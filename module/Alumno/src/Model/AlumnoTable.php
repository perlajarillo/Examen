<?php

namespace Alumno\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
//use Respuesta\Controller\RespuestaController;
use Zend\Db\Sql\Select;



class AlumnoTable
{
    private $tableGateway;



    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        
     
    }

    public function fetchAll()
    {
       
        return $this->tableGateway->select();
        
    }

     public function getExamenCompleto($id_examen)
    {
        $id_examen = (int) $id_examen;
       // $rowset = $this->tableGateway->select();
        //$sql    = new Sql($this->tableGateway);
        $select = new Select('examen');
       // $select->setIntegrityCheck(false);
        $select->where('id ='.$id_examen);
        $select->join(array('p'=>'pregunta'),
        'id = p.id_examen',
        array('textoP'=>'texto', 'id_pregunta'=>'id_pregunta'),
         Select::JOIN_INNER
        );
        $select->join(array('r'=>'respuesta'),
        'p.id_pregunta = r.id_pregunta',
        array('textoR'=>'texto', 'correcta'=>'correcta'),
         Select::JOIN_INNER
        );
        $rowset= $this->tableGateway->selectWith($select);
       
       
    return $rowset;
}
 public function getMateria($id_examen)
    {
        $id_examen = (int) $id_examen;
        $rowset = $this->tableGateway->select(['id' => $id_examen]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id_examen
            ));
        }

        return $row;
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


}