<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 13/10/18
 * Time: 11:09
 */

namespace App\Middleware;


use GuzzleHttp\Psr7\Stream;
use League\OAuth2\Server\Exception\OAuthServerException;
use Middlewares\Utils\Traits\HasResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

class AllowCrossOriginMiddleware implements MiddlewareInterface
{
    use HasResponseFactory;

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'OPTIONS') {
            $response = new EmptyResponse(200);
        } else {
            try {
                $response = $handler->handle($request);
            } catch (OAuthServerException $ex) {
                $response = $this->createResponse(403, $ex->getMessage());
            }
        }
        return $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers',
                'X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding')
            ->withHeader('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
    }
}