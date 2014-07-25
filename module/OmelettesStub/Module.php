<?php

namespace OmelettesStub;

use OmelettesDoctrine\Document as OmDoc;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, FormElementProviderInterface
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
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                // Forms
                'OmelettesStub\Form\SignupForm' => function ($fm) {
                    // $fm is FormElementManager
                    $sm = $fm->getServiceLocator();
                    $form = new Form\SignupForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\LoginForm' => function ($fm) {
                    // $fm is FormElementManager
                    $sm = $fm->getServiceLocator();
                    $form = new Form\LoginForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\PasswordForgotForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\PasswordForgotForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\PasswordResetForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\PasswordResetForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\UserPreferencesForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\UserPreferencesForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\VerifyPasswordForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\VerifyPasswordForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
            ),
        );
    }
    
}
