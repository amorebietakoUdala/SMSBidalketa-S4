<?php

namespace App\DTO;

use App\Entity\Contact;

class ContactDTO
{
    private $id;
    private $username;
    private $telephone;
    private $name;
    private $surname1;
    private $surname2;
    private $company;
    private $department;
    private $labels;

    public function __construct(Contact $contact = null)
    {
        if ($contact) {
            $this->extract($contact);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname1()
    {
        return $this->surname1;
    }

    public function getSurname2()
    {
        return $this->surname2;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getLabels()
    {
        return $this->labels;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setSurname1($surname1)
    {
        $this->surname1 = $surname1;

        return $this;
    }

    public function setSurname2($surname2)
    {
        $this->surname2 = $surname2;

        return $this;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    public function fill(Contact $contact)
    {
        $contact->setId($this->getId());
        $contact->setUsername($this->getUsername());
        $contact->setTelephone($this->getTelephone());
        $contact->setName($this->getName());
        $contact->setSurname1($this->getSurname1());
        $contact->setSurname2($this->getSurname2());
        $contact->setCompany($this->getCompany());
        $contact->setDepartment($this->getDepartment());
        $contact->setLabels($this->getLabels());
    }

    public function extract(Contact $contact)
    {
        $this->setId($contact->getId());
        $this->setUsername($contact->getUsername());
        $this->setTelephone($contact->getTelephone());
        $this->setName($contact->getName());
        $this->setSurname1($contact->getSurname1());
        $this->setSurname2($contact->getSurname2());
        $this->setCompany($contact->getCompany());
        $this->setDepartment($contact->getDepartment());
        $this->setLabels($contact->getLabels());

        return $this;
    }
}
