<?php

namespace OmelettesDoctrine\Form\Fieldset;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Document as OmDoc;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class WhenFieldset extends AbstractDocumentFieldset implements ViewPartialInterface
{
    /**
     * @var InputFilter
     */
    protected $inputFilter;

    public function init()
    {
        $this->setAllowedObjectBindingClass('OmelettesDoctrine\Document\When');
        $this->setAttribute('class', 'when');
        
        $this->add(array(
            'name'		=> 'date',
            'type'		=> 'Date',
            'options'	=> array(
                'label'		    => 'When',
            ),
            'attributes'=> array(
                'autocomplete' => 'off',
            ),
        ));
        
        $this->add(array(
            'name'		=> 'time',
            'type'		=> 'Time',
            'options'	=> array(
            ),
            'attributes'=> array(
                'autocomplete' => 'off',
            ),
        ));
    }
    
    public function setLabel($label)
    {
        $this->get('date')->setLabel($label);
        return $this;
    }
    
    public function setRequired($required)
    {
        $required = (boolean) $required;
        $this->get('date')->setAttribute('required', $required);
        return $this;
    }
    
    public function getViewPartial()
    {
        return 'form/fieldset/when';
    }

}
