<?php

namespace OmelettesDoctrine\Form\Fieldset;

use OmelettesDoctrine\Service\AbstractDocumentService;
use OmelettesDoctrine\Stdlib\Hydrator\UberHydrator;
use Zend\Form\Fieldset;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class AbstractDocumentFieldset extends Fieldset implements ServiceLocatorAwareInterface
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
        return new UberHydrator($this->getApplicationServiceLocator()->get('doctrine.documentmanager.odm_default'));
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
