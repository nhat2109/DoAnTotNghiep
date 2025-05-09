<style>
    .box_kichhoat {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .box_kichhoat_content {
        position: relative;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        max-width: 500px;
        width: 90%;
    }

    .close_modal {
        position: absolute;
        text-align: center;
        line-height: 25px;
        top: 10px;
        right: 14px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #fff;
        background-color: red;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3sease;
    }

    .close_modal:hover {
        background-color: darkred;
        transform: scale(1.1);
    }

    .timer-display {
        animation: fadeInOut 1s infinite;
    }

    @keyframes fadeInOut {
        0% {
            opacity: 0.7;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.7;
        }
    }

    .loading {
        color: #0066cc;
        padding: 10px;
        text-align: center;
    }

    .error {
        color: #ff0000;
        padding: 10px;
        text-align: center;
    }

    .box_sotien input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 10px;
    }

    #xacnhan_kichhoat,
    #sudung_sodu {
        background: #ff0000;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    #xacnhan_kichhoat:hover,
    #sudung_sodu:hover {
        background: #cc0000;
    }

    @media (max-width: 768px) {
        .box_kichhoat {
            width: 90%;
            padding: 10px;
        }

        .box_kichhoat_content {
            font-size: 14px;
        }

        .box_thongbao {
            max-width: 100%;
            padding: 10px;
            font-size: 13px;
        }

        .box_thongbao p,
        .box_thongbao ul {
            font-size: 12px;
        }

        .list_action button {
            width: 100%;
            font-size: 14px;
            padding: 8px;
        }

        .box_sotien input {
            width: 100%;
            font-size: 14px;
        }

        .title {
            font-size: 16px;
            text-align: center;
        }

        .close_modal {
            font-size: 18px;
            right: 10px;
            top: 10px;
        }
    }
</style>

<div class="box_kichhoat" style="{display_kh}">
    <div class="box_kichhoat_content">


        <span class="close_modal" style="{display_close}">&times;</span>

        <div class="title">Kích hoạt tài khoản</div>
        <div style="text-align: left; margin-top: 10px;">
            <div class="box_thongbao"
                style="max-width: 600px; background: #fff9e6; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
                <div style="text-align: center; font-size: 16px; font-weight: bold; color: #d9534f; ">
                    🔔 THÔNG BÁO PHÍ KÍCH HOẠT TÀI KHOẢN – CÔNG TY CỔ PHẦN SÓC ĐỎ 🔔
                </div>

                <p><b>Kính gửi Quý Nhà bán,</b></p>
                <p>Từ ngày <b>15/03/2025</b>, khi đăng ký trở thành Đại lý/ Nhà bán hàng trên <b>Socdo.vn</b>, Quý
                    Nhà bán sẽ được trải nghiệm miễn phí <b>15 ngày</b>. Sau thời gian này, để tiếp tục sử dụng nền
                    tảng, Quý Nhà bán cần đóng <b>phí kích hoạt tài khoản 500.000 VNĐ</b> (chỉ đóng một lần duy
                    nhất).</p>

                <p><b>Các chính sách hỗ trợ gia tăng dành cho Đại lý/ Nhà bán hàng Sóc Đỏ:</b></p>
                <ul style="padding-left: 20px; margin: 0;">
                    <li>✅ Nâng cấp và bổ sung các tính năng hỗ trợ bán hàng chuyên nghiệp.</li>
                    <li>✅ Mở rộng cơ hội tiếp cận nguồn hàng, khách hàng tiềm năng và gia tăng thu nhập.</li>
                    <li>✅ Cải tiến công nghệ, mang lại trải nghiệm tối ưu nhất cho Nhà bán/Đại lý.</li>
                </ul>

                <p>Chúng tôi cam kết luôn đồng hành cùng Quý Nhà bán, giúp bạn kinh doanh hiệu quả và phát triển bền
                    vững.</p>

                <p style="text-align: center; font-weight: bold; color: #d9534f;">📌 Mọi thắc mắc, vui lòng liên hệ:
                </p>
                <p style="text-align: center; font-weight: bold;">
                    Hotline: <span style="color: #337ab7;">0943.05.18.18</span> <br>
                    Email: <span style="color: #337ab7;">socdogroup@gmail.com</span>
                </p>
            </div>
        </div>

        <div style="text-align: center; font-weight: 700;">
            <div class="list_action">
                <button id="xacnhan_kichhoat" style="margin-bottom: 10px; display:none;">Nạp tiền</button>
                <!-- xử lý tại đây -->
                <button id="sudung_sodu">Kích hoạt</button>
            </div>

            <div style="clear: both;"></div>
            <span style="margin-bottom: 10px; display:none;">Khuyến mại: <span>{user_money2} đ</span></span>
        </div>

        <div class="box_xuly"></div>
        <div class="box_sotien" style="margin-bottom: 10px; display:none;">
            <input type="text" class="price_format" name="so_tien" placeholder="Số tiền nạp">
        </div>
    </div>

</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const boxKichHoat = document.querySelector(".box_kichhoat");
        const closeModal = document.querySelector(".close_modal");

        // Thời gian 6 tiếng (tính theo mili giây)
        const SIX_HOURS = 6 * 60 * 60 * 1000;

        // Lấy thời gian hiện tại
        const now = new Date().getTime();

        // Lấy thời gian lần cuối hộp thoại hiển thị từ localStorage
        const lastShownTime = localStorage.getItem("box_kichhoat_last_shown");

        // Kiểm tra nếu chưa lưu hoặc đã quá 6 tiếng kể từ lần hiển thị trước
        if (!lastShownTime || now - lastShownTime > SIX_HOURS) {
            // Hiển thị hộp thoại
            boxKichHoat.style.display = "block";

            // Lưu thời gian hiển thị vào localStorage
            localStorage.setItem("box_kichhoat_last_shown", now);
        } else {
            // Ẩn hộp thoại nếu chưa đủ 6 tiếng
            boxKichHoat.style.display = "none";
        }

        // Khi bấm nút đóng hộp thoại
        closeModal.addEventListener("click", function () {
            boxKichHoat.style.display = "none";

            // Cập nhật lại thời gian đóng vào localStorage
            localStorage.setItem("box_kichhoat_last_shown", new Date().getTime());
        });
    });
</script>