 @extends('welcome')
 @section('content')
 <div class="row" style="margin-bottom: 20px;">
    <div class="col-md-3">
       <label for="amount">Sắp xếp theo</label>
       <form>
           @csrf
           <select name="sort" id="sort" class="form-control">
               <option value="{{Request::url()}}?sort_by=none">---Lọc---</option>
               <option value="{{Request::url()}}?sort_by=tang_dan">Giá tăng dần</option>
               <option value="{{Request::url()}}?sort_by=giam_dan">Giá giảm dần</option>
               <option value="{{Request::url()}}?sort_by=kytu_az">A -> Z</option>
               <option value="{{Request::url()}}?sort_by=kytu_za">Z -> A</option>
           </select> 

       </form>
   </div>
   <div class="col-md-9" style="display:flex;">
       <label for="amount">Lọc theo giá :</label>
       <form style="margin-left:30px;margin-top: 5px;">
        <div id="slider-range"></div>
        <input type="text" id="amount_start" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        <input type="text" id="amount_end" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        <input type="hidden" name="start_price" id="start_price">
        <input type="hidden" name="end_price" id="end_price">
        <input style="float:right;width: 50px;margin-left: 20px;height: 30px;font-size: 14px;padding: 0;margin-top: 10px;" type="submit" name="filter_price" value="Lọc" class="btn btn-sm btn-default">
    </form>
    
</div>
 </div>
 <ul class="product_list">  
      @foreach($size_by_id as $key => $product)
    <li>
        <form>
            @csrf
            <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
            <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{number_format($product->product_price).' '.'₫'}}" class="cart_product_price_{{$product->product_id}}">
        <button data-toggle="modal" data-target="#xemnhanh" data-id_product = "{{$product->product_id}}" name="xemnhanh" class="xemnhanh">
        <img id="wishlist_productimage{{$product->product_id}}" src="{{URL::to('public/upload/product/'.$product->product_images)}}" alt="" />
        </button>
        <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('/chi-tiet-sp/'.$product->product_id)}}">
        <p>{{$product->product_name}}</p>  
        <p>{{number_format($product->product_price).' '.'₫'}}</p>
    <div class="list-icon">
        
        <a style="margin-left: 10px;" href="{{URL::to('/chi-tiet-sp/'.$product->product_id)}}"><i class="fa fa-shopping-cart"></i></a>
        <button class="button_wishlist" style="float: right;margin-right: 10px;background-color: white;" id= "{{$product->product_id}}" onclick="add_wishlist(this.id);"><a ><i class="fa fa-heart"></i></a></button>

    </div>
        </a>
    </form>
    </li>
      @endforeach 
</ul>

<ul class="pagination pagination-sm m-t-none m-b-none">
  {!!$size_by_id->links()!!}
</ul>
@endsection