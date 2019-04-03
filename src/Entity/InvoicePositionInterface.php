<?php

namespace Gmigroup\Clients\Fakturownia\Entity;

interface InvoicePositionInterface
{
    public function name(): string;
    public function tax(): int;
    public function totalPriceGross(): float;
    public function quantity(): float;
}
