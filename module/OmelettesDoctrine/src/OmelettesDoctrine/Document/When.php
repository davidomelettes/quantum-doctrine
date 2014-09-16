<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class When
{
    const REZ_Y = '1';
    const REZ_YM = '2';
    const REZ_YMD = '3';
    const REZ_DATE = '3';
    const REZ_YMDH = '4';
    const REZ_YMDHI = '5';
    const REZ_YMDHIS = '6';
    const REZ_DATETIME = '6';
    
    /**
     * @var string
     * @ODM\Id
     */
    protected $id;
    
    /**
     * @var \DateTime
     * @ODM\Date
     * @ODM\Index
     */
    protected $date;
    
    /**
     * @var int
     * @ODM\Int
     */
    protected $rez = self::REZ_DATE;
    
    /**
     * @var string
     */
    protected $time;
    
    public function setDate(\DateTime $date)
    {
        if (null !== $this->time) {
            $date->setTime($this->time);
        }
        $this->date = $date;
        return $this;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setRez($rez)
    {
        $this->rez = (int) $rez;
        return $this;
    }
    
    public function getRez()
    {
        return $this->rez;
    }
    
    public function setTime($time)
    {
        if ('' === $time) {
            $time = '00:00';
        } else {
            $this->setRez(self::REZ_YMDHI);
        }
        if ($this->date instanceof \DateTime) {
            $this->date->modify($time);
        }
        $this->time = $time;
        return $this;
    }
    
}