<?php

// OmelettesStub module config
return array(
    'controllers' => array(
        'invokables' => array(
            'Stub\Controller\Auth'   => 'OmelettesStub\Controller\AuthController',
            'Stub\Controller\Stub'   => 'OmelettesStub\Controller\StubController',
            'Stub\Controller\Signup' => 'OmelettesStub\Controller\SignupController',
            'Stub\Controller\User'   => 'OmelettesStub\Controller\UserController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'front' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Stub\Controller\Stub',
                        'action'     => 'hello-world',
                    ),
                ),
            ),
            
            'signup' => array(
                'type'	  => 'Literal',
                'options' => array(
                    'route'    => '/signup',
                    'defaults' => array(
                        'controller' => 'Stub\Controller\Signup',
                        'action'     => 'signup',
                    ),
                ),
            ),
            
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'			=> '/login',
                    'defaults'		=> array(
                        'controller'	=> 'Stub\Controller\Auth',
                        'action'		=> 'login',
                    ),
                ),
            ),
            
            'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'			=> '/logout',
                    'defaults'		=> array(
                        'controller' => 'Stub\Controller\Auth',
                        'action'     => 'logout',
                    ),
                ),
            ),
            
            'forgot-password' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/forgot-password',
                    'defaults' => array(
                        'controller' => 'Stub\Controller\Auth',
                        'action'     => 'forgot-password',
                    ),
                ),
            ),
            
            'reset-password' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/reset-password/:user/:secret',
                    'defaults' => array(
                        'controller' => 'Stub\Controller\Auth',
                        'action'     => 'reset-password',
                    ),
                    'constraints'	=> array(
                        'user'   => \Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
                        'secret' => \Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
                    ),
                ),
            ),
            
            'user' => array(
            'type' => 'Segment',
                'options' => array(
                    'route'    => '/user/:action',
                    'defaults' => array(
                        'controller' => 'Stub\Controller\User',
                        'action'     => 'preferences',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'doctype'					=> 'HTML5',
        'display_not_found_reason'	=> true,
        'display_exceptions'		=> true,
        'not_found_template'		=> 'error/404',
        'exception_template'		=> 'error/index',
        'template_map' => array(
            'mail/text/password-reset'	=> __DIR__ . '/../view/mail/text/password-reset.phtml',
            'mail/html/password-reset'	=> __DIR__ . '/../view/mail/html/password-reset.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
