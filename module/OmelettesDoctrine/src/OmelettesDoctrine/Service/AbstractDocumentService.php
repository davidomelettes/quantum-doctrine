<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query;
use DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
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
     * Allows us to specify default constraints
     * Query Builders should not be reused
     */
    protected function getDefaultQueryBuilder()
    {
        $qb = $this->documentManager->createQueryBuilder(get_class($this->createDocument()));
        $qb->find()
           ->field('deleted')->exists(false);
        return $qb;
    }
    
    /**
     * Generates a new Paginator instance for the given Cursor
     * @return Paginator
     */
    protected function getPaginator(Cursor $cursor)
    {
        return new Paginator(new DoctrinePaginator($cursor));
    }
    
    public function find($id)
    {
        $qb = $this->getDefaultQueryBuilder()
                   ->field('id')->equals($id);
        return $qb->getQuery()->getSingleResult();
    }
    
    public function findBy($field, $value)
    {
        $qb = $this->getDefaultQueryBuilder()->find()
                   ->field($field)->equals($value);
        return $qb->getQuery()->getSingleResult();
    }
    
    /**
     * @return Paginator
     */
    public function fetchAll()
    {
        $cursor = $this->getDefaultQueryBuilder()->find()->getQuery()->execute();
        return $this->getPaginator($cursor);
    }
    
    public function save(OmDoc\AbstractBaseClass $document)
    {
        $now = new \DateTime();
        if (!$document->getId()) {
            $document->setCreated($now);
        }
        $document->setUpdated($now);
        
        $this->documentManager->persist($document);
        return $this;
    }
    
    public function commit()
    {
        $this->documentManager->flush();
        return $this;
    }
    
}