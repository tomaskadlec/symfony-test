<?php
namespace Net\TomasKadlec\Test\Fixtures;

use Net\TomasKadlec\Test\Fixtures\ExecutorInterface;

/**
 * Interface FixtureInterface
 * @package Net\TomasKadlec\Test\Fixtures\Fixture
 */
interface FixtureInterface {

    /**
     * Loads a fixture
     *
     * @param ExecutorInterface $executor
     * @return mixed
     */
    public function load(ExecutorInterface $executor);

}
