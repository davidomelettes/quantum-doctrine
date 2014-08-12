<?php

// TactileAdmin module config
return array(
    'acl' => array(
        'resources' => array(
            'admin' => array(
                'admin' => array(),
                'admin/account' => array(),
                'admin/resources' => array(),
                'admin/users' => array(),
            ),
        ),
        'passworded' => array(
            'admin' => array(),
            'admin/account' => array(),
            'admin/resources' => array(),
            'admin/users' => array(),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Account'   => 'TactileAdmin\Controller\AccountController',
            'Admin\Controller\Resources' => 'TactileAdmin\Controller\ResourcesController',
            'Admin\Controller\Users'     => 'TactileAdmin\Controller\UsersController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Account',
                        'action'     => 'info',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'account' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/account[/:action]',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Account',
                                'action'     => 'info',
                            ),
                        ),
                    ),
                    'users' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/users[/:action][/:key]',
                            'constraints' => array(
                                'key'        => Omelettes\Validator\Uuid::UUID_REGEX_PATTERN,
                            ),
                            'defaults'    => array(
                                'controller' => 'Admin\Controller\Users',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'resources' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/resources[/:action][/:resource_name]',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Resources',
                                'action'     => 'index',
                            ),
                        ),
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
