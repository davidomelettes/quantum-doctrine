<?php

namespace Tactile\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class UserController extends AbstractDoctrineController
{
    public function getUsersService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
    }
    
    public function preferencesAction()
    {
        $form = $this->getManagedForm('Tactile\Form\UserPreferencesForm');
        $usersService = $this->getUsersService();
        $user = $this->getAuthenticationService()->getIdentity();
        $form->bind($user);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
                $usersService->save($user);
                $usersService->commit();
                $this->flashSuccess('Preferences updated successfully');
                return $this->redirect()->toRoute('user');
            } else {
                $this->flashError('There was a problem saving your preferences');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'User Preferences',
            'form'  => $form,
        ));
    }
    
}