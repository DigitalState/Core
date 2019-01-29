<?php

namespace Ds\Component\Security\Test\Command\Token;

use DomainException;
use Ds\Component\Security\Model\User;
use Ds\Component\Security\Test\Collection\UserCollection;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetCommand
 *
 * @package Ds\Component\Security
 */
final class GetCommand extends Command
{
    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    private $tokenManager;

    /**
     * @var \Ds\Component\Security\Test\Collection\UserCollection
     */
    private $userCollection;

    /**
     * Constructor
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     * @param \Ds\Component\Security\Test\Collection\UserCollection $userCollection
     * @param string $name
     */
    public function __construct(JWTTokenManagerInterface $tokenManager, UserCollection $userCollection, $name = null)
    {
        parent::__construct($name);
        $this->tokenManager = $tokenManager;
        $this->userCollection = $userCollection;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ds:security:token:get')
            ->addArgument('username', InputArgument::REQUIRED, 'The username.')
            ->addArgument('tenant', InputArgument::REQUIRED, 'The tenant.')
            ->setDescription('Gets a user token.')
            ->setHelp('This command allows you to get a user token.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $tenant = $input->getArgument('tenant');

        $user = $this->userCollection->filter(function(User $user) use ($username, $tenant) {
            return $user->getUsername() === $username && $user->getTenant() === $tenant;
        })->first();

        if (!$user) {
            throw new DomainException('User "'.$username.'" for tenant "'.$tenant.'" does not exist.');
        }

        $token = $this->tokenManager->create($user);
        $output->write($token);
    }
}
