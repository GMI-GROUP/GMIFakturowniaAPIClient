<?php

namespace Gmigroup\Clients\Fakturownia\Entity;

interface InvoiceInterface
{
    public function kind(): string;
    public function sellDate(): string;
    public function issueDate(): string;
    public function paymentTo(): string;
    public function sellerName(): string;
    public function sellerTaxNo(): string;
    public function buyerName(): string;
    public function buyerEmail(): string;
    public function buyerTaxNo(): string;
    /**
     * @return InvoicePositionInterface[]
     */
    public function positions(): array;
}
