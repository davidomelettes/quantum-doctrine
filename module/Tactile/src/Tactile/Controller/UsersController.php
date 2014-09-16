<?php

namespace Tactile\Controller;

use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;

class UsersController extends AbstractDoctrineController
{
    /**
     * @return Service\UsersService
     */
    public function getUsersService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
    }
    
    /**
     * @return OmDoc\User|boolean
     */
    public function loadRequestedUser()
    {
        $usersService = $this->getUsersService();
        $id = $this->params('id');
        return $usersService->find($id);
    }
    
    public function indexAction()
    {
        $usersService = $this->getUsersService();
        $users = $usersService->fetchAll();
        
        return $this->returnViewModel(array(
            'title' => 'Users',
            'users' => $users,
        ));
    }
    
    public function viewAction()
    {
        $user = $this->loadRequestedUser();
        if (!$user) {
            $this->flashError('Unable to locate requested user');
            return $this->redirect()->toRoute('users');
        }
        
        return $this->returnViewModel(array(
            'title' => 'Users',
        ));
    }
    
    
}
