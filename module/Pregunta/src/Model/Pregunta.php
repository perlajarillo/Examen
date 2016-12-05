<?php

namespace Pregunta\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Pregunta implements InputFilterAwareInterface
{
    public $id_pregunta;
    public $id_examen;
    public $texto;
   
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id_pregunta     = !empty($data['id_pregunta']) ? $data['id_pregunta'] : null;
        $this->id_examen     = !empty($data['id_examen']) ? $data['id_examen'] : null;
        $this->texto = !empty($data['texto']) ? $data['texto'] : null;
        
    }

    public function getArrayCopy()
    {
        return [
            'id_pregunta' => $this->id_pregunta,
            'id_examen' => $this->id_examen,
            'texto' => $this->texto,
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
            'name' => 'id_pregunta',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'id_examen',
            'required' => true,
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

        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}