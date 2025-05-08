<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
   public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'name'];
    protected $primaryKey ='province_id';
    protected $table ='tbl_province';
}
