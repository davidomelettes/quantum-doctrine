<?php

namespace OmelettesDoctrineDeveloper;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature;

class Module implements Feature\AutoloaderProviderInterface,
                        Feature\ConfigProviderInterface,
                        Feature\ConsoleUsageProviderInterface,
                        Feature\ServiceProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getConsoleUsage(Console $console)
    {
        return array(
            'build <assets>' => '<assets> must be one of: css',
            'db <action>'    => '<action> must be one of: drop, init',
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
            ),
        );
    }
    
}
