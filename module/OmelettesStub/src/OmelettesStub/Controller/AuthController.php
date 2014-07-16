<?php

namespace OmelettesStub\Controller;

use Omelettes\Uuid\Uuid;
use OmelettesDoctrine\Service;
use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesStub\Form;
use Zend\Authentication;
use Zend\Form\Annotation\AnnotationBuilder;

class AuthController extends AbstractDoctrineController
{
    /**
     * @return Service\UsersService
     */
    public function getUsersService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
    }
    
    /**
     * @return Service\UserPasswordResetTokensService
     */
    public function getPasswordResetTokensService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\UserPasswordResetTokensService');
    }
    
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
    
    /**
     * @return \Zend\Form\Zend\Form
     */
    public function getForgotPasswordForm()
    {
        return $this->getManagedForm('OmelettesStub\Form\PasswordForgotForm');
    }
    
    public function forgotPasswordAction()
    {
        $form = $this->getForgotPasswordForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $this->sendPasswordResetTokenEmail($data['emailAddress']);
                $this->flashSuccess(sprintf('An email containing password reset instructions has been sent to %s', $data['emailAddress']));
               
            } else {
                $this->flashError('No');
            }
        }
        
        return $this->returnViewModel(array(
            'title'   => 'Request a password reset',
            'form'    => $form,
        ));
    }
    
    public function sendPasswordResetTokenEmail($emailAddress)
    {
        // Verify the user exists
        $usersService = $this->getUsersService();
        if (false === ($user = $usersService->findBy('emailAddress', $emailAddress))) {
            throw new \Exception('Failed to find user with email address: ' . $emailAddress);
        }
        
        // Create a token and store the hash
        $tokensService = $this->getPasswordResetTokensService();
        $tokenDocument = $tokensService->createDocument();
        $uuid = new Uuid();
        $token = $uuid->v4();
        $tokenDocument->setUser($user)
                      ->setToken($token)
                      ->setExpiry(new \DateTime('+3 hours'));
        $tokensService->save($tokenDocument);
        $tokensService->commit();
        
        $mailVariables = array(
            'user'  => $user,
            'token' => $token,
        );
        $mailer = $this->getServiceLocator()->get('Omelettes\Mail\Mailer');
        $mailer->setHtmlTemplate('mail/html/password-reset', $mailVariables);
        $mailer->setTextTemplate('mail/text/password-reset', $mailVariables);
        $mailer->send(
            'Password Reset Requested',
            $emailAddress
        );
    }
    
    /**
     * @return Form\PasswordResetForm
     */
    public function getResetPasswordForm()
    {
        return $this->getManagedForm('OmelettesStub\Form\PasswordResetForm');
    }
    
    public function resetPasswordAction()
    {
        $userId = $this->params('user');
        $token = $this->params('secret');
        $tokensService = $this->getPasswordResetTokensService();
        $tokenDoc = $tokensService->findByUserIdAndToken($userId, $token);
        if (!$tokenDoc) {
            $this->flashError('Invalid reset token');
            return $this->redirect()->toRoute('login');
        }
        
        $form = $this->getResetPasswordForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // Change password
                $data = $form->getData();
                $usersService = $this->getUsersService();
                $user = $usersService->find($userId);
                if (!$user) {
                    throw new \Exception('Failed to find user with id: ' . $userId);
                }
                $user->setPassword($data['password']);
                $usersService->save($user);
                
                // Discard token
                $tokensService->removeToken($tokenDoc);
                $tokensService->commit();
                
                $this->flashSuccess('Your password has been successfully changed');
                return $this->redirect()->toRoute('login');
            }
        }
        
        return $this->returnViewModel(array(
            'title'   => 'Reset your password',
            'form'    => $form,
        ));
    }
    
}
