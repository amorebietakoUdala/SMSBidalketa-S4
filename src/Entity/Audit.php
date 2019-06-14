<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="audit")
 */
class Audit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Contact", cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     *      )
     */
    private $contacts;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status;
    /**
     * @var string
     *
     * @ORM\Column(name="response", type="string", length=1000)
     */
    private $response;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     */
    private $user;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Contact[]
     */
    public function getContacts(): ArrayCollection
    {
        return $this->contacts;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function addContact(Contact $contact)
    {
        if ($this->contacts->contains($contact)) {
            return;
        }
        $this->contacts[] = $contact;
    }

    public function removeContact(Contact $contact)
    {
        if (!$this->contacts->contains($contact)) {
            return;
        }
        $this->contacts->removeElement($contact);
    }

    public function setTimestamp(DateTime $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setResponse($response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
