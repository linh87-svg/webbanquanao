<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false;// set thời gian 
    protected $fillable =['info_contact','info_map','info_image'];
    protected $primaryKey = 'info_id';
    protected $table = 'tbl_information';
}
