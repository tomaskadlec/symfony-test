<?php
namespace Net\TomasKadlec\Test\TestCase;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ObjectManagerAwareTrait
 * @package Net\TomasKadlec\Test\TestCase
 */
trait ObjectManagerAwareTrait
{

    /** @var  ObjectManager */
    protected $objectManager;

    /**
     * @return string name of a connection to use
     */
    protected function getManagerName()
    {
        return 'default';
    }

    /**
     * Initializes objectManager with an instance of
     *
     * Method will be called automatically from ApplicationTestCase and
     * WebTestCase from this bundle and their children
     */
    protected function setUpObjectManager()
    {
        if (empty($this->container) || !$this->container instanceof ContainerInterface)
            throw new  \RuntimeException("Use the trait with a class that has an access to the container (ContainerInterface).");

        /** @var RegistryInterface $orm */
        $orm = $this->container->get('doctrine');
        $this->objectManager = $orm->getManager($this->getManagerName());
    }
}