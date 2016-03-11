<?php
namespace Net\TomasKadlec\Test\TestCase;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Trait SecurityContextAwareTrait
 * @package Net\TomasKadlec\TestBundle\TestCase
 */
trait SecurityAwareTrait {

    /**
     * Current token storage
     *
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Returns a user to be set to the security context
     *
     * @return UserInterface
     */
    protected function getUser()
    {
        return null;
    }

    /**
     * Returns an identifier of firewall context to be used
     * (defaults to the name of the main firewall)
     *
     * @return string identifier of a firewall context to use
     */
    protected function getFirewallContext()
    {
        return 'main';
    }

    /**
     * Initializes security context with an instance of a UserInterface 
     * returned by $this->getUser()
     *
     * Method will be called automatically from ApplicationTestCase and
     * WebTestCase from this bundle and their children
     */
    protected function setUpSecurityContext()
    {
        if (empty($this->container) || ! $this->container instanceof ContainerInterface)
            throw new  \RuntimeException("Use the trait with a class that has an access to the container (ContainerInterface).");

        $this->tokenStorage = $this->container->get('security.token_storage');

        $user = $this->getUser();
        if ($user != null && $user instanceof UserInterface) {
            $this->tokenStorage->setToken(
                new UsernamePasswordToken(
                    $user, null, $this->getFirewallContext(), $user->getRoles()
                )
            );
        }
    }
}