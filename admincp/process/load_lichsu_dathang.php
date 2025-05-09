<?php
$user_id = intval($_REQUEST['user_id']);
$page = intval($_REQUEST['page']);
$limit = 100;
$list = $class_index->list_donhang_drop_member($conn, $user_id, $page, $limit);
if ($page == 1) {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = '<tr>
                <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                <th style="text-align: left;">Mã đơn</th>
                <th style="text-align: left;" class="hide_mobile">Ngày</th>
                <th style="text-align: left;">ĐT TV</th>
                <th style="text-align: left;width: 150px;">Tên thành viên</th>
                <th style="text-align: left;">Điện thoại</th>
                <th style="text-align: left;width: 150px;">Họ và tên</th>
                <th style="text-align: center;">Sản phẩm</th>
                <th style="text-align: left;" class="hide_mobile">Giá trị</th>
                <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
                <th style="text-align: center;width: 140px;">Hành động</th>
            </tr><tr><td colspan="11" align="center">Chưa có giao dịch nào!</td></tr>';
    } else {
        $load = 1;
        $page++;
        $list = '<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Mã đơn</th>
                    <th style="text-align: left;" class="hide_mobile">Ngày</th>
                    <th style="text-align: left;">ĐT TV</th>
                    <th style="text-align: left;width: 150px;">Tên thành viên</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;width: 150px;">Họ và tên</th>
                    <th style="text-align: center;">Sản phẩm</th>
                    <th style="text-align: left;" class="hide_mobile">Giá trị</th>
                    <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
                    <th style="text-align: center;width: 140px;">Hành động</th>
                </tr>' . $list;
    }
} else {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = '<tr><td colspan="11" align="center">Không còn dữ liệu</td></tr>';
    } else {
        $load = 1;
        $page++;
    }
}
$info = array(
    'list' => $list,
    'page' => $page,
    'load' => $load
);
echo json_encode($info);
