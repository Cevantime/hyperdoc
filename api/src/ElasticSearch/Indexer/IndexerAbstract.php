<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 07/11/18
 * Time: 23:11
 */

namespace App\ElasticSearch\Indexer;


use Elastica\Client;
use Elastica\Document;
use Elastica\Request;
use Elastica\Type\Mapping;

abstract class IndexerAbstract
{
    protected $mappingProperties = [];
    protected $analysis = [
        'number_of_shards' => 4,
        'number_of_replicas' => 1,
        'analysis' => array(
            'analyzer' => array(
                'index' => array(
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => array('lowercase')
                ),
                'default_search' => array(
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => array('standard', 'lowercase')
                )
            )
        )
    ];
    protected $indexName = 'default';
    protected $index;
    protected $mapping;
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->index = $this->client->getIndex($this->indexName);

        $this->configure();
    }

    public function configure()
    {

    }

    public abstract function transform($object);

    public function createIndex() {
        if( ! $this->index->exists()) {
            $this->index->create($this->analysis);
        }
        if ($this->mappingProperties) {
            $this->mapping = new Mapping();
            $this->mapping->setProperties($this->mappingProperties);
            $this->mapping->setType($this->index->getType('_doc'));
            $this->mapping->send();
        }
    }

    public function clear()
    {
        if($this->index->exists()) {
            $this->client->request($this->indexName, Request::DELETE);
        }
        $this->createIndex();
    }

    public function indexMany($data)
    {
        $type = $this->index->getType('_doc');
        $docs = [];
        foreach ($data as $datum) {
            $docs[] = new Document($this->generateId(), $this->transform($datum));
        }
        $type->addDocuments($docs);

        $type->getIndex()->refresh();
    }

    public function indexOne($datum)
    {
        $type = $this->index->getType('_doc');

        $type->addDocument(new Document($this->generateId(), $this->transform($datum)));

        $type->getIndex()->refresh();
    }

    protected function generateId()
    {
        return bin2hex(openssl_random_pseudo_bytes(10));
    }

    public function getIndex()
    {
        return $this->index;
    }
}