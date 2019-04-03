<?php

namespace Gmigroup\Clients\Fakturownia\Entity;

final class Invoice implements InvoiceInterface
{
    /**
     * @var string
     */
    private $kind;

    /**
     * @var string
     */
    private $sellDate;

    /**
     * @var string
     */
    private $issueDate;

    /**
     * @var string
     */
    private $paymentTo;

    /**
     * @var string
     */
    private $sellerName;

    /**
     * @var string
     */
    private $sellerTaxNo;

    /**
     * @var string
     */
    private $buyerName;

    /**
     * @var string
     */
    private $buyerEmail;

    /**
     * @var string
     */
    private $buyerTaxNo;

    /**
     * @var InvoicePositionInterface[]|array
     */
    private $positions;

    /**
     * Invoice constructor.
     * @param string $kind
     * @param string $sellDate
     * @param string $issueDate
     * @param string $paymentTo
     * @param string $sellerName
     * @param string $sellerTaxNo
     * @param string $buyerName
     * @param string $buyerEmail
     * @param string $buyerTaxNo
     * @param array $positions
     */
    private function __construct(
        string $kind,
        string $sellDate,
        string $issueDate,
        string $paymentTo,
        string $sellerName,
        string $sellerTaxNo,
        string $buyerName,
        string $buyerEmail,
        string $buyerTaxNo
    )
    {
        $this->kind = $kind;
        $this->sellDate = $sellDate;
        $this->issueDate = $issueDate;
        $this->paymentTo = $paymentTo;
        $this->sellerName = $sellerName;
        $this->sellerTaxNo = $sellerTaxNo;
        $this->buyerName = $buyerName;
        $this->buyerEmail = $buyerEmail;
        $this->buyerTaxNo = $buyerTaxNo;

    }

    public static function createFromArray(array $invoiceArray): self
    {
        $invoice = new self(
            $invoiceArray['kind'],
            $invoiceArray['sellDate'],
            $invoiceArray['sellDate'],
            $invoiceArray['sellDate'],
            $invoiceArray['sellerName'],
            $invoiceArray['sellerTaxNo'],
            $invoiceArray['buyerName'],
            $invoiceArray['buyerEmail'],
            $invoiceArray['buyerTaxNo']
        );

        foreach ($invoiceArray['positions'] as $position) {
            $invoice->addPosition($position);
        }

        return $invoice;
    }

    public function kind(): string
    {
        return $this->kind;
    }

    public function sellDate(): string
    {
        return $this->sellDate;
    }

    public function issueDate(): string
    {
        return $this->issueDate;
    }

    public function paymentTo(): string
    {
        return $this->paymentTo;
    }

    public function sellerName(): string
    {
        return $this->sellerName;
    }

    public function sellerTaxNo(): string
    {
        return $this->sellerTaxNo;
    }

    public function buyerName(): string
    {
        return $this->buyerName;
    }

    public function buyerEmail(): string
    {
        return $this->buyerEmail;
    }

    public function buyerTaxNo(): string
    {
        return $this->buyerTaxNo;
    }

    /**
     * @return InvoicePositionInterface[]|array
     */
    public function positions(): array
    {
        return $this->positions;
    }

    private function addPosition(array $positionArray): void
    {
        $this->positions[] = InvoicePosition::createFromArray($positionArray);
    }
}
