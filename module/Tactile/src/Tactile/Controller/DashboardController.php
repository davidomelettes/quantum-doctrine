<?php

namespace Tactile\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class DashboardController extends AbstractDoctrineController
{
    public function dashboardAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Dashboard',
        ));
    }
    
}
