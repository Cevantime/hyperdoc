<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 02/02/19
 * Time: 00:23
 */

namespace App\Fixtures;


use App\Entity\Program;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProgramFixtures extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $prog = new Program();
        $code = "int i = 5;";
        $prog->setFullCode($code);
        $prog->setCurrentLocale('fr');
        $prog->setAuthor($this->getReference('user'));
        $prog->setCode($code);
        $prog->setLanguage('Java');
        $progTrans = $prog->translate('fr');
        $progTrans->setDescription("Mon super programme !");
        $progTrans->setTitle("Mon titre");
        $progEn = $prog->translate('en');
        $progEn->setDescription("My super program!");
        $progEn->setTitle("My title");
        $prog->setSlug('java-' . (new Slugify())->slugify($progTrans->getTitle()));
        $prog->mergeNewTranslations();
        $manager->persist($prog);
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}