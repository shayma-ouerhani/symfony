<?php

namespace App\Repository;

use App\Entity\Studentt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Studentt>
 *
 * @method Studentt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Studentt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Studentt[]    findAll()
 * @method Studentt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudenttRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Studentt::class);
    }

//    /**
//     * @return Studentt[] Returns an array of Studentt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Studentt
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
