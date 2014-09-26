<?php

namespace Omelettes\Form;

use Zend\Form\Form;

abstract class AbstractForm extends Form
{
    public function addSubmitFieldset($buttonText = 'Save', $buttonClass = 'btn btn-lg btn-success')
    {
        $submit = new Fieldset\SubmitFieldset();
        $submit->get('submit')->setAttributes(array(
            'class' => $buttonClass,
            'value' => $buttonText,
        ));
        $this->add($submit);
        
        return $this;
    }
    
}
