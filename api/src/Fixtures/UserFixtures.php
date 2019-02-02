<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 01/02/19
 * Time: 11:13
 */

namespace App\Fixtures;


use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $me = new User();
        $me->setEmail('thibaulttruffert@hotmail.com');
        $me->setPassword(password_hash('test', PASSWORD_ARGON2I));
        $me->setUsername('test');
        $manager->persist($me);
        $manager->flush();
        $this->addReference('user', $me);
    }
}