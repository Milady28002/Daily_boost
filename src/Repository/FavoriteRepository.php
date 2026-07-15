<?php

namespace App\Repository;

use App\Entity\Favorite;
use App\Entity\Quote;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Favorite>
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }

    public function findOneByUserAndQuote(User $user, Quote $quote): ?Favorite
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.owner = :user')
            ->andWhere('f.quote = :quote')
            ->setParameter('user', $user)
            ->setParameter('quote', $quote)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByVisitorAndQuote(string $visitorId, Quote $quote): ?Favorite
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.visitorId = :visitorId')
            ->andWhere('f.quote = :quote')
            ->setParameter('visitorId', $visitorId)
            ->setParameter('quote', $quote)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countFavoritesByQuote(): array
    {
        return $this->createQueryBuilder('f')
            ->select('q.id, q.title, q.content, COUNT(f.id) AS favorites')
            ->join('f.quote', 'q')
            ->groupBy('q.id')
            ->orderBy('favorites', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Favorite[] Returns an array of Favorite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Favorite
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
