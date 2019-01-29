<?php

namespace Ds\Component\Config\Command\Config;

use Ds\Component\Config\Service\ConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SetCommand
 *
 * @package Ds\Component\Config
 */
final class SetCommand extends Command
{
    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    private $configService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param string $name
     */
    public function __construct(ConfigService $configService, $name = null)
    {
        parent::__construct($name);
        $this->configService = $configService;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ds:config:set')
            ->addArgument('key', InputArgument::REQUIRED, 'The config key.')
            ->addArgument('value', InputArgument::REQUIRED, 'The config value.')
            ->setDescription('Sets a config value.')
            ->setHelp('This command allows you to set a config value.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $input->getArgument('key');
        $value = $input->getArgument('value');
        $this->configService->set($key, $value);
    }
}
