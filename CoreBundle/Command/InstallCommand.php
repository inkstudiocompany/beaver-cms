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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class InstallCommand
 * @package Beaver\CoreBundle\Command
 */
class InstallCommand extends Command
{
    private $src = ['src/', 'vendor/beaver/'];
    private $temporal = './beaverDev/';
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
            ->setName('backend:install')
            ->setDescription('Instalacion de los componentes de distribución.')
            ->setHelp('helping...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Vamos a copiar los archivos de gulp');

        $fs = new Filesystem();

        try {
            $output->writeln('Beaver CMS Installer');
            $output->writeln('====================');

            $output->writeln('Copiando archivos de instalación...');

            foreach ($this->files as $file) {
                foreach ($this->src as $root) {
                    if (true === $fs->exists($root . $this->distribution_folder .$file)) {
                        $fs->copy($root . $this->distribution_folder . $file, $this->temporal . $file);
                    }
                }
            }

            $output->writeln('Hecho!');

            $output->writeln('Instalando modulos de node...');

            $process = new Process('npm install -prefix ' . $this->temporal);
            $process->setTimeout(null);
            $process->run(function ($type, $buffer) {
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

            $output->writeln('Hecho!');

            $output->writeln('Creando directorios...');
            $fs->remove('web/css');
            $fs->remove('web/fonts');
            $fs->remove('web/js');

            $fs->mkdir('web/css');
            $fs->mkdir('web/fonts');
            $fs->mkdir('web/js');
            $output->writeln('Hecho!');

            /*$output->writeln('Instalando bootstrap vendor...');
            $process->setCommandLine('composer require twbs/bootstrap v4.0.0-beta.2');

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
            */

            $output->writeln('Hecho!');

            $output->writeln('Corriendo tareas Gulp...');
            $process->setCommandLine('gulp --gulpfile ' . $this->temporal . 'gulpfile.js');

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

            $output->writeln('Hecho!');

            //$fs->remove($this->temporal);

            echo $process->getOutput();
        } catch (IOException $exception) {
            echo 'Error ' . $exception->getMessage();
        }
    }
}