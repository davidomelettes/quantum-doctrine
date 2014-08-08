<?php

namespace Tactile;

use OmelettesDoctrine\Document as OmDoc;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, FormElementProviderInterface, ServiceProviderInterface
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
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'nav-top' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            ),
        );
    }
    
}
