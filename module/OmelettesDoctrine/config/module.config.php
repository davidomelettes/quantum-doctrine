<?php

use OmelettesDoctrine\Document as OmDoc;

// OmelettesDoctrine module config
return array(
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
            'application_documents' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/OmelettesDoctrine/Document'),
            ),
            
            'odm_default' => array(
                'drivers' => array(
                    'OmelettesDoctrine\Document' => 'application_documents',
                ),
            ),
        ),
    ),
    
    'service_manager' => array(
        'aliases' => array(
        ),
    ),
);
