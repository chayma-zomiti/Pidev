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
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        return $this->createQueryBuilder('r')
            ->where('r.nom Like :valeur')
            ->andWhere('r.prenom Like :valeur')
            ->orWhere('r.typea Like :valeur')
            ->andWhere('r.idVet Like :val ')
            ->setParameter('val',$user->getId())
            ->setParameter('valeur',"%".$r.'%')
            ->getQuery()
            ->getResult();

    }


    function rech2($r){
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        return $this->createQueryBuilder('r')
            ->where('r.nom Like :valeur')
            ->andWhere('r.prenom Like :valeur')
            ->andWhere('r.email Like :val ')
            ->setParameter('val',$user->getId())
            ->setParameter('valeur',"%".$r.'%')
            ->getQuery()
            ->getResult();

    }
}
