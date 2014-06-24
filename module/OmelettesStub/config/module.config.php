<?php

// OmelettesStub module config
return array(
    'controllers' => array(
        'invokables' => array(
            'Stub\Controller\Auth' => 'OmelettesStub\Controller\AuthController',
            'Stub\Controller\Stub' => 'OmelettesStub\Controller\StubController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'front' => array(
                'type'		=> 'Literal',
                'options'	=> array(
                    'route'			=> '/',
                    'defaults'		=> array(
                        'controller'	=> 'Stub\Controller\Stub',
                        'action'		=> 'hello-world',
                    ),
                ),
            ),
            
            'login' => array(
                'type'		=> 'Literal',
                'options'	=> array(
                    'route'			=> '/login',
                    'defaults'		=> array(
                        'controller'	=> 'Stub\Controller\Auth',
                        'action'		=> 'login',
                    ),
                ),
            ),
            
            'logout' => array(
                'type'		=> 'Literal',
                'options'	=> array(
                    'route'			=> '/logout',
                    'defaults'		=> array(
                        'controller'	=> 'Stub\Controller\Auth',
                        'action'		=> 'logout',
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
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
