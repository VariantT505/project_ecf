<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ResaRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reservations $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Reservations $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findExistingReservation($etablissements, $suites, $start, $end)
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.etaid', 'e')
            ->innerJoin('r.suiid', 's')
            ->where('e = :etaid')
            ->andWhere('s = :suiid')
            ->andWhere('
                (r.startdate BETWEEN :startDateFrom AND :startDateTo) OR 
                (r.enddate BETWEEN :endDateFrom AND :endDateTo) OR
                (r.startdate < :startDateFrom AND r.enddate > :endDateTo)
                ')
            ->setParameter('etaid', $etablissements)
            ->setParameter('suiid', $suites)
            ->setParameter('startDateFrom', $start)
            ->setParameter('startDateTo', $end)
            ->setParameter('endDateFrom', $start)
            ->setParameter('endDateTo', $end);
        return $qb->getQuery()->getResult();
     }

    // /**
    //  * @return Reservations[] Returns an array of Reservations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservations
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
