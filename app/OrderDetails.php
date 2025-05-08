<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'order_code','product_id','product_name','product_price','color_id','size_id','product_quantity','product_coupon','product_feeship'];
    protected $primaryKey ='order_detail_id';
    protected $table ='tbl_order_details';
     public function product(){
       return $this->belongsTo('App\Product', 'product_id');
    }
    public function color()
      {
         return $this->belongsTo('App\Color');
      }

   public function size()
      {
         return $this->belongsTo('App\Size');
      }

}
