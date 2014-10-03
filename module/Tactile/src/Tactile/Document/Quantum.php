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
     * @var ArrayCollection
     * @ODM\ReferenceMany(
     *     strategy="addToSet",
     *     targetDocument="Tactile\Document\Note",
     *     sort={"created": "desc"}
     * )
     */
    protected $notes;
    
    public function __construct()
    {
        $this->notes = new ArrayCollection();
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
    
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }
    
    public function getNotes()
    {
        return $this->notes;
    }
    
    public function addNotes($toAdd)
    {
        foreach ($toAdd as $add) {
            $this->notes->add($add);
        }
        return $this;
    }
    
    public function removeNotes($toRemove)
    {
        foreach ($toRemove as $remove) {
            $this->notes->removeElement($remove);
        }
        return $this;
    }
    
}