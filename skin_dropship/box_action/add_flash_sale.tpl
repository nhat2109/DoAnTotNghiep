<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 900px;">
            <div class="page_title">
                <h1 class="undefined">Thêm flash sale</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="box_deal_step">
                <div class="text_step">
                    <span class="active">1</span>
                </div>
                <div class="content_step">
                    <div class="title_step">Thông tin cơ bản</div>
                    <div class="tr_step">
                        <div class="step_left">Tên chương trình</div>
                        <div class="step_right">
                            <input type="text" name="tieu_de" placeholder="Nhập vào tên chương trình">
                        </div>
                    </div>
                    <div class="tr_step">
                        <div class="step_left">Thời gian bắt đầu/kết thúc</div>
                        <div class="step_right">
                            <div><input type="text" name="date_start" placeholder="Thời gian bắt đầu" class="datetimepicker_mask"></div>
                            <div style="padding: 10px;"><i class="fa fa-arrows-h"></i></div>
                            <div><input type="text" name="date_end" placeholder="Thời gian kết thúc" class="datetimepicker_mask"></div>                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="box_deal_step">
                <div class="text_step">
                    <span class="bg_violet">2</span>
                </div>
                <div class="content_step">
                    <div class="title_step">Sản phẩm</div>
                    <div class="tr_step"><button class="select_product_sub">Chọn sản phẩm</button></div>
                    <div class="tr_step">
                        <div id="list_product_sub" class="selected-products-container"></div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group" style="text-align: center;margin-top: 10px;">
                <button name="add_flash_sale" class="button_all">Hoàn thành</button>
            </div>
        </div>
    </div>
</div>

<!-- Popup chọn sản phẩm -->
<div id="product_popup" class="popup" style="display: none;">
    <div class="popup-content">
        <div class="popup-header">
            <h2>Chọn sản phẩm</h2>
            <span class="close_popup_flash_sale">×</span>
        </div>
        <div class="popup-body">
            <div class="search-bar">
                <input type="text" id="product_search" placeholder="Nhập để tìm kiếm sản phẩm...">
            </div>
            <div id="product_list" class="product-list"></div>
        </div>
        <div class="popup-footer">
            <button id="confirm_products">Hoàn thành</button>
        </div>
    </div>
</div>

<style>
/* CSS cho Popup */
.popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup-content {
    background: #fff;
    width: 80%;
    max-width: 900px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    height: 80vh; /* Chiều cao cố định cho popup */
}

.popup-header {
    padding: 3px 20px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.popup-header h2 {
    margin: 0;
    font-size: 20px;
    color: #333;
}

.close_popup_flash_sale {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    padding: 3px 7px;
    background-color: #ff0606;
    color: #fff;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 9px;
    transition: background-color 0.3s ease;
}

.close_popup_flash_sale:hover {
    background: #5c5858;
}

.popup-body {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    max-height: 81%;
}

.search-bar {
    margin-bottom: 20px;
}

.search-bar input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.product-list {
    overflow-y: auto; /* Tạo thanh cuộn dọc nếu nội dung vượt quá chiều cao */
    flex-grow: 1;
    scrollbar-width: thin; /* Độ mỏng của thanh cuộn trên Firefox */
    scrollbar-color: #ff6200 #f0f0f0; /* Màu sắc thanh cuộn trên Firefox */
}

/* Tùy chỉnh thanh cuộn trên Chrome, Edge, Safari */
.product-list::-webkit-scrollbar {
    width: 8px; /* Độ rộng thanh cuộn */
}

.product-list::-webkit-scrollbar-track {
    background: #f0f0f0; /* Màu nền của thanh cuộn */
    border-radius: 4px;
}

.product-list::-webkit-scrollbar-thumb {
    background: #ff6200; /* Màu của thanh kéo */
    border-radius: 4px;
}

.product-list::-webkit-scrollbar-thumb:hover {
    background: #e55a00; /* Màu khi hover */
}

.popup-footer {
    padding: 15px 20px;
    border-top: 1px solid #ddd;
    text-align: right;
}

.popup-footer button {
    padding: 4px 10px;
    background: #ff6200;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.popup-footer button:hover {
    background: #e55a00;
}

/* CSS cho danh sách sản phẩm trong popup */
.product-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.3s ease;
}

.product-item:hover {
    background-color: #f5f5f5;
}

.product-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 15px;
}

.product-info {
    flex-grow: 1;
}

.product-info .name {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.product-info .price {
    display: flex;
    gap: 10px;
    margin-top: 5px;
}

.price-old {
    color: #999;
    text-decoration: line-through;
    font-size: 14px;
}

.price-new {
    color: #ff6200;
    font-weight: bold;
    font-size: 14px;
}

.select-button {
    padding: 7px 8px;
    background: #ff6200;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.select-button:hover {
    background: #e55a00;
}

.select-button.disabled {
    background: #cccccc;
    cursor: not-allowed;
    opacity: 0.6;
}

/* CSS cho danh sách sản phẩm đã chọn trên giao diện chính */
.selected-products-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 10px;
}

.selected-product {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.selected-product:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.selected-product img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 20px;
}

.selected-product-info {
    flex: 1;
    min-width: 200px;
}

.selected-product-info .name {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.selected-product-info .price {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.selected-product .variant-list {
    width: 100%;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

.selected-product .variant-item {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin: 8px 0;
    padding: 8px;
    background: #f9f9f9;
    border-radius: 6px;
    gap: 1px;
}

.selected-product .variant-item span {
    flex: 1;
    font-size: 14px;
    color: #555;
    min-width: 94px;
}

.selected-product .variant-item .variant-price {
    display: flex;
    gap: 8px;
    min-width: 150px;
}

.selected-product .variant-item .stock {
    min-width: 55px;
    font-size: 14px;
    color: #333;
}

.selected-product .variant-item input.quantity-input,
.selected-product .variant-item input[name^="gia_deal_"] {
    width: 100px;
    padding: 6px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.selected-product .variant-item input.quantity-input:focus,
.selected-product .variant-item input[name^="gia_deal_"]:focus {
    border-color: #ff6200;
    outline: none;
}

.remove-product {
    background: #ff4444;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-left: auto;
}

.remove-product:hover {
    background: #e63e3e;
}

/* Responsive Design */
@media (max-width: 768px) { /* Tablet */
    .selected-product {
        flex-direction: column;
        align-items: flex-start;
    }

    .selected-product img {
        width: 60px;
        height: 60px;
        margin-right: 15px;
    }

    .selected-product-info {
        min-width: 100%;
    }

    .selected-product-info .name {
        font-size: 16px;
    }

    .selected-product .variant-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .selected-product .variant-item span,
    .selected-product .variant-item .variant-price,
    .selected-product .variant-item .stock,
    .selected-product .variant-item input.quantity-input,
    .selected-product .variant-item input[name^="gia_deal_"] {
        min-width: 100%;
        width: 100%;
    }

    .remove-product {
        margin-left: 0;
        margin-top: 10px;
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) { /* Mobile */
    .popup-content {
        width: 90%;
        height: 90vh;
    }

    .selected-product {
        padding: 10px;
    }

    .selected-product img {
        width: 50px;
        height: 50px;
    }

    .selected-product-info .name {
        font-size: 14px;
    }

    .selected-product-info .price .price-old,
    .selected-product .variant-item .variant-price .price-old {
        display: none; /* Ẩn giá cũ trên mobile để tiết kiệm không gian */
    }

    .selected-product .variant-item span {
        font-size: 12px;
    }

    .selected-product .variant-item input.quantity-input,
    .selected-product .variant-item input[name^="gia_deal_"] {
        width: 100%;
        font-size: 12px;
    }

    .remove-product {
        padding: 6px 10px;
        font-size: 12px;
    }
}
</style>

<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/>
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script src="/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".datepicker").datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
        $('input.timepicker').timepicker({'timeFormat': 'H:i:s', 'step': 5});
        $('.datetimepicker_mask').datetimepicker({
            format: 'H:i d/m/Y'
        });
        $.datepicker.setDefaults({
            closeText: "Đóng",
            prevText: "<Trước",
            nextText: "Tiếp>",
            currentText: "Hôm nay",
            monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"],
            monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
            dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
            dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tu",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        });

        // Mảng tạm để lưu các sản phẩm đã chọn trong popup
        var tempSelectedProducts = [];
        // Mảng để lưu các sản phẩm đã chọn trên giao diện chính
        var selectedProducts = [];

        // Khôi phục danh sách sản phẩm từ session khi tải trang
        $.ajax({
            url: '/dropship/process.php',
            type: 'post',
            data: {
                action: 'get_selected_products'
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success' && result.products) {
                    selectedProducts = JSON.parse(result.products);
                    displaySelectedProducts(selectedProducts);
                }
            }
        });

        // Hàm định dạng số theo kiểu Việt Nam
        function formatNumberVN(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Hàm hiển thị danh sách sản phẩm đã chọn trên giao diện chính
        function displaySelectedProducts(products) {
            var html = '';
            products.forEach(function(product) {
                // Kiểm tra xem product có variants không
                if (!product.variants || product.variants.length === 0) {
                    console.warn('Sản phẩm ' + product.name + ' (sp_id: ' + product.sp_id + ') không có biến thể.');
                    return; // Bỏ qua sản phẩm không có biến thể
                }

                html += '<div class="selected-product" sp="' + product.sp_id + '">';
                html += '<img src="' + product.minh_hoa + '" alt="' + product.name + '">';
                html += '<div class="selected-product-info">';
                html += '<div class="name">' + product.name + '</div>';
                html += '<div class="price">';
                html += '<div class="price-old">' + product.gia_cu + '</div>';
                html += '<div class="price-new">' + product.gia_moi + '</div>';
                html += '</div>';
                html += '<div class="variant-list">';
                product.variants.forEach(function(variant) {
                    html += '<div class="variant-item" variant_id="' + variant.variant_id + '">';
                    html += '<span>' + variant.ten_color + ' - ' + variant.ten_size + '</span>';
                    html += '<div class="variant-price">';
                    html += '<span class="price-old">' + variant.gia_cu + '</span>';
                    html += '<span class="price-new" style="color: #ff6200;">' + variant.gia_moi + '</span>';
                    html += '</div>';
                    html += '<div class="stock">Kho: ' + (variant.stock || 0) + '</div>';
                    html += '<input type="number" class="quantity-input" name="quantity_' + variant.variant_id + '" placeholder="Số lượng" value="' + (variant.quantity || '') + '" min="0" data-stock="' + (variant.stock || 0) + '">';
                    var giaDealFormatted = variant.gia_deal ? formatNumberVN(variant.gia_deal) : '';
                    html += '<input type="text" name="gia_deal_' + variant.variant_id + '" placeholder="Giá flash sale" value="' + giaDealFormatted + '">';
                    html += '</div>';
                });
                html += '</div>';
                html += '</div>';
                html += '<button class="remove-product">Xóa</button>';
                html += '</div>';
            });
            $('#list_product_sub').html(html);

            // Gắn sự kiện kiểm tra số lượng kho khi nhập
            $('.quantity-input').on('input', function() {
                var stock = parseInt($(this).data('stock')) || 0;
                var quantity = parseInt($(this).val()) || 0;
                if (quantity > stock) {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html('Số lượng nhập vượt quá số lượng kho (' + stock + ')!');
                    $(this).val(stock);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }
            });

            // Gắn sự kiện để định dạng giá flash sale khi người dùng nhập
            $('input[name^="gia_deal_"]').on('input', function() {
                var value = $(this).val().replace(/[^0-9]/g, ''); // Chỉ giữ số
                if (value) {
                    $(this).val(formatNumberVN(value));
                }
            });
        }

        // Hiển thị popup khi nhấn "Chọn sản phẩm"
        $('.select_product_sub').click(function() {
            $('#product_popup').show();
            $('#product_list').html('<div class="loading">Đang tải dữ liệu...</div>');

            // Làm mới tempSelectedProducts khi mở popup
            tempSelectedProducts = [];

            $.ajax({
                url: '/dropship/process.php',
                type: 'post',
                data: { action: 'get_product_variants' },
                success: function(response) {
                    var products = JSON.parse(response);
                    displayProducts(products);
                }
            });
        });

        // Hàm hiển thị danh sách sản phẩm trong popup
        function displayProducts(products) {
            var html = '';
            var selectedProductIds = selectedProducts.map(product => product.sp_id.toString());

            products.forEach(function(product) {
                var isSelected = selectedProductIds.includes(product.sp_id.toString());
                html += '<div class="product-item" data-sp="' + product.sp_id + '">';
                html += '<img src="/thumbnail.php?w=60&img=' + product.minh_hoa + '" alt="' + product.ten_sp + '">';
                html += '<div class="product-info">';
                html += '<div class="name">' + product.ten_sp + '</div>';
                html += '<div class="price">';
                html += '<div class="price-old">' + product.gia_cu + '</div>';
                html += '<div class="price-new">' + product.gia_moi + '</div>';
                html += '</div>';
                html += '</div>';
                html += '<button class="select-button' + (isSelected ? ' disabled' : '') + '" ' + (isSelected ? 'disabled' : '') + '>' + (isSelected ? 'Đã chọn' : 'Chọn') + '</button>';
                html += '</div>';
            });
            $('#product_list').html(html);
        }

        // Tìm kiếm sản phẩm trong popup
        $('#product_search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $.ajax({
                url: '/dropship/process.php',
                type: 'post',
                data: {
                    action: 'get_product_variants',
                    search: searchTerm
                },
                success: function(response) {
                    var products = JSON.parse(response);
                    displayProducts(products);
                }
            });
        });

        // Đóng popup
        $('.close_popup_flash_sale').click(function() {
            $('#product_popup').hide();
            $('#product_list').html('');
            $('#product_search').val('');
            tempSelectedProducts = [];
        });

        // Xử lý khi nhấn nút "Chọn" trong popup
        $('#product_list').on('click', '.select-button', function() {
            var $productItem = $(this).closest('.product-item');
            var sp_id = $productItem.data('sp').toString();

            // Kiểm tra xem sản phẩm đã có trong selectedProducts chưa
            if (selectedProducts.some(p => p.sp_id.toString() === sp_id)) {
                return; // Nếu đã có, không làm gì
            }

            var productInfo = {
                sp_id: sp_id,
                name: $productItem.find('.name').text(),
                gia_cu: $productItem.find('.price-old').text(),
                gia_moi: $productItem.find('.price-new').text(),
                minh_hoa: $productItem.find('img').attr('src'),
                variants: []
            };

            // Lấy danh sách biến thể của sản phẩm
            $.ajax({
                url: '/dropship/process.php',
                type: 'post',
                data: {
                    action: 'get_variants_by_product',
                    sp_id: sp_id
                },
                success: function(response) {
                    var variants = JSON.parse(response);
                    if (!variants || variants.length === 0) {
                        console.warn('Không tìm thấy biến thể cho sản phẩm sp_id:', sp_id);
                        return;
                    }
                    productInfo.variants = variants;
                    tempSelectedProducts.push(productInfo);
                    $productItem.find('.select-button').addClass('disabled').text('Đã chọn').prop('disabled', true);
                }
            });
        });

        // Xác nhận lựa chọn sản phẩm và hiển thị ra giao diện chính
        $('#confirm_products').click(function() {
            // Lọc tempSelectedProducts để đảm bảo không có sản phẩm trùng với selectedProducts
            var selectedProductIds = selectedProducts.map(product => product.sp_id.toString());
            tempSelectedProducts = tempSelectedProducts.filter(product => !selectedProductIds.includes(product.sp_id.toString()));

            // Thêm các sản phẩm từ tempSelectedProducts vào selectedProducts
            tempSelectedProducts.forEach(function(product) {
                selectedProducts.push(product);
            });

            // Hiển thị danh sách sản phẩm đã chọn
            displaySelectedProducts(selectedProducts);

            // Lưu vào session
            $.ajax({
                url: '/dropship/process.php',
                type: 'post',
                data: {
                    action: 'save_selected_products',
                    products: JSON.stringify(selectedProducts)
                },
                success: function(response) {
                    console.log('Saved selected products to session:', response);
                }
            });

            // Đóng popup
            $('#product_popup').hide();
            $('#product_list').html('');
            $('#product_search').val('');
            tempSelectedProducts = [];
        });

        // Xóa sản phẩm khỏi danh sách đã chọn
        $('#list_product_sub').on('click', '.remove-product', function() {
            var $product = $(this).closest('.selected-product');
            var sp_id = $product.attr('sp').toString();
            $product.remove();

            // Cập nhật lại selectedProducts
            selectedProducts = selectedProducts.filter(product => product.sp_id.toString() !== sp_id);

            // Cập nhật lại session
            $.ajax({
                url: '/dropship/process.php',
                type: 'post',
                data: {
                    action: 'save_selected_products',
                    products: JSON.stringify(selectedProducts)
                }
            });
        });

        // Xử lý khi nhấn "Hoàn thành"
        $('button[name="add_flash_sale"]').click(function(e) {
            e.preventDefault();

            var tieu_de = $('input[name="tieu_de"]').val();
            var date_start = $('input[name="date_start"]').val();
            var date_end = $('input[name="date_end"]').val();
            var sub_product = {};
            var sub_id = [];
            var list_product_sub = {};
            var quantities = {};

            // Debug: Kiểm tra số lượng sản phẩm đã chọn
            var selectedProductCount = $('#list_product_sub .selected-product').length;
            console.log('Số lượng sản phẩm đã chọn:', selectedProductCount);

            // Lấy danh sách sản phẩm đã chọn
            $('#list_product_sub .selected-product').each(function() {
                var sp_id = $(this).attr('sp');
                sub_product[sp_id] = [];
                list_product_sub[sp_id] = [];
                quantities[sp_id] = [];

                // Debug: Kiểm tra số lượng biến thể trong sản phẩm
                var variantCount = $(this).find('.variant-item').length;
                console.log('Sản phẩm sp_id:', sp_id, 'có số lượng biến thể:', variantCount);

                if (variantCount === 0) {
                    console.warn('Sản phẩm sp_id ' + sp_id + ' không có biến thể nào được hiển thị.');
                    return true; // Tiếp tục với sản phẩm tiếp theo
                }

                $(this).find('.variant-item').each(function() {
                    var variant_id = $(this).attr('variant_id');
                    // Bỏ định dạng giá flash sale trước khi gửi
                    var gia_deal = $(this).find('input[name="gia_deal_' + variant_id + '"]').val().replace(/[^0-9]/g, '') || 0;
                    var quantity = $(this).find('.quantity-input').val() || 0;
                    var stock = parseInt($(this).find('.stock').text().replace('Kho: ', '')) || 0;
                    var variantName = $(this).find('span').text().split(' - ');
                    var ten_color = variantName[0];
                    var ten_size = variantName[1];
                    var gia_cu = $(this).find('.variant-price .price-old').text().replace('đ', '').replace(/\./g, '');
                    var gia_moi = $(this).find('.variant-price .price-new').text().replace('đ', '').replace(/\./g, '');

                    // Debug: Kiểm tra dữ liệu biến thể
                    console.log('Biến thể:', { variant_id, ten_color, ten_size, gia_deal, quantity, stock });

                    // Kiểm tra số lượng trước khi gửi
                    if (quantity > stock) {
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        $('.load_note').html('Số lượng của biến thể ' + ten_color + ' - ' + ten_size + ' vượt quá số lượng kho (' + stock + ')!');
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);
                        return false;
                    }

                    sub_id.push(variant_id);
                    sub_product[sp_id].push({
                        variant_id: variant_id,
                        color: ten_color,
                        size: ten_size,
                        gia_cu: gia_cu,
                        gia: gia_deal
                    });
                    list_product_sub[sp_id].push({
                        variant_id: variant_id,
                        color: ten_color,
                        size: ten_size,
                        gia_cu: gia_cu,
                        gia: gia_moi
                    });
                    quantities[sp_id].push({
                        variant_id: variant_id,
                        quantity: quantity
                    });
                });
            });

            // Debug: Kiểm tra sub_id sau khi lặp
            console.log('sub_id sau khi lặp:', sub_id);

            if (sub_id.length === 0) {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $('.load_note').html('Vui lòng chọn sản phẩm! (Không tìm thấy biến thể nào hợp lệ)');
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
                return;
            }

            if (!tieu_de || !date_start || !date_end) {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $('.load_note').html('Vui lòng nhập đầy đủ thông tin cơ bản!');
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
                return;
            }

            // Gửi dữ liệu lên server
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/dropship/process.php',
                type: 'post',
                data: {
                    action: 'add_flash_sale',
                    tieu_de: tieu_de,
                    date_start: date_start,
                    date_end: date_end,
                    sub_product: JSON.stringify(sub_product),
                    sub_id: sub_id.join(','),
                    list_product_sub: JSON.stringify(list_product_sub),
                    quantities: JSON.stringify(quantities)
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    setTimeout(function() {
                        $('.load_note').html(result.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (result.ok === 1) {
                            window.location.href = '/dropship/list-flash-sale';
                        }
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    setTimeout(function() {
                        $('.load_note').html('Có lỗi xảy ra, vui lòng thử lại!');
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }
            });
        });
    });
</script>