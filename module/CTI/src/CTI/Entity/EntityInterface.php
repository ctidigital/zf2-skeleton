<?php

/**
 * CTI Digital
 *
 * @author Jason Brown <j.brown@ctidigital.com>
 */

namespace CTI\Entity;

interface EntityInterface
{
    public function getId();
    public function toArray();
}
