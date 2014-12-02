<?php

// TactileAdmin module config
return array(
    'acl' => array(
        'resources' => array(
            'admin' => array(
                'admin' => array(),
                'admin/account' => array(),
                'admin/resources' => array(),
                'admin/resources/id' => array(),
                'admin/resources/noid' => array(),
                'admin/users' => array(),
            ),
        ),
        'passworded' => array(
            'admin' => array(),
            'admin/account' => array(),
            'admin/resources' => array(),
            'admin/resources/id' => array(),
            'admin/resources/noid' => array(),
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
                            'route'    => '/resources',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Resources',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'noid' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'       => '/:action[/:extra]',
                                    'constraints' => array(
                                        'action' => '[a-z][a-z0-9_-]{1,30}',
                                    ),
                                    'defaults'    => array(
                                        'action'     => 'view',
                                    ),
                                ),
                            ),
                            'id' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'       => '/:id[/:action]',
                                    'constraints' => array(
                                        'id'     => '[a-z0-9]{32}',
                                        'action' => '[a-z][a-z0-9_-]+',
                                    ),
                                    'defaults'    => array(
                                        'action'     => 'view',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'form/fieldset/custom-field'                => __DIR__ . '/../view/partial/form/horizontal/fieldset/custom-field.phtml',
            'form/fieldset/custom-field-options'        => __DIR__ . '/../view/partial/form/horizontal/fieldset/custom-field-options.phtml',
            'form/fieldset/custom-field-options-option' => __DIR__ . '/../view/partial/form/horizontal/fieldset/custom-field-options-option.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
