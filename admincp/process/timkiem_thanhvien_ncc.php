<?php
$key = addslashes(strip_tags($_REQUEST['key']));
$list = $class_index->list_kq_timkiem_thanhvien_ncc($conn, $key);
$list = ' <tr>
                    <th style="text-align: center; width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: left;">Tên nhà cung cấp</th>
                    <th style="text-align: left;" class="hide_mobile">Tài khoản</th>
                    <th style="text-align: left;" class="hide_mobile">Điện thoại</th>
                    <th style="text-align: left;" class="hide_mobile">Email</th>
                    <th style="text-align: left;" class="hide_mobile">Ngày đăng ký</th>
                    <th style="text-align: left;" class="hide_mobile">Địa chỉ</th>
                    <th style="text-align: left;" class="hide_mobile">Tài khoản chính</th>
                    <th style="text-align: left; width: 80px;">Tình trạng</th>
                    <th style="text-align: center; width: 140px;">Hành động</th>
                </tr>' . $list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);
?>