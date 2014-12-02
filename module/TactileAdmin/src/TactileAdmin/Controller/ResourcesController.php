<?php

namespace TactileAdmin\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class ResourcesController extends AbstractDoctrineController
{
    public function getResourcesService()
    {
        return $this->getServiceLocator()->get('Tactile\Service\ResourcesService');
    }
    
    public function indexAction()
    {
        $resources = $this->getResourcesService()->fetchAll();
        
        return $this->returnViewModel(array(
            'title'     => 'Resources',
            'resources' => $resources,
        ));
    }
    
    public function loadRequestedResource()
    {
        $id = $this->params('id');
        return $this->getResourcesService()->find($id);
    }
    
    public function viewAction()
    {
        $resource = $this->loadRequestedResource();
        if (!$resource) {
            $this->flashError('Unable to locate requested Resource');
            return $this->redirect()->toRoute('admin/resources');
        }
        
        return $this->returnViewModel(array(
            'title'     => $resource->getPlural(),
            'item'      => $resource,
        ));
    }
    
    public function editAction()
    {
        $resource = $this->loadRequestedResource();
        if (!$resource) {
            $this->flashError('Unable to locate requested Resource');
            return $this->redirect()->toRoute('admin/resources');
        }
        
        $form = $this->getManagedForm('TactileAdmin\Form\ResourceForm');
        $form->bind($resource);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $collectionNames = array('customFields');
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
                $resourcesService = $this->getResourcesService();
                $resource = $form->getData();
                $resourcesService->save($resource);
                $resourcesService->commit();
                $this->flashSuccess('Resource updated successfully');
                return $this->redirect()->toRoute('admin/resources/id', array('id' => $resource->getId()));
            } else {
                $this->flashError('There was a problem updating the Resource');
            }
        }
        
        return $this->returnViewModel(array(
            'title'     => 'Edit ' . $resource->getPlural(),
            'form'      => $form,
        ));
    }
    
}
