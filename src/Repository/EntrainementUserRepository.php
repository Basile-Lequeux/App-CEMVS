<?php

namespace App\Repository;

use App\Entity\EntrainementUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EntrainementUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntrainementUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntrainementUser[]    findAll()
 * @method EntrainementUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrainementUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EntrainementUser::class);
    }

    // /**
    //  * @return EntrainementUser[] Returns an array of EntrainementUser objects
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
    public function findOneBySomeField($value): ?EntrainementUser
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
