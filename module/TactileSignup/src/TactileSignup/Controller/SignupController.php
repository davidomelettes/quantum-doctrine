<?php

namespace TactileSignup\Controller;

use TactileSignup\Form;
use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesDoctrine\Document as OmDoc;

class SignupController extends AbstractDoctrineController
{
    public function signupAction()
    {
        $form = $this->getManagedForm('TactileSignup\Form\SignupForm');
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $user = $usersService->createDocument();
        $form->bind($user);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // Create a new account
                $accountsService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\AccountsService');
                $account = $accountsService->createDocument();
                $accountsService->signup($account);
                $user->setAccount($account)
                     ->setAclRole('admin');
                
                $usersService->signup($user);
                $usersService->commit();
                $this->flashSuccess('Signup successful');
                return $this->redirect()->toRoute('front');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'Sign up to Tactile CRM',
            'form' => $form,
        ));
    }
    
}
