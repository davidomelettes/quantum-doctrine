<?php

namespace Tactile\Service;

use Doctrine\ODM\MongoDB\Query;
use Tactile\Document;
use OmelettesDoctrine\Service as OmService;

class NotesService extends OmService\AbstractAccountBoundHistoricDocumentService
{
    public function defaultSort(Query\Builder $qb)
    {
        return $qb->sort('created', 'desc');
    }
    
    public function createDocument()
    {
        return new Document\Note();
    }
    
}
