<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Imprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Imprint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Imprint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Imprint[]    findAll()
 * @method Imprint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ImprintRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Imprint::class);
        $this->paginator = $paginator;
    }

    public function paginate(int $page, int $limit = 3): PaginationInterface
    {
        $qb = $this->createQueryBuilder('imprint    ');
        $qb->setMaxResults($limit);

        return $this->paginator->paginate($qb->getQuery(), $page, $limit);
    }
}
