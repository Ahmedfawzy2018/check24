<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\IpBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class IpBlockRespository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IpBlock::class);
    }

    public function exists(string $ip): bool
    {
        $qb = $this->createQueryBuilder('ip');
        $qb->select('COUNT(ip.id)');
        $qb->andWhere('ip = :ip');
        $qb->setParameter('ip', $ip);
        $qb->setMaxResults(1);

        $result = $qb->getQuery()->getOneOrNullResult();

        return ((int) reset($result)) >= 1;
    }
}
