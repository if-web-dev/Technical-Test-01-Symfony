<?php

namespace App\Repository;

use App\Entity\Car;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

     /**
     * Recupere les cars en lien avec une recherche
     * @return Car[]
     */
    public function findSearch(SearchData $data): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c', 'k')
            ->join('c.carCategory', 'k');

        if(!empty($data->q)){
            $qb = $qb
                ->andWhere('c.name LIKE :q')
                ->setParameter('q', "%{$data->q}%");
        }

        if(!empty($data->carCategory)){
            $qb = $qb
            ->andWhere('k.name = :category')
            ->setParameter('category', $data->carCategory);
        }
         
        
        return $qb->getQuery()->getResult();

    }
}
