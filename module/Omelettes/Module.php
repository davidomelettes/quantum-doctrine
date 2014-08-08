<?php

namespace Omelettes;

use Omelettes\Mail;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\SessionManager;

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
                // Email
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
                
                // Session management
                'Zend\Session\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    if (isset($config['session'])) {
                        $session = $config['session'];
                        
                        // Create the session config
                        $sessionConfig = null;
                        if (isset($session['config'])) {
                            $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }
                        
                        // Create the session storage
                        $sessionStorage = null;
                        if (isset($session['storage'])) {
                            $class = $session['storage'];
                            $sessionStorage = new $class();
                        }
                        
                        // Create the session save handler
                        $sessionSaveHandler = null;
                        if (isset($session['save_handler'])) {
                            // class should be fetched from service manager since it will require constructor arguments
                            $sessionSaveHandler = $sm->get($session['save_handler']);
                        }
                        
                        // Create the session manager
                        $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
                        
                        // Add session validators
                        if (isset($session['validator'])) {
                            $chain = $sessionManager->getValidatorChain();
                            foreach ($session['validator'] as $validator) {
                                $validator = new $validator();
                                $chain->attach('session.validate', array($validator, 'isValid'));
                            }
                        }
                    } else {
                        $sessionManager = new SessionManager();
                    }
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $ev)
    {
        $this->bootstrapSession($ev);
        $app = $ev->getParam('application');
        $eventManager = $app->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setLayout'));
    }
    
    public function bootstrapSession(MvcEvent $ev)
    {
        $app = $ev->getParam('application');
        $sm = $app->getServiceManager();
        $session = $sm->get('Zend\Session\SessionManager');
        $session->start();
        
        $container = new Container('initialized');
        if (!isset($container->init)) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }
    
    /**
     * Allow different layouts to be specified by route
     * @param MvcEvent $ev
     */
    public function setLayout(MvcEvent $ev)
    {
        $config = $ev->getApplication()->getServiceManager()->get('config');
        if (!isset($config['layout'])) {
            return;
        }
        $layout = $config['layout'];
    
        $routeName = $ev->getRouteMatch()->getMatchedRouteName();
        if (isset($layout[$routeName])) {
            $viewModel = $ev->getViewModel();
            $viewModel->setTemplate($layout[$routeName]);
        }
    }
    
}
