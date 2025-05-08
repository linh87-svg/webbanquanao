<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'category_name','category_parent','category_status'];
    protected $primaryKey ='category_id';
    protected $table ='tbl_category_product';
    public function product(){
        return $this->hasMany('App\Product');
    }
}
