<div class="li_product">
	<div class="product-content">
		<div class="product-thumbnail">
			<a href="/product/{link}.html">
				{frame}
				<img class="minh_hoa" src="{minh_hoa}">
			</a>
			{label_sale}
            <div class="product-action">
                <div class="group_action">
                    <button class="btn-views add_to_cart active" sp_id="{id}" loai="{loai}" title="Thêm vào giỏ hàng">
                        <i class="fa fa-cart-plus"></i>
                    </button>
                    <a title="Xem nhanh" href="javascript:;" sp_id="{id}" class="xem_nhanh btn-circle btn-views">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </div>
		</div>
        <div class="product-info">
            <h3 class="product-name"><a href="/product/{link}.html" title="">{tieu_de}</a></h3>
            <div class="price-box">
                <span class="price">{gia_moi}₫</span>
                <span class="compare-price">{gia_cu}₫</span>
            </div>
            <!-- <img class="product-badge" src="/skin/css/images/label_1.png?v=113" alt="Flash Sale"> -->
        </div>
<!--         <div class="flashsale__bottom" style="">
            <div class="flashsale__label">{text_flash_sale}</div>
            <div class="flashsale__progressbar">
                <div class="flashsale___percent" style="width: {phantram}%;"></div>
            </div>
        </div> -->
	</div>
</div>