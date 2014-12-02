<?php

namespace TactileAdmin\Form\Fieldset;

use Tactile\Document;

class CustomFieldDateFieldset extends CustomFieldFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ResourceFieldDate');
        $this->setObject(new Document\ResourceFieldDate());
    
        $this->add(array(
            'name'       => 'label',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Date Field Label',
            ),
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name'       => 'type',
            'type'       => 'Hidden',
            'options'    => array(
            ),
            'attributes' => array(
                'value' => 'd',
            ),
        ));
        
        $whenOptions = array(
            '' => '-- None --',
        );
        $makeTimes = array(
            'Now',
            '+5 Minutes',
            '+10 Minutes',
            '+15 Minutes',
            '+30 Minutes',
            '+45 Minutes',
            '+1 Hour',
            '+2 Hours',
            '+3 Hours',
            '+6 Hours',
            '+12 Hours',
            '+24 Hours',
            '+2 Days',
            '+3 Days',
            '+7 Days',
            '+14 Days',
            '+21 Days',
            '+30 Days',
            '+60 Days',
            '+90 Days',
            '+120 Days',
            '+365 Days',
        );
        $now = time();
        foreach ($makeTimes as $when) {
            $interval = strtotime($when) - $now;
            $whenOptions[$interval] = $when;
        }
        $this->add(array(
            'name'       => 'default',
            'type'       => 'Select',
            'options'    => array(
                'label'   => 'Default Value',
                'options' => $whenOptions,
            ),
            'attributes' => array(
            ),
        ));
    }
    
}
