<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

abstract class AbstractAccountBoundDocumentService extends AbstractDocumentService
{
    protected function getAccount()
    {
        $identity = $this->getIdentity();
        $account = $identity->getAccount();
        if (!$account instanceof OmDoc\Account) {
            throw new \Exception('Expected an Account');
        }
        return $account;
    }
    
    protected function createDefaultFindQuery()
    {
        $account = $this->getAccount();
        $qb = parent::createDefaultFindQuery();
        $qb->field('account.id')->equals($account->getId());
        return $qb;
    }
    
    public function save(OmDoc\AbstractAccountBoundDocument $document)
    {
        $account = $this->getAccount();
        $document->setAccount($account);
    
        return parent::save($document);
    }
    
}
