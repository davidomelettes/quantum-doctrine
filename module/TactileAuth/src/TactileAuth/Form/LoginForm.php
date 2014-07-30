<?php

namespace TactileAuth\Form;

use Omelettes\Form\Fieldset;
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
                'label' => 'Choose a Password',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-password',
                'required'    => true,
            ),
        ));
        
        $this->add(array(
            'name' => 'forgotPassword',
            'type' => 'Omelettes\Form\Element\StaticAnchor',
            'options' => array(
                'label'       => 'Forgot Password?',
                'route_name'  => 'forgot-password',
                'group_class' => 'pull-right',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-forgotPassword',
            ),
        ));
        
        $this->add(array(
            'name' => 'rememberMe',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label'       => 'Remember Me',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-rememberMe',
            ),
        ));
        
        $this->add(new Fieldset\CsrfFieldset());
        $this->addSubmitFieldset('Sign in', 'btn btn-lg btn-warning btn-block');
    }
    
}