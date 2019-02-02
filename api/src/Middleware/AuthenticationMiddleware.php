<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 27/10/18
 * Time: 17:15
 */

namespace App\Middleware;


use App\Repository\AccessTokenRepository;
use App\Repository\UserRepository;
use Aura\Router\Exception;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\AuthorizationValidators\BearerTokenValidator;
use League\OAuth2\Server\ResourceServer;
use Middlewares\Utils\Traits\HasResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * @var ResourceServer
     */
    private $resourceServer;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthenticationMiddleware constructor.
     * @param ResourceServer $resourceServer
     * @param AccessTokenRepository $tokenRepository
     */
    public function __construct(ResourceServer $resourceServer, UserRepository $tokenRepository)
    {
        $this->resourceServer = $resourceServer;
        $this->userRepository = $tokenRepository;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->resourceServer->validateAuthenticatedRequest($request);
        $user = $this->userRepository->find($request->getAttribute('oauth_user_id'));
        return $handler->handle($request->withAttribute('user', $user));
    }
}