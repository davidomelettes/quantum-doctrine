<?php

namespace Omelettes\Form\Fieldset;

use Zend\Form\Fieldset;

class DateTimeFieldset extends Fieldset
{
    public function __construct($name, $label, $required = false)
    {
        parent::__construct($name, array());
        $this->add(array(
            'name'		=> 'date',
            'required'	=> $required,
            'type'		=> 'Text',
            'options'	=> array(
                'label'		    => $label,
                'feedback_icon' => 'calendar',
            ),
            'attributes'=> array(
                'id'			=> $this->getName() .'-date',
                'class'		=> 'form-control datepick',
            ),
        ));
        $this->add(array(
            'name'		=> 'time',
            'type'		=> 'Text',
            'options'	=> array(
                'feedback_icon' => 'time',
            ),
            'attributes'=> array(
                'id'			=> $this->getName() .'-time',
                'class'		=> 'form-control timepick',
            ),
        ));
    }
    
}
