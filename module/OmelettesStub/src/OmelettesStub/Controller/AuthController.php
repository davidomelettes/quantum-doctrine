<?php

namespace OmelettesStub\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;
use Zend\Authentication;
use Zend\Form\Annotation\AnnotationBuilder;

class AuthController extends AbstractDoctrineController
{
    public function loginAction()
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('OmelettesStub\Form\LoginForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $authResult = $this->authenticateUser($data['emailAddress'], $data['password']);
                if ($authResult->isValid()) {
                    $this->getAuthenticationService()->getStorage()->write($authResult->getIdentity());
                    $this->flashSuccess('Welcome back');
                    return $this->redirect()->toRoute('front');
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
        $auth = $this->getAuthenticationService();
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }
        	
        $this->flashMessenger()->addSuccessMessage('You have successfully logged out');
        return $this->redirect()->toRoute('login');
    }
    
    public function forgotPasswordAction()
    {
        $form = $this->getManagedForm('OmelettesStub\Form\ForgotPasswordForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->flashSuccess('Yes');
            } else {
                $this->flashError('No');
            }
        }
        
        return $this->returnViewModel(array(
            'title'   => 'Request a password reset',
            'form'    => $form,
        ));
    }
    
}