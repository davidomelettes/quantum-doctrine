<?php

namespace OmelettesDoctrineDeveloper\Db\Fixture;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class AbstractFixture
{
    /**
     * @var DocumentManager
     */
    protected $documentManager;
    
    protected $fixture;
    
    public function __construct(DocumentManager $dm)
    {
        $this->documentManager = $dm;
    }
    
    abstract public function parse($fixture);
    
    abstract public function insert();
    
}
