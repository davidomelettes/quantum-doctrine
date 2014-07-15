<?php

namespace OmelettesDoctrine\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesDoctrine\Service\AbstractDocumentService;
use Zend\Authentication;
use Zend\Form;

abstract class AbstractDoctrineController extends AbstractController
{
    /**
     * @return Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    }
    
    /**
     * @param string $type
     * @return Form\Form
     */
    public function getManagedForm($type)
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get($type);
        return $form;
    }
    
}
