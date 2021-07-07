<?php

namespace HitcKit\CoreBundle\Repository;

use HitcKit\CoreBundle\Entity\Node;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Node|null find($id, $lockMode = null, $lockVersion = null)
 * @method Node|null findOneBy(array $criteria, array $orderBy = null)
 * @method Node[]    findAll()
 * @method Node[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Node::class);
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

    public function getNodeListBuilder($parentId = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('d');
        $where = $parentId ? $qb->expr()->eq('d.parent', $parentId) : $qb->expr()->isNull('d.parent');
        $qb->orderBy('d.title', 'ASC')->where($where);

        return $qb;
    }
}
