<?php

namespace App\Repository;

use App\Entity\Car;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
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
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Car::class);
        $this->paginator = $paginator;
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
     * @return PaginationInterface
     */
    public function findSearch(SearchData $data): PaginationInterface
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
         
        
        $qb = $qb->getQuery();
        return $this->paginator->paginate(
            $qb,
            $data->page,
            20
        );
    }
}
