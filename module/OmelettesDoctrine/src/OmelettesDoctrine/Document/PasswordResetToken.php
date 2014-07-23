<?php

namespace OmelettesDoctrine\Document;

use Omelettes\Uuid\Uuid;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="userPasswordResetTokens", requireIndexes=true)
 */
class PasswordResetToken extends AbstractBaseClass
{
    /**
     * @var User
     * @ODM\ReferenceOne(targetDocument="User")
     * @ODM\UniqueIndex
     */
    protected $user;
    
    /**
     * @var string
     * @ODM\String
     * @ODM\Index
     */
    protected $tokenHash;
    
    /**
     * @var \DateTime
     * @ODM\Date
     * @ODM\Index
     */
    protected $expiry;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setTokenHash($hash)
    {
        $this->tokenHash = $hash;
        return $this;
    }
    
    public function getTokenHash()
    {
        return $this->tokenHash;
    }
    
    public function setExpiry(\DateTime $expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }
    
    public function getExpiry()
    {
        return $this->expiry;
    }
    
    public function setToken($token)
    {
        $hash = $this->hashToken($token);
        $this->setTokenHash($hash);
        return $this;
    }
    
    public function hashToken($token)
    {
        return hash('sha256', $token);
    }
    
}
