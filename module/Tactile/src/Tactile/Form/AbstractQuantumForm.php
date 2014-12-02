<?php

namespace Tactile\Form;

use OmelettesDoctrine\Form\AbstractDocumentForm;

abstract class AbstractQuantumForm extends AbstractDocumentForm
{
    public function getHydrator()
    {
        return $this->getApplicationServiceLocator()->get('Tactile\Stdlib\Hydrator\QuantumHydrator');
    }
    
}
