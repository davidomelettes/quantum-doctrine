<?php

namespace Omelettes\Form;

use Zend\Form;
use Zend\Validator;

class SubmitFieldset extends Form\Fieldset
{
    public function __construct($name = 'submit', $options = array())
    {
        parent::__construct($name, $options);

        $csrf = new Form\Element\Csrf('csrf', array(
            'csrf_options' => array(
                'timeout' => 600,
            ),
        ));
        $csrf->getCsrfValidator()->setMessage(
            'The submitted form was too old, or did not come from this site',
            \Zend\Validator\Csrf::NOT_SAME
        );
        $this->add($csrf);
        
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