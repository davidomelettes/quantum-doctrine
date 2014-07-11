<?php

namespace OmelettesDoctrine;

use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
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
    
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
            ),
            'factories' => array(
                // Authentication
                'Zend\Authentication\AuthenticationService' => function ($sm) {
                    $service = $sm->get('doctrine.authenticationservice.odm_default');
                    return $service;
                },
                
                // Forms
                'OmelettesDoctrine\Form\Factory' => function ($sm) {
                    $dm = $sm->get('doctrine.documentmanager.odm_default');
                    $factory = new Form\Factory();
                    $factory->setDocumentManager($dm);
                    return $factory;
                },
                
                // Document Services
                'OmelettesDoctrine\Service\AccountsService' => function ($sm) {
                    $service = new Service\AccountsService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
                'OmelettesDoctrine\Service\UsersService' => function ($sm) {
                    $service = new Service\UsersService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
            ),
        );
    }
    
}
