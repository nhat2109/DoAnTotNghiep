<!-- Popup kích hoạt tài khoản -->
<div class="box_kichhoat" style="{display_kh}">
    <div class="box_kichhoat_content">
        <span class="close_modal" style="{display_close}">×</span>
        <div class="title">Kích hoạt tài khoản</div>
        <div style="text-align: left; margin-top: 10px;">
            <div class="box_thongbao"
                style="max-width: 600px; background: #fff9e6; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
                <div style="text-align: center; font-size: 16px; font-weight: bold; color: #d9534f;">
                    🔔 THÔNG BÁO PHÍ KÍCH HOẠT TÀI KHOẢN NHÀ BÁN HÀNG - SÀN TMĐT SOCDO.VN 🔔
                </div>
                <p><b>Kính gửi: Quý Nhà Bán,</b></p>
                <p>Khi đăng ký trở thành đối tác bán hàng trên sàn TMĐT <b>Socdo.vn</b>, Quý Nhà Bán sẽ được <b>trải
                        nghiệm MIỄN PHÍ trong 07 ngày</b>.</p>
                <p>- Sau thời gian này, để tiếp tục sử dụng nền tảng, Quý Nhà Bán cần <b>kích hoạt tài khoản</b> với mức
                    phí <b>2.500.000 VNĐ</b>.</p>
                <p><b>Quyền lợi đặc biệt khi kích hoạt tài khoản:</b></p>
                <ul style="padding-left: 20px; margin: 0;">
                    <li>✅ Cung cấp một <b>website riêng chuyên nghiệp</b> với đầy đủ tính năng</li>
                    <li>✅ <b>Mở rộng cơ hội tiếp cận</b> khách hàng đa kênh</li>
                    <li>✅ <b>Đồng bộ sản phẩm</b> với toàn bộ hệ sinh thái sàn thuộc hệ thống <b>Socdo.vn</b></li>
                </ul>
                <p>Chúng tôi cam kết <b>luôn đồng hành cùng Quý Nhà Bán</b>, hỗ trợ bạn <b>kinh doanh hiệu quả và phát
                        triển bền vững</b>.</p>
                <p style="text-align: center; font-weight: bold; color: #d9534f;">📌 Mọi thắc mắc vui lòng liên hệ:</p>
                <p style="text-align: center; font-weight: bold;">
                    Hotline: <span style="color: #337ab7;">0943.05.18.18</span> <br>
                    Email: <span style="color: #337ab7;">hotro@socdo.vn</span>
                </p>
            </div>
        </div>
        <div style="text-align: center; font-weight: 700;">
            <div class="list_action">
                <button id="xacnhan_kichhoat" style="margin-bottom: 10px; display:none;">Nạp tiền</button>
                <button id="sudung_sodu">Kích hoạt</button>
            </div>
            <div style="clear: both;"></div>
            <span style="margin-bottom: 10px; display:none;">Khuyến mại: <span>{user_money2} đ</span></span>
        </div>
        <div class="box_confirm" style="display: none;">
            <div class="box_confirm_content">
                <div class="title" style="color: #d9534f; font-weight: bold; text-align: center;">
                    Xác nhận kích hoạt tài khoản
                </div>
                <div style="text-align: center; margin: 20px 0;">
                    Bạn có chắc chắn muốn kích hoạt tài khoản này?
                </div>
                <div style="text-align: center;">
                    <button id="confirm_yes"
                        style="background: #ff0000; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-right: 10px;">Thực
                        hiện</button>
                    <button id="confirm_no"
                        style="background: #0066cc; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Hủy</button>
                </div>
            </div>
        </div>
        <div class="box_xuly"></div>
        <div class="box_sotien" style="margin-bottom: 10px; display:none;">
            <input type="text" class="price_format" name="so_tien" placeholder="Số tiền nạp">
        </div>
    </div>
</div>

<!-- CSS -->
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

    .box_confirm {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 10000;
        justify-content: center;
        align-items: center;
    }

    .box_confirm_content {
        background: white;
        padding: 20px;
        border-radius: 5px;
        min-width: 300px;
    }

    .box_xuly {
        margin-top: 10px;
        text-align: center;
    }

    #confirm_yes:hover {
        background: #cc0000;
    }

    #confirm_no:hover {
        background: #004d99;
    }
</style>
<!-- JavaScript -->
<!-- <script>

    $(document).ready(function () {
        // Khai báo biến toàn cục
        const $boxKichHoat = $('.box_kichhoat');
        const $body = $('body');

        // Hàm hiển thị popup (export để có thể gọi từ file khác)
        window.showKichHoatPopup = function () {
            $boxKichHoat.fadeIn(300).css({
                'display': 'flex',
                'background-color': 'rgba(0, 0, 0, 0.5)',
                'z-index': '9999'
            });
            $body.css('overflow', 'hidden');
        };

        // Hàm ẩn popup
        function hideKichHoatPopup() {
            $boxKichHoat.fadeOut(300);
            $body.css('overflow', 'auto');
        }

        // Xử lý click nút đóng
        $('.close_modal').on('click', function () {
            hideKichHoatPopup();
        });

        // Xử lý click ra ngoài popup
        $boxKichHoat.on('click', function (e) {
            if ($(e.target).is($boxKichHoat)) {
                hideKichHoatPopup();
            }
        });

        // Ngăn sự kiện click lan ra ngoài content
        $('.box_kichhoat_content').on('click', function (e) {
            e.stopPropagation();
        });

        // Thêm phím tắt ESC để đóng
        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                hideKichHoatPopup();
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
    const $boxKichHoat = $('.box_kichhoat'); // Lấy phần tử popup
    const $body = $('body'); // Lấy phần tử body (để khóa cuộn khi popup hiện)

    // Hàm để hiện popup
    window.showKichHoatPopup = function () {
        $boxKichHoat.css({
            'display': 'flex', // Hiện popup
            'background-color': 'rgba(0, 0, 0, 0.5)', // Lớp phủ mờ
            'z-index': '9999', // Đảm bảo popup nằm trên cùng
            'position': 'fixed', // Che toàn màn hình
            'top': '0',
            'left': '0',
            'width': '100%',
            'height': '100%',
            'justify-content': 'center',
            'align-items': 'center'
        }).fadeIn(300); // Hiệu ứng hiện mượt mà
        $body.css('overflow', 'hidden'); // Khóa cuộn khi popup hiện
    };

    // Gắn sự kiện bấm cho nút "Kích hoạt tài khoản"
    $('.open_modal').off('click').on('click', function (e) {
        e.preventDefault(); // Ngăn hành vi mặc định của nút
        e.stopPropagation(); // Ngăn sự kiện lan ra ngoài
        window.showKichHoatPopup(); // Gọi hàm hiện popup
    });

    // Đóng popup khi bấm nút "X"
    $('.close_modal').on('click', function () {
        $boxKichHoat.fadeOut(300); // Ẩn popup mượt mà
        $body.css('overflow', 'auto'); // Bật lại cuộn
    });

    // Đóng popup khi bấm ra ngoài nội dung popup
    $boxKichHoat.on('click', function (e) {
        if ($(e.target).is($boxKichHoat)) {
            $boxKichHoat.fadeOut(300); // Ẩn popup
            $body.css('overflow', 'auto'); // Bật lại cuộn
        }
    });

    // Ngăn bấm trong nội dung popup làm đóng popup
    $('.box_kichhoat_content').on('click', function (e) {
        e.stopPropagation(); // Ngăn sự kiện lan ra ngoài
    });

    // Đóng popup bằng phím ESC
    $(document).keyup(function (e) {
        if (e.key === "Escape") {
            $boxKichHoat.fadeOut(300); // Ẩn popup
            $body.css('overflow', 'auto'); // Bật lại cuộn
        }
    });
});
</script> -->


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let countdownInterval;
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

        // Hàm đếm ngược
        function startCountdown(duration, display) {
            let timer = duration;

            // Clear interval cũ nếu có
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }

            countdownInterval = setInterval(function () {
                const minutes = parseInt(timer / 60, 10);
                const seconds = parseInt(timer % 60, 10);

                display.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    // Xử lý khi hết thời gian
                }
            }, 1000);
        }

        // Cleanup khi đóng modal
        closeModal.addEventListener("click", function () {
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            boxKichHoat.style.display = "none";
            localStorage.setItem("box_kichhoat_last_shown", new Date().getTime());
        });
    });
</script>

<script>
    // Đặt biến toàn cục cho countdown và trạng thái popup
    window.countdownInterval = null;
    window.isPopupVisible = false;

    $(document).ready(function () {
        const $boxKichHoat = $('.box_kichhoat');
        const $body = $('body');

        // Hàm hiển thị popup
        window.showKichHoatPopup = function () {
            // Kiểm tra nếu đang ở trang dashboard
            if ($('.box_right_content').length) {
                // Lưu scroll position hiện tại
                const scrollPos = $(window).scrollTop();

                $boxKichHoat.css({
                    'display': 'flex',
                    'background-color': 'rgba(0, 0, 0, 0.5)',
                    'z-index': '9999',
                    'position': 'fixed',
                    'top': '0',
                    'left': '0',
                    'width': '100%',
                    'height': '100%',
                    'justify-content': 'center',
                    'align-items': 'center'
                }).fadeIn(300);

                // Khóa scroll của dashboard
                $body.css('overflow', 'hidden');
                window.isPopupVisible = true;

                // Đảm bảo popup hiển thị trên cùng
                $boxKichHoat.appendTo('body');
            }
        };

        // Hàm ẩn popup
        function hideKichHoatPopup() {
            $boxKichHoat.fadeOut(300);
            $body.css('overflow', 'auto');
            window.isPopupVisible = false;

            // Clear countdown nếu có
            if (window.countdownInterval) {
                clearInterval(window.countdownInterval);
            }
        }

        // Xử lý đóng popup
        $('.close_modal').on('click', hideKichHoatPopup);

        // Click outside to close
        $boxKichHoat.on('click', function (e) {
            if ($(e.target).is($boxKichHoat)) {
                hideKichHoatPopup();
            }
        });

        // Ngăn click trong popup lan ra ngoài
        $('.box_kichhoat_content').on('click', function (e) {
            e.stopPropagation();
        });

        // ESC key to close
        $(document).keyup(function (e) {
            if (e.key === "Escape" && window.isPopupVisible) {
                hideKichHoatPopup();
            }
        });

        // Xử lý reload trang
        $(window).on('beforeunload', function () {
            if (window.countdownInterval) {
                clearInterval(window.countdownInterval);
            }
        });
    });
</script>
<!-- js của  ẩn hiện menu -->
<script>
    $(document).ready(function () {
        // Nếu chưa có giá trị lưu trong localStorage => mặc định mở tất cả menu
        var stored = localStorage.getItem('open_menus');
        if (!stored) {
            var openMenus = [];
            $('.main_menu .title').each(function () {
                var id = $(this).attr('id');
                if (id) {
                    $(this).addClass('active');               // Thêm active cho tiêu đề
                    $(this).next('.list_menu').show();          // Hiển thị danh sách
                    openMenus.push(id);
                }
            });
            localStorage.setItem('open_menus', JSON.stringify(openMenus));
        } else {
            var openMenus = JSON.parse(stored);
            // Duyệt qua mỗi tiêu đề: nếu id có trong mảng lưu, mở menu tương ứng
            $('.main_menu .title').each(function () {
                var id = $(this).attr('id');
                if (openMenus.indexOf(id) !== -1) {
                    $(this).addClass('active');
                    $(this).next('.list_menu').show();
                }
            });
        }

        // Bind sự kiện click để toggle menu
        $('.main_menu .title').off('click').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            $this.toggleClass('active');
            $this.next('.list_menu').slideToggle(300);

            var titleId = $this.attr('id');
            if (!titleId) {
                console.warn("Menu title không có id:", $this);
                return; // Yêu cầu mỗi menu phải có id để lưu trạng thái
            }

            var openMenus = JSON.parse(localStorage.getItem('open_menus')) || [];
            if ($this.hasClass('active')) {
                // Nếu menu mở, thêm id nếu chưa có
                if ($.inArray(titleId, openMenus) === -1) {
                    openMenus.push(titleId);
                }
            } else {
                // Nếu menu đóng, loại bỏ id khỏi mảng
                openMenus = openMenus.filter(function (id) {
                    return id !== titleId;
                });
            }
            localStorage.setItem('open_menus', JSON.stringify(openMenus));
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash) {
            const targetElement = document.querySelector(window.location.hash);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });

                // Thêm viền đỏ cho thẻ <tbody> bên trong phần tử mục tiêu
                const tbodyElement = targetElement.querySelector('tbody');
                if (tbodyElement) {
                    tbodyElement.style.border = '5px solid red';
                }
            }
        }
    });

</script>
<script>
    $(document).ready(function () {
        const modal = $('.box_kichhoat');
        const modalContent = $('.box_kichhoat_content');
        const closeModal = $('.close_modal');
        const $countdownTimer = $('#custom-countdown-timer');
        const endTime = parseInt($countdownTimer.attr('data-time'), 10) * 1000;
        let countdownInterval;

        function showExpiredModal() {
            // Hiển thị modal với backdrop
            modal.fadeIn(300).css({
                'display': 'flex',
                'background-color': 'rgba(0, 0, 0, 0.8)', // Làm tối nền
                'z-index': '9999' // Đảm bảo hiển thị trên cùng
            });

            // Ẩn nút đóng
            closeModal.hide();


            // Vô hiệu hóa tất cả tương tác nền
            $('.box_kichhoat').css({
                'pointer-events': 'all'
            });

            // Cho phép tương tác với content modal
            modalContent.css({
                'pointer-events': 'auto',
                'position': 'relative',
                'z-index': '10000'
            });

            // Vô hiệu hóa tất cả trừ nút kích hoạt và box_xuly
            modalContent.find('*:not(#sudung_sodu, .box_xuly, .box_xuly *)').css({
                'pointer-events': 'none',
                'opacity': '1'
            });

            // Làm nổi bật nút kích hoạt
            $('#sudung_sodu').css({
                'pointer-events': 'auto',
                'opacity': '1',
                'background': '#ff0000',
                'transform': 'scale(1.05)',
                'box-shadow': '0 0 10px rgba(255, 0, 0, 0.5)',
                'transition': 'all 0.3s ease'
            });

            // Thêm thông báo hết hạn
            if (!$('.warning-message').length) {
                $('.box_thongbao').prepend(`
            <div class="warning-message" style="background: #fff3cd; color: #856404; padding: 15px; margin-bottom: 15px; border-radius: 4px; text-align: center;">
                <strong>⚠️ Đã hết thời gian dùng thử!</strong><br>
                Vui lòng kích hoạt để tiếp tục sử dụng.
            </div>
        `);
            }

            // Thêm handler để chặn click outside
            modal.off('click').on('click', function (e) {
                if ($(e.target).is(modal)) {
                    return false;
                }
            });
        }
        function updateCountdown() {
            let now = new Date().getTime();
            let timeLeft = endTime - now;

            if (timeLeft <= 0) {
                $countdownTimer.text("Hết thời gian!");
                showExpiredModal();
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }

                return;
            }

            let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            $('.custom_days').text(days.toString().padStart(2, '0'));
            $('.custom_hours').text(hours.toString().padStart(2, '0'));
            $('.custom_minutes').text(minutes.toString().padStart(2, '0'));
            $('.custom_seconds').text(seconds.toString().padStart(2, '0'));
        }

        // Xử lý các sự kiện click
        closeModal.on('click', function (e) {
            e.preventDefault();
            let now = new Date().getTime();
            if (endTime - now > 0) {
                modal.fadeOut(300);
            }
        });

        // Kiểm tra khi tải trang
        let now = new Date().getTime();
        if (endTime && now >= endTime) {
            showExpiredModal();
        } else {
            // Khởi tạo countdown
            updateCountdown();
            countdownInterval = setInterval(updateCountdown, 1000);
        }
    });
</script>
<script>
    $(document).ready(function () {
        // Xử lý nút "Kích hoạt tài khoản tại đây" (.open_modal)
        $('.open_modal').off('click').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("Nút .open_modal được bấm");
            window.showKichHoatPopup();
        });

        // Xử lý nút "Kích hoạt" (#sudung_sodu)
        $('body').off('click', '#sudung_sodu').on('click', '#sudung_sodu', function () {
            console.log("Nút Kích hoạt được bấm");
            $('.box_confirm').css({
                'display': 'flex',
                'background-color': 'rgba(0, 0, 0, 0.5)',
                'z-index': '10000',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'width': '100%',
                'height': '100%',
                'justify-content': 'center',
                'align-items': 'center'
            });

            // Xử lý nút "Thực hiện"
            $('#confirm_yes').off('click').on('click', function () {
                console.log("Nút Thực hiện được bấm");
                $('.box_confirm').hide();
                $('.box_xuly').html('<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...');

                // Gọi API kích hoạt
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: 'sudung_sodu'
                    },
                    success: function (response) {
                        console.log("Phản hồi từ server:", response);
                        try {
                            const info = JSON.parse(response);
                            setTimeout(function () {
                                switch (info.ok) {
                                    case 1: // Thành công
                                        $('.box_xuly').html(info.thongbao);
                                        if ($('#status_button').length) {
                                            $('#status_button').html(
                                                '<button style="color: #ffffff; display: block; margin-bottom: 5px;"><p style="text-align: center; margin: 0;">Bạn đã là thành viên chính thức</p></button>'
                                            );
                                        }
                                        setTimeout(() => location.reload(), 2000);
                                        break;
                                    case 0: // Cần nạp thêm tiền
                                        $('.title_note, .box_sotien, .box_thongbao').remove();
                                        $('.sudung_sodu, #xacnhan_kichhoat, #sudung_sodu').remove();
                                        if ($('#text_note').length) {
                                            $('#text_note').html('Chuyển khoản để hoàn thành giao dịch');
                                        }
                                        $('.box_xuly').html(info.step2);
                                        break;
                                    case 2: // Lỗi xử lý
                                        $('.box_xuly').html(info.thongbao);
                                        break;
                                    default:
                                        $('.box_xuly').html('Có lỗi không xác định xảy ra');
                                }
                            }, 2000);
                        } catch (e) {
                            console.error("Lỗi phân tích JSON:", e);
                            $('.box_xuly').html('Lỗi xử lý dữ liệu từ máy chủ');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Lỗi AJAX:", error);
                        $('.box_xuly').html('Lỗi kết nối đến máy chủ');
                    }
                });
            });

            // Xử lý nút "Hủy"
            $('#confirm_no').off('click').on('click', function () {
                console.log("Nút Hủy được bấm");
                $('.box_confirm').fadeOut(300);
            });
        });
    });
</script>