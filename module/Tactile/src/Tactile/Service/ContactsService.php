<?php

namespace Tactile\Service;

use Tactile\Document as Doc;
use OmelettesDoctrine\Service\AbstractDocumentService;

class ContactsService extends QuantaService
{
    public function createDocument()
    {
        return new Doc\Contact($this);
    }
    
}
