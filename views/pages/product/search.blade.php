 @extends('welcome')
 @section('content')
    <?php 
            $message = Session::get('message');
                if($message){
                    echo'<span class="text-alert" style="margin-left:20px">', $message,'</span>';
                     Session::put('message', null);
                }
        ?>
  @if(isset($search_product) && $search_product->count() > 0)
    <ul class="product_list">  
        @foreach($search_product as $key => $product)
            @if($product->category_id != 19)
                <li>
                    <form>
                        @csrf
                        <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                        <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{number_format($product->product_price).' '.'₫'}}" class="cart_product_price_{{$product->product_id}}">
                        <button data-toggle="modal" data-target="#xemnhanh" data-id_product="{{$product->product_id}}" name="xemnhanh" class="xemnhanh">
                            <img id="wishlist_productimage{{$product->product_id}}" src="{{URL::to('public/upload/product/'.$product->product_images)}}" />
                        </button>
                        <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('/chi-tiet-sp/'.$product->product_id)}}">
                            <p>{{$product->product_name}}</p>  
                            <p>{{number_format($product->product_price).' '.'₫'}}</p>
                            <div class="list-icon">
                                <a style="margin-left: 10px;" href="{{URL::to('/chi-tiet-sp/'.$product->product_id)}}">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                                <button class="button_wishlist" style="float: right;margin-right: 10px;background-color: white;" id="{{$product->product_id}}" onclick="add_wishlist(this.id);">
                                    <a><i class="fa fa-heart"></i></a>
                                </button>
                            </div>
                        </a>
                    </form>
                </li>
            @endif
        @endforeach 
    </ul>
@else
    <h2 style="margin-left: 450px;">Không tìm thấy sản phẩm nào phù hợp.</h2>
@endif

 <ul class="pagination pagination-sm m-t-none m-b-none">
      {!!$search_product->links()!!}
 </ul>
 @endsection