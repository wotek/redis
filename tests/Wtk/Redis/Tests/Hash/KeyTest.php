<?php

/**
 * @package Redis
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 *
 * @copyright Copyright (c) 2013, Wojtek Zalewski
 * @license MIT
 */

namespace Wtk\Redis\Tests\Hash;

use Wtk\Redis\Hash\Key;

class KeyTest extends \PHPUnit_Framework_TestCase
{
    public function testKey()
    {
        $name = 'test';

        $key = new Key($name);

        $this->assertEquals(
            $name, $key->getName()
        );
        $this->assertEquals(
            $name, $key->__toString()
        );
    }

    public function testInvalidConstrutorArgument()
    {
        $this->setExpectedException('InvalidArgumentException');

        new Key(null);
    }
}
