<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use OmelettesDoctrine\Paginator\Paginator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

abstract class AbstractDocumentService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    /**
     * @var OmDoc\AbstractDocument
     */
    protected $document;
    
    /**
     * @var DocumentManager
     */
    protected $documentManager;
    
    public function __construct(DocumentManager $dm)
    {
        $this->documentManager = $dm;
    }
    
    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->documentManager;
    }
    
    /**
     * @return OmDoc\AbstractDocument
     */
    abstract function createDocument();
    
    /**
     * Query Builders should not be reused!
     * @return Query\Builder
     */
    final protected function createQueryBuilder()
    {
        $qb = $this->documentManager->createQueryBuilder(get_class($this->createDocument()));
        return $qb;
    }
    
    /**
     * Allows us to specify default constraints
     * @return Query\Builder
     */
    protected function createDefaultFindQuery()
    {
        $qb = $this->createQueryBuilder();
        $qb->find();
        $this->defaultSort($qb);
        return $qb;
    }
    
    /**
     * Apply a sort to the default query
     * @return Query\Builder
     */
    protected function defaultSort(Query\Builder $qb)
    {
        return $qb;
    }
    
    /**
     * Generates a new Paginator instance for the given Cursor
     * @return Paginator
     */
    protected function getPaginator(Cursor $cursor)
    {
        $paginator = new Paginator(new DoctrinePaginator($cursor));
        $paginator->setMockDocument($this->createDocument());
        return $paginator;
    }
    
    public function find($id)
    {
        return $this->findBy('id', $id);
    }
    
    public function findBy($field, $value)
    {
        $qb = $this->createDefaultFindQuery();
        $qb->field($field)->equals($value);
        return $qb->getQuery()->getSingleResult();
    }
    
    /**
     * @return Paginator
     */
    public function fetchAll()
    {
        $qb = $this->createDefaultFindQuery();
        $cursor = $qb->getQuery()->execute();
        return $this->getPaginator($cursor);
    }
    
    public function save(OmDoc\AbstractDocument $document)
    {
        $this->documentManager->persist($document);
        return $this;
    }
    
    public function delete(OmDoc\AbstractDocument $document)
    {
        // Delete for reals!
        $this->documentManager->remove($document);
        return $this;
    }
    
    public function commit()
    {
        $this->documentManager->flush();
        return $this;
    }
    
}
