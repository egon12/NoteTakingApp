<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'Note\Controller\Note' => 'Note\Controller\NoteController',
        ),
    ),

    'router' => array(
        'routes' => array(

            'note' => array(
                'type' => 'Literal',
                'options' =>array(
                    'route' => '/note',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Note\Controller',
                        'controller'    => 'Note',
                        'action'        => 'index',
                    ),
                ),
            ),

            'noteSegment' => array(
                'type' => 'Segment',
                'options' =>array(
                    'route' => '/note[/][:action][/]',

                    'contsraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Note\Controller',
                        'controller'    => 'Note',
                        'action'        => 'index',
                    ),
                ),
            ),

            'noteEdit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/note/edit/[:id]',
                    'contsraints' => array(
                        'id'         => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Note\Controller',
                        'controller'    => 'Note',
                        'action'        => 'edit',
                    ),
                ),
            ),

            'noteDelete' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/note/delete/[:id]',
                    'contsraints' => array(
                        'id'         => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Note\Controller',
                        'controller'    => 'Note',
                        'action'        => 'delete',
                    ),
                ),
            ),

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
