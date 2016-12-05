<?php

namespace Alumno;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
//use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Alumno\Model\AlumnoTable;

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
                Model\AlumnoTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlumnoTableGateway::class);
                    return new Model\AlumnoTable($tableGateway);
                },
                Model\AlumnoTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Alumno());
                    return new TableGateway('examen', $dbAdapter, null, $resultSetPrototype);
                },


            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlumnoController::class => function($container) {
                    return new Controller\AlumnoController(
                        $container->get(Model\AlumnoTable::class)
                    );


                }, 
          /*     Controller\PreguntaController::class => function($container) {
                    return new Controller\PreguntaController(
                        $container->get(Model\PreguntaTable::class)
                    );

                },  */  
            ],
        ];
    }
}