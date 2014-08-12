<?php

namespace Tactile\Document;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
class Quantum extends OmDoc\AbstractAccountBoundHistoricDocument
{
    /**
     * @var Resource
     * @ODM\ReferenceOne(targetDocument="Resource")
     */
    protected $resource;
    
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
        return $this;
    }
    
    public function getResource()
    {
        return $this->resource;
    }
    
}