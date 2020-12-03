<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findByExample(Contact $contact, $orderBy = null, $limit = null, $offset = null)
    {
        $criteria = $contact->__toArray();
        $qb = $this->createQueryBuilder('c');
        if (array_key_exists('telephone', $criteria) && null !== $criteria['telephone']) {
            $qb->andWhere('c.telephone = :telephone');
            $qb->setParameter('telephone', $criteria['telephone']);
        }
        if (array_key_exists('name', $criteria) && null !== $criteria['name']) {
            $qb->andWhere('c.name = :name');
            $qb->setParameter('name', $criteria['name']);
        }
        if (array_key_exists('surname1', $criteria) && null !== $criteria['surname1']) {
            $qb->andWhere('c.surname1 = :surname1');
            $qb->setParameter('surname1', $criteria['surname1']);
        }
        if (array_key_exists('surname2', $criteria) && null !== $criteria['surname2']) {
            $qb->andWhere('c.surname2 = :surname2');
            $qb->setParameter('surname2', $criteria['surname2']);
        }
        if (array_key_exists('labels', $criteria) && null !== $criteria['labels'] && !empty($criteria['labels'])) {
            $qb->innerJoin('c.labels', 'l');
            $qb->andWhere('l IN (:labels)');
            $qb->setParameter('labels', $criteria['labels']);
        }
        $result = $qb->getQuery()->getResult();
        return $result;
    }

    public function findByLabels($labels)
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.labels', 'l')
            ->andWhere('l IN (:labels)')
            ->setParameter('labels', $labels);
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
