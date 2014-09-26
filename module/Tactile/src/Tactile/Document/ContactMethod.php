<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ContactMethod implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $type;
    
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $detail;
    
    /**
     * @var InputFilter\InputFilter
     */
    protected $inputFilter;
    
    public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }
    
    public function getDetail()
    {
        return $this->detail;
    }
    
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getTypes()
    {
        return array(
            'e' => 'Email',
            'f' => 'Fax',
            'm' => 'Mobile',
            't' => 'Telephone',
        );
    }
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Interface method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter\InputFilter();
            
            $inputFilter->add(array(
                'name'     => 'type',
                'required' => false,
            ));
            
            $inputFilter->add(array(
                'name'     => 'detail',
                'required' => false,
            ));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
}