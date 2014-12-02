<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\EmbeddedDocument
 */
class CustomValueText extends CustomValue
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $value;
    
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function getType()
    {
        return 't';
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();
    
            $inputFilter->add(array(
                'name'     => 'value',
                'required' => true,
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
                ),
            ));
    
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
}