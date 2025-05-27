<tr id="tr_{user_id}">
	<td style="text-align: center;" class="hide_mobile">{i}</td>
	<td style="text-align: left;color: red;font-weight: 700;">{user_id}</td>
	<td style="text-align: left;">{name}</td>
	<td style="text-align: center;" class="hide_mobile">{email}</td>
	<td style="text-align: center;" class="hide_mobile">{tinh_trang}</td>
	<td style="text-align: center;" class="hide_mobile">{created}</td>
	<td style="text-align: center;">
		<a href="/ncc/edit-thanhvien?id={user_id}" class="edit custom-action-edit"><i class="fa fa-edit"></i></a><a href="javascript:;" onclick="confirm_del('del','thanhvien', 'Xác nhận xóa thành viên', '{id}');" class="del custom-action-delete"><i class="fa fa-trash"></i></a>
	</td>
</tr>


<style>
    
    .custom-action-edit,
    .custom-action-delete {
        display: inline-block;
        padding: 4px 8px;
        margin: 0 4px;
        text-decoration: none;
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
        font-size: 14px;
    }

  
    .custom-action-edit {
        background-color: #28a745;
    }

    .custom-action-edit:hover {
        background-color: #218838;
        color: #fff;
    }

   
    .custom-action-delete {
        background-color: #dc3545;
    }

    .custom-action-delete:hover {
        background-color: #c82333;
        color: #fff;
    }

  
    .custom-action-edit i,
    .custom-action-delete i {
        vertical-align: middle;
        font-size: 16px;
    }


    @media (max-width: 768px) {
        .custom-action-edit,
        .custom-action-delete {
            padding: 2px 6px;
            font-size: 12px;
            margin: 0 2px;
        }
    }

    td[style="text-align: center;"] {
        white-space: nowrap;
    }
</style>