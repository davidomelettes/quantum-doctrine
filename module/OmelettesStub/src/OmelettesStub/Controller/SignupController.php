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
        $form = $this->createForm('OmelettesStub\Form\SignupForm');
        $usersService = $this->getServiceLocator()->get('OmelettesDoctrine\Service\UsersService');
        $user = $usersService->createDocument();
        $form->bind($user);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
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
