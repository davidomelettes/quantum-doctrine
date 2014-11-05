<?php

namespace Tactile\Controller;

use Tactile\Document;
use Tactile\Service;
use OmelettesDoctrine\Controller\AbstractDoctrineController;
use Zend\Filter;

class ContactsController extends AbstractDoctrineController
{
    /**
     * @return Service\ContactsService
     */
    public function getContactsService()
    {
        return $this->getServiceLocator()->get('Tactile\Service\ContactsService');
    }
    
    /**
     * @return Service\NotesService
     */
    public function getNotesService()
    {
        return $this->getServiceLocator()->get('Tactile\Service\NotesService');
    }
    
    /**
     * @return Service\TagsService
     */
    public function getTagsService()
    {
        return $this->getServiceLocator()->get('Tactile\Service\TagsService');
    }
    
    public function indexAction()
    {
        $paginator = $this->getContactsService()->fetchAll();
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        
        return $this->returnViewModel(array(
            'title'    => 'Contacts',
            'resource' => $this->getContactsService()->getResource(),
            'contacts' => $paginator,
        ));
    }
    
    public function newAction()
    {
        $contactsService = $this->getContactsService();
        $form = $this->getManagedForm('Tactile\Form\ContactForm');
        $contact = $contactsService->createDocument();
        $form->bind($contact);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $contact = $form->getData();
                $contactsService->save($contact);
                $contactsService->commit();
                $this->flashSuccess('Contact created successfully');
                return $this->redirect()->toRoute('contacts/id', array('id' => $contact->getId()));
            } else {
                $this->flashError('There was a problem saving the Contact');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'New Contact',
            'form'  => $form,
        ));
    }
    
    /**
     * @return Document\Contact|boolean
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
            $this->flashError('Unable to locate requested Contact');
            return $this->redirect()->toRoute('contacts');
        }
        $this->rememberRoute($contact->getFullName());
        
        $noteForm = $this->getManagedForm('Tactile\Form\NoteForm');
        $notes = $this->getNotesService()->fetchForQuantum($contact);
        
        return $this->returnViewModel(array(
            'title'    => $contact->getFullName(),
            'item'     => $contact,
            'notes'    => $notes,
            'noteForm' => $noteForm,
        ));
    }
    
    public function editAction()
    {
        $contact = $this->loadRequestedContact();
        if (!$contact) {
            $this->flashError('Unable to locate requested Contact');
            return $this->redirect()->toRoute('contacts');
        }
        
        $form = $this->getManagedForm('Tactile\Form\ContactForm');
        $form->bind($contact);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $collectionNames = array('contactMethods', 'addresses');
            $emptyCollections = array();
            foreach ($collectionNames as $collectionName) {
                if (!isset($data->$collectionName)) {
                    // Collection element expects an empty array if collection is empty
                    $emptyCollections[] = $collectionName;
                    $data->$collectionName = array();
                }
            }
            $form->setData($data);
            foreach ($emptyCollections as $collectionName) {
                // Remove validation from the form for each empty collection 
                $formFilter = $form->getInputFilter();
                $collectionFilter = $formFilter->get($collectionName);
                foreach ($collectionFilter->getInputs() as $i => $collectionFieldsetFilter) {
                    $collectionFilter->remove($i);
                }
            }
            if ($form->isValid()) {
                $contactsService = $this->getContactsService();
                $contact = $form->getData();
                $contactsService->save($contact);
                $contactsService->commit();
                $this->flashSuccess('Contact updated successfully');
                return $this->redirect()->toRoute('contacts/id', array('id' => $contact->getId()));
            } else {
                $this->flashError('There was a problem updating the Contact');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => sprintf("Editing '%s'", $contact->getFullName()),
            'form'  => $form,
            'item'  => $contact,
        ));
    }
    
    public function deleteAction()
    {
        $contact = $this->loadRequestedContact();
        if (!$contact) {
            $this->flashError('Unable to locate requested Contact');
            return $this->redirect()->toRoute('contacts');
        }
        
        $form = $this->getManagedForm('Tactile\Form\DeleteConfirmationForm');
        $form->get('cancel')->setOptions(array(
            'route_name' => 'contacts',
            'route_params' => array(
                'action' => 'view',
                'id' => $contact->getId(),
            ),
        ));
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $service = $this->getContactsService();
                $service->delete($contact);
                $service->commit();
                $this->flashSuccess('Contact deleted');
                return $this->redirect()->toRoute('contacts');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => sprintf("Delete %s?", $contact->getFullName()),
            'form'  => $form,
            'item'  => $contact,
        ));
    }
    
    public function addNoteAction()
    {
        $contact = $this->loadRequestedContact();
        if (!$contact) {
            $this->flashError('Unable to locate requested Contact');
            return $this->redirect()->toRoute('contacts');
        }
        
        $noteForm = $this->getManagedForm('Tactile\Form\NoteForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $note = new Document\Note();
            $noteForm->bind($note);
            $noteForm->setData($request->getPost());
            if ($noteForm->isValid()) {
                $note->getAttachedTo()->add($contact);
                $notesService = $this->getNotesService();
                $notesService->save($note);
                $notesService->commit();
                $this->flashSuccess('Note addded');
            } else {
                $this->flashError('There was a problem adding your Note');
            }
        }
        return $this->redirect()->toRoute('contacts/id', array('id' => $contact->getId()));
    }
    
    public function taggedAction()
    {
        $tagStrings = preg_split('/,/', $this->params('extra'));
        $tags = $this->getTagsService()->fetchWithNames($tagStrings);
        $title = 'Contacts Tagged: ';
        $tagNames = array();
        foreach ($tags as $tag) {
            $tagNames[] = '"' . $tag->getName() . '"';
        }
        $title .= implode(', ', $tagNames);
        
        $paginator = $this->getContactsService()->fetchByTags($tags);
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        
        return $this->returnViewModel(array(
            'title'              => $title,
            'resource'           => $this->getContactsService()->getResource(),
            'contacts'           => $paginator,
            'selectedTags'       => $tagStrings,
        ));
    }
    
}
