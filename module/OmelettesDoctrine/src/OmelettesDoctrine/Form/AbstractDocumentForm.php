<?php

namespace OmelettesDoctrine\Form;

use Omelettes\Form\AbstractForm;
use OmelettesDoctrine\Service\AbstractDocumentService;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use OmelettesDoctrine\Stdlib\Hydrator\UberHydrator;

abstract class AbstractDocumentForm extends AbstractForm implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    /**
     * @var AbstractDocumentService
     */
    protected $documentService;
    
    public function setDocumentService(AbstractDocumentService $service)
    {
        $this->documentService = $service;
        return $this;
    }
    
    public function getHydrator()
    {
        return $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Stdlib\Hydrator\UberHydrator');
    }
    
    /**
     * @return AbstractDocumentService
     */
    public function getDocumentService()
    {
        return $this->documentService;
    }
    
    /**
     * @return ServiceLocatorInterface
     */
    public function getApplicationServiceLocator()
    {
        return $this->getServiceLocator()->getServiceLocator();
    }
    
}
