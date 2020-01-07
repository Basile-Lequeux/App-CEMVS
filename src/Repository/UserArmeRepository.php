<?php

namespace App\Repository;

use App\Entity\UserArme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserArme|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserArme|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserArme[]    findAll()
 * @method UserArme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserArmeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserArme::class);
    }

    // /**
    //  * @return UserArme[] Returns an array of UserArme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserArme
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
