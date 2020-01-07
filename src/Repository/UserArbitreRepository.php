<?php

namespace App\Repository;

use App\Entity\UserArbitre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserArbitre|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserArbitre|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserArbitre[]    findAll()
 * @method UserArbitre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserArbitreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserArbitre::class);
    }

    // /**
    //  * @return UserArbitre[] Returns an array of UserArbitre objects
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
    public function findOneBySomeField($value): ?UserArbitre
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
