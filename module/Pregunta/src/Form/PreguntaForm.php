<?php

namespace Pregunta\Form;

use Zend\Form\Form;

class PreguntaForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('pregunta');

        //$this->setAttribute('method', 'GET'); // Default is POST

        $this->add([
            'name' => 'id_pregunta',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'id_examen',
            'type' => 'hidden',
        ]);


        $this->add([
            'name' => 'texto',
            'type' => 'text',
            'options' => [
                'label' => 'Texto de la pregunta',
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