<?php

namespace OmelettesDoctrine\Form;

use Omelettes\Form\AbstractForm;
use OmelettesDoctrine\Service\AbstractDocumentService;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

abstract class AbstractDocumentForm extends AbstractForm
{
    use ServiceLocatorAwareTrait;
    
    /**
     * @var AbstractDocumentService
     */
    protected $documentService;
    
    public function setDocumentService(AbstractDocumentService $service)
    {
        $this->documentService = $service;
        $hydrator = new DoctrineHydrator($service->getDocumentManager());
        $this->setHydrator($hydrator);
        return $this;
    }
    
    public function getDocumentService()
    {
        return $this->documentService;
    }
    
}
