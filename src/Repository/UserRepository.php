<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    public function findOneByUsername(string $email)
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function addUser(User $user): void {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
       } 

    public function saveUser(User $user): void {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
       } 

}