@extends('admin_layout')
@section('admin_content')
<style type="text/css">
	/* Định dạng chung cho các ô KPI */
	.kpi-card {
	    background-color: #ffffff;
	    border-radius: 10px;
	    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	    padding: 20px;
	    text-align: center;
	    transition: transform 0.3s ease;
	    cursor: pointer;
	    display: flex;
	    flex-direction: column;
	    justify-content: center;
	    align-items: center;
	}

	/* Định dạng hover cho các ô KPI */
	.kpi-card:hover {
	    transform: scale(1.05);
	}

	/* Tiêu đề KPI */
	.kpi-card h6 {
	    font-size: 16px;
	    font-weight: bold;
	    color: #555;
	    margin-bottom: 10px;
	}

	/* Các biểu tượng KPI */
	.kpi-card h6 span {
	    font-size: 24px; /* Kích thước biểu tượng */
	    margin-right: 8px;
	}

	/* Giá trị KPI */
	.kpi-card h3 {
	    font-size: 30px;
	    font-weight: 600;
	    color: #333;
	    margin: 0;
	}

	/* Chỉ thị Loading */
	.kpi-card small {
	    font-size: 14px;
	    color: #6c757d;
	    margin-top: 10px;
	}

	/* Định dạng chung cho các cột */
	.row {
	    margin-top: 20px;
	}

	/* Điều chỉnh màu sắc cho các ô KPI */
	.text-success {
	    color: #28a745;
	}

	.text-danger {
	    color: #dc3545;
	}

	.text-muted {
	    color: #6c757d;
	}

	.text-secondary {
	    color: #6c757d;
	}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

		<div class="container">
		    <div id="dashboard-wrapper" class="container-fluid" style="border: 1px solid #ddd">
		    <!-- Bộ lọc -->
		    <div class="row mb-3">
		        <div class="col-md-3">
		            <input type="text" id="datepicker" class="form-control" placeholder="Từ ngày">
		        </div>
		        <div class="col-md-3">
		            <input type="text" id="datepicker2" class="form-control" placeholder="Đến ngày">
		        </div>
		        <div class="col-md-3">
		            <select id="dashboard_filter" class="form-control">
		                <option value="">--Chọn--</option>
		                <option value="7ngay">7 ngày qua</option>
		                <option value="thangtruoc">Tháng trước</option>
		                <option value="thangnay">Tháng này</option>
		                <option value="365ngay">365 ngày</option>
		            </select>
		        </div>
		        <div class="col-md-3">
		            <button id="btn-dashboard-filter" class="btn btn-primary w-100">Lọc kết quả</button>
		        </div>
		    </div>
<br>
		    <!-- Thẻ KPI -->
		    <div class="row text-center mb-4">
			    @foreach ([
			        'order' => ['label' => 'Đơn hàng', 'icon' => '📦'],
			        'sales' => ['label' => 'Doanh số', 'icon' => '💰'],
			        'profit' => ['label' => 'Lợi nhuận', 'icon' => '📈'],
			        'quantity' => ['label' => 'Số lượng ', 'icon' => '📊']
			    ] as $id => $item)
			        <div class="col-md-3 mb-2">
			            <div class="kpi-card border rounded shadow-sm bg-light p-3">
			                <h6 class="text-muted">
			                    <span class="me-1">{{ $item['icon'] }}</span>{{ $item['label'] }}
			                </h6>
			                <h3 id="kpi-{{ $id }}-value">0</h3>
			                <small id="kpi-{{ $id }}-compare" class="text-secondary"></small>
			            </div>
			        </div>
			    @endforeach
			</div><br>
		</div><br>
			<div style="display: flex; gap: 20px; flex-wrap: wrap;">
			    <!-- Cột bên trái: Doanh số -->
			    <div style="flex: 1; min-width: 300px; max-height: 400px; overflow: auto; border: 1px solid #ddd; padding: 10px; border-radius: 10px;">
			        <h4>Doanh thu</h4><br>
			        <canvas id="monthlyCompareChart" height="200"></canvas>
			    </div>

		
			    <div style="flex: 1; min-width: 300px; max-height: 400px; overflow: auto; border: 1px solid #ddd; padding: 10px; border-radius: 10px;">
			        <h4>Lợi nhuận</h4><br>
			        <canvas id="monthlyChart" height="200"></canvas>
			    </div>
			</div><br>


			<div style="display: flex; gap: 20px; flex-wrap: wrap;">
			    <div style="flex: 1; min-width: 300px; max-height: 400px; overflow: auto; border: 1px solid #ddd; padding: 10px; border-radius: 10px; ">
				    <h4>Top sản phẩm bán chạy</h4><br>
				    <table style="width: 100%; border-collapse: collapse;">
				        <thead>
				            <tr>
				            	<th style="padding: 8px; text-align: left;">STT</th>
				                <th style="padding: 8px; text-align: left;">Sản phẩm</th>
				                <th style="padding: 8px; text-align: right;">Lượt bán</th>
				            </tr>
				        </thead>
				        <tbody id="top-products-table">
				        </tbody>
				    </table>
				</div>
			    <div style="flex: 1; min-width: 300px; max-height: 400px; overflow: auto; border: 1px solid #ddd; padding: 10px; border-radius: 10px;">
				    <h4>Đơn hàng gần đây</h4><br>
				    <table style="width: 100%; border-collapse: collapse;">
				        <thead>
				            <tr >
				                <th style="padding: 5px;">Mã ĐH</th>
				                <th style="padding: 5px;">Tên khách hàng</th>
				                <th style="padding: 5px; text-align: right;">Tổng tiền</th>
				                <th style="padding: 5px;">Thời gian</th>
				                <th style="padding: 5px;">Tình trạng</th>
				            </tr>
				        </thead>
				        <tbody id="recent-orders-table">
				            <!-- AJAX sẽ đổ dữ liệu vào đây -->
				        </tbody>
				    </table>
				</div>
			</div>
		</div>

@endsection