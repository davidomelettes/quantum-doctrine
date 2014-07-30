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
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
                $identity = $authService->getIdentity();
                $identity->setPassword($data['password']);
                $usersService->save($identity)->commit();
                $this->flashSuccess('Password changed');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'Change your preferences',
            'form'  => $form,
        ));
    }
    
}
