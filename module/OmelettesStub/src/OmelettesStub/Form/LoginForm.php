<?php

namespace OmelettesStub\Form;

use Zend\Form\Annotation as Form;

/**
 * @Form\Name("login") 
 */
class LoginForm
{
    /**
     * @Form\Type("Zend\Form\Element\Email")
     * @Form\Required(true)
     * @Form\Options({"label":"Email Address"})
     * @Form\Attributes({"id":"login-email"})
     */
    public $emailAddress;
    
    /**
     * @Form\Type("Zend\Form\Element\Password")
     * @Form\Required(true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Options({"label":"Password"})
     * @Form\Attributes({"id":"login-password"})
     */
    public $password;
    
    /**
     * @Form\Type("Zend\Form\Element\Csrf");
     */
    public $csrf;
    
    /**
     * @Form\Type("Zend\Form\Element\Submit")
     * @Form\Attributes({"value":"Login", "class":"btn btn-lg btn-block btn-primary"}) 
     */
    public $submit;
    
}