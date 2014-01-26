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
 * Hash key interface
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface KeyInterface
{
    /**
     * Returns key name
     *
     * @return string
     */
    function getName();

    /**
     *
     * @return string
     */
    function __toString();
}
