<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 08/11/18
 * Time: 00:05
 */

namespace App\Command;


use App\ElasticSearch\Indexer\ProgramIndexer;
use App\Repository\ProgramRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ElasticIndex extends Command
{
    /**
     * @var ProgramRepository
     */
    protected $programRepository;
    /**
     * @var ProgramIndexer
     */
    protected $programIndexer;

    /**
     * IndexPrograms constructor.
     * @param ProgramRepository $programRepository
     * @param ProgramIndexer $programIndexer
     */
    public function __construct(ProgramRepository $programRepository, ProgramIndexer $programIndexer)
    {
        parent::__construct();
        $this->programRepository = $programRepository;
        $this->programIndexer = $programIndexer;
    }

    protected function configure()
    {
        $this->setName('elasticsearch:index')
            ->setDescription('Index data in db to ElasticSearch')
            ->setHelp("Run this command when you have data that are not yet indexed in elasticsearch. It may occur if you didn't use doctrine to index data");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Program Indexer',
            '================',
            'Cleaning Index...'
        ]);

        $programsCount = $this->programRepository->count([]);
        $programs = $this->programRepository->createQueryBuilder('p')->getQuery()->getResult();
        $this->programIndexer->clear();

        $output->writeln('Indexing programs from db to elastic...');

        $progress = new ProgressBar($output);

        $progress->start($programsCount);

        foreach($programs as $program) {
            $this->programIndexer->indexOne($program);
            $progress->advance(1);
        }

        $progress->finish();

        $output->writeln("\nIndexation ended successfully !!");
    }
}