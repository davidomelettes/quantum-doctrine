<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class UserPreferencesService extends AbstractDocumentService
{
    public function createDocument()
    {
        return new OmDoc\UserPreference($this);
    }
    
    public function save(OmDoc\UserPreference $pref)
    {
        return parent::save($pref);
    }
    
}
