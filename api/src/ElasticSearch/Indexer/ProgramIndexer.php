<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 07/11/18
 * Time: 23:40
 */

namespace App\ElasticSearch\Indexer;


use App\Entity\ContentValue;
use App\Entity\Program;

class ProgramIndexer extends IndexerAbstract
{
    protected $mappingProperties = [
        'id' => array('type' => 'integer'),
        'translations.title' => array('type' => 'text', 'boost' => 2),
        'code' => array('type' => 'text')
    ];

    protected $indexName = 'hyperdoc_program';

    public function transform($program)
    {
        /** @var Program $program */
        return [
            'id' => $program->getId(),
            'slug' => $program->getSlug(),
            'translations' => array_map(function ($translation) {
                return [
                    'title' => $translation->getTitle(),
                    'description' => $translation->getDescription()
                ];
            }, $program->getTranslations()->toArray()),
            'language' => $program->getLanguage(),
            'fullCode' => $program->getFullCode(),
            'code' => $program->getCode(),
            'inputs' => array_map(function (ContentValue $input) {
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