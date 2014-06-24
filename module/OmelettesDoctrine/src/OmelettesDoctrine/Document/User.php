<?php

namespace OmelettesDoctrine\Document;

use Omelettes\Uuid\Uuid;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="users", requireIndexes=true)
 */
class User extends AbstractBaseClass
{
    /**
     * @var string
     * @ODM\String
     */
    protected $fullName;
    
    /**
     * @var string
     * @ODM\String
     * @ODM\UniqueIndex
     */
    protected $emailAddress;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $passwordHash;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $salt;
    
    public function setFullName($name)
    {
        $this->fullName = $name;
        return $this;
    }
    
    public function getFullName()
    {
        return $this->fullName;
    }
    
    public function setEmailAddress($email)
    {
        $this->emailAddress = $email;
        return $this;
    }
    
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
    
    public function hashPassword($plaintext)
    {
        if (!$this->salt) {
            throw new \Exception('Missing salt');
        }
        return hash('sha256', $plaintext.$this->salt);
    }
    
    public function setPlaintextPassword($plaintext)
    {
        $uuid = new Uuid();
        $this->salt = $uuid->v4();
        $this->passwordHash = $this->hashPassword($plaintext);
        return $this;
    }
    
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }
    
}