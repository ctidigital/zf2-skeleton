<?php

/**
 * Parrot Framework
 * 
 * @author Jason Brown <jason.brown@jbfreelance.co.uk>
 */

namespace Core\Entity;

use Core\Entity\EntityInterface,
    Core\Entity\RegistrationEntityInterface,
    Core\Entity\Facebook\User as FacebookUser,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="registrations")
 **/
class Registration implements EntityInterface, RegistrationEntityInterface
{
     /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Facebook\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="facebook_user", referencedColumnName="id")
     */
    protected $facebookUser;
    
    /** @ORM\Column(type="string") **/
    protected $first;
    /** @ORM\Column(type="string") **/
    protected $last;
    /** @ORM\Column(type="date") **/
    protected $dob;
    /** @ORM\Column(type="string", name="email_address", unique=true) **/
    protected $emailAddress;
    /** @ORM\Column(type="datetime", name="created")*/
    protected $created;
    
    /**
     * Constructor
     * @param string $first
     * @param string $last
     * @param string $dob
     * @param string $email 
     */
    public function __construct($first, $last, $dob, $email)
    {
        $this->first = $first;
        $this->last = $last;
        $this->dob = $dob;
        $this->emailAddress = $email;
        $this->created = new \DateTime();
    }
    
    /**
     * Returns id of registration entity
     * @return int 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Returns registrant's first name
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first;
    }
    
    /**
     * Sets registrant's first name
     * @param string $first
     * @return \Core\Entity\RegistrationEntity 
     */
    public function setFirstName($first)
    {
        $this->first = $first;
        return $this;
    }
    
    /**
     * Returns last name of registrant
     * @return string 
     */
    public function getLastName()
    {
        return $this->last;
    }
    
    /**
     * Sets last name of registrant
     * @param string $last
     * @return \Core\Entity\RegistrationEntity 
     */
    public function setLastName($last)
    {
        $this->last = $last;
        return $this;
    }
    
    /**
     * Returns registrant's Date of Birth
     * @return string 
     */
    public function getDob()
    {
        return $this->dob;
    }
    
    /**
     * Sets Date of Birth for registrant 
     * @param string $dob
     * @return \Core\Entity\RegistrationEntity 
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }
    
    /**
     * Returns Email Address used to register
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->emailAdress;
    }
    
    /**
     * Sets Email Address
     * @param string $email
     * @return \Core\Entity\RegistrationEntity 
     */
    public function setEmailAddress($email)
    {
        $this->emailAddress = $email;
        return $this;
    } 
    
    /**
     * Gets Facebook User
     * @return \Core\Entity\Facebook\User
     */
    public function getFacebookUser()
    {
        return $this->facebookUser;
    }
    
    /**
     * Sets Facebook User
     * @param \Core\Entity\Facebook\User $fbUser
     * @return \Core\Entity\Registration
     */
    public function setFacebookUser(\Core\Entity\Facebook\User $fbUser)
    {
        $this->facebookUser = $fbUser;
        return $this;
    }
    
    /**
     * Returns date/time of when registration was created
     * @param string $format
     * @return \DateTime 
     */
    public function getCreated($format = "d-m-Y H:i:s")
    {
        return $this->created->format($format);
    }
    
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }
}

