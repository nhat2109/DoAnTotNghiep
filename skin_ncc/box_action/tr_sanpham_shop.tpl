<tr id="tr_{id}">
   
    <td style="text-align: center;"><input type="checkbox" class="select-item" data-id="{id}"></td> 
    <td style="text-align: center;" class="hide_mobile">{i}</td>
    <td style="text-align: center;" class="hide_mobile">{list_ma}</td>
    <td style="text-align: center;" class="hide_mobile">
        <a href="{domain}/product/{link}.html" target="_blank">
            <img src="{minh_hoa}" width="120" height="120">
        </a>
    
    </td>
    <td style="text-align: left;"><a href="{domain}/product/{link}.html" target="_blank">{tieu_de}</a></td>
    <td style="text-align: center;" class="hide_mobile">{gia_cu}</td>
    <td style="text-align: center;" class="hide_mobile color_red bold">{gia_moi}</td>
    <td style="text-align: center;" class="hide_mobile">{ban}</td>
    <td style="text-align: center;" class="hide_mobile">{kho_hang}</td>
    <td style="text-align: center;" class="hide_mobile">{view}</td>
    <td style="text-align: center;">
        <div class="action_product">
            <div class="action_suaxoa">
                <a href="/ncc/edit-sanpham?id={id}">
                    <i class="fa fa-edit"></i> Sửa
                </a>
                <a href="javascript:;" onclick="confirm_del('del','sanpham', 'Xác nhận xóa sản phẩm', '{id}');">
                    <i class="fa fa-trash-o"></i> Xóa
                </a>
            </div>
        </div>
    </td>
</tr>

