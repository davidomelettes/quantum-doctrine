<?php

namespace OmelettesDoctrineDeveloper\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesDoctrine\Service\SystemService;
use Zend\Console;
use Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleDbController extends AbstractController
{
    /**
     * @return SystemService
     */
    protected function getSystemService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\SystemService');
    }
    
    /**
     * @return Console\Console
     */
    public function getConsole()
    {
        return $this->getServiceLocator()->get('console');
    }
    
    public function initAction()
    {
        $console = $this->getConsole();
        $systemService = $this->getSystemService();
        $this->tellDbName();
        
        $console->write("Initialising the database...\n");
        $systemService->insertSystemUsers();
        $systemService->commit();
        $console->write("Database Initialised.\n");
    }
    
    protected function tellDbName()
    {
        $console = $this->getConsole();
        $console->write('Default database name: ');
        $console->write(sprintf("%s\n", $this->getSystemService()->getDefaultDatabaseName()), Console\ColorInterface::YELLOW);
    }
    
    public function createAction()
    {
        $console = $this->getConsole();
        $systemService = $this->getSystemService();
        $this->tellDbName();
        if ($systemService->checkDatabaseExists()) {
            $console->write("!ERROR! ", Console\ColorInterface::RED);
            $console->write("The default database already exists.\n");
            return;
        }
        
        $console->write("This action will CREATE the database.\n");
        
        $prompt = new Console\Prompt\Line('Are you sure you want to continue? [y/N]: ');
        $prompt->setAllowEmpty(true);
        $result = $prompt->show();
        if ($result !== 'y') {
            $console->write("Stopped.\n");
            return;
        }
        
        $console->write("Creating database...\n");
        $cli = $this->getServiceLocator()->get('doctrine.cli');
        $schemaCreateCommand = new CreateCommand();
        $cli->add($schemaCreateCommand);
        $input = new ArrayInput(array(
            'command' => 'odm:schema:create',
        ));
        $schemaCreateCommand->run($input, new ConsoleOutput());
        $console->write("Database created.\n");
        
        $prompt = new Console\Prompt\Line('Would you like to initialise the new database? [Y/n]: ');
        $prompt->setAllowEmpty(true);
        $result = $prompt->show();
        if ($result === 'n') {
            $console->write("Okay.\n");
            return;
        }
        
        $this->initAction();
    }
    
    public function dropAction()
    {
        $console = $this->getConsole();
        $systemService = $this->getSystemService();
        $this->tellDbName();
        if (!$systemService->checkDatabaseExists()) {
            $console->write("!ERROR! ", Console\ColorInterface::RED);
            $console->write("The default database does not exist.\n");
            return;
        }
        
        $console->write("!WARNING! ", Console\ColorInterface::RED);
        $console->write("This action will DROP the database!\n");
        
        $prompt = new Console\Prompt\Line('Are you sure you want to continue? [y/N]: ');
        $prompt->setAllowEmpty(true);
        $result = $prompt->show();
        if ($result !== 'y') {
            $console->write("Stopped.\n");
            return;
        }
        
        $console->write("Dropping database...\n");
        $systemService->dropDatabase();
        $console->write("Database dropped.\n");
    }
    
}
