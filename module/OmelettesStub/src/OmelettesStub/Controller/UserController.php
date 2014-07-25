<?php

namespace OmelettesStub\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class UserController extends AbstractDoctrineController
{
    public function preferencesAction()
    {
        $form = $this->getManagedForm('OmelettesStub\Form\UserPreferencesForm');
        
        return $this->returnViewModel(array(
            'title' => 'Change your preferences',
            'form'  => $form,
        ));
    }
    
}
