<?php

use OmelettesDoctrine\Document as OmDoc;

// OmelettesDoctrine module config
return array(
    'acl' => array(
        'roles' => array(
            'guest' => array(),
            'user' => array('guest'),
            'admin' => array('user'),
            'super' => array('admin'),
            'system' => array('super'),
        ),
        'resources' => array(
            'system' => array(
                'build' => array(),
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
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Console\Controller\Assets' => 'OmelettesDoctrine\Controller\ConsoleAssetsController',
        ),
    ),
    'doctrine' => array(
        'authentication' => array(
            'odm_default' => array(
                'identityClass'      => 'OmelettesDoctrine\Document\User',
                'identityProperty'   => 'emailAddress',
                'credentialProperty' => 'passwordHash',
                'credentialCallable' => function (OmDoc\User $user, $plaintext) {
                    return $user->hashPassword($plaintext);
                },
            ),
        ),
        
        'driver' => array(
            'omelettes_documents' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/OmelettesDoctrine/Document'),
            ),
            
            'odm_default' => array(
                'drivers' => array(
                    'OmelettesDoctrine\Document' => 'omelettes_documents',
                ),
            ),
        ),
    ),
    
    'service_manager' => array(
        'aliases' => array(
        ),
    ),
    
    'view_helpers'	=> array(
        'invokables'	=> array(
            'aclAllows' => 'OmelettesDoctrine\View\Helper\AclAllows',
        ),
    ),
);
