<?php

// Omelettes module config
return array(
    'view_manager' => array(
        'template_map' => array(
            'flash-messenger'                      => __DIR__ . '/../view/partial/flash-messenger.phtml',
            'form/fieldset/when'                   => __DIR__ . '/../view/partial/form/horizontal/fieldset/when.phtml',
            'form/friendly'                        => __DIR__ . '/../view/partial/form/friendly.phtml',
            'form/friendly/element'                => __DIR__ . '/../view/partial/form/friendly/element.phtml',
            'form/friendly/fieldset'               => __DIR__ . '/../view/partial/form/friendly/fieldset.phtml',
            'form/friendly/group'                  => __DIR__ . '/../view/partial/form/friendly/group.phtml',
            'form/horizontal'                      => __DIR__ . '/../view/partial/form/horizontal.phtml',
            'form/horizontal/collection'           => __DIR__ . '/../view/partial/form/horizontal/collection.phtml',
            'form/horizontal/multitype-collection' => __DIR__ . '/../view/partial/form/horizontal/multitype-collection.phtml',
            'form/horizontal/element'              => __DIR__ . '/../view/partial/form/horizontal/element.phtml',
            'form/horizontal/fieldset'             => __DIR__ . '/../view/partial/form/horizontal/fieldset.phtml',
            'form/horizontal/group'                => __DIR__ . '/../view/partial/form/horizontal/group.phtml',
            'form/inline'                          => __DIR__ . '/../view/partial/form/inline.phtml',
            'form/inline/element'                  => __DIR__ . '/../view/partial/form/inline/element.phtml',
            'form/inline/fieldset'                 => __DIR__ . '/../view/partial/form/inline/fieldset.phtml',
            'form/inline/group'                    => __DIR__ . '/../view/partial/form/inline/group.phtml',
            'listify'                              => __DIR__ . '/../view/partial/listify.phtml',
            'tabulate'                             => __DIR__ . '/../view/partial/tabulate.phtml',
            'paginate'                             => __DIR__ . '/../view/partial/paginate.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'view_helpers' => array(
        'invokables' => array(
            'listify'    => 'Omelettes\Listify\View\Helper\Listify',
            'tabulate'   => 'Omelettes\Tabulate\View\Helper\Tabulate',
            'prettyText' => 'Omelettes\View\Helper\PrettyText',
            'prettyTime' => 'Omelettes\View\Helper\PrettyTime',
        ),
    ),
);
