<?php

namespace App\Repository;

use App\Entity\Bootcamp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bootcamp>
 *
 * @method Bootcamp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bootcamp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bootcamp[]    findAll()
 * @method Bootcamp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BootcampRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bootcamp::class);
    }

//    /**
//     * @return Bootcamp[] Returns an array of Bootcamp objects
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

//    public function findOneBySomeField($value): ?Bootcamp
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
