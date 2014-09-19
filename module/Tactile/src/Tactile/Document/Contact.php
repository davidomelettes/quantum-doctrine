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
     * @var OmDoc\When
     * @ODM\EmbedOne(targetDocument="OmelettesDoctrine\Document\When")
     */
    protected $lastContacted;
    
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
    
    public function setLastContacted(OmDoc\When $time)
    {
        $this->lastContacted = $time;
        return $this;
    }
    
    public function getLastContacted()
    {
        return $this->lastContacted;
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
            
            $when = new OmDoc\When();
            $when->setRequired(true);
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