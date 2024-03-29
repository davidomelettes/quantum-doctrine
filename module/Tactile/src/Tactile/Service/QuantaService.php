<?php

namespace Tactile\Service;

use Tactile\Document;
use OmelettesDoctrine\Service\AbstractAccountBoundHistoricDocumentService;

abstract class QuantaService extends AbstractAccountBoundHistoricDocumentService
{
    /**
     * @var Doc\Resource
     */
    protected $resource;
    
    public function setResource(Document\Resource $resource)
    {
        $this->resource = $resource;
        return $this;
    }
    
    /**
     * @return Doc\Resource
     */
    public function getResource()
    {
        if (!$this->resource instanceof Document\Resource) {
            throw new \Exception('Resource not set');
        }
        return $this->resource;
    }
    
    public function save(Document\Quantum $quantum)
    {
        $resource = $this->getResource();
        $quantum->setResource($resource);
        
        // Add tags to Resource
        foreach ($quantum->getTags() as $tag) {
            $tagName = $tag->getName();
            $nameMatch = function ($t) use ($tagName) {
                return $t->getName() === $tagName;
            };
            if ($resource->getTags()->filter($nameMatch)->count() < 1) {
                $resource->getTags()->add($tag);
            }
        }
    
        return parent::save($quantum);
    }
    
    public function fetchByTags($tags)
    {
        $qb = $this->createDefaultFindQuery();
        $tagRefs = array();
        foreach ($tags as $tag) {
            if (!$tag instanceof Document\Tag) {
                throw new \Exception('Expected a Tag');
            }
            $tagRefs[] = $qb->expr()->includesReferenceTo($tag)->getQuery();
        }
        $qb->field('tags')->all($tagRefs);
        
        $cursor = $qb->getQuery()->execute();
        return $this->getPaginator($cursor);
    }
    
}
