<?php

namespace OmelettesDoctrine\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="accounts.plans", requireIndexes=true)
 */
class AccountPlan extends AbstractHistoricDocument
{
    /**
     * @var string
     * @ODM\String
     */
    protected $planName;
    
    public function setPlanName($name)
    {
        $this->planName = $name;
        return $this;
    }
    
    public function getPlanName()
    {
        return $this->planName;
    }
    
}