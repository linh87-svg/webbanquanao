<!DOCTYPE html>
<head>
<title>Đăng Ký </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
</head>

<body>
<section id="form">
<div class="login-form">
	<h2>Đăng ký tài khoản</h2>
	<?php 
	$message = Session::get('message');
	if($message){
		echo'<span class="text-alert">', $message,'</span>';
		Session::put('message', null);
	}
	?>
		<form action="{{URL::to('/register')}}" method="post">
			{{csrf_field()}}
			
			<div class="form-group">
		        <input type="text" class="ggg" name="admin_email" placeholder="Nhập email">
		        @error('admin_email')
		            <span style="color:red;" class="text-danger">{{ $message }}</span>
		        @enderror
		    </div>
		    <div class="form-group">
		        <input type="text" class="ggg" name="admin_name" placeholder="Nhập tên">
		        @error('admin_name')
		            <span style="color:red;" class="text-danger">{{ $message }}</span>
		        @enderror
		    </div>

		    <div class="form-group">
		        <input type="text" class="ggg" name="admin_phone" placeholder="Nhập số điện thoại">
		        @error('admin_phone')
		            <span style="color:red;" class="text-danger">{{ $message }}</span>
		        @enderror
		    </div>
		    
		    <div class="form-group">
		        <input type="password" class="ggg" name="admin_password" placeholder="Mật khẩu">
		        @error('admin_password')
		            <span style="color:red;" class="text-danger">{{ $message }}</span>
		        @enderror
		    </div>
		    <div class="form-group">
		        <input type="password" class="ggg" name="admin_password_confirmation" placeholder="Nhập lại mật khẩu">
		        @error('admin_password_confirmation')
		            <span style="color:red;" class="text-danger">{{ $message }}</span>
		        @enderror
		    </div>
				<div class="clearfix"></div>
				<button type="submit" name="register">Đăng ký</button>
		</form>
		
</div>
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
      {!! Toastr::message() !!}
</body>
</html>