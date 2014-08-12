<?php

namespace Tactile\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class ContactsController extends AbstractDoctrineController
{
    public function indexAction()
    {
        $contactsService = $this->getServiceLocator()->get('Tactile\Service\ContactsService');
        $paginator = $contactsService->fetchAll();
        
        return $this->returnViewModel(array(
            'title'    => 'Contacts',
            'contacts' => $paginator,
        ));
    }
    
    public function newAction()
    {
        $contactsService = $this->getServiceLocator()->get('Tactile\Service\ContactsService');
        $form = $this->getManagedForm('Tactile\Form\ContactForm');
        $form->bind($contactsService->createDocument());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $contact = $form->getData();
                $contactsService->save($contact);
                $contactsService->commit();
                $this->flashSuccess('Contact created successfully');
                return $this->redirect()->toRoute('contacts');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'New Contact',
            'form'  => $form,
        ));
    }
    
}
