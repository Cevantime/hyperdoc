<?php

namespace App;

use App\Controller\HomeController;
use Sherpa\App\App;
use Sherpa\Declaration\DeclarationInterface;
use Sherpa\Doctrine\DoctrineDeclarations;

class Declarations implements DeclarationInterface
{

    public function register(App $app)
    {

        /* connect a module by simply requiring the module declaration php file */

        $app->addDeclaration(DoctrineDeclarations::class);

        /* declare middlewares in delayed function : */

        //$app->delayed(function($app) {
        //    // declare middlewares here
        //
        //    $app->add(new MyAwesomeMiddleware(), 75);
        //});


        /* use aura router to declare routes : see https://github.com/auraphp/aura.router */

        $map = $app->getRouterMap();

        $map->get('home', '/', HomeController::class . '::home');

        //
        //$map->get('hello', '/hello/{name}', function($name){
        //    return new HtmlResponse("Hello, $name !");
        //});

        /* use di container to declare dependencies to inject. See http://php-di.org */

        $builder = $app->getContainerBuilder();

        $builder->addDefinitions([
            'doctrine.connection' => [
                'driver' => 'pdo_mysql',
                'user' => 'root',
                'password' => 'pastor5456',
                'dbname' => 'hyperdoc',
            ]
        ]);
    }

}
