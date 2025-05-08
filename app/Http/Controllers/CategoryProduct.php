<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Category;
use App\Product;
use Auth;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();
class CategoryProduct extends Controller
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
  
    public function add_category_product(){
          $this->AuthLogin();
          $category = Category::where('category_parent',0)->get();
          $all_category_product = Category::orderBy('category_id', 'DESC')->paginate(10);
            return view('admin.add_category_product')->with(compact('category','all_category_product'));
        }
    public function all_category_product(){
        $this->AuthLogin();
        $category_product = Category::where('category_parent',0)->get();
        $all_category_product = Category::orderBy('category_id', 'ASC')->paginate(10);
        $manager_category_product = view ('admin.all_category_product')->with('all_category_product', $all_category_product)->with(compact('category_product'));
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }
    public function save_category_product(Request $request){
            $this->AuthLogin();
             //sử dụng Model
          $data = $request->validate([
            'category_name' =>'required|unique:tbl_category_product|string|max:255',
            'category_parent' => 'required|not_in:0'
          ],
          [
            'category_name.required' => 'Tên danh mục không được để trống!',
            'category_name.unique'   => 'Tên danh mục đã tồn tại!',
            'category_parent.required' => 'Vui lòng chọn danh mục cha!',
            'category_parent.not_in'   => 'Vui lòng chọn danh mục cha khác!'
          ]);
          $category = new Category();
          $category->category_name = $data['category_name'];
          $category->category_parent = $data['category_parent'];
          $category->save();
       Toastr::success('Thêm danh mục sản phẩm thành công!','Thông báo');
        return Redirect::to('/add-category-product');
    }

    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $category = Category::orderBy('category_id', 'DESC')->get();
        $edit_category_product = Category::where('category_id', $category_product_id)->get();
        $manager_category_product = view ('admin.edit_category_product')->with('edit_category_product', $edit_category_product)->with('category', $category);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }

    public function update_category_product(Request $request, $category_product_id){
          $this->AuthLogin();
         //sử dụng Model
          $data = $request->validate([
            'category_name' =>'required|string|max:255',
            'category_parent' => 'required|not_in:0'
          ],
          [
            'category_name.required'   => 'Tên danh mục đã tồn tại!',
            'category_name.unique'   => 'Tên danh mục đã tồn tại!',
            'category_parent.not_in'   => 'Vui lòng chọn danh mục cha khác!'
          ]);
          $category = Category::find($category_product_id);
          $category->category_name = $data['category_name'];
          $category->category_parent = $data['category_parent'];
          $category->save();
         
        Toastr::success('Cập nhật danh mục sản phẩm thành công!','Thông báo');
        return Redirect::to('/add-category-product');
    }

    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        Toastr::success('Xóa danh mục sản phẩm thành công!','Thông báo');
        return Redirect::to('/add-category-product');
    }


    //ENdadmin
    //danh mục sp bên client
    public function show_category_home(Request $request, $category_id){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        $max_price_range =  $max_price + 50000;
        $min_price_range =  $min_price - 50000;
  if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by == 'giam_dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','DESC')->paginate(20)->appends(request()->query());
            }elseif($sort_by == 'tang_dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','ASC')->paginate(20)->appends(request()->query());
            }elseif($sort_by == 'kytu_za'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','DESC')->paginate(20)->appends(request()->query());
            }elseif ($sort_by == 'kytu_az') {
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','ASC')->paginate(20)->appends(request()->query());
            }
        }elseif(isset($_GET['start_price']) && $_GET['end_price']){
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];

            $category_by_id = Product::with('category')->whereBetween('product_price',[$min_price,$max_price])->orderBy('product_id','DESC')->paginate(20)->appends(request()->query());
        }else{
            $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_id','DESC')->paginate(20);
        }


        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = '';
        $url_canonical = $request->url();
        foreach($category_by_id as $key => $val){
        // seo
        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = $val->category_name;
        $url_canonical = $request->url();
        //
        }
         $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();
        return view('pages.category.show_category')->with('category',$cate_product)->with('colors',$colors)->with('sizes',$sizes)->with('category_by_id',$category_by_id)->with('category_name',$category_name)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('min_price',$min_price)->with('max_price',$max_price)->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range);
    }
    public function product_new(Request $request){

        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $new =  DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id',19)->orderBy('tbl_product.product_id', 'desc')->paginate(12);
        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = '';
        $url_canonical = $request->url();
        foreach($new as $key => $val){
        // seo
        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = $val->category_name;
        $url_canonical = $request->url();
        //
        }
        return view('pages.product.product_new')->with('category',$cate_product)->with('colors',$colors)->with('sizes',$sizes)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('new',$new);
    }
    
}
