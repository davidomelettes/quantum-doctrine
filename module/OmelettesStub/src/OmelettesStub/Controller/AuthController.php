<?php

namespace OmelettesStub\Controller;

use Omelettes\Controller\AbstractController;
use Zend\Authentication;
use Zend\Form\Annotation\AnnotationBuilder;

class AuthController extends AbstractController
{
    public function loginAction()
    {
        $result = $this->authenticateUser('david@omelett.es', 'password');
        if ($result->isValid()) {
        } else {
        }
        
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('OmelettesStub\Form\LoginForm');
        
        return $this->returnViewModel(array(
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