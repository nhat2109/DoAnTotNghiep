<tr id="tr_{user_id}" data-dropship="{dropship}" data-leader="{leader}" data-created="{created}">
  <td style="text-align: center" class="hide_mobile">{i}</td>
  <td style="text-align: left;" data-fulltext="{name}">
    <a href="/admincp/edit-thanhvien?id={user_id}" style="color: {style_color}">{name}</a>
</td>
	<td style="text-align: left;" class="hide_mobile"><a href="/admincp/edit-thanhvien?id={user_id}" style="color: {style_color}; width: 10%;">{username}</a></td></td>
	<td style="text-align: center;" class="hide_mobile">{leader}</td>
  <td style="text-align: left;  width: 10%;" class="ten_quanly hide_mobile">{nguoi_quanly}</td></td>
  <td style="text-align: center;" class="hide_mobile">{add_hot}</td>
  <td style="text-align: center" class="hide_mobile">{created}</td>
  <td style="text-align: center" class="hide_mobile">{mobile}</td>
  <td style="text-align: center" class="hide_mobile">{email}</td>
  <td style="text-align: center;" class="hide_mobile">{user_money}</td>
	<td style="text-align: center;" class="hide_mobile">{user_money2}</td>
  <td style="text-align: center; width: 20%;" class="drop_status">
		{tinh_trang}
	</td>
  <!-- <td style="text-align: center; width: 20%;">
    <a href="/admincp/edit-thanhvien?id={user_id}" class="edit">Chi tiết</a>
    <a
      href="javascript:;"
      onclick="confirm_del('del','thanhvien', 'Xác nhận xóa thành viên', '{user_id}');"
      class="del">xóa</a>
  </td> -->
</tr>
<script>
    $(document).ready(function(){
        $('tr').each(function(){ // Duyệt qua từng hàng <tr>
            var dropship = parseInt($(this).attr('data-dropship')); // Lấy giá trị dropship từ từng hàng
            if (dropship === 0) {
                $(this).find('.add_hot').removeClass('add_hot'); // Xóa class add_hot chỉ trong hàng đó
            }
        });
    });
</script>


