<?php

namespace TactileSignup\Controller;

use Omelettes\Controller\AbstractController;

class PagesController extends AbstractController
{
    public function frontAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Tactile CRM',
        ));
    }
    
}
