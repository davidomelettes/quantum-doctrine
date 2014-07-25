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
        $now = new \DateTime();
        if (!$document->getId()) {
            // A new document
            $document->setCreated($now);
        }
        $document->setUpdated($now);
    
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
