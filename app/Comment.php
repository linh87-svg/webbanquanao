<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false; //set time không cho nó chạy
    protected $fillable = [
    'comment','comment_name' ,'comment_date','comment_product_id', 'comment_parent_comment', 'comment_status' ];
    protected $primaryKey ='comment_id';
    protected $table ='tbl_comment';

    public function product(){
        return $this->belongsTo('App\Product', 'comment_product_id');
    }


}
