<?php

namespace OmelettesStub\Form;

use Zend\Form\Annotation as Form;

/**
 * @Form\Name("submit")
 * @author dave
 */
class SubmitFieldset
{
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