<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 16:41
 */

namespace App\Repository;


use App\Entity\Content;
use App\Entity\Program;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Rest\Utils\Bag;
use Sherpa\Doctrine\ServiceRepository;
use Sherpa\Rest\Abstractions\DoctrineRestQueryBuilderInterface;

class ProgramRepository extends ContentRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Program::class);
    }

    public function createQueryBuilderFromArray($alias, Bag $criteria)
    {
        return parent::createQueryBuilderFromArray($alias, $criteria)
            ->leftJoin($alias.'.inputs', 'pi')
            ->addSelect('pi')
            ->leftJoin($alias.'.associatedInputs', 'ai')
            ->addSelect('ai')
            ->leftJoin($alias.'.wrapped', 'w')
            ->addSelect('w');
    }

    public function getProgramBySlug($slug)
    {
        return $this->getContentBySlug($slug);
    }
}