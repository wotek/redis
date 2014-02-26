<?php

namespace Wtk\Redis\Hash;

use Wtk\Redis\DataTypeInterface;

interface HashInterface extends DataTypeInterface
{
    function getKey();

    function fields($pattern, $position = 0);

    function get($field);
    function mget(array $fields);

    function set($field, $value);
    function mset(array $fields, array $values);

    function remove($field);
    function mremove(array $fields);
}
