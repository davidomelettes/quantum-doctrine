<?php

namespace TactileSignup;

use Omelettes\Module\OmelettesModule;
use OmelettesDoctrine\Document as OmDoc;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module extends OmelettesModule implements ConfigProviderInterface, AutoloaderProviderInterface, FormElementProviderInterface
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
                    __NAMESPACE__           => __DIR__ . '/src/' . __NAMESPACE__,
                    'TactileSignupFixtures' => __DIR__ . '/fixtures',
                ),
            ),
        );
    }
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'TactileSignup\Form\SignupForm' => function ($fm) {
                    // $fm is FormElementManager
                    $sm = $fm->getServiceLocator();
                    $form = new Form\SignupForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
            ),
        );
    }
    
}
