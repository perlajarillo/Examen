<?php

namespace Pregunta;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
//use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Pregunta\Model\PreguntaTable;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\PreguntaTable::class => function($container) {
                    $tableGateway = $container->get(Model\PreguntaTableGateway::class);
                    return new Model\PreguntaTable($tableGateway);
                },
                Model\PreguntaTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Pregunta());
                    return new TableGateway('pregunta', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\PreguntaController::class => function($container) {
                    return new Controller\PreguntaController(
                        $container->get(Model\PreguntaTable::class)
                    );
                },
            ],
        ];
    }
}