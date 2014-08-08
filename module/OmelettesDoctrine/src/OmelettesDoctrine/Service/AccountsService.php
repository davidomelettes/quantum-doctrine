<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class AccountsService extends AbstractHistoricDocumentService
{
    public function createDocument()
    {
        return new OmDoc\Account($this);
    }
    
    public function save(OmDoc\Account $account)
    {
        return parent::save($account);
    }
    
    public function signup(OmDoc\Account $account)
    {
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $systemIdentity = $usersService->find('system');
        if (!$systemIdentity instanceof OmDoc\User) {
            throw new \Exception('Expected system User');
        }
    
        $now = new \DateTime();
        $account->setCreated($now);
        $account->setCreatedBy($systemIdentity);
        $account->setUpdated($now);
        $account->setUpdatedBy($systemIdentity);
    
        return AbstractDocumentService::save($account);
    }
    
}
