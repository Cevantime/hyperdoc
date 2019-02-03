<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 03/02/19
 * Time: 18:34
 */

namespace App\ElasticSearch\Adapter;

use App\ElasticSearch\Indexer\ProgramIndexer;
use Elastica\Client;

class ProgramAdapter extends ElasticaRestAdapter
{
    public function __construct(Client $client, ProgramIndexer $indexer)
    {
        parent::__construct($client, $indexer);
    }
}