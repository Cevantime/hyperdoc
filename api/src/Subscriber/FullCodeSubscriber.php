<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 12/10/18
 * Time: 19:38
 */

namespace App\Subscriber;


use App\Entity\Program;
use App\Generator\FullCodeGenerator;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Middlewares\HttpErrorException;

class FullCodeSubscriber implements EventSubscriber
{
    /**
     * @var FullCodeGenerator
     */
    protected $codeGenerator;

    /**
     * FullCodeSubscriber constructor.
     * @param FullCodeGenerator $codeGenerator
     * @param ObjectManager $manager
     */
    public function __construct(FullCodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postUpdate,
            Events::postPersist,
            Events::preRemove
        ];
    }

    public function postSave(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!($entity instanceof Program)) {
            return;
        }

        $wrappers = $entity->getWrappers();

        foreach ($wrappers as $wrapper) {
            $this->codeGenerator->generateFullCode($wrapper->getWrapperProgram());
        }

        $args->getEntityManager()->flush();
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->postSave($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->postSave($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!($entity instanceof Program)) {
            return;
        }

        if($entity->getWrappers()->count() > 0) {
            throw new HttpErrorException(sprintf('You can\'t delete program "%s" since it is used by other programs', $entity->getTitle()), 400);
        }
    }
}