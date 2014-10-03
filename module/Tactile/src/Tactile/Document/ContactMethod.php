<?php

namespace Tactile\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Omelettes\Listable\ListableItemInterface;
use OmelettesDoctrine\Document as OmDoc;
use Zend\InputFilter;
use Zend\Validator;

/**
 * @ODM\EmbeddedDocument
 */
class ContactMethod implements InputFilter\InputFilterAwareInterface, ListableItemInterface
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
                'required' => true,
            ));
            
            $detailValidationClosure = function ($value, $context) {
                switch ($context['type']) {
                    case 'e':
                        $validator = new Validator\EmailAddress();
                        return $validator->isValid($value);
                    default:
                        return true;
                }
            };
            
            $inputFilter->add(array(
                'name'     => 'detail',
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
                    array(
                        'name'      => 'Callback',
                        'options'   => array(
                            'callback' => $detailValidationClosure,
                        ),
                    ),
                ),
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