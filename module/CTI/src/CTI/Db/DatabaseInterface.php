<?php

/**
 * CTI Digital
 *
 * @author Jason Brown <j.brown@ctidigital.com>
 */
namespace CTI\Db;

use CTI\Entity\EntityInterface;

interface DatabaseInterface
{
    public function insert(EntityInterface $entity);
    public function update(EntityInterface $entity);
    public function delete(EntityInterface $entity);
    public function find($entityName, $id);
    public function findBy($entityName, $criteria = array(), $orderBy = array(), $limit = null, $offset = null);
    public function findOneBy($entityName, $criteria = array(), $orderBy = array());
            
}

