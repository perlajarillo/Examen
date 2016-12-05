<?php

namespace Alumno\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Alumno implements InputFilterAwareInterface
{
    public $id;
    public $materia;
    public $pregunta;
    public $textoP;
    public $id_examen;
    public $textoR;
    public $correcta;
   
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->materia    = !empty($data['materia']) ? $data['materia'] : null;
        $this->pregunta    = !empty($data['pregunta']) ? $data['pregunta'] : null;
        $this->textoP    = !empty($data['textoP']) ? $data['textoP'] : null;
        $this->textoR    = !empty($data['textoR']) ? $data['textoR'] : null;
        $this->id_examen    = !empty($data['id_examen']) ? $data['id_examen'] : null;
        $this->correcta    = !empty($data['correcta']) ? $data['correcta'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'materia' => $this->materia,
            'pregunta' => $this->pregunta,
            'textoP' => $this->textoP,
            'id_examen' => $this->id_examen,
            'correcta' => $this->correcta,
             ];
    }

   public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id_examen',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

           $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'materia',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

             $inputFilter->add([
            'name' => 'textoR',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);


             $inputFilter->add([
            'name' => 'textoP',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'id_respuesta',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'id_pregunta',
            'required' => true,
           //'value' =>$this->params()->fromRoute('id_respuesta', 0),
             'filters' => [
             ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'pregunta',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}