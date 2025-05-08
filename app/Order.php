<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'user_id','shipping_id','order_status','order_code', 'order_date','created_at','order_destroy'];
    protected $primaryKey ='order_id';
    protected $table ='tbl_order';
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }
}
