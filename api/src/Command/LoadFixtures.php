<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 01/02/19
 * Time: 11:01
 */

namespace App\Command;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixtures extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * LoadFixtures constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('fixtures:load')
            ->setDescription('Load all fixtures')
            /*->setHelp("Add a --prod flag if you want to load production fixtures")*/;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Fixtures Loader',
            '================'
        ]);

        $loader = new Loader();
        $loader->loadFromDirectory('src/Fixtures');

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
    }
}