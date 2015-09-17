<?php

namespace Bru2s\Silex\Cache\Factory;

use Bru2s\Silex\Exception\ModuleIsNotInstalled;

abstract class AbstractFactory implements Factorable
{
    abstract public function getModuleName();

    public function __construct()
    {
        if (!$this->moduleIsInstalled()) {
            throw new ModuleIsNotInstalled($this->getModuleName());
        }
    }

    public function moduleIsInstalled()
    {
        if (!extension_loaded($this->getModuleName())) {
            return false;
        }

        return true;
    }
}
