<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Application;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class EnquiriesTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.ContactMessages', 'app.CollaborationRequests'];

    /**
     * Contact submissions require a CSRF token and valid contact details.
     */
    public function testContactSubmissions(): void
    {
        $message = ['name' => 'Mo Test', 'email' => 'mo@example.test', 'message' => 'Een normale vraag.'];
        $messages = $this->getTableLocator()->get('ContactMessages');

        $this->post('/contact', $message);
        $this->assertResponseCode(403);
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $this->post('/contact', ['email' => 'ongeldig', 'message' => '    ', 'name' => 'Mo Test']);
        $this->assertResponseCode(422);
        $this->assertResponseContains('Vul een geldig e-mailadres in.');
        $this->assertResponseContains('Schrijf een bericht.');
        $this->assertSame(0, $messages->find()->count());

        $this->post('/contact', $message + ['id' => 999]);
        $this->assertResponseCode(303);
        $this->assertRedirectContains('/contact#contactformulier');
        $saved = $messages->find()->firstOrFail();
        $this->assertSame('Een normale vraag.', $saved->message);
        $this->assertNotSame(999, $saved->id);
    }

    /**
     * Collaboration requests allow optional fields to be blank and ignore supplied attachment paths.
     */
    public function testCollaborationSubmissions(): void
    {
        $this->enableCsrfToken(Application::CSRF_COOKIE);
        $payload = ['name' => 'Mo Test', 'email' => 'mo@example.test', 'idea' => 'Ansichtkaarten', 'category' => 'posters'];
        $requests = $this->getTableLocator()->get('CollaborationRequests');
        $invalid = ['category' => 'onbekend', 'website' => 'mailto:mo@example.test', 'preferred_date' => '2026-02-30'];
        $this->post('/samenwerken', $invalid + $payload);
        $this->assertResponseCode(422);
        $this->assertResponseContains('Kies een categorie.');
        $this->assertResponseContains('Vul een geldige datum in.');
        $this->assertSame(0, $requests->find()->count());

        $this->post('/samenwerken', $payload + ['attachment_key' => 'an-untrusted-path']);
        $this->assertResponseCode(303);
        $this->assertRedirectContains('/samenwerken#aanvraag');
        $saved = $requests->find()->firstOrFail();
        $this->assertSame('posters', $saved->category);
        $this->assertFalse($saved->keep_in_touch);
        $this->assertNull($saved->attachment_key);
    }
}
