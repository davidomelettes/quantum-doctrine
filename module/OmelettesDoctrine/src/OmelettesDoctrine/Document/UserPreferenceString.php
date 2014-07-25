<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class UserPreferenceString extends UserPreference
{
    /**
     * @var string
     * @ODM\String
     */
    protected $value;
    
    public function setValue($value)
    {
        $this->value = (string)$value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
}
