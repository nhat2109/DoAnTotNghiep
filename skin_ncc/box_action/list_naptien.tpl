<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<div class="box_right">
	<div class="chart-container" style="width: 60%; margin: auto;">
		<canvas id="chartNapTien"></canvas>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			let dataNapTien = {};

			// Chỉ lấy các dòng có trạng thái "Đã duyệt"
			let rows = document.querySelectorAll("tbody tr");

			rows.forEach(row => {
				let cells = row.querySelectorAll("td");

				if (cells.length >= 5) { // Đảm bảo có đủ cột
					let statusElement = cells[4].querySelector('span');
					// Chỉ xử lý các giao dịch đã duyệt
					if (statusElement && statusElement.classList.contains('status-approved')) {
						let dateText = cells[1].textContent.trim();
						let moneyText = cells[2].textContent.trim();

						let dateParts = dateText.split(" ")[0].split("/");
						let monthYear = `${dateParts[1]}/${dateParts[2]}`;

						let amount = parseInt(moneyText.replace(/\./g, "").replace(" VNĐ", ""));

						if (!dataNapTien[monthYear]) {
							dataNapTien[monthYear] = 0;
						}
						dataNapTien[monthYear] += amount;
					}
				}
			});

			// Tạo mảng tháng từ đầu năm đến hiện tại
			const currentDate = new Date();
			const currentYear = currentDate.getFullYear();
			const months = [];
			const monthData = {};

			// Khởi tạo dữ liệu cho tất cả các tháng từ đầu năm
			for (let i = 0; i < 12; i++) {
				const monthYear = `${String(i + 1).padStart(2, '0')}/${currentYear}`;
				months.push(monthYear);
				monthData[monthYear] = dataNapTien[monthYear] || 0;
			}

			// Lấy labels và data cho biểu đồ
			let labels = months;
			let data = months.map(month => monthData[month]);

			// Vẽ biểu đồ
			let ctx = document.getElementById("chartNapTien").getContext("2d");
			new Chart(ctx, {
				type: "bar",
				data: {
					labels: labels,
					datasets: [{
						label: "Số tiền nạp (VNĐ)",
						data: data,
						backgroundColor: "rgba(54, 162, 235, 0.5)",
						borderColor: "rgba(54, 162, 235, 1)",
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						title: {
							display: true,
							text: `Biểu đồ nạp tiền theo tháng năm ${currentYear}`,
							font: { size: 16 }
						},
						tooltip: {
							callbacks: {
								label: function (context) {
									return 'Số tiền: ' + new Intl.NumberFormat('vi-VN', {
										style: 'currency',
										currency: 'VND'
									}).format(context.raw);
								}
							}
						}
					},
					scales: {
						y: {
							beginAtZero: true,
							ticks: {
								callback: function (value) {
									return new Intl.NumberFormat('vi-VN', {
										style: 'currency',
										currency: 'VND'
									}).format(value);
								}
							}
						}
					}
				}
			});
		});
	</script>


	<div class="box_right_content">
		<div class="container">
			<div class="filter-box">
				<h4 style="font-weight: bold;" class="m-0">Quản lí nạp tiền</h4>
				<div style="margin-left: 470px;"></div>
				<label>Từ ngày <input type="date" class="form-control" name="from_date"></label>
				<label>Đến ngày <input type="date" class="form-control" name="to_date"></label>
				<button class="btn btn-light btn-filter"><i class="fa-solid fa-filter"></i> Lọc</button>
				<!-- <input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
				<button name="timkiem_sanpham_hethang" class="button_timkiem">Tìm kiếm</button> -->
				<div class="dropdown">
					<button class="btn-search dropdown-toggle" style="width: 105px;" type="button" id="statusDropdown">
						Trạng thái<i class="fas fa-caret-down"></i>
					</button>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#" data-status="all">Tất cả</a>
						<a class="dropdown-item" href="#" data-status="0">Chờ xử lý</a>
						<a class="dropdown-item" href="#" data-status="1">Đã duyệt</a>
						<a class="dropdown-item" href="#" data-status="2">Đã hủy</a>
					</div>
				</div>
			</div>
		</div>
		<style>
			.list_donhang_top {
				display: none;
			}

			.filter-box {
				background: #d3d3d3;
				padding: 10px;
				display: flex;
				align-items: center;
				gap: 10px;
				border-radius: 5px;
			}

			.status-processing {
				background-color: #e8f5e9;
				color: #2e7d32;
				border: 1px solid #c8e6c9;
			}

			.filter-box input,
			.filter-box button,
			.filter-box select {
				height: 36px;
			}

			.btn-search {
				background: black;
				color: white;
				border: none;
				padding: 6px 12px;
			}

			.btn-search:hover {
				background: #333;
			}

			.dropdown {
				position: relative;
				display: inline-block;
			}

			.dropdown-toggle {
				cursor: pointer;
			}

			.dropdown-toggle i {
				margin-left: 5px;
			}

			.dropdown-menu {
				display: none;
				position: absolute;
				background-color: #fff;
				min-width: 100px;
				box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
				z-index: 100000;
				border-radius: 4px;
				margin-top: 2px;
			}

			.dropdown-menu.show {
				display: block;
			}

			.dropdown-item {
				display: block;
				padding: 8px 16px;
				text-decoration: none;
				color: #333;
				transition: background-color 0.2s;
			}

			.dropdown-item:hover {
				background-color: #f8f9fa;
				color: #000;
			}

			.filter-box label {
				display: flex;
				align-items: center;
				gap: 8px;
				white-space: nowrap;
			}

			.filter-box input[type="date"] {
				padding: 6px 10px;
				border: 1px solid #ddd;
				border-radius: 4px;
				width: 140px;
			}

			.btn-filter,
			.btn-reset {
				padding: 6px 12px;
				border-radius: 4px;
				cursor: pointer;
				display: inline-flex;
				align-items: center;
				gap: 5px;
			}

			.btn-filter {
				background: #007bff;
				color: white;
				border: 1px solid #0056b3;
			}

			.btn-reset {
				background: #6c757d;
				color: white;
				border: 1px solid #545b62;
			}

			.btn-filter:hover,
			.btn-reset:hover {
				opacity: 0.9;
			}

			.list_baiviet th,
			.list_baiviet td {
				padding: 10px;

				text-align: center !important;
				/* Force center alignment */
				vertical-align: middle;
			}


			.list_baiviet th {

				color: white;
				font-weight: bold;
				text-align: center !important;
			}

			/* Remove inline styles from HTML */
			.list_baiviet tr td[style],
			.list_baiviet tr th[style] {
				text-align: center !important;
			}

			/* Additional styling for better appearance */
			.list_baiviet {
				width: 100%;
				border-collapse: collapse;
				font-family: Arial, sans-serif;
			}

			.list_baiviet tr:nth-child(even) {
				background-color: #f2f2f2;
			}

			.list_baiviet tr:hover {
				background-color: #ddd;
			}
		</style>
		<div class="box_profile" style="width: 100%; padding: 10px; background-color: white;">
			<div class="page_title">
				<h1 class="undefined">Lịch sử nạp tiền</h1>
				<div class="line"></div>
				<hr>
			</div>
			<style>
				/* Table styling */
				.list_baiviet {
					width: 100%;
					border-collapse: collapse;
					font-family: Arial, sans-serif;
				}

				.list_baiviet th,
				.list_baiviet td {
					padding: 10px;
					text-align: center;
					vertical-align: middle;
				}

				

				/* Status badges */
				.status-pending,
				.status-approved,
				.status-cancelled,
				.status-unknown {
					display: inline-block;
					padding: 5px 10px;
					border-radius: 4px;
					font-weight: bold;
					text-align: center;
				}

				.status-pending {
					background: #fff3cd;
					color: #856404;
				}

				.status-approved {
					background: #d4edda;
					color: #155724;
				}

				.status-cancelled {
					background: #f8d7da;
					color: #721c24;
				}

				.status-unknown {
					background: #e2e3e5;
					color: #383d41;
				}

				/* Remove borders */
				.list_baiviet,
				.list_baiviet th,
				.list_baiviet td {
					border: none;
				}
			</style>
			<table class="list_baiviet">
				<thead>
					<tr>
						<th class="hide_mobile">STT</th>
						<th>Thời gian</th>
						<th>Số tiền</th>
						<th>Nội dung chuyển khoản</th>
						<th class="hide_mobile">Trạng thái</th>
					</tr>
				</thead>
				<tbody>
					{list_naptien}
				</tbody>
			</table>
			{phantrang}
		</div>
	</div>
</div>
<!--Trang thái-->
<script>
	$(document).ready(function () {
		// Hàm xử lý chung cho việc lọc dữ liệu
		function filterData(params) {
			$.ajax({
				url: '/ncc/process.php',
				type: 'POST',
				data: {
					action: params.action,
					status: params.status || '',
					from_date: params.from_date || '',
					to_date: params.to_date || '',
					page: params.page || 1
				},
				beforeSend: () => $('.list_baiviet tbody').html('<tr><td colspan="5" class="text-center">Đang tải...</td></tr>'),
				success: function (response) {
					try {
						const result = JSON.parse(response);
						if (result.success) {
							$('.list_baiviet tbody').html(result.html);
							if (result.chartData) {
								updateChart(result.chartData);
							}
						} else {
							$('.list_baiviet tbody').html('<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>');
						}
					} catch (e) {
						console.error('Lỗi parse JSON:', e);
						$('.list_baiviet tbody').html('<tr><td colspan="5" class="text-center">Có lỗi xảy ra</td></tr>');
					}
				},
				error: () => alert('Không thể kết nối đến máy chủ!')
			});
		}

		let chartInstance = null;

		function updateChart(chartData) {
			if (chartInstance) {
				chartInstance.destroy();
			}

			// Tạo mảng tháng từ đầu năm đến hiện tại
			const currentDate = new Date();
			const currentYear = currentDate.getFullYear();
			const months = [];
			const monthData = {};

			// Khởi tạo dữ liệu cho tất cả các tháng
			for (let i = 0; i < 12; i++) {
				const monthYear = `${String(i + 1).padStart(2, '0')}/${currentYear}`;
				months.push(monthYear);
				monthData[monthYear] = 0;
			}

			// Cập nhật dữ liệu từ response
			if (chartData && chartData.data) {
				chartData.labels.forEach((label, index) => {
					if (monthData.hasOwnProperty(label)) {
						monthData[label] = chartData.data[index];
					}
				});
			}

			let ctx = document.getElementById("chartNapTien").getContext("2d");
			chartInstance = new Chart(ctx, {
				type: "bar",
				data: {
					labels: months,
					datasets: [{
						label: "Số tiền nạp (VNĐ)",
						data: months.map(month => monthData[month]),
						backgroundColor: "rgba(54, 162, 235, 0.5)",
						borderColor: "rgba(54, 162, 235, 1)",
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					plugins: {
						title: {
							display: true,
							text: `Biểu đồ nạp tiền theo tháng năm ${currentYear}`,
							font: { size: 16 }
						},
						tooltip: {
							callbacks: {
								label: function (context) {
									return 'Số tiền: ' + new Intl.NumberFormat('vi-VN', {
										style: 'currency',
										currency: 'VND'
									}).format(context.raw);
								}
							}
						}
					},
					scales: {
						y: {
							beginAtZero: true,
							ticks: {
								callback: function (value) {
									return new Intl.NumberFormat('vi-VN', {
										style: 'currency',
										currency: 'VND'
									}).format(value);
								}
							}
						}
					}
				}
			});
		}


		// Xử lý lọc theo trạng thái
		$('.dropdown-item').click(function (e) {
			e.preventDefault();
			const status = $(this).data('status');
			$('#statusDropdown')
				.html(`${$(this).text()} <i class="fas fa-caret-down"></i>`)
				.data('current-status', status);
			$('.dropdown-menu').removeClass('show');
			filterData({ action: 'filter_status', status: status });
		});

		// Xử lý lọc theo ngày
		$('.btn-filter').click(function (e) {
			e.preventDefault();
			const from_date = $('input[name="from_date"]').val();
			const to_date = $('input[name="to_date"]').val();

			if (!from_date || !to_date) {
				alert('Vui lòng chọn đầy đủ ngày');
				return;
			}

			filterData({
				action: 'filter_date',
				from_date: from_date,
				to_date: to_date,
				status: $('#statusDropdown').data('current-status')
			});
		});

		// Xử lý phân trang
		$(document).on('click', '.pagination a', function (e) {
			e.preventDefault();
			const params = {
				action: $('input[name="from_date"]').val() ? 'filter_date' : 'filter_status',
				status: $('#statusDropdown').data('current-status'),
				from_date: $('input[name="from_date"]').val(),
				to_date: $('input[name="to_date"]').val(),
				page: $(this).data('page')
			};
			filterData(params);
		});

		// Xử lý dropdown trạng thái
		$('#statusDropdown').click(e => {
			e.preventDefault();
			$('.dropdown-menu').toggleClass('show');
		});

		// Đóng dropdown khi click ngoài
		$(document).click(e => {
			if (!$(e.target).closest('.dropdown').length) {
				$('.dropdown-menu').removeClass('show');
			}
		});
	});
</script>