<?php

namespace OmelettesDoctrine\Service;

use OmelettesDoctrine\Document as OmDoc;

class UserPasswordResetTokensService extends AbstractDocumentService
{
    public function createDocument()
    {
        return new OmDoc\UserPasswordResetToken($this);
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
        $qb->find();
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
    
    public function save(OmDoc\UserPasswordResetToken $token)
    {
        //Delete existing token for user
        if (!$token->getUser()) {
            throw new \Exception('Token has no user');
        }
        $this->removeTokensForUser($token->getUser());
        
        return parent::save($token);
    }
    
    /**
     * @param string $userId
     * @param string $token
     * @return boolean|OmDoc\UserPasswordResetToken
     */
    public function findByUserIdAndToken($userId, $token)
    {
        // Remove any expired tokens
        $this->removeExpiredTokens();
        
        // Hash token and find matching document
        $qb = $this->createDefaultFindQuery();
        $tokenHash = hash('sha256', $token);
        $qb->field('user.id')->equals($userId)
           ->field('tokenHash')->equals($tokenHash);
        
        $result = $qb->getQuery()->getSingleResult();
        $this->commit();
        
        return $result;
    }
    
    public function removeToken(OmDoc\UserPasswordResetToken $token)
    {
        $this->documentManager->remove($token);
    }
    
}
