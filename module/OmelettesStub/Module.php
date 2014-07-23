<?php

namespace OmelettesStub;

use Omelettes\Uuid\Uuid;
use OmelettesDoctrine\Document as OmDoc;
use Zend\Http\Header\SetCookie;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, FormElementProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                // Forms
                'OmelettesStub\Form\SignupForm' => function ($sm) {
                    // $sm is FormElementManager
                    $sm = $sm->getServiceLocator();
                    $form = new Form\SignupForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\PasswordForgotForm' => function ($sm) {
                    $sm = $sm->getServiceLocator();
                    $form = new Form\PasswordForgotForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
                'OmelettesStub\Form\PasswordResetForm' => function ($sm) {
                    $sm = $sm->getServiceLocator();
                    $form = new Form\PasswordResetForm();
                    $form->setDocumentService($sm->get('OmelettesDoctrine\Service\UsersService'));
                    return $form;
                },
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $ev)
    {
        $app = $ev->getParam('application');
        $eventManager = $app->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAuth'));
    }
    
    public function checkAuth(MvcEvent $ev)
    {
        $app = $ev->getApplication();
        $sm = $app->getServiceManager();
        /** @var $auth \Zend\Authentication\AuthenticationService */
        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        
        // Is the user logged in?
        if ($auth->hasIdentity()) {
            // User is logged in, session is fresh
            return;
        
        } else {
            // HTTP request might provide cookie data
            $request = $ev->getRequest();
            $cookie = $request->getCookie();
            if ($cookie && $cookie->offsetExists('login')) {
                // No auth identity in the current session, but we have a login cookie
                $loginPair = $cookie->login;
                if (!preg_match('/^([^;]+);([^;]+)$/', $loginPair, $m)) {
                    // Login cookie exists, but contents are garbage
                    return;
                }
                $userId = $m[1];
                $token = $m[2];
                
                // If we got here, we have a login cookie that looks valid
                // Attempt to authenticate using token-based auth adapter
                $oldAuthAdapter = $auth->getAdapter();
                $tokenAuthAdapter = new \DoctrineModule\Authentication\Adapter\ObjectRepository(array(
                    'objectManager'      => $sm->get('doctrine.documentmanager.odm_default'),
                    'identityClass'      => 'OmelettesDoctrine\Document\PersistentLoginToken',
                    'identityProperty'   => 'user.id',
                    'credentialProperty' => 'tokenHash',
                    'credentialCallable' => function (OmDoc\PersistentLoginToken $tokenDoc, $credential) {
                        return $tokenDoc->hashToken($credential);
                    },
                ));
                $auth->setAdapter($tokenAuthAdapter);
                $tokenAuthAdapter->setIdentity($userId)
                                 ->setCredential($token);
                $authResult = $tokenAuthAdapter->authenticate();
                if ($authResult->isValid()) {
                    // Successful authentication via persistent login cookie
                    $tokenDoc = $authResult->getIdentity();
                    $identity = $tokenDoc->getUser();
                    // Probably don't need to restore the old auth adapter, but hey
                    $auth->setAdapter($oldAuthAdapter);
                    $auth->getStorage()->write($identity);
                    
                    // Tokens are single-use; remove it
                    $tokensService = $sm->get('OmelettesDoctrine\Service\Auth\PersistentLoginTokensService');
                    $tokensService->removeToken($tokenDoc);
                    
                    // Create a new token
                    $uuid = new Uuid();
                    $newToken = $uuid->v4();
                    $newTokenDoc = $tokensService->createDocument();
                    $expiry = new \DateTime(OmDoc\PersistentLoginToken::DEFAULT_TOKEN_EXPIRY);
                    $newTokenDoc->setUser($identity)
                                ->setToken($newToken)
                                ->setExpiry($expiry);
                    $tokensService->save($newTokenDoc);
                    
                    // Send the token to the user for storage in a cookie
                    $setCookieHeader = new SetCookie(
                        'login',
                        sprintf('%s;%s', $identity->getId(), $newToken),
                        (int)$expiry->format('U'),
                        '/'
                    );
                    $ev->getResponse()->getHeaders()->addHeader($setCookieHeader);
                    
                    $tokensService->commit();
                    
                    return;
                } else {
                    // Unsuccessful authentication; attempt to remove cookie
                    // TODO: Invalidate all stored logins?
                    return;
                }
                
            } else {
                // No identity in session or cookie; user is not logged in
                return;
            }
        }
    }
    
}
