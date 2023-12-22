<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class ObjectRequest
 */
abstract class ObjectRequest extends Request
{
    /**
     * Returns object from input data
     *
     * @return object
     */
    abstract public function asObject(): object;
}
