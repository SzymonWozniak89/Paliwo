<?php

namespace App\Repository;

use App\Entity\Refueling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Refueling>
 *
 * @method Refueling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Refueling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Refueling[]    findAll()
 * @method Refueling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefuelingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Refueling::class);
    }

   public function findRefuelingByCarId($car_id): array
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.car_id = :car_id')
           ->setParameter('car_id', $car_id)
           ->getQuery()
           ->getResult()
       ;
   }

   public function refuelingAvgFC(int $car_id)
   {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT avg(r.refueling_avg_fuel_consumption)
           FROM App\Entity\Refueling r
           WHERE r.car_id = :car_id'
       )->setParameter('car_id', $car_id);

       return $query->getSingleScalarResult();
   }

   public function refuelingAvgCost(int $car_id)
   {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT sum(r.refueling_price)/sum(r.refueling_liters)*avg(r.refueling_avg_fuel_consumption)
           FROM App\Entity\Refueling r
           WHERE r.car_id = :car_id'
       )->setParameter('car_id', $car_id);

       return $query->getSingleScalarResult();
   }

   public function findLastOdometer(int $car_id)
   {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT r
           FROM App\Entity\Refueling r
           WHERE r.car_id = :car_id
           Order By r.refueling_id DESC'
       )
       ->setMaxResults(1)
       ->setParameter('car_id', $car_id);

       return $query->getOneOrNullResult();
   }

   public function addRefueling(Refueling $refueling): void 
   {
        $this->getEntityManager()->persist($refueling);
        $this->getEntityManager()->flush();
   } 

   public function remove(Refueling $refueling): void
   {
        $this->getEntityManager()->remove($refueling);
        $this->getEntityManager()->flush();
 
   }
}
