<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 11/10/18
 * Time: 20:46
 */

namespace App\Subscriber;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Sherpa\Rest\Utils\Camelizer;

class SnakifyClassnamesSubscriber implements EventSubscriber
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $meta = $eventArgs->getClassMetadata();
        $meta->setPrimaryTable(['name' => Camelizer::snakify($meta->getTableName())]);
    }

    public function getSubscribedEvents()
    {
        return ['loadClassMetadata'];
    }
}