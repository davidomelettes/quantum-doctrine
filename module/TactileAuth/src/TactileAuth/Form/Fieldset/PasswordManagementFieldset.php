<?php

namespace TactileAuth\Form\Fieldset;

use Zend\Form;

class PasswordManagementFieldset extends Form\Fieldset
{
    public function __construct($name = 'password-management', $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttribute('class', 'row');
        
        $this->add(array(
            'name' => 'rememberMe',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label'       => 'Remember Me',
                'group_class' => 'col-lg-6',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-rememberMe',
            ),
        ));
        
        $this->add(array(
            'name' => 'forgotPassword',
            'type' => 'Omelettes\Form\Element\StaticAnchor',
            'options' => array(
                'label'       => 'Forgot Password?',
                'route_name'  => 'forgot-password',
                //'group_class' => 'pull-right',
                'group_class' => 'col-lg-6 text-right',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-forgotPassword',
            ),
        ));
    }
    
}