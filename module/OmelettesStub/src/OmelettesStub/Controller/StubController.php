<?php

namespace OmelettesStub\Controller;

use Omelettes\Controller\AbstractController;
use OmelettesDoctrine\Document as OmDoc;

use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class StubController extends AbstractController
{
    public function helloWorldAction()
    {
        $this->flashInfo('Hello World!');
        $this->flashError('Bad things');
        
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
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
