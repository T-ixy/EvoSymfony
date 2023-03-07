<?php

namespace App\Repository;

use App\Entity\Formations;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Formations>
 *
 * @method Formations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formations[]    findAll()
 * @method Formations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationsRepository extends ServiceEntityRepository
{

    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Formations::class);

        $this->paginator = $paginator;
    }

    public function save(Formations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Formations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Formations[] Returns an array of Formations objects
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

    //    public function findOneBySomeField($value): ?Formations
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findAllPaginate(Request $request): PaginationInterface
    {
        $formations = $this->findBy([],['priority' => 'DESC']);

        $pagination = $this->paginator->paginate(
            $formations,
            $request->query->getInt('page', 1),
            8
        );

        return $pagination;
    }

    public function findFormationsBySearch(SearchData $search, Request $request)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT f, d, u
        FROM App\Entity\Formations f
        JOIN f.categories d
        JOIN f.university u
        WHERE f.title LIKE :search
        OR f.generality LIKE :search
        ORDER BY f.id'
        )->setParameter('search', '%' . $search->search . '%');

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $pagination;
    }

    public function findFiltered(string $filter, Request $request)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT f 
            FROM App\Entity\Formations f
            LEFT JOIN f.categories c 
            LEFT JOIN f.sanction s 
            WHERE c.Category = :condition OR s.Sanction = :condition'
        )->setParameter('condition', $filter);

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $pagination;
    }
}
