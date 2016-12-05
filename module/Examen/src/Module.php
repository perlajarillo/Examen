<?php

namespace Examen;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
//use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Examen\Model\ExamenTable;

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
                Model\ExamenTable::class => function($container) {
                    $tableGateway = $container->get(Model\ExamenTableGateway::class);
                    return new Model\ExamenTable($tableGateway);
                },
                Model\ExamenTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Examen());
                    return new TableGateway('examen', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ExamenController::class => function($container) {
                    return new Controller\ExamenController(
                        $container->get(Model\ExamenTable::class)
                    );
                },
            ],
        ];
    }
}