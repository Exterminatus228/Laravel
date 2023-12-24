<?php

declare(strict_types=1);

namespace App\Models;

use App\Http\Enums\Permissions;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Role
 * @see Permissions
 * @property integer $id
 * @property integer $role_id
 * @property integer $type
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 * @property-read Role $role
 */
class Permission extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $table = 'permissions';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'type',
        'created_at',
        'updated_at',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     */
    public function role(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id', 'id', 'id');
    }
}
