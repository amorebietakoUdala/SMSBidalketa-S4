<?php

namespace App\Repository;

use App\Entity\Label;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Label::class);
    }

    public function findLabelsThatContain($pattern = null)
    {
        if (null === $pattern) {
            return [];
        }
        $qb = $this->createQueryBuilder('l')
            ->andWhere('l.name LIKE :pattern')
            ->orderBy('l.name', 'DESC')
            ->setParameter('pattern', '%'.$pattern.'%');

        return $qb->getQuery()->getResult();
    }
}
