<?php

// Tactile module config
return array(
    'acl' => array(
        'resources' => array(
            'user' => array(
                'dash' => array(),
                'contacts' => array(),
                'user' => array(),
            ),
        ),
        'passworded' => array(
            'user' => array(),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Tactile\Controller\Dash'     => 'Tactile\Controller\DashboardController',
            'Tactile\Controller\Contacts' => 'Tactile\Controller\ContactsController',
            'Tactile\Controller\User'     => 'Tactile\Controller\UserController',
        ),
    ),
    
    'doctrine' => array(
        'driver' => array(
            'tactile_documents' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Tactile/Document'),
            ),
    
            'odm_default' => array(
                'drivers' => array(
                    'Tactile\Document' => 'tactile_documents',
                ),
            ),
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Contacts',
                'route' => 'contacts',
            ),
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'dash' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/dash',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Dash',
                        'action'     => 'dashboard',
                    ),
                ),
            ),

            'contacts' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/contacts[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Contacts',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            'user' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/user[/:action]',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\User',
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
            'html/head'                   => __DIR__ . '/../view/partial/html/head.phtml',
            'navigation/navbar-fixed-top' => __DIR__ . '/../view/partial/navigation/navbar-fixed-top.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
