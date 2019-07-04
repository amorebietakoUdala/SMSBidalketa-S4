<?php

namespace App\Entity;

use DateTime;
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
     * @var string
     *
     * @ORM\Column(name="telephones", type="string", length=10000)
     */
    private $telephones;
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

    public function getId()
    {
        return $this->id;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    public function getResponse(): string
    {
        return $this->response;
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

    public function getTelephones()
    {
        return json_decode($this->telephones);
    }

    public function setTelephones($telephones)
    {
        $this->telephones = $telephones;

        return $this;
    }

    public static function createAudit(array $telephones, $responseCode, $message, $fullResponse, $user, $singleTelephone): Audit
    {
        $audit = new self();
        $audit->setTelephones(json_encode($telephones));
        $audit->setTimestamp(new DateTime());
        $audit->setResponseCode($responseCode);
        $audit->setMessage($message);
        $audit->setResponse(json_encode($fullResponse));
        $audit->setUser($user);

        return $audit;
    }
}
