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
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface ClientAwareDataTypeInterface
{
    /**
     * Returns redis client
     *
     * @return ClientInterface
     */
    function getClient();

    /**
     *
     * @param  ClientInterface $client Redis client
     */
    function setClient(ClientInterface $client);
}
