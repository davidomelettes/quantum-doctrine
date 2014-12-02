<?php

namespace TactileAdmin\Form\Fieldset;

use Tactile\Document;

class CustomFieldUserFieldset extends CustomFieldFieldset
{
    public function init()
    {
        parent::init();
        $this->setAllowedObjectBindingClass('Tactile\Document\ResourceFieldUser');
        $this->setObject(new Document\ResourceFieldUser());
    
        $this->add(array(
            'name'       => 'label',
            'type'       => 'Text',
            'options'    => array(
                'label' => 'User Field Label',
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
                'value' => 'u',
            ),
        ));
        
        $userOptions = array(
            ''   => '-- None --',
            'me' => 'Current User',
        );
        $usersService = $this->getApplicationServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        foreach ($usersService->fetchAllAccountUsers() as $user) {
            $userOptions[$user->getId()] = $user->getFullName();
        }
        
        $this->add(array(
            'name'       => 'default',
            'type'       => 'Select',
            'options'    => array(
                'label'   => 'Default Value',
                'options' => $userOptions,
            ),
            'attributes' => array(
            ),
        ));
    }
    
}
