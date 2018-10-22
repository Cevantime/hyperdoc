<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 16:44
 */

namespace App\Repository;


use App\Entity\ContentValue;
use Doctrine\ORM\EntityManagerInterface;
use Sherpa\Doctrine\ServiceRepository;

class ProgramValueRepository extends ServiceRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, ContentValue::class);
    }
}