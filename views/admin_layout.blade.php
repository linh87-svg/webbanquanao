<!DOCTYPE html>
<head>
<link rel="icon" type="image/x-icon" href="{{asset('public/frontend/images/logomay.png')}}" sizes="48x48">
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
<link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
     <img src="{{asset('public/frontend/images/logomay.png')}}" width="34%" style="margin-left: 10px;">
    <a href="{{URL::to('/dashboard')}}" class="logo">
        MAY BOUTIQUE
    </a>
</div>

<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle"  href="#">
                
                <span class="username">
                    <?php 
                        if(Auth::check()) { 
                            echo Auth::user()->admin_name;
                        } 
                    ?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="{{URL::to('/show-pass')}}"><i class="fa fa-lock"></i>Đổi mật khẩu</a></li>
                <li><a href="{{URL::to('/logout-auth')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                 @hasrole('admin')
                <li>
                    <a href="{{URL::to('/information')}}">
                       <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        <span>Liên hệ</span>
                    </a>
                </li>
                @endhasrole
                <li class="sub-menu">
                    <a href="{{URL::to('/add-category-product')}}">
                       <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                        <span>Danh mục sản phẩm</span>
                        
                    </a>
                    
                </li>
           
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cube" aria-hidden="true"></i>
                        <span>Sản phẩm</span>
                        <i  class="fa fa-angle-right pull-right" aria-hidden="true"></i>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{URL::to('/manager-order')}}">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-sellsy" aria-hidden="true"></i>
                        <span>Mã giảm giá</span>
                        <i  class="fa fa-angle-right pull-right" aria-hidden="true"></i>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/insert-counpon')}}">Thêm mã giảm giá</a></li>
						<li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{URL::to('/add-color')}}">
                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                        <span>Màu sắc</span>
                         
                    </a>
                   
                </li>
                 <li class="sub-menu">
                    <a href="{{URL::to('/add-size')}}">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                        <span>Kích thước</span>
                    
                    </a>
                </li>
                 <li class="sub-menu">
                    <a href="{{URL::to('/delivery')}}">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                        <span>Phí vận chuyển</span>
                    </a>
                </li>  
                 <li class="sub-menu">
                    <a href="{{URL::to('/comment')}}">
                        <i class="fa fa-comments" aria-hidden="true"></i>
                        <span>Bình luận</span>
                    </a>
                </li>              
                @hasrole('admin')
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        <span>Nhân viên</span>
                     <i  class="fa fa-angle-right pull-right" aria-hidden="true"></i>
                    </a>
                    <ul class="sub">
                         <li><a href="{{URL::to('/add-users')}}">Thêm nhân viên</a></li>
                        <li><a href="{{URL::to('/users')}}">Quản lý nhân viên</a></li>
                      
                    </ul>
                </li>
               
                <li class="sub-menu">
                    <a href="{{URL::to('/customer')}}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>Khách Hàng</span>
                    </a>
                </li>   
                
                @endhasrole
            </ul>            
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
	   @yield('admin_content')
</section>
 
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script src="{{asset('public/backend/js/simple.money.format.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
 <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      {!! Toastr::message() !!} 
<!-- morris JavaScript -->	
<!-- //money -->
<!-- jQuery để tìm kiếm -->
<script>
  $(document).ready(function(){
    $("#searchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  });
</script>
<script type="text/javascript">
    $('.price_format').simpleMoneyFormat();
</script>

<!-- datepier lọc tke -->
<script>
    $(document).ready(function () {
        const _token = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function () {
        let today = new Date().toISOString().slice(0, 10);
        let last30 = new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10);

        // Giới hạn không cho chọn ngày trong tương lai
        $('#datepicker, #datepicker2').attr('max', today);

        loadKPI(last30, today);

        // Sự kiện lọc theo ngày
        $('#btn-dashboard-filter').click(function () {
            let from = $('#datepicker').val();
            let to = $('#datepicker2').val();

            // Kiểm tra nếu ô nhập ngày rỗng
            if (!from || !to) {
                alert("Vui lòng chọn đầy đủ ngày bắt đầu và ngày kết thúc.");
                return;
            }

            // Kiểm tra nếu chọn ngày trong tương lai
            if (new Date(from) > new Date(today) || new Date(to) > new Date(today)) {
                alert("Không được chọn ngày trong tương lai.");
                return;
            }

            if (new Date(to) >= new Date(from)) {
                loadKPI(from, to);
            } else {
                alert("Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.");
            }
        });
    });

        // Sự kiện lọc nhanh
        $('#dashboard_filter').change(function () {
            let val = $(this).val();
            if (val) {
                $.post("{{ url('/dashboard-filter') }}", { dashboard_value: val, _token }, function(data) {
                    let from = data[0]?.period;
                    let to = data[data.length - 1]?.period;
                    if (from && to) loadKPI(from, to);
                }, 'json');
            }
        });

        function loadKPI(from, to) {
            $.post("{{ url('/dashboard-kpi') }}", { form_date: from, to_date: to, _token }, function(res) {
                updateKPI('#kpi-order', res.order);
                updateKPI('#kpi-sales', res.sales);
                updateKPI('#kpi-profit', res.profit);
                updateKPI('#kpi-quantity', res.quantity);
            });
        }

        function updateKPI(selectorPrefix, data) {
            $(`${selectorPrefix}-value`).text(
                Number(data.value).toLocaleString() +
                (selectorPrefix.includes('sales') || selectorPrefix.includes('profit') ? ' ₫' : '')
            );
        }

        // Datepicker ràng buộc
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $("#datepicker2").datepicker("option", "minDate", selected);
            }
        });

        $("#datepicker2").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>
<!-- doanh số -->
<script>
    $(document).ready(function () {
        $.post("{{ url('/compare-sales-month') }}", {
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function (res) {
            let months = res.map(item => item.month);
            let thisYear = res.map(item => item.sales_this_year);
            let lastYear = res.map(item => item.sales_last_year);
            let percentChanges = res.map(item => item.percent_change); // lấy phần trăm thay đổi

            const ctx = document.getElementById('monthlyCompareChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Năm nay',
                            data: thisYear,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Năm trước',
                            data: lastYear,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                afterBody: function (tooltipItems) {
                                    const index = tooltipItems[0].dataIndex;
                                    const percent = percentChanges[index];
                                    let text = '';
                                    if (percent > 0) {
                                        text = `📈 Tăng ${percent}% so với năm trước`;
                                    } else if (percent < 0) {
                                        text = `📉 Giảm ${Math.abs(percent)}% so với năm trước`;
                                    } else {
                                        text = `⏸ Không thay đổi so với năm trước`;
                                    }
                                    return text;
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return value.toLocaleString() + ' ₫';
                                }
                            }
                        }
                    }
                }
            });
        });
    });
</script>
<!-- lợi nhuận -->
<script>
    $(document).ready(function () {
        $.post("{{ url('/compare-profit-month') }}", {_token: $('meta[name="csrf-token"]').attr('content')}, function (res) {
            let months = res.map(item => item.month);
            let thisYear = res.map(item => item.sales_this_year);
            let lastYear = res.map(item => item.sales_last_year);
            let percentChanges = res.map(item => item.percent_change); // lấy phần trăm thay đổi


            const ctx = document.getElementById('monthlyChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Năm nay',
                            data: thisYear,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Năm trước',
                            data: lastYear,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                afterBody: function (tooltipItems) {
                                    const index = tooltipItems[0].dataIndex;
                                    const percent = percentChanges[index];
                                    let text = '';
                                    if (percent > 0) {
                                        text = `📈 Tăng ${percent}% so với năm trước`;
                                    } else if (percent < 0) {
                                        text = `📉 Giảm ${Math.abs(percent)}% so với năm trước`;
                                    } else {
                                        text = `⏸ Không thay đổi so với năm trước`;
                                    }
                                    return text;
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return value.toLocaleString() + ' ₫';
                                }
                            }
                        }
                    }
                }
            });
        });
    });
</script>
 <!-- top sp  -->
<script>
$(document).ready(function () {
    $.ajax({
        url: "{{ url('/top-selling-products') }}",
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function (data) {
        let tableBody = $('#top-products-table');
        tableBody.empty();

            $.each(data, function (index, product) {
                tableBody.append(`
                    <tr>
                        <td style="padding: 8px;">${index + 1}</td> <!-- STT -->
                        <td style="padding: 8px;">${product.product_name}</td>
                        <td style="padding: 8px; text-align: right;">${product.product_sold}</td>
                    </tr>
                `);
            });
        },
        error: function (xhr, status, error) {
            console.error("Lỗi khi tải top sản phẩm:", error);
        }
    });
});
</script>
<!-- đơn hàng gần đây -->
<script>
$(document).ready(function () {
    function getStatusText(status) {
        switch (parseInt(status)) {
            case 1: return 'Chờ xử lý';
            case 2: return 'Đã xử lý - Đã giao hàng';
            case 3: return 'Đã hủy';
            default: return 'Không xác định';
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Gửi kèm token
        }
    });

    $.ajax({
       url: '{{ url("/recent-orders") }}',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            let html = '';
            data.forEach(function (order) {
                html += `
                    <tr>
                        <td style="padding: 8px;">
                        <a href="/shoplaravel/view-order/${order.order_code}" style="color: #007bff; text-decoration: none;">
                            ${order.order_code}
                        </a>
                        </td>
                        <td style="padding: 8px;">${order.user_name}</td>
                        <td style="padding: 8px; text-align: right;">${Number(order.total_amount).toLocaleString()} đ</td>
                        <td style="padding: 8px;">${order.created_at}</td>
                        <td style="padding: 8px;">${getStatusText(order.order_status)}</td>
                    </tr>
                `;
            });
            $('#recent-orders-table').html(html);
        },
        error: function () {
            $('#recent-orders-table').html('<tr><td colspan="4">Không thể tải dữ liệu</td></tr>');
        }
    });
});
</script>
<script>
    //thay thế cho textarea
    CKEDITOR.replace('ckeditor');
    CKEDITOR.replace('ckeditor1');
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#myTable').DataTable();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
    	fetch_delivery();
    	function fetch_delivery(){
    		var _token = $('input[name="_token"]').val();
    		$.ajax({
                url: '{{url('/select-feeship')}}',
                method: 'POST',
                data: {_token: _token},
                success: function(data){
                   $('#load_delivery').html(data);
                }
            });
    	}
    	$(document).on('blur','.fee_feeship_edit',function(){
    		var feeship_id = $(this).data('feeship_id');
    		var fee_value = $(this).text();
    		var _token = $('input[name="_token"]').val();
    		$.ajax({
                url: '{{url('/update-delivery')}}',
                method: 'POST',
                data: {feeship_id:feeship_id, fee_value:fee_value,_token: _token},
                success: function(data){
                   fetch_delivery();
                }
            });
    	});
    	$('.add_delivery').click(function(){
			var province = $('.province').val();
			var district = $('.district').val();
			var wards = $('.wards').val();
			var fee_ship = $('.fee-ship').val().trim();
			var _token = $('input[name="_token"]').val();
           if (fee_ship === '') {
                alert("Vui lòng chọn địa điểm và nhập phí ship!");
                return false;
            } else if (isNaN(fee_ship)) {
                alert("Phí ship phải là số!");
                return false;
            } else if (parseFloat(fee_ship) < 0) {
                alert("Phí ship không được nhỏ hơn 0!");
                return false;
            }
			$.ajax({
                url: '{{url('/insert-delivery')}}',
                method: 'POST',
                data: {province: province, district: district, wards:wards, fee_ship: fee_ship,_token: _token},
                success: function(data){
                    
                   fetch_delivery();
                   
                 },
			    error: function(xhr, status, error) {
			        console.log(xhr.responseText); // Debug lỗi

    			}
            });
		});
        $('.choose').on('change', function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action == 'province'){
                result = 'district';
            }else{
                result = 'wards';
            }

            $.ajax({
                url: '{{url('/select-delivery')}}',
                method: 'POST',
                data: {action: action, ma_id: ma_id, _token: _token},
                success: function(data){
                    $('#' + result).html(data); // Fix lỗi này
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Debug nếu lỗi
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $('.order_detail').change(function(){
        var order_status = $(this).val();
        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();

        // Lấy ra số lượng
        let quantities = [];
        $("input[name='product_quantity']").each(function(){
            quantities.push($(this).val());
        });

        // Lấy ra product_id
        let order_product_id = [];
        $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });

        let isValid = true; // Biến kiểm tra tính hợp lệ

        for (let i = 0; i < order_product_id.length; i++) {
            let order_qty = parseInt($('.order_qty_' + order_product_id[i]).val());
            let order_qty_storage = parseInt($('.order_qty_storage_' + order_product_id[i]).val());

            if (order_qty_storage === 0) {
                alert('Sản phẩm ' + order_product_id[i] + ' đã hết hàng!');
                isValid = false;
                break; // Dừng kiểm tra nếu có lỗi
            }

            if (order_qty > order_qty_storage) {
                alert('Số lượng đặt cho sản phẩm ' + order_product_id[i] + ' vượt quá số lượng tồn kho!');
                isValid = false;
                break; // Dừng kiểm tra nếu có lỗi
            }
        }

        // Nếu không có lỗi, gửi AJAX
        if (isValid) {
            $.ajax({
                url: '{{url('/update-order-qty')}}',
                method: 'POST',
                data: {
                    _token: _token,
                    order_status: order_status,
                    order_id: order_id,
                    quantities: quantities,
                    order_product_id: order_product_id
                },
                success: function(data) {
                    alert('Cập nhật tình trạng đơn hàng thành công');
                    location.reload();
                }
            });
        }
    });
</script>
<!-- gallery -->
<script type="text/javascript">
   $(document).ready(function(){
    load_gallery();

    function load_gallery(){
        var pro_id = $('.pro_id').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ url('/select-gallery') }}",
            method: 'POST',
            data: {pro_id: pro_id, _token: _token},
            success: function(data) {
                $('#gallery_load').html(data);
            }
        });
    }

    // Kiểm tra file ảnh trước khi upload
    $('#file').change(function(){
        var error = '';
        var files = $('#file')[0].files;

        if (files.length > 3) {
            error += '<p>Chỉ được chọn tối đa 3 ảnh</p>';
        } 
        if (files.length === 0) { // Kiểm tra nếu không có file nào
            error += '<p>Không được để trống ảnh</p>';
        }
        
        // Kiểm tra từng file
        for (var i = 0; i < files.length; i++) {
            if (files[i].size > 2000000) {
                error += '<p>File ảnh ' + files[i].name + ' không được lớn hơn 2MB</p>';
            }
        }

        if (error !== '') {
            $('#file').val(''); // Reset input file
            $('#error_gallery').html('<span class="text-danger">' + error + '</span>');
            return false;
        }
    });

    // Cập nhật tên ảnh
    $(document).on('blur', '.edit_gal_name', function(){
        var gal_id = $(this).data('gal_id');
        var gal_text = $(this).text();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ url('/update-gallery-name') }}",
            method: 'POST',
            data: {gal_id: gal_id, gal_text: gal_text, _token: _token},
            success: function(data) {
                load_gallery();
                $('#error_gallery').html('<span class="text-success">Cập nhật tên hình ảnh thành công</span>');
            }
        });
    });

    // Xóa ảnh
    $(document).on('click', '.delete-gallery', function(){
        var gal_id = $(this).data('gal-id');
        var _token = $('input[name="_token"]').val();
        if (confirm('Bạn có muốn xóa hình ảnh này không?')) {
            $.ajax({
                url: "{{ url('/delete-gallery') }}",
                method: 'POST',
                data: {gal_id: gal_id, _token: _token},
                success: function(data) {
                    load_gallery();
                    $('#error_gallery').html('<span style="color:green">Xóa hình ảnh thành công</span>');
                }
            });
        }
    });

    // Cập nhật ảnh
    $(document).on('change', '.file_image', function(){
        var gal_id = $(this).data('gal-id');
        var inputFile = document.getElementById('file-' + gal_id);
        var image = inputFile.files[0];

        if (!image) { // Kiểm tra nếu không chọn file
            $('#error_gallery').html('<span class="text-danger">Vui lòng chọn ảnh trước khi tải lên</span>');
            return false;
        }

        var form_data = new FormData();
        form_data.append("file", image);
        form_data.append("gal_id", gal_id);
        form_data.append("_token", $('meta[name="csrf-token"]').attr('content')); // Thêm CSRF token vào FormData

        $.ajax({
            url: "{{ url('/update-gallery') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                load_gallery();
                $('#error_gallery').html('<span class="text-success">Cập nhật hình ảnh thành công</span>');
            }
        });
    });
});

</script>
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
<script type="text/javascript">
    $('.comment_status_btn').click(function(){
        var comment_status = $(this).data('comment_status');
        var comment_id = $(this).data('comment_id');
        var comment_product_id = $(this).attr('id');

        if(comment_status==0){
            var alert ='Duyệt thành công';
        }
        else{
            var alert ='Duyệt không thành công';
        }
         $.ajax({
            url: "{{ url('/allow-comment')}}", 
            method: 'POST',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           data:{comment_status: comment_status, comment_id: comment_id, comment_product_id: comment_product_id},
            success: function(data) {
                location.reload();
                $('#notify_comment').html('<span class="text text-alert">'+alert+'</span>');
            }
        });  
    });
    $('.btn-reply-comment').click(function(){
        var comment_id = $(this).data('comment_id');
        var comment = $('.reply_comment_'+comment_id).val();
        
        var comment_product_id = $(this).data('product_id');
         $.ajax({
            url: "{{ url('/reply-comment')}}", 
            method: 'POST',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           data:{comment: comment, comment_id: comment_id, comment_product_id: comment_product_id},
            success: function(data) { location.reload();
            $('.reply_comment_'+comment_id).val('');
                $('#notify_comment').html('<span class="text text-alert">Trả lời bình luận thành công</span>');
            }
        });  
    });
</script>
<script>
  $( function() {
    $( "#start_coupon" ).datepicker({
        prevText: "Tháng trước", 
        nextText: "Tháng sau",
        dateFormat: "dd-mm-yy",
        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        duration: "slow"
    });

    $( "#end_coupon" ).datepicker({
        prevText: "Tháng trước", 
        nextText: "Tháng sau",
        dateFormat: "dd-mm-yy",
        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        duration: "slow"
    });
  } );
  </script> 

</body>
</html>
