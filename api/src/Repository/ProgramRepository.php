<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 16:41
 */

namespace App\Repository;


use App\Entity\Program;
use Doctrine\ORM\EntityManagerInterface;
use Sherpa\Rest\Utils\Bag;
use Sherpa\Doctrine\ServiceRepository;
use Sherpa\Rest\Abstractions\DoctrineRestQueryBuilderInterface;

class ProgramRepository extends ServiceRepository implements DoctrineRestQueryBuilderInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Program::class);
    }

    public function createQueryBuilderFromArray($alias, Bag $criteria)
    {
        return $this->createQueryBuilder($alias)
            ->leftJoin($alias.'.inputs', 'pi')
            ->addSelect('pi')
            ->leftJoin($alias.'.associatedInputs', 'ai')
            ->addSelect('ai')
            ->leftJoin($alias.'.outputs', 'po')
            ->addSelect('po')
            ->leftJoin($alias.'.wrapped', 'w')
            ->addSelect('w')
            ->leftJoin($alias.'.translations', 'tr')
            ->addSelect('tr');
    }
    public function createQueryBuilderFromIdentifier($alias, $identifier, Bag $criteria)
    {
        return $this->createQueryBuilderFromArray($alias, $criteria)
            ->where($alias . '.slug = :slug')
            ->setParameter('slug', $identifier);
    }

    public function getProgramBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }
}