<?php

namespace OmelettesStub\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;

use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class StubController extends AbstractDoctrineController
{
    /**
     * @return Service\UsersService
     */
    public function getUsersService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
    }
    
    public function helloWorldAction()
    {
        $auth = $this->getAuthenticationService();
        //var_dump($auth->getIdentity());
        $this->flashInfo('Hello World!');
        $this->flashError('Bad things');
        
        $usersService = $this->getUsersService();
        $user = $usersService->createDocument();
        $user->setFullName('David Edwards');
        $user->setEmailAddress('david@omelett.es');
        //$user->setPlaintextPassword('password');
        $usersService->save($user);
        //$usersService->commit();

        $paginator = $usersService->fetchAll();
        //$paginator->setCurrentPageNumber(1)->setItemCountPerPage(5);
        
        foreach ($paginator as $foo) {
            //var_dump($foo);
            //$account = $foo->getAccount();
            //var_dump($account);
            //var_dump($account->getCreated());
            //var_dump($account);
        } 
        
        return $this->returnViewModel();
    }
    
}
