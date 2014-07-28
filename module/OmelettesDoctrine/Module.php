<?php

namespace OmelettesDoctrine;

use Omelettes\Module\OmelettesModule;
use Omelettes\Uuid\Uuid;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;
use Zend\Http\Header\SetCookie;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl;
use Zend\Session\Container;
use Zend\Stdlib\ResponseInterface as Response;

class Module extends OmelettesModule implements ConfigProviderInterface, ServiceProviderInterface
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
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                // Acl
                'OmelettesDoctrine\Service\AclService' => function ($sm) {
                    $service = new Service\AclService();
                    $config = $sm->get('config');
                    if (isset($config['acl'])) {
                        $acl = $config['acl'];
                        // Roles
                        if (isset($acl['roles'])) {
                            foreach ($acl['roles'] as $role => $roleParents) {
                                $role = new Acl\Role\GenericRole($role);
                                $service->addRole($role, $roleParents);
                            }
                        }
                        
                        // Resources
                        if (isset($acl['resources'])) {
                            foreach ($acl['resources'] as $role => $roleResources) {
                                foreach ($roleResources as $resource => $privileges) {
                                    if (!$service->hasResource($resource)) {
                                        $service->addResource(new Acl\Resource\GenericResource($resource));
                                    }
                                    $service->allow($role, $resource, $privileges);
                                }
                            }
                        }
                    }
                    return $service;
                },
                
                // Authentication
                'Zend\Authentication\AuthenticationService' => function ($sm) {
                    $service = $sm->get('doctrine.authenticationservice.odm_default');
                    return $service;
                },
                
                // Document Services
                'OmelettesDoctrine\Service\AccountsService' => function ($sm) {
                    $service = new Service\AccountsService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
                'OmelettesDoctrine\Service\UsersService' => function ($sm) {
                    $service = new Service\UsersService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
                'OmelettesDoctrine\Service\Auth\PasswordResetTokensService' => function ($sm) {
                    $service = new Service\Auth\PasswordResetTokensService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
                'OmelettesDoctrine\Service\Auth\PersistentLoginTokensService' => function ($sm) {
                    $service = new Service\Auth\PersistentLoginTokensService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $ev)
    {
        $app = $ev->getParam('application');
        $eventManager = $app->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAuth'));
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAcl'));
    }
    
    public function checkAcl(MvcEvent $ev)
    {
        $app = $ev->getApplication();
        $sm = $app->getServiceManager();
        $acl = $sm->get('OmelettesDoctrine\Service\AclService');
        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        $flash = $sm->get('ControllerPluginManager')->get('flashMessenger');
        
        // What resource are we trying to access?
        $resource = $ev->getRouteMatch()->getMatchedRouteName();
        if (!$acl->hasResource($resource)) {
            throw new \Exception('Missing or undefined ACL resource: ' . $resource);
        }
        // What are we trying to do with that resource?
        $privilege = $ev->getRouteMatch()->getParam('action', 'index');
        
        // Who is trying to do it?
        $role = 'guest';
        if ($auth->hasIdentity()) {
            $role = $auth->getIdentity()->getAclRole();
        }
        if (!$acl->hasRole($role)) {
            throw new \Exception('Missing or undefined ACL role: ' . $role);
        }
        
        // Are they allowed to do it?
        if (!$acl->isAllowed($role, $resource, $privilege)) {
            // ACL role is not allowed to access this resource/privilege
            switch ($role) {
                case 'guest':
                    // User is not logged in
                    $session = new Container('Omelettes');
                    $session->rememberedRoute = array(
                        'name'   => $resource,
                        'params' => $ev->getRouteMatch()->getParams(),
                    );
                    $flash->addErrorMessage('You must be logged in to access that page');
                    return $this->redirectToRoute($ev, 'login');
                default:
                    // User is logged in, probably tried to access an admin-only resource/privilege
                    $flash->addErrorMessage('You do not have permission to access that page');
                    return $this->redirectToRoute($ev, 'front');
            }
        }
    }
    
    /**
     * Confirm the user has an authentication identity;
     * handle persistent login tokens
     * @param MvcEvent $ev
     */
    public function checkAuth(MvcEvent $ev)
    {
        $app = $ev->getApplication();
        $sm = $app->getServiceManager();
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
                    $this->setCookie($ev->getResponse(), 'login', '', 0, '/');
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
                    $this->setCookie(
                        $ev->getResponse(),
                        'login',
                        sprintf('%s;%s', $identity->getId(), $newToken),
                        (int)$expiry->format('U'),
                        '/'
                    );
    
                    $tokensService->commit();
                    return;
                    
                } else {
                    // Unsuccessful authentication; attempt to remove cookie
                    $this->setCookie($ev->getResponse(), 'login', '', 0, '/');
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
