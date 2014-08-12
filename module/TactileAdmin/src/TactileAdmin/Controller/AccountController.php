<?php

namespace TactileAdmin\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;

class AccountController extends AbstractDoctrineController
{
    public function infoAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Account Information',
        ));
    }
    
    public function settingsAction()
    {
        return $this->returnViewModel(array(
            'title' => 'Account Settings',
        ));
    }
    
}
