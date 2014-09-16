<?php

// Omelettes module config
return array(
    'view_manager' => array(
        'template_map' => array(
            'flash-messenger'    => __DIR__ . '/../view/partial/flash-messenger.phtml',
            'form/fieldset/when' => __DIR__ . '/../view/partial/form/horizontal/fieldset/when.phtml',
            'form/friendly'      => __DIR__ . '/../view/partial/form/friendly.phtml',
            'form/horizontal'    => __DIR__ . '/../view/partial/form/horizontal.phtml',
            'tabulate'           => __DIR__ . '/../view/partial/tabulate.phtml',
            'paginate'           => __DIR__ . '/../view/partial/paginate.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'view_helpers' => array(
        'invokables' => array(
            'formDateTimeCompatible' => 'Omelettes\Form\View\Helper\FormDateTimeCompatible',
            'tabulate'   => 'Omelettes\View\Helper\Tabulate',
            'prettyTime' => 'Omelettes\View\Helper\PrettyTime'
        ),
    ),
);
