<?php


namespace App\Command;


use App\Services\DoctrineService;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Doctrine Reverse Engineer entrypoint.
 * Class DoctrineReverseEngineerCommand
 * @package App\Command
 */
class DoctrineReverseEngineerCommand extends Command
{
    /**
     * @var DoctrineService
     */
    private $doctrineService;

    public function __construct(DoctrineService $doctrineService)
    {
        parent::__construct('db:reverse-engineer');
        $this->doctrineService = $doctrineService;
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('db:reverse-engineer')
            ->setDescription('Do magic to reverse engineer a database and generate entities');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $myConfig = array(
            'dbParam' => array(
                'host' => '127.0.0.1',
                'driverClass' => Driver::class,
                'user' => 'root',
                'password' => '',
                'dbname' => 'test',
            ),
            'entityLocation' => 'src',
            'ymlLocation' => 'src/Entity/yml',
            'namespace' => 'Entity\\'
        );

        $this->doctrineService->reverseEngineer($myConfig);
        
        $output->writeln('Task completed');
    }
}
