<?php

// TactileAuth module config
return array(
    'acl' => array(
        'resources' => array(
            'guest' => array(
                'login' => array(),
                'logout' => array(),
                'forgot-password' => array(),
                'reset-password' => array(),
            ),
            'user' => array(
                'verify-password' => array(),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Tactile\Controller\Auth'   => 'TactileAuth\Controller\AuthController',
        ),
    ),
    
    'layout' => array(
        'login' => 'layout/front',
        'forgot-password' => 'layout/front',
        'reset-password' => 'layout/front',
    ),
    
    'router' => array(
        'routes' => array(
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'			=> '/login',
                    'defaults'		=> array(
                        'controller'	=> 'Tactile\Controller\Auth',
                        'action'		=> 'login',
                    ),
                ),
            ),
            
            'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'			=> '/logout',
                    'defaults'		=> array(
                        'controller' => 'Tactile\Controller\Auth',
                        'action'     => 'logout',
                    ),
                ),
            ),
            
            'forgot-password' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/forgot-password',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Auth',
                        'action'     => 'forgot-password',
                    ),
                ),
            ),
            
            'reset-password' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/reset-password/:user/:secret',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Auth',
                        'action'     => 'reset-password',
                    ),
                    'constraints'	=> array(
                        'user'   => \Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
                        'secret' => \Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
                    ),
                ),
            ),
            
            'verify-password' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/verify-password',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Auth',
                        'action'     => 'verify-password',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'mail/text/password-reset'	=> __DIR__ . '/../view/mail/text/password-reset.phtml',
            'mail/html/password-reset'	=> __DIR__ . '/../view/mail/html/password-reset.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
