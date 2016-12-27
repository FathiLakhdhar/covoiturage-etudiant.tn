<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrajetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrajetRepository extends EntityRepository
{

    public function getTrajetById($id){
        $qb = $this->createQueryBuilder('t');
        $qb
            ->join('t.Origine', 'o')
            ->addSelect('o')
            ->join('t.Destination', 'd')
            ->addSelect('d')
            ->leftJoin('t.waypoints', 'ways')
            ->addSelect('ways')
            ->join('t.conducteur', 'c')
            ->addSelect('c')
            ->leftJoin('t.Preferences','p')
            ->addSelect('p')
            ->leftJoin('t.reservations','r')
            ->addSelect('r')
            ->leftJoin('t.vehicule','v')
            ->addSelect('v')
            ->leftJoin('t.datesAller', 'da')
            ->addSelect('da')
            ->leftJoin('t.datesRetour', 'dr')
            ->addSelect('dr')
            ->where('t.id = :id')
            ->setParameter('id',$id)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }



    public function getTrajetByIdAndConducteur($id,$conducteur){
        $qb = $this->createQueryBuilder('t');
        $qb
            ->join('t.Origine', 'o')
            ->addSelect('o')
            ->join('t.Destination', 'd')
            ->addSelect('d')
            ->leftJoin('t.waypoints', 'ways')
            ->addSelect('ways')
            ->join('t.conducteur', 'c')
            ->addSelect('c')
            ->leftJoin('t.Preferences','p')
            ->addSelect('p')
            ->leftJoin('t.reservations','r')
            ->addSelect('r')
            ->leftJoin('t.vehicule','v')
            ->addSelect('v')
            ->leftJoin('t.datesAller', 'da')
            ->addSelect('da')
            ->leftJoin('t.datesRetour', 'dr')
            ->addSelect('dr')
            ->where('t.id = :id')
            ->setParameter('id',$id)
            ->andWhere('t.conducteur = :cond')
            ->setParameter('cond',$conducteur);
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }



    public function SearchByOrigineAndDestination($depart,$arrive,$date){
        $qb = $this->createQueryBuilder('t');

        $qb->join('t.Origine', 'origine')
            ->join('t.Destination','destination')
            ->leftJoin('t.datesAller','datesAller')
            ->leftJoin('t.datesRetour','datesRetour')
            ->where('origine.lieu LIKE :depart')
            ->setParameter('depart', $depart)
            ->andWhere('destination.lieu LIKE :arrive')
            ->setParameter('arrive',$arrive)
            ->andWhere('datesAller.date = :date OR datesRetour.date = :date OR t.Date_Allet_unique= :date OR t.Date_Retour_unique= :date')
            ->setParameter('date', $date)
        ;


        return $qb->getQuery()->getResult();
    }


    public function DeleteTrajet($id,$user)
    {
        $q= $this->createQueryBuilder('t');

        $q->delete('t')
            ->where('t.id = :id')
            ->setParameter('id',$id)
            ->andWhere('t.conducteur = :c')
            ->setParameter('c',$user);
    }




}
