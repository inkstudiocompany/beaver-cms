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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class InstallCommand
 * @package Beaver\CoreBundle\Command
 */
class DeployCommand extends Command
{
	protected function configure()
    {
        $this
            ->setName('beaver:deploy')
            ->setDescription('Prepara la aplicación para producción.')
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
        $fs = new Filesystem();

        try {
            $environment = $input->getOption('mode');
            $output->writeln($environment);

            $output->writeln('Beaver Deploy');
            $output->writeln('====================');
	
	        $output->writeln('Step 1. Actualizando vendor');
	        $process = new Process('composer install --no-dev --optimize-autoloader');
	
	        $process->start(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo $buffer;
		        } else {
			        echo $buffer;
		        }
	        });
	
	        $output->writeln('Step 2. Instalando assets');
	        $process = new Process('bin/console beaver:install-assets');
	
	        $process->start(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo $buffer;
		        } else {
			        echo $buffer;
		        }
	        });
	  
            $output->writeln('Finalizado!, la App esta lista para producción.');
            echo $process->getOutput();
        } catch (IOException $exception) {
            echo 'Error ' . $exception->getMessage();
        }
    }
}