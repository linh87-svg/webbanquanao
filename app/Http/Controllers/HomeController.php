<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use App\Social; 
use App\Product; 
use Socialite; 
use App\Login; 
use App\Users;
use App\Order;
use App\OrderDetails;
use App\Shipping;
use App\Coupon;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();
class HomeController extends Controller
{
     public function index(Request $request)
    {
        // seo
        $meta_desc = "MAYBOUTIQUE cung cấp đầy đủ thời trang tuổi teen với nhiều mức giá ưu đãi vô cùng hấp dẫn.Mua ngay";
        $meta_keywords = "quần áo tuổi teen,quan ao,thời trang, quần áo thời trang";
        $meta_title = "MAY BOUTIQUE";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        $max_price_range =  $max_price + 100000;
        $min_price_range =  $min_price;
  if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by == 'giam_dan'){
                $all_product = Product::orderBy('product_price','DESC')->paginate(16)->appends(request()->query());
            }elseif($sort_by == 'tang_dan'){
                $all_product = Product::orderBy('product_price','ASC')->paginate(16)->appends(request()->query());
            }elseif($sort_by == 'kytu_za'){
                $all_product = Product::orderBy('product_name','DESC')->paginate(16)->appends(request()->query());
            }elseif ($sort_by == 'kytu_az') {
                $all_product = Product::orderBy('product_name','ASC')->paginate(16)->appends(request()->query());
            }
        }elseif(isset($_GET['start_price']) && $_GET['end_price']){
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];

            $all_product = Product::whereBetween('product_price',[$min_price,$max_price])->orderBy('product_id','DESC')->paginate(16)->appends(request()->query());
        }else{
            $all_product = Product::orderBy('product_id')->paginate(16);
        }

        return view('pages.home')->with('category',$cate_product)->with('colors',$colors)->with('sizes',$sizes)->with('all_product',$all_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('min_price',$min_price)->with('max_price',$max_price)->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range);
    }
    public function search(Request $request){
        $keywords = $request->key; 
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%' .$keywords. '%')->paginate(20)->appends(['key' => $keywords]);
        $meta_desc = "MAYBOUTIQUE cung cấp đầy đủ thời trang tuổi teen với nhiều mức giá ưu đãi vô cùng hấp dẫn.Mua ngay";
        $meta_keywords = "quần áo tuổi teen,quan ao,thời trang, quần áo thời trang";
        $meta_title = "MAY BOUTIQUE";
        $url_canonical = $request->url();
        return view('pages.product.search')->with('category',$cate_product)->with('colors',$colors)->with('sizes',$sizes)->with('search_product',$search_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function send_mail(){
        $to_name = "Thùy Linh";
        $to_email = "httlinh.dhti15a1hn@sv.uneti.edu.vn";//send to this email
        $data = array("name"=>"Mail từ tài khoản khách","body"=>'mail gửi về vấn đề hàng hóa'); //body of mail.blade.php
        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
       $message->to($to_email)->subject('Test mail');//send this mail with subject
        $message->from($to_email,$to_name);//send from this mail
        });
      return Redirect('/')->with('message','Gửi thành công');
    }
    public function login_google(){
        return Socialite::driver('google')->redirect();
   }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        // return $users->id;
        $authUser = $this->findOrCreateUser($users,'google');
        if($authUser){
            $account_name = Login::where('user_id',$authUser->user)->first();
            Session::put('user_name',$account_name->user_name);
            Session::put('user_id',$account_name->user_id);
        }elseif($customer_new){
            $account_name = Login::where('user_id',$authUser->user)->first();
            Session::put('user_name',$account_name->user_name);
            Session::put('user_id',$account_name->user_id);
        }
        Toastr::success('Đăng nhập thành công!','Thông báo');
        return redirect('/');    
    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }else{
            $customer_new = new Social([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider)
        ]);

        $orang = Login::where('user_email',$users->email)->first();

            if(!$orang){
                $orang = Login::create([
                    'user_name' => $users->name,
                    'user_email' =>$users->email,
                    'user_password' => '',
                    'user_phone' => ''
                ]);
            }
        $customer_new->login()->associate($orang);
        $customer_new->save();
        return $customer_new;
        }
    }
    public function user_info(){
        $getorder = Order::where('user_id',Session::get('user_id'))->orderBy('order_id','DESC')->paginate(5);
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.user_info')->with(compact('getorder'))->with('category',$cate_product);
    }
    public function product_wishlist(Request $request){
        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "Sản phẩm yêu thích";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        return view('pages.product.product_wishlist')->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('category',$cate_product)->with('colors',$colors)->with('sizes',$sizes);
    }
    public function view_history($order_code){
        $order_details = OrderDetails::with('product', 'color', 'size')->where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->first();
        
            $user_id = $order->user_id;
            $shipping_id = $order->shipping_id;
            $order_status = $order->order_status;
     
        $user = Users::where('user_id',$user_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $order_details_product = OrderDetails::with('product', 'color', 'size')->where('order_code', $order_code)->get();

        foreach($order_details_product as $key => $ord_detail){
            $product_coupon = $ord_detail->product_coupon;
        }
        if($product_coupon != '0'){
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.view_history')->with(compact('order_details','user', 'shipping','order_details_product', 'coupon_condition', 'coupon_number','order', 'order_status','cate_product'));
    }
    public function dac_quyen(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.footer.dac_quyen')->with('category',$cate_product);
    }
    public function den_bu(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.footer.den_bu')->with('category',$cate_product);
    }
    public function doi_tra(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.footer.doi_tra')->with('category',$cate_product);
    }
    public function bao_mat(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.footer.bao_mat')->with('category',$cate_product);
    }
    public function giao_hang(){
       $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.footer.giao_hang')->with('category',$cate_product);
    }
}
