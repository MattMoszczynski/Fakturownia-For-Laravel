<?php

namespace MattM\FFL;

use Illuminate\Http\Client\Response;

class FakturowniaResponse extends Response
{
    const STATUS_SUCCESS   = 'SUCCESS';
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    const STATUS_ERROR     = 'ERROR';
    private int $code;
    private string $data;

    public function __construct(Response $response)
    {
        parent::__construct($response);

        $this->code = $response->getStatusCode();
        $this->data = $response->getBody();
    }

    public function getStatus(): string
    {
        if ($this->code >= 200 && $this->code < 300) {
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
