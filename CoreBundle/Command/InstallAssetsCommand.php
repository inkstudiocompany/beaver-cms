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
class InstallAssetsCommand extends Command
{
	private $src = ['src/', 'vendor/beaver/'];
	private $temporal = './beaver-install/';
	private $distribution_folder = 'Beaver/CoreBundle/Distribution/';
	private $files = [
		'package.json',
		'gulpfile.js'
	];
	
	/**
	 *
	 */
    protected function configure()
    {
        $this
            ->setName('beaver:install')
            ->setDescription('Compila y copia los assets necesarios para el CMS.')
            ->addOption('mode', 'prod', InputOption::VALUE_OPTIONAL,'', 'prod')
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

            $output->writeln('Beaver Installer');
            $output->writeln('====================');
	
	        $output->writeln('Step 1. Instalando assets');
	        $process = new Process('bin/console fos:js-routing:dump --target=public/js/fos_js_routes.js ');
	
	        $process->start(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo $buffer;
		        } else {
			        echo $buffer;
		        }
	        });
	        
            $output->writeln('Step 2. Creando directorios');
            $fs->remove('public/bundles/beaver/fonts');
            $fs->remove('public/bundles/beaver/images');
            $fs->remove('public/bundles/beaver/css');
            $fs->remove('public/bundles/beaver/js');
	
	        $fs->mkdir('public/bundles/beaver/fonts');
	        $fs->mkdir('public/bundles/beaver/images');
	        $fs->mkdir('public/bundles/beaver/css');
	        $fs->mkdir('public/bundles/beaver/js');
	
	        $output->writeln('Step 3. Copiando archivos de instalación');
	        foreach ($this->files as $file) {
		        foreach ($this->src as $root) {
			        if (true === $fs->exists($root . $this->distribution_folder .$file)) {
				        $fs->copy($root . $this->distribution_folder . $file, $this->temporal . $file);
			        }
		        }
	        }
	
	        $output->writeln('Step 4. Instalando modulos de node');
	
	        $process = new Process('npm install -prefix ' . $this->temporal);
	        $process->setTimeout(null);
	        $process->run(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo $buffer;
		        } else {
			        echo $buffer;
		        }
	        });
	        
	        
			/*
            $output->writeln('Corriendo tareas Gulp...');
            $process = new Process('gulp --gulpfile ' . $this->temporal . 'gulpfile.js --env=' . $environment);

            $process->start(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo $buffer;
                } else {
                    echo $buffer;
                }
            });

            while ($process->isRunning()) {
                echo '';
            }

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output->writeln('Assets instalados correctamente.');
            echo $process->getOutput();*/
        } catch (IOException $exception) {
            echo 'Error ' . $exception->getMessage();
        }
    }
}