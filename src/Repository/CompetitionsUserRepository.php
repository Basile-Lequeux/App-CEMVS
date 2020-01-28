<?php

namespace App\Repository;

use App\Entity\CompetitionsUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionsUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionsUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionsUser[]    findAll()
 * @method CompetitionsUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionsUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionsUser::class);
    }

    


    public function getArbitre($element)
    {
        $role = 2; //2 = arbitre
        $data = $element->createQueryBuilder('u')
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
            ->getQuery()
            ->getResult();
        return $data;
    }

    // /**
    //  * @return CompetitionsUser[] Returns an array of CompetitionsUser objects
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
    public function findOneBySomeField($value): ?CompetitionsUser
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
