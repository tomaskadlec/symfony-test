# symfony-test

symfony-test library simplifies use of the ``KernelTestCase`` class. It provides traits that
can handle initialization of:
  * kernel and container (``ContainerAwareTrait``),
  * security context (``SecurityContextAwareTrait``),
  * object manager (``ObjectManagerAwareTrait``).

The ``ContainerAwareTrait`` implements ``setUp`` and ``tearDown`` that boots / shuts down the 
kernel and also calls all ``setUp*`` methods defined in the other provided traits (you can use
it too in yout traits). The library provides also following classes 
  * ``ApplicationTestCase``, direct descendant of ``KernelTestCase`` with initialized container,
  * ``WebTestCase``, direct descendant of ``WebTestCase`` with initialized container.

## Instalation

The library supports Symfony >=3. Install it using composer: 

```
path/to/project $ composer require tomaskadlec/symfony-test
```

## Basic usage

Use of ``ApplicationTestCase`` or ``ContainerAwareTrait`` adds a property named ``$container``
and populates it with current instance.

```php
class MyTestCase extends ApplicationTestCase
{
    public function testThis()
    {
        $service = $this->container->get('...');
        // ...
    }
}
```

## Initialization of common services

The library can handle initialization of common services - object manager and security
can be initialized this way.

### ObjectManager

``ObjectManagerAwareTrait`` allows to easily access databases. A manager can be selected
(instead of ``default`` one) by overriding ``getManagerName()`` method. Name of the manager
is supposed to be retuned by this method.

```php
class MyTestCase extends ApplicationTestCase {

   use ObjectManagerAwareTrait;

    protected function getManagerName()
    {
        return 'default';
    }

    public function testThis()
    {
        $this->objectManager->
    }
}
```

### Security - TokenStorage

``SecurityAwareTrait`` initializes ``security.token_storage`` with an authenticated token.
An instance of ``UserInterface`` (represents the desired user) must be provided as a return
value of ``getUser()`` method.
 
```php
class MyTestCase extends ApplicationTestCase {

   use SecurityAwareTrait;

    protected function getUser()
    {
        $user = new MyUser(...); // must implement UserInterface!!!
        // ...
        return $user;
    }

    public function testThis()
    {
        // ...
        $this->assertTrue($this->securityContext->isGranted(...))
    }
}
```

Fixtures
--------

``ApplicationTestCase`` adds support for loading fixtures into memory and allows to reference them by simple keys.
A fixture is an object implementing a ``FixtureInterface``. Handling fixtures via the library is sufficient for 
simple use cases. If your fixtures are more complicated and/or stored in database consider using ``doctrine/doctrine-fixtures-bundle``
or ``nelmio/alice``.

Preparing a fixture
~~~~~~~~~~~~~~~~~~~

One has to implement aforementioned interface. Method ``load(ExecutorInterface $executor)`` is responsible for
creating instances and registering them as references. Reference repository is shared amongst all instances
 of executors. An executor is passed into the method and can be used to

  * addReference($key, $object),
  * removeReference($key),
  * getReference($key).

Loading fixtures is done by ``ApplicationTestCase::loadFixtures(array $fixtures)``. ``$fixtures`` is an array of
fully qualified class names that references to classes that implement ``FixtureInterface`` and shall be loaded.

Using a fixture
~~~~~~~~~~~~~~~

Fixture represents an expected object therefore it can be used directly. Retrieving fixtures is done using
``ApplicationTestCase::getFixtures()::getReference($key)``.

Exceptions
~~~~~~~~~~

If an error occurs exception is thrown

  * ``ReferenceException`` - generic error,
  * ``ReferenceDoesNotExistException`` - key does not exist (get, remove),
  * ``ReferenceExistsException`` - key exists (add).
