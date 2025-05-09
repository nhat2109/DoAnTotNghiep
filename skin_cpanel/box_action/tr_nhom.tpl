<tr id="tr_{id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: left;">{tieu_de}</td>
	<td style="text-align: center;">{total_member}</td>
	<td style="text-align: center;" class="hide_mobile">{date_post}</td>
	<td style="text-align: center;">
		<a href="/admincp/add-thanhvien-nhom?id={id}" class="edit in_line bg_green"><i class="fa fa-plus"></i>Thêm thành viên</a>
		<a href="/admincp/list-thanhvien-nhom?id={id}" class="edit in_line bg_violet"><i class="fa fa-list"></i>List thành viên</a>
		<a href="/admincp/thongke-doanhthu-nhom?id={id}" class="edit in_line bg_blue"><i class="fa fa-pie-chart"></i>Báo cáo doanh thu</a>
		<a href="/admincp/thongke-nhom?id={id}" class="edit in_line bg_green_bold"><i class="fa fa-bar-chart-o"></i>Thống kê đơn hàng</a>
		<a href="/admincp/edit-nhom?id={id}" class="edit in_line bg_orange"><i class="fa fa-edit"></i>Sửa nhóm</a>
		<a href="javascript:;" onclick="confirm_del('del','nhom', 'Xác nhận xóa nhóm kinh doanh', '{id}');" class="del in_line"><i class="fa fa-trash"></i>xóa nhóm</a>
	</td>
</tr>