<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="accounts", requireIndexes=true)
 */
class Account extends AbstractHistoricDocument
{
    /**
     * @var string
     * @ODM\String
     */
    protected $accountName;
    
    public function setAccountName($name)
    {
        $this->accountName = $name;
        return $this;
    }
    
    public function getAccountName()
    {
        return $this->accountName;
    }
    
}