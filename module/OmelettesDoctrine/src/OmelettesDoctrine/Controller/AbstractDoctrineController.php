<?php

namespace OmelettesDoctrine\Controller;

use Doctrine\Common\Collections\ArrayCollection;
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

        // Prepare a new route
        $route = new OmDoc\RememberedRoute();
        $route->setLabel($label)
        ->setName($routeName)
        ->setOptions($routeOptions);

        // Is the route already remembered?
        $rememberedRoutes = $identity->getRememberedRoutes();
        foreach ($rememberedRoutes as $rr) {
            if ($rr->getName() === $route->getName() && $rr->getOptions() === $route->getOptions()) {
                // It is; let's remove it first
                $rememberedRoutes->removeElement($rr);
                break;
            }
        }
        
        // Will the new set exceed the max?
        $maxSize = 6;
        while (count($rememberedRoutes) > ($maxSize - 1)) {
            // Remove the last item
            $rememberedRoutes->remove(count($rememberedRoutes)-1);
        }

        // Create a new set with the new route at the front
        $newRouteSet = new ArrayCollection(array_merge(array($route), $rememberedRoutes->toArray()));
        $identity->setRememberedRoutes($newRouteSet);
        if (count($identity->getRememberedRoutes()) > 10) {
            $identity->getRememberedRoutes()->remove(0);
        }
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $usersService->commit();
    }

}
