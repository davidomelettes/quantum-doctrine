<?php

namespace OmelettesDoctrine\Controller;

use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Omelettes\Controller\AbstractController;

class ConsoleDbController extends AbstractController
{
    public function initAction()
    {
        $systemService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\SystemService');
        $systemService->insertSystemUsers();
        $systemService->commit();
    }
    
    public function dropAction()
    {
        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        $mongo = $dm->getConnection();
    }
    
}
