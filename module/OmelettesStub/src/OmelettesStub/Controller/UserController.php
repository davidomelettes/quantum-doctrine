<?php

namespace OmelettesStub\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class UserController extends AbstractDoctrineController
{
    public function preferencesAction()
    {
        $session = $this->getOmelettesSession();
        if (!$session->passwordAuthenticated) {
            $this->rememberCurrentRoute();
            return $this->redirect()->toRoute('verify-password');
        }
        
        $form = $this->getManagedForm('OmelettesStub\Form\UserPreferencesForm');
        
        return $this->returnViewModel(array(
            'title' => 'Change your preferences',
            'form'  => $form,
        ));
    }
    
}
