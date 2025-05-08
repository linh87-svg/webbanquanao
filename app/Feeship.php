<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'province_id','district_id','wards_id','fee_feeship'];
    protected $primaryKey ='fee_id';
    protected $table ='tbl_feeship';
     public function province(){
        return $this->belongsTo('App\Province', 'province_id');
    }
    public function district(){
        return $this->belongsTo('App\District', 'district_id');
    }
    public function wards(){
        return $this->belongsTo('App\Wards', 'wards_id');
    }

}
