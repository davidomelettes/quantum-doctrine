<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="resources.fields", requireIndexes=true)
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 */
class ResourceField extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var Resource
     * @ODM\ReferenceOne(targetDocument="Resource")
     */
    protected $resource;
    
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $name;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $label;
    
    /**
     * @var boolean
     * @ODM\Boolean
     */
    protected $required;
    
    /**
     * @var Boolean
     * @ODM\Boolean
     */
    protected $protected;
    
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
        return $this;
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
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
    
    public function setRequired($required)
    {
        $this->required = (boolean) $required;
        return $this;
    }
    
    public function getRequired()
    {
        return $this->required;
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