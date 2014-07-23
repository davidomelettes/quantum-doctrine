<?php

namespace OmelettesDoctrine\Service\Auth;

use OmelettesDoctrine\Document as OmDoc;
use OmelettesDoctrine\Service;

class PersistentLoginTokensService extends Service\AbstractDocumentService
{
    public function createDocument()
    {
        return new OmDoc\PersistentLoginToken($this);
    }
    
    public function removeExpiredTokens()
    {
        $qb = $this->createQueryBuilder();
        $qb->remove()
           ->field('expiry')->lte(new \DateTime('now'));
        $query = $qb->getQuery();
        $query->execute();
    }
    
    protected function createDefaultFindQuery()
    {
        $qb = $this->documentManager->createQueryBuilder(get_class($this->createDocument()));
        $qb->find()
           ->field('expiry')->gt(new \DateTime('now'));
        return $qb;
    }
    
    public function removeTokensForUser(OmDoc\User $user)
    {
        $qb = $this->createQueryBuilder();
        $qb->remove()
           ->field('user.id')->equals($user->getId());
        $query = $qb->getQuery();
        $query->execute();
    }
    
    public function save(OmDoc\PersistentLoginToken $token)
    {
        //Delete existing token for user
        if (!$token->getUser()) {
            throw new \Exception('Token has no user');
        }
        $this->removeTokensForUser($token->getUser());
    
        // Save new token
        return parent::save($token);
    }
    
    /**
     * @param string $userId
     * @param string $token
     * @return boolean|OmDoc\UserPasswordResetToken
     */
    public function findByUserIdAndToken($userId, $token)
    {
        // Hash token and find matching document
        $qb = $this->createDefaultFindQuery();
        $tokenHash = hash('sha256', $token);
        $qb->field('user.id')->equals($userId)
           ->field('tokenHash')->equals($tokenHash);
    
        $result = $qb->getQuery()->getSingleResult();
        $this->commit();
    
        return $result;
    }
    
    public function removeToken(OmDoc\PersistentLoginToken $token)
    {
        $this->documentManager->remove($token);
    }
}
