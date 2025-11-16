<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    public function findStagiaire(): array
    {
        $conn= $this->getEntityManager()->getConnection();
        $sql='select * from user where JSON_CONTAINS(roles, :role)';
        $stmt=$conn->prepare($sql);
        $resultSet=$stmt->executeQuery(['role' => json_encode('ROLE_STAGIAIRE')]);
        return $resultSet->fetchAllAssociative();
    }

    public function countStagiaires():int{
        return $this->createQueryBuilder('s')
        ->select('COUNT(s.id)')
        ->where('s.roles LIKE :role')
        ->setParameter('role', '%ROLE_STAGIAIRE%')
        ->getQuery()
        ->getSingleScalarResult();
    }
    public function countEncadrant():int{
        return $this->createQueryBuilder('s')
        ->select('COUNT(s.id)')
        ->where('s.roles LIKE :role')
        ->setParameter('role', '%ROLE_ENCADRANT%')
        ->getQuery()
        ->getSingleScalarResult();
    }
    public function findByRoles(string $role): array
{
    return $this->createQueryBuilder('u')
        ->where('u.roles LIKE :role')
        ->setParameter('role', '%'.$role.'%')
        ->getQuery()
        ->getResult();
}

public function save(User $user, bool $flush = false): void
{
    $this->getEntityManager()->persist($user);

    if ($flush) {
        $this->getEntityManager()->flush();
    }
}


public function findEncadrant(Stage $stage): ?User
{
    return $this->createQueryBuilder('u')
        ->innerJoin('App\Entity\Stage', 's', 'WITH', 's.encadrant = u')
        ->where('s.id = :stageId')
        ->setParameter('stageId', $stage->getId())
        ->getQuery()
        ->getOneOrNullResult();
        
}
public function findProfesseur(Stage $stage): ?User
{
    return $this->createQueryBuilder('u')
        ->innerJoin('App\Entity\Stage', 's', 'WITH', 's.professeur = u')
        ->where('s.id = :stageId')
        ->setParameter('stageId', $stage->getId())
        ->getQuery()
        ->getOneOrNullResult();
}
public function findStagiairesByEncadrant(User $encadrant): array
{
    return $this->createQueryBuilder('u')
        ->join('u.stage', 's')
        ->where('s.encadrant = :encadrant')
        ->setParameter('encadrant', $encadrant)
        ->getQuery()
        ->getResult();
}

public function findStagiairesByProfesseur(User $professeur): array
{
    return $this->createQueryBuilder('u')
        ->join('u.stage', 's') // adapte selon ta relation
        ->where('s.professeur = :professeur')
        ->setParameter('professeur', $professeur)
        ->getQuery()
        ->getResult();
}



    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
