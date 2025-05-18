<!-- Tìm kiếm nâng cao -->
<div class="li_danhmuc_timkiem">
	<div class="li_danhmuc_content_timkiem">
		<a href="/san-pham/{cat_blank}.html">
			<div class="minh_hoa_timkiem">
				{label_sale}
				<img src="{cat_minhhoa}" alt="{cat_tieude}">
			</div>
			<div class="tieu_de_timkiem">{cat_tieude}</div>
		</a>
	</div>
</div>
<style>
	.list_danhmuc_timkiem {
		display: flex;
		/* Sử dụng Flexbox để xếp ngang */
		flex-wrap: nowrap;
		/* Không cho phép xuống hàng */
		justify-content: space-between;
		/* Căn đều các danh mục */
		width: 100%;
		/* Đảm bảo container chiếm toàn bộ chiều rộng */
		overflow-x: auto;
		/* Nếu danh mục vượt quá chiều rộng, cho phép cuộn ngang */
	}

	.li_danhmuc_content_timkiem {
		width: 19%;
		/* Mỗi danh mục chiếm 19% chiều rộng (5 danh mục, trừ khoảng cách) */
		margin: 0 0.5%;
		/* Khoảng cách giữa các danh mục */
		text-align: center;
		/* Căn giữa nội dung */
		flex-shrink: 0;
		/* Ngăn danh mục bị co lại */
	}

	.minh_hoa_timkiem img {
		max-width: 100%;
		/* Đảm bảo hình ảnh không vượt quá chiều rộng container */
		height: auto;
		/* Giữ tỷ lệ hình ảnh */
	}

	.tieu_de_timkiem {
		font-size: 14px;
		/* Thu nhỏ chữ nếu cần */
		white-space: nowrap;
		/* Ngăn tiêu đề xuống hàng */
		overflow: hidden;
		text-overflow: ellipsis;
		/* Hiển thị "..." nếu tiêu đề quá dài */
	}

	.box_danhmuc_noibat_timkiem .container {
		width: 100%;
		/* Đảm bảo container chiếm toàn bộ chiều rộng */
		padding: 0;
		/* Bỏ padding nếu cần */
	}
</style>