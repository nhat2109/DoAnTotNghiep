<tr id="tr_{id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: center;">{ngay}</td>
	<td style="text-align: left;">{tieu_de}</td>
	<td style="text-align: left;">{mo_ta}</td>
	<td style="text-align: center;">
		<a href="/admincp/edit-nhiemvu?id={id}" class="a_inline bg_green">Sửa</a>
		<a href="/admincp/add-noidung-nhiemvu?id={id}" class="a_inline bg_violet">Thêm nội dung</a>
		<a href="/admincp/list-noidung-nhiemvu?id={id}" class="a_inline bg_blue">List nội dung</a>
		<a href="javascript:;" onclick="confirm_del('del','nhiemvu', 'Xác nhận xóa nhiệm vụ', '{id}');" class="a_inline bg_red">xóa</a>
	</td>
</tr>