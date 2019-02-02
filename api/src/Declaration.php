<?php

namespace App;

use App\Declarations\DoctrineDeclaration;
use App\Declarations\OAuthDeclaration;
use App\Entity\Content;
use App\Middleware\AllowCrossOriginMiddleware;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\DebugMiddleware;
use function DI\autowire;
use DI\ContainerBuilder;
use Elastica\Client;
use Middlewares\ContentLanguage;
use Sherpa\App\App;
use Sherpa\Declaration\CacheRouteDeclaration;
use Sherpa\Doctrine\DoctrineDeclarations;
use Sherpa\Plates\Declarations;
use Sherpa\Rest\Declaration as RestDeclaration;
use function DI\get;
use function DI\create;
use Sherpa\Rest\Middleware\AddDoctrineAdapter;
use Sherpa\Routing\Map;
use Zend\Diactoros\Response;

class Declaration extends \Sherpa\Declaration\Declaration
{
    public function custom(App $app)
    {
        $app->addDeclaration(DoctrineDeclarations::class);
        $app->addDeclaration(RestDeclaration::class);
        $app->addDeclaration(\Sherpa\Rest\Declarations\DoctrineDeclarations::class);
        $app->addDeclaration(Declarations::class);
        $app->addDeclaration(DoctrineDeclaration::class);
        $app->addDeclaration(OAuthDeclaration::class);

        if( ! $app->isDebug()) {
            $app->addDeclaration(CacheRouteDeclaration::class);
        }

        $app->pipe(ContentLanguage::class, 200);
        $app->pipe(AllowCrossOriginMiddleware::class, 500);

        if ($app->isDebug()) {
            $app->pipe(DebugMiddleware::class, 100);
        }
    }

    public function routes(Map $map)
    {
        $map->get('home','/', function(){
            return new Response\HtmlResponse("Hello world !!");
        });
        $map->tokens(['id' => '[a-z0-9\-]+','token'=>['.+']]);
        $map->pipe(AuthenticationMiddleware::class);
        $map->attach('api.', '/api', ApiRoutes::class.'::init');
        $map->unpipe();
    }

    public function definitions(ContainerBuilder $builder)
    {
        $builder->addDefinitions([
            'locales' => ['en', 'fr'],
            ContentLanguage::class => autowire()->constructor(get('locales'))->method('usePath', true),
            'elasticsearch.config' => [
                'host' => 'localhost',
                'port' => '9200'
            ],
            Client::class => autowire()->constructor(get('elasticsearch.config'))
        ]);
    }

}
