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

    

    //renvoie tous les arbitres d'une competition
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

    public function getTireurCompetition()
    {
        $role = 1;
        $null = 'null';
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
            ->andWhere('u.place != :null')
            ->setParameter('null', $null)
            ->getQuery()
            ->getResult();
        return $data;
    }




    //renvoie les competitions ou le user est un arbitre
    public function getCompetitionArbitre($user)
    {
        $role = 2; //2 = arbitre
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        
    }

    //renvoie les competitions ou le user est un Tireur
    public function getCompetitionTireur($user)
    {
        $role = 1; //2 = arbitre
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
            ->andWhere('u.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        
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
