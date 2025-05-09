
<?php
$user_id = intval($_REQUEST['user_id']);
$page = intval($_REQUEST['page']);
$limit = 100;
$list = $class_index->list_naptien_member($conn, $user_id, $page, $limit);
if ($page == 1) {
    if (strlen($list) < 50) {
        $list = '<tr>
                <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                <th style="text-align: left;">Thời gian</th>
                <th style="text-align: left;">Thành viên</th>
                <th style="text-align: left;">Điện thoại</th>
                <th style="text-align: left;">Số tiền</th>
                <th style="text-align: left;">Nội dung chuyển khoản</th>
                <th style="text-align: center;" class="hide_mobile">Trạng thái</th>
                <th style="text-align: center;width: 120px;">Hành động</th>
            </tr><tr><td colspan="8" align="center">Không còn dữ liệu!</td></tr>';
        $load = 0;
        $page = 1;
    } else {
        $list = '<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Thời gian</th>
                    <th style="text-align: left;">Thành viên</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;">Số tiền</th>
                    <th style="text-align: left;">Nội dung chuyển khoản</th>
                    <th style="text-align: center;" class="hide_mobile">Trạng thái</th>
                    <th style="text-align: center;width: 120px;">Hành động</th>
                </tr>' . $list;
        $load = 1;
        $page++;
    }
} else {
    if (strlen($list) < 50) {
        $list = '<tr><td colspan="8" align="center">Không còn dữ liệu!</td></tr>';
        $load = 0;
        $page = 1;
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
