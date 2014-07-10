<?php

namespace OmelettesStub\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;
use Zend\InputFilter\InputFilterAwareInterface;

class SignupForm extends AbstractDocumentForm
{
    public function __construct($name = 'signup', $options = array())
    {
        parent::__construct($name, $options);
        
        $this->add(array(
            'name' => 'emailAddress',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'Email Address',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-emailAddress',
                'required'    => true,
                'placeholder' => "We won't send you any junk",
            ),
        ));
        
        $this->add(array(
            'name' => 'fullName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Full Name',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-fullName',
                'required'    => true,
                'placeholder' => 'What shall we call you?',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Choose a Password',
            ),
            'attributes' => array(
                'id'          => $this->getName() . '-password',
                'required'    => true,
                'placeholder' => 'At least 8 characters long',
            ),
        ));
        
        $this->addSubmitFieldset('Sign Up', 'btn btn-lg btn-warning btn-block');
    }
    
}