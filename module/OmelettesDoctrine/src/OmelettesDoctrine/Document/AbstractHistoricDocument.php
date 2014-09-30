<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
abstract class AbstractHistoricDocument extends AbstractDocument
{
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $created;
    
    /**
     * @var User
     * @ODM\ReferenceOne(targetDocument="OmelettesDoctrine\Document\User")
     */
    protected $createdBy;
    
    /**
     * @var \DateTime
     * @ODM\Date
     */
    protected $updated;
    
    /**
     * @var User
     * @ODM\ReferenceOne(targetDocument="OmelettesDoctrine\Document\User")
     */
    protected $updatedBy;
    
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
    
    public function setCreatedBy(User $user)
    {
        $this->createdBy = $user;
        return $this;
    }
    
    public function getCreatedBy()
    {
        return $this->createdBy;
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
    
    public function setUpdatedBy(User $user)
    {
        $this->updatedBy = $user;
        return $this;
    }
    
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    
    public function setDeleted(\DateTime $date)
    {
        $this->deleted = $date;
        return $this;
    }
    
    public function getDeleted()
    {
        return $this->deleted;
    }
    
}