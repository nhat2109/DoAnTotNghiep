<tr id="tr_{user_id}" style="color: {style_color}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: left;"><a href="/admincp/edit-thanhvien?id={user_id}" style="color: {style_color}">{name}</a></td>
	<td style="text-align: left;" class="hide_mobile"><a href="/admincp/edit-thanhvien?id={user_id}" style="color: {style_color}">{username}</a></td></td>
	<td style="text-align: center;" class="hide_mobile">{mobile}</td>
	<td style="text-align: center;" class="hide_mobile">{user_money}</td>
	<td style="text-align: center;" class="hide_mobile">{user_money2}</td>
	<td style="text-align: center;" class="hide_mobile">{total_thanhvien}</td>
	<td style="text-align: center;" class="drop_status">
		{created}
	</td>
	<td style="text-align: center;">
		<a href="/admincp/list-hoahong?id={user_id}" class="button bg_orange">List hoa hồng</a>
		<a href="javascript:;" class="button bg_brown capnhat_donhang_nhom" user="{user_id}">Cập nhật hoa hồng 1.5%</a>
		<a href="javascript:;" class="button bg_blue capnhat_donhang" user="{user_id}">Cập nhật hoa hồng 5%</a>
	</td>
</tr>