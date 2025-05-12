<!-- Popup kích hoạt tài khoản -->
<div class="box_kichhoat" style="{display_kh}">
    <div class="box_kichhoat_content">
        <span class="close_modal" style="{display_close}">×</span>
        <div class="title">Kích hoạt tài khoản</div>
        <div style="text-align: left; margin-top: 10px;">
            <div class="box_thongbao"
                style="width: 100%; background: #fff9e6; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
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
            <div style="text-align: center; font-weight: 700;">
                <div class="list_action">
                    <button id="xacnhan_kichhoat" style="margin-bottom: 10px; display:none;">Nạp tiền</button>
                    <button id="sudung_sodu">Kích hoạt</button>
                </div>
                <div style="clear: both;"></div>
                <span style="margin-bottom: 10px; display:none;">Khuyến mại: <span>{user_money2} đ</span></span>
            </div>
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
    .modal-base {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: none;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .box_kichhoat {
        display: flex;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 99999;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 15px;
    }

    .box_kichhoat.show {
        display: flex !important;
        justify-content: center;
        align-items: center;
    }

    .box_confirm {
        composes: modal-base;
        z-index: 100000;
    }

    .modal-content-base {
        position: relative;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        max-width: 500px;
        width: 90%;
        margin: 0 auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .box_kichhoat_content,
    .box_confirm_content {
        composes: modal-content-base;
    }

    .box_kichhoat.expired {
        display: flex !important;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 99999;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
    }

    .box_kichhoat.expired .box_kichhoat_content {
        left: 0 !important;
        top: 2% !important;
        right: 0 !important;
        bottom: 2% !important;
        position: fixed !important;
        width: 560px;
        max-width: calc(100% - 20px);
        background: #fff;
        max-height: calc(100vh - 10px);
        border-radius: 5px;
        padding: 10px;
        margin: auto;
        transform: none !important;
        overflow-y: auto;
    }

    .box_kichhoat .box_kichhoat_content .list_action {
        width: 100%;
        display: flex;
        margin-top: 10px;
        justify-content: center;
        gap: 10px;
    }

    .box_kichhoat_content {
        transform: none !important;
        top: auto !important;
    }

    .close_modal {
        position: absolute;
        top: 10px;
        right: 15px;
        padding: 0px 9px;
        /* width: 25px; */
        /* height: 25px; */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        background-color: #ff0000;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
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
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 100000;
        display: none;
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
        function updateModalState() {
            let now = new Date().getTime();
            if (now >= endTime) {
                $('.box_kichhoat').addClass('expired');
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
<script>
    $(document).ready(function () {
        const modal = $('.box_kichhoat');
        const modalContent = $('.box_kichhoat_content');
        const closeModal = $('.close_modal');
        const $countdownTimer = $('#custom-countdown-timer');
        const endTime = parseInt($countdownTimer.attr('data-time'), 10) * 1000;
        let countdownInterval;

        // Function to block all interactions
        function blockPageInteraction() {
            // Create overlay to block all content
            const $overlay = $('<div id="page-overlay"></div>').css({
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'width': '100%',
                'height': '100%',
                'background': 'rgba(0, 0, 0, 0.5)',
                'z-index': '9998',
                'cursor': 'not-allowed'
            });

            // Add overlay to body
            $('body').append($overlay);

            // Prevent scrolling
            $('body').css('overflow', 'hidden');

            // Show expired modal
            showExpiredModal();
        }

        function showExpiredModal() {
            modal.fadeIn(300).css({
                'display': 'flex !important',
                'background-color': 'rgba(0, 0, 0, 0.8)',
                'z-index': '99999',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'width': '100vw',
                'height': '100vh',
                'justify-content': 'center',
                'align-items': 'center',
                'margin': '0',
                'padding': '0'
            });

            modalContent.css({
                'position': 'relative',
                'background': '#fff',
                'max-width': '500px',
                'width': '90%',
                'margin': '0 auto',
                'padding': '20px',
                'border-radius': '8px',
                'box-shadow': '0 2px 10px rgba(0,0,0,0.1)',
                'transform': 'none', // Remove translateY
                'top': 'auto' // Remove top positioning
            });


            // Hide close button
            closeModal.hide();

            // Only allow interaction with activation button
            modalContent.find('*:not(#sudung_sodu, .box_xuly, .box_xuly *)').css({
                'pointer-events': 'none'
            });

            // Highlight activation button
            $('#sudung_sodu').css({
                'pointer-events': 'auto',
                'opacity': '1',
                'background': '#ff0000',
                'transform': 'scale(1.05)',
                'box-shadow': '0 0 10px rgba(255, 0, 0, 0.5)',
                'transition': 'all 0.3s ease'
            });

            // Add warning message
            if (!$('.warning-message').length) {
                $('.box_thongbao').prepend(`
                    <div class="warning-message" style="background: #fff3cd; color: #856404; padding: 15px; margin-bottom: 15px; border-radius: 4px; text-align: center;">
                        <strong>⚠️ Đã hết thời gian dùng thử!</strong><br>
                        Vui lòng kích hoạt để tiếp tục sử dụng.
                    </div>
                `);
            }

            // Prevent any closing attempts
            modal.off('click');
            $(document).off('keyup.modal');
            closeModal.off('click');
        }

        // Check expired status on page load
        function checkExpired() {
            let now = new Date().getTime();
            if (now >= endTime) {
                blockPageInteraction();
                return true;
            }
            return false;
        }

        // Initialize on page load
        if (!isNaN(endTime)) {
            if (!checkExpired()) {
                updateCountdown();
                countdownInterval = setInterval(function () {
                    let now = new Date().getTime();
                    let timeLeft = endTime - now;

                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        blockPageInteraction();
                    } else {
                        updateCountdown();
                    }
                }, 1000);
            }
        }
    });
</script>
<script>
    function showExpiredModal() {
        const modal = $('.box_kichhoat');

        // Remove any inline styles first
        modal.removeAttr('style');
        $('.box_kichhoat_content').removeAttr('style');

        // Apply our classes
        modal.addClass('show').css({
            'display': 'flex',
            'justify-content': 'center',
            'align-items': 'center'
        });

        $('.box_kichhoat_content').css({
            'background': '#fff',
            'max-width': '500px',
            'width': '90%',
            'margin': '0 auto',
            'padding': '20px',
            'border-radius': '8px',
            'box-shadow': '0 2px 10px rgba(0,0,0,0.1)',
            'position': 'relative'
        });
    }
</script>
<script>
    $(document).ready(function () {
        // Xử lý nút kích hoạt
        $('#sudung_sodu').on('click', function () {
            $('.box_confirm').css({
                'display': 'flex',
                'background-color': 'rgba(0, 0, 0, 0.5)',
                'z-index': '10000',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'width': '100%',
                'height': '100%'
            });

            // Xử lý nút xác nhận
            $('#confirm_yes').off('click').on('click', function () {
                $('.box_confirm').hide();
                $('.box_xuly').html('<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...');

                $.ajax({
                    url: "/ncc/process.php",
                    type: "POST",
                    data: {
                        action: 'sudung_sodu'
                    },
                    success: function (response) {
                        try {
                            const info = JSON.parse(response);
                            if (info.ok === 1 && !info.step2) {
                                // Kích hoạt thành công
                                $('.box_xuly').html(info.thongbao);
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else if (info.show_step2) {
                                // Cần nạp thêm tiền - chuyển sang step2
                                $('.title_note').remove();
                                $('.box_sotien').remove();
                                $('.box_thongbao').remove();
                                $('.sudung_sodu').remove();
                                $('#xacnhan_kichhoat').remove();
                                $('#sudung_sodu').remove();
                                $('#text_note').html('Chuyển khoản để hoàn thành giao dịch');
                                $('.box_xuly').html(info.step2);
                            } else {
                                // Lỗi khác
                                $('.box_xuly').html(info.thongbao);
                            }
                        } catch (e) {
                            $('.box_xuly').html('Có lỗi xử lý dữ liệu');
                        }
                    },
                    error: function () {
                        $('.box_xuly').html('Lỗi kết nối máy chủ');
                    }
                });
            });

            // Xử lý nút hủy
            $('#confirm_no').off('click').on('click', function () {
                $('.box_confirm').fadeOut(300);
            });
        });
    });
</script>