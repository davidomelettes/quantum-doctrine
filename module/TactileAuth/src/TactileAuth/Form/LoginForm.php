<?php

namespace TactileAuth\Form;

use Omelettes\Form\Fieldset\CsrfFieldset;
use OmelettesDoctrine\Form\AbstractDocumentForm;

class LoginForm extends AbstractDocumentForm
{
    public function init()
    {
        $this->setName('login');
        
        $this->add(array(
            'name' => 'emailAddress',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'Email Address',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-emailAddress',
                'required'    => true,
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-password',
                'required'    => true,
            ),
        ));
        
        $passwordManagementFieldset = new Fieldset\PasswordManagementFieldset();
        $this->add($passwordManagementFieldset);
        
        $this->add(new CsrfFieldset());
        $this->addSubmitFieldset('Sign in', 'btn btn-lg btn-primary btn-block');
    }
    
}