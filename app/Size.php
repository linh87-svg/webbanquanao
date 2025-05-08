<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
     public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'size_name'];
    protected $primaryKey ='size_id';
    protected $table ='tbl_size';
}
