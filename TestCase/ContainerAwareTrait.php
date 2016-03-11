<?php
namespace Net\TomasKadlec\Test\TestCase;

use Net\TomasKadlec\Test\Fixtures\Executor\ReferenceExecutor;
use Net\TomasKadlec\Test\Fixtures\ExecutorInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Trait ContainerAwareTrait
 * @package Net\TomasKadlec\TestBundle\TestCase
 */
trait ContainerAwareTrait {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @inheritdoc
     */
    protected function setUp() {

        if (!$this instanceof KernelTestCase)
            throw new \RuntimeException("Use the trait with a class that has an access to the container (ContainerInterface).");

        static::bootKernel();
        $container = static::$kernel->getContainer();
        $this->container = $container;

        // call all setUp* methods
        $reflector = new \ReflectionObject($this);
        $methods = $reflector->getMethods();
        print_r($methods);
        foreach ($methods as $method) {
            if (!$method->isStatic() && preg_match('/^setUp.+/', $method->getName()))
                $this->{$method->getName()}();
        }
    }

    /**
     * @var ExecutorInterface
     */
    private $fixturesExecutor;

    /**
     * Returns an instance of ExecutorInterface. If it does not exists a new
     * one is created.
     *
     * @return ExecutorInterface
     */
    protected function getFixtures()
    {
        if ($this->fixturesExecutor == null) {
            $this->fixturesExecutor = new ReferenceExecutor();
        }
        return $this->fixturesExecutor;
    }

    /**
     * Creates a fixture executor and loads fixtures.
     *
     * Example use:
     *
     *   $this->getFixturesExecutor->getReference(...)
     *
     * @param array $fixtures
     * @param null $executor
     * @return $this
     */
    protected function loadFixtures(array $fixtures, $executor = null)
    {
        $this->getFixtures()->execute($fixtures);
        return $this;
    }

}