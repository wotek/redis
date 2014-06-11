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

use Wtk\Redis\Hash\HashInterface;

/**
 * Hash data type
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class Hash implements HashInterface, ClientAwareDataTypeInterface
{
    /**
     * That might end up as a stupid idea. But don't want to
     * tighten up DataTypes with Redis client yet.
     */
    use ClientAwareTrait;

    /**
     * Hash key
     *
     * @var string
     */
    protected $key;

    /**
     *
     * @param  KeyInterface $key
     */
    public function __construct(KeyInterface $key)
    {
        $this->key = $key;
    }

    /**
     * Returns hash key
     *
     * @return KeyInterface
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Returns hash field value
     *
     * @param  string     $field
     *
     * @return string
     */
    public function get($field)
    {
        $client = $this->getClient();

        return $client->hget($this->getKey()->getName(), $field);
    }

    /**
     * Returns fields matching given pattern
     *
     * @param  string     $pattern
     * @param  integer    $position
     *
     * @return array
     */
    public function fields($pattern, $position = 0)
    {
        /**
         * Redis returns collection's cursor first and then
         * an array of elements found.
         */
        return $this->getClient()->hscan(
            $this->getKey()->getName()
            , $position
            , 'MATCH'
            , $pattern
        );
    }

    /**
     * Multiget fields values
     *
     * @return array
     */
    public function mget(array $fields)
    {
        $result = array();

        foreach ($fields as $field) {
            $result[$field] = $this->get($field);
        }

        return $result;
    }

    /**
     * Sets field value
     *
     * @param  string     $field
     * @param  mixed      $value
     */
    public function set($field, $value)
    {
        $client = $this->getClient();

        $client->hset(
            $this->getKey()->getName(),
            $field,
            $value
        );

        // Integer reply, specifically:
        // 1 if field is a new field in the hash and value was set.
        // 0 if field already exists in the hash and the value was updated.

        return true;
    }

    /**
     * Multiset hash values
     *
     * @param  array      $fields
     * @param  array      $values
     *
     * @return void
     */
    public function mset(array $fields, array $values)
    {
        // Those are really temporary tricks.
        // @todo: Rewrite it to use native Predis API
        if(count($fields) !== count($values))
        {
            throw new \InvalidArgumentException(
                "Fields and values array have to be equal!"
            );
        }

        $combined = array_combine($fields, $values);

        foreach ($combined as $field => $value) {
            $this->set($field, $value);
        }
    }

    /**
     * Removes given field from hash
     *
     * @param  string     $field
     *
     * @return int
     */
    public function remove($field)
    {
        return (bool) $this->getClient()->hdel(
            $this->getKey()->getName(), $field
        );
    }

    /**
     * Removes given field from hash
     *
     * @param  array      $fields
     *
     * @return void
     */
    public function mremove(array $fields)
    {
        $removed = 0;

        foreach ($fields as $field) {
            $removed += $this->remove($field);
        }

        return $removed;
    }

    /**
     * Destroys hash and it's contents
     *
     * @return int
     */
    public function destroy()
    {
        return $this->getClient()->del($this->getKey()->getName());
    }
}
