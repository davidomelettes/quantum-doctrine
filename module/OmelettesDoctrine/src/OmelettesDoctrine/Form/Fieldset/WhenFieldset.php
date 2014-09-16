<?php

namespace OmelettesDoctrine\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Document as OmDoc;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class WhenFieldset extends Fieldset implements InputFilterAwareInterface, ViewPartialInterface
{
    /**
     * @var boolean
     */
    protected $required = false;

    /**
     * @var InputFilter
     */
    protected $inputFilter;

    public function __construct($name, $label, $required = false)
    {
        parent::__construct($name, array());
        $this->setAttribute('class', 'when');
        $this->required = (boolean) $required;

        $this->add(array(
            'name'		=> 'date',
            'type'		=> 'Date',
            'required'	=> $this->required,
            'options'	=> array(
                'label'		    => $label,
            ),
            'attributes'=> array(
                //'id'			=> $this->getName() .'-date',
            ),
        ));

        $this->add(array(
            'name'		=> 'time',
            'type'		=> 'Time',
            'required'  => false,
            'options'	=> array(
            ),
            'attributes'=> array(
                //'id'			=> $this->getName() .'-time',
            ),
        ));

    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/when';
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $format = 'Y-m-d';
            $inputFilter->add(array(
                'name'			=> 'date',
                'required'      => $this->required,
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                    array(
                        'name'    => 'Omelettes\Filter\DateStringToIso8601',
                        'options' => array(
                            'format' => $format,
                        ),
                    ),
                ),
                'validators'	=> array(
                    array(
                        'name'		=> 'StringLength',
                        'options'	=> array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 1,
                            'max'		=> 255,
                        ),
                    ),
                    array(
                        'name'		=> 'Date',
                        'options'	=> array(
                            'format'    => $format,
                            'messages' => array(
                                \Zend\Validator\Date::INVALID_DATE => sprintf("The input does not appear to be a valid date of format '%s'", $format),
                            ),
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'			=> 'time',
                'required'      => false,
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                ),
                'validators'	=> array(
                    array(
                        'name'		=> 'StringLength',
                        'options'	=> array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 1,
                            'max'		=> 255,
                        ),
                    ),
                    array(
                        'name'		=> 'Date',
                        'options'	=> array(
                            'format'    => 'H:i',
                            'messages' => array(
                                \Zend\Validator\Date::INVALID_DATE => "The input does not appear to be a valid time of format 'HH:MM'",
                            ),
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Method not used');
    }

}
