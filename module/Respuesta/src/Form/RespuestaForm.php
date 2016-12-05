<?php

namespace Respuesta\Form;

use Zend\Form\Form;

class RespuestaForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Respuesta');

        //$this->setAttribute('method', 'GET'); // Default is POST

        $this->add([
            'name' => 'id_respuesta',
            'type' => 'hidden',
         
        ]);

        $this->add([
            'name' => 'id_pregunta',
            'type' => 'text',
           'options' => [
                'label' => 'Con qué pregunta se relaciona',
                ]
        ]);

        $this->add([
            'name' => 'texto',
            'type' => 'text',
            'options' => [
                'label' => 'Texto de la respuesta',
            ],
        ]);

        $this->add([
            'name' => 'correcta',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Marcar como correcta',
            ],
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