<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Type\Integer;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discord_id',
        'name',
        'email',
        'password',
        'birth_date',
        'role_id',
        'description',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Calculate the age of the user
     * @return int Age of the user
     * @throws \Exception
     */
    public function age(): int
    {
        $now = new \DateTime();
        $dob = new \DateTime($this->birth_date);
        $difference = $now->diff($dob);
        return $difference->y;
    }

    /**
     * Fetch role of the user
     * @return Role Role of the user
     */
    public function getRole(): ?Role
    {
        return Role::where('id', $this->role_id)->first();
    }

    /**
     * Get Permissions as array
     * @return array|null Permission
     */
    public function getPermissions() {
        if (auth()->user()->role_id == null) {
            return array();
        }

        $role = Role::where('id', auth()->user()->role_id)->first();
        return RolePermission::where('role_id', $role['id'])->get();
    }

    /**
     * Check if user has permission
     * @param $permissionName
     * @param int $minValue
     * @return bool
     */
    public function hasPermission($permissionName, $minValue=1): bool {
        $permissionValue = 0;

        foreach ($this->getPermissions() as $key => $permission) {
            if ($permission->name == $permissionName) {
                $permissionValue = $permission->value;
            } elseif ($permission->name == '*') {
                $permissionValue = 10;
            }
        }

        return ($permissionValue >= $minValue);
    }
}
