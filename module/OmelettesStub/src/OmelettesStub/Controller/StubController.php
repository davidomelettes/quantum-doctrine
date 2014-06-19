<?php

namespace OmelettesStub\Controller;

use Omelettes\Controller\AbstractController;

class StubController extends AbstractController
{
    public function helloWorldAction()
    {
        return $this->returnViewModel();
    }
    
}
