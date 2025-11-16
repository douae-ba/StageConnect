<?php

namespace App\Repository;

use App\Entity\Message;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findMessagesReçusPar(User $stagiaire): array
{
    return $this->createQueryBuilder('m')
        ->where('m.destinataire = :user')
        ->setParameter('user', $stagiaire)
        ->orderBy('m.date', 'DESC')
        ->getQuery()
        ->getResult();
}


public function findExpiredMessages(): array
{
    $dateLimite = new DateTimeImmutable('-30 days');

    return $this->createQueryBuilder('m')
        ->where('m.date < :limit')
        ->setParameter('limit', $dateLimite)
        ->getQuery()
        ->getResult();
}


    //    /**
    //     * @return Message[] Returns an array of Message objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Message
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
