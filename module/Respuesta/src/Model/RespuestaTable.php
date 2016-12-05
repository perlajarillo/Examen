<?php

namespace Respuesta\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;


class RespuestaTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
  
    }

    public function fetchAll($id_pregunta)
    {
         $id_pregunta = (int) $id_pregunta;

        //return $this->tableGateway->select();
        return $this->tableGateway->select(['id_pregunta' => $id_pregunta]);

    }

    public function getAsociadas($id_respuesta)
    {
        $id_respuesta = (int) $id_respuesta;

        return toArray($this->tableGateway->select(['id_pregunta' => $id_respuesta]));

    }

    public function getRespuesta($id_respuesta)
    {
        $id_respuesta = (int) $id_respuesta;
        $rowset = $this->tableGateway->select(['id_respuesta' => $id_respuesta]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id_respuesta
            ));
        }

        return $row;
    }

    public function getPregunta($id_respuesta)
    {
        $id_respuesta = (int) $id_respuesta;       
        $rowset = $this->tableGateway->select(['id_respuesta' => $id_respuesta]);
        $row = $rowset->current();
         if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id_respuesta
            ));
        }
        return $row->id_pregunta;
    }

    public function saveRespuesta(Respuesta $respuesta)
    {
      
        $data = [
            'texto' => $respuesta->texto,
            'correcta'=> $respuesta->correcta,
            'id_pregunta'=> $respuesta->id_pregunta,
        ];

        $id_respuesta = (int) $respuesta->id_respuesta;

        if ($id_respuesta === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getRespuesta($id_respuesta)) {
            throw new RuntimeException(sprintf(
                 'No se puede guardar la respuesta %d; no existe',
                $id_respuesta
            ));
        }

        $this->tableGateway->update($data, ['id_respuesta' => $id_respuesta]);
    }

    public function deleteRespuesta($id_respuesta)
    {
        $this->tableGateway->delete(['id_respuesta' => (int) $id_respuesta]);
    }
    
}