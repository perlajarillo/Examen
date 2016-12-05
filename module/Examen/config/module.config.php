<?php

namespace Examen;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'examen' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/examen[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ExamenController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'examen' => __DIR__ . '/../view',
        ],
    ],
];