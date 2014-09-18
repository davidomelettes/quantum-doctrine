<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class UserPreference extends AbstractDocument
{
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $name;
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
     
}
