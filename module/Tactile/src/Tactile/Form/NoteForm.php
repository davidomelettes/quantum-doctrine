<?php

namespace Tactile\Form;

use Omelettes\Form\ViewPartialInterface;
use OmelettesDoctrine\Form\AbstractDocumentForm;

class NoteForm extends AbstractDocumentForm implements ViewPartialInterface
{
    public function init()
    {
        $this->setName('note');
        
        $this->add(array(
            'name' => 'body',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Note',
            ),
        ));
        
        /*
        $this->add(array(
            'name' => 'private',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'Private',
            ),
        ));
        */
        
        $this->addSubmitFieldset('Add Note', 'btn btn-success btn-block');
    }
    
    public function getViewPartial()
    {
        return 'form/note';
    }
    
}