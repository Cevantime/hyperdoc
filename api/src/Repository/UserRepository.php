<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 12:18
 */

namespace App\Repository;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Sherpa\Doctrine\ServiceRepository;

class UserRepository extends ServiceRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, User::class);
    }

    public function getUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->orWhere('u.email = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}