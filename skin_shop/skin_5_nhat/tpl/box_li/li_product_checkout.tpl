<tr class="product">
    <td class="product-info">
        <div class="product-main">
            <div class="product-image">
                <div class="product-thumbnail">
                    <div class="product-thumbnail-wrapper">
                        <img class="product-thumbnail-image" alt="{tieu_de}" src="{minh_hoa}">
                    </div>
                    <span class="product-thumbnail-quantity" aria-hidden="true">{quantity}</span>
                </div>
            </div>
            <div class="product-content">
                <span class="product-description-name order-summary-emphasis">{ten_sanpham}</span>
                <span class="product-description-variant">{variant}</span>
                <div class="product-price">
                    <span class="order-summary-emphasis">{thanhtien}₫</span>
                </div>
            </div>
        </div>
    </td>
</tr>

<style>
.product {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.product:last-child {
    border-bottom: none;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.product-main {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    flex: 1;
}

.product-image {
    flex-shrink: 0;
}

.product-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 4px;
    position: relative;
    background: #fff;
}

.product-thumbnail-wrapper {
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
    border-radius: 4px;
}

.product-thumbnail-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-thumbnail-quantity {
    position: absolute;
    right: -6px;
    top: -6px;
    font-size: 11px;
    padding: 0 6px;
    height: 18px;
    min-width: 18px;
    line-height: 18px;
    border-radius: 9px;
    background: rgba(153, 153, 153, 0.9);
    color: #fff;
    text-align: center;
}

.product-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding-right: 8px;
}

.product-description-name {
    font-size: 13px;
    color: #333;
    margin: 0;
    line-height: 1.4;
}

.product-description-variant {
    font-size: 12px;
    color: #666;
}

.product-price {
    font-size: 13px;
    color: #333;
    font-weight: 500;
}

.order-summary-emphasis {
    font-weight: 500;
    color: #1f2937;
    font-size: 0.875rem;
}

.visually-hidden {
    display: none;
}

/* CSS cho phần thông tin sản phẩm */
.product-table {
    max-height: 400px; /* Chiều cao tối đa cho phần list sản phẩm */
    overflow-y: auto; /* Thêm thanh cuộn dọc khi vượt quá */
}

/* Tùy chỉnh thanh cuộn */
.product-table::-webkit-scrollbar {
    width: 4px;
}

.product-table::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.product-table::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 2px;
}

.product-table::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Điều chỉnh container chứa danh sách sản phẩm */
.order-summary-section-product-list {
    padding: 0;
    margin: 0;
}

.product-table tbody {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.product-table tr {
    display: block;
}
</style>