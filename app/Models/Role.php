<?php

declare(strict_types=1);

namespace App\Models;

use App\Http\Enums\Roles;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Role
 * @see Roles
 * @property integer $id
 * @property integer $type
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 * @property-read Permission[] $permissions
 */
class Role extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $table = 'roles';

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
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id', 'id', 'id');
    }
}
