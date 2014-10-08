<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Omelettes\Listable\ListableItemInterface;
use OmelettesDoctrine\Document as OmDoc;
use Zend\InputFilter;

/**
 * @ODM\MappedSuperclass
 */
class ContactMethod implements InputFilter\InputFilterAwareInterface, ListableItemInterface
{
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
                'required' => true,
            ));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    public function getListItemPartial()
    {
        return 'listable/contact-method';
    }
    
}