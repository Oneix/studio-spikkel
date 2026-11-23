<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class StorefrontTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Products', 'app.NewsPosts'];

    /**
     * A product hidden from the catalog is also hidden at its direct URL.
     */
    public function testInactiveProductIsPrivate(): void
    {
        $this->get('/cadeaus');
        $this->assertResponseOk();
        $this->assertResponseContains('Bloemenboekje');
        $this->assertResponseNotContains('Verborgen kaars');
        $this->get('/cadeaus/notitieboekje');
        $this->assertResponseOk();
        $this->assertResponseContains('12,95');
        $this->get('/cadeaus/verborgen-kaars');
        $this->assertResponseCode(404);
    }

    /**
     * Draft and scheduled news cannot be found through index or detail routes.
     */
    public function testNewsPublicationDate(): void
    {
        $this->get('/nieuws');
        $this->assertResponseOk();
        $this->assertResponseContains('Onze nieuwe collectie is binnen!');
        $this->assertResponseNotContains('Afgeschermd concept');
        $this->assertResponseNotContains('Later bericht');
        $this->get('/nieuws/nieuwe-collectie');
        $this->assertResponseOk();
        $this->assertResponseContains('datetime="2020-03-13"');
        $this->get('/nieuws/afgeschermd-concept');
        $this->assertResponseCode(404);
        $this->get('/nieuws/later-bericht');
        $this->assertResponseCode(404);
    }
}
