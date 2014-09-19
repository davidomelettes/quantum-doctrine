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
    ),
    'doctrine' => array(
        'authentication' => array(
            'odm_default' => array(
                'identityClass'      => 'OmelettesDoctrine\Document\User',
                'identityProperty'   => 'email',
                'credentialProperty' => 'pwHash',
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
            'aclAllows'  => 'OmelettesDoctrine\View\Helper\AclAllows',
            'prettyUser' => 'OmelettesDoctrine\View\Helper\PrettyUser',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'form/fieldset/when' => __DIR__ . '/../view/partial/form/horizontal/fieldset/when.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
