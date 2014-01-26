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
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
trait ClientAwareTrait
{
    /**
     * Redis client
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * Returns Redis client
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        if(null === $this->client)
        {
            throw new \InvalidArgumentException(
                "Missing Redis client. Please set one."
            );
        }

        return $this->client;
    }

    /**
     * @param  ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
