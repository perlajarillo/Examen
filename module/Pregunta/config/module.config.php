<?php

namespace Pregunta;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'pregunta' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/pregunta[/:action[/:id_pregunta]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id_pregunta'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\PreguntaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'pregunta' => __DIR__ . '/../view',
        ],
    ],
];