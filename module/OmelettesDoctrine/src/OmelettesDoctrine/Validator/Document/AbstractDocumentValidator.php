<?php

namespace OmelettesDoctrine\Validator\Document;

use OmelettesDoctrine\Service\AbstractDocumentService;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

abstract class AbstractDocumentValidator extends AbstractValidator
{
    /**
     * @var AbstractDocumentService
     */
    protected $documentService;
    
    /**
     * Which field is queried against?
     * @var string
     */
    protected $field = 'id';
    
    public function __construct(array $options)
    {
        if (!isset($options['document_service']) || !$options['document_service'] instanceof AbstractDocumentService) {
            throw new Exception\InvalidArgumentException('Missing Document Service');
        }
        $this->setDocumentService($options['document_service']);
        
        if (isset($options['field'])) {
            $this->setField($options['field']);
        }
        
        parent::__construct($options);
    }
    
    public function setDocumentService(AbstractDocumentService $service)
    {
        $this->documentService = $service;
        return $this;
    }
    
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
    
}