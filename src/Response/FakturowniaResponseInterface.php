<?php

namespace Gmigroup\Clients\Fakturownia\Response;

interface FakturowniaResponseInterface
{
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_NOT_FOUND = 'NOT_FOUND';
    public const STATUS_ERROR = 'ERROR';

    public function getStatus(): string;
    public function getData(): array;
}
