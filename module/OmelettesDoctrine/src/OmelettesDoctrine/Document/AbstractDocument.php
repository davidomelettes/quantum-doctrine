<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use OmelettesDoctrine\Service\AbstractDocumentService;
use Zend\InputFilter;

/**
 * @ODM\MappedSuperclass
 */
abstract class AbstractDocument implements InputFilter\InputFilterAwareInterface
{
    /**
     * @var string
     * @ODM\Id(strategy="UUID")
     */
    protected $id;
    
    /**
     * @var AbstractDocumentService
     */
    protected $documentService;
    
    public function __construct(AbstractDocumentService $service)
    {
        $this->documentService = $service;
        $this->init();
    }
    
    public function setInputFilter(InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception('Interface method not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = new InputFilter\InputFilter();
    
            $this->inputFilter = $filter;
        }
        return $this->inputFilter;
    }
    
    /**
     * Utility method for initialising collections
     * @return \OmelettesDoctrine\Document\AbstractDocument
     */
    protected function init()
    {
        return $this;
    }
    
}
