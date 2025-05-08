<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}">
    <meta name="robots" content="">
    <meta name="author" content="">
    <link rel="canonical" href="{{$url_canonical}}" />
    <meta property="og:site_name" content="{{$url_canonical}}" />
    <meta property="og:description" content="{{$meta_desc}}" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:url" content="{{$url_canonical}}" />
    <meta property="og:type" content="website" />
    <link rel="icon" type="image/x-icon" href="{{asset('public/frontend/images/logomay.png')}}" sizes="48x48">
    <title>{{$meta_title}}</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">  
    <link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet">  
    <link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

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
            <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="GET">
                    {{  csrf_field() }}
            <div class="search_box pull-right">
                  <input type="text" name="key"  placeholder="Tìm kiếm" required>
                <button type="submit"><img src="{{asset('public/frontend/images/icon.png')}}" alt=""/></button> 
                 
            </div>
           
             </form>   
        </div><!--/header-middle-->
    </header><!--/header-->
    
  <section id="slider">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>
                        
                        <div class="carousel-inner">
                            <div class="item active">
                                    <img src="{{asset('public/frontend/images/banner.png')}}"   alt="" />
                            </div>
                            <div class="item">   
                                    <img src="{{asset('public/frontend/images/banner3.png')}}"  alt="" /> 
                            </div>
                            <div class="item">   
                                    <img src="{{asset('public/frontend/images/banner2.png')}}" alt="" />     
                            </div>
                        </div>
                        
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
    </section>

     <div class="content">
      <div class="row">
        <div class="col-sm-2">
            <div class="left-sidebar">
           
                <p style="font-size:18px;text-align: center;text-transform: uppercase;font-weight: bold;font-family: 'Roboto'">Danh mục sản phẩm</p>
                <div class="panel-group category-products" id="accordian">
                        
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordian" href="#ao">
                                    <span class="badge pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    Áo</a></h4>
                                </div>
                               
                                <div id="ao" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category as $key => $cate_sub)
                                             @if($cate_sub->category_parent == 1)
                                            <li><a href="{{URL::to('/danh-muc-sp/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> 
                            </div>
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordian" href="#quan">
                                    <span class="badge pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    Quần</a></h4>
                                </div>
                               
                                <div id="quan" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category as $key => $cate_sub)
                                             @if($cate_sub->category_parent == 2)
                                            <li><a href="{{URL::to('/danh-muc-sp/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> 
                            </div>
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordian" href="#vay">
                                    <span class="badge pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    Váy</a></h4>
                                </div>
                               
                                <div id="vay" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category as $key => $cate_sub)
                                             @if($cate_sub->category_parent == 3)
                                            <li><a href="{{URL::to('/danh-muc-sp/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> 
                            </div>
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordian" href="#set">
                                    <span class="badge pull-right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    Set</a></h4>
                                </div>
                               
                                <div id="set" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category as $key => $cate_sub)
                                             @if($cate_sub->category_parent == 4)
                                            <li><a href="{{URL::to('/danh-muc-sp/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> 
                            </div>

                       
                    </div>
                    <style>
                        .scrollable-panel {
                            max-height: 300px; 
                            overflow-y: auto; 
                            border: 1px solid #ddd;
                            padding: 10px;
                            
                        }
                    </style>
                <h2>Màu sắc</h2>
                <div class="panel-group category-products scrollable-panel" id="accordian">
                    @foreach($colors as $key => $color)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="{{URL::to('/mau-sp/'.$color->color_id)}}">{{$color->color_name}}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach   
                </div>
                <h2>Kích thước</h2>
                <div class="panel-group category-products" id="accordian">
                         @foreach($sizes as $key => $size)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{URL::to('/kichthuoc-sp/'.$size->size_id)}}">{{$size->size_name}}</a></h4>
                                </div>
                            </div>
                         @endforeach   
                </div>
        </div>
    </div>
    <div class="col-sm-10 padding-right">
        <div class="nd">
           @yield('content')   
        </div>
    </div>
    <style type="text/css">
        .phone-vr-img-circle {
            background-color: #2196F3;
            width: 40px;
            height: 40px;
            line-height: 40px;
            top: 25px;
            left: 25px;
            position: absolute;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            -webkit-animation: phonering-alo-circle-img-anim 1s infiniteease-in-out;
            animation: phone-vr-circle-fill 1s infiniteease-in-out;
            }
        #button-contact-zalo{
            position: fixed;
            bottom: 110px;
            z-index: 99999;
            left: 0;

        }
        #gom-all-in-one #zalo-vr {
            transition: 1s all;
            -moz-transition: 1s all;
            -webkit-transition: 1s all;
        }
        .phone-vr-circle-fill {
            width: 65px;
            height: 65px;
            top: 12px;
            left: 12px;
            position: absolute;
            box-shadow: 0 0 0 0 #2196F3;
            background-color: rgba(33, 150, 243, 0.7);
            border-radius: 50%;
            border: 2px solid transparent;
            -webkit-animation: phone-vr-circle-fill 2.3s infinite ease-in-out;
            animation: phone-vr-circle-fill 2.3s infinite ease-in-out;
            transition: all .5s;
            -webkit-transform-origin: 50% 50%;
            -ms-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
            -webkit-animuiion: zoom 1.3s infinite;
            animation: zoom 1.3s infinite;
        }
        
        .phone-vr-img-circle {
            background-color: #2196F3;
            width: 40px;
            height: 40px;
            line-height: 40px;
            top: 25px;
            left: 25px;
            position: absolute;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            -webkit-animation: phonering-alo-circle-img-anim 1s infinite ease-in-out;
            animation: phone-vr-circle-fill 1s infinite ease-in-out;
        }
        .phone-vr-img-circle a {
            display: block;
            line-height: 37px;
        }
        .phone-vr-img-circle img {

            max-height: 80px;
            max-width: 80px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
        }
        @keyframes zoom{
            0% {
                transform: scale(.9);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px transparent;
            }
            100% {
                transform: scale(.9);
                box-shadow: 0 0 0 0 transparent;
            }
        }
        @keyframes phone-vr-circle-fill{
            0% {
                -webkit-transform: rotate(0) scale(1) skew(1deg);
            }
            10% {
                -webkit-transform: rotate(-25deg) scale(1) skew(1deg);
            }
            20% {
                -webkit-transform: rotate(25deg) scale(1) skew(1deg);
            }
            30% {
                -webkit-transform: rotate(-25deg) scale(1) skew(1deg);
            }
            40% {
                -webkit-transform: rotate(25deg) scale(1) skew(1deg);
            }
            50% {
                -webkit-transform: rotate(0) scale(1) skew(1deg);
            }
            100% {
                -webkit-transform: rotate(0) scale(1) skew(1deg);
            }
    </style>
    <div id="button-contact-zalo" class="">
        <div id="gom-all-in-one">
            <div id="zalo-vr" class="button-contact">
                <div class="phone-vr">
                    <div class="phone-vr-circle-fill"></div>
                    <div class="phone-vr-img-circle">
                       <a target="_blank" href="https://m.me/626427037210322">            
                            <img src="{{asset('public/frontend/images/messxanh.png')}}">
                        </a>
                    </div>
                </div>
                </div>
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
    

  
    <!-- <script src="{{asset('public/frontend/js/jquery.js')}}"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
     <script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/prettify.js')}}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="{{asset('public/frontend/js/simple.money.format.js')}}"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
      {!! Toastr::message() !!}
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
    <script type="text/javascript">
        $(document).ready(function() {
    $('#imageGallery').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:3,
        slideMargin:0,
        enableDrag: false,
        currentPagerPosition:'left',
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        }   
    });  
  });
    </script>
    <script type="text/javascript">
        $('.xemnhanh').click(function(){
            var product_id = $(this).data('id_product');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/quickview')}}",
                method:"POST",
                dataType:"JSON",
                data:{product_id:product_id, _token:_token},
                success:function(data){
                    $('#product_quickview_title').html(data.product_name);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);
                    $('#product_quickview_quantities').html(data.product_quantities);
                    $('#product_quickview_desc').html(data.product_desc);
                }
            });

        });
      
    </script>
   <script type="text/javascript">
       $(document).ready(function(){
        load_comment();
        function load_comment(){
            var product_id = $('.comment_product_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/load-comment')}}",
                method:"POST",
                data:{product_id:product_id, _token:_token},
                success:function(data){
                    $('#comment_show').html(data);
                }
            });
        }
        $('.send-comment').click(function(){
            var product_id = $('.comment_product_id').val();
            var comment_name = $('.comment_name').val();
            var comment_content = $('.comment_content').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/send-comment')}}",
                method:"POST",
                data:{product_id:product_id,comment_name:comment_name,comment_content:comment_content, _token:_token},
                success:function(data){
                   $('#notify_comment').html('<span style="color:green" class"text text-success">Thêm bình luận thành công</span>');
                    load_comment();
                     $('#notify_comment').fadeOut(5000);
                     $('.comment_name').val('');
                     $('.comment_content').val('');
                }
            });
        });
       });
   </script>
   <script type="text/javascript">
    function remove_background(product_id) {
        for (var count = 1; count <= 5; count++) {
            $('#' + product_id + '-' + count).css('color', '#ccc'); // Màu mặc định
        }
    }

    // hover chuột đánh giá sao
    $(document).on('mouseenter', '.star', function() { // Sử dụng lớp star
        var index = $(this).data('index');
        var product_id = $(this).data('product-id');

        remove_background(product_id);
        for (var count = 1; count <= index; count++) {
            $('#' + product_id + '-' + count).css('color', '#FFFF33'); // Màu khi hover
        }
    });

    // nhả chuột
    $(document).on('mouseleave', '.star', function() {
        var index = $(this).data('index');
        var product_id = $(this).data('product-id');
        var rating = $(this).data("rating");

        remove_background(product_id);
        // Giữ màu cho sao đã đánh giá
        for (var count = 1; count <= rating; count++) {
            $('#' + product_id + '-' + count).css('color', '#FFFF33');
        }
    });
    $(document).on('click','.star',function(){
       var index = $(this).data('index');
       var product_id = $(this).data('product-id');
       var _token = $('input[name="_token"]').val();
        $.ajax({
                url:"{{url('/insert-rating')}}",
                method:"POST",
                data:{product_id:product_id,index:index, _token:_token},
                success:function(data){
                   if(data == 'done'){
                    alert("Đánh giá thành công");
                    location.reload();
                   }else{
                    alert("Lỗi đánh giá!");
                   }
                }
            });
    });
</script>
<script type="text/javascript">
    function view(){
        if(localStorage.getItem('data') != null){
            var data = JSON.parse(localStorage.getItem('data'));
            data.reverse();
            document.getElementById('row_wishlist').style.overflow = 'scoll';
            document.getElementById('row_wishlist').style.height = '600px';
            for(i = 0;i<data.length;i++){
                var name = data[i].name;
                var price = data[i].price;
                var image = data[i].image;
                var url = data[i].url;
                $("#row_wishlist").append();
            }
        }
    }
    function add_wishlist(clicked_id){
        var id = clicked_id;
        var name = document.getElementById('wishlist_productname'+id).value;
        var price = document.getElementById('wishlist_productprice'+id).value;
        var image = document.getElementById('wishlist_productimage'+id).src;
        var url = document.getElementById('wishlist_producturl'+id).href;
         var newItem = {
            'url':url,
            'id':id,
            'name':name,
            'price':price,
            'image':image
         }
         if(localStorage.getItem('data') == null){
            localStorage.setItem('data','[]');
         }
         var old_data = JSON.parse(localStorage.getItem('data'));
         var matches = $.grep(old_data,function(obj){
            return obj.id == id;
         });
         if(matches.length){
            alert('Sản phẩm đã tồn tại!');
         }else{
            old_data.push(newItem);
            $("#row_wishlist").append();
         }
         localStorage.setItem('data',JSON.stringify(old_data));
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sort').on('change',function(){
            var url = $(this).val();
            if(url){
                window.location = url;
            }
            return false;
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $( "#slider-range" ).slider({
              orientation: "horizontal",
              range: true,
              min:{{$min_price}},
              max:{{$max_price_range}},
              step:10000,
              values: [ {{$min_price}}, {{$max_price}} ],
              slide: function( event, ui ) {
                $( "#amount_start" ).val(ui.values[ 0 ]).simpleMoneyFormat();
                $( "#amount_end" ).val(ui.values[ 1 ]).simpleMoneyFormat();
                $( "#start_price" ).val(ui.values[ 0 ]);
                $( "#end_price" ).val(ui.values[ 1 ]);
              }
            });

    $( "#amount_start" ).val( $( "#slider-range" ).slider( "values", 0 )).simpleMoneyFormat();
    $( "#amount_end" ).val( $( "#slider-range" ).slider( "values", 1 )).simpleMoneyFormat();
    });
</script>
</body>
</html>