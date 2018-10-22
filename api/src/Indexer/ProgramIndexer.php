<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 07/11/18
 * Time: 23:40
 */

namespace App\Indexer;


use App\Entity\Content;
use App\Entity\ContentValue;

class ProgramIndexer extends IndexerAbstract
{
    protected $mappingProperties = [
        'id'      => array('type' => 'integer'),
        'title'     => array('type' => 'text', 'boost' => 2),
        'code'  => array('type' => 'text')
    ];

    protected $indexName = 'hyperdoc_program';

    public function transform($program)
    {
        return [
            'id' => $program->getId(),
            'slug' => $program->getSlug(),
            'language' => $program->getLanguage(),
            'fullCode' => $program->getFullCode(),
            'code' => $program->getCode(),
            'inputs' => array_map(function(ContentValue $input){
                return [
                    'id' => $input->getId(),
                    'name' => $input->getName(),
                    'type' => $input->getType(),
                    'description' => $input->getDescription()
                ];
            }, $program->getAllInputs()->toArray())
        ];
    }
}