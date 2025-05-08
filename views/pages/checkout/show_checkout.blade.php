<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Thông tin giao hàng</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">      
    <link rel="icon" type="image/x-icon" href="{{asset('public/frontend/images/logomay.png')}}" sizes="48x48">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>

<header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                   <div class="row">                   
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> 024 22683232</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> mayboutique@gmail.com</a></li>
                        <div class="social-icons">
                            <ul class="nav navbar-nav">
                                <li><a href="https://www.facebook.com/mayboutique.official"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/mayboutique.official/"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                            <ul class="shop-menu pull-right ">
                                <?php
                                use App\Users;
                                    $user_id = Session::get('user_id');
                                    $user = Users::find($user_id);
                                    if($user_id != NULL){
                               ?>
                                <li><a href="{{URL::to('/user-info')}}"><i class="fa fa-user"></i> <?php echo e($user->user_name); ?></a></li>
                                <?php
                            }else{
                                 ?>
                               <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-user"></i> Tài khoản</a></li>
                            <?php } ?>
                                <li><a href="{{URL::to('/product-wishlist')}}"><i class="fa fa-star"></i> Yêu thích</a></li>
                                <div id="show-cart"></div>
                                <?php
                                    $user_id = Session::get('user_id');
                                    if($user_id != NULL){
                               ?>
                                <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
                                
                                <?php

                            }else{
                                 ?>
                               <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                            <?php } ?>
                            </ul>                      
                            </ul>
                        </div>
                    </div>
                </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div  class="logomay">
                <a href="{{URL::to('/')}}"><img src="{{asset('public/frontend/images/logomay.png')}}" alt="" /></a> 
            </div>       
            <div class="mainmenu">
                 <ul class="nav navbar-nav collapse navbar-collapse">
                    <li><a href="{{URL::to('/trang-chu')}}" class="active">TRANG CHỦ</a></li>
                    <li class="dropdown"><a href="">SẢN PHẨM<i class="fa fa-angle-down"></i></a>
                        <ul role="menu" class="sub-menu">
                            @foreach($category as $key => $cate)
                            @if($cate->category_parent != 0 && $cate->category_id != 19)
                                <li><a href="{{URL::to('/danh-muc-sp/'.$cate->category_id)}}">{{$cate->category_name}}</a></li> 
                            @endif
                            @endforeach
                            
                        </ul>
                     </li>  
                    <li><a href="{{URL::to('/product-new')}}">HÀNG MỚI VỀ</a></li>
                    <li><a href="{{URL::to('/lien-he')}}">LIÊN HỆ</a></li>
                </ul>
            </div>
            <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="POST">
                    {{  csrf_field() }}
            <div class="search_box pull-right">
                  <input type="text" name="key"  placeholder="Tìm kiếm" required>
                <button type="submit"><img src="{{asset('public/frontend/images/icon.png')}}" alt=""/></button> 
                 
            </div>
           
             </form>   
        </div><!--/header-middle-->
    </header><!--/header-->

  	<div class="container">

<div class="breadcrumbs">
                <ol class="breadcrumb">
                  <li><i class="fa fa-home" aria-hidden="true"></i><a href="{{URL::to('/')}}">Trang chủ</a></li>
                  <li style="color:#888888;" class="active">Thông tin giao hàng</li>
                </ol>
            </div>
             <?php 
                $message = Session::get('message');
                if($message){
                    echo'<span class="text-alert">', $message,'</span>';
                    Session::put('message', null);
            }
            ?>
		<div class="checkout_info">
           
			<div class="form-info">
				<h3>Thông tin giao hàng</h3>
				
					<form action="{{URL::to('/save-checkout-user')}}" method="POST">
						{{ csrf_field() }}
						
					    <input style="width: 100%;" type="text" name="shipping_name" placeholder="Họ và tên" required>
						<br>
						<input style="width: 69%;" type="text" name="shipping_email" placeholder="Email" required>
						<input style="width: 30%;" type="text" name="shipping_phone" placeholder="Số điện thoại" required>
                        <br>
						<input style="width: 100%;" type="text" name="shipping_address" placeholder="Địa chỉ" required>
						<br>
						<textarea name="shipping_note" placeholder="Ghi chú" rows="5" required></textarea>
						<br>
						<button name="send_order">Gửi</button>
					</form>
			</div>
    <div class="hinhthucck">
        <div class="total_area">
             <div class="table-responsive cart_info">
                <?php
                $content = Cart::content();
                 ?>
                <table class="table table-condensed">
                    <tbody>
                      @foreach($content as $v_content)
                      <tr>
                        <td class="cart_product">
                          <a href=""><img src="{{URL::to('public/upload/product/'.$v_content->options->image)}}" width="70" alt="" /></a>
                        </td>
                        <td class="cart_description">
                          {{$v_content->name}}
                        </td>
                        <td class="cart_description">{{$v_content->options->color}}</td>
                        <td class="cart_description">{{$v_content->options->size}}</td>
                        <td class="cart_description">x{{$v_content->qty}}</td>
                          <td class="cart_description">
                          <p>
                            <?php
                            $subtotal = $v_content->price * $v_content->qty;
                            echo number_format($subtotal,0,',','.').' '.'₫';
                            ?>
                          </p>
                        </td>
                        </td> 
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                <ul>
                    <li>Tổng tiền <span>{{Cart::priceTotal(0,',','.').' '.'₫'}}</span></li>
                    <li>
                    @if(Session::get('coupon'))
                    @foreach(Session::get('coupon') as $key => $cou)
                        @if($cou['coupon_condition'] == 1)
                            @php
                                // Chuyển đổi tổng tiền từ chuỗi sang số
                                $total = (float) str_replace('.', '', Cart::priceTotal(0, ',', '.'));
                                $total_coupon = ($total * $cou['coupon_number']) / 100;
                            @endphp
                            <p>Voucher giảm giá: <span> - {{ number_format($total_coupon, 0, ',', '.') }} ₫</span></p>
                        @else
                            @php
                                $total = (float) str_replace('.', '', Cart::priceTotal(0, ',', '.'));
                                $total_coupon = $total - $cou['coupon_number'];
                            @endphp
                            <p>Voucher giảm giá: <span> - {{ number_format($cou['coupon_number'], 0, ',', '.') }} ₫</span></p>
                         @endif
                    @endforeach
                        @else
                            <p>Voucher giảm giá: <span> 0 ₫</span></p>
                        @endif
                    </li>
                </ul>
                <form action="{{URL::to('/check-coupon')}}" method="POST">
                    {{ csrf_field() }}
                    <input class="magiamgia" type="text" name="coupon" placeholder="Nhập mã giảm giá">
                    <input class="apdung" type="submit" name="check_coupon" value="Áp dụng">
                </form>
            </div>
            <form action="{{URL::to('/order-place')}}" method="POST">
                {{ csrf_field() }}
                <div class="payment-options">
                <!-- <p>Hình thức thanh toán</p>
                    <input name="payment_options" value="1" type="radio" required> Thẻ ATM<br>
                    <input name="payment_options" value="2" type="radio" required> Thanh toán khi nhận hàng<br> -->
                  
                        @if(Session::get('coupon'))
                            @foreach(Session::get('coupon') as $key => $cou)
                                @if($cou['coupon_condition'] == 1)
                                    @php
                                        $total = (float) str_replace('.', '', Cart::priceTotal(0, ',', '.'));
                                        $total_coupon = ($total * $cou['coupon_number']) / 100;
                                    @endphp
                                    <h4><b>Tổng thanh toán : <span>{{ number_format($total - $total_coupon, 0, ',', '.') }} ₫</span></b></h4>
                                @else
                                    @php
                                         $total = (float) str_replace('.', '', Cart::priceTotal(0, ',', '.'));
                                        $total_coupon = $total - $cou['coupon_number'];
                                    @endphp
                                    <h4><b>Tổng thanh toán :<span>{{ number_format($total_coupon, 0, ',', '.') }} ₫</span></b></h4>
                            @endif
                            @endforeach
                            @else
                            <h4><b>Tổng thanh toán :<span>{{ Cart::priceTotal(0, ',', '.') }} ₫</span></b></h4>
                        @endif
              
                    <!-- <button name="send_order_place">ĐẶT HÀNG</button> -->
                </div>
            </form>
        </div>
    </div>
					
			
	</div>
			
		</div>
	

 <footer id="footer"><!--Footer-->
        <div class="gioithieu">
            <h4><b>GIỚI THIỆU</b></h4>
            <p>CÔNG TY CỔ PHẦN PHÁT TRIỂN THƯƠNG MẠI DỊCH VỤ CAMELLIA MST: 5300812562 - Số ĐKKD: 5300812562 cấp ngày 20/02/2023 bởi Sở KH và ĐT Tỉnh Lào Cai</p>
            <p><i class="fa fa-phone"></i> 024 22683232</p>
            <p><i class="fa fa-envelope"></i> mayboutique@gmail.com</p>
            <p><i class="fa fa-clock-o" aria-hidden="true"></i> Giờ mở cửa : 8H30 - 22H30 </p>
            <p>Tất cả các ngày trong tuần</p>
            <img src="{{asset('public/frontend/images/bocongthuong.png')}}">
        </div>
        <div class="hotro">
            <h4><b>HỖ TRỢ KHÁCH HÀNG</b></h4>
            <p><a href="{{URL::to('/dac-quyen')}}">Đặc quyền thành viên</a></p>
            <p><a href="{{URL::to('/den-bu')}}">Chính sách đền bù</a></p>
            <p><a href="{{URL::to('/doi-tra')}}">Chính sách đổi/trả</a></p>
            <p><a href="{{URL::to('/bao-mat')}}">Chính sách bảo mật</a></p>
            <p><a href="{{URL::to('/giao-hang')}}">Chính sách giao hàng và kiểm hàng</a></p>
            <p>THEO DÕI CHÚNG TÔI</p>
            <div style="display: flex;">
                <a href="https://www.facebook.com/mayboutique.official"><img src="{{asset('public/frontend/images/logofb.png')}}" ></a>
                <a style="margin-left:20px" href="https://www.instagram.com/mayboutique.official/"><img src="{{asset('public/frontend/images/logoinsta.png')}}" ></a>
                <a style="margin-left:20px" href="https://www.tiktok.com/@mayboutique"><img src="{{asset('public/frontend/images/logotiktok.png')}}" ></a>
            </div>
        </div>
        <div class="coso">
            <h4><b>CƠ SỞ CỬA HÀNG</b></h4>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 102 - B6 Phạm Ngọc Thạch</p>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 245 Chùa Bộc</p>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 65 Hồ Tùng Mậu</p>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 179 Cầu Giấy </p>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 264 Ngọc Lâm</p>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 206 Nguyễn Trãi, Nam Từ Liêm</p>
        </div>
        
        <div style="width: 25%;margin-top: 20px;">
            <h4><b>FANPAGE </b></h4>
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v22.0&appId=936843198532406"></script>
            <div class="fb-page" data-href="https://www.facebook.com/mayboutique.official" data-tabs="timeline" data-width="550" data-height="300px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/mayboutique.official" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/mayboutique.official">May Boutique</a></blockquote></div>
        </div>
        
        
    </footer><!--/Footer-->
  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
             show_cart();
        function show_cart(){
            $.ajax({
                url:'{{url('/count-cart')}}',
                method:"GET",
                success:function(data){
                    $('#show-cart').html(data);
                }
            });
        }

        });     
    </script>
</body>
</html>