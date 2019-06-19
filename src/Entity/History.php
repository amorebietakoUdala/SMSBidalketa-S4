<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="App\Repository\HistoryRepository")
 */
class History
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    private $id;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="senderAccount", type="string", length=50, nullable=true)
     */
    private $senderAccount;
    /**
     * @var string
     *
     * @ORM\Column(name="rctp_name_number", type="string", length=50, nullable=true)
     */
    private $rctpNameNumber;
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=400, nullable=true)
     */
    private $text;
    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50, nullable=true)
     */
    private $ip;
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, nullable=true)
     */
    private $status;
    /**
     * @var string
     *
     * @ORM\Column(name="es_unicode", type="string", length=50, nullable=true)
     */
    private $esUnicode;

    public function __construct($history = null)
    {
        if ($history) {
            $this->extractFromJson($history);
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getEsUnicode(): string
    {
        return $this->esUnicode;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    public function setIp(string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    public function setEsUnicode(string $esUnicode)
    {
        $this->esUnicode = $esUnicode;

        return $this;
    }

    public function getRctpNameNumber(): string
    {
        return $this->rctpNameNumber;
    }

    public function setRctpNameNumber(string $rctpNameNumber)
    {
        $this->rctpNameNumber = $rctpNameNumber;

        return $this;
    }

    public function getSenderAccount()
    {
        return $this->senderAccount;
    }

    public function setSenderAccount($senderAccount)
    {
        $this->senderAccount = $senderAccount;

        return $this;
    }

    private function extractFromJson($json)
    {
        $this->setId($json->{'id'});
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $json->{'date'});
        $this->setDate($date);
        $this->setSenderAccount($json->{'from'});
        $this->setRctpNameNumber($json->{'rctp_name_number'});
        $this->setText($json->{'text'});
        $this->setIp($json->{'ip'});
        $this->setStatus($json->{'status'});
        $this->setEsUnicode($json->{'es_unicode'});
    }
}
