<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="audit")
 * @ORM\Entity(repositoryClass="App\Repository\AuditRepository")
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
     * @ORM\Column(name="responseCode", type="string")
     */
    private $responseCode;
    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string")
     */
    private $message;
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
    public function getContacts()
    {
        return $this->contacts;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
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

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    public static function createAudit(array $contacts, $responseCode, $message, $fullResponse, $user): Audit
    {
        $audit = new self();
        $audit->setContacts(new ArrayCollection($contacts));
        $audit->setTimestamp(new DateTime());
        $audit->setResponseCode($responseCode);
        $audit->setMessage($message);
        $audit->setResponse(json_encode($fullResponse));
        $audit->setUser($user);

        return $audit;
    }
}
