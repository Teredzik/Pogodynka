<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Measurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measurement>
 */
class MeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measurement::class);
    }

    //    /**
    //     * @return Measurement[] Returns an array of Measurement objects
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

    //    public function findOneBySomeField($value): ?Measurement
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findByLocation(string $city, ?string $country = null)
{
    $qb = $this->createQueryBuilder('m')
        ->join('m.location', 'l')
        ->where('l.city = :city')
        //->andWhere('m.date >= :now')
        ->setParameter('city', $city);
        //->setParameter('now', date('Y-m-d'));
    if ($country) {
        $qb->andWhere('l.country = :country')
            ->setParameter('country', $country);
    }

    // (opcjonalnie) posortuj, żeby mieć czytelną kolejność
    $qb->orderBy('m.date', 'ASC');

    return $qb->getQuery()->getResult();
}


}
