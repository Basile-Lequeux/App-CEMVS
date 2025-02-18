<?php

namespace App\Repository;

use App\Entity\Competitions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Competitions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competitions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competitions[]    findAll()
 * @method Competitions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Competitions::class);
    }




    public function getCompetitionsRevolues($element)
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
    
    public function getCompetitionsRevoluesByCategorie($categorie)
    {
        $dateActuelle = new \DateTime('now');
        $dateActuelle = $dateActuelle->format('Y-m-d H:i:s');
        return $this ->createQueryBuilder('competitions')
            ->andWhere('competitions.dateEnd <= :dateActuelle')
            ->setParameter('dateActuelle', $dateActuelle)
            ->andWhere('competitions.CategorieAge <= :categorie')
            ->setParameter('categorie', $categorie)
            ->getQuery()
            ->getResult();

    }

    public function getTireur($user)
    {
      
        return $this->createQueryBuilder('c')
            ->andWhere('c.users <= :tireur')
            ->setParameter('tireur', $user)
            ->getQuery()
            ->getResult();    
    }



    // /**
    //  * @return Competitions[] Returns an array of Competitions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Competitions
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
