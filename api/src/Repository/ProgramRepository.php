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
use Sherpa\Doctrine\ServiceRepository;
use Sherpa\Rest\Abstractions\DoctrineRestQueryBuilderInterface;

class ProgramRepository extends ServiceRepository implements DoctrineRestQueryBuilderInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Program::class);
    }

    public function createQueryBuilderFromArray($alias, array $criteria)
    {
        return $this->createQueryBuilder($alias)
            ->leftJoin($alias.'.inputs', 'pi')
            ->addSelect('pi')
            ->leftJoin($alias.'.outputs', 'po')
            ->addSelect('po')
            ->leftJoin($alias.'.translations', 'tr')
            ->addSelect('tr');
    }
    public function createQueryBuilderFromIdentifier($alias, $identifier, array $criteria = [])
    {
        return $this->createQueryBuilderFromArray($alias, $criteria)
            ->where($alias . '.slug = :slug')
            ->setParameter('slug', $identifier);
    }
}