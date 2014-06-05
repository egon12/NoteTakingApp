<?php

return array(
    'modules' => array(
        "Application", 
        "ZfcUser",
        "Note"
    ),

    'module_listener_options' => array(
        'config_glob_paths' => array(
            '../../../config/autoload/{,*.}{global,local}.php'
        ),
        'module_paths' => array(
            'module',
            'vendor'
        )
    ),

    'service_manager' => array(
        'factories' => array(
            'DbAdapterTest' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
