<?php
namespace VeterinaireBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: Steve
 * Date: 23/03/2018
 * Time: 12:41
 */

class RdvRepository extends EntityRepository
{
    function rech($r){
        return $this->createQueryBuilder('r')
            ->where('r.nom Like :valeur')
            ->andWhere('r.prenom Like :valeur')
            ->setParameter('valeur',"%".$r.'%')
            ->getQuery()
            ->getResult();

    }
}
