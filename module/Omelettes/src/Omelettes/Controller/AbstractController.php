<?php

namespace Omelettes\Controller;

use Zend\Mvc\Controller\AbstractActionController;

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
    
}
