<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Gallery;
use App\Product;
use App\Comment;
use App\Rating;
use Auth;
use File;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Exports\ExcelExport;
// use App\Imports\ExcelImport;
use Excel;
class ProductController extends Controller
{


    public function export_csv(){
        return Excel::download(new ExcelExport, 'product.xlsx');
    }
    //Admin
    public function AuthLogin(){
      $admin_id = Auth::id();
      if($admin_id){
       return Redirect::to('dashboard');
      }else{
       return Redirect::to('login-auth')->send();
      }
    }

    public function add_product(){
        $this->AuthLogin();
    $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
    $color_product = DB::table('tbl_color')->orderBy('color_id', 'asc')->get(); // Lấy danh sách màu
    $size_product = DB::table('tbl_size')->orderBy('size_id', 'asc')->get(); // Lấy danh sách kích thước

   
     return view('admin.add_product')->with('cate_product', $cate_product)->with('color_product', $color_product)->with('size_product', $size_product);
    }
    public function all_product(){
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->orderBy('tbl_product.product_id', 'desc')->paginate(30);
        $manager_product = view ('admin.all_product')->with('all_product', $all_product);

        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function save_product(Request $request){
        
       $data = $request->validate([
        'product_name' => 'required|string|max:255',
        'product_quantities' => 'required|integer|min:1',
        'product_price' => 'required|numeric|gt:price_cost|min:0',
        'price_cost' => 'required|numeric|min:0',
        'product_desc' => 'required|string',
        'product_images' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',

       // 'product_category' => 'required|exists:tbl_category_product,category_id',
       // chưa validate 3 select ???///
        ], 
    [
        'product_name.required' => 'Tên sản phẩm không được để trống',
        'product_quantities.required' => 'Số lượng sản phẩm không được để trống',
        'product_quantities.integer' => 'Số lượng sản phẩm phải là số nguyên',
        'product_price.required' => 'Giá bán sản phẩm không được để trống',
        'product_price.numeric' => 'Giá bán phải là số',
        'product_price.gt' => 'Giá bán phải lớn hơn giá gốc!',
        'price_cost.required' => 'Giá gốc sản phẩm không được để trống',
        'price_cost.numeric' => 'Giá gốc phải là số',
        'product_desc.required' => 'Mô tả sản phẩm không được để trống',
        'product_images.required' => 'Hình ảnh sản phẩm không được để trống',
        'product_images.image' => 'File tải lên phải là hình ảnh',
        'product_images.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, svg',

        // 'product_category.required' => 'Vui lòng chọn danh mục sản phẩm!',
        // 'product_category.exists' => 'Danh mục sản phẩm không hợp lệ!',
        
    ]);
        $product_price = floatval(str_replace(',', '', $request->product_price));
        $price_cost = floatval(str_replace(',', '', $request->price_cost));

        $data['product_name'] = $request->product_name;
        $data['product_quantities'] = $request->product_quantities;
        $data['product_price'] = $product_price;
        $data['price_cost'] = $price_cost;
        $data['product_desc'] = $request->product_desc;
        $data['category_id'] = $request->product_category;
        $data['product_status'] = 1;
        $data['product_sold'] = 0;

    // Xử lý upload ảnh sản phẩm
    $get_images = $request->file('product_images');

    $path = 'public/upload/product/';
    $path_gallery = 'public/upload/gallery/';
    if ($get_images) {
        $get_name_images = $get_images->getClientOriginalName();
        $name_image = current(explode('.', $get_name_images));
        $new_image = $name_image . rand(0, 99) . '.' . $get_images->getClientOriginalExtension();
        $get_images->move($path, $new_image);
        File::copy($path.$new_image,$path_gallery.$new_image);
        $data['product_images'] = $new_image;
    } else {
        $data['product_images'] = '';
    }
   // Thêm sản phẩm và lấy ID
        $product_id = DB::table('tbl_product')->insertGetId($data);

        // Thêm màu sắc sản phẩm
        if (!empty($request->product_color)) {
            //array_map() là một hàm trong PHP dùng để áp dụng một hàm callback lên từng phần tử của một hoặc nhiều mảng và trả về một mảng mới với các giá trị đã được xử lý.
            $product_colors = array_map(fn($color_id) => [
                'product_id' => $product_id,
                'color_id' => intval($color_id),
                'created_at' => now(),
                'updated_at' => now(),
            ], $request->product_color);
            DB::table('tbl_product_color')->insert($product_colors);
        }

        // Thêm kích thước sản phẩm
        if (!empty($request->product_size)) {
            $product_sizes = array_map(fn($size_id) => [
                'product_id' => $product_id,
                'size_id' => intval($size_id),
                'created_at' => now(),
                'updated_at' => now(),
            ], $request->product_size);
            DB::table('tbl_product_size')->insert($product_sizes);
        }

    $gallery = new Gallery();
    $gallery->gallery_image = $new_image;
    $gallery->gallery_name = $new_image;
    $gallery->product_id = $product_id ;
    $gallery->save();
      Toastr::success('Thêm sản phẩm thành công!','Thông báo');
    return Redirect::to('/add-product');
    }

    public function edit_product($product_id){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $color_product = DB::table('tbl_color')->orderBy('color_id', 'desc')->get();
        $size_product = DB::table('tbl_size')->orderBy('size_id', 'desc')->get();

        // Lấy thông tin sản phẩm
        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->first();

        // Lấy danh sách màu sắc đã chọn
        $selected_colors = DB::table('tbl_product_color')
            ->where('product_id', $product_id)
            ->pluck('color_id') // Lấy danh sách ID màu sắc
            ->toArray(); // Chuyển thành mảng

        // Lấy danh sách kích thước đã chọn
        $selected_sizes = DB::table('tbl_product_size')
            ->where('product_id', $product_id)
            ->pluck('size_id') // Lấy danh sách ID kích thước
            ->toArray(); // Chuyển thành mảng

        return view('admin.edit_product', compact('edit_product', 'cate_product', 'color_product', 'size_product', 'selected_colors', 'selected_sizes'));
    }

    public function update_product(Request $request, $product_id){
        $this->AuthLogin();
        $data = $request->validate([
        'product_name' => 'required|string|max:255',
        'product_quantities' => 'required|integer|min:1',
        'product_price' => 'required|numeric|gt:price_cost|min:0',
        'price_cost' => 'required|numeric|min:0',
        'product_desc' => 'required|string',
        
        
        ], 
    [
        'product_name.required' => 'Tên sản phẩm không được để trống',
        'product_quantities.required' => 'Số lượng sản phẩm không được để trống',
        'product_quantities.integer' => 'Số lượng sản phẩm phải là số nguyên',
        'product_price.required' => 'Giá bán sản phẩm không được để trống',
        'product_price.numeric' => 'Giá bán phải là số',
        'product_price.gt' => 'Giá bán phải lớn hơn giá gốc!',
        'price_cost.required' => 'Giá gốc sản phẩm không được để trống',
        'price_cost.numeric' => 'Giá gốc phải là số',
        'product_desc.required' => 'Mô tả sản phẩm không được để trống',
        
        
        
    ]);

        $product_price = floatval(str_replace(',', '', $request->product_price));
        $price_cost = floatval(str_replace(',', '', $request->price_cost));

        $data['product_name'] = $request->product_name;
        $data['product_quantities'] = $request->product_quantities;
        $data['product_price'] = $product_price;
        $data['price_cost'] = $price_cost;
        $data['product_desc'] = $request->product_desc;
        $data['category_id'] = $request->product_category;
        $data['product_status'] = $request->product_status;
        $data['product_sold'] = 0;

        // Cập nhật ảnh nếu có ảnh mới
        $get_images = $request->file('product_images');

        if ($get_images) {
            $get_name_images = $get_images->getClientOriginalName();
            $name_image = current(explode('.', $get_name_images));
            $new_image = $name_image . rand(0, 99) . '.' . $get_images->getClientOriginalExtension();
            $get_images->move('public/upload/product', $new_image);
            $data['product_images'] = $new_image;
        }

        // Cập nhật thông tin sản phẩm
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);

        // Cập nhật màu sắc sản phẩm
        DB::table('tbl_product_color')->where('product_id', $product_id)->delete(); // Xóa màu cũ
        if (!empty($request->product_color)) {
            $product_colors = array_map(fn($color_id) => [
                'product_id' => $product_id,
                'color_id' => intval($color_id),
                'created_at' => now(),
                'updated_at' => now(),
            ], $request->product_color);
            DB::table('tbl_product_color')->insert($product_colors);
        }

        // Cập nhật kích thước sản phẩm
        DB::table('tbl_product_size')->where('product_id', $product_id)->delete(); // Xóa size cũ
        if (!empty($request->product_size)) {
            $product_sizes = array_map(fn($size_id) => [
                'product_id' => $product_id,
                'size_id' => intval($size_id),
                'created_at' => now(),
                'updated_at' => now(),
            ], $request->product_size);
            DB::table('tbl_product_size')->insert($product_sizes);
        }

         Toastr::success('Cập nhật sản phẩm thành công!','Thông báo');
        return Redirect::to('/all-product');
    }

    public function delete_product($product_id){
           $this->AuthLogin();
        // Xóa màu sắc liên quan
        DB::table('tbl_product_color')->where('product_id', $product_id)->delete();
        
        // Xóa kích thước liên quan
        DB::table('tbl_product_size')->where('product_id', $product_id)->delete();

        // Xóa sản phẩm
        DB::table('tbl_product')->where('product_id', $product_id)->delete();

         Toastr::success('Xóa sản phẩm thành công thành công!','Thông báo');
        return Redirect::to('/all-product');
    }
    public function unactive_product($product_id){
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' =>0]);
         Toastr::success('Đã ẩn sản phẩm!','Thông báo');
        return Redirect::to('all_product');
    }
     public function active_product($product_id){
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' =>1]);
         Toastr::success('Kích hoạt sản phẩm thành công!','Thông báo');
        return Redirect::to('all_product');
    }

    

    //endadmin


    //Client
    public function details_product(Request $request, $product_id){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','asc')->get();
        $colors = DB::table('tbl_color')->orderBy('color_id','asc')->get();
        $sizes = DB::table('tbl_size')->orderBy('size_id','asc')->get();
        $product_color = DB::table('tbl_product_color')
            ->join('tbl_product', 'tbl_product.product_id', '=', 'tbl_product_color.product_id')
            ->join('tbl_color', 'tbl_color.color_id', '=', 'tbl_product_color.color_id')
            ->where('tbl_product.product_id', $product_id)
            ->get();
        $product_size = DB::table('tbl_product_size')
            ->join('tbl_product', 'tbl_product.product_id', '=', 'tbl_product_size.product_id')
            ->join('tbl_size', 'tbl_size.size_id', '=', 'tbl_product_size.size_id')
            ->where('tbl_product.product_id', $product_id)
            ->get();
         $details_product = DB::table('tbl_product')
         ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
         ->where('tbl_product.product_id',$product_id)->get();


        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = '';
        $url_canonical = $request->url();
        $image_og = '';

         foreach($details_product as $key => $val) {
                $category_id = $val->category_id;
                $product_id = $val->product_id;
                $product_cate = $val->category_name;
                $meta_desc = $val->product_desc;
                $meta_keywords = '';
                $meta_title = $val->product_name;
                $url_canonical = $request->url();
                $image_og = url('public/upload/product/' . $val->product_images);
         }
         //gallery
         $gallery = Gallery::where('product_id',$product_id)->get();
             //deteil_order update_views
                $product = Product::where('product_id', $product_id)->first();
                $product->product_views = $product->product_views +1;
                $product->save();
              
         //sp liên quan
          $related_product = DB::table('tbl_product')
         ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
         ->where('tbl_category_product.category_id',$category_id)
         ->whereNotIn('tbl_product.product_id',[$product_id])
         ->get();
          $rating = Rating::where('product_id',$product_id)->avg('rating');
          $rating = round($rating);
        return view('pages.product.show_details')->with('category',$cate_product)->with('colors',$colors)->with('product_details',$details_product)->with('product_color',$product_color)->with('product_size',$product_size)->with('related_product',$related_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('image_og',$image_og)->with('gallery',$gallery)->with('product_cate',$product_cate)->with('category_id',$category_id)->with('rating',$rating)->with('sizes',$sizes);
    }
    public function quickview(Request $request){
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $output['product_name'] = $product->product_name;
        $output['product_price'] = number_format($product->product_price,0,',','.').'₫';
        $output['product_image'] = '<p><img width="100%" src="public/upload/product/'.$product->product_images.'"></p>';
        $output['product_quantities'] = $product->product_quantities;
        $output['product_desc'] = $product->product_desc;
        echo json_encode($output);
    }
    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id',$product_id)->where('comment_status',0)->where('comment_parent_comment','=',0)->get();
         $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->orderBy('comment_id', 'DESC')->get(); 
        $output = '';
        foreach($comment as $key => $com){
            $output .= '
                <div class="row style_comment">
                
                    <div class="col-md-1">
                        <img width="100%" src="'.url('/public/frontend/images/avarta_icon.png').'" class="img img-responsive img-thumbnail">
                    </div>
                    <div class="col-md-9" style="font-size:11px">
                        <p><b>'.$com->comment_name.'</b></p>
                        <p>'.$com->comment_date.'</p>
                        <p>'.$com->comment.'</p>
                    </div>
                
                </div>
                <p></p>
                ';
           foreach($comment_rep as $key => $reply_comment){
                if($reply_comment->comment_parent_comment==$com->comment_id){
               $output .= ' <div class="row style_comment" style="margin: 5px 30px;background-color:#EEEEEE;width:80%" >
                
                    <div class="col-md-1">
                        <img width="100%" src="'.url('/public/frontend/images/ava_icon.png').'" class="img img-responsive img-thumbnail">
                    </div>
                    <div class="col-md-9" style="font-size:11px">
                        <p><b>ShopMay</b></p>
                        <p>'.$reply_comment->comment.'</p>
                    </div>
                </div>
                <p></p>';
                }
            }
        
        } 
        echo $output;
    }
    public function send_comment(Request $request){
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment = $comment_content;
        $comment->comment_name = $comment_name;
        $comment->comment_product_id = $product_id;
        $comment->comment_status = 0;
        $comment->comment_parent_comment = 0;
        $comment->save();
    }
     public function list_comment(){
        $comment = Comment::with('product')->where('comment_parent_comment','=',0)->orderBy('comment_id', 'DESC')->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->orderBy('comment_id', 'DESC')->get(); 
        return view('admin.comment.list_comment')->with(compact('comment','comment_rep'));
    }
    public function allow_comment(Request $request){
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }
    public function reply_comment(Request $request){
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 0;
        $comment->comment_name = 'ShopMay';
        $comment->save();
    }
    public function insert_rating(Request $request){
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo 'done';
    }

}
           