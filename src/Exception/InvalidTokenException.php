<?php

namespace Gmigroup\Clients\Fakturownia\Exception;

class InvalidTokenException extends \Exception
{
    protected $message = 'Invalid Fakturowania API token';
}
