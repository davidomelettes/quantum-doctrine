<?php

// Omelettes module config
return array(
    'view_manager' => array(
        'template_map' => array(
            'flash-messenger'                => __DIR__ . '/../view/partial/flash-messenger.phtml',
            'form/friendly'                  => __DIR__ . '/../view/partial/form/friendly.phtml',
            'form/horizontal'                => __DIR__ . '/../view/partial/form/horizontal.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
