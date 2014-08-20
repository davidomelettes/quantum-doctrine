<?php

namespace OmelettesDoctrine\Paginator;

use Zend\Paginator\Paginator as ZendPaginator;
use OmelettesDoctrine\Document as OmDoc;
use Omelettes\Tabulatable\TabulatableSetInterface;

class Paginator extends ZendPaginator implements TabulatableSetInterface
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
    
    public function getTableMock()
    {
        return $this->getMockDocument();
    }
    
}
