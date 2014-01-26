<?php

/**
 * @package Redis
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 *
 * @copyright Copyright (c) 2013, Wojtek Zalewski
 * @license MIT
 */

namespace Wtk\Redis;

use Predis\ClientInterface;

/**
 * Redis client interface. Mostly for tests.
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface ClientApiInterface extends ClientInterface
{
    function hget($key, $field);
    function hscan($key, $position, $match, $pattern);
    function hset($key, $field, $value);
    function hdel($key, $field);
}
