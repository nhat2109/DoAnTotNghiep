<tr>
	<td style="text-align:center;">{id}</td>
	<td style="text-align:center;">{ten_sanpham}<br></td>
    <td style="text-align:center;"><img src="{minh_hoa}" style="max-width:40px;"><br></td>
	<td style="text-align:center;">{username}<br><img src="{avatar}" style="max-width:30px;border-radius:50%;"></td>
	<td style="text-align:center;">{rating}/5</td>
	<td style="text-align:left;">{comment}</td>
	<td style="text-align:center;">{ngay}</td>
	<td style="text-align:center;">
		<span class="badge badge-{status_class}">{status_text}</span>
	</td>
	<td style="text-align:center;">
		<button class="btn btn-xs btn-success btn-duyet-danhgia" data-id="{id}" {duyet_disabled}>Duyệt</button>
		<button class="btn btn-xs btn-warning btn-an-danhgia" data-id="{id}" {an_disabled}>Ẩn</button>
		<button class="btn btn-xs btn-danger btn-xoa-danhgia" data-id="{id}">Xóa</button>
	</td>
</tr> 