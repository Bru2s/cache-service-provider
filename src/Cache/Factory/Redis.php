<?php

namespace Bru2s\Silex\Cache\Factory;

use Bru2s\Silex\Exception\InvalidCacheConfig;

class Redis extends AbstractFactory
{
    const MODULE_NAME = 'redis';

    public function getModuleName()
    {
        return self::MODULE_NAME;
    }

    public function create(array $params)
    {
        if (!$this->isValidParams($params)) {
            throw new InvalidCacheConfig();
        }

        $redis = new \Redis();
        $redis->connect($params['host'], $params['port']);

        return $redis;
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    private function isValidParams(array $params)
    {
        if (!isset($params['host'])) {
            return false;
        }

        if (!isset($params['port'])) {
            return false;
        }

        return true;
    }
}
