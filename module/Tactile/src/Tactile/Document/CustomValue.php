<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;
use Zend\InputFilter;

/**
 * @ODM\MappedSuperclass
 */
abstract class CustomValue implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $name;
    
    /**
     * @var InputFilter\InputFilter
     */
    protected $inputFilter;
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    abstract function setValue($value);
    
    abstract function getValue();
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Interface method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter\InputFilter();
    
            $inputFilter->add(array(
                'name'     => 'name',
                'required' => true,
            ));
    
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
}
