<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'category_post_name','category_post_desc','category_post_status'];
    protected $primaryKey ='category_post_id';
    protected $table ='tbl_category_post';
}
