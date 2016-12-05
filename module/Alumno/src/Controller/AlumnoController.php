<?php

namespace Alumno\Controller;

use Alumno\Form\AlumnoForm;
use Alumno\Model\Alumno;
use Alumno\Model\AlumnoTable;
//use Respuesta\Model\RespuestaTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlumnoController extends AbstractActionController
{
    // Add this property:
    private $table;
  //  private $tablePregunta;
  //  private $tableRespuesta;

    // Add this constructor:
    public function __construct(AlumnoTable $table)
    { 
        $this->table = $table;
      //  $this->tablePregunta = $tablePregunta;

    }

    public function indexAction()
    {
        
        return new ViewModel([
            'examenes' => $this->table->fetchAll(),
        ]);
    }



    public function editAction()
    {
        $id_examen = (int) $this->params()->fromRoute('id_examen', 0);      
        return new ViewModel([
            'examenesC' => $this->table->getExamenCompleto($id_examen),

        ]);
        
    }

      public function gradeAction()
    {
        
        $n=$_GET['n'];
        $suma=0;
        for ($i=1; $i<=$n;$i++)
        {
            if($_GET[$i]==1)
                $suma++;
        }
        $promedio=($suma/$n)*100; 
       return ['promedio'    => $promedio];
    }


}
