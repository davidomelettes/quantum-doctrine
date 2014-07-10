<?php

namespace Omelettes\Form;

use Zend\Form\Form;

abstract class AbstractForm extends Form
{
    public function addSubmitFieldset($buttonText = 'Save', $buttonClass = 'btn btn-default')
    {
        $submit = new SubmitFieldset();
        $submit->get('submit')->setAttributes(array(
            'class' => $buttonClass,
            'value' => $buttonText,
        ));
        $this->add($submit);
        
        return $this;
    }
    
}
