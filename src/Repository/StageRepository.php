<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stage>
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }



    public function countThisMonth(): int
    {
        $startDate = new \DateTime('first day of this month 00:00:00');
        $endDate = new \DateTime('last day of this month 23:59:59');

        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.dateDebut BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function countstages(): int{
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countEnCours(): int
    {
        $conn = $this->getEntityManager()->getConnection();
        
        // Adaptez cette requête selon vos besoins
        $sql = 'SELECT COUNT(*) as count FROM stage WHERE date_debut <= CURRENT_DATE() AND date_fin >= CURRENT_DATE()';
        $result = $conn->executeQuery($sql)->fetchAssociative();
        
        return (int) $result['count'];
    }
    public function countAVenir(): int
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = 'SELECT COUNT(*) as count FROM stage WHERE date_debut > CURRENT_DATE()';
        $result = $conn->executeQuery($sql)->fetchAssociative();
        
        return (int) $result['count'];
    }

    //    /**
    //     * @return Stage[] Returns an array of Stage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Stage
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
