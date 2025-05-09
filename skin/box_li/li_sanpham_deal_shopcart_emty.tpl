<div class="deal-product-item">
    <div class="deal-product-thumbnail">
        <a href="/product/{link}.html">
            <img src="{minh_hoa}" alt="{tieu_de}">
            <div class="discount-badge">-{giam}%</div>
        </a>
    </div>
    <a href="/product/{link}.html" class="product-name">{tieu_de}</a>
    <div class="price-box">
        <span class="price">{gia_moi}₫</span>
        <span class="compare-price">{gia_cu}₫</span>
    </div>
</div>
<style>
    .deal-product-thumbnail {
        position: relative;
    }

    .discount-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        padding: 2px 6px;
        font-size: 10px;
        font-weight: bold;
        border: 1px solid #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        z-index: 2;
    }
</style>