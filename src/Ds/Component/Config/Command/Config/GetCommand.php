<?php

namespace Ds\Component\Config\Command\Config;

use Ds\Component\Config\Service\ConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetCommand
 *
 * @package Ds\Component\Config
 */
class GetCommand extends Command
{
    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

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
            ->setName('ds:config:get')
            ->addArgument('key', InputArgument::REQUIRED, 'The config key.')
            ->setDescription('Gets a config value.')
            ->setHelp('This command allows you to get a config value.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $input->getArgument('key');
        $value = $this->configService->get($key);
        $output->write($value);
    }
}
