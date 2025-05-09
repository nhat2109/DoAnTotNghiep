<?php
$user_id = intval($_REQUEST['user_id']);
$page = intval($_REQUEST['page']);
$limit = 100;
$list = $class_index->list_chitieu_member($conn, $user_id, $page, $limit);
if ($page == 1) {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = '<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;width: 150px;">Thời gian</th>
                    <th style="text-align: left;">Thành viên</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;width: 120px;">Số tiền</th>
                    <th style="text-align: left;width: 120px">Số dư trước</th>
                    <th style="text-align: left;width: 120px;">Số dư sau</th>
                    <th style="text-align: left;">Nội dung chi tiêu</th>
                </tr><tr><td colspan="8" align="center">Không còn dữ liệu!</td></tr>';
    } else {
        $load = 1;
        $page++;
        $list = '<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;width: 150px;">Thời gian</th>
                    <th style="text-align: left;">Thành viên</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;width: 120px;">Số tiền</th>
                    <th style="text-align: left;width: 120px">Số dư trước</th>
                    <th style="text-align: left;width: 120px;">Số dư sau</th>
                    <th style="text-align: left;">Nội dung chi tiêu</th>
                </tr>' . $list;
    }
} else {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = '<tr><td colspan="8" align="center">Không còn dữ liệu!</td></tr>';
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
