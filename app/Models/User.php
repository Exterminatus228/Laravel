<?php

declare(strict_types=1);

namespace App\Models;

use App\Http\Enums\Roles;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 * @property DateTimeInterface $email_verified_at
 * @property string $remember_token
 * @property-read Role[] $roles
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @inheritdoc
     */
    protected $table = 'users';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id', 'id', 'id')
            ->with('permissions');
    }

    /**
     * @return Permission[]
     */
    public function permissions(): array
    {
        $result = [];

        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $result[$permission->id] = $permission;
            }
        }

        return $result;
    }

    /**
     * @param Roles[] $roles
     * @return bool
     */
    public function hasRoles(array $roles): bool
    {
        return $this->roles()->whereIn('type', array_column($roles, 'value'))->exists();
    }
}
