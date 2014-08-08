<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

abstract class AbstractHistoricDocumentService extends AbstractDocumentService
{
    protected function createDefaultFindQuery()
    {
        $qb = parent::createDefaultFindQuery();
        $qb->field('deleted')->exists(false);
        return $qb;
    }
    
    public function save(OmDoc\AbstractHistoricDocument $document)
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$authService->hasIdentity()) {
            throw new \Exception('Missing authentication identity');
        }
        $identity = $auth->getIdentity();
        if (!$identity instanceof User) {
            throw new \Exception('Expected a User');
        }
        
        $now = new \DateTime();
        if (!$document->getId()) {
            // A new document
            $document->setCreated($now);
            $document->setCreatedBy($identity);
        }
        $document->setUpdated($now);
        $document->setUpdatedBy($identity);
    
        return parent::save($document);
    }
    
    /**
     * Historic documents are not removed from the database when deleted
     */
    public function delete(OmDoc\AbstractHistoricDocument $document)
    {
        $now = new \DateTime();
        $document->setDeleted($now);
        $this->documentManager->persist($document);
        return $this;
    }
    
}
