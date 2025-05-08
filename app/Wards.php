<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'district_id','name'];
    protected $primaryKey ='wards_id';
    protected $table ='tbl_wards';
}
