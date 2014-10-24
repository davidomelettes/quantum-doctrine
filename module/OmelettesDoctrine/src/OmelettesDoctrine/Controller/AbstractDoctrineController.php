<?php

namespace OmelettesDoctrine\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Omelettes\Controller\AbstractController;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service\AbstractDocumentService;
use Zend\Authentication;
use Zend\Form;

abstract class AbstractDoctrineController extends AbstractController
{
    /**
     * @return DocumentManager
     */
    public function getDefaultDocumentManager()
    {
        return $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
    }
    
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
    
    public function rememberRoute($label)
    {
        $identity = $this->getAuthenticationService()->getIdentity();
        $routeMatch = $this->getEvent()->getRouteMatch();
        $routeName = $routeMatch->getMatchedRouteName();
        $routeOptions = array();
        foreach ($routeMatch->getParams() as $k => $v) {
            if ('controller' === $k) {
                continue;
            }
            $routeOptions[$k] = $v;
        }
        
        $route = new OmDoc\RememberedRoute();
        $route->setLabel($label)
              ->setName($routeName)
              ->setOptions($routeOptions);
        if ($identity->hasRememberedRoute($route)) {
            return;
        }
        $identity->getRememberedRoutes()->add($route);
        if (count($identity->getRememberedRoutes()) > 10) {
            $identity->getRememberedRoutes()->remove(0);
        }
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $usersService->commit();
    }
    
}
