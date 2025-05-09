<tr id="tr_{user_id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: left;color: red;font-weight: 700;">{user_id}</td>
	<td style="text-align: left;">{name}</td>
	<td style="text-align: center;" class="hide_mobile">{email}</td>
	<td style="text-align: center;" class="hide_mobile">{tinh_trang}</td>
	<td style="text-align: center;" class="hide_mobile">{created}</td>
	<td style="text-align: center;">
		<a href="/ncc/edit-thanhvien?id={user_id}" class="edit">Chi tiết</a><a href="javascript:;" onclick="confirm_del('del','thanhvien', 'Xác nhận xóa thành viên', '{id}');" class="del">xóa</a>
	</td>
</tr>