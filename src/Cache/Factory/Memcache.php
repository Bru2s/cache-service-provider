<?php

namespace Bru2s\Silex\Cache\Factory;

use Bru2s\Silex\Exception\InvalidCacheConfig;
use Bru2s\Silex\Exception\ModuleIsNotInstalled;

class Memcache extends AbstractFactory
{
    const MODULE_NAME = 'memcache';

    public function getModuleName()
    {
        return self::MODULE_NAME;
    }

    /**
     * @param array $params
     *
     * @return \Memcache
     *
     * @throws ModuleIsNotInstalled
     */
    public function create(array $params)
    {
        if (!$this->isValidParams($params)) {
            throw new InvalidCacheConfig();
        }

        $memcache = new \Memcache();
        $memcache->connect($params['host'], $params['port']);

        return $memcache;
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
