<tr id="tr_{id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: center;text-transform: uppercase;">{tieu_de}</td>
	<td style="text-align: center;" class="hide_mobile">{thu_tu}</td>
	<td style="text-align: center;">
		<a href="/ncc/edit-size?id={id}" class="custom-action-edit edit"><i class="fa fa-edit"></i></a>
		<a href="javascript:;" onclick="confirm_del('del','size', 'Xác nhận xóa kích cỡ', '{id}')"
			class="custom-action-delete del"><i class="fa fa-trash"></i></a>
	</td>
	<td style="text-align: center;">
		<input type="checkbox" class="selectItem" value="{id}">
	</td>
</tr>

<style>
	/* Định dạng cho nút Sửa và Xóa */
	.custom-action-edit,
	.custom-action-delete {
		display: inline-block;
		padding: 4px 8px;
		/* Giảm padding từ 5px 10px xuống 4px 8px */
		margin: 0 4px;
		/* Thêm margin giữa các nút */
		text-decoration: none;
		color: #fff;
		border-radius: 4px;
		transition: background-color 0.3s ease, color 0.3s ease;
		font-size: 14px;
		/* Giảm font-size từ 16px xuống 14px */
	}

	/* Màu sắc cho nút Sửa (xanh lá) */
	.custom-action-edit {
		background-color: #28a745;
	}

	.custom-action-edit:hover {
		background-color: #218838;
		color: #fff;
	}

	/* Màu sắc cho nút Xóa (đỏ) */
	.custom-action-delete {
		background-color: #dc3545;
	}

	.custom-action-delete:hover {
		background-color: #c82333;
		color: #fff;
	}

	/* Đảm bảo icon Font Awesome hiển thị đúng */
	.custom-action-edit i,
	.custom-action-delete i {
		vertical-align: middle;
	}

	/* Responsive: Điều chỉnh kích thước trên mobile */
	@media (max-width: 768px) {

		.custom-action-edit,
		.custom-action-delete {
			padding: 2px 6px;
			/* Giảm padding thêm trên mobile */
			font-size: 12px;
			/* Giảm font-size trên mobile */
			margin: 0 2px;
			/* Giảm margin trên mobile */
		}
	}

	/* Đảm bảo cột hành động không bị tràn */
	td[style="text-align: center;"] {
		white-space: nowrap;
		/* Ngăn text hoặc icon tràn dòng */
	}
	.custom-action-edit i,
	.custom-action-delete i {
		font-size: 16px;
	}
</style>