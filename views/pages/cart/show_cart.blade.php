 @extends('welcome')
 @section('content')


	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><i class="fa fa-home" aria-hidden="true"></i><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li style="color:#888888;" class="active">Giỏ hàng</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<?php
				$content = Cart::content();
				 ?>
					<tbody>
					  @foreach($content as $v_content)
					  <div class="khung">
					  	<div class="anh">
					  		<img src="{{URL::to('public/upload/product/'.$v_content->options->image)}}" alt="" />
					  	</div>
					  	<div class="noidung">
					  		<h4>{{$v_content->name}}</h4>
					  		<p>Giá : {{number_format($v_content->price,0,',','.').' '.'₫'}}</p>
					  		<p>Màu : {{$v_content->options->color}}</p>
					      	<p>Size : {{$v_content->options->size}}</p>
					  	<div class="cart_quantity_button">
					        <form action="{{URL::to('/update-qty')}}" method="POST">
					          {{csrf_field()}}
					          Số lượng : <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
					          <input type="hidden" name="rowId_cart" value="{{$v_content->rowId}}" class="form-control">
					          <button name="update_qty"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					        </form>
					      </div>
					      <button class="cart_delete"><a href="{{URL::to('/delete-cart/'.$v_content->rowId)}}">Xóa</a></button>
					  	</div>
					  </div>
					    <tr><td colspan="8"><hr></td></tr>
					  @endforeach
					</tbody>
					<button class="delete_all"><a href="{{URL::to('/delete-all')}}">Xóa tất cả</a></button>
					<h3><b>Tổng cộng : {{Cart::priceTotal(0,',','.').' '.'₫'}}</b></h3>
					 <?php
                                    $user_id = Session::get('user_id');
                                    $cart = Session::get('cart');
                                    if($user_id != NULL){
                                   	if($cart){
                               ?>
                               <a class="check_out" href="{{URL::to('/payment')}}">TIẾN HÀNH THANH TOÁN</a>
                                <?php
                           			}else{
                           				echo '<a class="check_out" href="javascript:void(0);" onclick="alert(\'Giỏ hàng của bạn đang trống, vui lòng thêm sản phẩm trước khi thanh toán.\')">TIẾN HÀNH THANH TOÁN</a>';
                           	   ?>
                           	   
                           	   
                           	<?php 
                           }

                            	}else{
                                 ?>
                               <a class="check_out" href="{{URL::to('/login-checkout')}}">TIẾN HÀNH THANH TOÁN</a>
                            <?php } ?>
				
			</div>
		</div>
	</section> 
 @endsection