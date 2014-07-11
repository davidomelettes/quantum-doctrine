<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class AccountsService extends AbstractDocumentService
{
    public function createDocument()
    {
        return new OmDoc\Account($this);
    }
    
    public function save(OmDoc\Account $account)
    {
        return parent::save($account);
    }
    
}
