<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class UsersService extends AbstractDocumentService
{
    public function createDocument()
    {
        return new OmDoc\User($this);
    }
    
    public function save(OmDoc\User $user)
    {
        return parent::save($user);
    }
    
}
