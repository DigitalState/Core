<?php

namespace Ds\Component\Tenant\Command\Tenant;

use Ds\Component\Tenant\Service\TenantService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CreateCommand
 *
 * @package Ds\Component\Tenant
 */
class CreateCommand extends Command
{
    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    protected $tenantService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Tenant\Service\TenantService $tenantService
     * @param string $name
     */
    public function __construct(TenantService $tenantService, $name = null)
    {
        parent::__construct($name);
        $this->tenantService = $tenantService;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ds:tenant:create')
            ->addArgument('data', InputArgument::REQUIRED, 'The tenant data.')
            ->setDescription('Create a tenant.')
            ->setHelp('This command allows you to create a tenant.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $input->getArgument('data');
        $data = Yaml::parse(str_replace('\\n', "\n", $data));
        $this->tenantService->initialize($data);
    }
}
