<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Size;
use App\Http\Requests;
use Auth;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();

class SizeProduct extends Controller
{
     public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }
  public function add_size(){
        $this->AuthLogin();
        $all_size = Size::orderBy('size_id', 'ASC')->get();
        return view('admin.add_size')->with(compact('all_size'));
    }
    public function save_size(Request $request){
        $this->AuthLogin();
         //sử dụng Model
          $data = $request->validate([
             'size_name' => 'required|unique:tbl_size|regex:/^[a-zA-Z\s]+$/|max:50',
            ], [
                'size_name.required' => 'Kích thước không được để trống',
                'size_name.unique' => 'Kích thước đã tồn tại',
                'size_name.regex' => 'Kích thước chỉ được phép chứa chữ cái và dấu cách.',
          
          ]);
      
          $size = new Size();
          $size->size_name = $data['size_name'];
          $size->save(); 
        Toastr::success('Thêm kích thước thành công!','Thông báo');
        return Redirect::to('/add-size');
    }

    public function delete_size($size_id){
        $this->AuthLogin();
        DB::table('tbl_size')->where('size_id', $size_id)->delete();
        Toastr::success('Xóa kích thước thành công!','Thông báo');
        return Redirect::to('/add-size');
    }
    public function show_size_home(Request $request, $product_size_id){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $size_by_id = DB::table('tbl_product')->join('tbl_product_size','tbl_product.product_id','=','tbl_product_size.product_id')->where('tbl_product_size.size_id',$product_size_id)->paginate(16);
         
        $meta_desc = 'Kích thước';
        $meta_keywords = 'Kích thước';
        $meta_title = 'Kích thước';
        $url_canonical = $request->url();
       
        return view('pages.size.show_size')->with('category',$cate_product)->with('sizes',$sizes)->with('size_by_id',$size_by_id)->with('colors',$colors)->with('meta_desc',$meta_desc)->with('meta_title',$meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }
}
