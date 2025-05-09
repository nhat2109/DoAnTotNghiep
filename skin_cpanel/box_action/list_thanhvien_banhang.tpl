<div class="box_right">

    <div class="chart-container" style="width: 50%; margin: auto;">
        <canvas id="chartBanhang"></canvas>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartBanhangInstance = null;

        document.addEventListener("DOMContentLoaded", function () {
            let dataBanhang = getChartDataFromTable();
            updateChart(dataBanhang);
        });

        function getChartDataFromTable() {
            let dataBanhang = { "1": 0, "2": 0, "3": 0 };

            // Count only visible rows
            let rows = document.querySelectorAll(".list_baiviet tr:not(:first-child):not([style*='display: none'])");

            rows.forEach(row => {
                let statusSelect = row.querySelector(".status-select");
                if (statusSelect) {
                    let selectedValue = statusSelect.value;
                    let userId = statusSelect.getAttribute('data-user-id');

                    // If no userId or invalid status, count as Cool (3)
                    if (!userId || !["1", "2", "3"].includes(selectedValue)) {
                        dataBanhang["3"]++;
                    } else {
                        dataBanhang[selectedValue]++;
                    }
                }
            });

            console.log('Updated chart data:', dataBanhang);
            return dataBanhang;
        }

        function updateChart(dataBanhang) {
            const ctx = document.getElementById("chartBanhang").getContext("2d");

            const chartData = {
                labels: ["Hot", "Warm", "Cool"],
                datasets: [{
                    label: "Số lượng",
                    data: [
                        parseInt(dataBanhang["1"]), // Hot
                        parseInt(dataBanhang["2"]), // Warm
                        parseInt(dataBanhang["3"])  // Cool
                    ],
                    backgroundColor: ["#dc3545", "#ffc107", "#17a2b8"],
                    borderColor: ["#bd2130", "#d39e00", "#0f6674"],
                    borderWidth: 1,
                    barPercentage: 0.5, // Make bars thinner
                    categoryPercentage: 0.5 // Adjust space between bars
                }]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "Biểu đồ trạng thái bán hàng",
                        font: { size: 16 }
                    },
                    legend: {
                        display: false // Hide legend since colors are self-explanatory
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 18 // Adjust font size of x-axis labels
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                            precision: 0 // Show only whole numbers
                        }
                    }
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            };

            if (chartBanhangInstance) {
                chartBanhangInstance.data = chartData;
                chartBanhangInstance.options = chartOptions;
                chartBanhangInstance.update();
            } else {
                chartBanhangInstance = new Chart(ctx, {
                    type: "bar",
                    data: chartData,
                    options: chartOptions
                });
            }
        }

        function initializeStatusSelects() {
            $('.status-select').off('change').on('change', function () {
                const $select = $(this);
                const userId = $select.attr('data-user-id');
                const newStatus = $select.val();
                const oldStatus = $select.data('previous-status') || '3';

                if (!userId) {
                    $select.val('3');
                    alert('Không thể thay đổi trạng thái cho mục này');
                    return;
                }

                $select.data('previous-status', newStatus);


                $select.removeClass('status-1 status-2 status-3').addClass('status-' + newStatus);

                $.ajax({
                    url: '/admincp/process.php',
                    type: 'POST',
                    data: {
                        action: 'update_status_banhang',
                        user_id: userId,
                        status: newStatus,
                        old_status: oldStatus
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.ok) {

                            $select.css('box-shadow', '0 0 5px #28a745');
                            setTimeout(() => {
                                $select.css('box-shadow', 'none');
                            }, 1000);


                            const newData = getChartDataFromTable();
                            updateChart(newData);

                        } else {
                            alert('Lỗi: ' + (response.error || 'Không thể cập nhật trạng thái'));

                            $select.val(oldStatus)
                                .removeClass('status-1 status-2 status-3')
                                .addClass('status-' + oldStatus);


                            const newData = getChartDataFromTable();
                            updateChart(newData);
                        }
                    },
                    error: function () {
                        alert('Lỗi kết nối server');

                        $select.val(oldStatus)
                            .removeClass('status-1 status-2 status-3')
                            .addClass('status-' + oldStatus);


                        const newData = getChartDataFromTable();
                        updateChart(newData);
                    }
                });
            });
        }

        // Make sure to initialize on document ready and after search
        $(document).ready(function () {
            initializeStatusSelects();
            const initialData = getChartDataFromTable();
            updateChart(initialData);
        });
    </script>


    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
            <div class="box_timkiem">
                <label>Từ ngày <input type="date" class="form-control" name="from_date"></label>
                <label>Đến ngày <input type="date" class="form-control" name="to_date"></label>
                <button class="btn btn-light btn-filter"><i class="fa-solid fa-filter"></i> Lọc</button>

                <form method="POST" id="searchForm" action="/admincp/process.php">
                    <input type="hidden" name="action" value="timkiem_thanhvien_banhang">
                    <select name="status" id="status_khach">
                        <option value="">Tất cả</option>
                        <option value="1" {status_1}>Hot</option>
                        <option value="2" {status_2}>Warm</option>
                        <option value="3" {status_3}>Cool</option>
                    </select>
                    <input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
                    <button type="submit" class="button_timkiem">Tìm kiếm</button>
                </form>
            </div>
            <div class="page_title">
                <h1 class="undefined">Danh sách bán hàng</h1>
                <div style="clear: both;"></div>
                <div class="line"></div>
                <hr>
            </div>
            <script>
                function filterData(filterParams) {
                    $.ajax({
                        url: '/admincp/process.php',
                        type: 'POST',
                        data: filterParams,
                        dataType: 'json',
                        beforeSend: function () {
                            $('.list_baiviet').html('<tr><td colspan="10" class="text-center">Đang tải...</td></tr>');
                        },
                        success: function (response) {
                            if (response.ok) {
                                // Add header row back before the filtered data
                                const headerRow = '<tr>' +
                                    '<th class="hide_mobile">STT</th>' +
                                    '<th>Người quản lí</th>' +
                                    '<th>Tên khách hàng</th>' +
                                    '<th class="hide_mobile">Điện thoại</th>' +
                                    '<th class="hide_mobile">Ngày thêm</th>' +
                                    '<th class="hide_mobile">Lần chăm sóc gần nhất</th>' +
                                    '<th class="hide_mobile">Người chăm sóc</th>' +
                                    '<th class="hide_mobile">TK chính</th>' +
                                    '<th class="hide_mobile">Doanh số</th>' +
                                    '<th class="hide_mobile">Tình trạng</th>' +
                                    '</tr>';

                                $('.list_baiviet').html(headerRow + response.list);

                                // Initialize status selects for new content
                                initializeStatusSelects();

                                // Update chart with new data
                                const newData = getChartDataFromTable();
                                updateChart(newData);
                            } else {
                                alert(response.error || 'Không tìm thấy dữ liệu');
                                $('.list_baiviet').html('<tr><td colspan="10" class="text-center">Không tìm thấy dữ liệu</td></tr>');
                                updateChart({ "1": 0, "2": 0, "3": 0 });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', error);
                            console.log('Server response:', xhr.responseText); // Add this for debugging
                            $('.list_baiviet').html('<tr><td colspan="10" class="text-center">Có lỗi xảy ra</td></tr>');
                            updateChart({ "1": 0, "2": 0, "3": 0 });
                        }
                    });
                }
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
            </script>

            <table class="list_baiviet">
                <tr>
                    <th class="hide_mobile">STT</th>
                    <th>Người quản lí</th>
                    <th>Tên khách hàng</th>
                    <th class="hide_mobile">Điện thoại</th>
                    <th class="hide_mobile">Ngày thêm</th>
                    <th class="hide_mobile">Lần chăm sóc gần nhất</th>
                    <th class="hide_mobile">Người chăm sóc</th>
                    <th class="hide_mobile">TK chính</th>
                    <th class="hide_mobile">Doanh số</th>
                    <th class="hide_mobile">Tình trạng</th>
                </tr>
                {list_thanhvien_banhang}
            </table>
            {phantrang}
        </div>
    </div>
</div>
<!-- Thêm CSS cho trạng thái -->
<script>
    $(document).ready(function () {
        console.log('Total rows:', $('.list_baiviet tr').length);

        $('#status_khach').change(function () {
            const selectedStatus = $(this).val();
            console.log('Selected status:', selectedStatus);

            $('.list_baiviet tr').each(function (index) {
                if (index === 0) return;

                const row = $(this);
                const statusSelect = row.find('.status-select');
                const currentStatus = statusSelect.val();

                console.log('Row', index, 'Status:', currentStatus);

                if (!selectedStatus || currentStatus === selectedStatus) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });


        function initializeStatusSelects() {
            $('.status-select').off('change').on('change', function () {
                const $select = $(this);
                const userId = $select.attr('data-user-id');
                const newStatus = $select.val();
                const oldStatus = $select.data('previous-status') || '3';

                if (!userId) {
                    $select.val('3');
                    alert('Không thể thay đổi trạng thái cho trạng thái này!');
                    return;
                }

                // Update all rows with same user_id
                $('.status-select[data-user-id="' + userId + '"]').each(function () {
                    $(this).val(newStatus)
                        .removeClass('status-1 status-2 status-3')
                        .addClass('status-' + newStatus)
                        .data('previous-status', newStatus);
                });

                $.ajax({
                    url: '/admincp/process.php',
                    type: 'POST',
                    data: {
                        action: 'update_status_banhang',
                        user_id: userId,
                        status: newStatus,
                        old_status: oldStatus
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.ok) {
                            // Success feedback for all matching selects
                            $('.status-select[data-user-id="' + userId + '"]').each(function () {
                                $(this).css('box-shadow', '0 0 5px #28a745');
                                setTimeout(() => {
                                    $(this).css('box-shadow', 'none');
                                }, 1000);
                            });

                            // Recalculate and update chart
                            const newData = getChartDataFromTable();
                            updateChart(newData);
                        } else {
                            alert('Lỗi: ' + (response.error || 'Không thể cập nhật trạng thái'));
                            // Rollback all matching selects
                            $('.status-select[data-user-id="' + userId + '"]').each(function () {
                                $(this).val(oldStatus)
                                    .removeClass('status-1 status-2 status-3')
                                    .addClass('status-' + oldStatus)
                                    .data('previous-status', oldStatus);
                            });

                            // Recount and update chart
                            const newData = getChartDataFromTable();
                            updateChart(newData);
                        }
                    },
                    error: function () {
                        alert('Lỗi kết nối server');
                        // Rollback all matching selects
                        $('.status-select[data-user-id="' + userId + '"]').each(function () {
                            $(this).val(oldStatus)
                                .removeClass('status-1 status-2 status-3')
                                .addClass('status-' + oldStatus)
                                .data('previous-status', oldStatus);
                        });

                        // Recount and update chart
                        const newData = getChartDataFromTable();
                        updateChart(newData);
                    }
                });
            });
        }


        $('#searchForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/admincp/process.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function () {
                    $('.list_baiviet').html('<tr><td colspan="10" class="text-center">Đang tải...</td></tr>');
                },
                success: function (response) {
                    if (response.ok) {
                        $('.list_baiviet').html(response.list);

                        // Initialize status selects for new content
                        initializeStatusSelects();

                        // Get fresh data from table and update chart
                        const newData = getChartDataFromTable();
                        updateChart(newData);
                    } else {
                        $('.list_baiviet').html('<tr><td colspan="10" class="text-center">Không tìm thấy dữ liệu</td></tr>');
                        // Reset chart when no data
                        updateChart({ "1": 0, "2": 0, "3": 0 });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('.list_baiviet').html('<tr><td colspan="10" class="text-center">Có lỗi xảy ra</td></tr>');
                    // Reset chart on error
                    updateChart({ "1": 0, "2": 0, "3": 0 });
                }
            });
        });
    });
</script>
<style>
    /* Table styling */
    .list_baiviet {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .list_baiviet th {
        background: #f8f9fa;
        padding: 12px 15px;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    .list_baiviet td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .list_baiviet tr:hover {
        background-color: #f8f9fa;
    }

    /* Status select styling */
    .status-select {
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-weight: 500;
        cursor: pointer;
        width: 90px;
        text-align: center;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 12px;
        padding-right: 28px;
    }

    /* Status colors */
    .status-1 {
        background-color: #dc3545 !important;
        color: white !important;
        border-color: #dc3545 !important;
    }

    .status-2 {
        background-color: #ffc107 !important;
        color: #000 !important;
        border-color: #ffc107 !important;
    }

    .status-3 {
        background-color: #17a2b8 !important;
        color: white !important;
        border-color: #17a2b8 !important;
    }

    /* Search box improvements */
    .box_timkiem {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .box_timkiem label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .box_timkiem input[type="date"],
    .box_timkiem select,
    .box_timkiem input[type="text"] {
        height: 36px;
        padding: 0 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .box_timkiem .btn-filter,
    .box_timkiem .button_timkiem {
        height: 36px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.2s;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .hide_mobile {
            display: none;
        }
        
        .box_timkiem {
            flex-direction: column;
            align-items: stretch;
        }

        .box_timkiem input[type="date"],
        .box_timkiem select,
        .box_timkiem input[type="text"] {
            width: 100%;
        }

        .status-select {
            width: 100%;
        }
    }
</style>