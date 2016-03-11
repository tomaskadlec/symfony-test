<?php
namespace Net\TomasKadlec\Test\Fixtures;

use Net\TomasKadlec\Test\Fixtures\Executor\ReferenceDoesNotExistException;
use Net\TomasKadlec\Test\Fixtures\Executor\ReferenceExistsException;

/**
 * Interface ExecutorInterface
 * @package Net\TomasKadlec\Test\Fixtures\Fixture
 */
interface ExecutorInterface {

    /**
     * Loads fixtures into repository
     *
     * @param array $fixtures
     * @return ExecutorInterface
     */
    public function execute(array $fixtures);

    /**
     * Purges repository
     *
     * @return ExecutorInterface
     */
    public function purge();

    /**
     * @param $key
     * @return object
     * @throws ReferenceDoesNotExistException
     */
    public function getReference($key);

    /**
     * @param $key
     * @param $object
     * @return $this
     * @throws ReferenceExistsException
     */
    public function addReference($key, $object);

    /**
     * @param $key
     * @return $this
     * @throws ReferenceDoesNotExistException
     */
    public function removeReference($key);

}
