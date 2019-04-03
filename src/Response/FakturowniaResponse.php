<?php

namespace Gmigroup\Clients\Fakturownia\Response;

class FakturowniaResponse implements FakturowniaResponseInterface
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $data;

    public function __construct(int $code, array $data)
    {
        $this->code = $code;
        $this->data = $data;
    }

    public function getStatus(): string
    {
        if (200 <= $this->code && 300 > $this->code) {
            return FakturowniaResponseInterface::STATUS_SUCCESS;
        }
        if (404 === $this->code) {
            return FakturowniaResponseInterface::STATUS_NOT_FOUND;
        }

        return FakturowniaResponseInterface::STATUS_ERROR;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'status' => $this->getStatus(),
            'data' => $this->getData()
        ];
    }
}
