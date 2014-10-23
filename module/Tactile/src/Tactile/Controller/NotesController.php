<?php

namespace Tactile\Controller;

use Tactile\Document;
use Tactile\Service;
use OmelettesDoctrine\Controller\AbstractDoctrineController;

class NotesController extends AbstractDoctrineController
{
    public function getNotesService()
    {
        return $this->getServiceLocator()->get('Tactile\Service\NotesService');
    }
    
    public function indexAction()
    {
        $paginator = $this->getNotesService()->fetchAll();
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        
        return $this->returnViewModel(array(
            'title'    => 'Notes',
            'notes'    => $paginator,
        ));
    }
    
    
}
