<?php

namespace App\DTO;

use App\Entity\Contact;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class AuditSearchDTO
{
    private $contacts;
    private $fromDate;
    private $toDate;
    private $responseCode;
    private $message;
    private $response;
    private $user;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function getResponse(): ?string
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

    public function setResponse($response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getResponseCode(): ?string
    {
        return $this->responseCode;
    }

    public function setResponseCode($responseCode): self
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    public function getFromDate()
    {
        return $this->fromDate;
    }

    public function getToDate()
    {
        return $this->toDate;
    }

    public function setFromDate($fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function setToDate($toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function toArray()
    {
        $auditArray['contacts'] = $this->contacts;
        $auditArray['fromDate'] = $this->fromDate;
        $auditArray['toDate'] = $this->toDate;
        $auditArray['responseCode'] = $this->responseCode;
        $auditArray['message'] = $this->response;
        $auditArray['user'] = $this->user;

        return $auditArray;
    }
}
