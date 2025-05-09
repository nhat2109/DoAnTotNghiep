<?php
$user_id = intval($_REQUEST['user_id']);
$page = intval($_REQUEST['page']);
$limit = 100;
$list = $class_index->list_thanhvien_nhom_chuyennghiep($conn, $user_id, $page, $limit);
if ($page == 1) {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = ' <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;width:180px;">Tài khoản</th>
                    <th style="text-align: left;width: 180px;">Họ và tên</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;">Số dư</th>
                    <th style="text-align: center;width: 200px;">Loại tài khoản</th>
                    <th style="text-align: left;width: 150px;">Ngày tham gia</th>
                    <th style="text-align: center;width: 140px;">Hành động</th>
                </tr><tr><td colspan="8" align="center">Chưa có thành viên nào!</td></tr>';
    } else {
        $load = 1;
        $page++;
        $list = ' <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;width:180px;">Tài khoản</th>
                    <th style="text-align: left;width: 180px;">Họ và tên</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;">Số dư</th>
                    <th style="text-align: center;width: 200px;">Loại tài khoản</th>
                    <th style="text-align: left;width: 150px;">Ngày tham gia</th>
                    <th style="text-align: center;width: 140px;">Hành động</th>
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
$user_id = intval($_REQUEST['user_id']);
$page = intval($_REQUEST['page']);
$limit = 100;
$list = $class_index->list_thanhvien_nhom_chuyennghiep($conn, $user_id, $page, $limit);
if ($page == 1) {
    if (strlen($list) < 50) {
        $load = 0;
        $page = 1;
        $list = ' <tr>
                        <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                        <th style="text-align: left;width:180px;">Tài khoản</th>
                        <th style="text-align: left;width: 180px;">Họ và tên</th>
                        <th style="text-align: left;">Điện thoại</th>
                        <th style="text-align: left;">Số dư</th>
                        <th style="text-align: center;width: 200px;">Loại tài khoản</th>
                        <th style="text-align: left;width: 150px;">Ngày tham gia</th>
                        <th style="text-align: center;width: 140px;">Hành động</th>
                    </tr><tr><td colspan="8" align="center">Chưa có thành viên nào!</td></tr>';
    } else {
        $load = 1;
        $page++;
        $list = ' <tr>
                        <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                        <th style="text-align: left;width:180px;">Tài khoản</th>
                        <th style="text-align: left;width: 180px;">Họ và tên</th>
                        <th style="text-align: left;">Điện thoại</th>
                        <th style="text-align: left;">Số dư</th>
                        <th style="text-align: center;width: 200px;">Loại tài khoản</th>
                        <th style="text-align: left;width: 150px;">Ngày tham gia</th>
                        <th style="text-align: center;width: 140px;">Hành động</th>
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
