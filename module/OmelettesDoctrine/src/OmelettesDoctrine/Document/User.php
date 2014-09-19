<?php

namespace OmelettesDoctrine\Document;

use Omelettes\Uuid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\InputFilter;

/**
 * @ODM\Document(collection="users", requireIndexes=true)
 */
class User extends AbstractAccountBoundHistoricDocument
{
    /**
     * @var string
     * @ODM\String
     */
    protected $aclRole = 'guest';
    
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
    protected $email;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $pwHash;
    
    /**
     * @var string
     * @ODM\String
     */
    protected $salt;
    
    protected $tz;
    
    /**
     * @var array
     * @ODM\EmbedMany(
     *     targetDocument="UserPreference",
     *     discriminatorField="type",
     *     discriminatorMap={
     *         "boolean"="UserPreferenceBoolean",
     *         "string"="UserPreferenceString",
     *         "int"="UserPreferenceInteger",
     *         "date"="UserPreferenceDate"
     *     }
     * )
     */
    protected $preferences = array();
    
    public function setAclRole($role)
    {
        $this->aclRole = $role;
        return $this;
    }
    
    public function getAclRole()
    {
        return $this->aclRole;
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
    
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->email;
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
        $this->pwHash = $this->hashPassword($plaintext);
        return $this;
    }
    
    public function getPwHash()
    {
        return $this->pwHash;
    }
    
    public function getPreferences()
    {
        return $this->preferences;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $filter = parent::getInputFilter();
            
            $filter->add(array(
                'name'			=> 'email',
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
                    /*
                    array(
                        'name'                  => 'OmelettesDoctrine\Validator\Document\DoesNotExist',
                        'options'               => array(
                            'field'            => 'emailAddress',
                            'messages' => array(
                                \OmelettesDoctrine\Validator\Document\DoesNotExist::ERROR_DOCUMENT_EXISTS => 'A user with that email address already exists',
                            ),
                        ),
                    ),
                    */
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
            
            $this->inputFilter = $filter;
        }
        
        return $this->inputFilter;
    }
    
}
