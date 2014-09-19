<?php

use OmelettesDoctrine\Document as OmDoc;

// OmelettesDoctrine module config
return array(
    'acl' => array(
        'resources' => array(
            'system' => array(
                //'build' => array(),
                //'db' => array(),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'build' => array(
                    'options' => array(
                        'route' => 'build <assets>',
                        'defaults' => array(
                            'controller' => 'Console\Controller\Assets',
                            'action' => 'build',
                        ),
                    ),
                ),
                'db' => array(
                    'options' => array(
                        'route' => 'db <action>',
                        'defaults' => array(
                            'controller' => 'Console\Controller\Db',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Console\Controller\Assets' => 'OmelettesDoctrineDeveloper\Controller\ConsoleAssetsController',
            'Console\Controller\Db'     => 'OmelettesDoctrineDeveloper\Controller\ConsoleDbController',
        ),
    ),
);
