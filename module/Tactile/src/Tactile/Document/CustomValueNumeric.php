<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\EmbeddedDocument
 */
class CustomValueNumeric extends CustomValue
{
    /**
     * @var int
     * @ODM\Int
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
        return 'n';
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
                        'name'		=> 'Int',
                        'options'	=> array(
                        ),
                    ),
                ),
            ));
    
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
}