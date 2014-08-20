<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class SystemService extends AbstractDocumentService
{
    public function createDocument()
    {
        throw new \Exception('Method not used');
    }
    
    public function insertSystemUsers()
    {
        $now = new \DateTime();
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $system = $usersService->createDocument();
        $system->setData(array(
            'id'           => 'system',
            'fullName'     => 'The Robot',
            'emailAddress' => 'system',
            'aclRole'      => 'system',
            'created'      => $now,
            'updated'      => $now,
        ));
        $this->documentManager->persist($system);
        
        $console = $usersService->createDocument();
        $console->setData(array(
            'id'           => 'console',
            'fullName'     => 'Superuser Console',
            'emailAddress' => 'console',
            'aclRole'      => 'system',
            'created'      => $now,
            'updated'      => $now,
        ));
        $this->documentManager->persist($console);
        
        return $this;
    }
    
}
