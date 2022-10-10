<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role notAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $is_admin
 */
class Role extends SpatieRole
{
    /**
     * @param  string  $title
     * @param  int|null  $exceptId
     * @return string
     */
    public static function genName(string $title, ?int $exceptId = null): string
    {
        $initName = Str::lower(Str::slug($title));

        $name = $initName;
        $count = 1;

        while (Role::where('name', $name)->where('id', '<>', $exceptId)->exists()) {
            $count++;
            $name = $initName.'-'.$count;
        }

        return $name;
    }

    /* attributes */

    public function getIsAdminAttribute()
    {
        return $this->name === RoleConst::ROLE_ADMIN;
    }

    /* scopes */

    public function scopeNotAdmin($query)
    {
        $query->where('name', '<>', RoleConst::ROLE_ADMIN);
    }
}
