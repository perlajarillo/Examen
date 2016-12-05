<?php

namespace Alumno;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'alumno' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/alumno[/:action[/:id_examen]]',
                        'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id_examen'     => '[0-9]+',
                        //'idp'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlumnoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'alumno' => __DIR__ . '/../view',
        ],
    ],
];