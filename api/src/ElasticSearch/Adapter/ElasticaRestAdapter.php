<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 03/02/19
 * Time: 16:38
 */

namespace App\ElasticSearch\Adapter;


use App\ElasticSearch\Indexer\IndexerAbstract;
use Elastica\Client;
use Elastica\Query;
use Elastica\Search;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Adapter\ElasticaAdapter;
use Sherpa\Rest\Adapter\RestAdapter;
use Sherpa\Rest\Utils\Bag;

class ElasticaRestAdapter extends RestAdapter
{

    /**
     * @var Client
     */
    private $client;

    protected $indexer;

    /**
     * ElasticaRestAdapter constructor.
     * @param Client $client
     * @param IndexerAbstract $indexer
     */
    public function __construct(Client $client, IndexerAbstract $indexer)
    {
        $this->client = $client;
        $this->indexer = $indexer;
    }

    /**
     * @return AdapterInterface
     */
    public function getPageAdapterFromParams(Bag $params)
    {
        return new ElasticaAdapter($this->getIndex(), $this->buildQueryFromCriteria($params), [],5000);
    }

    public function getEntityFromParams($id, Bag $params)
    {
        $query = $this->buildQueryFromCriteria($params);
        $search = new Search($this->client);
        $query->setSize(1);
        $documents = $search->search($search)->getDocuments();
        return $documents ? $documents[0] : null;
    }

    public function persistEntity($entity)
    {
        $this->getIndex()->getType('_doc')->addDocuments([$entity]);
    }

    public function removeEntity($entity)
    {
        $this->getIndex()->getType('_doc')->deleteDocument($entity);
    }

    public function getIndex()
    {
        return $this->indexer->getIndex();
    }

    protected function buildQueryFromCriteria(Bag $criteria)
    {
        $query = new Query();

        if ($search = $criteria->get('search')) {
            $query->setQuery(new Query\Term(['_all' => $search]));
        }

        return $query;
    }
}