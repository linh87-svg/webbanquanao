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
            <p style="color:red;font-size: 16px;">CHÍNH SÁCH GIAO HÀNG VÀ KIỂM HÀNG</p>
            <p style="font-style:italic;font-size: 12px;"><i class="fa fa-calendar" aria-hidden="true"></i> Đăng ngày 07-09-2023</p>
            <p>May Boutique luôn hướng tới việc cung cấp dịch vụ giao hàng tốt nhất cho tất cả các đơn hàng của bạn. </p>
            <p>Sau khi Quý Khách đặt hàng thành công tại website mayboutique.vn, May Boutique sẽ gửi email để thông báo tới Quý Khách, trong đó bao gồm nội dung chi tiết đơn hàng đã đặt thành công. May Boutique sẽ không tiến hành gọi điện xác nhận đơn hàng tránh làm phiền Quý Khách.</p>
            <p>Chúng tôi hỗ trợ giao hàng toàn quốc với chính sách như sau:</p>
            <p><b>1. Đồng kiểm trước khi thanh toán</b></p>
            <p>Trước khi nhận hàng và thanh toán, Quý Khách được quyền kiểm tra sản phẩm. Không hỗ trợ thử hàng.</p>
            <p>Quý Khách vui lòng mở gói hàng kiểm tra để đảm bảo đơn hàng được giao đúng mẫu mã, số lượng như đơn hàng đã đặt. Không thử hay dùng thử sản phẩm.</p>
            <p>Sau khi đồng ý với món hàng được giao đến, Quý Khách thanh toán với nhân viên giao hàng (trường hợp đơn hàng được ship COD) và nhận hàng.</p>
            <p>Trường hợp Quý Khách không ưng ý với sản phẩm, Quý Khách có thể từ chối nhận hàng. Tại đây, May Boutique sẽ thu thêm chi phí hoàn hàng, tương đương với phí ship của đơn hàng Quý khách đã đặt.</p>
            <p style="font-style:italic;font-weight: bold;">Lưu ý: </p>
            <p>- Khi Quý Khách kiểm tra đơn hàng, nhân viên giao nhận buộc phải đợi Quý Khách kiểm tra hàng hóa bên trong gói hàng. Trường hợp nhân viên từ chối cho Quý Khách kiểm tra hàng hóa, Quý Khách vui lòng liên hệ với May Boutique qua hotline: 0981.933.439 để được hỗ trợ.</p>
            <p>- May Boutique sẽ không chịu trách nhiệm về số lượng, mẫu mã cũng như lỗi của sản phẩm, sau khi đơn hàng đã được giao hàng thành công.</p>
            <p>- Quý Khách tránh dùng vật sắc nhọn để mở gói hàng để tránh gây hư hỏng cho sản phẩm bên trong. Đối với những trường hợp sản phẩm bị hư hỏng do lỗi từ phía Khách hàng, May Boutique rất tiếc không thể hỗ trợ Quý Khách đổi/trả/bảo hành sản phẩm.</p>
            <p><b>2. Thời gian và mức phí giao hàng</b></p>
            <style type="text/css">
                
                table {
                    width: 50%;
                    border-collapse: collapse; 
                    margin: 20px auto;
                }
                th, td {
                    border: 1px solid black; 
                    text-align: center; 
                    padding: 8px; 
                }
        
            </style>
            <table>
                <tr>
                    <th>Hình thức thanh toán</th>
                    <th>Thời gian dự kiến nhận hàng</th>
                    <th>Mức phí</th>
                </tr>
                <tr>
                    <th>Tiền mặt (COD)</th>
                    <td>03 – 05 ngày làm việc kể từ ngày đặt đơn</td>
                    <td>Dựa trên biểu phí thực tế của đơn vị vận chuyển</td>
                </tr>
                <tr>
                    <th>Thanh toán trước (Chuyển khoản, Online, Visa/Mastercard, VnPay)</th>
                    <td>03 – 06 ngày làm việc kể từ khi May Boutique nhận được thanh toán</td>
                    <td>Dựa trên biểu phí thực tế của đơn vị vận chuyển</td>
                </tr>
            </table>
            <p style="font-style:italic;font-weight: bold;">Lưu ý: </p>
            <p>- Thời gian vận chuyển thực tế có thể nhanh hoặc chậm hơn so với thời gian dự kiến – phụ thuộc vào tình hình sản xuất hoặc các sự kiện bất khả kháng khác (mưa lũ, thiên tai, dịch bệnh).</p>
            <p>- May Boutique sẽ thông báo cho khách hàng nếu thời gian này dài hơn 10 ngày làm việc.</p>
            <p>- Trong trường hợp cần nhận đơn hàng gấp, Quý khách hàng có thể liên hệ với May Boutique qua Điện thoại hoặc Facebook để được hỗ trợ vận chuyển nhanh hơn:</p>
            <p style="margin-left:50px">Hotline: 0981.933.439</p>
            <p style="margin-left:50px">Fanpage: https://www.facebook.com/mayboutique.official</p>
            <p><b>3. Trách nhiệm của đơn vị vận chuyển cung cấp chứng từ hàng hóa.</b></p>
            <p style="font-style: italic;"><b>3.1. Quyền và nghĩa vụ chung của đơn vị vận chuyển</b></p>
            <p>Được hưởng thù lao dịch vụ và các chi phí hợp lý khác theo thỏa thuận với May Boutique</p>
            <p>Bên vận chuyển phải cung cấp đầy đủ chứng từ gửi và nhận hàng hóa cho cả May Boutique và khách hàng</p>
            <p>Đảm bảo giao hàng theo đúng thời gian quy định đã thỏa thuận với May Boutique (trừ trường hợp ảnh hưởng của nguyên nhân bất khả kháng quy định trong hợp đồng hợp tác)</p>
            <p>Gửi hàng hóa đến người nhận nguyên trạng đảm bảo không hỏng hóc hoặc ảnh hưởng đến chức năng sử dụng của hàng hóa và có hình ảnh, ký xác nhận của người nhận đi kèm</p>
            <p>Khi thực hiện việc vận chuyển hàng hóa, thương nhân kinh doanh dịch vụ logistics phải tuân thủ các quy định của pháp luật và tập quán vận tải.
</p>
            <p>Đơn vị vận chuyển thực hiện quyền cầm giữ hàng hoá có các nghĩa vụ sau đây:</p>
            <p style="margin-left:50px">- Bảo quản, giữ gìn hàng hoá;</p>
            <p style="margin-left:50px">- Không được sử dụng hàng hoá nếu không được bên May Boutique đồng ý;</p>
            <p style="margin-left:50px">- Bồi thường thiệt hại cho May Boutique nếu làm mất mát hoặc hư hỏng hàng hoá cầm giữ.</p>
            <p style="font-style: italic;"><b>3.2. Các trường hợp miễn trách nhiệm:</b></p>
            <p>Đơn vị vận chuyển không phải chịu trách nhiệm về những tổn thất đối với hàng hoá phát sinh trong các trường hợp sau đây:</p>
            <p>- Tổn thất là do lỗi của khách hàng hoặc của người được khách hàng uỷ quyền,</p>
            <p>- Tổn thất phát sinh do Đơn vị vận chuyển làm đúng theo những chỉ dẫn của khách hàng hoặc của người được khách hàng uỷ quyền;</p>
            <p>- Tổn thất là do khuyết tật của hàng hoá;</p>
            <p>- Tổn thất phát sinh trong những trường hợp miễn trách nhiệm theo quy định của pháp luật và tập quán vận tải nếu Đơn vị vận chuyển tổ chức vận tải;</p>
            <p>- Đơn vị vận chuyển không nhận được thông báo về khiếu nại trong thời hạn mười bốn ngày, kể từ ngày Đơn vị vận chuyển giao hàng cho người nhận;</p>
            <p>- Sau khi bị khiếu nại, Đơn vị vận chuyển không nhận được thông báo về việc bị kiện tại Trọng tài hoặc Toà án trong thời hạn chín tháng, kể từ ngày giao hàng.</p>
            <p>- Đơn vị vận chuyển không phải chịu trách nhiệm về việc mất khoản lợi đáng lẽ được hưởng của khách hàng, về sự chậm trễ hoặc thực hiện dịch vụ logistics sai địa điểm không do lỗi của mình.</p>
            <p>Lưu ý: Trường hợp phát sinh chậm trễ trong việc giao hàng hoặc cung ứng dịch vụ, đơn vị vận chuyển phải có thông tin kịp thời cho May Boutique để chúng tôi liên hệ đến khách hàng và tạo cơ hội để khách hàng có thể hủy đơn hàng nếu muốn.</p>
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