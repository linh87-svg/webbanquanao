<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'user_name', 'user_email', 'user_password', 'user_phone','customer_token','customer_vip', 'user_status', 'user_address'];
    protected $primaryKey ='user_id';
    protected $table ='tbl_user';
     public function orders()
    {
        return $this->hasMany('App\Order', 'user_id', 'user_id');
    }
}
