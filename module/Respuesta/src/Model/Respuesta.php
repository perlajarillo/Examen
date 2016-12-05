<?php

namespace Respuesta\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Respuesta implements InputFilterAwareInterface
{
    public $id_respuesta;
    public $id_pregunta;
    public $texto;
    public $correcta;
   
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id_respuesta     = !empty($data['id_respuesta']) ? $data['id_respuesta'] : null;
        $this->id_pregunta     = !empty($data['id_pregunta']) ? $data['id_pregunta'] : null;
        $this->texto = !empty($data['texto']) ? $data['texto'] : null;
        $this->correcta = !empty($data['correcta']) ? $data['correcta'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id_pregunta' => $this->id_pregunta,
            'id_respuesta' => $this->id_respuesta,
            'texto' => $this->texto,
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
            'name' => 'texto',
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
            'name' => 'correcta',
            'required' => false,
        ]);
        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}