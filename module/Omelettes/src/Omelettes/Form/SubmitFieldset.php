<?php

namespace Omelettes\Form;

use Zend\Form\Fieldset;

class SubmitFieldset extends Fieldset
{
    public function __construct($name = 'submit', $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn',
                'value' => 'Hi',
            ),
        ));
    }
    
}