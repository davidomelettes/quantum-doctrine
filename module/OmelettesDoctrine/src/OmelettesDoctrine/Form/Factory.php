<?php

namespace OmelettesDoctrine\Form;

use Zend\Form;
use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Factory extends Form\Factory
{
    /**
     * @var DocumentManager
     */
    protected $documentManager;
    
    public function setDocumentManager(DocumentManager $dm)
    {
        $this->documentManager = $dm;
        return $this;
    }
    
    public function createForm($spec)
    {
        $form = parent::createForm($spec);
        if ($form instanceof AbstractDocumentForm) {
            $hydrator = new DoctrineHydrator($this->documentManager);
            $form->setHydrator($hydrator);
        }
        return $form;
    }
    
}
