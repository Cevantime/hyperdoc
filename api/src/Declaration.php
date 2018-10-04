<?php

namespace App;

use App\Controller\HomeController;
use App\Declarations\DoctrineBehaviorsDeclaration;
use App\Entity\Product;
use App\Entity\Program;
use App\Entity\ProgramValue;
use Middlewares\ContentLanguage;
use Sherpa\App\App;
use Sherpa\Declaration\DeclarationInterface;
use Sherpa\Doctrine\DoctrineDeclarations;
use Sherpa\Rest\Declaration as RestDeclaration;

class Declaration implements DeclarationInterface
{

    public function register(App $app)
    {

        /* connect a module by simply requiring the module declaration php file */

        $app->addDeclaration(DoctrineDeclarations::class);
        $app->addDeclaration(RestDeclaration::class);
        $app->addDeclaration(DoctrineBehaviorsDeclaration::class);

        $app->add((new ContentLanguage(['en', 'fr']))->usePath(true), 200);

        /* declare middlewares in delayed function : */

        //$app->delayed(function($app) {
        //    // declare middlewares here
        //
        //    $app->add(new MyAwesomeMiddleware(), 75);
        //});


        /* use aura router to declare routes : see https://github.com/auraphp/aura.router */

        $map = $app->getRouterMap();
        $map->crud(Program::class, null, '', '/{locale}');
        $map->crud(ProgramValue::class);

        $map->getRoute('program.item')->tokens(['id' => '[a-z0-9\-]+']);
        $map->removeRoute('program_value.create');

    }

}
