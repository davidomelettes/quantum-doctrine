<?php

namespace Omelettes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class AbstractController extends AbstractActionController
{
    /**
     * Defines the type of View returned based on the Accept header
     * 
     * @var array
     */
    protected $acceptedViewCriteria = array(
        'Zend\View\Model\ViewModel' => array(
            'text/html',
        ),
        'Zend\View\Model\JsonModel' => array(
            'application/json',
        ),
    );
    
    /**
     * Returns a view model selected by the HTTP Accept header criteria
     *
     * @param array $variables
     * @return ViewModel
     */
    public function returnViewModel(array $variables = array())
    {
        $viewModel = $this->acceptableViewModelSelector($this->acceptedViewCriteria);
        $viewModel->setVariables($variables, true);
    
        return $viewModel;
    }
    
    public function flashError($message)
    {
        return $this->flashMessenger()->addErrorMessage($message);
    }
    
    public function flashSuccess($message)
    {
        return $this->flashMessenger()->addSuccessMessage($message);
    }
    
    public function flashInfo($message)
    {
        return $this->flashMessenger()->addInfoMessage($message);
    }
    
    /**
     * @return \Zend\Session\Container
     */
    public function getOmelettesSession()
    {
        return new Container('Omelettes');
    }
    
    public function rememberCurrentRoute()
    {
        $session = $this->getOmelettesSession();
        $route = null;
        $routeMatch = $this->getEvent()->getRouteMatch();
        if ($routeMatch) {
            $route = array(
                'name'    => $routeMatch->getMatchedRouteName(),
                'params'  => $routeMatch->getParams(),
            );
        }
        $session->rememberedRoute = $route;
    }
    
    public function getRememberedRoute()
    {
        $session = $this->getOmelettesSession();
        $route = $session->rememberedRoute;
        $this->forgetRememberedRoute();
        return $route;
    }
    
    public function forgetRememberedRoute()
    {
        $session = $this->getOmelettesSession();
        $session->rememberedRoute = null;
    }
    
}
