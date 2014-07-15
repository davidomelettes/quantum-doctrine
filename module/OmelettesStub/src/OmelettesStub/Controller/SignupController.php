<?php

namespace OmelettesStub\Controller;

use OmelettesStub\Form;
use OmelettesDoctrine\Controller\AbstractDoctrineController;
use OmelettesDoctrine\Document as OmDoc;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Annotation\AnnotationBuilder;

class SignupController extends AbstractDoctrineController
{
    public function signupAction()
    {
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $form = $this->createDocumentForm('OmelettesStub\Form\SignupForm', $usersService);
        $user = $usersService->createDocument();
        $form->bind($user);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $accountsService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\AccountsService');
                $account = $accountsService->createDocument();
                $accountsService->save($account);
                $user->setAccount($account);
                
                $usersService->save($user);
                $usersService->commit();
                $this->flashSuccess('Signup successful');
                return $this->redirect()->toRoute('front');
            }
        }
        
        return $this->returnViewModel(array(
            'title' => 'Sign Up',
            'form' => $form,
        ));
    }
    
}
