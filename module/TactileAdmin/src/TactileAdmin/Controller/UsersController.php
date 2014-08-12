<?php

namespace TactileAdmin\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class UsersController extends AbstractDoctrineController
{
    public function indexAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Users',
        ));
    }
    
}
