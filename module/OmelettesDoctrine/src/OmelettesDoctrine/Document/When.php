<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\EmbeddedDocument
 */
class When implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var \DateTime
     * @ODM\Date
     * @ODM\Index
     */
    protected $date;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $time;
    
    /**
     * @var boolean
     */
    protected $required = false;
    
    /**
     * @var InputFilter\InputFilter
     */
    protected $inputFilter;
    
    public function setDate(\DateTime $date)
    {
        if (null !== $this->time) {
            $date->modify('' == $this->time ? '00:00' : $this->time);
        }
        $this->date = $date;
        return $this;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setTime($time)
    {
        if ($this->date instanceof \DateTime) {
            $this->date->modify('' == $time ? '00:00' : $time);
        }
        $this->time = $time;
        return $this;
    }
    
    public function getTime()
    {
        if (empty($this->time)) {
            return null;
        }
        return $this->date->format('H:i');
    }
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Interface method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter\InputFilter();
            
            $format = 'Y-m-d';
            $inputFilter->add(array(
                'name'			=> 'date',
                'required'      => false,
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
    
    public function setRequired($required)
    {
        $required = (boolean) $required;
        $filter = $this->getInputFilter();
        $filter->get('date')->setRequired($required);
        return $this;
    }
    
}