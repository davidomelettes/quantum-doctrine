<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class UserPreferenceInteger extends UserPreference
{
    /**
     * @var int
     * @ODM\Int
     */
    protected $value;
    
    public function setValue($value)
    {
        $this->value = (int)$value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
}
