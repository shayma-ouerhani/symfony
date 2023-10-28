<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function listBook ($id)
    {
        return $this->createQueryBuilder('a')
        ->join('a.author ' ,'B')
        ->addSelect('B')
        ->where('B.id =:id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();

    }

    public function Recherche($id){
        return $this->createQueryBuilder('B')
            ->where('B.ref LIKE :ref')
            ->setParameter('ref',$id)
            ->getQuery()
            ->getResult();
        }

    public function findBooksPublishedBeforeYearWithAuthorBooksCount($year, $minBookCount)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.author', 'a')
            ->select('b')
            ->where('b.publicationDate < :year')
            ->andWhere('a.nbbooks > :minBookCount')
           ->setParameter('year', $year)
            ->setParameter('minBookCount', $minBookCount)
            ->getQuery()
            ->getResult();
    }

   // public function findSumBooks(){
        //return $this->createQueryBuilder('S')
        //->where("s.category LIKE :name ")
       // ->
    

}
