<?php
namespace Net\TomasKadlec\Test\TestCase;

/**
 * Class WebTestCase
 * @package Net\TomasKadlec\Test\TestCase
 */
class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase 
{
    use ContainerAwareTrait;

    /** @inheritdoc */
    protected static function createClient(array $options = array(), array $server = array())
    {
        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }

}
