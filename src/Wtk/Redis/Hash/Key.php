<?php

/**
 * @package Redis
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 *
 * @copyright Copyright (c) 2013, Wojtek Zalewski
 * @license MIT
 */

namespace Wtk\Redis\Hash;

use Wtk\Redis\KeyInterface;

/**
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class Key implements KeyInterface
{
    /**
     *
     * @param  string     $key
     */
    public function __construct($key)
    {
        if(null === $key)
        {
            throw new \InvalidArgumentException(
                "Invalid argument given. Key cannot be empty!"
            );
        }
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->key;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
