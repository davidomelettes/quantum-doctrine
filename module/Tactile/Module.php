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
                'Tactile\Form\ContactForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\ContactForm();
                    $form->setDocumentService($sm->get('Tactile\Service\ContactsService'));
                    return $form;
                },
                'Tactile\Form\NoteForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\NoteForm();
                    $form->setDocumentService($sm->get('Tactile\Service\NotesService'));
                    return $form;
                },
                'Tactile\Form\TagForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\TagForm();
                    $form->setDocumentService($sm->get('Tactile\Service\TagsService'));
                    return $form;
                },
                'Tactile\Form\UserPreferencesForm' => function ($fm) {
                    $sm = $fm->getServiceLocator();
                    $form = new Form\UserPreferencesForm();
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
                // Hydration
                'Tactile\Stdlib\Hydrator\ContactMethodHydrator' => function ($sm) {
                    $hydrator = new Stdlib\Hydrator\ContactMethodHydrator($sm->get('doctrine.documentmanager.odm_default'));
                    return $hydrator;
                },
                
                // Resources
                'Tactile\Service\ResourcesService' => function ($sm) {
                    $service = new Service\ResourcesService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
                
                // Contacts
                'Tactile\Service\ContactsService' => function ($sm) {
                    $service = new Service\ContactsService($sm->get('doctrine.documentmanager.odm_default'));
                    $contactsResource = $sm->get('Tactile\Service\ResourcesService')->findBy('slug', 'contacts');
                    $service->setResource($contactsResource);
                    return $service;
                },
                
                // Notes & Tags
                'Tactile\Service\NotesService' => function ($sm) {
                    $service = new Service\NotesService($sm->get('doctrine.documentmanager.odm_default'));
                    //$service->setResource();
                    return $service;
                },
                'Tactile\Service\TagsService' => function ($sm) {
                    $service = new Service\TagsService($sm->get('doctrine.documentmanager.odm_default'));
                    //$service->setResource();
                    return $service;
                },
                
                // Navigation
                'nav-top' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            ),
        );
    }
    
}
