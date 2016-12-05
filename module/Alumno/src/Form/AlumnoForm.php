<?php

namespace Alumno\Form;

use Zend\Form\Form;

class AlumnoForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Alumno');

        //$this->setAttribute('method', 'GET'); // Default is POST

        $this->add([
            'name' => 'id_examen',
            'type' => 'hidden',
         
        ]);

          $this->add([
            'name' => 'id_pregunta',
            'type' => 'hidden',
         
        ]);

        $this->add([
            'name' => 'id_respuesta',
            'type' => 'hidden',
         
        ]);
        $this->add([
            'name' => 'materia',
            'type' => 'text',
            'options' => [
                'label' => 'Materia',
            ],
        ]);


        $this->add([
            'name' => 'textoP',
            'type' => 'text',
            'options' => [
                'label' => 'Texto de la pregunta',
            ],
        ]);

        $this->add([
            'name' => 'textoR',
            'type' => 'text',
            'options' => [
                'label' => 'Texto de la respuesta',
            ],
        ]);



        $this->add([
            'name' => 'opt',
            'type' => 'radio',
            //'options' => [
             //   'label' => 'Marcar como correcta',
          //  ],
        ]);



        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}