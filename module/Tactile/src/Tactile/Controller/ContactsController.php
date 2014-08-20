<?php

namespace Tactile\Controller;

use Tactile\Document as Doc;
use Tactile\Service;
use OmelettesDoctrine\Controller\AbstractDoctrineController;

class ContactsController extends AbstractDoctrineController
{
    /**
     * @return Service\ContactsService
     */
    public function getContactsService()
    {
        return $this->getServiceLocator()->get('Tactile\Service\ContactsService');
    }
    
    public function indexAction()
    {
        $paginator = $this->getContactsService()->fetchAll();
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        
        return $this->returnViewModel(array(
            'title'    => 'Contacts',
            'contacts' => $paginator,
        ));
    }
    
    public function newAction()
    {
        $contactsService = $this->getContactsService();
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
                return $this->redirect()->toRoute('contacts', array('action' => 'view', 'id' => $contact->getId()));
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'New Contact',
            'form'  => $form,
        ));
    }
    
    /**
     * @return Doc\Contact|boolean
     */
    public function loadRequestedContact()
    {
        $contactsService = $this->getContactsService();
        $id = $this->params('id');
        return $contactsService->find($id);
    }
    
    public function viewAction()
    {
        $contact = $this->loadRequestedContact();
        if (!$contact) {
            $this->flashError('Unable to locate requested contact');
            return $this->redirect()->toRoute('contacts', array('action' => 'index'));
        }
        
        return $this->returnViewModel(array(
            'title' => $contact->getFullName(),
            'item'  => $contact,
        ));
    }
    
    public function editAction()
    {
        $contact = $this->loadRequestedContact();
        if (!$contact) {
            $this->flashError('Unable to locate requested contact');
            return $this->redirect()->toRoute('contacts', array('action' => 'index'));
        }
        
        $form = $this->getManagedForm('Tactile\Form\ContactForm');
        $form->bind($contact);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $contactsService = $this->getContactsService();
                $contact = $form->getData();
                $contactsService->save($contact);
                $contactsService->commit();
                $this->flashSuccess('Contact updated successfully');
                return $this->redirect()->toRoute('contacts', array('action' => 'view', 'id' => $contact->getId()));
            }
        }
        
        return $this->returnViewModel(array(
            'title' => $contact->getFullName(),
            'form'  => $form,
            'item'  => $contact,
        ));
    }
    
}
