<?php

namespace Omelettes;

use Omelettes\Mail;
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
            'factories' => array(
                'Omelettes\Mail\Mailer' => function ($sm) {
                    $config = $sm->get('config');
                    if (!isset($config['omelettes']['mail'])) {
                        throw new \Exception('Missing omelettes mail config');
                    }
                    $config = $config['omelettes']['mail'];
                    $defaultAddress = $config['email_addresses']['SYSTEM_NOREPLY'];
                    $mailer = new Mail\Mailer();
                    $mailer->setTextLayout('mail/layout/text')
                        ->setHtmlLayout('mail/layout/html')
                        ->setFromAddress($defaultAddress['email'])
                        ->setFromName($defaultAddress['name']);
                    return $mailer;
                },
            ),
        );
    }
    
}
