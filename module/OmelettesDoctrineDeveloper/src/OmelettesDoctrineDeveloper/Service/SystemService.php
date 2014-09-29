<?php

namespace OmelettesDoctrineDeveloper\Service;

use Doctrine\Common\DataFixtures;
use Doctrine\MongoDB\Connection;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service as OmService;
use OmelettesDoctrineDeveloperFixtures as Fixtures;

class SystemService extends OmService\AbstractDocumentService
{
    /**
     * @var DataFixtures\Purger\PurgerInterface
     */
    protected $purger;
    
    /**
     * @var DataFixtures\Executor\AbstractExecutor
     */
    protected $executor;
    
    public function createDocument()
    {
        throw new \Exception('Method not used');
    }
    
    public function getFixturePurger()
    {
        if (!$this->purger) {
            $purger = new DataFixtures\Purger\MongoDBPurger();
            $this->purger = $purger;
        }
        return $this->purger;
    }
    
    public function getFixtureExecutor()
    {
        if (!$this->executor) {
            $executor = new DataFixtures\Executor\MongoDBExecutor($this->getDocumentManager(), $this->getFixturePurger());
            $this->executor = $executor;
        }
        return $this->executor;
    }
    
    public function getDocumentManager()
    {
        return $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
    }
    
    /**
     * @var Connection
     */
    public function getDatabaseConnection()
    {
        $dm = $this->getDocumentManager();
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
    
    public function loadAndExecuteFixture(DataFixtures\FixtureInterface $fixture, $append = false)
    {
        $loader = new DataFixtures\Loader();
        $loader->addFixture($fixture);
        
        $executor = $this->getFixtureExecutor();
        $executor->execute($loader->getFixtures(), $append);
        
        return $this;
    }
    
    public function insertSystemUsers()
    {
        $this->loadAndExecuteFixture(new Fixtures\LoadSystemUsers(), true);
        
        return $this;
    }
    
    public function insertLocaleData()
    {
        $this->loadAndExecuteFixture(new Fixtures\LoadLocaleData(), true);
        
        return $this;
    }
    
}
