<?php

namespace OmelettesStub\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter;

class VerifyPasswordForm extends AbstractDocumentForm
{
    public function __construct($name = 'password', $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function init()
    {
        $this->add(array(
            'name'  => 'emailAddress',
            'type'  => 'Omelettes\Form\Element\StaticValue',
            'options' => array(
                'label' => 'Email Address',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-password',
                'required'    => true,
            ),
        ));
        
        $this->addSubmitFieldset('Continue', 'btn btn-lg btn-primary btn-block');
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
            $this->filter = $filter;
        }
        
        return $this->filter;
    }
    
}