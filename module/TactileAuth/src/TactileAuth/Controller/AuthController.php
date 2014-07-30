<?php

namespace TactileAuth\Controller;

use Omelettes\Uuid\Uuid;
use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;
use TactileAuth\Form;
use Zend\Authentication;
use Zend\Http\Header\SetCookie;
use Zend\Session\Container;

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
     * @return Service\Auth\PasswordResetTokensService
     */
    public function getPasswordResetTokensService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\Auth\PasswordResetTokensService');
    }
    
    public function getPersistentLoginTokensService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\Auth\PersistentLoginTokensService');
    }
    
    public function passwordAuthenticateSession($authenticated = false)
    {
        $session = $this->getOmelettesSession();
        $session->passwordAuthenticated = $authenticated;
    }
    
    public function loginAction()
    {
        $auth = $this->getAuthenticationService();
        if ($auth->hasIdentity()) {
            $this->flashSuccess('Welcome back');
            return $this->redirect()->toRoute('front');
        }
        
        $form = $this->getManagedForm('TactileAuth\Form\LoginForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $authResult = $this->authenticateUser($data['emailAddress'], $data['password']);
                if ($authResult->isValid()) {
                    $identity = $auth->getIdentity();
                    // Store the fact that this session has been password-authenticated
                    $this->passwordAuthenticateSession(true);
                    
                    // Did they ask to be remembered?
                    if ($data['rememberMe']) {
                        $this->rememberMe($identity);
                    }
                    $this->flashSuccess('Welcome back');
                    
                    $redirectTo = $this->getRememberedRoute();
                    if (isset($redirectTo['name'])) {
                        return $this->redirect()->toRoute($redirectTo['name'], $redirectTo['params']);
                    } else {
                        return $this->redirect()->toRoute('front');
                    }
                } else {
                    //var_dump($authResult->getMessages());
                    $this->flashError('Invalid email address and/or password');
                }
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'Login',
            'form' => $form,
        ));
    }
    
    public function rememberMe(OmDoc\User $user)
    {
        // Create a token and store its hash
        $expiry = new \DateTime(OmDoc\PersistentLoginToken::DEFAULT_TOKEN_EXPIRY);
        $tokensService = $this->getPersistentLoginTokensService();
        $tokenDocument = $tokensService->createDocument();
        $uuid = new Uuid();
        $token = $uuid->v4();
        $tokenDocument->setUser($user)
                      ->setToken($token)
                      ->setExpiry($expiry);
        $tokensService->save($tokenDocument);
        
        // Give the user agent a cookie
        $setCookieHeader = new SetCookie(
            'login',
            sprintf('%s;%s', $user->getId(), $token),
            (int)$expiry->format('U'),
            '/'
        );
        $this->getResponse()->getHeaders()->addHeader($setCookieHeader);
        
        // Ok now we can save, but if the header is not received or rejected,
        // the user agent will not have the correct token
        $tokensService->commit();
    }

    /**
     * @param string $username
     * @param string $password
     * @return Authentication\Result
     */
    public function authenticateUser($identity, $credential)
    {
        $authService = $this->getAuthenticationService();
        $authAdapter = $authService->getAdapter();
        $authAdapter->setIdentityValue($identity) 
                    ->setCredentialValue($credential);
        return $authService->authenticate();
    }
    
    public function logoutAction()
    {
        $auth = $this->getAuthenticationService();
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }
        
        // Expire any login cookie on this machine
        $setCookieHeader = new SetCookie(
            'login',
            '',
            0,
            '/'
        );
        $this->getResponse()->getHeaders()->addHeader($setCookieHeader);
        
        $this->flashMessenger()->addSuccessMessage('You have successfully logged out');
        return $this->redirect()->toRoute('login');
    }
    
    /**
     * @return \Zend\Form\Zend\Form
     */
    public function getForgotPasswordForm()
    {
        return $this->getManagedForm('TactileAuth\Form\PasswordForgotForm');
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
        return $this->getManagedForm('TactileAuth\Form\PasswordResetForm');
    }
    
    /**
     * Allows a guest to change the password of a user account, if they provide a valid reset token
     * @throws \Exception
     */
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
                
                // Discard reset token
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
    
    public function verifyPasswordAction()
    {
        $session = $this->getOmelettesSession();
        if ($session->passwordAuthenticated) {
            $this->flashInfo('Your session is already password-authenticated');
            return $this->redirect()->toRoute('front');
        }
        $auth = $this->getAuthenticationService();
        
        $form = $this->getManagedForm('TactileAuth\Form\VerifyPasswordForm');
        $form->setData(array(
            'emailAddress' => $auth->getIdentity()->getEmailAddress(),
        ));
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $result = $this->authenticateUser($auth->getIdentity()->getEmailAddress(), $data['password']);
                if ($result->isValid()) {
                    $this->passwordAuthenticateSession(true);
                    $redirectTo = $this->getRememberedRoute();
                    if (isset($redirectTo['name'])) {
                        return $this->redirect()->toRoute($redirectTo['name'], $redirectTo['params']);
                    } else {
                        return $this->redirect()->toRoute('front');
                    }
                } else {
                    $this->flashError('Invalid email address and/or password');
                }
            }
        }
        
        return $this->returnViewModel(array(
            'title'   => 'Verify your password',
            'form'    => $form,
        ));
    }
    
}
