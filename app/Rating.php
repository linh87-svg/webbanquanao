<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'product_id','rating'];
    protected $primaryKey ='rating_id';
    protected $table ='tbl_rating';
}
