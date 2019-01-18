<?php

namespace Irontec\Bundle\Wsdl2PhpGeneratorCommandBundle\Command;

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
            )
            ->addOption(
                'user',
                'u',
                InputOption::VALUE_NONE,
                'User'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_NONE,
                'Password'
            )
            ->addOption(
                'authentication',
                'a',
                InputOption::VALUE_NONE,
                'The autentication method for getting the wsdl. Allowed values: SOAP_AUTHENTICATION_BASIC or SOAP_AUTHENTICATION_DIGEST. Default value: SOAP_AUTHENTICATION_BASIC'
            )
        ;
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

        $user = $input->getOption('user');
        $password = $input->getOption('password');

        if(isset($user) != isset($password)) {
            $logger->alert('Both or none user and password must be provided');
        }

        $config = array(
            'inputFile' => $input->getOption('input'),
            'outputDir' => $input->getOption('output'),
            'namespaceName' => $input->getOption('namespace'),
            'sharedTypes' => $input->getOption('shared-types'),
            'constructorParamsDefaultToNull' => $input->getOption('constructorParamsDefaultToNull'),
        );

        if(isset($user) && isset($password)) {
            $auth = SOAP_AUTHENTICATION_BASIC;
            if($input->getOption('input') == 'SOAP_AUTHENTICATION_DIGEST') {
                $auth = SOAP_AUTHENTICATION_DIGEST;
            }
            $config['soapClientOptions'] = array(
                'login' => $user,
                'password' => $password,
                'connection_timeout' => 60,
                'authentication' => $auth
            );
        }
        $generator = new Generator();
        $generator->setLogger($logger);
        $generator->generate(
            new Config($config)
        );


    }
}
