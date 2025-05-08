		
 @extends('welcome')
 @section('content')
 @foreach($product_details as $key => $details)
<div class="product-details">
	<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="background: none;">
    <li class="breadcrumb-item"><i class="fa fa-home" aria-hidden="true"></i><a style="color:black;" href="{{URL::to('/')}}">  Trang chủ</a></li>
    <li class="breadcrumb-item"><a style="color:black;"  href="{{URL::to('/danh-muc-sp/'.$category_id)}}">{{$product_cate}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
  </ol>
</nav>
        <div class="row">
            <div class="col-sm-3">
            	<ul id="imageGallery" >
            		@foreach($gallery as $key => $gal)
					<li  data-thumb="{{asset('public/upload/gallery/'.$gal->gallery_image)}}" data-src="{{asset('public/upload/gallery/'.$gal->gallery_image)}}">
						<img width="100%" alt="{{$gal->gallery_image}}" src="{{asset('public/upload/gallery/'.$gal->gallery_image)}}" />
					</li>
					@endforeach
				</ul>
            </div>
                <div class="product-information">
                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                    <h2>{{$details->product_name}}</h2>
                    <p>Mã sản phẩm : {{$details->product_id}}</p>
                    <p>Số lượng : {{$details->product_quantities}} </p>
                     
                    	@if($details->product_quantities == 0)
                    		<p style="color:red"><b>Tình trạng:</b> Hết hàng </p>
                    	@else
                    		<p><b>Tình trạng:</b> Còn hàng </p>
                    	@endif

            <form action="{{URL::to('/save-cart')}}" method="POST" onsubmit="return validateQuantity()">
			    {{ csrf_field() }}

			    <span style="color:red;">{{number_format($details->product_price).' '.'₫'}}</span>

			    <p>Màu sắc :</p>
			    @foreach($product_color as $key => $pr_color)
			        <input type="radio" name="prcolor_hidden" value="{{$pr_color->color_name}}" required /> {{$pr_color->color_name}}
			    @endforeach

			    <p>Kích thước:</p>
			    <?php 
			        $sortedSizes = $product_size->sortBy('size_id');
			    ?>
			    @foreach($sortedSizes as $key => $pr_size)
			        <input type="radio" name="prsize_hidden" value="{{$pr_size->size_name}}" required /> {{$pr_size->size_name}}
			    @endforeach

			    <p>Số lượng : 
			        <input style="height: 30px; width: 40px;" id="soluong" name="soluong" type="number" min="1" value="1"  oninput="checkQuantity() " {{ $details->product_quantities == 0 ? 'disabled' : '' }} />
			    </p>

			    <input type="hidden" id="available_quantity" value="{{$details->product_quantities}}" />
			    <input name="productid_hidden" type="hidden" value="{{$details->product_id}}" />

			    <p id="quantity-warning" style="color: red; display: none;">Số lượng không đủ trong kho!</p>

			 
			        <button type="submit" {{ $details->product_quantities == 0 ? 'disabled' : '' }}>THÊM GIỎ HÀNG</button>
			  
			</form>

			<script>
			    function checkQuantity() {
			        var inputQuantity = parseInt(document.getElementById('soluong').value);
			        var availableQuantity = parseInt(document.getElementById('available_quantity').value);

			        if (inputQuantity > availableQuantity) {
			            document.getElementById('quantity-warning').style.display = 'block';
			        } else {
			            document.getElementById('quantity-warning').style.display = 'none';
			        }
			    }

			    function validateQuantity() {
			        var inputQuantity = parseInt(document.getElementById('soluong').value);
			        var availableQuantity = parseInt(document.getElementById('available_quantity').value);

			        if (inputQuantity > availableQuantity) {
			            return false;
			        }
			        return true;
			    }
			</script>
                <div class="note">
                	 <p><i class="fa fa-truck" aria-hidden="true"></i> &nbsp; GIAO HÀNG TOÀN QUỐC</p>
                	 <p><i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp;ĐỔI TRẢ SẢN PHẨM DỄ DÀNG(trong vòng 3 ngày)</p>
                	 <p><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;024 22683232</p>
                </div>
               
                </div>
            
        </div>

</div>
  

 		<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
								<li><a href="#tag" data-toggle="tab">Hướng dẫn bảo quản</a></li>
								<li ><a href="#reviews" data-toggle="tab">Chính sách đổi trả</a></li>
								<li ><a href="#danhgia" data-toggle="tab">Đánh giá</a></li>
							</ul>
						</div>
						<div class="tab-content ">
							<!-- chi tiết sp -->
							<div class="tab-pane fade active in" id="details" >
							<p style="margin-left:20px">{{$details->product_desc}}</p>	
							</div>
@endforeach
							<!-- hướng dẫn ảo quản -->
							<div class="tab-pane fade" id="tag" >
								<img src="{{URL::to('/public/frontend/images/hdbq.png')}}">
							</div>
							<!-- chính sách đổi trả -->
							<div class="tab-pane fade " id="reviews" >
								<h5><b>1.CHÍNH SÁCH ĐỔI/TRẢ</b></h5>
								<p><b>Đặc quyền đổi sản phẩm dành cho khách hàng của May Boutique.</b></p>
								<p><b>Khách hàng đến mua hàng tại May Boutique sẽ được đổi sản phẩm trong vòng 3 ngày kể từ ngày mua hàng.</b></p>
								<p><b>* Điều kiện đổi trả:</b></p>
								<p>- Sản phẩm không giảm giá.</p>
								<p>- Sản phẩm được đổi phải còn nguyên nhãn mác, chưa qua sử dụng, giặt ủi, không hư hỏng.</p>
								<p>- Khách hàng đến đổi hàng phải mang theo hóa đơn có ghi sản phẩm cần đổi trên đó.</p>
								<p>- Chương trình áp dụng cho khách mua hàng tại cửa hàng và online (với khách mua online, phí ship do khách tự thanh toán).</p>
								<p><b>* Lưu ý:</b></p>
								<p>- Áp dụng đổi sang sản phẩm khác bằng hoặc hơn giá và đổi duy nhất 1 lần với mỗi sản phẩm.</p>
								<h5><b>2.CHÍNH SÁCH GIAO HÀNG</b></h5>
								<p><b>MAY BOUTIQUE ÁP DỤNG GIAO HÀNG TRÊN TOÀN QUỐC</b></p>
								<p> PHÍ VẬN CHUYỂN TÍNH THEO BÁO GIÁ CỦA ĐƠN VỊ VẬN CHUYỂN</p>
								<p><b> Lưu ý:</b></p>
								<p>- Không được xem hàng trước khi thanh toán, shop sẽ hỗ trợ đổi hàng sau khi bạn nhận hàng.</p>
							</div>
							<div class="tab-pane fade " id="danhgia">
								<form style="margin-left:20px;">
									@csrf
									<input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$details->product_id}}">
									<div id="comment_show"></div>
								</form>
								<?php
                                	use App\Users;
                                    $user_id = Session::get('user_id');
                                    $user = Users::find($user_id);
                                    if($user_id != NULL){
                               		?>
								<form style="margin-left:20px">
									@csrf
									<p><b>Viết đánh giá của bạn</b></p>

									<ul class="list-inline rating" title="Average Rating">
										@for($count=1;$count<=5;$count++)
											@php
											if($count <= $rating){
												$color = 'color:#FFFF33';
											}else{
												$color = 'color:#DDDDDD';
											}
											@endphp

										<li title="Đánh giá sao"
										 id="{{$details->product_id}}-{{$count}}"
										 data-index="{{$count}}"
										 data-product-id="{{$details->product_id}}"
										 data-rating="{{$rating}}" class="star" 
										 style="font-size: 30px;cursor: pointer; {{$color}}" 
										 >&#9733;</li>
										 @endfor
									</ul>

									<input style="width: 50%;" class="form-control comment_name"  type="text" placeholder="Họ tên"><br>
									<textarea style="width: 50%; " rows="5" class="form-control comment_content"  name="comment"  placeholder="Nội dung"></textarea><br>
									
									<button style="margin-left: 45%;" type="button" class="btn btn-info send-comment">Gửi</button>
                                	 <?php } ?>
									<div id="notify_comment"></div>
								</form>
							</div>
							
						</div>
					</div><!--/category-tab-->
	<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">SẢN PHẨM LIÊN QUAN</h2>
    
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">	
                @foreach($related_product as $key => $related)
                    @if($key % 4 == 0 && $key != 0) <!-- Mở một item mới cho mỗi nhóm 5 sản phẩm -->
                        </div><div class="item">
                    @endif
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{URL::to('/public/upload/product/'.$related->product_images)}}" alt="" />
                                    <p style="margin-top:20px;font-size: 17px;font-weight: bold;">{{$related->product_name}}</p>
                                    <h3 style="font-weight: bold;">{{number_format($related->product_price).' '.'₫'}}</h3>
                                    <style type="text/css">
                                    	button{
                                    		height:35px;
                                    		margin-bottom: 20px;
                                    		margin-top: 20px;
                                    		background-color: black;
                                    		transition: all 0.3s ease;
                                    	}
                                    	button:hover{
                                    		transform: scale(1.1);
                                    	}
                                    </style>
                                    <button type="button" ><i style="color:white;" class="fa fa-shopping-cart"></i><a style="color:white;" href="{{URL::to('/chi-tiet-sp/'.$related->product_id)}}"> Thêm giỏ hàng</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>			
    </div>
</div>
@endsection