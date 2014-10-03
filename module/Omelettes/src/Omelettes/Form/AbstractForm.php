<?php

namespace Omelettes\Form;

use Zend\Form\Form as ZendForm;
use Zend\Form\FormInterface;
use Zend\Form\Exception;

abstract class AbstractForm extends ZendForm
{
    public function addSubmitFieldset($buttonText = 'Save', $buttonClass = 'btn btn-lg btn-success')
    {
        $submit = new Fieldset\SubmitFieldset();
        $submit->get('submit')->setAttributes(array(
            'class' => $buttonClass,
        ))->setLabel($buttonText);
        $this->add($submit);
        
        return $this;
    }
    
}
