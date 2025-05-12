
<?php
$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
$thu_tu = intval($_REQUEST['thu_tu']);
$brand=addslashes(strip_tags($_REQUEST['brand']));
$id_thuonghieu_socdo = intval($_REQUEST['id_thuonghieu_socdo']);
$tach_key = explode(' ', $tieu_de);
		$k = 0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$tenthuonghieu .= "tieu_de LIKE '%$value%'";
				} else {
					$tenthuonghieu .= " AND tieu_de LIKE '%$value%'";
				}
			}
		}
$thuonghieu_socdo = mysqli_query($conn, "SELECT COUNT(*) AS total FROM thuong_hieu WHERE shop=0 AND $tenthuonghieu");
$r_tt = mysqli_fetch_assoc($thuonghieu_socdo);
if (strlen($tieu_de) < 2) {
    $ok = 0;
    $thongbao = 'Tên thương hiệu phải có ít nhất 2 ký tự';
}else if($r_tt['total'] > 0) {
    if(strlen($brand)>0) {
        $thongbao = 'Thêm thương hiệu thành công';
        $ok = 1;
        mysqli_query($conn, "INSERT INTO thuong_hieu(shop, tieu_de, thu_tu, id_thuonghieu_socdo, trang_thai_duyet) VALUES('$user_id', '$tieu_de', '$thu_tu', '$id_thuonghieu_socdo', 0)");
    }
    else {
        $ok = 0;
        $thongbao = 'Tên thương hiệu đã tồn tại trên socdo.vn, vui lòng chọn từ socdo.vn';
    }
} 
else {
    $thongbao = 'Thêm thương hiệu thành công';
    $ok = 1;
    mysqli_query($conn, "INSERT INTO thuong_hieu(shop, tieu_de, thu_tu, id_thuonghieu_socdo, trang_thai_duyet) VALUES('$user_id', '$tieu_de', '$thu_tu', '$id_thuonghieu_socdo', 0)");
}

$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>