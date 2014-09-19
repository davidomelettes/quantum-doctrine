<?php

// TactileSignup module config
return array(
    'acl' => array(
        'resources' => array(
            'guest' => array(
                'front' => array(),
                'signup' => array(),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Signup\Controller\Pages'   => 'TactileSignup\Controller\PagesController',
            'Signup\Controller\Signup'   => 'TactileSignup\Controller\SignupController',
        ),
    ),
    
    'layout' => array(
        'front' => 'layout/front',
        'signup' => 'layout/signup',
    ),
    
    'router' => array(
        'routes' => array(
            'front' => array(
                'type'	  => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Signup\Controller\Pages',
                        'action'     => 'front',
                    ),
                ),
            ),
            'signup' => array(
                'type'	  => 'Literal',
                'options' => array(
                    'route'    => '/signup',
                    'defaults' => array(
                        'controller' => 'Signup\Controller\Signup',
                        'action'     => 'signup',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
