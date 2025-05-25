<div class="quick-view-container" style="background-color: #f9f9f9; max-height: 80vh">
    <div class="row" style="display: flex; flex-wrap: wrap;">
        <div class="col-md-6 col-sm-12 col-xs-12 image-section" style="flex: 1 1 50%; padding: 10px;">
            <div class="large-image">
                <div class="main-image-container"
                    style="position: relative; max-width: 400px; max-height: 400px; width: 100%; height: 0; padding-bottom: 100%; overflow: hidden;">
                    <img class="img-responsive main-image" src="{minh_hoa}" alt="{tieu_de}"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; border-radius: 10px;">
                </div>
                <div class="thumbnail-container" style="margin-top: 10px; position: relative;">
                    <button class="prev-btn"
                        style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background: #fff; border: 1px solid #ddd; padding: 5px 10px; cursor: pointer; z-index: 10;">❮</button>
                    <div class="thumbnail-wrapper"
                        style="overflow: hidden; white-space: nowrap; scroll-behavior: smooth; width: 210px; margin: 0 auto; max-height: 70px;">
                        <div class="thumbnail-list" style="display: inline-flex; transition: transform 0.3s ease;">
                            {list_anh}
                        </div>
                    </div>
                    <button class="next-btn"
                        style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: #fff; border: 1px solid #ddd; padding: 5px 10px; cursor: pointer; z-index: 10;">❯</button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12 info-section" style="flex: 1 1 50%; padding: 10px; max-height: 100%;">
            <h1 class="product_title"
                style="font-size: 28px; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                {tieu_de}
            </h1>

            <div class="price-box clearfix" style="margin-bottom: 15px;">
                <div class="special-price">
                    <span class="price product-price" style="font-size: 24px; color: #d70018;" id="price">{gia_moi} đ</span>
                    <del style="font-size: 16px; color: #707070; margin-left: 10px;" class="price product-price-old" id="old-price">{gia_cu}₫</del>
                </div>
            </div>

            <div class="inventory_quantity" style="margin-bottom: 15px;">
                <span class="stock-brand-title"><strong>Tình trạng:</strong></span>
                <span class="a-stock" id="stock-status" style="margin-left: 5px;">{tinh_trang}</span>
            </div>

            <div class="form-product">
                <div class="color-options">
                    {option_mau}
                </div>
                {option_size}
                <div class="form-group" style="margin-bottom: 20px;">
                    <div class="quantity-wrapper">
                        <label>Số lượng</label>
                        <div class="quantity-controls">
                            <button class="btn-minus btn-cts" type="button">–</button>
                            <input type="text" class="qty input-text" id="quantity_quick_view" name="quantity" value="{quantity_default}" />
                            <button class="btn-plus btn-cts" type="button">+</button>
                        </div>
                    </div>

                    <div class="clearfix margin-bottom-20"></div>
                    <div class="action-buttons">
                        <!-- <button type="submit" class="btn btn-cart btn_buy {disabled}" id="buy-button"
                            sp_id="{id}" loai="{loai}" data-color="{color}" data-size="{size}">
                            <span class="txt-main">{text_button}</span>
                        </button> -->
                        <button type="submit" class="btn btn-cart btn_buy {disabled}" id="buy-button"
                            sp_id="{id}" loai="{loai}" data-variant-id="{variants[0].variant_id}">
                            <span class="txt-main">{text_button}</span>
                        </button>

                        <div class="support-buttons">
                            <a href="tel:{hotline_number}" class="hotline-button">
                                <i class="fas fa-phone"></i> Liên hệ
                            </a>
                            <a href="https://zalo.me/{hotline_number}" class="zalo-button">
                                <i class="fas fa-comments"></i> Tư vấn Zalo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {script_variants}
</div>

<style>
    /* Color swatches styling */
    .color-swatch {
        display: inline-block;
        margin: 5px;
    }

    .color-swatch input[type="radio"] {
        display: none;
    }

    .color-swatch label {
        display: block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #ddd;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .color-swatch input[type="radio"]:checked+label {
        border-color: #333;
        transform: scale(1.1);
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    /* Thumbnail styling */
    .thumbnail-list img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-right: 2px;
        border: 2px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .thumbnail-list img.active {
        border-color: #2196F3;
    }

    /* Quantity controls styling */
    .quantity-wrapper {
        margin: 15px 0;
    }

    .quantity-wrapper label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        max-width: 120px;
        border: 1px solid #ddd;
        border-radius: 4px;
        height: 43px;
    }

    .quantity-controls button {
        width: 30px;
        height: 30px;
        border: none;
        background: #f5f5f5;
        font-size: 16px;
        cursor: pointer;
    }

    .quantity-controls input {
        width: 40px;
        height: 30px;
        border: none;
        text-align: center;
        font-size: 14px;
        padding: 0px;
        margin: auto;
    }

    /* Action buttons styling */
    .action-buttons {
        margin-top: 20px;
    }

    .btn-cart {
        width: 100%;
        background: #FF5722;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        margin-bottom: 15px;
        padding: 0;
    }

    .special-price {
        display: flex;
        align-items: center;
    }

    .support-buttons {
        display: flex;
        gap: 10px;
    }

    .support-buttons a {
        flex: 1;
        padding: 10px;
        text-align: center;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        font-size: 14px;
    }

    .hotline-button {
        background: #dc3545;
    }

    .zalo-button {
        background: #0068ff;
    }

    .support-buttons i {
        margin-right: 5px;
    }
</style>