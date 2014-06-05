<?php

return array(
    'bjyauthorize' => array(

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',

        // ZfcUserIdentity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',

        // get all roles
        'role_providers' => array(

            // this will load roles from the user_role table in a database
            // format: user_role(role_id(varchar), parent(varchar))
            'BjyAuthorize\Provider\Role\ZendDb' => array(
                'table'                 => 'user_role',
                'identifier_field_name' => 'id',
                'role_id_field'         => 'role_id',
                'parent_role_field'     => 'parent_id',
            ),

        ),

        // ok the real guards
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'Application\Controller\Index', 'roles' => array('user', 'guest')),
                array('controller' => 'zfcuser', 'roles' => array('user', 'guest')),
                array('controller' => 'Note\Controller\Note', 'roles' => array('user')),
            ),
        ),
    ),
);
