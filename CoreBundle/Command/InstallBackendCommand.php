<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 11/4/17
 * Time: 00:19
 */
namespace Beaver\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Process\Process;

/**
 * Class InstallBackendCommand
 *
 * @package Beaver\CoreBundle\Command
 */
class InstallBackendCommand extends Command
{
	/**
	 *
	 */
    protected function configure()
    {
        $this
            ->setName('beaver:install-backend')
            ->setDescription('Instala la base de datos y genera los datos base para su uso.')
        ;
    }
	
	/**
	 * @param \Symfony\Component\Console\Input\InputInterface   $input
	 * @param \Symfony\Component\Console\Output\OutputInterface $output
	 *
	 * @return int|null|void
	 */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln('Step 1. Generando diferencias en el schema.');
	        
	        $command = $this->getApplication()->find('doctrine:migrations:diff');
	        $command->run($input, $output);
	
	        $output->writeln('Step 2. Ejecutando migration.');
	        $command = $this->getApplication()->find('doctrine:migrations:migrate');
	        $command->run($input, $output);
	
            $output->writeln('Instalación finalizada');
        } catch (IOException $exception) {
            echo 'Error ' . $exception->getMessage();
        }
    }
}