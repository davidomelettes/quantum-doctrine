<?php

namespace TactileAdmin\Form\Fieldset;

use Tactile\Document;

class CustomFieldOptionsFieldset extends CustomFieldFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ResourceFieldOptions');
        $this->setObject(new Document\ResourceFieldOptions());
        
        $this->add(array(
            'name'       => 'label',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'Option Field Label',
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
                'value' => 'o',
            ),
        ));
        
        $optionFieldset = $this->getServiceLocator()->get('TactileAdmin\Form\Fieldset\CustomFieldOptionsOptionFieldset');
        $this->add(array(
            'type'    => 'Omelettes\Form\Element\RemovableCollection',
            'name'    => 'options',
            'options' => array(
                'label'                  => 'Options',
                'count'                  => 0,
                'allow_add'              => true,
                'allow_remove'           => true,
                'create_new_objects'     => true,
                'should_create_template' => true,
                'target_element'         => $optionFieldset,
            ),
            'attributes' => array(
                'class'      => 'options',
            ),
        ));
        
        $defaultOptions = array(
            '' => '-- None --',
        );
        $this->add(array(
            'name'       => 'default',
            'type'       => 'Select',
            'options'    => array(
                'label'   => 'Default Value',
                'options' => $defaultOptions,
            ),
            'attributes' => array(
            ),
        ));
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/custom-field-options';
    }
    
}
