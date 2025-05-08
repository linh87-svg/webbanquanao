<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Auth;
use App\Order;
use App\OrderDetails;
use App\Shipping;
use App\Feeship;
use App\Users;
use App\Coupon;
use App\Color;
use App\Size;
use App\Statistic;
use App\Product;
use PDF;
use App\Exports\ExcelExport;
use Excel;
use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;
session_start();

class OrderController extends Controller
{
     public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }

    public function export_csv(){
        return Excel::download(new ExcelExport , 'order.xlsx');
    }
    public function manager_order(){
        $this->AuthLogin();
        $order = Order::orderBy('created_at','DESC')->get();
        return view('admin.manager_order')->with(compact('order'));
    }

   public function view_order($order_code){
        $this->AuthLogin();
        $order_details = OrderDetails::with('product', 'color', 'size')->where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $user_id = $ord->user_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
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
        return view('admin.view_order')->with(compact('order_details','user', 'shipping','order_details_product', 'coupon_condition', 'coupon_number','order', 'order_status'));
    }
    public function print_order($checkout_code){
    
        
        $this->AuthLogin();
        $pdf = \App::make('dompdf.wrapper');
        $html = $this->print_order_convert($checkout_code);

        // Kiểm tra nội dung HTML
        if (empty($html)) {
            dd('HTML trống');
        }
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
   
    public function print_order_convert($checkout_code) {
        $this->AuthLogin();
        $order_details = OrderDetails::where('order_code', $checkout_code)->get();
        $order = Order::where('order_code', $checkout_code)->get();

        foreach ($order as $key => $ord) {
            $user_id = $ord->user_id;
            $shipping_id = $ord->shipping_id;
        }

        $user = Users::where('user_id', $user_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

        $output = '';

        // CSS
        $output .= '<style>
            body { font-family: DejaVu Sans; }
            .container { border: 1px solid #000; padding: 10px; width: 100%; }
            .header { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 10px; }
            .flex-container {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-start;
                width: 100%;
                max-width: 100%;
                gap: 10px;
            }
            .box {
                flex: 1;
                min-width: 45%;
                border: 1px solid #000;
                padding: 5px;
                box-sizing: border-box;
            }
            .table-styling { width: 100%; border-collapse: collapse; }
            .table-styling th, .table-styling td { border: 1px solid #000; padding: 5px; text-align: left; }
            .signature { margin-top: 20px; text-align: center; }
        </style>';

        // Header
        $output .= '<div class="header">May Boutique</div>';
        
        // Mã vận đơn & mã đơn hàng
        $output .= '<p><strong>Mã vận đơn:</strong> MBSP' . strtoupper(substr(md5($checkout_code), 0, 12)) . '</p>';
        $output .= '<p><strong>Mã đơn hàng:</strong> ' . $checkout_code . '</p>';

        // Thông tin Người bán & Người nhận
        $output .= '<table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; border: 1px solid #000; padding: 10px;">
                    <h3>Người gửi</h3>
                    <p><strong>Tên:</strong> MAY BOUTIQUE</p>
                    <p><strong>Địa chỉ:</strong> 101 P. Chùa Bộc, Trung Liệt, Đống Đa, Hà Nội</p>
                    <p><strong>SĐT:</strong> 024 22683232</p>
                </td>
                <td style="width: 50%; border: 1px solid #000; padding: 10px;">
                    <h3>Người nhận</h3>
                    <p><strong>Tên:</strong> ' . $shipping->shipping_name . '</p>
                    <p><strong>Địa chỉ:</strong> ' . $shipping->shipping_address . '</p>
                    <p><strong>SĐT:</strong> ' . $shipping->shipping_phone . '</p>
                </td>
            </tr>
        </table>';

       $output .= '<p><strong>Đơn hàng</strong></p>';
        $total = 0;

        foreach ($order_details_product as $key => $product) {
            $subtotal = $product->product_quantity * $product->product_price;
            $total += $subtotal;
            $feeship = $product->product_feeship;

            // Kiểm tra nếu color và size có tồn tại trước khi truy cập thuộc tính con
            $color_name = $product->color_name;
            $size_name = $product->size_name;

            $output .= '<p>' . ($key + 1) . '. ' . $product->product_name . ' - SL: ' 
                . $product->product_quantity . ' - Màu sắc: ' . $color_name . ' - Size: ' . $size_name . '</p>';
        }

        $total_payment = $total + $feeship;

        // Hiển thị tổng tiền + phí vận chuyển
        // $output .= '<p><strong>Tổng giá trị đơn hàng:</strong> ' . number_format($total, 0, ',', '.') . ' đồng</p>';
        // $output .= '<p><strong>Phí vận chuyển:</strong> ' . number_format($feeship, 0, ',', '.') . ' đồng</p>';
        $output .= '<p><strong>Tổng thanh toán:</strong> ' . number_format($total_payment, 0, ',', '.') . ' đồng</p>';

        // Chữ ký người nhận
        $output .= '<div class="signature">
            <p><strong>Chữ ký người nhận:</strong> ______________________</p>
            <p>(Xác nhận hàng nguyên vẹn, không móp méo, bể vỡ)</p>
        </div>';

        return $output;
    } 
    public function update_order_qty(Request $request){
        //update_code
        $data = $request ->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();
        //order_date
        $order_date = $order->order_date;
        $statistic = Statistic::where('order_date', $order_date)->get();
        if($statistic){
            $statistic_count = $statistic->count();
        }else{
            $statistic_count = 0;
        }

       if($order->order_status == 2){
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;

            foreach($data['order_product_id'] as $key => $product_id){
                $product = Product::find($product_id);
                $product_quantities = $product->product_quantities;
                $product_sold = $product->product_sold;

                $product_price = $product->product_price;
                $price_cost = $product->price_cost;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

                foreach($data['quantities'] as $key2 => $qty){

                    if($key == $key2){
                        $product_remain = $product_quantities - $qty;
                        $product->product_quantities = $product_remain;
                        $product->product_sold = $product_sold + $qty;
                        $product->save();
                        //update doanh thu
                        $quantity+=$qty;
                        $total_order+=1;
                        $sales+= intval($product_price)* intval($qty);
                        $profit += (intval($product_price)*intval($qty))-(intval($price_cost)*intval($qty));

                    }

                }
            }
            //update dso db
            if($statistic_count>0){
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            }else{
                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }
        }
    }
        public function huy_don_hang(Request $request){
            $data = $request->all();
            $order = Order::where('order_code',$data['order_code'])->first();
            $order->order_destroy = $data['lydo'];
            $order->order_status = 3;
            $order->save();
        }


}
