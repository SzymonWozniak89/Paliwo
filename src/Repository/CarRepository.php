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

//    public function findCarByUserId(int $user_id): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.user_id = :user_id')
//            ->setParameter('user_id', $user_id)
//            //->orderBy('c.id', 'ASC')
//            //->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findCarByUserId(int $userId): array
//     {
//         $conn = $this->getEntityManager()->getConnection();

//         $sql = '
//             SELECT * 
//             FROM car 
//             where user_id = :userId
//             ';

//         $resultSet = $conn->executeQuery($sql, ['userId' => $userId]);

//         // returns an array of arrays (i.e. a raw data set)
//         return $resultSet->fetchAllAssociative();
//     }



   public function findCarByUserId($user_id): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.user_id = :user_id')
           ->setParameter('user_id', $user_id)
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
