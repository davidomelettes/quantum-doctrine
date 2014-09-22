<?php

namespace Tactile\Form\Fieldset;

use OmelettesDoctrine\Form\Fieldset\AbstractDocumentFieldset;

class PreferencesFieldset extends AbstractDocumentFieldset
{
    public function init()
    {
        $this->setName('prefs');
        $this->setAllowedObjectBindingClass('OmelettesDoctrine\Document\UserPreferences');
        
        $localesService = $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Service\LocalesService');
        $tzOptions = $localesService->getTimeZones();
        $this->add(array(
            'name'       => 'tz',
            'type'       => 'Select',
            'options'    => array(
                'label'         => 'Time Zone',
                'value_options' => $tzOptions,
            ),
            'attributes' => array(
                'id'           => $this->getName() . '-tz',
                'required'     => true,
            ),
        ));
    }
    
}
