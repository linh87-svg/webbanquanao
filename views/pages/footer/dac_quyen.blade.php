<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ĐĂNG NHẬP</title>
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
<hr>
        <div style="margin-left:10%;margin-bottom: 50px;">
            <p style="color:red;font-size: 16px;">ĐẶC QUYỀN THÀNH VIÊN</p>
            <p style="font-style:italic;font-size: 12px;"><i class="fa fa-calendar" aria-hidden="true"></i> Đăng ngày 15-10-2020</p>
            <p><b>1.Đặc quyền ưu đãi tích lũy và sử dụng Điểm:</b></p>
            <p>- Đối với lần đầu tiên mua hàng tại May Boutique, bạn sẽ được lập mã khách hàng mới và được tặng ngay lập tức <span style="font-weight: bold;">100.000 Điểm</span> vào ví. Sau khi tiếp tục mua hàng và tích lũy hóa đơn mua sắm đủ <span style="font-weight: bold;">1.000.000VNĐ</span>, số điểm đã tích lũy sẽ có thể bắt đầu được sử dụng để giảm trực tiếp vào đơn hàng mỗi lần mua sắm.</p>
            <p><span style="font-weight: bold;font-style: italic;">- Đối với May Member (KH đang có tổng tích lũy hóa đơn dưới 5 triệu đồng):</span> Với mỗi hóa đơn mua sắm phát sinh tại May Boutique, số Điểm tích thêm sẽ tính bằng <span style="font-weight: bold;">3% giá trị đơn hàng</span> sau giảm giá. </p>
            <p style="margin-left:40px">Mỗi lần mua hàng, khách hàng May Member sẽ được dùng Điểm để giảm giá không quá <span style="font-weight: bold;">5% giá trị đơn hàng.</span></p>
            <p><span style="font-weight: bold;font-style: italic;">- Đối với Vip Member (KH đang có tổng tích lũy hóa đơn từ 5 triệu đồng trở lên):</span> Với mỗi hóa đơn mua sắm của khách hàng VIP Member phát sinh tại May Boutique, số Điểm tích thêm sẽ tính bằng <span style="font-weight: bold;">6% giá trị đơn hàng.</span> </p>
            <p style="margin-left:40px">Mỗi lần mua hàng, khách hàng VIP Member sẽ được dùng Điểm để giảm giá không quá <span style="font-weight: bold;">10% giá trị đơn hàng.</span></p>
            <p><span style="font-weight: bold;font-style: italic;">- Đối với VVip Member (KH đang có tổng tích lũy hóa đơn từ 20tr đồng trở lên):</span> Với mỗi hóa đơn mua sắm của khách hàng VIP Member phát sinh tại May Boutique, số Điểm tích thêm sẽ tính bằng <span style="font-weight: bold;">10% giá trị đơn hàng sau giảm giá.</span> </p>
            <p style="margin-left:40px">Mỗi lần mua hàng, khách hàng VIP Member sẽ được dùng Điểm để giảm giá không quá <span style="font-weight: bold;">15% giá trị đơn hàng.</span></p>
            <p><span style="font-weight: bold;font-style: italic;">Lưu ý:</span> Tổng số tiền tích lũy được coi là cột mốc nâng hạng khách hàng, Điểm tích lũy được dùng để giảm trừ trực tiếp vào hóa đơn mua sắm (quy đổi 1 điểm = 1 VNĐ). Việc sử dụng Điểm tích lũy để mua sắm sẽ không ảnh hưởng đến tổng số tiền doanh số đã tích lũy.</p>
             <p><b>1.Đặc quyền sinh nhật :</b></p>
             <p><span style="font-weight: bold;font-style: italic;">- Đối với May Member:</span> Giảm ngay 20% khi mua hàng trong ngày sinh nhật (áp dụng tối đa với 03 sản phẩm)</p>
             <p><span style="font-weight: bold;font-style: italic;">- Đối với VIP Member:</span> Giảm ngay 25% khi mua hàng trong ngày sinh nhật (áp dụng tối đa với 03 sản phẩm)</p>
             <p><span style="font-weight: bold;font-style: italic;">Lưu ý:</span> Chính sách ưu đãi sinh nhật chỉ áp dụng cho khách hàng sở hữu tài khoản tích điểm và chỉ áp dụng cho 01 lần mua hàng. Khách hàng vui lòng mang theo giấy tờ tùy thân có hình ảnh xác minh để được hưởng ưu đãi sinh nhật.</p>
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