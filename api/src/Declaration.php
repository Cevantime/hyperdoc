<?php

namespace App;

use App\Controller\HomeController;
use App\Debug\DoctrineLogger;
use App\Declarations\DoctrineDeclaration;
use App\Entity\Product;
use App\Entity\Program;
use App\Entity\ProgramValue;
use App\Middleware\DebugMiddleware;
use Aura\Router\Map;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\ORM\EntityManagerInterface;
use Middlewares\ContentLanguage;
use PHPUnit\Util\Json;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sherpa\App\App;
use Sherpa\Declaration\CacheRouteDeclaration;
use Sherpa\Declaration\DeclarationInterface;
use Sherpa\Doctrine\DoctrineDeclarations;
use Sherpa\Rest\Declaration as RestDeclaration;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Stream;

class Declaration extends \Sherpa\Declaration\Declaration
{

    public function declarations(App $app)
    {
        $app->addDeclaration(DoctrineDeclarations::class);
        $app->addDeclaration(RestDeclaration::class);
        $app->addDeclaration(DoctrineDeclaration::class);
        if( ! $app->isDebug()) {
            $app->addDeclaration(CacheRouteDeclaration::class);
        }
    }

    public function delayed(App $app)
    {
        $app->add((new ContentLanguage(['en', 'fr']))->usePath(true), 200);
        if ($app->isDebug()) {
            $app->add(new DebugMiddleware($app->get(EntityManagerInterface::class)));
        }
    }

    public function routes(Map $map)
    {
        $map->crud(Program::class, function ($map) {
            $map->getRoute('item')->tokens(['id' => '[a-z0-9\-]+']);
            $map->getRoute('delete')->tokens(['id' => '[a-z0-9\-]+']);
        }, '', '/{locale}');

        $map->crud(ProgramValue::class, function ($map) {
            $map->removeRoute('create');
        });
    }

}
