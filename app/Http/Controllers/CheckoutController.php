<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Province;
use App\District;
use App\Wards;
use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\Coupon;
use Carbon\Carbon;
use App\Users;
use Mail;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
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
   
    //Client
    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product);
    }
    public function add_user(Request $request){
        // $data = array();
        $data = $request->validate(
            [
            'user_name' => 'required|string',
            'user_email' => 'required|email|unique:tbl_user|max:255',
            'user_password' =>[
            'required',
            'max:255',
            'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'confirmed'
        ],
            'user_phone' => 'required|regex:/^0[0-9]{9,14}$/',
            'user_address' => 'required|string',
             
            ],
             [
                'user_name.required' => 'Họ tên không được để trống',
                'user_email.required'  => 'Email không được để trống',
                'user_email.unique'  => 'Email đã tồn tại!',
                'user_email.regex'  => 'Email không đúng định dạng!',
                'user_password.required'  => 'Mật khẩu không được để trống',
                'user_password.regex' => 'Mật khẩu phải có ít nhất một chữ hoa, một chữ thường và một số!',
                'user_password.confirmed'  => 'Mật khẩu xác nhận không trùng!',
                'user_phone.required'  => 'Số điện thoại không được để trống',
                'user_phone.regex' => 'Số điện thoại không hợp lệ! Phải bắt đầu bằng số 0 và từ 10-15 số!',
                'user_address.required' => 'Địa chỉ không được để trống',
            ]
        );
        $data['user_name'] = $request->user_name;
        $data['user_email'] = $request->user_email;
        $data['user_password'] = md5($request->user_password);
        $data['user_phone'] = $request->user_phone;
        $data['user_address'] = $request->user_address;

        $user_id = DB::table('tbl_user')->insertGetId($data);

        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $all_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->paginate(20);
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = '';
        $url_canonical = $request->url();
        Session::put('user_id',$user_id);
        Session::put('user_name',$request->user_name);
        Toastr::success('Đăng ký thành công!','Thông báo');
       return view('pages.home')->with('category',$cate_product)->with('colors',$colors)->with('all_product',$all_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('sizes',$sizes);
    }
    public function checkout(Request $request){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $meta_desc = 'Thanh toán';
        $meta_keywords = 'Thanh toán';
        $meta_title = 'Thanh toán';
        $url_canonical = $request->url();
        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('colors',$colors)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function save_checkout_user(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_note'] = $request->shipping_note;
        $data['shipping_address'] = $request->shipping_address;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);
       return Redirect::to('/payment');
    }
    public function payment(){
        $province = Province::orderBy('province_id','asc')->get();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.checkout.payment')->with('province',$province)->with('category',$cate_product);
    }

    public function logout_checkout(){
        Session::flush();

        return Redirect::to('/login-checkout');
    }
    public function dang_ky(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        return view('pages.checkout.sign-up')->with('category',$cate_product);
    }
    public function login_user(Request $request){

        $data = $request->validate([
        'email_account' => 'required|email|max:50',
        'password_account' => [
            'required',
            'max:255',
            'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/'
        ],
    ], [
        'email_account.required' => 'Email không được để trống!',
        'email_account.email' => 'Email không hợp lệ. Vui lòng nhập đúng định dạng email!',
        
        'password_account.required' => 'Mật khẩu không được để trống!',
        'password_account.max' => 'Mật khẩu không được quá 255 ký tự!',
        'password_account.regex' => 'Mật khẩu phải có ít nhất một chữ hoa, một chữ thường và một số!',
        
    ]);
        $email = $request->email_account;
        $password = md5($request->password_account);

        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $all_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->paginate(20);
        $result = DB::table('tbl_user')->where('user_email',$email)->where('user_password',$password)->first();
        $meta_desc = 'Thanh toán';
        $meta_keywords = 'Thanh toán';
        $meta_title = 'Thanh toán';
        $url_canonical = $request->url();   
        if ($result) {
            if ($result->user_status == 0) {
                Toastr::error('Tài khoản của bạn đã bị khóa!', 'Thông báo');
                return Redirect::to('/login-checkout');
            }

            Session::put('user_id', $result->user_id);
            Toastr::success('Đăng nhập thành công!', 'Thông báo');

            return view('pages.home')->with([
                'category' => $cate_product,
                'colors' => $colors,
                'all_product' => $all_product,
                'meta_desc' => $meta_desc,
                'meta_keywords' => $meta_keywords,
                'meta_title' => $meta_title,
                'url_canonical' => $url_canonical,
                'sizes' => $sizes
            ]);
        } else {
            Toastr::error('Email hoặc mật khẩu không đúng!', 'Thông báo');
            return Redirect::to('/login-checkout');
        }
    }
    public function select_delivery_home(Request $request){
         $data = $request->all();
        if($data['action']){
            $output ='';
            if($data['action'] == "province"){

                $select_district = District::where('province_id',$data['ma_id'])->orderBy('district_id', 'ASC')->get();
                 $output.='<option >Chọn quận huyện</option>';
                foreach($select_district as $key => $district ){
                $output.='<option value ="'.$district->district_id.'">'.$district->name.'</option>';
                }
            }else{

                $select_wards = Wards::where('district_id',$data['ma_id'])->orderBy('wards_id', 'ASC')->get();
                 $output.='<option >Chọn xã phường thị trấn</option>';
                foreach($select_wards as $key => $wards ){
                $output.='<option value ="'.$wards->wards_id.'">'.$wards->name.'</option>';
                }
            }
        }
        echo $output;
    }
    public function calculate_fee(Request $request){
          $data = $request->all();
          if($data['province']){
            $feeship = Feeship::where('province_id',$data['province'])->where('district_id',$data['district'])->where('wards_id',$data['wards'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship > 0){
                    foreach($feeship as $key => $fee){
                    Session::put('fee',$fee->fee_feeship);
                    Session::save();
                    }
                }else{
                    Session::put('fee',20000);
                    Session::save();
                }
            }
            
          }
    }
    public function updateVipStatus($userId)
    {
        $totalSpent = $this->calculateTotalSpent($userId);

        // Nếu tổng chi tiêu lớn hơn 5 triệu, nâng hạng khách hàng lên VIP
        $isVip = $totalSpent > 5000000 ? 1 : 0;

        // Cập nhật trạng thái VIP cho khách hàng
        DB::table('tbl_user')->where('user_id', $userId)->update(['user_vip' => $isVip]);
    }

    public function calculateTotalSpent($userId)
    {
        // Tính tổng giá trị chi tiêu của khách hàng từ bảng order_details
        $totalSpent = DB::table('tbl_order_details')
            ->join('tbl_order', 'tbl_order.order_code', '=', 'tbl_order_details.order_code')
            ->where('tbl_order.user_id', $userId)
            ->sum(DB::raw('tbl_order_details.product_price * tbl_order_details.product_quantity'));

        return $totalSpent;
    }
        public function order_place(Request $request){
        // get payment_method
        $data = array();
        $data['payment_method'] = $request->payment_options;
        $data['payment_status'] = 'Đang chờ xử lí';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

       //insert order
        $order_data = array();
        $order_data['user_id'] =  Session::get('user_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id ;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lí';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

         //insert order
        $content = Cart::content();
        foreach($content as $v_content){
        $order_detail_data = array();
        $order_detail_data['order_id'] =  $order_id;
        $order_detail_data['product_id'] = $v_content->id;
        $order_detail_data['product_name'] = $v_content->name ;
        $order_detail_data['product_price'] = $v_content->price;
        $order_detail_data['color_id'] = $v_content->options->color ;
        $order_detail_data['size_id'] = $v_content->options->size;
        $order_detail_data['product_quantity'] = $v_content->qty;
        DB::table('tbl_order_details')->insert($order_detail_data);
      
       $this->updateVipStatus(Session::get('user_id'));
        }
        if($data['payment_method'] == 1){
            echo 'Thanh toán ATM';
        }else {
            Cart::destroy();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $meta_desc = 'Thanh toán';
        $meta_keywords = 'Thanh toán';
        $meta_title = 'Thanh toán';
        $url_canonical = $request->url();
        return view('pages.checkout.handcash')->with('category',$cate_product)->with('colors',$colors)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
        }
      //return Redirect::to('/payment');   
    }
    public function confirm_order(Request $request){
        $data = $request->all();
        if (!isset($data['order_fee']) || $data['order_fee'] == 0) {
        return response()->json(['error' => 'Vui lòng tính phí vận chuyển trước khi đặt hàng!'], 400);
    }
        //get coupon
        if($data['order_coupon'] != 0){
            $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
            $coupon->coupon_used = $coupon->coupon_used.','.Session::get('user_id'); 
            $coupon->coupon_quantity = $coupon->coupon_quantity - 1;
            $coupon_mail = $coupon->coupon_code;
            $coupon->save();
        }else{
            $coupon_mail='Không có';
        }
        
        //get shipping
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order = new Order();
        $order->user_id = Session::get('user_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
         $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d'); 
         $order->created_at = Carbon::now('Asia/Ho_Chi_Minh');
         $order->order_date = $order_date;
         $order->save();


        if(Session::get('cart')){
             $content = Cart::content();
            foreach($content as $cart){
                 $order_detail = new OrderDetails();
                 $order_detail->order_code = $checkout_code;
                 $order_detail->product_id = $cart->id;
                 $order_detail->product_name = $cart->name;
                 $order_detail->product_price = $cart->price;
                 $order_detail->color_name = $cart->options->color;
                 $order_detail->size_name = $cart->options->size;
                 $order_detail->product_quantity = $cart->qty;
                 $order_detail->product_coupon = $data['order_coupon'];
                 $order_detail->product_feeship = $data['order_fee'];
                 $order_detail->save();
            }
        }
        //send mail confirm
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Đơn hàng xác nhận ngày".' '.$now;
        $customer = Users::find(Session::get('user_id'));
        $data['email'][] = $customer->user_email;

        
        // lấy phí vận chuyển
        if(Session::get('fee') == true){
            $fee = Session::get('fee');
        }else{
            $fee = '20000₫';
        }
        $shipping_array = array(
            'fee' => $fee,
            'user_name' => $customer->user_name,
            'shipping_name' =>$data['shipping_name'],
            'shipping_email' =>$data['shipping_email'],
            'shipping_phone' =>$data['shipping_phone'],
            'shipping_address' =>$data['shipping_address'],
            'shipping_note' =>$data['shipping_note'],
            'shipping_method' =>$data['shipping_method']
        );
        $ordercode_mail = array(
            'coupon_code' => $coupon_mail,
            'order_code' => $checkout_code
        );
        Mail::send('pages.mail.mail_order', ['shipping_array' => $shipping_array,'code' => $ordercode_mail], function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        Session::forget('fee');
        Session::forget('cart');
        Session::forget('coupon');
    }
     public function vnpay_payment(Request $request){
        $data = $request->all();
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://shopmay.com/shoplaravel/payment";
        $vnp_TmnCode = "N9XHS6EJ";//Mã website tại VNPAY 
        $vnp_HashSecret = "PJV379JDUSZNS2RJ1K90D40S6XCS2VME"; //Chuỗi bí mật
        
        $vnp_TxnRef = rand(00,9999); 
        $vnp_OrderInfo = 'Thanh toán đơn hàng test';
        $vnp_OrderType ='billpayment';
        $vnp_Amount = $data['total_vnpay'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
       
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef     
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        // }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
     }

            
    }
