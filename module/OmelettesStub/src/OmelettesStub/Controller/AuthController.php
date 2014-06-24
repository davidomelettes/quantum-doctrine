<?php

namespace OmelettesStub\Controller;

use Omelettes\Controller\AbstractController;
use Zend\Authentication;
use Zend\Form\Annotation\AnnotationBuilder;

class AuthController extends AbstractController
{
    public function loginAction()
    {
        //$result = $this->authenticateUser('david@omelett.es', 'password');
        
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('OmelettesStub\Form\LoginForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->flashSuccess('Success');
            } else {
                // Failure
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'Login',
            'form' => $form,
        ));
    }

    /**
     * @param string $username
     * @param string $password
     * @return Authentication\Result
     */
    public function authenticateUser($username, $password)
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authAdapter = $authService->getAdapter();
        $authAdapter->setIdentityValue($username) 
                    ->setCredentialValue($password);
        return $authAdapter->authenticate();
    }
    
    public function logoutAction()
    {
        
    }
    
}