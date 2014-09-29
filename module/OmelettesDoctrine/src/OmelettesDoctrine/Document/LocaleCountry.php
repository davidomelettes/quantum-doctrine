<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="locale.countries", requireIndexes=true)
 */
class LocaleCountry
{
    /**
     * @var string
     * @ODM\Id(strategy="NONE")
     */
    protected $code;
    
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $name;
    
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    public function getCode()
    {
        return $this->code;
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
    
}
