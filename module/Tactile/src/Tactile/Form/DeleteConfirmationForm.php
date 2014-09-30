<?php

namespace Tactile\Form;

use Omelettes\Form\AbstractForm;

class DeleteConfirmationForm extends AbstractForm
{
    public function __construct($name = 'delete', array $options = array())
    {
        parent::__construct($name, $options);
        
        $this->add(array(
            'name' => 'cancel',
            'type' => 'Omelettes\Form\Element\StaticAnchor',
            'options' => array(
                'label' => 'Cancel',
            ),
            'attributes' => array(
                'class' => 'btn btn-lg btn-primary btn-block',
                'value' => 'Cancel',
            ),
        ));
        
        $this->addSubmitFieldset('Confirm deletion', 'btn btn-lg btn-danger btn-block');
    }
}
