<?php

namespace Pregunta\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

class PreguntaTable
{
    private $tableGateway;


    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($id_examen)
    {
        $id_examen = (int) $id_examen;
     //   return $this->tableGateway->select();

  // return $this->tableGateway->select((array('id_examen' => $id_pregunta)));
        
        
        return $this->tableGateway->select(['id_examen' => $id_examen]);
       /* return $this->tableGateway->select(function(Select $select, $id_examen = $id_pregunta) {
            
            $select->where(array('id_examen' => $id_examen)); 
            });*/
    
    }


    public function getPregunta($id_pregunta)
    {
        $id_pregunta = (int) $id_pregunta;

        $rowset = $this->tableGateway->select(['id_pregunta' => $id_pregunta]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id_pregunta
            ));
        }
        return $row;
    }

     public function getExamen($id_pregunta)
    {
        $id_pregunta = (int) $id_pregunta;
        //$rowset = $this->tableGateway->select->columns(['id_examen'])->where(['id_pregunta' => $id_pregunta]);
        
        $rowset = $this->tableGateway->select(['id_pregunta' => $id_pregunta]);
        $row = $rowset->current();
         if (! $row) {
            throw new RuntimeException(sprintf(
                'No hay examenes relacionados para la pregunta: %d',
                $id_pregunta
            ));
        }
        return $row->id_examen;
       // return 2;
    }

    public function savePregunta(Pregunta $pregunta)
    {
        $data = [
            'texto' => $pregunta->texto,
            'id_examen'=> $pregunta->id_examen
        ];

        $id_pregunta = (int) $pregunta->id_pregunta;

        if ($id_pregunta === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getPregunta($id_pregunta)) {
            throw new RuntimeException(sprintf(
                 'Cannot update question with identifier %d; does not exist',
                $id_pregunta
            ));
        }

        $this->tableGateway->update($data, ['id_pregunta' => $id_pregunta]);
    }

    public function deletePregunta($id_pregunta)
    {
        $this->tableGateway->delete(['id_pregunta' => (int) $id_pregunta]);
    }
    
}