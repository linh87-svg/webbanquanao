<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'user_name',  'user_email',  'user_password', 'user_phone'
    ];
 
    protected $primaryKey = 'user_id';
    protected $table = 'tbl_user';
}
