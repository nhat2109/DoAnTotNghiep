

<tr id="tr_{user_id}" data-ctv="{ctv}" data-created="{created}">
    <td style="text-align: center" class="hide_mobile">{i}</td>
    <td style="text-align: left;" data-fulltext="{name}">
        <a href="/admincp/edit-thanhvien?id={user_id}" style="color: {style_color}">{name}</a>
    </td>
    <td style="text-align: left;" class="hide_mobile">
        <a href="/admincp/edit-thanhvien?id={user_id}" style="color: {style_color}">{username}</a>
    </td>
    <td style="text-align: center;" class="hide_mobile">{mobile}</td>
    <td style="text-align: center" class="hide_mobile">{email}</td>
    <td style="text-align: center" class="hide_mobile">{created}</td>
    <td style="text-align: center" class="hide_mobile">{dia_chi}</td>
    <td style="text-align: center" class="hide_mobile">{user_money}</td>
    <td style="text-align: center;" class="drop_status">{tinh_trang}</td>
    <td style="text-align: center;">
        <a href="/admincp/edit-thanhvien?id={user_id}" class="edit">Sửa</a>
        <a href="javascript:;" onclick="confirm_del('del', 'nhacungcap', 'Xác nhận xóa nhà cung cấp', '{user_id}');" class="del">Xóa</a>
    </td>
</tr>