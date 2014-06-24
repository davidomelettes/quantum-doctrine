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
     * @Form\Attributes({"placeholder":"Email Address"}) 
     */
    public $emailAddress;
    
    /**
     * @Form\Type("Zend\Form\Element\Password")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Options({"label":"Password"})
     * @Form\Attributes({"placeholder":"Password"}) 
     */
    public $password;
    
    /**
     * @Form\ComposedObject("OmelettesStub\Form\SubmitFieldset") 
     */
    public $submit;
    
}