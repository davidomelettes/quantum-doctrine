<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="resources.fields", requireIndexes=true)
 */
class ResourceField extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var string
     * @ODM\String
     */
    protected $name;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $label;
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
    
    public function getLabel()
    {
        return $this->label;
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