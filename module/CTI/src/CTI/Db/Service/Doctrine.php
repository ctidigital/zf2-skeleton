<?php

/**
 * CTI Digital
 *
 * @author Jason Brown <j.brown@ctidigital.com>
 */

namespace CTI\Db\Service;

use CTI\Db\DatabaseInterface,
    CTI\Entity\EntityInterface,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Log\Writer\Stream,
    Zend\Log\Logger,
    DoctrineORMModule\Service\EntityManagerFactory,
    Doctrine\DBAL\DBALException;

class Doctrine implements DatabaseInterface, ServiceLocatorAwareInterface
{
    /**
     * @var \DoctrineORMModule\Service\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Zend\ServiceManager
     */
    protected $serviceLocator;

    /**
     * Insert entity into database
     * @param \CTI\Entity\EntityInterface $entity
     * @return \CTI\Entity\EntityInterface|boolean
     */
    public function insert(EntityInterface $entity)
    {
        try{
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
            
            return $entity;
        }catch(DBALException $e){
            // Log error
            $this->logError($e->getMessage());
        }
        
        return false;
    }

    /**
     * Update entity into database
     * @param \CTI\Entity\EntityInterface $entity
     * @return \CTI\Entity\EntityInterface|boolean
     */
    public function update(EntityInterface $entity)
    {
        try{
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
            
            return $entity;
        }catch(DBALException $e){
            // Log error
            $this->logError($e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Delete entity from database
     * @param \CTI\Entity\EntityInterface $entity
     * @return \CTI\Entity\EntityInterface|boolean
     */
    public function delete(EntityInterface $entity)
    {
        try{
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
            
            return $entity;
        }catch(DBALException $e){
            // Log error
            $this->logError($e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Find entity by it's id
     * @param string $entityName
     * @param int $id
     * @return object The entity
     */
    public function find($entityName, $id)
    {
        return $this->getEntityManager()
                ->getRepository($entityName)
                ->find($id);
    }

    /**
     * Find entity by criteria 
     * @param string $entityName
     * @param mixed $criteria
     * @param mixed $orderBy
     * @param int | null $limit
     * @param int | null $offset
     * @return object The Entity
     */
    public function findBy($entityName, $criteria = array(), $orderBy = array(), $limit = null, $offset = null)
    {
       return $this->getEntityManager()
                    ->getRepository($entityName)
                    ->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    /**
     * Find One entity by criteria
     * @param string $entityName
     * @param mixed $criteria
     * @param mixed $orderBy
     * @return object The entity
     */
    public function findOneBy($entityName, $criteria = array(), $orderBy = array())
    {
        return $this->getEntityManager()
                    ->getRepository($entityName)
                    ->findOneBy($criteria, $orderBy);
    }
    
    /**
     * Returns the entity manager
     * @return \DoctrineORMModule\Service\EntityManager
     */
    public function getEntityManager()
    {
        // Check if Entity Manager is open
        // If it's closed, usually this means there has been an error
        if(!$this->entityManager->isOpen())
        {
            // We want to recover and create a new instance of the entity manager
            $em = new EntityManagerFactory('orm_default');
            $this->entityManager = $em->createService($this->serviceLocator);
            
            // But we should also create an error in the log
            $this->logError('Doctrine Entity Manager was closed. An exception occurred.');
        }
        
        return $this->entityManager;
    }
    
    /**
     * Sets the entity manager
     * @param \DoctrineORMModule\Service\EntityManager $em
     * @return \CTI\Db\Service\Doctrine
     */
    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /* Service locator getter and setter methods */

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @param string $message
     */
    protected function logError($message)
    {
        $writer = new Stream('data/logs/error.log');
        $logger = new Logger();
        $logger->addWriter($writer);

        $logger->err($message);
    }
}

