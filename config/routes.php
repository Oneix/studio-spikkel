<?php
declare(strict_types=1);

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->prefix('Admin', ['path' => '/beheer'], static function (RouteBuilder $admin): void {
        $admin->connect('/', ['controller' => 'Dashboard', 'action' => 'index'], [
            '_name' => 'beheer',
        ])->setMethods(['GET', 'HEAD']);
        foreach (['producten' => 'Products', 'nieuws' => 'News'] as $section => $controller) {
            $admin->connect('/' . $section, ['controller' => $controller, 'action' => 'index'], [
                '_name' => 'beheer-' . $section,
            ])->setMethods(['GET', 'HEAD']);
            $admin->connect('/' . $section . '/nieuw', ['controller' => $controller, 'action' => 'edit'], [
                '_name' => 'beheer-' . $section . '-nieuw',
            ])->setMethods(['GET', 'HEAD', 'POST']);
            $admin->connect('/' . $section . '/{id}', ['controller' => $controller, 'action' => 'edit'], [
                '_name' => 'beheer-' . $section . '-bewerken',
            ])->setPass(['id'])->setPatterns(['id' => '[1-9][0-9]{0,9}'])->setMethods(['GET', 'HEAD', 'POST']);
        }
        foreach (['bestellingen' => 'Orders', 'contact' => 'ContactMessages', 'samenwerking' => 'Collaborations'] as $section => $controller) {
            $admin->connect('/' . $section, ['controller' => $controller, 'action' => 'index'], [
                '_name' => 'beheer-' . $section,
            ])->setMethods(['GET', 'HEAD']);
            $admin->connect('/' . $section . '/{id}', ['controller' => $controller, 'action' => 'view'], [
                '_name' => 'beheer-' . $section . '-bekijken',
            ])->setPass(['id'])->setPatterns(['id' => '[1-9][0-9]{0,9}'])->setMethods(['GET', 'HEAD']);
        }
        $admin->connect('/samenwerking/{id}/bijlage', ['controller' => 'Collaborations', 'action' => 'download'], [
            '_name' => 'beheer-bijlage',
        ])->setPass(['id'])->setPatterns(['id' => '[1-9][0-9]{0,9}'])->setMethods(['GET', 'HEAD']);
    });

    $routes->scope('/', static function (RouteBuilder $builder): void {
        $pages = [
            '/' => 'home',
            '/over-studio-spikkel' => 'over',
            '/team' => 'team',
            '/veelgestelde-vragen' => 'vragen',
        ];

        foreach ($pages as $path => $page) {
            $builder->connect(
                $path,
                ['controller' => 'Pages', 'action' => 'display', 'shopPage' => $page, $page],
                ['_name' => $page],
            )->setMethods(['GET', 'HEAD']);
        }

        foreach (['contact' => 'contact', 'samenwerken' => 'collaborate'] as $page => $action) {
            $builder->connect(
                '/' . $page,
                ['controller' => 'Enquiries', 'action' => $action, 'shopPage' => $page],
                ['_name' => $page],
            )->setMethods(['GET', 'HEAD', 'POST']);
        }

        $builder->connect('/account', ['controller' => 'Accounts', 'action' => 'index', 'shopPage' => 'account'], [
            '_name' => 'account',
        ])->setMethods(['GET', 'HEAD']);
        foreach (['inloggen' => 'login', 'registreren' => 'register'] as $path => $action) {
            $builder->connect(
                '/' . $path,
                ['controller' => 'Accounts', 'action' => $action, 'shopPage' => 'account'],
                ['_name' => $path],
            )->setMethods(['GET', 'HEAD', 'POST']);
        }
        $builder->connect('/uitloggen', ['controller' => 'Accounts', 'action' => 'logout'], [
            '_name' => 'uitloggen',
        ])->setMethods(['POST']);

        $builder->connect('/winkelmand', ['controller' => 'Cart', 'action' => 'index', 'shopPage' => 'winkelmand'], [
            '_name' => 'winkelmand',
        ])->setMethods(['GET', 'HEAD']);
        $builder->connect('/afrekenen', ['controller' => 'Checkout', 'action' => 'index', 'shopPage' => 'winkelmand'], [
            '_name' => 'afrekenen',
        ])->setMethods(['GET', 'HEAD']);
        $builder->connect('/afrekenen/overzicht', ['controller' => 'Checkout', 'action' => 'review', 'shopPage' => 'winkelmand'], [
            '_name' => 'afrekenen-overzicht',
        ])->setMethods(['POST']);
        $builder->connect('/afrekenen/plaatsen', ['controller' => 'Checkout', 'action' => 'place', 'shopPage' => 'winkelmand'], [
            '_name' => 'afrekenen-plaatsen',
        ])->setMethods(['POST']);
        $builder->connect('/mijn-bestellingen', ['controller' => 'Orders', 'action' => 'index', 'shopPage' => 'account'], [
            '_name' => 'bestellingen',
        ])->setMethods(['GET', 'HEAD']);
        $builder->connect('/mijn-bestellingen/{number}', ['controller' => 'Orders', 'action' => 'view', 'shopPage' => 'account'], [
            '_name' => 'bestelling',
        ])->setPass(['number'])->setPatterns(['number' => 'SP-[A-F0-9]{12}'])->setMethods(['GET', 'HEAD']);
        foreach (['toevoegen' => 'add', 'aanpassen' => 'update', 'verwijderen' => 'remove'] as $path => $action) {
            $builder->connect('/winkelmand/' . $path . '/{id}', ['controller' => 'Cart', 'action' => $action], [
                '_name' => 'mandje-' . $path,
            ])->setPass(['id'])->setPatterns(['id' => '[1-9][0-9]{0,9}'])->setMethods(['POST']);
        }

        $builder->connect('/cadeaus/cadeaubon', ['controller' => 'Products', 'action' => 'giftCard', 'shopPage' => 'cadeaus'], [
            '_name' => 'cadeaubon',
        ])->setMethods(['GET', 'HEAD']);
        foreach (['cadeaus' => 'Products', 'nieuws' => 'News'] as $page => $controller) {
            $builder->connect(
                '/' . $page,
                ['controller' => $controller, 'action' => 'index', 'shopPage' => $page],
                ['_name' => $page],
            )->setMethods(['GET', 'HEAD']);
            $builder->connect(
                '/' . $page . '/{slug}',
                ['controller' => $controller, 'action' => 'view', 'shopPage' => $page],
                ['_name' => $page . '-detail'],
            )->setPass(['slug'])->setPatterns(['slug' => '[a-z0-9]+(?:-[a-z0-9]+)*'])->setMethods(['GET', 'HEAD']);
        }
    });
};
