<?php


namespace App\Actions;

use App\Entity\Entrainement;

class ActionsProject{

    public function compareDateEntrainement($element)
    {
        $dateActuelle = new \DateTime('now');
        $dateActuelle = $dateActuelle->format('Y-m-d H:i:s');
        $data = $element->createQueryBuilder()
            ->select('r')
            ->from(Entrainement::class, 'r')
            ->where('r.dateStart <= :dateActuelle')
            ->andWhere('r.dateEnd >= :dateActuelle')
            ->setParameter('dateActuelle', $dateActuelle)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        if(sizeof($data)>0){
            return $data;
        }else{
            return false;
        }
    }

    public function getMaitreArmes($element){
        $role = 'ROLE_MAITRE';
        $data = $element->createQueryBuilder('u')
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
            ->getQuery()
            ->getResult();
        return $data;
    }
    public function getCompetitionsRevolues($element,$user)
    {
        $dateActuelle = new \DateTime('now');
        $dateActuelle = $dateActuelle->format('Y-m-d H:i:s');
        $data = $element->createQueryBuilder('competitions')
            ->andWhere('competitions.dateEnd <= :dateActuelle')
            ->setParameter('dateActuelle', $dateActuelle)
            ->getQuery()
            ->getResult();

        return $data;
    }
   
}