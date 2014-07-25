<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class UserPreferenceDate extends UserPreference
{
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $value;
    
    public function setValue(\DateTime $value)
    {
        $this->value = $value;
        return $this;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
}
