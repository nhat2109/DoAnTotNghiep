<div class="thongbao_add_follow"></div>

<tr id="tr_{id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: center;" class="hide_mobile image-col">
		<div class="image-container">
			<a href="/product/{link}.html" target="_blank">
				<img src="{minh_hoa}" width="100">
			</a>
			<div class="overlay">
				<a href="javascript:;" class="icon-heart add_to_cart_new" sp_id="{id}" size="{size_active}"
					color="{color_active}" pl="{pl}">
					<img src="/images/cart.png" alt="thêm giỏ hàng">
				</a>
				<a href="javascript:;" class="add_follow" sp_id="{id}">
					<img src="/images/favourite.png" class="icon-cart {class_follow}" alt="yêu thích">
				</a>
			</div>
		</div>
	</td>



	<td style="text-align: left;" class="hide_mobile">{list_ma}</td>
	<td style="text-align: left;" class="name-col">
		<a href="/product/{link}.html" target="_blank">{tieu_de}</a>
	</td>
	<!-- <td style="text-align: center;" class="hide_mobile">{size}</td> -->
	<td style="text-align: center;" class="hide_mobile">{gia_cu}</td>
	<td style="text-align: center;" class="hide_mobile">{gia_moi}</td>
	<td style="text-align: center;" class="hide_mobile">{drop_min}</td>
	<td style="text-align: center;" class="color_red bold">
		{gia_nhap}
		<div class="loi_nhuan" style="{display_loinhuan}">
			Lợi nhuận tối thiểu<br><span>{loi_nhuan}</span>
		</div>
	</td>
	<td style="text-align: center;">{kho}</td>
	<td style="text-align: center;">
		<a href="javascript:;" class="edit bg_green in_line dat_ngay" sp_id="{id}" size="{size_active}"
			color="{color_active}" pl="{pl}">
			<i class="fa fa-plus-circle"></i> Đặt ngay
		</a>
		<a href="/ncc-share-sanpham?id={id}" class="flex share_facebook" sp_id="{id}">
			<span>Đăng bán</span>
			<img src="/images/fb_zalo.png">
		</a>
	</td>
</tr>


<style>
	/* Điều chỉnh kích thước cột: image cột cho ảnh, name cột cho tiêu đề sản phẩm */
	td.image-col {
		width: 120px;
		/* Cột ảnh được dành không gian rộng hơn */
	}

	td.name-col {
		width: 150px;
		/* Cột tên thu nhỏ lại */
	}

	/* Các thiết lập cho container ảnh */
	.image-container {
		position: relative;
		display: inline-block;
	}

	.image-container img {
		display: block;
		width: 100%;
	}

	/* Overlay ẩn ban đầu, chiếm 50% chiều cao của ảnh */
	.overlay {
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		height: 50%;
		background-color: rgba(94, 89, 89, 0.502);
		/* Nền đen với độ mờ 0.5, điều chỉnh theo ý muốn */
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 15px;
		transform: translateY(100%);
		opacity: 0;
		transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
		border-top: 2px solid #6E6666;
		/* Stroke-top: 6E6666 */
	}

	/* Khi hover vào container ảnh, overlay xuất hiện */
	tr:hover .image-container .overlay {
		transform: translateY(0);
		opacity: 1;
	}

	/* Định dạng cho các liên kết trong overlay */
	.overlay a {
		text-decoration: none;
	}

	/* Định dạng cho ảnh icon bên trong overlay */
	.overlay a img {
		width: 32px;
		/* Kích thước cố định cho icon */
		height: 32px;
		object-fit: contain;
		border: 2px white solid;
		border-radius: 50px;
	}

	/* Nếu cần, tắt pseudo-element của Font Awesome (nếu lớp icon được dùng) */
	.icon-heart::before,
	.icon-cart::before {
		content: none !important;
	}

	/* Nếu muốn icon trái tim (favorite) có màu đỏ, có thể dùng filter hoặc thay thế ảnh đỏ sẵn */

	.list_baiviet tr:nth-child(2n+1) {
		z-index: 920;
	}

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