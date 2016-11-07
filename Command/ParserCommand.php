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


class ParserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('wsdl2phpgenerator:parser')
            ->setDescription('Parse remote WSDL, and create PHP Classes .')
            ->addOption(
                'wsdl',
                null,
                InputOption::VALUE_REQUIRED,
                'The WSDL URL.'
            )
            ->addOption(
                'output',
                null,
                InputOption::VALUE_REQUIRED,
                'Output Directory for generated classes'
            )
            ->addOption(
                'ns',
                null,
                InputOption::VALUE_REQUIRED,
                'Class Namespace Class\\Example'
            );


    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $verbosityLevelMap = array(
            LogLevel::INFO   => OutputInterface::VERBOSITY_VERY_VERBOSE,
        );
        $logger = new ConsoleLogger($output, $verbosityLevelMap);


        $generator = new Generator();
        $generator->setLogger($logger);
        $generator->generate(
            new Config(array(
                'inputFile' => $input->getOption('wsdl'),
                'outputDir' => $input->getOption('output'),
                'namespaceName' => $input->getOption('ns'),
                'sharedTypes' => true,
                'constructorParamsDefaultToNull' => true
            ))
        );


    }
}
