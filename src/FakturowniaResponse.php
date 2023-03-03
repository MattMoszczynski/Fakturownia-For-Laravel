<?php

namespace MattM\FFL;

use Illuminate\Http\Response;

class FakturowniaResponse
{
    const STATUS_SUCCESS   = 'SUCCESS';
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    const STATUS_ERROR     = 'ERROR';

    public function __construct(Response $response)
    {
        $this->code = $response->getStatusCode();
        $this->data = $response->getBody();
    }

    public function getStatus() {
        if (200 <= $this->code && $this->code < 300) {
            return self::STATUS_SUCCESS;
        }

        if ($this->code === 404) {
            return self::STATUS_NOT_FOUND;
        }

        return self::STATUS_ERROR;
    }

    public function isSuccess(): bool
    {
        return 'SUCCESS' === $this->getStatus();
    }
}
