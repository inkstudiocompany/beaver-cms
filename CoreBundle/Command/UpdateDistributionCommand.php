<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 11/4/17
 * Time: 00:19
 */
namespace Beaver\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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
class UpdateDistributionCommand extends ContainerAwareCommand
{
    private $src = ['vendor/beaver/'];
    private $temporal = './beaverDev/';
    private $distribution_folder = 'Beaver/CoreBundle/Distribution/';
    private $files = [
        'package.json',
        'gulpfile.js',
        'composer.json'
    ];

    protected function configure()
    {
        $this
            ->setName('beaver:self-update')
            ->setDescription('Actualiza archivos de distribución necesarios.')
            ->addOption('mode', 'prod', InputOption::VALUE_OPTIONAL,'', 'prod')
            ->addOption('install', 'install', InputOption::VALUE_OPTIONAL,'', 'yes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        try {
            if ('dev' === $input->getOption('mode')) {
                $this->src = ['src/'];
            }
            $output->writeln('Beaver Update Distribution');
            $output->writeln('====================');

            $output->writeln('Copiando archivos de distribución...');

            foreach ($this->files as $file) {
                foreach ($this->src as $root) {
                    if (true === $fs->exists($root . $this->distribution_folder .$file)) {
                        $fs->copy($root . $this->distribution_folder . $file, $this->temporal . $file);
                    }
                }
            }

            if ('yes' === $input->getOption('mode')) {
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
                }*/
            }

            $output->writeln('Beaver distribution se ha actualizado correctamente.');
        } catch (IOException $exception) {
            echo 'Error ' . $exception->getMessage();
        }
    }
}