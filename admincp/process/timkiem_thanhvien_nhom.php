<?php
$key = addslashes(strip_tags($_REQUEST['key']));
$nhom=intval($_REQUEST['id']);
$thongtin_nhom=mysqli_query($conn,"SELECT * FROM nhom WHERE id='$nhom'");
$r_nhom=mysqli_fetch_assoc($thongtin_nhom);
$list = $class_index->list_kq_timkiem_thanhvien_nhom($conn,$r_nhom['nhomtruong'],$nhom, $key);
$list = '<tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
            <th style="text-align: left;">Tài khoản</th>
            <th style="text-align: left;">Điện thoại</th>
            <th style="text-align: left;">Họ và tên</th>
            <th style="text-align: center;">Vai trò</th>
            <th style="text-align: center;">Tổng đơn hàng</th>
            <th style="text-align: center;">Tổng doanh số</th>
            <th style="text-align: center;width: 150px;">Hành động</th>
        </tr>'.$list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);


?>