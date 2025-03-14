<?php

namespace App\Middleware;

use Cake\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Core\Configure;

class ApiKeyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $apiKey = $request->getHeaderLine('X-Api-Key');
        $validApiKey = Configure::read('ApiKey');

        // Verifique a chave API
        if ($apiKey !== $validApiKey) {
            throw new UnauthorizedException('Chave API inválida.');
        }

        return $handler->handle($request);
    }
}
