<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

   public function findCarByCarId(int $car_id): Car
   {
       return $this->createQueryBuilder('c')
           ->where('c.car_id = :car_id')
           ->setParameter('car_id', $car_id)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

   public function findCarByUserId($id): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.user_id = :id')
           ->setParameter('id', $id)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findCarOdometer(int $car_id)
   {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT c
           FROM App\Entity\Car c
           WHERE c.car_id = :car_id'
       )
       ->setParameter('car_id', $car_id);

       // returns an array of Product objects
       return $query->getOneOrNullResult();
   }
   
   public function addCar(Car $car): void {
    $this->getEntityManager()->persist($car);
    $this->getEntityManager()->flush();
   } 

   public function remove(Car $car): void
   {
        $this->getEntityManager()->remove($car);
        $this->getEntityManager()->flush();
 
   }
}
