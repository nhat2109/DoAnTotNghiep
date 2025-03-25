<footer>
    <div class="mid-footer" >
        <div class="container">
            <div class="row">
                
                <div class="col-lg-3">
                    <div class="footer-block footer-click">
                        <a href="/" class="logo-wrapper mb-3 d-block">
                            <img loading="lazy"
                            src="{logo}" 
                            alt="logo" width="200" height="70" />    
                        </a>
                            
                                
                                    {text_footer}
                                
                               

                            
                            
                                {text_contact_footer}
                            
                    </div>
                    
                    
                            <span id="register">© Bản quyền thuộc về <b><?php echo $_SERVER['HTTP_HOST'];?></b></span>
                    
                    
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="footer-block footer-click">
                                <h3 class="footer-title title-menu clicked">
                                   HƯỚNG DẪN
                                    <i class="fa fa-angle-down d-md-none d-inline-block"></i>
                                </h3>
                                <ul class="list-menu toggle-mn">
                                    <ul class="list-menu">
                                        {menu_huongdan}
                                    </ul>

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="footer-block footer-click">
                                <h3 class="footer-title title-menu clicked">
                                    CHÍNH SÁCH
                                    <i class="fa fa-angle-down d-md-none d-inline-block"></i>
                                </h3>
                                <ul class="list-menu toggle-mn">
                                    
                                    {menu_chinhsach}
                                </ul>
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="footer-block footer-click">
                                <h3 class="footer-title title-menu">ĐĂNG KÝ NHẬN TIN</h3>
                                <p class="mailchimp-title">
                                    Bạn muốn nhận khuyến mãi đặc biệt? Đăng ký ngay.
                                </p>
                                <div class="form_register">
                                    <form id="mc-form" class="newsletter-form custom-input-group mb-3"
                                        data-toggle="validator">
                                        <input class="form-control input-group-field" aria-label="Địa chỉ Email"
                                            type="email" placeholder="Nhập địa chỉ email" name="EMAIL" required
                                            autocomplete="off" />
                                        <div class="input-group-btn btn-action">
                                            <button class="h-100 btn text-white button_subscribe subscribe"
                                                type="submit" aria-label="Đăng ký nhận tin" name="subscribe">
                                                Đăng ký
                                            </button>
                                        </div>
                                    </form>
                                    <div class="mailchimp-alerts">
                                        <div class="mailchimp-submitting"></div>
                                        <!-- mailchimp-submitting end -->
                                        <div class="mailchimp-success mb-2"></div>
                                        <!-- mailchimp-success end -->
                                        <div class="mailchimp-error mb-2"></div>
                                        <!-- mailchimp-error end -->
                                    </div>
                                </div>

                                <ul class="follow_option d-flex flex-wrap align-items-center list-unstyled mt-2">
                                    <li>
                                        <a class="facebook link"  href="{link_facebook}" target="_blank"
                                            title="Theo dỗi">
                                            <img src="/uploads/minh-hoa/facebook.png"
                                                loading="lazy" width="32" height="32" alt="facebook" />
                                        </a>
                                    </li>

                                    <li>
                                        <a class="zalo link" href="{link_zalo}"
                                            target="_blank" title="Theo dỗi">
                                            <img src="/uploads/minh-hoa/zalo.png"
                                                loading="lazy" width="32" height="32" alt="zalo" />
                                        </a>
                                    </li>

                                    <li>
                                        <a class="instgram link" href="{link_instagram}"  target="_blank"
                                            title="Theo dỗi">
                                            <img src="/uploads/minh-hoa/instagram.png"
                                                loading="lazy" width="32" height="32" alt="instgram" />
                                        </a>
                                    </li>

                                    <li>
                                        <a class="youtube link" href="{link_youtube}" target="_blank"
                                            title="Theo dỗi">
                                            <img src="/uploads/minh-hoa/youtube.png"
                                                loading="lazy" width="36" height="36" alt="youtube" />
                                        </a>
                                    </li>

                                    <li>
                                        <a class="tiktok link" href="{link_tiktok}" target="_blank"
                                            title="Theo dỗi">
                                           <img src="/uploads/minh-hoa/tiktok.png"
                                                loading="lazy" width="36" height="36" alt="tiktok" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="trustbadge-wrap mt-4">
                                <div class="product-trustbadge d-flex flex-wrap align-items-center">
                                    <a href="/" target="_blank" title="Phương thức thanh toán">
                                        <img class="img-fluid" loading="lazy"
                                            src="/uploads/minh-hoa/footer_trustbadge.png"
                                            alt="Phương thức thanh toán" width="301" height="36" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</footer>
<style>
    
    
    #ega-sale-pop .sale-pop-close {
        position: absolute;
        top: 6px;
        right: 6px !important;
        cursor: pointer;
        margin-left: 5px !important;
    }
    
    @media (max-width: 767px) {
        button.btn.btn_num.num_2 {
            border-radius: 0 5px 5px 0;
            border-left: none;
            border: none;
            padding-right: 3px;
            position: relative;
            right: 42% !important;
        }

        .modal-backdrop.fade.show {
            display: none !important; /* Ẩn phần tử */
        }
        #ega-sale-pop {
            position: fixed;
            bottom: 20px;
            left: 2px !important;
            margin: 2px;
            max-width: 380px !important;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 9999;
            display: none;
        }
        .coupon-item-wrap {
            flex: 0 0 auto;
            min-width: 250px; /* Kích thước tối thiểu */
            min-height: 0px !important;
            padding: 0;
            margin: 0;
            box-sizing: border-box; /* Đảm bảo padding và border không làm tăng kích thước */
            position: relative; /* Đảm bảo không bị ảnh hưởng bởi các thuộc tính position khác */
        }
    }
    .scroll_s {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
      gap: 10px;
      scrollbar-width: none;
      -ms-overflow-style: none;
      padding-left: 160px; /* Thêm khoảng trống 100px đầu */
      margin: 0;
    }
    
    
    /* Ẩn thanh cuộn trên Chrome, Safari */
    .scroll_s::-webkit-scrollbar {
        display: none;
    }
    @media (max-width: 768px) {
        .scroll_s {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 10px;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-left: 0px !important; /* Thêm khoảng trống 100px đầu */
            margin: 0;
          }
      }
    .coupon-item-wrap {
        flex: 0 0 auto;
        min-width: 250px; /* Kích thước tối thiểu */
        min-height: 220px;
        padding: 0;
        margin: 0;
        box-sizing: border-box; /* Đảm bảo padding và border không làm tăng kích thước */
        position: relative; /* Đảm bảo không bị ảnh hưởng bởi các thuộc tính position khác */
    }
    .search__list a:hover {
        color: #333 !important;
    }
    .list-group .list-group-item .mega-menu {
        height: 200% !important;
    }

    .navigation {
        --nav-height: 313px;
        min-height: 100%;
        overflow-x: auto; /* Cho phép cuộn ngang */
        display: flex;
        flex-direction: row;
        flex-wrap: wrap; /* Mặc định vẫn wrap */
        max-width: 100%;
        width: 100%;
    }
    #output_search::-webkit-scrollbar {
        display: none;
    }
    #output_search .name_product a {
        display: inline-block;       /* Để áp dụng width */
        width: 100%;                 /* Chiếm toàn bộ chiều rộng của container */
        white-space: nowrap;         /* Không xuống dòng */
        overflow: hidden;            /* Ẩn phần tràn */
        text-overflow: ellipsis;     /* Thêm "..." nếu nội dung vượt quá */
        font-size: 14px;             /* Kích thước chữ */
        color: #333;                 /* Màu chữ */
        text-decoration: none;       /* Xóa gạch chân */
    }
    
    #output_search .name_product a:hover {
        text-decoration: underline;  /* Gạch chân khi hover */
    }
    
    .footer-click ul{
        list-style: none !important;
        background-color: black !important;
    }
    .footer-click ul li p{

        color: #fff ;
    
    }
    .footer-click ul li p:hover, span:hover{

        color: #ec720e !important;
    
    }
    .footer-click ul li span:hover{

        color: #ec720e !important;
    
    }
    .footer-click ul li span{

        color: #fff;
    }
    .footer-click .list-menu li a{

        color: #fff;
    }
    .footer-click .list-menu li a:hover{

        color: #ec720e !important;
    }
    .footer-click .mailchimp-title{

        color: #fff;
    }
    .footer-click .mailchimp-title:hover{

        color: #ec720e !important;
    }
</style>
<script>
    
</script>


<script>
    $(document).ready(function() {
        $(document).on('click', '.xem_nhanh', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của nút
    
            var sp_id = $(this).attr('sp_id');
            var loai = $(this).attr('loai');
    
            if (sp_id) {
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    data: {
                        action: 'get_product_info',
                        sp_id: sp_id,
                        loai: loai
                    },
                    success: function(response) {
                        try {
                            var product = JSON.parse(response);
                            var disabledClass = product.text_button === 'Hết hàng' ? 'disabled' : '';
                            var disabledAttr = product.text_button === 'Hết hàng' ? 'disabled="disabled"' : '';
                            var modalContent = `
                                <div class="quick-view-product align-verticle">
                                    <div class="block-quickview primary_block details-product details-product_hide">
                                        <div style="display:flex;">
                                            <!-- Phần hình ảnh sản phẩm -->
                                           <div class="product-detail-left product-images bg-white py-3 col-12 col-lg-6 overflow-hidden thumbs-on-mobile--show">
                                                <div class="section slickthumb_relative_product_1">
                                                    <div id="gallery_02" class="custom-slider-nav slickproduct thumb_product_details slider-nav">
                                                        ${product.list_photo}
                                                    </div>
                                                </div>

                                                <div class="pt-0 col_large_default large-image">
                                                    <div id="gallery_1" class="custom-slider-for slider-for">
                                                        ${product.list_photo_1}
                                                    </div>

                                                    <div class="share-group d-flex justify-content-center align-items-center mt-3">
                                                        <strong class="share-group__heading mr-3">Chia sẻ</strong>
                                                        <div class="share-group__list">
                                                            <a class="share-group__item facebook" target="_blank" href="http://www.facebook.com/sharer">
                                                                <i class="fab fa-facebook-f"></i>
                                                            </a>
                                                            <a class="share-group__item messenger d-lg-none" target="_blank" href="fb-messenger://share/?link=">
                                                                <i class="fab fa-facebook-messenger"></i>
                                                            </a>
                                                            <a class="share-group__item pinterest" target="_blank" href="http://pinterest.com/pin/create/button/?url=">
                                                                <i class="fab fa-pinterest-p"></i>
                                                            </a>
                                                            <a class="share-group__item twitter" target="_blank" href="http://twitter.com/share?text=">
                                                                <i class="fab fa-twitter"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Phần thông tin sản phẩm -->
                                            <div class="product-center-column product-info product-item col-xs-12 col-sm-6 col-md-8 col-lg-7 col-xl-6 details-pro style_product style_border" style="margin:10px;" >
                                                <div class="head-qv group-status">
                                                    <h3 class="qwp-name title-product">
                                                        <a class="text2line" href="/product/${product.link}.html" title="${product.tieu_de}">${product.tieu_de}</a>
                                                    </h3>
                                                    <div class="vend-qv group-status">
                                                        <div class="left_vend">
                                                            <div class="first_status top_vendor d-inline-block">
                                                                <span class="vendor_ status_name">${product.thuong_hieu}</span>
                                                            </div>
                                                            <span class="line_tt">|</span>
                                                            <div class="top_sku first_status d-inline-block">Mã sản phẩm:
                                                                <span class="sku_ status_name">${product.id}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="reviews_qv mt-2">
                                                    <div class="sapo-product-reviews-badge" data-id=${product.id}><div class="sapo-product-reviews-star" data-score="5" data-number="5" style="color: #ffbe00" title="gorgeous"><i data-alt="1" class="star-on-png" title="gorgeous"></i>&nbsp;<i data-alt="2" class="star-on-png" title="gorgeous"></i>&nbsp;<i data-alt="3" class="star-on-png" title="gorgeous"></i>&nbsp;<i data-alt="4" class="star-on-png" title="gorgeous"></i>&nbsp;<i data-alt="5" class="star-on-png" title="gorgeous"></i><input name="score" type="hidden" value="5" readonly=""></div></div>
                                                </div>
                                                <div class="quickview-info clearfix">
                                                    <span class="prices price-box">
                                                        <span class="price product-price sale-price on-sale">${product.gia_moi}₫</span>
                                                        <del class="old-price">${product.gia_cu}₫</del>
                                                        <span class="label_product">${product.label_sale}</span>
                                                    </span>
                                                </div>
                                                <div class="product-description product-summary">
                                                    <div class="rte">
                                                     
                                                    </div>
                                                </div>
                                                <form action="/cart/add" method="post" enctype="multipart/form-data" class="quick_option variants form-ajaxtocart form-product">
                                                    <div class="form-group form_product_content">
                                                        <div class="count_btn_style quantity_wanted_p">
                                                            <div class="custom input_number_product soluong1">
                                                                <button class="btn_num btn num_1 button button_qty" type="button" onclick="var result = document.getElementById('quantity-detail'); var qtyqv = result.value; if( !isNaN( qtyqv ) && qtyqv > 1 ) result.value--;return false;">
                                                                    <svg class="icon"><use xlink:href="#icon-minus"></use></svg>
                                                                </button>
                                                                <input type="text" id="quantity-detail" name="quantity" value="1" maxlength="2" class="form-control prd_quantity">
                                                                <button class="btn_num btn num_2 button button_qty" type="button" onclick="var result = document.getElementById('quantity-detail'); var qtyqv = result.value; if( !isNaN( qtyqv )) result.value++;return false;">
                                                                    <svg class="icon"><use xlink:href="#icon-plus"></use></svg>
                                                                </button>
                                                            </div>
                                                            <div style="display: flex;flex-wrap: wrap;width: 100%;" class="button_actions clearfix margin-bottom-20">
                                                                 <button type="submit" class="add_to_cart action-child btn-circle btn-views btn_view btn right-to m-0 ${disabledClass}" 
                                                                    sp_id="${product.id}" loai="${product.loai}" ${disabledAttr}>
                                                                    <div class="button-link">
                                                                        <span class="action-name add_to_cart" sp_id="${product.id}" loai="${product.loai}" title="${product.text_button}">
                                                                            <span class="txt-main">${product.text_button}</span>
                                                                        </span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <a title="Close" class="quickview-close close-window" href="javascript:;"><i class="fas fa-times"></i></a>
                                </div>
                            `;
                             // Khởi tạo Slick Slider sau khi thêm nội dung
                             // Đợi một chút để DOM được cập nhật
                            setTimeout(function() {
                                // Khởi tạo slider cho ảnh lớn
                                $('#gallery_1').slick({
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: true,
                                    fade: true,
                                    asNavFor: '#gallery_02'
                                });

                                // Khởi tạo slider cho ảnh nhỏ
                                $('#gallery_02').slick({
                                    slidesToShow: 4,
                                    slidesToScroll: 1,
                                    asNavFor: '#gallery_1',
                                    dots: false,
                                    centerMode: true,
                                    focusOnSelect: true,
                                    vertical: true,
                                    verticalSwiping: true
                                });
                            }, 100);
                            // Cập nhật nội dung modal
                            $('#quick_view_content').html(modalContent);
    
                            // Hiển thị modal
                            $('#xem_nhanh').show();
    
                            // Đóng modal khi nhấp vào nút đóng
                            $('.quickview-close').on('click', function() {
                                $('#xem_nhanh').hide();
                            });
    
                            // Đóng modal khi nhấp ra ngoài modal
                            $(window).on('click', function(event) {
                                if (event.target.id === 'xem_nhanh') {
                                    $('#xem_nhanh').hide();
                                }
                            });
                        } catch (error) {
                            console.error("Lỗi khi phân tích dữ liệu JSON:", error);
                        }
                    },
                    error: function() {
                        alert("Lỗi khi tải thông tin sản phẩm.");
                    }
                });
            } else {
                alert('Thông tin sản phẩm không hợp lệ.');
            }
        });
    });
    $(document).ready(function() {
        $(document).on('click', '.add_to_cart', function(event) {
            if ($(this).hasClass('disabled') || $(this).attr('disabled')) {
                event.preventDefault();
                return;
            }
            event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit
    
            var sp_id = $(this).attr('sp_id');
            var loai = $(this).attr('loai');
            //var quantity = $('#quantity-detail').val(); // Lấy giá trị số lượng từ input
            sp_id=$(this).attr('sp_id');
            loai=$(this).attr('loai');
            if($('input[name=size]').length>0){
                size=$('input[name=size]:checked').val();
            }else{
                size='';
            }
            if($('input[name=mau]').length>0){
                mau=$('input[name=mau]:checked').val();
            }else{
                mau='';
            }
            if($('#quantity_view').length>0){
                quantity=$('#quantity_view').val();
            }else{
                var quantity = $('#quantity-detail').val();
            }
            if($('#quantity-detail').length>0){
                var quantity = $('#quantity-detail').val();
            }
            console.log(quantity);
            if (sp_id) {
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    data: {
                        action: 'add_to_cart',
                        sp_id:sp_id,
                        loai:loai,
                        size:size,
                        mau:mau,
                        quantity:quantity
                    },
                    success: function(response) {
                        try {
                            var info = JSON.parse(response);
                            if (info.ok) {
                                // Cập nhật giỏ hàng và các phần tử liên quan
                                updateCartCount(info.total_cart);
                            } else {
                                alert('Có lỗi xảy ra, vui lòng thử lại sau.');
                            }
                        } catch (e) {
                            console.error('Invalid JSON response:', response);
                            alert('Có lỗi xảy ra, vui lòng thử lại sau.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        alert('Có lỗi xảy ra, vui lòng thử lại sau.');
                    }
                });
            } else {
                alert('Thông tin sản phẩm không hợp lệ.');
            }
        });
    
        function updateCartCount(totalCart) {
            $('.count_item_pr').text(totalCart);
        }
    });
</script>

<style>
    /* Ẩn nút điều hướng của slider ảnh nhỏ */
    #gallery_02 .slick-prev,
    #gallery_02 .slick-next {
    display: none !important;
}
</style>
<script src="/skin_shop/skin_7_nhat/tpl/js/jquery.min.js"></script>
<script src="/skin_shop/skin_7_nhat/tpl/js/slick.min.js"></script>
<!-- Add these links in the head section -->
<script>
    $(document).ready(function () {
        // Khởi tạo slider cho ảnh lớn
        $('.custom-slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '.custom-slider-nav' // Kết nối với thumbnail slider
        });

        // Khởi tạo slider cho ảnh nhỏ
        $('.custom-slider-nav').slick({
            slidesToShow: 4, // Số ảnh nhỏ hiển thị cùng lúc
            slidesToScroll: 1,
            asNavFor: '.custom-slider-for', // Kết nối với slider ảnh lớn
            dots: false,
            centerMode: true,
            focusOnSelect: true
        });
    });
</script>
<style>
    #quick-view-product .quick-view-product {
        border-radius: 8px;
        padding: 15px 20px;
    }#quick-view-product .quick-view-product {
        position: absolute;
        width: 950px;
        max-height: 720px;
        top: 5%;
        height: auto;
        margin: 0 auto;
        left: 0;
        right: 0;
        padding: 30px;
        background-color: #fff;
        z-index: 8011;
        border-radius: 0px;
    }
    @media (max-width: 1199px) {
        .quick-view-product .align-verticle {
            display:block !important;
             grid-template-rows: 1fr;
            margin: 0px;
            grid-template-columns:auto ;
            overflow: auto;
            justify-content: start;
        }
    }
    
</style>

<!-- <style>
    .img-check {
        display: none;
    }

    @media (min-width: 1200px) {
        .col-xl-3 {
            flex: 0 0 20%; /* Chiếm 20% chiều rộng */
            max-width: 20%; /* Đảm bảo hiển thị tối đa 5 cột */
        }
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        width: 50%;
        border-radius: 10px;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }
</style> -->
<style>
/* Định dạng chung cho modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    width: 80%;
    max-width: 800px;
    border-radius: 10px;
    position: relative;
    text-align: center;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
}

/* Định dạng cho desktop */
@media (min-width: 1024px) {
    .modal-content {
        width: 80% !important;
    }
    
    .quick-view-product, .details-product .product-promo-tag {
        display: inline-block;
        clear: both;
        width: 100% !important;
    }
}

/* Định dạng cho tablet */
@media (min-width: 768px) and (max-width: 1023px) {
    .modal-content {
        width: 70%;
    }
}

/* Định dạng cho mobile */
@media (max-width: 767px) {
    .modal-content {
        width: 90%;
    }
    
.input-group {
    margin-left: -110px !important;
    position: relative;
    display: -ms-flexbox;
    display: flex
;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 360% !important;
}

}
.btn-circle, .input_number_product_1{
    border: 1px solid #c4c1c1;
}    
@media (max-width: 991px) {
    .ega-header .header-wrap .header-right__icons img {
        max-width: none;
    }
}
.ega-header  .header-wrap .header-right__icons .product-thumbnail__img--secondary {
    
}

/* Modal */
.modal {
    background: rgba(0,0,0,0.5);
}

.modal-content {
    max-width: 1000px;
    margin: 120px auto;
}
.top-cart-content {
    position: absolute;
    z-index: 999999 !important;
    visibility: hidden;
    opacity: 0;
    width: 400px;
    right: 0%;
    top: calc(100% + 8px);
    color: var(--text-color);
    padding: 10px 15px;
    font-size: 14px;
}
</style>
<!-- <script src="/skin_shop/skin_7_nhat/tpl/js/coupon.js" defer></script>
<link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/styles.css"> -->
<script>
		
    var isProductInit = false;
    var moneyFormat = "{{amount_no_decimals_with_comma_separator}}₫";
    $(document).ready(function (e) {
        $(".action-buy").click(function () {
            $("#add-to-cart-form .add_to_cart").trigger("click");
        });

        $("#ega-sticky-addcart .add_to_cart").click(() => {
            $(".details-product .add_to_cart").trigger("click");
        });

        $(".ega-share-box .pd-ac-share").click(function () {
            $("#ega-modal-share").modal("show");
        });
    });

    function findSize(value1, value2, yw, sizeData) {
        var indexRes = "",
            indexValue1 = -1,
            indexValue2 = -2;
        var foundIndexPair = -3;

        sizeData["all"].forEach(function (v, index) {
            if (v.value1[0] <= value1 && v.value1[1] >= value1) {
                indexValue1 = index;
            }
            if (v.value2[0] <= value2 && v.value2[1] >= value2) {
                indexValue2 = index;
            }

            if (indexValue1 == indexValue2) {
                foundIndexPair = indexValue1;
                indexValue1 = -1;
                indexValue2 = -2;
            }
        });

        if (
            (indexValue1 == -1 ||
                indexValue2 == -2 ||
                typeof indexRes == "string") &&
            foundIndexPair == -3
        ) {
            return "Chưa có size phù hợp";
        } else {
            indexRes = foundIndexPair;
        }

        if (yw == 0 && indexRes > 0) {
            indexRes--;
        }
        if (yw == 2 && indexRes < sizeData["all"].length - 1) {
            indexRes++;
        }

        return sizeData["all"][indexRes].size;
    }

    function initSizeChart() {
        $(".open-size-modal").click(function () {
            $("#ega-modal-sizes").modal("show");
        });

        $(".size-fit .fit-item").click(function () {
            $(this).addClass("actived").siblings().removeClass("actived");
        });

        function displaySize(sizeData) {
            $(".slider-input").each(function (i, v) {
                let dataType = $(v).data().type;
                let dataValue = $(v).val();
                $("#size-info").attr(`data-${dataType}`, dataValue);
            });

            let wantedValue = $(".size-fit .fit-item.actived").data().value;
            $("#size-info").attr(`data-wanted`, wantedValue);

            setTimeout(function () {
                var value1 = Number($("#size-info").attr("data-value-1"));
                var value2 = Number($("#size-info").attr("data-value-2"));
                var wanted = Number($("#size-info").attr("data-wanted"));

                $("#result_size span").html(
                    findSize(value1, value2, wanted, sizeData)
                );
                $("#result_size").removeClass("hidden");
            }, 500);
        }

        function loadSizeData(url, sizeData) {
            const params = {
                type: "GET",
                url: url,
                async: false,
                dataType: "text",
                success: function (data) {
                    const from = data.indexOf("{");
                    const to = data.lastIndexOf("}") + 1;
                    const jsonText = data.slice(from, to);
                    const parsedText = JSON.parse(jsonText);
                    const table = parsedText.table;
                    if (!table || !table.rows || !table.rows.length) {
                        $(".loading-icon").hide();
                        $(".not_found").show();
                        return;
                    }
                    //table.rows.shift();
                    let result = table.rows.map((item) => {
                        return item.c;
                    });
                    result.map((item) =>
                        sizeData["all"].push({
                            size: item[0].v,
                            value1: item[1].v.split("-"),
                            value2: item[2].v.split("-"),
                        })
                    );

                    $(".slider-input").on("input", function (e) {
                        $(this)
                            .parents(".slider-box")
                            .find(".slider-value .value-number")
                            .html(`${this.value}`);

                        displaySize(sizeData);
                    });

                    $(".size-fit .fit-item").click(function () {
                        $(this).addClass("actived").siblings().removeClass("actived");
                        displaySize(sizeData);
                    });
                },
                error: function () { },
            };
            jQuery.ajax(params);
        }

        let sizeData = { all: [] };
        let spreadSheet =
            "https://docs.google.com/spreadsheets/d/1MeNi4UEop9SAchADBrO31veyeuWGrRJm8nCxWk9gxN4/edit?usp=sharing";

        if (!spreadSheet) return;
        const id = spreadSheet.match(/(d\/)(.*)(?=\/)/gm);
        let gid = "0";

        let gidMatch = spreadSheet.match(/gid\=(.*)/gm);
        if (gidMatch != null) {
            gid = gidMatch[0].split("=")[1];
        }

        const url =
            "https://docs.google.com/spreadsheets/" +
            id +
            "/gviz/tq?tqx=out:json&gid=" +
            gid +
            "&tq=SELECT A, B, C";
        loadSizeData(url, sizeData);
    }
    window.sectionScripts = window.sectionScripts || [];
    window.sectionScripts.push(
        "/skin_shop/skin_7_nhat/tpl/js/product.js"
    );
</script>






<div id="ega-sale-pop" class="sales-pop hidden">
    <div class="sale-pop-wrap"></div>
    <div class="sale-pop-close">
        <i class="fa fa-times"></i>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Kiểm tra phần tử #ega-sale-pop có đang hiển thị hay không
        //console.log("Kiểm tra hiển thị #ega-sale-pop: ", $("#ega-sale-pop").hasClass("salepop-show"));

        const fakerScript = "https://cdnjs.cloudflare.com/ajax/libs/Faker/3.1.0/faker.min.js";

        // Lấy dữ liệu từ file JSON
        // Đường dẫn tuyệt đối cho thư mục hiện tại
        
     // Sử dụng đường dẫn tuyệt đối
     setTimeout(function(){
        $.ajax({
            url: '/skin_shop/skin_7_nhat/salePopArr.json', // Đường dẫn tuyệt đối từ root
            dataType: 'json',
            cache: true,
            success: function(data) {
                if (Array.isArray(data) && data.length > 0) {
                    initSalesPop(data);
                } else {
                    console.warn("Dữ liệu rỗng hoặc không hợp lệ.");
                }
            },
            error: function(jqxhr, textStatus, error) {
                // Thử các đường dẫn thay thế
                const alternativePaths = [
                    '/salePopArr.json',
                    '../salePopArr.json',
                    './salePopArr.json',
                    '/skin_shop/skin_7_nhat/tpl/salePopArr.json'
                ];

                function tryNextPath(paths, index) {
                    if (index >= paths.length) {
                        console.error("Không thể tải file JSON từ tất cả các đường dẫn");
                        return;
                    }

                    $.ajax({
                        url: paths[index],
                        dataType: 'json',
                        cache: true,
                        success: function(data) {
                            if (Array.isArray(data) && data.length > 0) {
                                initSalesPop(data);
                            }
                        },
                        error: function() {
                            tryNextPath(paths, index + 1);
                        }
                    });
                }

                tryNextPath(alternativePaths, 0);
            }
        });

     },5000);


        // Hàm khởi tạo popup sale
        function initSalesPop(salePopArr) {
            setTimeout(() => {
                $.getScript(fakerScript)
                    .done(function () {
                       // console.log("fakerScript loaded!");
                        //console.log("faker:", window.faker);
                        if (window.faker) {
                            showSalePop(salePopArr);
                        }
                    })
                    .fail(function (jqxhr, settings, exception) {
                        //console.error("Lỗi khi tải fakerScript:", exception);
                    });
            }, 1000); // Đợi 1 giây trước khi tải faker
        }

        // Hàm hiển thị popup sale
        function showSalePop(salePopArr) {
           // console.log("Gọi showSalePop...");
            if (!window.faker) return;

            // Ẩn popup nếu đang hiển thị
            $("#ega-sale-pop.salepop-show")
                .removeClass("salepop-show")
                .addClass("salespop-close");

            let pdRanIndex = Math.floor(Math.random() * salePopArr.length);
            let salePopProduct = salePopArr[pdRanIndex];
            let randomMin = `${Math.floor(Math.random() * 59) + 1} phút`;

            // Kiểm tra customerGender trước khi sử dụng
            let customerGender = window.faker.random.arrayElement(["male", "female"]);
            let name = `${window.faker.name.lastName(customerGender)} ${window.faker.name.firstName(customerGender)}`;
            let phone = `xxx${window.faker.phone.phoneNumber().slice(-8)}`;
            let address = window.faker.random.arrayElement(window.faker.locales.vi.address.city_root || ["Hà Nội"]);

            const desc = (window.salesPopDesc || "[name] vừa mua [phone] tại [address] [time] trước")
                .replace("[name]", name)
                .replace("[phone]", phone)
                .replace("[time]", randomMin)
                .replace("[address]", address);

            const salesPopContent = `
                <div class="sale-pop-img">
                    <img src="${salePopProduct.img_url}" class="img-fluid" loading="lazy" alt="${salePopProduct.pd_title}" width="80" height="80"/>
                </div>
                <div class="sale-pop-body">
                    <div class="sale-pop-name">
                        <a href="/product/${salePopProduct.pd_url}.html">${salePopProduct.pd_title}</a>
                    </div>
                    <span class="sale-pop-desc">${desc}</span>
                </div>
            `;

            $(".sale-pop-wrap").html(salesPopContent);

            // Hiển thị popup
            setTimeout(() => {
                $("#ega-sale-pop").addClass("salepop-show").removeClass("salespop-close");

                setTimeout(() => {
                    $("#ega-sale-pop.salepop-show").removeClass("salepop-show").addClass("salespop-close");

                    setTimeout(() => {
                        showSalePop(salePopArr);
                    }, 1000); // Lặp lại sau 1 giây
                }, 10000); // Ẩn popup sau 10 giây
            }, 3000); // Hiện popup sau 3 giây

        }
        // Thêm sự kiện click cho nút đóng
        $(".sale-pop-close").click(function() {
            $("#ega-sale-pop").removeClass("salepop-show").addClass("salespop-close");
        });
    });

</script>

<style>
    #ega-sale-pop {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 400px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        z-index: 9999;
        display: none;
    }

   
    #ega-sale-pop.salepop-show {
        display: block !important;
    }

    #ega-sale-pop .sale-pop-wrap {
        display: flex;
        align-items: center;
        padding: 10px;
    }

    #ega-sale-pop .sale-pop-img {
        flex-shrink: 0;
        margin-right: 10px;
    }

    #ega-sale-pop .sale-pop-img img {
        border-radius: 50%;
    }

    #ega-sale-pop .sale-pop-body {
        flex-grow: 1;
    }

    #ega-sale-pop .sale-pop-name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    #ega-sale-pop .sale-pop-desc {
        font-size: 14px;
        color: #666;
    }
    .mid-footer{
        background-color: black;
    }
    .mini-cart .remove-item-cart{
        display:none !important;
    }
</style>
