<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class UsersService extends AbstractHistoricDocumentService
{
    public function createDocument()
    {
        return new OmDoc\User($this);
    }
    
    public function save(OmDoc\User $user)
    {
        return parent::save($user);
    }
    
    public function signup(OmDoc\User $user)
    {
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $systemIdentity = $usersService->find('system');
        if (!$systemIdentity instanceof OmDoc\User) {
            throw new \Exception('Expected system User');
        }
    
        $now = new \DateTime();
        $user->setCreated($now);
        $user->setCreatedBy($systemIdentity);
        $user->setUpdated($now);
        $user->setUpdatedBy($systemIdentity);
    
        return AbstractDocumentService::save($user);
    }
    
}
