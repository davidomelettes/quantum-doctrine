<?php

namespace Tactile\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Omelettes\Tabulatable\TabulatableItemInterface;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Form\Fieldset\WhenFieldset;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="contacts", requireIndexes=true)
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 */
class Contact extends Quantum implements TabulatableItemInterface
{
    protected $hydrator;
    
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $fullName;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $description;

    /**
     * @var OmDoc\When
     * @ODM\EmbedOne(targetDocument="OmelettesDoctrine\Document\When")
     */
    protected $lastContacted;
    
    /**
     * @var array
     * @ODM\EmbedMany(
     *     strategy="setArray",
     *     targetDocument="ContactMethod"
     * )
     */
    protected $contactMethods = array();
    
    public function __construct()
    {
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
    
    public function setDescription($desc)
    {
        $this->description = $desc;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setLastContacted(OmDoc\When $time)
    {
        $this->lastContacted = $time;
        return $this;
    }
    
    public function getLastContacted()
    {
        return $this->lastContacted;
    }
    
    public function setContactMethods($methods)
    {
        $this->contactMethods = $methods;
        return $this;
    }
    
    public function getContactMethods()
    {
        return $this->contactMethods;
    }
    
    public function addContactMethods($toAdd)
    {
        foreach ($toAdd as $method) {
            $this->contactMethods[] = $method;
        }
        return $this;
    }
    
    public function removeContactMethods($toRemove)
    {
        foreach ($toRemove as $method) {
            // ??? Really ???
            $this->contactMethods->removeElement($method);
        }
        return $this;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'fullName',
                'required'		=> true,
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
            
            $filter->add(array(
                'name'			=> 'description',
                'required'		=> false,
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
            
            $when = new OmDoc\When();
            $filter->add($when->getInputFilter(), 'lastContacted');
            
            $this->inputFilter = $filter;
        }
        
        return $this->inputFilter;
    }
    
    public function getTableRowPartial()
    {
        return 'tabulate/contact';
    }
    
    public function getTableHeadings()
    {
        return array(
            'fullName'       => 'Contact Name',
            'created'        => 'Last Contacted',
            'lastContacted'  => 'Created',
        );
    }
    
}