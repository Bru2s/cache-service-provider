<?php

namespace Bru2s\Silex\Cache\Factory;

use Bru2s\Silex\Exception\InvalidCacheConfig;

class Memcached extends AbstractFactory
{
    const MODULE_NAME = 'memcached';

    public function getModuleName()
    {
        return self::MODULE_NAME;
    }

    public function create(array $params)
    {
        if (!$this->isValidParams($params)) {
            throw new InvalidCacheConfig();
        }

        $memcached = new \Memcached();
        $memcached->addServer($params['host'], $params['port']);

        return $memcached;
    }

    /**
     * @param array $params *
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
