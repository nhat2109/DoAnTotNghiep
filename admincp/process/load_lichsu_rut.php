<?php
$user_id = intval($_REQUEST['user_id']);
$page = intval($_REQUEST['page']);
$limit = 100;
$list = $class_index->list_ruttien_member($conn, $user_id, $page, $limit);
if ($page == 1) {
    if (strlen($list) < 50) {
        $load = 0;
        $list = '<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Thời gian</th>
                    <th style="text-align: left;">Thành viên</th>
                    <th style="text-align: left;">Số tiền</th>
                    <th style="text-align: left;">Chủ khoản</th>
                    <th style="text-align: left;">Số tài khoản</th>
                    <th style="text-align: left;">Ngân hàng</th>
                    <th style="text-align: center;" class="hide_mobile">Trạng thái</th>
                    <th style="text-align: center;width: 120px;">Hành động</th>
                </tr><tr><td colspan="9" align="center">Chưa có giao dịch nào!</td></tr>';
        $page = 1;
    } else {
        $load = 1;
        $page++;
        $list = '<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Thời gian</th>
                    <th style="text-align: left;">Thành viên</th>
                    <th style="text-align: left;">Số tiền</th>
                    <th style="text-align: left;">Chủ khoản</th>
                    <th style="text-align: left;">Số tài khoản</th>
                    <th style="text-align: left;">Ngân hàng</th>
                    <th style="text-align: center;" class="hide_mobile">Trạng thái</th>
                    <th style="text-align: center;width: 120px;">Hành động</th>
                </tr>' . $list;
    }
} else {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = '<tr><td colspan="9" align="center">Không còn dữ liệu!</td></tr>';
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
