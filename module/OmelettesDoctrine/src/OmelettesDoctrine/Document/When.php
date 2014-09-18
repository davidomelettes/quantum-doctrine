<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class When
{
    /**
     * @var \DateTime
     * @ODM\Date
     * @ODM\Index
     */
    protected $date;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $time;
    
    public function setDate(\DateTime $date)
    {
        if (null !== $this->time) {
            $date->modify('' == $this->time ? '00:00' : $this->time);
        }
        $this->date = $date;
        return $this;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setTime($time)
    {
        if ($this->date instanceof \DateTime) {
            $this->date->modify('' == $time ? '00:00' : $time);
        }
        $this->time = $time;
        return $this;
    }
    
    public function getTime()
    {
        return $this->time;
    }
    
}