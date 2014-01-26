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

use Wtk\Redis\ClientFactoryInterface;

use MD\Foundation\Utils\ArrayUtils;

use Predis\Client;

/**
 * Redis clients factory
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class ClientFactory implements ClientFactoryInterface
{
    /**
     * Predefined connections configs
     *
     * @var array
     */
    protected $configs = array();

    /**
     *
     * @param  array      $configurations
     */
    public function __construct(array $configurations = array())
    {
        foreach($configurations as $name => $config) {
            $this->addConfiguration($name, $config);
        }
    }

    /**
     * Creates new redis client
     *
     * @param  string     $name
     *
     * @throws RuntimeException
     *
     * @return Predis\ClientInterface
     */
    public function create($name)
    {
        $config = $this->getConfiguration($name);

        if(null === $config) {
            throw new \RuntimeException(
                "Connection with name: $name not found."
            );
        }

        return new Client($config);
    }

    /**
     * Adds connection config
     *
     * @param  string     $name
     * @param  array      $config
     *
     * @throws RuntimeException
     *
     * @return void
     */
    public function addConfiguration($name, array $config)
    {
        if(array_key_exists($name, $this->configs)) {
            throw new \RuntimeException(
                "Connection with given name already exists!"
            );
        }

        $this->configs[$name] = $config;
    }

    /**
     * Returns connection config if defined
     *
     * @param  string     $name
     *
     * @return array|null
     */
    public function getConfiguration($name)
    {
        return ArrayUtils::get($this->configs, $name, null);
    }
}
