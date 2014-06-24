<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;
use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class UsersService extends AbstractDocumentService
{
    public function save(OmDoc\User $user)
    {
        $now = new \DateTime();
        if (!$user->getId()) {
            $user->setCreated($now);
        }
        $user->setUpdated($now);
        
        $this->documentManager->persist($user);
        return $this;
    }
    
}
