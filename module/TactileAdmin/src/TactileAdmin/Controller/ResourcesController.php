<?php

namespace TactileAdmin\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class ResourcesController extends AbstractDoctrineController
{
    public function indexAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Resources',
        ));
    }
    
}
