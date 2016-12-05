<?php

namespace Respuesta;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
//use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Respuesta\Model\RespuestaTable;

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
                Model\RespuestaTable::class => function($container) {
                    $tableGateway = $container->get(Model\RespuestaTableGateway::class);
                    return new Model\RespuestaTable($tableGateway);
                },
                Model\RespuestaTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Respuesta());
                    return new TableGateway('respuesta', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\RespuestaController::class => function($container) {
                    return new Controller\RespuestaController(
                        $container->get(Model\RespuestaTable::class)
                    );
                },
            ],
        ];
    }
}