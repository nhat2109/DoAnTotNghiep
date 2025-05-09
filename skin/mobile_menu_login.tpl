<div id="mobile-menu" class="scroll">
    <div class="media d-flex user-menu position-relative">
        <a href="/tai-khoan.html"><i class="fas fa-user-circle mr-3 align-self-center"></i></a>
        <div class="media-body">
            <!-- <a rel="nofollow" href="/dang-nhap.html" class="d-block" title="Đăng nhập">
                Đăng nhập
            </a>
            <a href="/dang-ky.html" title="Đăng ký" class="bg_green">
                Đăng ký
            </a> -->
            <a href="/tai-khoan.html">Tài khoản: <strong>{name}</strong></a>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mobileMenu = document.getElementById("mobile-menu");
            const closeBtn = document.querySelector(".close-btn");
            const openMenuBtn = document.getElementById("open-menu");

            if (!mobileMenu || !closeBtn || !openMenuBtn) {
                console.error("Không tìm thấy phần tử cần thiết.");
                return;
            }

            openMenuBtn.addEventListener("click", function () {
                console.log("Mở menu");
                mobileMenu.classList.add("show-menu");
            });

            closeBtn.addEventListener("click", function () {
                console.log("Đóng menu");
                mobileMenu.classList.remove("show-menu");
            });
        });
    </script>
    <style>
        #mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100vh;
            background: white;
            transition: left 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.2);
        }

        #mobile-menu.show-menu {
            left: 0;
            /* Hiện menu */
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: black;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
    <div class="mobile-menu-body scroll">
        <nav class="h-100">
            <ul class="navigation list-group list-group-flush scroll">
                {list_category_mobile}
            </ul>
        </nav>
        <ul class="shop-policises list-unstyled  d-flex flex-wrap m-0 pr-0">
            <li style="width: 100%;background: #fd0;">
                <div class="">
                    <i class="icon icon-store2"></i>
                </div>
                <a class="link" href="/dangky-banhang.html" title="Kênh bán hàng">Kênh bán hàng</a>
            </li>
            <li>
                <div class="">
                    <i class="fa fa-puzzle-piece"></i>
                </div>
                <a class="link" href="/kho-giao-dien.html" title="Kho giao diện">Kho giao diện</a>
            </li>
            <li>
                <div class="">
                    <img class="img-fluid lazyload loaded" src="/skin/css/images/policy_header_image_1.png?v=128"
                        data-src="/skin/css/images/policy_header_image_1.png?v=128" alt="Sản phẩm chính hãng"
                        data-was-processed="true">
                </div>
                <a class="link" title="Sản phẩm chính hãng">Sản phẩm chính hãng</a>
            </li>
            <li>
                <div class="">
                    <img class="img-fluid lazyload loaded" src="/skin/css/images/policy_header_image_2.png?v=128"
                        data-src="/skin/css/images/policy_header_image_2.png?v=128" alt="Kiểm tra khi nhận hàng"
                        data-was-processed="true">
                </div>
                <a class="link" title="Kiểm tra khi nhận hàng">Kiểm tra khi nhận hàng</a>
            </li>
            <li>
                <div class="">
                    <img class="img-fluid lazyload loaded" src="/skin/css/images/policy_header_image_3.png?v=128"
                        data-src="/skin/css/images/policy_header_image_3.png?v=128" alt="Hoàn tiền 111% nếu giả"
                        data-was-processed="true">
                </div>
                <a class="link" title="Hoàn tiền 111% nếu giả">Hoàn tiền 111% nếu giả</a>
            </li>
        </ul>
    </div>
    <div class="mobile-menu-footer border-top w-100 d-flex align-items-center text-center">
        <div class="hotline  w-50   p-2 ">
            <a href="tel:{hotline_number}" title="{hotline}">
                Gọi điện <i class="fa fa-phone ml-3"></i>
            </a>
        </div>
        <div class="messenger border-left p-2 w-50 border-left">
            <a href="{link_facebook}" title="Nhắn tin">
                Nhắn tin
                <i class="fab fa-facebook-messenger ml-3"></i>
            </a>
        </div>
    </div>
</div>