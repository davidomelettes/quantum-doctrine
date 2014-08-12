<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="contacts.methods", requireIndexes=true)
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 */
class ContactMethod extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var Contact
     * @ODM\ReferenceOne(targetDocument="Contact")
     */
    protected $contact;
    
    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
        return $this;
    }
    
    public function getContact()
    {
        return $this->contact;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $this->inputFilter = $filter;
        }
        
        return $this->inputFilter;
    }
    
}