<?php

namespace TactileSignup\Controller;

use TactileSignup\Form;
use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service as OmService;

class SignupController extends AbstractDoctrineController
{
    /**
     * @return OmService\AccountsService
     */
    public function getAccountsService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\AccountsService');
    }
    
    /**
     * @return OmService\UsersService
     */
    public function getUsersService()
    {
        return $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
    }
    
    public function signupAction()
    {
        $form = $this->getManagedForm('TactileSignup\Form\SignupForm');
        $usersService = $this->getUsersService();
        $user = $usersService->createDocument();
        $form->bind($user);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // Create a new account
                $accountsService = $this->getAccountsService();
                $account = $accountsService->createDocument();
                $accountsService->signup($account);
                
                // Create user
                $user->setAccount($account)
                     ->setAclRole('admin');
                $usersService->signup($user);
                
                // Sign in as user
                $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $auth->getStorage()->write($user);
                
                // Add resources to account 
                $this->createResources();
                
                $usersService->commit();
                $this->flashSuccess('Signup successful');
                return $this->redirect()->toRoute('dash');
            } else {
                $this->flashError('There was a problem with the data you entered');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'Sign up to Tactile CRM',
            'form' => $form,
        ));
    }
    
    public function createResources()
    {
        $config = $this->getServiceLocator()->get('config');
        if (!isset($config['signup'])) {
            var_dump($config);
            throw new \Exception('Expected signup config');
        }
        $resources = $config['signup']['resources'];
        $resourcesService = $this->getServiceLocator()->get('Tactile\Service\ResourcesService');
        foreach ($resources as $resource) {
            $document = $resourcesService->createDocument();
            $document->setSlug($resource['slug']);
            $document->setSingular($resource['singular']);
            $document->setPlural($resource['plural']);
            $document->setProtected(true);
            $resourcesService->save($document);
        }
    }
    
}
