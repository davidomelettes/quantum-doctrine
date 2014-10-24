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
        $resource = $this->getResource();
        $quantum->setResource($resource);
    
        return parent::save($quantum);
    }
    
    public function fetchByTags(array $tags)
    {
        $qb = $this->createDefaultFindQuery();
        //$qb->field('tags')->in($tags);
        $qb->field('tags.name')->in($tags);
        /*
        foreach ($tags as $tagString) {
            $tagsService = $this->getServiceLocator()->get('Tactile\Service\TagsService');
            if (false !== ($tag = $tagsService->findBy('tag', $tagString))) {
                
            }
        }
        */
        
        $cursor = $qb->getQuery()->execute();
        return $this->getPaginator($cursor);
    }
    
}
