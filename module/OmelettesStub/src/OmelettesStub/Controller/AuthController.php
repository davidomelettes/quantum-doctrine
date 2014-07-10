<?php

namespace OmelettesStub\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;
use Zend\Authentication;
use Zend\Form\Annotation\AnnotationBuilder;

class AuthController extends AbstractDoctrineController
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
                $data = $form->getData();
                $authResult = $this->authenticateUser($data['emailAddress'], $data['password']);
                if ($authResult->isValid()) {
                    var_dump($authResult->getIdentity());
                    //$this->getAuthenticationService()->getStorage()->write($authResult->getIdentity());
                    $this->flashSuccess('Welcome back');
                    //return $this->redirect()->toRoute('front');
                } else {
                    $this->flashError('Invalid email address and/or password');
                }
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
        $authService = $this->getAuthenticationService();
        $authAdapter = $authService->getAdapter();
        $authAdapter->setIdentityValue($username) 
                    ->setCredentialValue($password);
        return $authAdapter->authenticate();
    }
    
    public function logoutAction()
    {
        
    }
    
    public function signupAction()
    {
        
    }
    
}