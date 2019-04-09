<?php

namespace Gmigroup\Clients\Fakturownia\Entity;

class InvoicePosition implements InvoicePositionInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $tax;

    /**
     * @var float
     */
    private $total_price_gross;

    /**
     * @var float
     */
    private $quantity;

    /**
     * InvoicePosition constructor.
     * @param string $name
     * @param int $tax
     * @param float $totalPriceGross
     * @param float $quantity
     */
    private function __construct(string $name, int $tax, float $totalPriceGross, float $quantity)
    {
        $this->name = $name;
        $this->tax = $tax;
        $this->total_price_gross = $totalPriceGross;
        $this->quantity = $quantity;
    }

    public static function createFromArray(array $positionArray): self
    {
        return new self(
            $positionArray['name'],
            $positionArray['tax'],
            $positionArray['totalPriceGross'],
            $positionArray['quantity']
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function tax(): int
    {
        return $this->tax;
    }

    public function totalPriceGross(): float
    {
        return $this->total_price_gross;
    }

    public function quantity(): float
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        $array = [];

        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }
}
