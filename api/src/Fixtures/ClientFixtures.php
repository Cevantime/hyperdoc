<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 01/02/19
 * Time: 10:58
 */

namespace App\Fixtures;


use App\Entity\Client;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ClientFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $testFront = new Client();
        $testFront->setName("Dev Front");
        $testFront->setRedirectUri('http://localhost:8080/callback');
        $testFront->setIdentifier('front-dev');
        $testFront->setSecret('mysecret');

        $manager->persist($testFront);
        $manager->flush();
    }
}