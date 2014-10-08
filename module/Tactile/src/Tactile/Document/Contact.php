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
 */
class Contact extends Quantum implements TabulatableItemInterface
{
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
     * @var ArrayCollection
     * @ODM\EmbedMany(
     *     strategy="setArray",
     *     targetDocument="ContactAddress"
     * )
     */
    protected $addresses;
    
    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(
     *     strategy="setArray",
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "e"="Tactile\Document\ContactMethodEmail",
     *         "f"="Tactile\Document\ContactMethodFax",
     *         "m"="Tactile\Document\ContactMethodMobile",
     *         "t"="Tactile\Document\ContactMethodTelephone"
     *     }
     * )
     */
    protected $contactMethods;
    
    public function __construct()
    {
        parent::__construct();
        $this->addresses = new ArrayCollection();
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
    
    public function setAddresses($methods)
    {
        $this->addresses = $methods;
        return $this;
    }
    
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    public function addAddresses($toAdd)
    {
        foreach ($toAdd as $add) {
            $this->addresses[] = $add;
        }
        return $this;
    }
    
    public function removeAddresses($toRemove)
    {
        foreach ($toRemove as $remove) {
            // ??? Really ???
            $this->addresses->removeElement($remove);
        }
        return $this;
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
        foreach ($toAdd as $add) {
            $this->contactMethods->add($add);
        }
        return $this;
    }
    
    public function removeContactMethods($toRemove)
    {
        foreach ($toRemove as $remove) {
            $this->contactMethods->removeElement($remove);
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