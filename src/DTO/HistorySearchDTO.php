<?php

namespace App\DTO;

class HistorySearchDTO
{
    private $fromDate;
    private $toDate;
    private $rctpNameNumber;
    private $text;
    private $status;

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setText($text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getRctpNameNumber(): ?string
    {
        return $this->rctpNameNumber;
    }

    public function setRctpNameNumber($rctpNameNumber): self
    {
        $this->rctpNameNumber = $rctpNameNumber;

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
        $historyArray['fromDate'] = $this->fromDate;
        $historyArray['toDate'] = $this->toDate;
        $historyArray['rctpNameNumber'] = $this->rctpNameNumber;
        $historyArray['text'] = $this->text;
        $historyArray['status'] = $this->status;

        return $historyArray;
    }
}
