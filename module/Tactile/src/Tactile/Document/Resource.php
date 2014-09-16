<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Boolean;

/**
 * @ODM\Document(collection="resources", requireIndexes=true)
 * @ODM\UniqueIndex(keys={"account.id"="asc", "slug"="asc"})
 */
class Resource extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
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
    
    /**
     * @var Boolean
     * @ODM\Boolean
     */
    protected $protected;
    
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
    
    public function setProtected($protected)
    {
        $this->protected = (boolean) $protected;
        return $this;
    }
    
    public function getProtected()
    {
        return $this->protected;
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