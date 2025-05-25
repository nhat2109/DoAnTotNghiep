<style>
    .chart-container {
        background: #fff;
        padding: 30px;
        border-radius: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    h2 {
        text-align: center;
        color: #1a1f46;
        margin-bottom: 20px;
        font-size: 26px;
        font-weight: 700;
    }

    canvas {
        width: 100% !important;
        height: 400px !important;
    }

    .product-list {
        margin-top: 20px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 10px;
    }

    .banchay-pagination {
        margin-top: 20px;
    }

    
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%; padding: 10px;">
            <div class="box_time">
                <h2>Thống kê sản phẩm bán chạy</h2>
                <div class="list_time">
                    <div class="li_time filter-type">
                        <label>Loại lọc</label>
                        <select name="filter_type">
                            <option value="week" {week_selected}>Tuần</option>
                            <option value="month" {month_selected}>Tháng</option>
                            <option value="quarter" {quarter_selected}>Quý</option>
                            <option value="year" {year_selected}>Năm</option>
                            <option value="custom" {custom_selected}>Tùy chỉnh</option>
                        </select>
                    </div>
                    <div class="li_time custom-time" {custom_style}>
                        <label>Thời gian bắt đầu</label>
                        <input type="text" class="datepicker" value="{begin}" name="begin"
                            placeholder="Chọn thời gian bắt đầu">
                    </div>
                    <div class="li_time custom-time" {custom_style}>
                        <label>Thời gian kết thúc</label>
                        <input type="text" class="datepicker" value="{end}" name="end"
                            placeholder="Chọn thời gian kết thúc">
                    </div>
                    <div class="li_time">
                        <button name="button_doanhthu_hieu_suat_cuaban">Áp dụng</button>
                    </div>
                </div>
            </div>
            <!-- Biểu đồ sản phẩm bán chạy -->
            <div class="chart-container">
                <h3>Sản phẩm bán chạy</h3>
                <canvas id="chartBanChay"></canvas>
            </div>
            <!-- Biểu đồ tổng quan lượt mua -->
            <div class="chart-container">
                <h3>Tổng quan lượt mua</h3>
                <canvas id="chartSummary"></canvas>
            </div>
            <!-- Danh sách sản phẩm bán chạy -->
            <div class="product-list">
                <h3>Danh sách sản phẩm bán chạy</h3>
                <table class="list_baiviet">
                    <thead style="z-index: 1;">
                        <th style="text-align: left;">Tên sản phẩm</th>
                        <th style="text-align: center; width: 100px;">Số lượng bán</th>
                        <th style="text-align: center; width: 100px;" class="hide_mobile">Giá</th>
                        <th style="text-align: center; width: 100px;" class="hide_mobile">Ngày đăng</th>
                    </thead>
                    <tbody>
                        {list_banchay}
                    </tbody>
                </table>
                <div class="pagination banchay-pagination">{phantrang_banchay}</div>
            </div>
        </div>
    </div>
    {footer}
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Khởi tạo datepicker
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true
            });
        });

        // Hàm khởi tạo biểu đồ
        function initChart(labels, data, elementId, title, type = 'bar', options = {}) {
            const ctx = document.getElementById(elementId).getContext('2d');
            let chartInstance = Chart.getChart(elementId);
            if (chartInstance) chartInstance.destroy();

            const config = {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: type === 'line' ? 'rgba(75, 192, 192, 0.2)' : 'rgba(54, 162, 235, 0.7)',
                        borderColor: type === 'line' ? 'rgba(75, 192, 192, 1)' : 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: type === 'line',
                        borderRadius: type === 'bar' ? 5 : 0,
                        barPercentage: type === 'bar' ? 0.8 : 1
                    }]
                },
                options: {
                    indexAxis: type === 'bar' ? 'y' : 'x',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: type === 'bar' ? 'Số lượng bán' : 'Thời gian'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: type === 'bar' ? 'Tên sản phẩm' : 'Số lượt mua'
                            }
                        }
                    },
                    plugins: {
                        title: { display: true, text: title },
                        legend: { display: false }
                    },
                    ...options
                }
            };

            new Chart(ctx, config);
        }

        // Hàm gọi AJAX để tải dữ liệu
        function loadData(page_banchay = 1) {
            const filter_type = $("select[name=filter_type]").val();
            const time_begin = filter_type === 'custom' ? $("input[name=begin]").val().trim() : '';
            const time_end = filter_type === 'custom' ? $("input[name=end]").val().trim() : '';

            if (filter_type === 'custom') {
                if (time_begin.length < 10) {
                    $("input[name=begin]").focus();
                    alert("Vui lòng chọn thời gian bắt đầu hợp lệ");
                    return;
                }
                if (time_end.length < 10) {
                    $("input[name=end]").focus();
                    alert("Vui lòng chọn thời gian kết thúc hợp lệ");
                    return;
                }
            }

            // Hiển thị overlay loading (nếu có)
            if ($(".load_overlay").length) $(".load_overlay").show();
            if ($(".load_process").length) $(".load_process").fadeIn();

            const form_data = new FormData();
            form_data.append("action", "load_doanhthu_hieu_suat_cuaban");
            form_data.append("filter_type", filter_type);
            form_data.append("time_begin", time_begin);
            form_data.append("time_end", time_end);
            form_data.append("page_banchay", page_banchay);
            form_data.append("ajax", "1");

            $.ajax({
                url: "/ncc/process.php",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (res) {
                    let info;
                    try {
                        info = JSON.parse(res);
                    } catch (e) {
                        console.error("Lỗi phân tích JSON:", e);
                        if ($(".load_process").length) $(".load_process").hide();
                        if ($(".load_overlay").length) $(".load_overlay").hide();
                        alert("Lỗi dữ liệu trả về từ server");
                        return;
                    }

                    setTimeout(() => {
                        if ($(".load_note").length) $(".load_note").html(info.thongbao || "Đang xử lý...");
                    }, 1000);

                    setTimeout(() => {
                        if ($(".load_process").length) $(".load_process").hide();
                        if ($(".load_note").length) $(".load_note").html("Hệ thống đang xử lý");
                        if ($(".load_overlay").length) $(".load_overlay").hide();

                        if (info.ok == 1) {
                            // Cập nhật danh sách bán chạy
                            const htmlBanChay = info.list_banchay.map(item => `
                                <tr>
                                    <td style="text-align: left;">${item.tieu_de}</td>
                                    <td style="text-align: center;">${item.ban}</td>
                                    <td style="text-align: center;" class="hide_mobile">${item.gia_moi}</td>
                                    <td style="text-align: center;" class="hide_mobile">${item.date_post}</td>
                                </tr>`).join('');
                            $('.product-list').find('tbody').html(htmlBanChay);
                            $('.banchay-pagination').html(info.phantrang_banchay || '');

                            // Cập nhật thời gian
                            if (info.filter_type !== 'custom') {
                                $('.custom-time').hide();
                                $("input[name=begin]").val(info.time_begin);
                                $("input[name=end]").val(info.time_end);
                            } else {
                                $('.custom-time').show();
                            }

                            // Cập nhật biểu đồ
                            if (info.labels_banchay.length > 0) {
                                initChart(info.labels_banchay, info.data_banchay, 'chartBanChay', 'Sản phẩm bán chạy', 'bar');
                            }
                            if (info.summary_labels.length > 0) {
                                initChart(info.summary_labels, info.summary_data, 'chartSummary', 'Tổng quan lượt mua', 'line');
                            }

                            // Gắn lại sự kiện cho các liên kết phân trang
                            attachPaginationEvents();
                        } else {
                            console.error("Lỗi từ server:", info.thongbao);
                            alert(info.thongbao || "Lỗi không xác định từ server");
                        }
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error("Lỗi AJAX:", status, error);
                    if ($(".load_process").length) $(".load_process").hide();
                    if ($(".load_overlay").length) $(".load_overlay").hide();
                    alert("Lỗi kết nối đến server");
                }
            });
        }

        // Hàm gắn sự kiện cho các liên kết phân trang
        function attachPaginationEvents() {
            $('.banchay-pagination a').off('click').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href') || '';
                const match = href.match(/page_banchay=(\d+)/);
                const page_banchay = match ? parseInt(match[1]) : 1;
                loadData(page_banchay);
            });
        }

        // Xử lý sự kiện thay đổi loại lọc
        $("select[name=filter_type]").on("change", function () {
            const filter_type = $(this).val();
            if (filter_type === 'custom') {
                $('.custom-time').show();
            } else {
                $('.custom-time').hide();
                loadData(1); // Tải lại dữ liệu khi thay đổi loại lọc
            }
        });

        // Xử lý sự kiện nút Áp dụng
        $("button[name=button_doanhthu_hieu_suat_cuaban]").on("click", function () {
            loadData(1); // Reset trang về 1 khi áp dụng bộ lọc thời gian
        });

        // Khởi tạo dữ liệu ban đầu
        const labelsBanChay = JSON.parse('{labels_banchay}' || '[]');
        const dataBanChay = JSON.parse('{data_banchay}' || '[]');
        const summaryLabels = JSON.parse('{summary_labels}' || '[]');
        const summaryData = JSON.parse('{summary_data}' || '[]');

        if (labelsBanChay.length > 0) initChart(labelsBanChay, dataBanChay, 'chartBanChay', 'Sản phẩm bán chạy', 'bar');
        if (summaryLabels.length > 0) initChart(summaryLabels, summaryData, 'chartSummary', 'Tổng quan lượt mua', 'line');

        // Gắn sự kiện phân trang ban đầu
        attachPaginationEvents();
    </script>