<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'category_id', 'product_name', 'product_price','product_images','product_status','product_desc','product_quantities','product_views','product_sold','price_cost'];
    protected $primaryKey ='product_id';
    protected $table ='tbl_product';
     public function comment(){
        return $this->hasMany('App\Comment');
    }
    public function category(){
      return $this->belongsTo('App\Category','category_id');
    }

}
