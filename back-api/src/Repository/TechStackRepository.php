<?php

namespace App\Repository;

use App\Entity\TechStack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechStack>
 *
 * @method TechStack|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechStack|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechStack[]    findAll()
 * @method TechStack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechStackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechStack::class);
    }

//    /**
//     * @return TechStack[] Returns an array of TechStack objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TechStack
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
