<?php
/**
 * CTI Digital
 *
 * @author Jason Brown <j.brown@ctidigital.com>
 */

namespace CTI;

return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),
        'cache' => array(
            'memcached' => array(
                'instance' => 'Doctrine\Memcached',
            )
        ),
        'configuration' => array (
            'orm_default' => array (
                'metadata_cache' => 'memcached',
                'query_cache' => 'memcached',
                'result_cache' => 'memcached',
            ),
        ),
    ),
);
