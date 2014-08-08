<?php

// Tactile module config
return array(
    'acl' => array(
        'resources' => array(
            'user' => array(
                'dash' => array(),
                'contacts' => array(),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Tactile\Controller\Dash'     => 'Tactile\Controller\DashboardController',
            'Tactile\Controller\Contacts' => 'Tactile\Controller\ContactsController',
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
                    'route'    => '/contacts',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Contacts',
                        'action'     => 'index',
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
