<tr id="tr_{nhom}-{user_id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: left;">{username}</td>
	<td style="text-align: left;">{mobile}</td>
	<td style="text-align: left;">{name}</td>
	<td style="text-align: center;">{vaitro}</td>
	<td style="text-align: center;">{total_donhang}</td>
	<td style="text-align: center;">{total_doanhso}</td>
	<td style="text-align: center;">
		<a href="/admincp/thongke-donhang-thanhvien?id={user_id}" class="edit in_line bg_blue"><i class="fa fa-bar-chart-o"></i>Thống kê</a>
		<a href="javascript:;" onclick="confirm_del('del','thanhvien_nhom', 'Xác nhận xóa thành viên nhóm', '{nhom}-{user_id}');" class="del in_line"><i class="fa fa-trash"></i>xóa</a>
	</td>
</tr>