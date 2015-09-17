<?php

namespace Bru2s\Silex;

use Bru2s\Silex\Exception\InvalidCacheConfig as InvalidCacheConfigException;
use Doctrine\Common\Cache\CacheProvider;
use Silex\ServiceProviderInterface;
use Silex\Application;

class CacheServiceProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    private $prefix = 'cache';

    public function register(Application $app)
    {
        $app[$this->prefix] = $app->share(
            function () use ($app) {

                if (!isset($app['config']['cache'])) {
                    throw new InvalidCacheConfigException('Cache Config Not Defined');
                }

                $cacheSettings = $app['config']['cache'];
                $cacheClassName = sprintf('\Doctrine\Common\Cache\%sCache', ucfirst($cacheSettings['adapter']));

                if (!class_exists($cacheClassName)) {
                    throw new InvalidCacheConfigException('Cache Adapter Not Supported!');
                }

                if($cacheSettings['adapter'] == 'filesystem'){
                    $cacheAdapter = new $cacheClassName($cacheSettings['path']);
                }else{
                    $cacheAdapter = new $cacheClassName();
                }

                if ($cacheSettings['connectable'] === true) {
                    $this->addConnection($cacheAdapter, $cacheSettings);
                }

                return $cacheAdapter;
            }
        );
    }

    /**
     * @param CacheProvider $cacheAdapter
     * @param array         $cacheSettings
     */
    private function addConnection(CacheProvider $cacheAdapter, array $cacheSettings)
    {
        $proxy = new \Bru2s\Silex\Cache\Proxy();
        $connection = $proxy->getAdapter($cacheSettings);

        $setMethod = sprintf('set%s', ucfirst($cacheSettings['adapter']));
        $cacheAdapter->$setMethod($connection);
    }

    public function boot(Application $app)
    {
    }
}
