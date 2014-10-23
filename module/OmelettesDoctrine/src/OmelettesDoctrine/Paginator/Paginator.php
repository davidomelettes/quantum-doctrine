<?php

namespace OmelettesDoctrine\Paginator;

use Zend\Paginator\Paginator as ZendPaginator;
use OmelettesDoctrine\Document as OmDoc;
use Omelettes\Tabulate\TabulateSetInterface;

class Paginator extends ZendPaginator implements TabulateSetInterface
{
    /**
     * @var OmDoc\AbstractDocument
     */
    protected $mockDocument;
    
    public function setMockDocument(OmDoc\AbstractDocument $doc)
    {
        $this->mockDocument = $doc;
        return $this;
    }
    
    /**
     * @return OmDoc\AbstractDocument
     */
    public function getMockDocument()
    {
        return $this->mockDocument;
    }
    
    public function getTabulateMock()
    {
        return $this->getMockDocument();
    }
    
    public function getTabulateItems()
    {
        return $this->getCurrentItems();
    }
    
}
