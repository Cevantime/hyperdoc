<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 12:13
 */

namespace App\Declarations;


use App\Controller\OAuthController;
use App\Entity\AuthCode;
use App\Repository\AccessTokenRepository;
use App\Repository\AuthCodeRepository;
use App\Repository\ClientRepository;
use App\Repository\RefreshTokenRepository;
use App\Repository\ScopeRepository;
use Aura\Router\Map;
use Defuse\Crypto\Key;
use DI\ContainerBuilder;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Sherpa\App\App;
use Sherpa\Declaration\Declaration;

use function DI\create;
use function DI\get;

class OAuthDeclaration extends Declaration
{
    public function declarations(App $app)
    {
        $privateKey = file_get_contents($app->get('projectDir') . '/private.key');
        $encryptionKey = Key::loadFromAsciiSafeString(file_get_contents($app->get('projectDir') . '/diffuse.key'));

        $builder = $app->getContainerBuilder();

        $builder->addDefinitions([
            AuthorizationServer::class => create()->constructor(
                get(ClientRepository::class),
                get(AccessTokenRepository::class),
                get(ScopeRepository::class),
                $privateKey,
                $encryptionKey
            ),
            AuthCodeGrant::class => create()->constructor(
                get(AuthCodeRepository::class),
                get(RefreshTokenRepository::class),
                new \DateInterval('PT10M')
            )
        ]);
    }

    public function routes(Map $map)
    {
        $map->get('/authorize', OAuthController::class . '::authorize');
        $map->get('/access-token', OAuthController::class . '::accessToken');
    }

    public function delayed(App $app)
    {
        $server = $app->get(AuthorizationServer::class);
        $server->enableGrantType($app->get(AuthCodeGrant::class), new \DateInterval('PT1H'));
    }
}