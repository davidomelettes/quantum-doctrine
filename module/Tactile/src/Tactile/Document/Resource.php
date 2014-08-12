<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="resources", requireIndexes=true)
 */
class Resource extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var string
     * @ODM\String
     */
    protected $slug;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $singular;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $plural;
    
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function setSingular($label)
    {
        $this->singular = $label;
        return $this;
    }
    
    public function getSingular()
    {
        return $this->singular;
    }
    
    public function setPlural($label)
    {
        $this->plural = $label;
        return $this;
    }
    
    public function getPlural()
    {
        return $this->plural;
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