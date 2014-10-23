<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
abstract class AbstractAccountBoundDocument extends AbstractDocument
{
    /**
     * @var Account
     * @ODM\ReferenceOne(targetDocument="OmelettesDoctrine\Document\Account")
     * @ODM\Index
     */
    protected $account;
    
    public function setAccount(Account $account)
    {
        $this->account = $account;
        return $this;
    }
    
    public function getAccount()
    {
        return $this->account;
    }
    
}