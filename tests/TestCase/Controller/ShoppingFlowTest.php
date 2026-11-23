<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Application;
use App\Store\Cart;
use App\Store\CheckoutQuote;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

class ShoppingFlowTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Products', 'app.Users'];

    /**
     * Registration verifies both password fields and stores a hash for a normalized, unique email.
     */
    public function testRegisterFromCheckout(): void
    {
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->session(['Cart' => ['items' => [1 => 1]]]);
        $data = ['name' => 'Alex Test', 'email' => ' ALEX@example.test ', 'password' => 'SecretPass123!'];
        $this->post('/registreren?verder=afrekenen', $data + ['password_confirm' => 'different']);
        $this->assertResponseCode(422);
        $this->assertResponseContains('De wachtwoorden komen niet overeen.');
        $this->assertResponseNotContains('SecretPass123!');

        $this->post('/registreren?verder=afrekenen', $data + ['password_confirm' => $data['password'], 'id' => 999]);
        $this->assertResponseCode(303);
        $this->assertRedirectContains('/inloggen?verder=afrekenen');
        $user = $this->getTableLocator()->get('Users')->find()->where(['email' => 'alex@example.test'])->firstOrFail();
        $this->assertTrue(password_verify($data['password'], $user->password));
        $this->assertNotSame(999, $user->id);
        $this->assertSession([1 => 1], Cart::SESSION_KEY);

        $this->post('/registreren', $data + ['password_confirm' => $data['password']]);
        $this->assertResponseCode(422);
        $this->assertResponseContains('Dit e-mailadres is al in gebruik.');
    }

    /**
     * Login only returns to the two supported shop destinations.
     */
    public function testLoginRedirectCannotLeaveShop(): void
    {
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->post('/inloggen?verder=https%3A%2F%2Fexample.test', [
            'email' => 'mo@example.test', 'password' => 'SecretPass123!',
        ]);
        $this->assertResponseCode(303);
        $this->assertRedirectContains('/account');
        $this->assertSession(1, 'Auth');
    }

    /**
     * Checkout refuses guest access even when visited directly and uses catalog prices when signed in.
     */
    public function testCheckoutGateAndPrices(): void
    {
        $this->session(['Cart' => ['items' => [1 => 2, 2 => 1]]]);
        $this->get('/afrekenen');
        $this->assertRedirectContains('/inloggen?verder=afrekenen');

        $this->session(['Auth' => 1]);
        $this->get('/afrekenen');
        $this->assertResponseOk();
        $this->assertResponseContains('25,90');
        $this->assertResponseNotContains('Verborgen kaars');
        $this->assertSession([1 => 2], Cart::SESSION_KEY);
    }

    /**
     * Ask for another confirmation if a catalog price changes after review.
     */
    public function testChangedCatalogPriceRequiresAnotherReview(): void
    {
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->session(['Auth' => 1, 'Cart' => ['items' => [1 => 2]]]);
        $this->post('/afrekenen/overzicht', ['delivery_method' => 'pickup']);
        $this->assertResponseOk();
        $this->assertResponseContains('25,90');
        $review = Hash::get($_SESSION, CheckoutQuote::SESSION_KEY);
        $this->assertIsArray($review);
        $this->session(['Checkout' => ['review' => $review]]);

        $products = $this->getTableLocator()->get('Products');
        $connection = $products->getConnection();
        $connection->begin();
        try {
            $products->updateAll(['price_cents' => 1500], ['id' => 1]);
            $this->post('/afrekenen/plaatsen', ['token' => $review['token']]);
            $this->assertResponseCode(409);
            $this->assertResponseContains('Controleer het nieuwe overzicht.');
            $this->assertResponseContains('30,00');
            $this->assertSession([1 => 2], Cart::SESSION_KEY);
            $this->assertResponseNotContains($review['token']);
        } finally {
            $connection->rollback();
        }
    }

    /**
     * Guests can add a gift only through a protected POST with a sensible quantity.
     */
    public function testCartQuantityAndCsrf(): void
    {
        $this->post('/winkelmand/toevoegen/1', ['quantity' => 1]);
        $this->assertResponseCode(403);
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->post('/winkelmand/toevoegen/1', ['quantity' => 100]);
        $this->assertResponseCode(303);
        $this->assertRedirectContains('/cadeaus/notitieboekje');
        $this->assertSessionNotHasKey(Cart::SESSION_KEY);
        $this->post('/winkelmand/toevoegen/1', ['quantity' => 2, 'price_cents' => 1]);
        $this->assertResponseCode(303);
        $this->assertSession([1 => 2], Cart::SESSION_KEY);
    }
}
