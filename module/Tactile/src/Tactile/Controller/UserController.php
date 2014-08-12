<?php

namespace Tactile\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class UserController extends AbstractDoctrineController
{
    public function preferencesAction()
    {
        $form = $this->getManagedForm('Tactile\Form\UserPreferencesForm');
        
        return $this->returnViewModel(array(
            'title' => 'User Preferences',
            'form'  => $form,
        ));
    }
    
}