<?php

namespace Tactile\Service;

use Tactile\Document as Doc;
use OmelettesDoctrine\Service\AbstractAccountBoundHistoricDocumentService;

abstract class QuantaService extends AbstractAccountBoundHistoricDocumentService
{
    /**
     * @var Doc\Resource
     */
    protected $resource;
    
    public function setResource(Doc\Resource $resource)
    {
        $this->resource = $resource;
        return $this;
    }
    
    /**
     * @return Doc\Resource
     */
    public function getResource()
    {
        if (!$this->resource instanceof Doc\Resource) {
            throw new \Exception('Resource not set');
        }
        return $this->resource;
    }
    
    public function save(Doc\Quantum $quantum)
    {
        //$resource = $this->getResource();
        //$quantum->setResource($resource);
    
        return parent::save($quantum);
    }
    
}
