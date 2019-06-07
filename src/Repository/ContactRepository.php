<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findByExample(Contact $contact, $orderBy = null, $limit = null, $offset = null)
    {
        $criteria = $contact->__toArray();

        return parent::findBy($this->__remove_blank_filters($criteria), $orderBy, $limit, $offset);
    }

    public function findByLabels($labels)
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.labels', 'l')
            ->andWhere('l IN (:labels)')
            ->setParameter('labels', $labels)
        ;
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
