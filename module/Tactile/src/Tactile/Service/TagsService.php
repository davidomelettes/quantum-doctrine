<?php

namespace Tactile\Service;

use Doctrine\ODM\MongoDB\Query;
use Tactile\Document;
use OmelettesDoctrine\Service as OmService;

class TagsService extends OmService\AbstractAccountBoundDocumentService
{
    public function defaultSort(Query\Builder $qb)
    {
        return $qb->sort('tag', 'asc');
    }
    
    public function createDocument()
    {
        return new Document\Tag();
    }
    
}
