<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Color;
use Session;
use Auth;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();

class ColorProduct extends Controller
{

//Admin
    public function AuthLogin(){
          $admin_id = Auth::id();
          if($admin_id){
           return Redirect::to('dashboard');
          }else{
           return Redirect::to('login-auth')->send();
          }
        }
public function add_color(){
        $this->AuthLogin();
        $all_color = Color::orderBy('color_id','DESC')->paginate(10);
        return view('admin.add_color')->with('all_color',$all_color);
    }


    public function save_color(Request $request){
        $this->AuthLogin();
        $data = $request->validate([
            'color_name' =>'required|unique:tbl_color|regex:/^[a-zA-Z\s]/|max:100',
          ],
          [
            'color_name.required' => 'Tên màu sắc không được để trống',
            'color_name.unique' => 'Màu này đã tồn tại',
             'color_name.regex' => 'Tên màu sắc chỉ được phép chứa chữ cái',
          ]);
        $color = new Color();
        $color->color_name =  $data['color_name'];
        $color->save();
        Toastr::success('Thêm màu sắc thành công!','Thông báo');
        return Redirect::to('/add-color');
    }
    public function delete_color($color_id){
        $this->AuthLogin();
        DB::table('tbl_color')->where('color_id', $color_id)->delete();
        Toastr::success('Xóa màu sắc thành công!','Thông báo');
        return Redirect::to('/add-color');
    }


  //endadmin  
    public function show_color_home(Request $request, $product_color_id){
         $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
         $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
         $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
         $color_by_id = DB::table('tbl_product')->join('tbl_product_color','tbl_product.product_id','=','tbl_product_color.product_id')->where('tbl_product_color.color_id',$product_color_id)->paginate(16);
         
        $meta_desc = 'Màu sắc';
        $meta_keywords = 'Màu sắc';
        $meta_title = 'Màu sắc';
        $url_canonical = $request->url();
       
        return view('pages.colors.show_color')->with('category',$cate_product)->with('colors',$colors)->with('color_by_id',$color_by_id)->with('sizes',$sizes)->with('meta_desc',$meta_desc)->with('meta_title',$meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }
}
