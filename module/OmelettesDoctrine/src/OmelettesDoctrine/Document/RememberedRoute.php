<?php

namespace OmelettesDoctrine\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\EmbeddedDocument
 */
class RememberedRoute
{
    /**
     * @var string
     * @ODM\String
     */
    protected $label;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $name;
    
    /**
     * @var array
     * @ODM\Hash
     */
    protected $options = array();
    
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
    
    public function getLabel()
    {
        return $this->label;
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
    
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
}