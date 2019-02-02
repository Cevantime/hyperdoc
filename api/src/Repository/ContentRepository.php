<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 21/11/18
 * Time: 22:15
 */

namespace App\Repository;


use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Sherpa\Doctrine\ServiceRepository;
use Sherpa\Rest\Abstractions\DoctrineRestQueryBuilderInterface;
use Sherpa\Rest\Utils\Bag;

class ContentRepository  extends ServiceRepository implements DoctrineRestQueryBuilderInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Content::class);
    }

    public function createQueryBuilderFromArray($alias, Bag $criteria)
    {
        return $this->createQueryBuilder($alias)
            ->leftJoin($alias.'.translations', 'tr')
            ->addSelect('tr');
    }

    public function createQueryBuilderFromIdentifier($alias, $identifier, Bag $criteria)
    {
        return $this->createQueryBuilderFromArray($alias, $criteria)
            ->where($alias . '.slug = :slug')
            ->setParameter('slug', $identifier);
    }

    public function getContentBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }
}