<?php

namespace Examen\Form;

use Zend\Form\Form;

class ExamenForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('examen');

        //$this->setAttribute('method', 'GET'); // Default is POST

        $this->add([
            'name' => 'id',
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
            'name' => 'unidad',
            'type' => 'text',
            'options' => [
                'label' => 'Unidad',
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