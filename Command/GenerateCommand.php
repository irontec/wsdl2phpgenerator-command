<?php

namespace Wsdl2PhpGeneratorCommandBundle\Command;

use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Wsdl2PhpGenerator\Config;
use Wsdl2PhpGenerator\Generator as Generator;


class GenerateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('wsdl2phpgenerator:generate')
            ->setDescription('Provides wsdl2phpgenerator/wsdl2phpgenerator as a command on your Symfony Project.')
            ->addOption(
                'input',
                'i',
                InputOption::VALUE_REQUIRED,
                'Input WSDL URL [<fg=yellow>Required*</fg=yellow>]'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output Directory for self generated classes [<fg=yellow>Required*</fg=yellow>]'
            )
            ->addOption(
                'namespace',
                null,
                InputOption::VALUE_OPTIONAL,
                'Class Namespace "Class\\Example"'
            )
            ->addOption(
                'proxy',
                'p',
                InputOption::VALUE_OPTIONAL,
                'URL-like format proxy settings'
            )
            ->addOption(
                'shared-types',
                null,
                InputOption::VALUE_NONE,
                'sharedTypes option set to true'
            )
            ->addOption(
                'constructorParamsDefaultToNull',
                null,
                InputOption::VALUE_NONE,
               'constructorParamsDefaultToNull value set to true'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $verbosityLevelMap = array(
            LogLevel::INFO   => OutputInterface::VERBOSITY_VERY_VERBOSE,
            LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
        );

        $logger = new ConsoleLogger($output, $verbosityLevelMap);

        $wsdlFile = $input->getOption('input');

        if (!$wsdlFile) {
            $logger->alert('WSDL file not found!');
            return 1;
        }

        $outputDir = $input->getOption('output');
        if (!$outputDir) {
            $logger->alert('Output directory not found.');
            return 2;
        }

        if (!is_writable($outputDir)) {
            $logger->alert('Output directory not writable.');
            return 3;
        }

        $generator = new Generator();
        $generator->setLogger($logger);
        $generator->generate(
            new Config(array(
                'inputFile' => $input->getOption('input'),
                'outputDir' => $input->getOption('output'),
                'namespaceName' => $input->getOption('namespace'),
                'sharedTypes' => $input->getOption('shared-types'),
                'constructorParamsDefaultToNull' => $input->getOption('constructorParamsDefaultToNull')
            ))
        );


    }
}
