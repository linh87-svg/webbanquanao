<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'shipping_name','shipping_email','shipping_address','shipping_note','shipping_phone','shipping_method'];
    protected $primaryKey ='shipping_id';
    protected $table ='tbl_shipping';
}
