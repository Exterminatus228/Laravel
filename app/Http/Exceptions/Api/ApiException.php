<?php

declare(strict_types=1);

namespace App\Http\Exceptions\Api;

use Exception;
use Throwable;

/**
 * Class ApiException
 */
class ApiException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = '',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
