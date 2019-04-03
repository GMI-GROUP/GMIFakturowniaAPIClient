<?php

namespace Gmigroup\Clients\Fakturownia\Client;

use Gmigroup\Clients\Fakturownia\Entity\InvoiceInterface;
use Gmigroup\Clients\Fakturownia\Response\FakturowniaResponseInterface;

class Fakturownia extends AbstractFakturownia
{
    private const WITHOUT_ID = 0;

    public function getInvoices(array $params = []): FakturowniaResponseInterface
    {
        return $this->request(__FUNCTION__, self::WITHOUT_ID, $params);
    }

    public function getInvoice(int $id): FakturowniaResponseInterface
    {
        return $this->request(__FUNCTION__, $id);
    }

    public function createInvoice(InvoiceInterface $invoice): FakturowniaResponseInterface
    {
        return $this->request(__FUNCTION__, self::WITHOUT_ID, ['data' => $invoice]);
    }
}
