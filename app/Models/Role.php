<?php

namespace App\Models;

use App\Traits\CreatorAndUpdater;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends Model
{
    use HasFactory, CreatorAndUpdater;

    protected  $primaryKey = 'key';
    protected  $keyType = 'string';
    public  $incrementing = false;

    protected  $touches = [];
    protected  $fillable = ['key', 'name', 'description', 'color'];
    protected  $hidden = [];
    protected  $casts = [];
    protected  $with = [];
    protected  $withCount = [];


    /**
     * Get users had this role
     *
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'rolable');
    }

    /**
     * Get permissions of this role
     *
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Determine whether model has a permission
     *
     */
    public function hasPermission(Permission|string $permission): bool
    {
        $permissionKey = is_string($permission) ? $permission : $permission->getKey();
        return !is_null($this->permissions()->where('key', $permissionKey)->first(['key']));
    }

    /**
     * Determine whether model has any permissions
     *
     */
    public function hasAnyPermissions(Collection|array $permissions): bool
    {
        $permissionKeys = is_array($permissions) ? $permissions : $permissions->pluck('key')->toArray();
        return !is_null($this->permissions()->whereIn('key', $permissionKeys)->first(['key']));
    }

    /**
     * Determine whether model has all permissions
     *
     */
    public function hasAllPermissions(Collection|array $permissions): bool
    {
        $permissionKeys = is_array($permissions) ? $permissions : $permissions->pluck('key')->toArray();
        return  count($permissionKeys) == $this->permissions()->whereIn('key', $permissionKeys)->count();
    }
}
