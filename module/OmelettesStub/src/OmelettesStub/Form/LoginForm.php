<?php

namespace OmelettesStub\Form;

use Zend\Form\Annotation as Form;

/**
 * @Form\Name("login") 
 * @author dave
 */
class LoginForm
{
    /**
     * @Form\Type("Zend\Form\Element\Email")
     * @Form\Options({"label":"Email Address"})
     */
    public $emailAddress;
    
    /**
     * @Form\Type("Zend\Form\Element\Password")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Options({"label":"Password"})
     */
    public $password;
    
    /**
     * @Form\Type("Zend\Form\Element\Submit")
     * @Form\Attributes({"value":"Login"}) 
     */
    public $submit;
    
}