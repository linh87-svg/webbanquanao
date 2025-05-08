<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body {
		    font-family: Arial, sans-serif;
		    background-color: #f8f8f8;
		    text-align: center;
		    margin: 0;
		    padding: 20px;
		}

		.coupon {
		    border: 1px solid #000;
		    padding: 20px;
		    display: inline-block;
		    text-align: left;
		    max-width: 400px;
		    background: #fff;
		    border-radius: 8px;
		}

		.container {
		    margin-bottom: 10px;
		}

		.promo {
		    font-weight: bold;
		    font-size: 20px;
		    border: 2px dashed #000;
		    padding: 5px 10px;
		    display: inline-block;
		    border-radius: 5px;
		}

		.expire {
		    font-size: 14px;
		    color: #555;
		}

		a {
		    color: #000;
		    font-weight: bold;
		    text-decoration: none;
		}

		a:hover {
		    text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="coupon">
		<div class="container">
			<h3>Mã khuyến mãi từ shop: <a target="_blank" href="http://localhost/shopclothes">http://localhost/shopclothes</a></h3>
		</div>
		<div class="container" style="background-color: white;">
			<h3 class="note"><b><i>
				@if($coupon['coupon_condition']==1)
					Giảm {{$coupon['coupon_number']}}%
				@else
					Giảm {{number_format($coupon['coupon_number'],0,',','.')}} đồng
				@endif
			 cho tổng đơn hàng mua</i></b></h3>
			<p>Quý khách đã từng mua hàng tại shop <a target="_blank" style="color:red" href="http://localhost/shopclothes"></a>nếu đã có tài khoản xin vui lòng <a target="_blank" style="color:red" href="http://localhost/shopclothes/dang-nhap">đăng nhập</a> vào tài khoản để mua hàng và nhập mã code dưới để được giảm giá mua hàng, xin cảm ơn quý khách</p>
		</div>
		<div class="container">
			<p>Sử dụng code sau:<span class="promo">{{$coupon['coupon_code']}}</span>chỉ với {{$coupon['coupon_quantity']}} mã giảm giá</p>
			<p class="expire">Ngày bắt đầu: {{$coupon['start_coupon']}} / Ngày hết hạn: {{$coupon['end_coupon']}}</p>
		</div>
	</div>
</body>
</html>