<div class="selected-product" sp="{id}">
    <img src="{minh_hoa}" alt="{ten_sp}">
    <div class="selected-product-info">
        <div class="name">{ten_sp}</div>
        <div class="price">
            <div class="price-old">{gia_cu}</div>
            <div class="price-new">{gia_moi}</div>
        </div>
        <div class="variant-list" id="variant_list_{id}">
         
        </div>
    </div>
    <button class="remove-product">Xóa</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm định dạng số theo kiểu Việt Nam
    function formatNumberVN(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ';
    }

    var variants = JSON.parse('{variants}');
    var html = '';
    variants.forEach(function(variant) {
        html += '<div class="variant-item" variant_id="' + variant.variant_id + '">';
        html += '<span>' + variant.ten_color + ' - ' + variant.ten_size + '</span>';
        html += '<div class="variant-price">';
        html += '<span class="price-old">' + formatNumberVN(variant.gia_cu) + '</span>';
        // html += '<span class="price-new">' + formatNumberVN(variant.gia_moi) + '</span>';
        html += '</div>';
        html += '<div class="stock">Kho: ' + (variant.stock || 0) + ' sản phẩm</div>';
        html += '<input type="number" class="quantity-input" name="quantity_' + variant.variant_id + '" placeholder="Số lượng flash sale" value="' + (variant.quantity || '') + '" min="0" data-stock="' + (variant.stock || 0) + '">';
        var giaDealFormatted = variant.gia_deal ? formatNumberVN(variant.gia_deal) : '';
        html += '<input type="text" name="gia_deal_' + variant.variant_id + '" placeholder="Giá flash sale" value="' + giaDealFormatted + '">';
        html += '</div>';
    });
    document.getElementById('variant_list_{id}').innerHTML = html;

    // Gắn sự kiện kiểm tra số lượng kho khi nhập
    $('#variant_list_{id} .quantity-input').on('input', function() {
        var stock = parseInt($(this).data('stock')) || 0;
        var quantity = parseInt($(this).val()) || 0;
        if (quantity > stock) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Số lượng flash sale vượt quá số lượng kho (' + stock + ' sản phẩm)!');
            $(this).val(stock);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }
    });

    // Gắn sự kiện để định dạng giá flash sale khi người dùng nhập
    $('#variant_list_{id} input[name^="gia_deal_"]').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, '');
        if (value) {
            $(this).val(formatNumberVN(value));
        }
    });
});
</script>