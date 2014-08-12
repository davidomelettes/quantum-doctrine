<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="contacts", requireIndexes=true)
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 */
class Contact extends Quantum
{
    /**
     * @var string
     * @ODM\String
     */
    protected $fullName;
    
    /**
     * @var ArrayCollection
     * @ODM\ReferenceMany(
     *     targetDocument="ContactMethod",
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "e"="ContactMethodEmail",
     *         "p"="ContactMethodPhone",
     *     }
     * )
     */
    protected $contactMethods;
    
    public function init()
    {
        parent::init();
        $this->contactMethods = new ArrayCollection();
    }
    
    public function setFullName($name)
    {
        $this->fullName = $name;
        return $this;
    }
    
    public function getFullName()
    {
        return $this->fullName;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'fullName',
                'required'		=> 'true',
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
            
            $this->inputFilter = $filter;
        }
        
        return $this->inputFilter;
    }
    
}