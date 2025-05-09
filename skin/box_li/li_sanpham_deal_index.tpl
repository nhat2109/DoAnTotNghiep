<!-- <div class="li_product">
	<div class="product-content">
		<div class="product-thumbnail">
			<a href="/product/{link}.html">
				<img class="minh_hoa" src="{minh_hoa}">
			</a>
		</div>
        <div class="product-info">
            <h3 class="product-name"><a href="/product/{link}.html" title="">{tieu_de}</a></h3>
            <div class="price-box">
                <span class="price">{gia_moi}₫</span>
                <span class="compare-price"><span class="old-price">{gia_cu}₫</span> <span class="giam">{giam}%</span></span>
            </div>
            <div class="line_quantity">
                <div class="line_phantram">
                    <div class="text">Còn 5/10 suất</div>
                    <span style="width: 50%;"></span>
                </div>
            </div>
        </div>
	</div>
</div> -->


<div class="li_product" style="position: relative;">
    <div class="product-content">
        <!-- Container hình ảnh với vị trí relative để overlay định vị chính xác -->
        <div class="product-thumbnail" style="position: relative; overflow: hidden;"
            onmouseover="this.querySelector('.product-action').style.transform='translateY(0)';"
            onmouseout="this.querySelector('.product-action').style.transform='translateY(100%)';">
            <div class="flash-sale">{text_flash_sale}</div>
            <div class="giam">-{giam}%</div>
            <a href="/product/{link}.html">
                <img class="minh_hoa" src="{minh_hoa}" style="display: block; width: 100%;">
            </a>
            <div class="product-action"
                style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); display: flex; justify-content: center; align-items: center; gap: 20px; transform: translateY(100%); transition: transform 0.5s ease;">
                <button sp_id="{id}" pl="{pl}" title="Thêm vào giỏ hàng"
                    style="display: inline-flex; justify-content: center; align-items: center; width: 45px; height: 45px; background: #fff; border: none; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.15); cursor: pointer; color: #e53935;"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.backgroundColor='#f7f7f7';"
                    onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#fff';"
                    class="btn-views q_add_to_cart active">
                    <i class="fa fa-cart-plus"></i>
                </button>
                <a sp_id="{id}" pl="{pl}" title="Xem nhanh" href="javascript:;"
					style="display: inline-flex; justify-content: center; align-items: center; width: 45px; height: 45px; border: 1px solid #ccc; background: #fff; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.15); cursor: pointer; color: #333; text-decoration: none;"
					onmouseover="this.style.transform='scale(1.05)'; this.style.backgroundColor='#f7f7f7';"
					onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#fff';"
					class="xem_nhanh btn-circle btn-views">
					<i class="fa fa-eye"></i>
				</a>
            </div>

        </div>
        <!-- Thông tin sản phẩm bên dưới hình ảnh -->
        <div class="product-info">
            <h3 class="product-name">
                <a href="/product/{link}.html" title="">{tieu_de}</a>
            </h3>
            <div class="price-box">
                <span class="price">{gia_moi}₫</span>
                <span class="compare-price"><span class="old-price">{gia_cu}₫</span> </span>
            </div>
        </div>
    </div>
</div>
<style>
    .flash-sale {
        position: absolute;
        top: -2px;
        left: -1px;
        /* background: linear-gradient(135deg, #00c853, #64dd17);  */
        /* background: linear-gradient(135deg, #304ffe, #6200ea);   */
        /* background: linear-gradient(135deg, #ff4081, #d500f9);  */
        background: linear-gradient(135deg, #ffaeae, #ff0000);  
        color: white;
        font-weight: bold;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 10;
        text-transform: uppercase;
        letter-spacing: 1px;    
    }

    .giam {
        position: absolute;
        top: -2px;
        right: -1px;
        background: linear-gradient(135deg, #ff7f00, #ff5500);
        color: white;
        font-weight: bold;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    /* CSS riêng cho Mobile */
    @media (max-width: 768px) {
        .giam {
            top: 2px;
            right: 2px;
            font-size: 12px;
            padding: 3px 6px;
        }
    }
</style>