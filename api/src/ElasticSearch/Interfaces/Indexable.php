<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 03/02/19
 * Time: 23:33
 */

namespace App\ElasticSearch\Interfaces;


use App\ElasticSearch\Indexer\IndexerAbstract;

interface Indexable
{
    /**
     * @return string[] indexers class names
     */
    public function getIndexers() : array;
}