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
class UpdateBackendCommand extends Command
{
	private $src = ['src/', 'vendor/inkstudio/beaver/'];
	private $temporal = './beaver-install/';
	private $distribution_folder = 'CoreBundle/Distribution/';
	private $files = [
		'package.json',
		'gulpfile.js',
		'gulp-tasks/fonts.js',
		'gulp-tasks/framework.js',
		'gulp-tasks/images.js',
		'gulp-tasks/sass.js',
		'gulp-tasks/scripts.js'
	];
	
	/**
	 *
	 */
    protected function configure()
    {
        $this
            ->setName('beaver:install-assets')
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
	
	        $output->writeln('Step 1. Copiando assets');
	        $process = new Process('bin/console asset:install --symlink public');
	
	        $process->start(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo $buffer;
		        } else {
			        echo $buffer;
		        }
	        });
	
	        $output->writeln('Step 2. Instalando assets');
	        $process = new Process('bin/console fos:js-routing:dump --target=public/js/fos_js_routes.js ');
	
	        $process->start(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo $buffer;
		        } else {
			        echo $buffer;
		        }
	        });
	  
            $output->writeln('Step 3. Eliminando directorios antiguos');
            $fs->remove([
            	'public/bundles/beaver/fonts',
	            'public/bundles/beaver/images',
	            'public/bundles/beaver/css',
	            'public/bundles/beaver/js'
            ]);
	
	        $output->writeln('Step 4. Copiando archivos de instalación');
	        foreach ($this->files as $file) {
		        foreach ($this->src as $root) {
			        if (true === $fs->exists($root . $this->distribution_folder .$file)) {
				        $fs->copy($root . $this->distribution_folder . $file, $this->temporal . $file);
			        }
		        }
	        }
	        
	        $output->writeln('Step 5. Instalando modulos de node');
	
	        $process = new Process('npm install -prefix ' . $this->temporal);
	        $process->setTimeout(null);
	        $process->run(function ($type, $buffer) {
		        if (Process::ERR === $type) {
			        echo 'ERR > '.$buffer;
		        } else {
			        echo 'OUT > '.$buffer;
		        }
	        });
	
			if (true == $process->isSuccessful()) {
				$output->writeln('Step 6. Compilando archivos');
				$process = new Process('gulp --gulpfile beaver-install/gulpfile.js');
				$process->run(function ($type, $buffer) {
					if (Process::ERR === $type) {
						echo 'ERR > '.$buffer;
					} else {
						echo 'OUT > '.$buffer;
					}
				});
			}
	        

            $output->writeln('Instalación finalizada');
            echo $process->getOutput();
        } catch (IOException $exception) {
            echo 'Error ' . $exception->getMessage();
        }
    }
}