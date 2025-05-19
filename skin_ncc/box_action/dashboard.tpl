<style>
    .chart-container {
        background: #fff;
        padding: 30px;
        border-radius: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);


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
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
            <div class="box_list_donhang">
                <div class="box_list_right">
                    <div class="title">Đơn hàng của bạn</div>
                    <div class="list_donhang scroll">
                        {list_donhang_cuaban}
                    </div>
                </div>
                
            </div>
            <div class="box_time">
                <h2>Thống kê đơn hàng của bạn</h2>
                <div class="list_time">
                    <div class="li_time">
                        <label>Thời gian bắt đầu</label>
                        <input type="text" class="datepicker" value="{begin}" name="begin"
                            placeholder="Chọn thời gian bắt đầu">
                    </div>
                    <div class="li_time">
                        <label>Thời gian kết thúc</label>
                        <input type="text" class="datepicker" value="{end}" name="end"
                            placeholder="Chọn thời gian kết thúc">
                    </div>
                    <div class="li_time">
                        <button name="button_doanhthu_cuaban">Áp dụng</button>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <!-- <h2>Thống kê đơn hàng của bạn</h2> -->
                <canvas id="orderChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    function initChart(doanhthuData, donhangData) {
        const ctx = document.getElementById('orderChart').getContext('2d');
        let chartInstance = Chart.getChart('orderChart');
        if (chartInstance) {
            chartInstance.destroy();
        }

        const data = {
            labels: [
                "Đơn hàng hoàn thành",
                "Đơn hàng chờ xử lý",
                "Đơn hàng đã tiếp nhận",
                "Đơn hàng đang giao",
                "Đơn hàng hủy",
                "Đơn hàng hoàn trả"
            ],
            datasets: [{
                label: "Tổng tiền (đ)",
                data: [
                    parseFloat(doanhthuData.doanhthu_hoanthanh) || 0,
                    parseFloat(doanhthuData.doanhthu_cho) || 0,
                    parseFloat(doanhthuData.doanhthu_tiepnhan) || 0,
                    parseFloat(doanhthuData.doanhthu_giao) || 0,
                    parseFloat(doanhthuData.doanhthu_huy) || 0,
                    parseFloat(doanhthuData.doanhthu_hoan) || 0
                ],
                backgroundColor: [
                    "rgba(40, 167, 69, 0.85)",
                    "rgba(255, 193, 7, 0.85)",
                    "rgba(111, 66, 193, 0.85)",
                    "rgba(253, 126, 20, 0.85)",
                    "rgba(220, 53, 69, 0.85)",
                    "rgba(23, 162, 184, 0.85)"
                ],
                borderColor: [
                    "rgba(40, 167, 69, 1)",
                    "rgba(255, 193, 7, 1)",
                    "rgba(111, 66, 193, 1)",
                    "rgba(253, 126, 20, 1)",
                    "rgba(220, 53, 69, 1)",
                    "rgba(23, 162, 184, 1)"
                ],
                borderWidth: 1.5,
                borderRadius: 12,
                borderSkipped: false,
                barThickness: "flex",
                maxBarThickness: 50
            }]
        };

        const orderCounts = [
            parseInt(donhangData.donhang_hoanthanh) || 0,
            parseInt(donhangData.donhang_cho) || 0,
            parseInt(donhangData.donhang_tiepnhan) || 0,
            parseInt(donhangData.donhang_giao) || 0,
            parseInt(donhangData.donhang_huy) || 0,
            parseInt(donhangData.donhang_hoan) || 0
        ];

        const options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Tổng tiền (đ)",
                        font: { size: 14, weight: '600', family: 'Inter' },
                        color: '#1a1f46'
                    },
                    ticks: {
                        callback: value => value.toLocaleString("vi-VN") + " đ",
                        color: '#1a1f46',
                        font: { size: 12, family: 'Inter' }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false }
                },
                x: {
                    title: {
                        display: true,
                        text: "Trạng thái đơn hàng",
                        font: { size: 14, weight: '600', family: 'Inter' },
                        color: '#1a1f46'
                    },
                    ticks: {
                        color: '#1a1f46',
                        font: { size: 12, family: 'Inter' },
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: { display: false }
                }
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(26, 31, 70, 0.9)',
                    titleFont: { size: 14, family: 'Inter', weight: '700' },
                    bodyFont: { size: 12, family: 'Inter' },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function (tooltipItem) {
                            const index = tooltipItem.dataIndex;
                            return `${tooltipItem.label}: ${tooltipItem.raw.toLocaleString("vi-VN")} đ (với ${orderCounts[index]} đơn hàng)`;
                        }
                    }
                },
                legend: { display: false }
            },
            animation: { duration: 2000, easing: 'easeOutCubic' },
            elements: {
                bar: {
                    shadowColor: 'rgba(0, 0, 0, 0.2)',
                    shadowBlur: 8,
                    shadowOffsetX: 2,
                    shadowOffsetY: 4
                }
            },
            hover: { animationDuration: 400 }
        };

        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    }


    const initialData = {
        doanhthu: {
            doanhthu_hoanthanh: '{doanhthu_hoanthanh}',
            doanhthu_cho: '{doanhthu_cho}',
            doanhthu_tiepnhan: '{doanhthu_tiepnhan}',
            doanhthu_giao: '{doanhthu_giao}',
            doanhthu_huy: '{doanhthu_huy}',
            doanhthu_hoan: '{doanhthu_hoan}'
        },
        donhang: {
            donhang_hoanthanh: '{donhang_hoanthanh}',
            donhang_cho: '{donhang_cho}',
            donhang_tiepnhan: '{donhang_tiepnhan}',
            donhang_giao: '{donhang_giao}',
            donhang_huy: '{donhang_huy}',
            donhang_hoan: '{donhang_hoan}'
        }
    };


    initChart(initialData.doanhthu, initialData.donhang);
</script>