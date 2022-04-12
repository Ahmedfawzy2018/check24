<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PostRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Post::class);
        $this->paginator = $paginator;
    }

    public function detail(string $slug):? Post
    {
        $qb = $this->createQueryBuilder('post');
        $qb->setMaxResults(1);
        $qb->andWhere('post.slug = :slug');
        $qb->setParameter('slug', $slug);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function paginate(int $page, int $limit = 3): PaginationInterface
    {
        $qb = $this->createQueryBuilder('post');
        $qb->setMaxResults($limit);
        $qb->addOrderBy('post.date', 'DESC');

        return $this->paginator->paginate($qb->getQuery(), $page, $limit);
    }
}
