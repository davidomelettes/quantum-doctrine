<?php

namespace OmelettesDoctrine;

use Omelettes\Uuid\Uuid;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Header\SetCookie;
use Zend\ModuleManager\Feature;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl;
use Zend\Session\Container;
use Zend\Stdlib\ResponseInterface as Response;

class Module implements Feature\AutoloaderProviderInterface,
                        Feature\ConfigProviderInterface,
                        Feature\ConsoleBannerProviderInterface,
                        Feature\ConsoleUsageProviderInterface,
                        Feature\FormElementProviderInterface,
                        Feature\ServiceProviderInterface
{
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
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getConsoleBanner(Console $console)
    {
        return
        "==------------------------------------------------------==\n" .
        "==        OMELETT.ES APPLICATION CONSOLE                ==\n" .
        "==------------------------------------------------------=="
                ;
    }
    
    public function getConsoleUsage(Console $console)
    {
        return array(
        );
    }
    
    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'OmelettesDoctrine\Form\Fieldset\WhenFieldset' => function ($fm) {
                    $fieldset = new Form\Fieldset\WhenFieldset();
                    return $fieldset;
                },
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
                
                // Hydration
                'OmelettesDoctrine\Stdlib\Hydrator\UberHydrator' => function ($sm) {
                    $hydrator = new Stdlib\Hydrator\UberHydrator($sm->get('doctrine.documentmanager.odm_default'));
                    return $hydrator;
                },
                
                // Locale
                'OmelettesDoctrine\Service\LocalesService' => function ($sm) {
                    $service = new Service\LocalesService();
                    return $service;
                },
                
                // System Service
                'OmelettesDoctrine\Service\SystemService' => function ($sm) {
                    $service = new Service\SystemService($sm->get('doctrine.documentmanager.odm_default'));
                    return $service;
                },
            ),
        );
    }
    
    /**
     * If an event returns a response, the event manger is
     * short-ciruted and prevented from dispatching
     * (if the event occurs before dispatch)
     *
     * @param MvcEvent $ev
     * @param string $routeName
     * @return Response
     */
    protected function redirectToRoute(MvcEvent $ev, $routeName = 'login')
    {
        $routeUrl = $ev->getRouter()->assemble(array(), array('name' => $routeName));
        $response = $ev->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $ev->getRequest()->getBaseUrl() . $routeUrl);
        $response->setStatusCode('302');
        return $response;
    }
    
    /**
     * Adds a set-cookie header to the HTTP response
     * @param Response $response
     * @param string $name
     * @param string $value
     * @param string $expires
     * @param string $path
     * @param string $domain
     * @param string $secure
     * @param string $httponly
     * @param string $maxAge
     * @param string $version
     */
    protected function setCookie(
            Response $response,
            $name = null,
            $value = null,
            $expires = null,
            $path = null,
            $domain = null,
            $secure = false,
            $httponly = false,
            $maxAge = null,
            $version = null
    )
    {
        $setCookieHeader = new SetCookie(
                $name,
                $value,
                $expires,
                $path,
                $domain,
                $secure,
                $httponly,
                $maxAge,
                $version
        );
        $response->getHeaders()->addHeader($setCookieHeader);
    }
    
    public function onBootstrap(MvcEvent $ev)
    {
        $app = $ev->getParam('application');
        $eventManager = $app->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAuth'));
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAcl'));
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setDefaultTimezone'));
    }
    
    /**
     * Ensures all DateTime instances are created using the user's local timezone
     * @param MvcEvent $ev
     */
    public function setDefaultTimezone(MvcEvent $ev)
    {
        $app = $ev->getApplication();
        $sm = $app->getServiceManager();
        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
            $id = $auth->getIdentity();
            if ($id) {
                $prefs = $id->getPrefs();
                // System users have no preferences
                if ($prefs) {
                    date_default_timezone_set($prefs->getTz());
                }
            }
        }
    }
    
    public function checkAcl(MvcEvent $ev)
    {
        $request = $ev->getRequest();
        if ($request instanceof ConsoleRequest) {
            // Don't bother checking for console requests
            return;
        }
        
        $app = $ev->getApplication();
        $sm = $app->getServiceManager();
        $config = $sm->get('config');
        $acl = $sm->get('OmelettesDoctrine\Service\AclService');
        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        $flash = $sm->get('ControllerPluginManager')->get('flashMessenger');
        $session = new Container('Omelettes');
        
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
            $identity = $auth->getIdentity();
            if ($identity instanceof OmDoc\User) {
                $role = $identity->getAclRole();
            }
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
        
        // Does this route require the session to be password-authenticated?
        if (!$session->passwordAuthenticated) {
            if (isset($config['acl']['passworded'][$resource])) {
                // This route requires password-authentication
                $session->rememberedRoute = array(
                    'name'   => $resource,
                    'params' => $ev->getRouteMatch()->getParams(),
                );
                return $this->redirectToRoute($ev, 'verify-password');
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
        
        // Check we're not using the console
        $request = $ev->getRequest();
        if ($request instanceof ConsoleRequest) {
            // We're using the console
            $routeName = $ev->getRouteMatch()->getMatchedRouteName();
            if (in_array($routeName, array('doctrine_cli', 'db'))) {
                // We're using Doctrine or DB management commands, an auth identity is not needed 
                return;
            }
            $usersService = $sm->get('OmelettesDoctrine\Service\UsersService');
            $systemIdentity = $usersService->find('console');
            if (!$systemIdentity) {
                throw new \Exception('Expected system identity on route: ' . $routeName);
            }
            // Auth as system user
            $auth->getStorage()->write($systemIdentity);
            return;
        }
        
        // Is the user logged in?
        if ($auth->hasIdentity()) {
            // User is logged in, session is fresh
            return;
    
        } else {
            // HTTP request might provide cookie data
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
