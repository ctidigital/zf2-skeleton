<?php

/**
 * CTI Digital
 *
 * @author Jason Brown <j.brown@ctidigital.com>
 */

namespace Api\Entity;

use Api\Entity\EntityInterface,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="messages")
 **/
/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"message" = "Api\Entity\Message", "tweet" = "Api\Entity\Tweet"})
 */
class Message implements EntityInterface
{
     /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="datetime", name="created")*/
    protected $created;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
    }
    
    /**
     * Returns entity id
     * @return int 
     */
    public function getId()
    {
        return $this->id;
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
    public function toArray()
    {
        return get_object_vars($this);
    }
}

