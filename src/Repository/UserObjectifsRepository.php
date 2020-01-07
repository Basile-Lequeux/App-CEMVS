<?php

namespace App\Repository;

use App\Entity\UserObjectifs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserObjectifs|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserObjectifs|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserObjectifs[]    findAll()
 * @method UserObjectifs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserObjectifsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserObjectifs::class);
    }

    // /**
    //  * @return UserObjectifs[] Returns an array of UserObjectifs objects
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
    public function findOneBySomeField($value): ?UserObjectifs
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
