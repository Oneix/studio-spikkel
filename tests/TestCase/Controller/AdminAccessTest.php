<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Application;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class AdminAccessTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Users', 'app.Products'];

    /**
     * Every admin page and the private download require a current admin role.
     */
    public function testAdminRoutesAreGuarded(): void
    {
        $guardedPaths = [
            '/beheer',
            '/beheer/producten/nieuw',
            '/beheer/nieuws',
            '/beheer/bestellingen/1',
            '/beheer/contact/1',
            '/beheer/samenwerking/1',
            '/beheer/samenwerking/1/bijlage',
        ];
        foreach ($guardedPaths as $path) {
            $this->get($path);
            $this->assertResponseCode(303);
            $this->assertRedirectContains('/inloggen?verder=beheer');
        }
        $this->session(['Auth' => 1]);
        $this->get('/beheer');
        $this->assertResponseCode(403);
        $this->get('/beheer/samenwerking/1/bijlage');
        $this->assertResponseCode(403);
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->post('/beheer/producten/1', ['active' => '0']);
        $this->assertResponseCode(403);

        $users = $this->getTableLocator()->get('Users');
        $users->updateAll(['is_admin' => true], ['id' => 1]);
        $this->get('/beheer');
        $this->assertResponseOk();
        $this->assertResponseContains('Winkelbeheer');
        $this->assertHeader('Cache-Control', 'private, no-store');

        $users->updateAll(['is_admin' => false], ['id' => 1]);
        $this->get('/beheer');
        $this->assertResponseCode(403);
    }

    /**
     * The editor still requires a CSRF token for an administrator.
     */
    public function testAdminEditRequiresCsrf(): void
    {
        $this->getTableLocator()->get('Users')->updateAll(['is_admin' => true], ['id' => 1]);
        $this->session(['Auth' => 1]);
        $this->post('/beheer/producten/1', ['active' => '0']);
        $this->assertResponseCode(403);
        $this->assertTrue($this->getTableLocator()->get('Products')->get(1)->active);
    }

    /**
     * Registering with an extra role field still creates a customer.
     */
    public function testRegistrationCannotGrantAdmin(): void
    {
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->post('/registreren?verder=beheer', [
            'name' => 'Test Klant', 'email' => 'just-a-customer@example.test',
            'password' => 'A-test-password-42', 'password_confirm' => 'A-test-password-42', 'is_admin' => '1',
        ]);
        $this->assertResponseCode(303);
        $this->assertRedirectContains('/inloggen?verder=account');
        $account = $this->getTableLocator()->get('Users')->find()->where(['email' => 'just-a-customer@example.test'])
            ->firstOrFail();
        $this->assertFalse($account->is_admin);
    }
}
