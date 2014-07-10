<?php

namespace OmelettesDoctrine\Document;

use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use OmelettesDoctrine\Service\AbstractDocumentService;

class AbstractDocument
{
    /**
     * @var AbstractDocumentService
     */
    protected $documentService;
    
    public function __construct(AbstractDocumentService $service)
    {
        $this->documentService = $service;
    }
    
}
