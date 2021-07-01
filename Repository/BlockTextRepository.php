<?php

namespace HitcKit\CoreBundle\Repository;

use HitcKit\CoreBundle\Entity\BlockText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlockText|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlockText|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlockText[]    findAll()
 * @method BlockText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlockText::class);
    }

    // /**
    //  * @return PagePiece[] Returns an array of PagePiece objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PagePiece
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
