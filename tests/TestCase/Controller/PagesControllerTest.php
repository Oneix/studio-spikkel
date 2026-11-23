<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * The shop's navigation should work while the catalog and order features are under construction.
     */
    public function testShopNavigationLoadsPublicPages(): void
    {
        $pages = [
            '/' => 'Kleine cadeaus.',
            '/over-studio-spikkel' => 'Over Studio Spikkel',
            '/cadeaus' => 'Cadeaus',
            '/nieuws' => 'Nieuws',
            '/team' => 'Team',
            '/contact' => 'Contact',
            '/veelgestelde-vragen' => 'Veelgestelde vragen',
            '/samenwerken' => 'Samenwerken',
            '/winkelmand' => 'Winkelmand',
            '/inloggen' => 'Inloggen',
            '/registreren' => 'Account maken',
        ];

        foreach ($pages as $path => $title) {
            $this->get($path);
            $this->assertResponseOk();
            $this->assertResponseContains('<html lang="nl">');
            $this->assertResponseContains($title);
            $this->assertResponseContains('aria-current="page"');
        }
    }

    /**
     * Unlisted paths do not expose the CakePHP starter templates.
     */
    public function testUnknownPageReturns404(): void
    {
        $debug = Configure::read('debug');
        Configure::write('debug', false);
        try {
            $this->get('/pages/home');
            $this->assertResponseCode(404);
            $this->assertResponseContains('Pagina niet gevonden');
        } finally {
            Configure::write('debug', $debug);
        }
    }
}
