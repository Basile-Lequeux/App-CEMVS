<?php

namespace App\Repository;

use App\Entity\Entrainement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entrainement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrainement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrainement[]    findAll()
 * @method Entrainement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrainementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entrainement::class);
    }

    // /**
    //  * @return Entrainement[] Returns an array of Entrainement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entrainement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
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

    public function getEntrainementPasse($element)
    {
        $dateActuelle = new \DateTime('now');
        $dateActuelle = $dateActuelle->format('Y-m-d H:i:s');
        $data = $element->createQueryBuilder()
            ->select('r')
            ->from(Entrainement::class, 'r')
            ->where('r.dateStart <= :dateActuelle')
            ->andWhere('r.dateEnd <= :dateActuelle')
            ->setParameter('dateActuelle', $dateActuelle)
            ->getQuery()
            ->getResult();
        if(sizeof($data)>0){
            return $data;
        }else{
            return false;
        }
    }






}
