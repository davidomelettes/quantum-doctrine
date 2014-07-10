<?php

namespace OmelettesDoctrine\Controller;

use Omelettes\Controller\AbstractController;
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
    public function createForm($type)
    {
        $factory = $this->getServiceLocator()->get('OmelettesDoctrine\Form\Factory');
        return $factory->createForm(array('type' => $type));
    }
    
}
