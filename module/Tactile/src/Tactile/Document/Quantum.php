<?php

namespace Tactile\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Document as OmDoc;

/**
 * @ODM\MappedSuperclass
 */
class Quantum extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var Resource
     * @ODM\ReferenceOne(targetDocument="Tactile\Document\Resource")
     */
    protected $resource;
    
    /**
     * @var OmDoc\User
     * @ODM\ReferenceOne(targetDocument="OmelettesDoctrine\Document\User")
     * @ODM\Index
     */
    protected $assignedTo;
    
    /**
     * @var Array
     * @ODM\Collection
     * @ODM\Index
     */
    protected $tags = array();
    
    public function __construct()
    {
        //$this->tags = new ArrayCollection();
    }
    
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
        return $this;
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
    public function setAssignedTo(OmDoc\User $user)
    {
        $this->assignedTo = $user;
        return $this;
    }
    
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }
    
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }
    
    public function getTags()
    {
        return $this->tags;
    }
    
    /*
    public function addTags($toAdd)
    {
        foreach ($toAdd as $add) {
            $this->tags->add($add);
        }
        return $this;
    }
    
    public function removeTags($toRemove)
    {
        foreach ($toRemove as $remove) {
            $this->tags->removeElement($remove);
        }
        return $this;
    }
    */
    
}