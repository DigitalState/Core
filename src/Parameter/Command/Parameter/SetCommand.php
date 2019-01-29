<?php

namespace Ds\Component\Parameter\Command\Parameter;

use Ds\Component\Parameter\Service\ParameterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SetCommand
 *
 * @package Ds\Component\Parameter
 */
final class SetCommand extends Command
{
    /**
     * @var \Ds\Component\Parameter\Service\ParameterService
     */
    private $parameterService;

    /**
     * Constructor.
     *
     * @param \Ds\Component\Parameter\Service\ParameterService $parameterService
     * @param string $name
     */
    public function __construct(ParameterService $parameterService, $name = null)
    {
        parent::__construct($name);
        $this->parameterService = $parameterService;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ds:parameter:set')
            ->addArgument('key', InputArgument::REQUIRED, 'The parameter key.')
            ->addArgument('value', InputArgument::REQUIRED, 'The parameter value.')
            ->setDescription('Sets a parameter value.')
            ->setHelp('This command allows you to set a parameter value.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $input->getArgument('key');
        $value = $input->getArgument('value');
        $this->parameterService->set($key, $value);
    }
}
