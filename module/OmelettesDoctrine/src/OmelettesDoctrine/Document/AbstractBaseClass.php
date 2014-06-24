<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
abstract class AbstractBaseClass extends AbstractDocument
{
    /**
     * @var string
     * @ODM\Id(strategy="UUID")
     */
    protected $id;
    
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $created;
    
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $updated;
    
    /**
     * @var \DateTime
     * @ODM\Date
     * @ODM\Index
     */
    protected $deleted;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setCreated(\DateTime $date)
    {
        $this->created = $date;
        return $this;
    }
    
    public function getCreated()
    {
        return $this->created;
    }
    
    public function setUpdated(\DateTime $date)
    {
        $this->updated = $date;
        return $this;
    }
    
    public function getUpdated()
    {
        return $this->updated;
    }
    
}