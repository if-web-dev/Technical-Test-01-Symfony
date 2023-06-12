<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithPagination(int $page, int $limit = 20): array
    {
        $qb = $this->createQueryBuilder('b')
            ->setFirstResult(($page - 1) * abs($limit))
            ->setMaxResults(abs($limit));
        return $qb->getQuery()->getResult();
    }

   
    public function searchCarByNameWithPagination(int $page, int $limit = 20, $value = null, ): array
    {
        if($value) {
            $qb = $this->createQueryBuilder('c')
                ->where('c.name LIKE :val')
                ->setParameter('val', '%'.$value.'%')
                //->orderBy('c.id', 'ASC')
                ->setFirstResult(($page - 1) * abs($limit))
                ->setMaxResults(abs($limit));
            return $qb->getQuery()->getResult();
        }

        $qb = $this->createQueryBuilder('b')
            ->setFirstResult(($page - 1) * abs($limit))
            ->setMaxResults(abs($limit));
        return $qb->getQuery()->getResult();
    }

    public function countCarsMatchedByName($value)
    {
        $qb = $this->createQueryBuilder('c')
        ->select('COUNT(c.id)') // Use COUNT() to count the rows
        ->where('c.name LIKE :val')
        ->setParameter('val', '%'.$value.'%');
        return $qb->getQuery()->getSingleScalarResult();
    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
