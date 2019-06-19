<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, \App\Entity\History::class);
    }

    public function findByDates(array $criteria = null)
    {
        $qb = $this->createQueryBuilder('h');
        if (array_key_exists('fromDate', $criteria) && null !== $criteria['fromDate']) {
            $qb->andWhere('h.date >= :fromDate');
            $qb->setParameter('fromDate', \DateTime::createFromFormat('Y-m-d H:i', $criteria['fromDate']));
            unset($criteria['fromDate']);
        }
        if (array_key_exists('toDate', $criteria) && null !== $criteria['toDate']) {
            $qb->andWhere('h.date <= :toDate');
            $qb->setParameter('toDate', \DateTime::createFromFormat('Y-m-d H:i', $criteria['toDate']));
            unset($criteria['toDate']);
        }
        if (array_key_exists('text', $criteria) and null !== $criteria['text']) {
            $qb->andWhere('h.text LIKE :text');
            $qb->setParameter('text', '%'.$criteria['text'].'%');
            unset($criteria['text']);
        }
        foreach ($this->__remove_blank_filters($criteria) as $key => $value) {
            $qb->andWhere('h.'.$key.'= :'.$key);
            $qb->setParameter($key, $value);
        }

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    private function __remove_blank_filters($criteria)
    {
        $new_criteria = [];
        foreach ($criteria as $key => $value) {
            if (!empty($value)) {
                $new_criteria[$key] = $value;
            }
        }

        return $new_criteria;
    }
}
