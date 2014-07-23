<?php

namespace Omelettes\Form\Fieldset;

use Zend\Form;
use Zend\Validator;

class CsrfFieldset extends Form\Fieldset
{
    public function __construct($name = 'csrf', $options = array())
    {
        parent::__construct($name, $options);

        $csrf = new Form\Element\Csrf('hash', array(
            'csrf_options' => array(
                'timeout' => 600,
            ),
        ));
        $csrf->getCsrfValidator()->setMessage(
            'The submitted form was too old, or did not come from this site',
            Validator\Csrf::NOT_SAME
        );
        $this->add($csrf);
    }
    
}