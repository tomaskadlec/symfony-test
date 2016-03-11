<?php
namespace Net\TomasKadlec\Test\Fixtures\Executor;

use Net\TomasKadlec\Test\Fixtures\ExecutorInterface;
use Net\TomasKadlec\Test\Fixtures\FixtureInterface;

/**
 * Class ReferenceExecutor
 *
 * Loads fixtures and maintains a references to all registered fixtures
 * as a static reference repository.
 *
 * Executor cannot handle dependencies. Must be handled by user by loading
 * fixtures in correct order.
 *
 * @package Net\TomasKadlec\Test\Fixtures\Executor
 */
class ReferenceExecutor implements ExecutorInterface
{
    public static $referenceRepository;

    public function __construct()
    {
        if (empty(self::$referenceRepository))
            self::$referenceRepository = new ReferenceRepository();
    }

    /**
     * @inheritdoc
     */
    public function execute(array $fixtures)
    {
        foreach ($fixtures as $fixtureClass) {
            /** @var \Net\TomasKadlec\Test\Fixtures\FixtureInterface $fixture */
            $fixture = new $fixtureClass();
            $fixture->load($this);
        }
    }

    /**
     * Purges repository
     *
     * @return ExecutorInterface
     */
    public function purge()
    {
        self::$referenceRepository = new ReferenceRepository();
    }

    /**
     * @param $key
     * @return object
     * @throws ReferenceDoesNotExistException
     */
    public function getReference($key)
    {
        return self::$referenceRepository->get($key);
    }

    /**
     * @param $key
     * @param $object
     * @return $this
     * @throws ReferenceExistsException
     */
    public function addReference($key, $object)
    {
        self::$referenceRepository->add($key, $object);
        return $this;
    }

    /**
     * @param $key
     * @return $this
     * @throws ReferenceDoesNotExistException
     */
    public function removeReference($key)
    {
        self::$referenceRepository->remove($key);
        return $this;
    }

}
