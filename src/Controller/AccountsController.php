<?php
declare(strict_types=1);

namespace App\Controller;

use App\Store\CheckoutQuote;
use Cake\Database\Exception\QueryException;
use Cake\Http\Response;

class AccountsController extends AppController
{
    /**
     * Load the plugin component for logout. The actions decide when a login is required.
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication', ['requireIdentity' => false]);
    }

    /**
     * Show only the account belonging to the signed-in customer.
     */
    public function index(): ?Response
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            return $this->redirect(['_name' => 'inloggen']);
        }
        $this->set(compact('identity'));

        return null;
    }

    /**
     * Sign in and return to the account or the checkout.
     */
    public function login(): ?Response
    {
        $next = $this->nextPage();
        if ($this->request->getAttribute('identity') !== null) {
            return $this->redirect(['_name' => $next], 303);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Dit e-mailadres en wachtwoord komen niet overeen.', ['key' => 'account']);
            $this->response = $this->response->withStatus(422);
        }
        $this->set(compact('next'));

        return null;
    }

    /**
     * Create a customer account and retain the original checkout destination.
     */
    public function register(): ?Response
    {
        $next = $this->nextPage();
        if ($next === 'beheer') {
            $next = 'account';
        }
        if ($this->request->getAttribute('identity') !== null) {
            return $this->redirect(['_name' => $next], 303);
        }
        $users = $this->fetchTable('Users');
        $form = $users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (is_string($data['name'] ?? null)) {
                $data['name'] = trim($data['name']);
            }
            if (is_string($data['email'] ?? null)) {
                $data['email'] = mb_strtolower(trim($data['email']));
            }
            $form = $users->newEntity($data, ['fields' => ['name', 'email', 'password'], 'associated' => []]);
            try {
                if ($users->save($form)) {
                    $this->Flash->success('Je account is aangemaakt. Je kunt nu inloggen.', ['key' => 'account']);

                    return $this->redirect(['_name' => 'inloggen', '?' => ['verder' => $next]], 303);
                }
            } catch (QueryException $exception) {
                $constraintFailed = (string)$exception->getPrevious()?->getCode() === '23000';
                if (!$constraintFailed || !$users->exists(['email' => $form->email])) {
                    throw $exception;
                }
                $form->setError('email', ['Dit e-mailadres is al in gebruik.']);
            }
            $this->response = $this->response->withStatus(422);
        }
        $this->set(compact('form', 'next'));

        return null;
    }

    /**
     * Sign out without discarding the device's shopping cart.
     */
    public function logout(): Response
    {
        $this->Authentication->logout();
        $this->request->getSession()->delete(CheckoutQuote::SESSION_KEY);
        $this->Flash->success('Je bent uitgelogd.', ['key' => 'account']);

        return $this->redirect(['_name' => 'inloggen'], 303);
    }

    /**
     * Continue to a known internal route only.
     */
    private function nextPage(): string
    {
        $target = $this->request->getQuery('verder');

        return in_array($target, ['afrekenen', 'bestellingen', 'beheer'], true) ? $target : 'account';
    }
}
