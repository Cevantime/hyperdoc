<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 12:13
 */

namespace App\Declarations;


use App\Controller\OAuthController;
use App\Middleware\AuthenticationMiddleware;
use App\Repository\AccessTokenRepository;
use App\Repository\AuthCodeRepository;
use App\Repository\ClientRepository;
use App\Repository\RefreshTokenRepository;
use App\Repository\ScopeRepository;
use Defuse\Crypto\Key;
use DI\ContainerBuilder;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\AuthorizationValidators\BearerTokenValidator;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;
use Psr\Container\ContainerInterface;
use Sherpa\App\App;
use Sherpa\Declaration\Declaration;

use function DI\create;
use function DI\get;
use Sherpa\Routing\Map;

class OAuthDeclaration extends Declaration
{
    public function definitions(ContainerBuilder $builder)
    {
        $builder->addDefinitions([
            'oauth.private_key' => function (ContainerInterface $container) {
                return file_get_contents($container->get('project.root') . '/private.key');
            },
            'oauth.public_key' => function (ContainerInterface $container) {
                return file_get_contents($container->get('project.root') . '/public.key');
            },
            'oauth.encryption_key' => function (ContainerInterface $container) {
                return Key::loadFromAsciiSafeString(file_get_contents($container->get('project.root') . '/diffuse.key'));
            },
            'oauth.access_token.lifetime' => function () {
                return new \DateInterval('PT1H');
            },
            'oauth.auth_code.lifetime' => function () {
                return new \DateInterval('PT10M');
            },
            'oauth.refresh_token.lifetime' => function () {
                return new \DateInterval('P1M');
            },
            ResourceServer::class => create()->constructor(get(AccessTokenRepository::class), get('oauth.public_key')),
            AuthorizationServer::class => create()->constructor(
                get(ClientRepository::class),
                get(AccessTokenRepository::class),
                get(ScopeRepository::class),
                get('oauth.private_key'),
                get('oauth.encryption_key')
            )
                ->method('enableGrantType', get(AuthCodeGrant::class), get('oauth.access_token.lifetime'))
                ->method('enableGrantType', get(RefreshTokenGrant::class), get('oauth.access_token.lifetime')),
            AuthCodeGrant::class => create()->constructor(
                get(AuthCodeRepository::class),
                get(RefreshTokenRepository::class),
                get('oauth.auth_code.lifetime')
            )
                ->method('setRefreshTokenTTL', get('oauth.refresh_token.lifetime')),
            RefreshTokenGrant::class => create()->constructor(
                get(RefreshTokenRepository::class)
            )
                ->method('setRefreshTokenTTL', get('oauth.refresh_token.lifetime'))
        ]);
    }

    public function routes(Map $map)
    {
        $map->get('authorize', '/authorize', OAuthController::class . '::authorize');
        $map->post('access_token', '/access-token', OAuthController::class . '::accessToken');
        $map->route('login', '/login', OAuthController::class . '::login')->allows(['GET', 'POST']);
        $map->route('register', '/register', OAuthController::class . '::register')->allows(['GET', 'POST']);
    }
}