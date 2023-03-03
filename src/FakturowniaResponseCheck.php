<?php

namespace MattM\FFL;

use Illuminate\Http\Client\Response;

class FakturowniaResponseCheck
{
    const STATUS_SUCCESS   = 'SUCCESS';
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    const STATUS_ERROR     = 'ERROR';


    public static function getStatus(Response $response) {
        $code = $response->getStatusCode();
        if (200 <= $code && $code < 300) {
            return self::STATUS_SUCCESS;
        }

        if ($code === 404) {
            return self::STATUS_NOT_FOUND;
        }

        return self::STATUS_ERROR;
    }

    public static function isSuccess(Response $response): bool
    {
        return 'SUCCESS' === self::getStatus($response);
    }
}
