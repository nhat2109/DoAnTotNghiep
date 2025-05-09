<tr id="tr_{id}" data-status="{status}">
    <td style="text-align: center;" class="hide_mobile">{i}</td>
    <td style="text-align: left;" class="hide_mobile">{list_ma}</td>
    <td style="text-align: center;" class="hide_mobile"><a href="/product/{link}.html" target="_blank"><img src="/thumbnail.php?w=320&img={minh_hoa}" width="80"></a></td>
    <td style="text-align: left;"><a href="/product/{link}.html" target="_blank">{tieu_de}</a></td>
    <td style="text-align: center;" class="hide_mobile">{user_info}</td>
    <td style="text-align: center;" class="hide_mobile">{kho}</td>
    <td style="text-align: center;" class="hide_mobile">{gia_cu}</td>
    <td style="text-align: center;" class="hide_mobile">{gia_moi}</td>
    <td style="text-align: center;" class="hide_mobile">{gia_drop}</td>
    <td style="text-align: center;" class="hide_mobile">{gia_ctv}</td>
    <td style="text-align: center;" class="hide_mobile">{drop_min}</td>
    <td style="text-align: center;">
        <div class="action_product">
            <!--//3-4-->
            <!-- <a href="/admincp/list-share-sanpham?id={id}" class="{bg_noidung}">Nội dung bán hàng</a>
            <a href="/admincp/edit-sanpham?id={id}" class="bg_green">Sửa</a>
            <a href="javascript:;" onclick="confirm_del('del','sanpham', 'Xác nhận xóa sản phẩm', '{id}');" class="bg_red">Xóa</a> -->
            {show_approve_button}
        </div>
        <span class="status status-{status}">{status_text}</span>
    </td>
</tr>