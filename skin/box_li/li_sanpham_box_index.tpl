<div class="li_product">
	<div class="product-content">
		<!-- Container hình ảnh với vị trí relative để overlay định vị chính xác -->
		<div class="product-thumbnail" style="position: relative; overflow: hidden;"
			onmouseover="this.querySelector('.product-action').style.transform='translateY(0)';"
			onmouseout="this.querySelector('.product-action').style.transform='translateY(100%)';">
			<a href="/product/{link}.html">
				<img class="minh_hoa" src="{minh_hoa}" style="display: block; width: 100%;">
			</a>
			{label_sale}
			<div class="product-action"
				style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); display: flex; justify-content: center; align-items: center; gap: 20px; transform: translateY(100%); transition: transform 0.5s ease;">
				<button sp_id="{id}" title="Thêm vào giỏ hàng"
					style="display: inline-flex; justify-content: center; align-items: center; width: 45px; height: 45px; background: #fff; border: none; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.15); cursor: pointer; color: #e53935;"
					onmouseover="this.style.transform='scale(1.05)'; this.style.backgroundColor='#f7f7f7';"
					onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#fff';"
					class="btn-views q_add_to_cart add_to_cart active">
					<i class="fa fa-cart-plus"></i>
				</button>
				<a sp_id="{id}" title="Xem nhanh" href="javascript:;"
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
				<span class="compare-price">{gia_cu}₫</span>
			</div>
		</div>
		<!-- <div class="sp-da-ban" data-id="{id}" data-sold="{sold}" data-total="{total}">
			<div class="buyed-text">Đã bán {sold}</div>
			<div class="buyed-progess-no">
				<div class="buyed-progess-ele per10">
					<div class="buyed-progess-ele-color" style="width: {progress}%"></div>
				</div>
			</div>
		</div> -->
		
	</div>
</div>