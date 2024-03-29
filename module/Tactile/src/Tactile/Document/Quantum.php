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
     * @ODM\ReferenceMany(
     *     targetDocument="Tactile\Document\Tag"
     * )
     * @ODM\Index
     */
    protected $tags = array();
    
    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(
     *     strategy="setArray",
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "t"="Tactile\Document\CustomValueText",
     *         "n"="Tactile\Document\CustomValueNumeric",
     *     }
     * )
     */
    protected $customValues;
    
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->customValues = new ArrayCollection();
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
    
    public function setCustomValues($customValues)
    {
        $this->customValues = $customValues;
        return $this;
    }
    
    public function getCustomValues()
    {
        return $this->customValues;
    }
    
    public function addCustomValues($toAdd)
    {
        foreach ($toAdd as $add) {
            $this->customValues->add($add);
        }
        return $this;
    }
    
    public function removeCustomValues($toRemove)
    {
        foreach ($toRemove as $remove) {
            $this->customValues->removeElement($remove);
        }
        return $this;
    }
    
}