<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 03/02/19
 * Time: 23:28
 */

namespace App\ElasticSearch\Subscriber;


use App\ElasticSearch\Indexer\IndexerAbstract;
use App\ElasticSearch\Interfaces\Indexable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Elastica\Client;
use Elastica\Index;
use mysql_xdevapi\Exception;
use Psr\Container\ContainerInterface;

class IndexEntitiesSubscriber implements EventSubscriber
{
    /**
     * @var Client $elasticClient
     */
    private $elasticClient;
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * IndexEntitiesSubscriber constructor.
     * @param Client $elasticClient
     * @param ContainerInterface $container
     */
    public function __construct(Client $elasticClient, ContainerInterface $container)
    {
        $this->elasticClient = $elasticClient;
        $this->container = $container;
    }


    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate
        ];
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->postSave($event, false);
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $this->postSave($event, true);
    }

    public function postSave(LifecycleEventArgs $event, $isUpdate = false)
    {
        $entity = $event->getEntity();
        if($entity instanceof Indexable) {
            foreach ($entity->getIndexers() as $indexerClass) {
                $indexer = $this->container->get($indexerClass);
                if(!($indexer instanceof IndexerAbstract)) {
                    throw new \Exception(sprintf("Invalid indexer %s should extend %s", $indexerClass, IndexerAbstract::class));
                }
                if($isUpdate) {

                }
                $indexer->indexOne($entity);
            }
        }
    }
}