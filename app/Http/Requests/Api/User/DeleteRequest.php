<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Request;
use App\Models\User;

/**
 * Class DeleteRequest
 */
class DeleteRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User
            && $user->can('delete', new User());
    }
}
