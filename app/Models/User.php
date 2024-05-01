<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'photo',
    //     'email',
    //     'phone',
    //     'address',
    //     'role',
    //     'status',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getPermissionGroups(){
        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
        return $permission_groups;
    }// end methods

    public static function getPermissionGroupNAme($group_name){
        $permission_group_name = DB::table('permissions')->where('group_name', $group_name)->select('id', 'name')->get();
        // dd($permission_group_name);
        return $permission_group_name;
    }// end methods


    ////// compare role check output : true or false
    public static function roleHasPermissions($role, $permissions){
       $hasPermission = true;
       foreach($permissions as $per){
            if(!$role->hasPermissionTo($per->name)){
                return $hasPermission = false;
            }
       }
       
       return $hasPermission;

    }// end methods
}
