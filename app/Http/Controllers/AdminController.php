<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Login;
use App\Statistic;
use App\Visitors;
use App\Product;
use App\Order;
use App\OrderDetails;
use App\Users;
use App\Social; //sử dụng model Social
use Socialite; //sử dụng Socialite
use Illuminate\Support\Facades\Redirect;
session_start();
use Auth;
use Carbon\Carbon;


class AdminController extends Controller
{
  public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }
      public function index(){
       return view('admin_login');
    }
    public function show_dashboard(Request $request){
      $this ->AuthLogin();
      $user_ip_address = $request->ip();

      $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
      $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
      $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
      $one_years = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
      $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

      $product = Product::all()->count();
      $order = Order::all()->count();
      $users = Users::all()->count();
      $product_views = Product::orderBy('product_views', 'DESC')->take(20)->get();

      return view('admin.dashboard')->with(compact('product', 'order', 'users', 'product_views'));
    }
    public function dashboard(Request $request){
      //sd Model
      $data = $request->all();
      $admin_email = $data['admin_email'];
      $admin_password = md5($data['admin_password']);
      $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
      if($login){
        $login_count = $login->count();
         if($login_count > 0){
          Session::put('admin_name',$login->admin_name);
          Session::put('admin_id',$login->admin_id);
          return Redirect::to('/dashboard');
        }
      }else{
     
         Session::put('message','Email hoặc mật khẩu không đúng. Vui lòng nhập lại');
       return Redirect::to('/admin');
      }
    }
    public function logout(){
         $this ->AuthLogin();
      Session::put('admin_name',null);
      Session::put('admin_id',null);
       return Redirect::to('/admin');
    }
    public function filter_by_date(Request $request){
        $data = $request->all();
        $form_date = $data['form_date'];
        $to_date = $data['to_date'];

        $get = Statistic::whereBetween('order_date', [$form_date, $to_date])->orderBy('order_date', 'ASC')->get();
      $chart_data = [];
        foreach($get as $key => $val){
            $chart_data[] = array(
                'period' =>$val->order_date,
                'order' =>$val->total_order,
                'sales' =>$val->sales,
                'profit' =>$val->profit,
                'quantity' =>$val->quantity
            );
        }
        echo $data = json_encode($chart_data);  
        
        
    }
    public function dashboard_filter(Request $request){
        $data = $request->all();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();

        // Tính toán tháng trước, tháng sau
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        // Lấy dữ liệu năm nay
        if ($data['dashboard_value'] == '7ngay') {
            // Lấy dữ liệu trong vòng 7 ngày của năm nay
            $get = Statistic::whereBetween('order_date', [$sub7days, $now])->get();
        } elseif ($data['dashboard_value'] == 'thangtruoc') {
            // Lấy dữ liệu tháng trước của năm nay
            $get = Statistic::whereBetween('order_date', [$dau_thangtruoc, $cuoi_thangtruoc])->get();
        } elseif ($data['dashboard_value'] == 'thangnay') {
            // Lấy dữ liệu tháng này của năm nay
            $get = Statistic::whereBetween('order_date', [$dauthangnay, $now])->get();
        } elseif ($data['dashboard_value'] == '365ngay') {
            $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
            $get = Statistic::whereBetween('order_date', [$sub365days, $now])->get();
        } else {
            // fallback nếu không đúng gì cả
            $get = collect(); // trả về mảng rỗng để không bị lỗi
        }

        // Tạo dữ liệu chart
        $chart_data = [];
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }

        return response()->json($chart_data);
        }
    public function dashboard_kpi(Request $request)
        {
            $form_date = $request->input('form_date');
            $to_date = $request->input('to_date');

            $current = Statistic::whereRaw("STR_TO_DATE(order_date, '%Y-%m-%d') BETWEEN ? AND ?",[$form_date, $to_date])->get();
            $sum = fn($data, $field) => $data->sum($field);

            $kpi = [
                'order' => [ 'value' => $sum($current, 'total_order') ],
                'sales' => [ 'value' => $sum($current, 'sales') ],
                'profit' => [ 'value' => $sum($current, 'profit') ],
                'quantity' => [ 'value' => $sum($current, 'quantity') ],
            ];

            return response()->json($kpi);
        }

        
     public function days_order(){
        
        $sub30days = Carbon::now()->subDays(30)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');

        $Statistic = Statistic::whereBetween('order_date', [$sub30days, $now])->orderBy('order_date', 'ASC')->get();

        $data = [];
        $total_sales = $Statistic->sum('sales');  // Tổng doanh thu trong 30 ngày

        foreach ($Statistic as $item) {
            $period = $item->order_date;

            // Lấy ngày cùng kỳ năm trước
            $last_year_date = Carbon::parse($period)->subYear()->toDateString();

            // Tìm doanh số của ngày tương ứng năm trước (dùng STR_TO_DATE vì order_date là varchar)
            $last_year_stat = Statistic::whereRaw("STR_TO_DATE(order_date, '%Y-%m-%d') = ?", [$last_year_date])->first();
            $sales_last = $last_year_stat ? $last_year_stat->sales : 0;

            $percentage_sales = ($total_sales > 0) ? ($item->sales / $total_sales) * 100 : 0;

            $data[] = [
                'period' => $period,
                'sales' => $item->sales,
                'sales_percentage' => $percentage_sales,
                'sales_last' => $sales_last
            ];
        }

        return response()->json($data);
    }
    public function compare_sales_month()
    {
        $current_year = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $last_year = $current_year - 1;

        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $start_current = Carbon::createFromDate($current_year, $month, 1)->startOfMonth();
            $end_current = $start_current->copy()->endOfMonth();

            $start_last = Carbon::createFromDate($last_year, $month, 1)->startOfMonth();
            $end_last = $start_last->copy()->endOfMonth();

            $sales_current = Statistic::whereBetween('order_date', [$start_current, $end_current])->sum('sales');
            $sales_last = Statistic::whereBetween('order_date', [$start_last, $end_last])->sum('sales');

            // Tính phần trăm thay đổi
            $percent_change = 0;
            if ($sales_last > 0) {
                $percent_change = (($sales_current - $sales_last) / $sales_last) * 100;
            } elseif ($sales_current > 0) {
                $percent_change = 100;
            }

            $data[] = [
                'month' => 'Tháng ' . $month,
                'sales_this_year' => $sales_current,
                'sales_last_year' => $sales_last,
                'percent_change' => round($percent_change, 2) // thêm phần trăm
            ];
        }

        return response()->json($data);
    }
    public function compare_profit_month()
    {
        $current_year = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $last_year = $current_year - 1;

        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $start_current = Carbon::createFromDate($current_year, $month, 1)->startOfMonth();
            $end_current = $start_current->copy()->endOfMonth();

            $start_last = Carbon::createFromDate($last_year, $month, 1)->startOfMonth();
            $end_last = $start_last->copy()->endOfMonth();

            $profit_current = Statistic::whereBetween('order_date', [$start_current, $end_current])->sum('profit');
            $profit_last = Statistic::whereBetween('order_date', [$start_last, $end_last])->sum('profit');

            $percent_change = 0;
            if ($profit_last > 0) {
                $percent_change = (($profit_current - $profit_last) / $profit_last) * 100;
            } elseif ($profit_current > 0) {
                $percent_change = 100;
            }

            $data[] = [
                'month' => 'Tháng ' . $month,
                'sales_this_year' => $profit_current,
                'sales_last_year' => $profit_last,
                'percent_change' => round($percent_change, 2)
            ];
        }

        return response()->json($data);
    }
    public function top_selling_products(){
        $topProducts = Product::select('product_id', 'product_name', 'product_sold')->where('product_sold', '>', 10)->orderByDesc('product_sold')->get();

    return response()->json($topProducts);
    }
    public function recent_orders()
    {
        $orders = Order::join('tbl_user', 'tbl_order.user_id', '=', 'tbl_user.user_id')->select('tbl_order.order_code','tbl_user.user_name',\DB::raw('(SELECT SUM(product_price * product_quantity)
            FROM tbl_order_details
            WHERE tbl_order_details.order_code = tbl_order.order_code) as total_amount'),'tbl_order.created_at', 'tbl_order.order_status'
        )
        ->orderByDesc('tbl_order.order_id')
        ->limit(5)
        ->get();

    return response()->json($orders);
    }
}
