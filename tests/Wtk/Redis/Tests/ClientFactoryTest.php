<?php

/**
 * @package Redis
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 *
 * @copyright Copyright (c) 2013, Wojtek Zalewski
 * @license MIT
 */

namespace Wtk\Redis\Tests;

use Wtk\Redis\ClientFactory;

class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function getFactory(array $config = array())
    {
        return new ClientFactory($config);
    }

    public function getConnectionsConfig()
    {
        return array(
            'conn_1' => array(),
            'conn_2' => array(
                'host' => 'foo',
                'scheme' => 'bar',
                'port' => 'baz'
            ),
        );
    }

    public function testCreateConnection()
    {
        $factory = $this->getFactory($this->getConnectionsConfig());

        $this->assertInstanceOf(
            'Predis\ClientInterface',
            $factory->create('conn_1')
        );
    }

    public function testCreateInvalidConnection()
    {
        $this->setExpectedException('RuntimeException');

        $factory = $this->getFactory($this->getConnectionsConfig());

        $factory->create('not_existing_configuration');
    }

    public function testThrowExceptionOnDuplicateConnectionsConfig()
    {
        $this->setExpectedException('RuntimeException');

        $factory = $this->getFactory($this->getConnectionsConfig());

        $factory->addConfiguration('conn_1', array());
    }

}
