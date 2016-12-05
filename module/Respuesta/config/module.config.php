<?php

namespace Respuesta;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'respuesta' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/respuesta[/:action[/:id_respuesta]]',
                        'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id_respuesta'     => '[0-9]+',
                        //'idp'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\RespuestaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'respuesta' => __DIR__ . '/../view',
        ],
    ],
];