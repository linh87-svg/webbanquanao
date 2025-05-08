
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

    <title>{{$meta_title}}</title>

    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">    
    <link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">


    <link rel="icon" type="image/x-icon" href="{{asset('public/frontend/images/logomay.png')}}" sizes="48x48">
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
            <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="POST">
                    {{  csrf_field() }}
            <div class="search_box pull-right">
                  <input type="text" name="key"  placeholder="Tìm kiếm" required>
                <button type="submit"><img src="{{asset('public/frontend/images/icon.png')}}" alt=""/></button> 
                 
            </div>
           
             </form>   
        </div><!--/header-middle-->
    </header><!--/header-->
    
    <section id="slider"><!--slider-->
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
    </section><!--/slider-->

    <div class="list_pro_new">
     <h3><b> HÀNG MỚI VỀ</b></h3> 
     <ul class="product_list">  
     @foreach($new as $key => $pr_new)
    <li style="margin-top:20px">
        <button data-toggle="modal" data-target="#xemnhanh" data-id_product = "{{$pr_new->product_id}}" name="xemnhanh" class="xemnhanh">
            <img  src="{{URL::to('public/upload/product/'.$pr_new->product_images)}}" alt="" />
        </button>
        <a href="{{URL::to('/chi-tiet-sp/'.$pr_new->product_id)}}">
        <p>{{$pr_new->product_name}}</p>  
        <p>{{number_format($pr_new->product_price).' '.'₫'}}</p>
    <div class="list-icon">
        <a style="margin-left: 10px;" href="{{URL::to('/chi-tiet-sp/'.$pr_new->product_id)}}"><i class="fa fa-shopping-cart"></i></a>
        <a style="float: right;margin-right: 10px;" href="#"><i class="fa fa-heart"></i></a>
    </div>
        </a>
    </li>
      @endforeach 
</ul>
<!-- Modal -->
            <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <style >
                        @media screen and (min-width:768px){
                            .modal-dialog {
                                width: 700px;
                            }
                            .modal-sm{
                                width: 350px;
                            }
                        }
                         @media screen and (min-width:992px){
                            .modal-lg {
                                width:1000px;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-5">
                             <span id="product_quickview_image"></span>   
                        </div>
                        <div style="color:black;" class="col-md-7">
                            <h4 class="modal-title product_quickview_title" id="">
                                <span id = "product_quickview_title"></span>
                            </h4>
                            <p style="margin-top: 10px;">Số lượng : <span id="product_quickview_quantities"></span></p>
                            <h4 style="color:red;margin-top: 10px;"><span id="product_quickview_price"></span></h4><hr>
                            <p><b>Mô tả sản phẩm : </b></p>
                             <p id="product_quickview_desc"></p>  
                           
                        </div>

                    </div>
                  </div>
                  
                  <div class="modal-footer">
                    <style type="text/css">
                      .modal-footer button{
                        background-color: black;
                        color: white;
                        height: 30px;
                        border: none;
                        transition: all 0.3s ease;
                        border-radius: 2px;
                      }
                      .modal-footer button:hover{
                         background-color: #33CCFF;
                      }
                    </style>
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

  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('public/frontend/js/prettify.js')}}"></script>
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