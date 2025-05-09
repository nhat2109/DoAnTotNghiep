<style type="text/css">
	.list_baiviet i {
		font-size: 35px;
	}

	.filter_wrapper {
		display: flex;
		justify-content: end;
		align-items: flex-start;
		margin: 20px 0;
		gap: 20px;
	}

	.search_section {
		flex: 1;
	}

	.box_search {
		width: 100%;
		position: relative;
		top: 0;
	}

	.box_search input {
		width: 100%;
		padding: 8px 15px;
		border: 1px solid #ddd;
		border-radius: 4px;
		font-size: 14px;
	}

	.filter_section {
		display: flex;
		gap: 10px;
		align-items: center;
		background: #f9f9f9;
		padding: 10px;
		border-radius: 5px;
	}

	.filter_item {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.filter_item select {
		padding: 8px;
		border: 1px solid #ddd;
		border-radius: 4px;
		min-width: 150px;
	}

	.date_range {
		display: flex;
		gap: 8px;
	}

	.date_range input {
		padding: 8px;
		border: 1px solid #ddd;
		border-radius: 4px;
		width: 130px;
	}

	#apply_filter {
		padding: 8px 15px;
		background-color: #4CAF50;
		color: white;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	#apply_filter:hover {
		background-color: #45a049;
	}

	/* Loading spinner */
	.loading {
		position: relative;
		pointer-events: none;
	}

	.loading:after {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(255, 255, 255, 0.8);
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.loading:before {
		content: '';
		position: absolute;
		top: 50%;
		left: 50%;
		width: 30px;
		height: 30px;
		margin: -15px 0 0 -15px;
		border: 3px solid #f3f3f3;
		border-top: 3px solid #3498db;
		border-radius: 50%;
		z-index: 1;
		animation: spin 1s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}

	@media (max-width: 768px) {
		.filter_wrapper {
			flex-direction: column;
		}

		.filter_section {
			width: 100%;
			flex-direction: column;
			align-items: stretch;
		}

		.filter_item {
			width: 100%;
		}

		.filter_item select {
			width: 100%;
			min-width: unset;
		}

		.date_range {
			flex-direction: row;
			flex-wrap: wrap;
		}

		.date_range input {
			flex: 1;
			min-width: 140px;
		}

		#apply_filter {
			width: 100%;
			margin-top: 8px;
		}

		.hide_mobile {
			display: none;
		}
	}
</style>
<div class="box_right">
	<div class="box_right_content">
		<div class="box_profile" style="width: 100%;padding: 10px;">
			<div class="page_title page_title_2" style="margin-top: 40px;">
				<h1 class="undefined">Danh sách đơn hàng shop</h1>
			</div>

			<form id="search_donhang_ncc" onsubmit="return false;">
				<input type="hidden" name="action" value="search_donhang_ncc">
				<div class="filter_wrapper">
					<div class="filter_section">
						<div class="search_section">
							<div class="box_search">
								<input type="text" name="input_search_ncc" placeholder="Nhập mã đơn hàng">
							</div>
						</div>
						<div class="filter_item">
							<select id="status_filter" name="status_filter">
								<option value="">Tất cả trạng thái</option>
								<option value="0">Chưa xử lý</option>
								<option value="1">Đã tiếp nhận đơn</option>
								<option value="2">Đã giao đơn vị vận chuyển</option>
								<option value="3">Yêu cầu hủy đơn</option>
								<option value="4">Đã hủy đơn</option>
								<option value="5">Giao thành công</option>
								<option value="6">Đã hoàn đơn</option>
							</select>
						</div>
						<div class="filter_item date_range">
							<input type="date" id="date_from" name="date_from" placeholder="Từ ngày">
							<input type="date" id="date_to" name="date_to" placeholder="Đến ngày">
						</div>
						<div class="filter_item">
							<button type="submit" id="apply_filter">Lọc</button>
						</div>
					</div>
				</div>
			</form>

			<div id="list_donhang_content">
				<table class="list_baiviet">
					<tr>
						<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
						<th style="text-align: left;">Mã đơn</th>
						<th style="text-align: left;" class="hide_mobile">Ngày</th>
						<th style="text-align: center;">Sản phẩm</th>
						<th style="text-align: left;" class="hide_mobile">Giá trị</th>
						<th style="text-align: center;" class="hide_mobile">Tình trạng</th>
						<th style="text-align: center;width: 225px;">Hành động</th>
					</tr>
					<tbody id="list_donhang_body">
				    	{list_donhang}
					</tbody>
				</table>
				{phantrang}
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('search_donhang_ncc');
    const listContent = document.getElementById('list_donhang_content');
    let currentPage = 1;
    let isLoading = false;

    function searchDonHang(page = 1) {
        if (isLoading) return;

        isLoading = true;
        listContent.classList.add('loading');

        const formData = new FormData(form);
        formData.append('page', page);
		$('.load_overlay').show();
		$('.load_process').fadeIn();
        $.ajax({
            url: '/ncc/process.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
				var info = JSON.parse(response);
				var tbody = document.getElementById('list_donhang_body');
				tbody.innerHTML = ''; 
				setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
				if (tbody) {
					tbody.innerHTML = info.list;
    			}
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại.');
            },
            complete: function() {
                isLoading = false;
                listContent.classList.remove('loading');
            }
        });
    }

    // Xử lý submit form
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        searchDonHang(1);
    });

    // Xử lý phân trang
    function setupPagination() {
        const paginationLinks = document.querySelectorAll('.phantrang a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.getAttribute('data-page') || 1;
                searchDonHang(parseInt(page));
            });
        });
    }

    // Xử lý debounce cho input search
    const searchInput = form.querySelector('input[name="input_search_donhang"]');
    let debounceTimer;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            searchDonHang(1);
        }, 500);
    });

    // Xử lý thay đổi select status và date
    const statusFilter = form.querySelector('#status_filter');
    const dateFrom = form.querySelector('#date_from');
    const dateTo = form.querySelector('#date_to');

    [statusFilter, dateFrom, dateTo].forEach(element => {
        element.addEventListener('change', () => searchDonHang(1));
    });

    // Khôi phục trạng thái tìm kiếm từ URL
    const urlParams = new URLSearchParams(window.location.search);
    for (const [key, value] of urlParams) {
        const input = form.querySelector(`[name="${key}"]`);
        if (input) input.value = value;
    }

    // Setup pagination ban đầu
    setupPagination();
});
</script>