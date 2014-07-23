<?php

namespace Omelettes\Form\Fieldset;

use Zend\Form;
use Zend\Validator;

class SubmitFieldset extends Form\Fieldset
{
    public function __construct($name = 'submit', $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn',
                'value' => 'Hi',
            ),
        ));
    }
    
    public function getInputFilter()
    {
        $filter = parent::getInputFilter();
    }
    
}