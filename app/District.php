<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'province_id','name'];
    protected $primaryKey ='district_id';
    protected $table ='tbl_district';
}
