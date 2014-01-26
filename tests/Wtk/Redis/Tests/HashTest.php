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

use Wtk\Redis\Hash;
use Wtk\Redis\Hash\Key;

class HashTest extends \PHPUnit_Framework_TestCase
{
    public function getKeyMock()
    {
        return $this->getMock(
            'Wtk\Redis\KeyInterface'
        );
    }

    public function getClientMock()
    {
        return $this->getMock(
            'Wtk\Redis\ClientApiInterface'
        );
    }

    public function getHash($key, $client)
    {
        $hash = new Hash($key);
        $hash->setClient($client);

        return $hash;
    }

    public function testInstantiate()
    {
        $hash = $this->getHash(
            $this->getKeyMock(),
            $this->getClientMock()
        );

        $this->assertInstanceOf(
            'Wtk\Redis\DataTypeInterface',
            $hash
        );
    }

    public function testNoClientSetOnClientAwareDataType()
    {
        $this->setExpectedException('InvalidArgumentException');

        $hash = new Hash(new Key('foo'));
        $hash->get('neverbland');
    }

    public function testGetHashKey()
    {
        $key = $this->getKeyMock();

        $hash = $this->getHash(
            $key,
            $this->getClientMock()
        );

        $this->assertSame($key, $hash->getKey());
    }

    public function testGet()
    {
        $client = $this->getClientMock();

        $name = 'hash_key_name';
        $expected_result = true;
        $field = 'look.for.me';

        $key = new Key($name);

        $client
            ->expects($this->once())
            ->method('hget')
            ->with($name, $field)
            ->will($this->returnValue($expected_result))
        ;

        $hash = $this->getHash($key, $client);

        $result = $hash->get($field);

        $this->assertSame($expected_result, $result);
    }

    public function testFields()
    {
        $client = $this->getClientMock();

        $name = 'hash_key_name';
        $pattern = 'look.for.me';
        $position = 0;
        $expected_result = array();

        $key = new Key($name);

        $client
            ->expects($this->once())
            ->method('hscan')
            ->with($name, $position, 'MATCH', $pattern)
            ->will($this->returnValue($expected_result))
        ;

        $hash = $this->getHash($key, $client);

        $result = $hash->fields($pattern);

        $this->assertSame($expected_result, $result);
    }

    public function testMget()
    {
        $client = $this->getClientMock();

        $fields = array('a', 'b', 'c', 'd', 'e', 'f');

        $name = 'hash_key_name';
        $key = new Key($name);

        $value = 345;

        $client
            ->expects($this->exactly(count($fields)))
            ->method('hget')
            ->with($name)
            ->will($this->returnValue($value))
        ;

        $hash = $this->getHash($key, $client);

        $result = $hash->mget($fields);

        $expected_result = array_fill_keys($fields, $value);

        $this->assertSame($expected_result, $result);
    }

    public function testSet()
    {
        $client = $this->getClientMock();

        $name = 'hash_key_name';
        $field = 'look.for.me';
        $value = 'some_value';

        $key = new Key($name);

        $client
            ->expects($this->once())
            ->method('hset')
            ->with($name, $field, $value)
            ->will($this->returnValue(true))
        ;

        $hash = $this->getHash($key, $client);

        $result = $hash->set($field, $value);

        $this->assertTrue($result);
    }

    public function testMultiSet()
    {
        $client = $this->getClientMock();

        $value = 'some_value';

        $fields = array('a', 'b', 'c', 'd', 'e', 'f');

        $seed = array_fill_keys($fields, $value);

        $name = 'hash_key_name';
        $key = new Key($name);

        $i = 0;
        foreach ($seed as $field => $field_value) {
            $client
                ->expects($this->at($i))
                ->method('hset')
                ->with($name, $field, $field_value)
                ->will($this->returnValue(true))
            ;

            $i++;
        }

        $hash = $this->getHash($key, $client);

        $result = $hash->mset(array_keys($seed), array_values($seed));
    }

    public function testInvalidMultiSet()
    {
        $this->setExpectedException('InvalidArgumentException');

        $client = $this->getClientMock();

        $fields = array('a', 'b', 'c', 'd', 'e', 'f');
        $values = array('not', 'event');


        $hash = $this->getHash(new Key('dont_care'), $client);
        $hash->mset($fields, $values);
    }

    public function testRemove()
    {
        $client = $this->getClientMock();

        $name = 'hash_key_name';
        $field = 'look.for.me';

        $key = new Key($name);

        $client
            ->expects($this->once())
            ->method('hdel')
            ->with($name, $field)
            ->will($this->returnValue(true))
        ;

        $hash = $this->getHash($key, $client);

        $result = $hash->remove($field);

        $this->assertTrue($result);
    }

    public function testMultiRemove()
    {
        $client = $this->getClientMock();

        $fields = array('a', 'b', 'c', 'd', 'e', 'f');

        $name = 'hash_key_name';
        $key = new Key($name);

        $i = 0;
        foreach ($fields as $field) {
            $client
                ->expects($this->at($i))
                ->method('hdel')
                ->with($name, $field)
                ->will($this->returnValue(true))
            ;

            $i++;
        }

        $hash = $this->getHash($key, $client);

        $result = $hash->mremove($fields);

        $this->assertEquals(count($fields), $result);
    }

}
