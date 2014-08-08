<?php

namespace Tactile\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class ContactsController extends AbstractDoctrineController
{
    public function indexAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Contacts',
        ));
    }
    
}
