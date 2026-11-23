<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Response;
use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AdminAccessMiddleware implements MiddlewareInterface
{
    /**
     * Check the current account on every admin request, including attachment downloads.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (($request->getAttribute('params')['prefix'] ?? null) !== 'Admin') {
            return $handler->handle($request);
        }

        $identity = $request->getAttribute('identity');
        if ($identity === null) {
            return (new Response(['status' => 303]))
                ->withHeader('Location', Router::url(['_name' => 'inloggen', '?' => ['verder' => 'beheer']]))
                ->withHeader('Cache-Control', 'private, no-store');
        }
        if ($identity->get('is_admin') !== true) {
            throw new ForbiddenException('Deze pagina is alleen beschikbaar voor beheerders.');
        }

        return $handler->handle($request)->withHeader('Cache-Control', 'private, no-store');
    }
}
