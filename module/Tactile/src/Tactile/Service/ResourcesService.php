<?php

namespace Tactile\Service;

use Tactile\Document as Doc;
use OmelettesDoctrine\Service\AbstractAccountBoundHistoricDocumentService;

class ResourcesService extends AbstractAccountBoundHistoricDocumentService
{
    public function createDocument()
    {
        return new Doc\Resource($this);
    }
    
}
