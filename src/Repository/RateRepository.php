<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Rate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class RateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }

    public function create(Rate $rate, int $vote): void
    {
        $rate->addVote($vote);

        $this->_em->persist($rate);
        $this->_em->flush();

        $qb = $this->createQueryBuilder('rate');
        $qb->select('COUNT(votes) AS total, SUM(votes.value) AS value');
        $qb->join('rate.votes', 'votes');
        $qb->where('rate = :rate');
        $qb->setParameter('rate', $rate->getId());

        $result = $qb->getQuery()->getSingleResult();
        $total = $result['total'] ?? 1;
        $value = $result['value'] ?? 1;

        $rate->update(round(($value / $total), 2), $total);

        $this->_em->persist($rate);
        $this->_em->flush();
    }
}
