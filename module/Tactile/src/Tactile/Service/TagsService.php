<?php

namespace Tactile\Service;

use Doctrine\ODM\MongoDB\Query;
use Tactile\Document;
use OmelettesDoctrine\Service as OmService;

class TagsService extends OmService\AbstractAccountBoundDocumentService
{
    public function defaultSort(Query\Builder $qb)
    {
        return $qb->sort('name', 'asc');
    }
    
    public function createDocument()
    {
        return new Document\Tag();
    }
    
    public function fetchWithNames(array $names)
    {
        $qb = $this->createDefaultFindQuery();
        $qb->field('name')->in($names);
        $cursor = $qb->getQuery()->execute();
        return $this->getPaginator($cursor);
    }
    
}
