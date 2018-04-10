<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    function rech($v){
        return $this->createQueryBuilder('v')
            ->where('v.fullname Like :valeur')
            ->OrWhere('v.email Like :valeur')
            ->OrWhere('v.fonctionuser = 2')
            ->setParameter('valeur',"%".$v.'%')
            ->getQuery()
            ->getResult();

    }
}
