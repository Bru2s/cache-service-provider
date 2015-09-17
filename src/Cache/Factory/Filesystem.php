<?php

namespace Bru2s\Silex\Cache\Factory;

use Bru2s\Silex\Exception\InvalidCacheConfig;

class Filesystem extends AbstractFactory
{
    const MODULE_NAME = 'filesystem';

    public function getModuleName()
    {
        return self::MODULE_NAME;
    }

    public function create(array $params)
    {
        if (!$this->isValidParams($params)) {
            throw new InvalidCacheConfig();
        }

        return new \Doctrine\Common\Cache\FilesystemCache($params['path']);
    }

    /**
     * @param array $params *
     *
     * @return bool
     */
    private function isValidParams(array $params)
    {
        if (!isset($params['path'])) {
            return false;
        }

        return true;
    }
}
