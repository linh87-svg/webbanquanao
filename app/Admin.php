<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Admin extends Authenticatable
{

   public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'admin_email', 'admin_password', 'admin_name', 'admin_phone'];
    protected $primaryKey ='admin_id';
    protected $table ='tbl_admin';

   public function roles(){
        return $this->belongsToMany('App\Roles');
   }
   public function getAuthPassword(){
     return $this->admin_password;
     
   }
       public function hasAnyRoles($roles){
           // return null !== $this->roles()->whereIn('name', $roles)->first();
        return $this->roles()->whereIn('name', (array)$roles)->exists();//để tối ưu code
       }
       public function hasRole($roles){
            return null !== $this->roles()->where('name', $roles)->first();
       }
}
