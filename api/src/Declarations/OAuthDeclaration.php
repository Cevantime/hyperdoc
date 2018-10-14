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
use App\Repository\RefreshTokenRepository;
use Aura\Router\Map;
use Defuse\Crypto\Key;
use DI\ContainerBuilder;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Sherpa\App\App;
use Sherpa\Declaration\Declaration;

use function DI\create;

class OAuthDeclaration extends Declaration
{
    public function definitions(ContainerBuilder $builder)
    {
        $privateKey = file_get_contents($builder->get('projectDir') . '/private.key');
        $encryptionKey = Key::loadFromAsciiSafeString(file_get_contents($builder->get('projectDir') . '/diffuse.key'));

        $builder->addDefinitions([
            AuthorizationServer::class => create()->constructor(
                ClientRepositoryInterface::class,
                AccessTokenRepositoryInterface::class,
                ScopeRepositoryInterface::class,
                $privateKey,
                $encryptionKey
            ),
            AuthCodeGrant::class => create()->constructor(
                AuthCodeRepositoryInterface::class,
                RefreshTokenRepository::class,
                new \DateInterval('PT10M')
            )
        ]);
    }

    public function routes(Map $map)
    {
        $map->get('/authorize', OAuthController::class . '::authorize');
    }

    public function delayed(App $app)
    {
        $server = $app->get(AuthorizationServer::class);
        $server->enableGrantType($app->get(AuthCodeGrant::class), new \DateInterval('PT1H'));
    }
}