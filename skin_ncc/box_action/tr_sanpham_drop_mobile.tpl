<div class="thongbao_add_follow"></div>

<div class="li_sanpham_drop" id="tr_{id}">
	<div class="minh_hoa"><a href="/product/{link}.html" target="_blank"><img src="{minh_hoa}"
				width="200"></a></div>
	<div class="tieu_de"><a href="/product/{link}.html" target="_blank">{tieu_de}</a></div>
	<div class="info_sanpham">
		<div class="left">
			<div class="li_info_left"><span>Mã:</span><span>{list_ma}</span></div>
			<div class="li_info_left"><span>Giá niêm yết:</span><span>{gia_cu}</span></div>
			<div class="li_info_left"><span>Giá bán:</span><span>{gia_moi}</span></div>
			<div class="li_info_left"><span>Bán tối thiểu:</span><span>{drop_min}</span></div>
			<div class="li_info_left"><span>Giá nhập:</span><span>{gia_nhap}</span></div>
			<div class="li_info_left"><span>Kho:</span><span>{kho}</span></div>
		</div>
		<div class="right">
			<div class="list_action">
				<a href="javascript:;" class="bg_green dat_ngay" pl="{pl}" sp_id="{id}" size="{size_active}"
					color="{color_active}"><i class="fa fa-plus-circle"></i> Đặt ngay</a>
				<a href="javascript:;" class="bg_orange add_to_cart_new" pl="{pl}" sp_id="{id}" size="{size_active}"
					color="{color_active}"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</a>
				<a href="/ncc/list-share-sanpham?id={id}" class="flex share_facebook" sp_id="{id}"><span>Đăng
						bán</span><img src="/images/fb_zalo.png"></a>
				<a href="javascript:;" class="edit bg_orange in_line add_follow" sp_id="{id}"
					style="margin-top: 0px;"><i class="fa {class_follow}"></i> Thêm yêu thích</a>
				<div class="loi_nhuan" style="{display_loinhuan}">Lợi nhuận tối thiểu<br><span>{loi_nhuan} đ</span>
				</div>
			</div>
		</div>
	</div>
	<div class="info_rutgon">
		<div class="input_aff">
			<input type="text" id="link_aff_{id}" name="link_aff"
				value="https://socdo.vn/product/{link}.html?utm_source={user_id}"><button class="copy_aff"><i
					class="icofont-ui-copy"></i> copy</button>
		</div>
		<div class="input_aff"><button class="rutgon_link_drop" sp_id="{id}">Rút gọn link affiliate</button></div>
		<div class="input_aff input_rutgon">
			{rut_gon}
		</div>
	</div>
</div>

<style>
	.thongbao_add_follow {
		position: fixed;
		top: 50px;
		right: 50px;
		/* vị trí cố định cách mép phải 50px */
		background: rgb(241, 116, 116);
		color: #fff;
		padding: 10px 20px;
		border-radius: 4px;
		font-size: 13px;

		opacity: 0;
		z-index: 10000;
	}

	/* Khi thêm class "show", thông báo sẽ chạy vào rồi chạy ra */
	.thongbao_add_follow.show {
		animation: slideInOut 3s forwards;
	}

	/* Keyframes: slide in từ bên phải, giữ lại rồi slide out */
	@keyframes slideInOut {
		0% {
			opacity: 0;
			transform: translateX(100%);
		}

		10% {
			opacity: 1;
			transform: translateX(0);
		}

		90% {
			opacity: 1;
			transform: translateX(0);
		}

		100% {
			opacity: 0;
			transform: translateX(100%);
		}
	}
</style>