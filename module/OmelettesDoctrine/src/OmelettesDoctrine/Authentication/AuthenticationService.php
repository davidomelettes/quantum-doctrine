<?php

namespace OmelettesDoctrine\Authentication;

use Zend\Authentication\AuthenticationService;

class AuthenticationService extends AuthenticationService
{
    protected $passwordAuthenticated = false;
    
    public function setPasswordAuthenticated($authenticated = false)
    {
        $this->passwordAuthenticated = (boolean)$authenticated;
        return $this;
    }
    
    public function isPasswordAuthenticated()
    {
        return $this->passwordAuthenticated;
    }
    
}
