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
            <p style="color:red;font-size: 16px;">CHÍNH SÁCH BẢO MẬT</p>
            <p style="font-style:italic;font-size: 12px;"><i class="fa fa-calendar" aria-hidden="true"></i> Đăng ngày 15-10-2020</p>
            <p><b>1.Mục đích thu thập thông tin cá nhân</b></p>
            <p>Website này được CÔNG TY CAMELLIA quản lý. Khi mỗi khách hàng truy cập vào website này, trang web sẽ tự động lưu địa chỉ IP cùng với tên miền. Chúng tôi cũng sử dụng các công cụ kiểm tra như “cookie”. Một tài khoản cookie sẽ lưu trữ dữ liệu mà server của website gửi đến trình duyệt của khách hàng khi khách hàng truy cập vào trang web, việc sử dụng chức năng này sẽ giúp chúng tôi hỗ trợ và tìm hiểu nhu cầu, thị hiếu của khách hàng khi truy cập vào website của chúng tôi.</p>
            <p>Chúng tôi cũng kết hợp thông tin về địa chỉ IP và tên miền của khách hàng cùng với các thông tin khác mà khách hàng cung cấp.  Các thông tin này được cung cấp qua những email khách hàng gửi cho chúng tôi, hoặc các thông tin khách hàng điền khi muốn đăng ký, ý kiến phản hồi, những yêu cầu được hỗ trợ, trả lời phiếu điều tra hoặc tham gia vào một cuộc thi/ các hoạt động khuyến mại.</p>
            <p><b>2.Phạm vi sử dụng thông tin</b></p>
            <p>Thông tin được thu thập thông qua website của chúng tôi sẽ giúp chúng tôi:</p>
            <p>- Hỗ trợ khách hàng khi mua sản phẩm của May Boutique.</p>
            <p>- Giải đáp thắc mắc khách hàng.</p>
            <p>- Cung cấp cho khách hàng thông tin về các phiên bản phần mềm mới nhất & các bản cập nhật trên Website của chúng tôi.</p>
            <p>- Xem xét và nâng cấp nội dung và giao diện của Website.</p>
            <p>- Thực hiện các bản khảo sát khách hàng.</p>
            <p>- Thực hiện các hoạt động quảng bá liên quan đến các sản phẩm và dịch vụ của May Boutique.</p>
            <p>Để thực hiện các mục đích nêu trên, công ty chúng tôi sẽ xem xét chia sẻ thông tin với các công ty đối tác của May Boutique ở Việt Nam hoặc nước ngoài. Thông tin có thể được chia sẻ cho bên thứ ba mà chúng tôi tin tưởng sẽ hoàn thành được các mục tiêu đã đề ra ở trên. Tuy nhiên, trong trường hợp này, chúng tôi sẽ cố gắng để đảm bảo người nhận không thể lợi dụng thông tin của khách hàng để thực hiện các mục đích khác ngoài các mục tiêu mà chúng tôi đã đề ra trong phạm vi cho phép của khách hàng, chúng tôi cũng sẽ đảm bảo họ sẽ không sử dụng những thông tin này vào những mục đích trái phép. Thông tin chỉ được tiết lộ cho bên thứ ba trong những trường hợp đặc biệt khi có sự yêu cầu của luật pháp hoặc nhà chức trách có thẩm quyền. Đặc biệt, chúng tôi không cho thuê hoặc bán thông tin của khách hàng cho bất kỳ đối tác thứ ba nào (trừ khi nó liên quan đến nhu cầu bán toàn bộ tài sản hoặc hoạt động kinh doanh của chúng tôi như đã đề cập).</p>
            <p><b>3.Thời gian lưu trữ thông tin</b></p>
            <p>Dữ liệu cá nhân của khách hàng sẽ được lưu trữ cho đến khi có yêu cầu hủy bỏ hoặc tự khách hàng đăng nhập và thực hiện hủy bỏ. Còn lại trong mọi trường hợp thông tin cá nhân khách hàng sẽ được bảo mật trên hệ thống máy chủ của May Boutique.</p>
            <p><b>Những người hoặc tổ chức có thể được tiếp cận với thông tin bảo mật: </b></p>
            <p>- May Boutique và các bộ phận liên quan đến việc hỗ trợ và thực hiện hợp đồng với người tiêu dùng.</p>
            <p>- Công ty đối tác của May Boutique ở Việt Nam hoặc nước ngoài.</p>
            <p>- Bên thứ ba mà May Boutique tin tưởng sẽ hoàn thành các mục tiêu đã đề ra trong việc thu thập thông tin cá nhân người dùng hoặc bên thứ ba khi có nhu cầu bán toàn bộ tài sản hoặc hoạt động kinh doanh của chúng tôi như đã đề cập.</p>
            <p>- Trong trường hợp có yêu cầu của pháp luật: Công ty có trách nhiệm hợp tác cung cấp thông tin cá nhân khách hàng khi có yêu cầu từ cơ quan tư pháp bao gồm: Viện kiểm sát, tòa án, cơ quan công an điều tra liên quan đến hành vi vi phạm pháp luật nào đó của khách hàng. Ngoài ra, không ai có quyền xâm phạm vào thông tin cá nhân của khách hàng.</p>
             <p><b>4. Địa chỉ của đơn vị thu thập và quản lý thông tin</b></p>
             <p>Địa chỉ trụ sở: Số 3 ngõ 154 phố Bắc Cầu, Phường Ngọc Thụy, Quận Long Biên, Thành phố Hà Nội, Việt Nam</p>
             <p>Đối với các thắc mắc về hoạt động thu thập, xử lý thông tin liên quan đến cá nhân người tiêu dùng, khách hàng có thể liên hệ: 024.7300.2889</p>
           <p><b>5.Phương thức và công cụ để người dùng tiếp cận và chỉnh sửa dữ liệu cá nhân của mình trên hệ thống của May Boutique.</b></p>
           <p>Khách hàng có quyền yêu cầu chúng tôi cho phép khách hàng có thể truy cập hoặc chỉnh sửa, xóa thông tin cá nhân của khách hàng, hoặc nếu khách hàng có bất kỳ câu hỏi nào về các điều khoản thông tin cá nhân.</p>
           <p><b>6.Cam kết bảo mật thông tin khách hàng.</b></p>
           <p>Khi khách hàng gửi thông tin cá nhân của khách hàng cho chúng tôi, khách hàng đã đồng ý với các điều khoản mà chúng tôi đã nêu ở trên. Chúng tôi cam kết rằng những thông tin mà khách hàng đã cung cấp cho chúng tôi sẽ được bảo mật và được sử dụng để đem lại lợi ích tối đa cho khách hàng. May Boutique sẽ nỗ lực để đảm bảo thông tin của khách hàng được giữ bí mật. Tuy nhiên do hạn chế về mặt kỹ thuật, không một dữ liệu nào có thể được truyền trên đường truyền Internet mà có thể được bảo mật 100%. Do vậy, chúng tôi không thể đưa ra một cam kết chắc chắn rằng thông tin khách hàng cung cấp cho chúng tôi sẽ được bảo mật một cách tuyệt đối an toàn, và chúng tôi không thể chịu trách nhiệm trong trường hợp có sự truy cập trái phép thông tin cá nhân của khách hàng. Nếu khách hàng không đồng ý với các điều khoản như đã mô tả ở trên. Chúng tôi khuyên khách hàng không nên gửi thông tin đến cho chúng tôi.</p>
           <p>Trang web có thể có các liên kết đến các website khác. Các website liên kết này có thể không thuộc phạm vi quản lý của May Boutique và May Boutique không chịu trách nhiệm đối với bất kỳ website liên kết nào.</p>
           <p>May Boutique có đặc quyền và toàn quyền chỉnh sửa nội dung trong trang này mà không cần phải cảnh báo hoặc báo trước. Khách hàng đã đồng ý rằng, khi khách hàng sử dụng website của chúng tôi sau khi chỉnh sửa nghĩa là khách hàng đã thừa nhận, đồng ý tuân thủ cũng như tin tưởng vào sự chỉnh sửa này. Do đó khách hàng nên xem trước nội dung trang này trước khi truy cập các nội dung khác trên website.</p>
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