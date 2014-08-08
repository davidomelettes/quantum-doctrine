<?php

namespace TactileAuth;

use OmelettesDoctrine\Document as OmDoc;
use Zend\ModuleManager\Feature;
use Zend\Mvc\MvcEvent;

class Module implements Feature\AutoloaderProviderInterface,
                        Feature\ConfigProviderInterface,
                        Feature\FormElementProviderInterface,
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
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'TactileAuth\Form\LoginForm' => function ($fm) {
                    // $fm is FormElementManager
                    $sm = $fm->getServiceLocator();
                    $form = new Form\LoginForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'TactileAuth\Form\PasswordForgotForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\PasswordForgotForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'TactileAuth\Form\PasswordResetForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\PasswordResetForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'TactileAuth\Form\VerifyPasswordForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\VerifyPasswordForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
            ),
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
