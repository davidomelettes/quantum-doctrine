<?php

namespace OmelettesStub\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter;

class UserPreferencesForm extends AbstractDocumentForm
{
    public function __construct($name = 'preferences', $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'New password',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-password',
                'required'    => true,
            ),
        ));
        
        $this->add(array(
            'name' => 'passwordConfirm',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Confirm your new Password',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-passwordConfirm',
                'required'    => true,
            ),
        ));
        
        $this->addSubmitFieldset('Save changes', 'btn btn-lg btn-primary btn-block');
    }
    
    public function getInputFilter()
    {
        if (!isset($this->filter)) {
            $filter = parent::getInputFilter();
            $filter->add(array(
                'name'       => 'password',
                'required'   => 'true',
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 8,
                            'max'      => 255,
                        ),
                    ),
                ),
            ));
            $filter->add(array(
                'name'       => 'passwordConfirm',
                'required'   => 'true',
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'      => 'Identical',
                        'options'   => array(
                            'token' => 'password',
                        ),
                    ),
                ),
            ));
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
    
}