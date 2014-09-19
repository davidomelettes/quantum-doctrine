<?php

namespace OmelettesDoctrine\Service;

use Doctrine\MongoDB\Connection;
use OmelettesDoctrine\Document as OmDoc;

class SystemService extends AbstractDocumentService
{
    public function createDocument()
    {
        throw new \Exception('Method not used');
    }
    
    /**
     * @var Connection
     */
    protected function getDatabaseConnection()
    {
        $dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        return $dm->getConnection();
    }
    
    public function getDefaultDatabaseName()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['doctrine']['configuration']['odm_default']['default_db'];
    }
    
    public function checkDatabaseExists()
    {
        $exists = false;
        $list = $this->getDatabaseConnection()->listDatabases();
        $name = $this->getDefaultDatabaseName();
        foreach ($list['databases'] as $db) {
            if ($db['name'] === $name) {
                $exists = true;
                continue;
            }
        }
        return $exists;
    }
    
    public function dropDatabase()
    {
        $mongo = $this->getDatabaseConnection();
        return $mongo->dropDatabase($this->getDefaultDatabaseName());
    }
    
    public function insertSystemUsers()
    {
        $now = new \DateTime();
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $system = $usersService->createDocument();
        $system->setData(array(
            'id'       => 'system',
            'fullName' => 'The Robot',
            'email'    => 'system',
            'aclRole'  => 'system',
            'created'  => $now,
            'updated'  => $now,
        ));
        $this->documentManager->persist($system);
        
        $console = $usersService->createDocument();
        $console->setData(array(
            'id'       => 'console',
            'fullName' => 'Superuser Console',
            'email'    => 'console',
            'aclRole'  => 'system',
            'created'  => $now,
            'updated'  => $now,
        ));
        $this->documentManager->persist($console);
        
        return $this;
    }
    
}
