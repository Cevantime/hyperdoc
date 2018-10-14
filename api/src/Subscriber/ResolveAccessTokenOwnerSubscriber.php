<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 17:10
 */

namespace App\Subscriber;


use App\Entity\AccessToken;
use App\Entity\AuthCode;
use App\Repository\UserRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ResolveAccessTokenOwnerSubscriber implements EventSubscriber
{
    /**
     * @var UserRepository $userRepo
     */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist => 'prePersist'
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(($entity instanceof AccessToken) || ($entity instanceof AuthCode)) {

            $user = $this->userRepo->find($entity->getUserIdentifier());
            if(!$user) {
                return;
            }
            if($entity instanceof AccessToken) {
                $user->addAccessToken($entity);
            } else {
                $user->addAuthCode($entity);
            }
        }
    }
}