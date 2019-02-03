<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 23/09/18
 * Time: 00:32
 */

namespace App\Declarations;


use App\Generator\FullCodeGenerator;
use App\Subscriber\FullCodeSubscriber;
use App\Subscriber\ResolveAccessTokenOwnerSubscriber;
use App\Subscriber\SnakifyClassnamesSubscriber;
use DI\Container;
use DI\ContainerBuilder;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber;
use Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriber;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;
use Middlewares\ContentLanguage;
use Sherpa\App\App;
use Sherpa\Declaration\Declaration;
use Sherpa\Declaration\DeclarationInterface;

class DoctrineDeclaration extends Declaration
{
    public function delayed(App $app)
    {
        $doctrineConfig = $app->get('doctrine.config');
        $doctrineConfig->setNamingStrategy(new UnderscoreNamingStrategy(CASE_LOWER));

        $em = $app->get(EntityManagerInterface::class);
        $ev = $em->getEventManager();

        /** @var EventManager $ev */
        $classAnalyzer = new ClassAnalyzer();

        $ev->addEventSubscriber(new TranslatableSubscriber(
            $classAnalyzer,
            new CurrentLocaleCallable($app->getContainer()),
            function() {return 'en';},
            'Knp\DoctrineBehaviors\Model\Translatable\Translatable',
            'Knp\DoctrineBehaviors\Model\Translatable\Translation',
            'LAZY',
            'LAZY'
        ));

        $ev->addEventSubscriber(new SluggableSubscriber(
            $classAnalyzer,
            true,
            "Knp\DoctrineBehaviors\Model\Sluggable\Sluggable"
        ));

        $ev->addEventSubscriber(new TimestampableSubscriber(
            $classAnalyzer,
            true,
            'Knp\DoctrineBehaviors\Model\Timestampable\Timestampable',
            'datetime'
        ));

        $ev->addEventSubscriber($app->get(ResolveAccessTokenOwnerSubscriber::class));
    }
}