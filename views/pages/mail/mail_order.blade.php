<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Xác nhận đơn hàng </title>
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
		<div class="col-md-12">
			<p style="text-align: center;">Đây là email tự động. Quý khách vui lòng không trả lời email này.</p>
			<div class="row">
				<div class="col-md-6" style="text-align: center;font-weight: bold; font-size: 25px;">
					<h3 style="margin: 0;">MAY BOUTIQUE</h3>
					<h6 style="margin: 0;"></h6>
				</div>
				<div class="col-md-6 logo">
					<p>Chào bạn<strong style="text-decoration: underline;">{{$shipping_array['user_name']}}</strong>, chúng tôi đã xác nhận bạn đã đặt hàng ở cửa hàng chúng tôi!</p>
				</div>
				
				<p style="color: black;">Mọi thắc mắc xin liên hệ <a target="_blank" href="http://shopmay.com/shoplaravel">tại đây </a>,hoặc liên hệ qua số hotline : 024 22683232</p>
			</div>
		</div>
	</div>
</body>
</html>