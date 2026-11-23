<?php
declare(strict_types=1);

namespace App\Controller;

use App\Store\Cart;
use Cake\Http\Response;

class CartController extends AppController
{
    /**
     * Read the guest or signed-in cart against the current catalog.
     */
    public function index(): void
    {
        $this->set('cart', $this->cart()->summary());
    }

    /**
     * Add a quantity of a currently available product.
     */
    public function add(string $id): Response
    {
        $product = $this->fetchTable('Products')->find('available')->where(['id' => $id])->firstOrFail();
        $cart = $this->cart();
        $existing = $cart->quantities()[$product->id] ?? 0;
        $quantity = $this->postedQuantity();
        if ($quantity === null || $existing + $quantity > Cart::MAX_QUANTITY) {
            $this->quantityError();

            $target = $product->is_digital
                ? ['_name' => 'cadeaubon']
                : ['_name' => 'cadeaus-detail', 'slug' => $product->slug];

            return $this->redirect($target, 303);
        }
        $cart->setQuantity($product->id, $existing + $quantity);
        $this->Flash->success('Toegevoegd aan je winkelmand.', ['key' => 'cart']);

        return $this->redirect(['_name' => 'winkelmand'], 303);
    }

    /**
     * Change the amount of a product already in the cart.
     */
    public function update(string $id): Response
    {
        $cart = $this->cart();
        $quantity = $this->postedQuantity();
        if ($quantity === null) {
            $this->quantityError();
        } elseif (isset($cart->quantities()[(int)$id])) {
            $cart->setQuantity((int)$id, $quantity);
            $this->Flash->success('Aantal aangepast.', ['key' => 'cart']);
        }

        return $this->redirect(['_name' => 'winkelmand'], 303);
    }

    /**
     * Remove a product from the current session's cart.
     */
    public function remove(string $id): Response
    {
        $cart = $this->cart();
        if (isset($cart->quantities()[(int)$id])) {
            $cart->setQuantity((int)$id, 0);
            $this->Flash->success('Cadeau uit je winkelmand gehaald.', ['key' => 'cart']);
        }

        return $this->redirect(['_name' => 'winkelmand'], 303);
    }

    /**
     * Read only whole quantities within the supported range.
     */
    private function postedQuantity(): ?int
    {
        $value = $this->request->getData('quantity');
        $options = ['options' => ['min_range' => 1, 'max_range' => Cart::MAX_QUANTITY]];
        $quantity = is_string($value) || is_int($value) ? filter_var($value, FILTER_VALIDATE_INT, $options) : false;

        return $quantity === false ? null : $quantity;
    }

    /**
     * Use the same shopping cart for all requests from this session.
     */
    private function cart(): Cart
    {
        return new Cart($this->request->getSession(), $this->fetchTable('Products'));
    }

    /**
     * Explain the range whenever a posted quantity cannot be accepted.
     */
    private function quantityError(): void
    {
        $this->Flash->error('Je kunt 1 tot 99 stuks per cadeau kiezen.', ['key' => 'cart']);
    }
}
