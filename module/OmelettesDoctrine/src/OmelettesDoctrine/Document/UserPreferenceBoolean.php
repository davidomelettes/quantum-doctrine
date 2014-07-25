<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class UserPreferenceBoolean extends UserPreference
{
    /**
     * @var boolean
     * @ODM\Boolean
     */
    protected $value;
    
    public function setValue($value)
    {
        $this->value = (boolean)$value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
}
