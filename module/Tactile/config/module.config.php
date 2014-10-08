<?php

// Tactile module config
return array(
    'acl' => array(
        'resources' => array(
            'user' => array(
                'activities' => array(),
                'dash' => array(),
                'contacts' => array(),
                'opportunities' => array(),
                'user' => array(),
            ),
        ),
        'passworded' => array(
            'user' => array(),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Tactile\Controller\Activities'    => 'Tactile\Controller\ActivitiesController',
            'Tactile\Controller\Dash'          => 'Tactile\Controller\DashboardController',
            'Tactile\Controller\Contacts'      => 'Tactile\Controller\ContactsController',
            'Tactile\Controller\Opportunities' => 'Tactile\Controller\OpportunitiesController',
            'Tactile\Controller\User'          => 'Tactile\Controller\UserController',
            'Tactile\Controller\Users'         => 'Tactile\Controller\UsersController',
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
            array(
                'label' => 'Opportunities',
                'route' => 'opportunities',
            ),
            array(
                'label' => 'Activities',
                'route' => 'activities',
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

            'activities' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/activities[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Activities',
                        'action'     => 'index',
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
            
            'opportunities' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/opportunities[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Opportunities',
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
            
            'users' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/users[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Tactile\Controller\Users',
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
            'form/fieldset/address'        => __DIR__ . '/../view/partial/form/horizontal/fieldset/address.phtml',
            'form/fieldset/contact-method' => __DIR__ . '/../view/partial/form/horizontal/fieldset/contact-method.phtml',
            'form/note'                    => __DIR__ . '/../view/partial/form/note.phtml',
            'html/head'                    => __DIR__ . '/../view/partial/html/head.phtml',
            'listable/address'             => __DIR__ . '/../view/partial/listable/address.phtml',
            'listable/contact-method'      => __DIR__ . '/../view/partial/listable/contact-method.phtml',
            'listable/note'                => __DIR__ . '/../view/partial/listable/note.phtml',
            'navigation/navbar-fixed-top'  => __DIR__ . '/../view/partial/navigation/navbar-fixed-top.phtml',
            'tabulate/contact'             => __DIR__ . '/../view/partial/tabulate/contact.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
