<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){

    $pr_id = $request->productid_hidden;
    $pr_color = $request->prcolor_hidden;
    $pr_size = $request->prsize_hidden;
    $quantity = $request->soluong;

    $pr_info = DB::table('tbl_product')->where('product_id', $pr_id)->first();

    $data['id'] = $pr_info->product_id;
    $data['qty'] = $quantity;
    $data['name'] = $pr_info->product_name;
    $data['price'] = $pr_info->product_price;
    $data['weight'] = $pr_info->product_price;
    $data['options'] = [
        'image' => $pr_info->product_images,
        'color' => $pr_color,
        'size' => $pr_size
    ];
    
    Cart::add($data);
    Cart::setGlobalTax(0);
    Toastr::success('Thêm giỏ hàng thành công!','Thông báo');
    // Chuyển hướng đến trang giỏ hàng
    return Redirect::to('/show-cart');
    }
    public function show_cart(Request $request) {
    $cate_product = DB::table('tbl_category_product')->orderBy('category_id', 'asc')->get();
    $colors = DB::table('tbl_color')->orderBy('color_id', 'asc')->get();
    $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
    $meta_desc = 'Giỏ hàng';
    $meta_keywords = 'Giỏ hàng';
    $meta_title = 'Giỏ hàng';
    $url_canonical = $request->url();
    return view('pages.cart.show_cart')
        ->with('category', $cate_product)
        ->with('colors', $colors)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('sizes',$sizes);
    }
    public function delete_cart($rowId){
        Cart::update($rowId,0);
        Toastr::success('Xóa giỏ hàng thành công!','Thông báo');
        Session::forget('coupon');
        Session::forget('fee');

        return Redirect::to('/show-cart');
    }
    public function delete_all(){
        Cart::destroy();
        Toastr::success('Xóa giỏ hàng thành công!','Thông báo');
        Session::forget('coupon');
        Session::forget('fee');
         return Redirect::to('/show-cart');
    }
    public function update_qty(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
         Cart::update($rowId,$qty);
         Toastr::success('Cập nhật số lượng thành công!','Thông báo');
         return Redirect::to('/show-cart');
    }
    public function count_cart(){
        $cart = Cart::content()->count();
        $output ='';
        if($cart > 0){
             $output .= '<li><a href="'.url('/show-cart').'"><i class="fa fa-shopping-cart"></i> Giỏ hàng
                                    <span style="color:red;" class="badges">('.$cart.')</span>
                                </a></li>';
        }else{
            $output .= '<li><a href="'.url('/show-cart').'"><i class="fa fa-shopping-cart"></i> Giỏ hàng
                                    <span style="color:red;" class="badges">(0)</span>
                                </a></li>';
        }


         echo $output;           
    }
   
}
