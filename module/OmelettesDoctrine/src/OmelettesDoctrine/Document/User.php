<?php

namespace OmelettesDoctrine\Document;

use Omelettes\Uuid\Uuid;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="users", requireIndexes=true)
 */
class User extends AbstractBaseClass
{
    /**
     * @var Account
     * @ODM\ReferenceOne(targetDocument="Account")
     */
    protected $account;
    
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
    
    public function setAccount(Account $account)
    {
        $this->account = $account;
        return $this;
    }
    
    public function getAccount()
    {
        return $this->account;
    }
    
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
    
    public function setPassword($plaintext)
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
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            $factory = $filter->getFactory();
            
            $filter->add(array(
                'name'			=> 'emailAddress',
                'required'		=> 'true',
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                ),
                'validators'	=> array(
                    array(
                        'name'		             => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options'	             => array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 1,
                            'max'		=> 255,
                        ),
                    ),
                    array(
                        'name'                   => 'Zend\Validator\EmailAddress',
                        'break_chain_on_failure' => true,
                        'options'                => array(
                            'messages' => array(
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Please enter a valid email address',
                            ),
                        ),
                    ),
                    array(
                        'name'                  => 'OmelettesDoctrine\Validator\Document\DoesNotExist',
                        'options'               => array(
                            'field'            => 'emailAddress',
                            'document_service' => $this->documentService,
                        ),
                    ),
                ),
            ));
            
            $filter->add(array(
                'name'			=> 'fullName',
                'required'		=> 'true',
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                ),
                'validators'	=> array(
                    array(
                        'name'		=> 'StringLength',
                        'options'	=> array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 1,
                            'max'		=> 255,
                        ),
                    ),
                ),
            ));
            
            $filter->add(array(
                'name'			=> 'password',
                'required'		=> 'true',
                'filters'		=> array(
                    array('name' => 'StringTrim'),
                ),
                'validators'	=> array(
                    array(
                        'name'		=> 'StringLength',
                        'options'	=> array(
                            'encoding'	=> 'UTF-8',
                            'min'		=> 8,
                            'max'		=> 255,
                        ),
                    ),
                ),
            ));
        }
        
        return $this->inputFilter;
    }
    
}