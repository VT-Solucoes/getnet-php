<?php

namespace Getnet\Responses;

class BoletoResponse extends BaseResponse
{

    public $boleto_id;

    public $bank;

    public string $status_label;

    public $typeful_line;

    public $bar_code;

    public $issue_date;

    public $expiration_date;

    public $our_number;

    public $document_number;

    public $boleto_pdf;

    public $boleto_html;

    private string $base_url;

    /**
     *
     * @param mixed $base_url
     */
    public function setBaseUrl($base_url)
   : BoletoResponse
    {
        $this->base_url = $base_url;

        return $this;
    }

    /**
     * @return void
     */
    public function generateLinks()
    {
        if ($this->getPaymentId()) {
            $this->boleto_pdf = $this->base_url . "/v1/payments/boleto/" . $this->getPaymentId() . "/pdf";
            $this->boleto_html = $this->base_url . "/v1/payments/boleto/" . $this->getPaymentId() . "/html";
        }
    }

    /**
     *
     * @return mixed
     */
    public function getBoletoPdf()
    {
        return $this->boleto_pdf;
    }

    /**
     *
     * @return mixed
     */
    public function getBoletoHtml()
    {
        return $this->boleto_html;
    }

    /**
     *
     * @return mixed
     */
    public function getDocumentNumber()
    {
        return $this->document_number;
    }

    /**
     *
     * @param mixed $document_number
     * @return BoletoResponse
     */
    public function setDocumentNumber($document_number)
   : BoletoResponse
    {
        $this->document_number = $document_number;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
   : string
    {
        return $this->description;
    }

    /**
     *
     * @param string $description
     * @return BaseResponse
     */
    public function setDescription(string $description): BaseResponse
    {
        $this->description = $description;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getBoletoId()
    {
        return $this->boleto_id;
    }

    /**
     *
     * @param mixed $boleto_id
     * @return BoletoResponse
     */
    public function setBoletoId($boleto_id)
   : BoletoResponse
    {
        $this->boleto_id = $boleto_id;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     *
     * @param mixed $bank
     * @return BoletoResponse
     */
    public function setBank($bank)
   : BoletoResponse
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusLabel()
   : string
    {
        return $this->status_label;
    }

    /**
     *
     * @param string $status_label
     * @return BoletoResponse
     */
    public function setStatusLabel(string $status_label): BoletoResponse
    {
        $this->status_label = $status_label;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getTypefulLine()
    {
        return $this->typeful_line;
    }

    /**
     *
     * @param mixed $typeful_line
     * @return BoletoResponse
     */
    public function setTypefulLine($typeful_line)
   : BoletoResponse
    {
        $this->typeful_line = $typeful_line;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getBarCode()
    {
        return $this->bar_code;
    }

    /**
     *
     * @param mixed $bar_code
     * @return BoletoResponse
     */
    public function setBarCode($bar_code)
   : BoletoResponse
    {
        $this->bar_code = $bar_code;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getIssueDate()
    {
        return $this->issue_date;
    }

    /**
     *
     * @param mixed $issue_date
     * @return BoletoResponse
     */
    public function setIssueDate($issue_date)
   : BoletoResponse
    {
        $this->issue_date = $issue_date;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     *
     * @param mixed $expiration_date
     * @return BoletoResponse
     */
    public function setExpirationDate($expiration_date)
   : BoletoResponse
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getOurNumber()
    {
        return $this->our_number;
    }

    /**
     *
     * @param mixed $our_number
     * @return BoletoResponse
     */
    public function setOurNumber($our_number)
   : BoletoResponse
    {
        $this->our_number = $our_number;

        return $this;
    }
}
