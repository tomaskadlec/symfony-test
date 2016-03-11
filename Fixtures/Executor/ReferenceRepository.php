<?php
namespace Net\TomasKadlec\Test\Fixtures\Executor;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ReferenceRepository
 *
 * Simple reference repository intended as shared amongst instances of ReferenceExecutor
 *
 * @package Net\TomasKadlec\Test\Fixtures\Executor
 */
class ReferenceRepository {

    protected $repository;

    public function __construct()
    {
        $this->repository = new ArrayCollection();
    }

    /**
     * Retrieves a reference identified by key
     *
     * @param $key
     * @return mixed
     * @throws ReferenceDoesNotExistException if no reference exists identified by specified key
     */
    public function get($key)
    {
        if (!$this->repository->containsKey($key))
            throw new ReferenceDoesNotExistException();
        return $this->repository->get($key);
    }

    /**
     * Add a reference identified by key
     *
     * @param $key
     * @param $object
     * @return $this
     * @throws ReferenceExistsException if reference already exists identified by key
     */
    public function add($key, $object)
    {
        if ($this->repository->containsKey($key))
            throw new ReferenceExistsException();
        $this->repository->set($key, $object);
    }

    /**
     * Removes a reference identified by $key
     *
     * @param $key
     * @return $this
     * @throws ReferenceDoesNotExistException if no reference exists identified by specified key
     */
    public function remove($key)
    {
        if (!$this->repository->containsKey($key))
            throw new ReferenceDoesNotExistException();
        $this->repository->remove($key);
        return $this;
    }
}

class ReferenceException extends \RuntimeException {

}

class ReferenceDoesNotExistException extends ReferenceException {

}

class ReferenceExistsException extends ReferenceException {

}
