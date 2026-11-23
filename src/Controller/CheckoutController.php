<?php
declare(strict_types=1);

namespace App\Controller;

use App\Store\Cart;
use App\Store\CheckoutQuote;
use App\Store\OrderWriter;
use Cake\Core\Configure;
use Cake\Database\Exception\QueryException;
use Cake\Form\Form;
use Cake\Http\Response;

class CheckoutController extends AppController
{
    /**
     * Show delivery and wrapping options for the signed-in customer's cart.
     */
    public function index(): ?Response
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            return $this->loginRequired();
        }
        $cart = $this->cart()->summary();
        if ($cart['items'] === []) {
            return $this->emptyCart();
        }
        $state = $this->sessionReview((int)$identity->getIdentifier());
        $defaults = [
            'delivery_method' => 'shipping',
            'shipping_country' => 'NL',
            'address_name' => $identity->get('name'),
        ];
        $this->showForm($cart, $state['quote']['input'] ?? $defaults);

        return null;
    }

    /**
     * Build a review with server prices. No order is written at this step.
     */
    public function review(): ?Response
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            return $this->loginRequired();
        }
        $cart = $this->cart()->summary();
        if ($cart['items'] === []) {
            return $this->emptyCart();
        }
        $quote = CheckoutQuote::build($this->request->getData(), $cart, Configure::read('Store.shipping'));
        if ($quote['errors'] !== []) {
            $this->request->getSession()->delete(CheckoutQuote::SESSION_KEY);
            $this->response = $this->response->withStatus(422);
            $this->showForm($cart, $quote['input'], $quote['errors']);

            return $this->render('index');
        }
        $this->showReview((int)$identity->getIdentifier(), $quote);

        return null;
    }

    /**
     * Place a reviewed demo order, or ask for a new review when the cart has changed.
     */
    public function place(): Response
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            return $this->loginRequired();
        }
        $userId = (int)$identity->getIdentifier();
        $token = $this->request->getData('token');
        if (!is_string($token) || !preg_match('/\A[0-9a-f]{64}\z/', $token)) {
            return $this->expiredReview();
        }
        $orders = $this->fetchTable('Orders');
        $alreadyPlaced = $orders->find('ownedBy', userId: $userId)->where(['checkout_token' => $token])->first();
        if ($alreadyPlaced !== null) {
            return $this->orderLink($alreadyPlaced->number);
        }
        $state = $this->sessionReview($userId);
        if ($state === null || !hash_equals($state['token'], $token)) {
            return $this->expiredReview();
        }

        $connection = $orders->getConnection();
        try {
            $result = $connection->transactional(function () use ($orders, $userId, $token, $state): array {
                $cart = $this->cart()->summary(lockProducts: true);
                $quote = CheckoutQuote::build($state['quote']['input'], $cart, Configure::read('Store.shipping'));
                if ($cart['items'] === [] || $quote['order'] !== $state['quote']['order']) {
                    return compact('cart', 'quote');
                }
                if ($quote['errors'] !== [] || $quote['items'] !== $state['quote']['items']) {
                    return compact('cart', 'quote');
                }

                return ['order' => OrderWriter::save($orders, $userId, $token, $quote)];
            });
        } catch (QueryException $exception) {
            $duplicate = $orders->find('ownedBy', userId: $userId)->where(['checkout_token' => $token])->first();
            if ($duplicate === null) {
                throw $exception;
            }

            return $this->orderLink($duplicate->number);
        }

        if (!isset($result['order'])) {
            return $this->changedReview($userId, $result['cart'], $result['quote']);
        }

        $session = $this->request->getSession();
        $session->delete(Cart::SESSION_KEY);
        $session->delete(CheckoutQuote::SESSION_KEY);
        $this->Flash->success('Bestelling geplaatst. Er is niets afgeschreven.', ['key' => 'order']);

        return $this->orderLink($result['order']->number);
    }

    /**
     * Ask for confirmation again after a change. If delivery options became invalid, return to the form.
     */
    private function changedReview(int $userId, array $cart, array $quote): Response
    {
        $this->request->getSession()->delete(CheckoutQuote::SESSION_KEY);
        if ($cart['items'] === []) {
            return $this->emptyCart();
        }
        $this->Flash->error('Je mandje of de verzendkosten zijn gewijzigd. Controleer het nieuwe overzicht.', [
            'key' => 'checkout',
        ]);
        $this->response = $this->response->withStatus(409);
        if ($quote['errors'] !== []) {
            $this->showForm($cart, $quote['input'], $quote['errors']);

            return $this->render('index');
        }
        $this->showReview($userId, $quote);

        return $this->render('review');
    }

    /**
     * Prepare the address form and reuse the FAQ's destination labels.
     */
    private function showForm(array $cart, array $input, array $errors = []): void
    {
        $shipping = Configure::read('Store.shipping');
        unset($shipping['pickup']);
        $countries = array_map(static fn(array $rate): string => $rate['label'], $shipping);
        $form = new Form();
        $form->setData($input)->setErrors($errors);
        $this->set(compact('cart', 'form', 'countries'));
    }

    /**
     * Keep the reviewed prices and address on the server, tied to this identity.
     */
    private function showReview(int $userId, array $quote): void
    {
        $token = bin2hex(random_bytes(32));
        $this->request->getSession()->write(CheckoutQuote::SESSION_KEY, [
            'userId' => $userId,
            'token' => $token,
            'quote' => $quote,
        ]);
        $this->set(compact('quote', 'token'));
    }

    /**
     * Read only the review attached to the signed-in account.
     */
    private function sessionReview(int $userId): ?array
    {
        $state = $this->request->getSession()->read(CheckoutQuote::SESSION_KEY);

        return ($state['userId'] ?? null) === $userId ? $state : null;
    }

    /**
     * Use the same cart session as the storefront.
     */
    private function cart(): Cart
    {
        return new Cart($this->request->getSession(), $this->fetchTable('Products'));
    }

    /**
     * Return to checkout after authentication.
     */
    private function loginRequired(): Response
    {
        return $this->redirect(['_name' => 'inloggen', '?' => ['verder' => 'afrekenen']]);
    }

    /**
     * Send an empty cart back to the shop.
     */
    private function emptyCart(): Response
    {
        $this->Flash->error('Kies eerst een cadeau voordat je gaat afrekenen.', ['key' => 'cart']);

        return $this->redirect(['_name' => 'winkelmand']);
    }

    /**
     * Never place an order without a valid review for this session.
     */
    private function expiredReview(): Response
    {
        $this->Flash->error('Controleer je gegevens en bekijk je bestelling opnieuw.', ['key' => 'checkout']);

        return $this->redirect(['_name' => 'afrekenen'], 303);
    }

    /**
     * Redirect after placing or replaying a previously placed demo order.
     */
    private function orderLink(string $number): Response
    {
        return $this->redirect(['_name' => 'bestelling', 'number' => $number], 303);
    }
}
