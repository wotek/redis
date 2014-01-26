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
/**
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface ClientFactoryInterface
{
    /**
     * Creates new redis client
     *
     * @param  string     $name
     *
     * @throws RuntimeException
     *
     * @return RedisClientInterface
     */
    function create($name);
}
