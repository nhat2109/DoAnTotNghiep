<div class="shopping-cart-item">
    <div class="item-image">
        <a href="/product/{link}.html" title="{tieu_de}" target="_blank">
            <img src="{minh_hoa}" alt="{tieu_de}">
        </a>
    </div>

    <div class="item-info">
        <div class="item-details">
            <h3 class="item-name">
                <a href="/product/{link}.html" title="{tieu_de}" target="_blank">{ten_sanpham}</a>
            </h3>
            <div class="variant-info">{variant_info}</div>
            <div class="item-price">{gia_moi}₫</div>
        </div>

        <div class="item-quantity">
            <div class="quantity-control">
                <button type="button" class="btn-minus" data-id="{id}" data-color="{color}"
                    data-size="{size}">−</button>
                <input type="text" name="quantity" value="{quantity}" class="input-text number-sidebar" data-id="{id}"
                    data-color="{color}" data-size="{size}">
                <button type="button" class="btn-plus" data-id="{id}" data-color="{color}" data-size="{size}">+</button>
            </div>
            <a href="javascript:;" class="remove-item-cart-shop" data-id="{id}" data-color="{color}" data-size="{size}">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>


<style>
    .shopping-cart-item {
        display: flex;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    .item-image {
        width: 100px;
        margin-right: 20px;
    }

    .item-image img {
        width: 100%;
        height: auto;
        border-radius: 4px;
    }

    .item-info {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        margin: 0 0 5px;
        font-size: 16px;
    }

    .item-name a {
        color: #333;
        text-decoration: none;
    }

    .variant-info {
        color: #666;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .item-price {
        color: #2563eb;
        font-weight: 600;
        font-size: 16px;
    }

    .item-quantity {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .btn-minus,
    .btn-plus {
        width: 32px;
        height: 32px;
        border: none;
        background: #f5f5f5;
        color: #333;
        font-size: 16px;
        cursor: pointer;
    }

    .input-text.number-sidebar {
        width: 61px !important;
        height: 32px;
        border: none;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        text-align: center;
        font-size: 14px;
        margin: 0;
    }

    .remove-item-cart-shop {
        color: #666;
        font-size: 18px;
        text-decoration: none;
        padding: 5px;
    }

    .remove-item-cart-shop:hover {
        color: #ef4444;
    }

    @media (max-width: 576px) {
        .shopping-cart-item {
            flex-direction: column;
        }

        .item-image {
            width: 100%;
            margin-bottom: 15px;
        }

        .item-info {
            flex-direction: column;
            gap: 15px;
        }

        .item-quantity {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>