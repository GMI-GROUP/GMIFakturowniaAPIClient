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
    private $sell_date;

    /**
     * @var string
     */
    private $issue_date;

    /**
     * @var string
     */
    private $payment_to;

    /**
     * @var string
     */
    private $seller_name;

    /**
     * @var string
     */
    private $seller_tax_no;

    /**
     * @var string
     */
    private $buyer_name;

    /**
     * @var string
     */
    private $buyer_email;

    /**
     * @var string
     */
    private $buyer_tax_no;

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
        $this->sell_date = $sellDate;
        $this->issue_date = $issueDate;
        $this->payment_to = $paymentTo;
        $this->seller_name = $sellerName;
        $this->seller_tax_no = $sellerTaxNo;
        $this->buyer_name = $buyerName;
        $this->buyer_email = $buyerEmail;
        $this->buyer_tax_no = $buyerTaxNo;

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
        return $this->sell_date;
    }

    public function issueDate(): string
    {
        return $this->issue_date;
    }

    public function paymentTo(): string
    {
        return $this->payment_to;
    }

    public function sellerName(): string
    {
        return $this->seller_name;
    }

    public function sellerTaxNo(): string
    {
        return $this->seller_tax_no;
    }

    public function buyerName(): string
    {
        return $this->buyer_name;
    }

    public function buyerEmail(): string
    {
        return $this->buyer_email;
    }

    public function buyerTaxNo(): string
    {
        return $this->buyer_tax_no;
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

    public function toArray(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            if (!is_object($value) && !is_array($value)) {
                $array[$key] = $value;
            } elseif (is_object($value)) {
                $array[$key] = $value->toArray();
            } elseif (is_array($value)) {
                foreach ($value as $k => $v) {
                    $array[$key][$k] = $v->toArray();
                }
            } else {
                var_dump(true);
            }
        }

        return $array;
    }
}
