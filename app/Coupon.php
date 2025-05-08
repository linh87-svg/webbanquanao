<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'coupon_name','coupon_code','coupon_quantity','coupon_condition','coupon_number','coupon_status','coupon_date_start','coupon_date_end','coupon_used'];
    protected $primaryKey ='coupon_id';
    protected $table ='tbl_coupon';
}
