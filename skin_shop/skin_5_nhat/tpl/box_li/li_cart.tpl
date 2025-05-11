<li class="cart-item">
    <div class="cart-item-inner">
        <div class="cart-item-image">
            <a href="/product/{link}.html" title="{tieu_de}" target="_blank">
                <img loading="lazy" src="/thumbnail.php?w=320&img={minh_hoa}" alt="{tieu_de}" />
            </a>
        </div>
        <div class="cart-item-details">
            <div class="cart-item-header">
                <a href="javascript:;" title="Xóa" class="remove-item-cart" data-id="{id}">
                    <i class="fa fa-times"></i>
                </a>
                <h3 class="cart-item-title">
                    <a href="/product/{link}.html" title="{tieu_de}" target="_blank">{ten_sanpham}</a>
                </h3>
            </div>
            <div class="cart-item-footer">
                <div class="cart-item-price">{gia_moi}₫</div>
                <div class="cart-item-quantity">
                    <span class="quantity-label">Số lượng:</span>
                    <span class="quantity-value">{quantity}</span>
                </div>
            </div>
        </div>
    </div>
</li>

<style>
.cart-item {
    padding: 15px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.cart-item-inner {
    display: flex;
    gap: 15px;
}

.cart-item-image {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.cart-item-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.cart-item-header {
    position: relative;
}

.remove-item-cart {
    position: absolute;
    top: -40px;
    right: 0;
    color: #666;
    font-size: 16px;
    padding: 5px;
    cursor: pointer;
    transition: color 0.2s ease;
}

.remove-item-cart:hover {
    color: #dc3545;
}

.cart-item-title {
    margin: 0 0 10px;
    font-size: 14px;
    line-height: 1.4;
}

.cart-item-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.2s ease;
}

.cart-item-title a:hover {
    color: #007bff;
}

.cart-item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.cart-item-price {
    font-weight: 600;
    color: #dc3545;
    font-size: 15px;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #666;
    font-size: 13px;
}

.quantity-label {
    color: #666;
}

.quantity-value {
    font-weight: 500;
    color: #333;
}

@media (max-width: 576px) {
    .cart-item-inner {
        gap: 10px;
    }
    
    .cart-item-image {
        width: 60px;
        height: 60px;
    }
    
    .cart-item-title {
        font-size: 13px;
    }
    
    .cart-item-price {
        font-size: 14px;
    }
    
    .cart-item-quantity {
        font-size: 12px;
    }
}
</style>