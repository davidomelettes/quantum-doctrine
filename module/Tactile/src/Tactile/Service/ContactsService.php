<?php

namespace Tactile\Service;

use Doctrine\ODM\MongoDB\Query;
use Tactile\Document as Doc;
use OmelettesDoctrine\Service\AbstractDocumentService;

class ContactsService extends QuantaService
{
    public function defaultSort(Query\Builder $qb)
    {
        return $qb->sort('fullName', 'asc');
    }
    
    public function createDocument()
    {
        return new Doc\Contact();
    }
    
}
