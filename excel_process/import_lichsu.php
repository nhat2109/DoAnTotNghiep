<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = './lich-su/31.xls';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
$LastColumn = $sheet->getHighestColumn();

//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

//Tạo mảng chứa dữ liệu
$data = [];

//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
$hientai=time();
for ($i = 1; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
    }
}
//print_r($data);
foreach ($data as $key => $value) {
	print_r($value);
	$ngay=addslashes($value[0]);
	$tach_ngay=explode('/', $ngay);
	$date_time=mktime(0,0,0,$tach_ngay[0],$tach_ngay[1],$tach_ngay[2]);
	$lenh=addslashes($value[1]);
	$bks=addslashes($value[2]);
	$so_khung=addslashes($value[3]);
	$ma_kieu=addslashes($value[4]);
	$so_km=preg_replace('/[^0-9]/', '', $value[5]);
	$ho_ten=addslashes($value[6]);
	$dia_chi=addslashes($value[7]);
	$lai_xe=addslashes($value[8]);
	$huyen=addslashes($value[9]);
	$tinh=addslashes($value[10]);
	$cong_phutung=addslashes($value[11]);
	if($cong_phutung==''){
		$cong_phutung='tong';
	}
	$ma=addslashes($value[12]);
	$ten=addslashes($value[13]);
	$cong_viec=addslashes($value[14]);
	$so_luong=addslashes($value[15]);
	$gia_von=addslashes(preg_replace('/[^0-9]/', '', $value[16]));
	$gia_ban=addslashes(preg_replace('/[^0-9]/', '', $value[17]));
	$tien_ban=addslashes(preg_replace('/[^0-9]/', '', $value[18]));
	$chiet_khau=addslashes(preg_replace('/[^0-9]/', '', $value[19]));
	$sau_chietkhau=addslashes(preg_replace('/[^0-9]/', '', $value[20]));
	$thue=addslashes(preg_replace('/[^0-9]/', '', $value[21]));
	$doanh_thu=addslashes(preg_replace('/[^0-9]/', '', $value[22]));
	$co_van=addslashes($value[23]);
	$ten_kieu=addslashes($value[24]);
	$back_color=addslashes($value[25]);
	$phan_loai=addslashes($value[26]);
	mysqli_query($conn,"INSERT INTO lichsu_suachua(ngay,ma_lenh,bks,so_khung,ma_kieu,so_km,ho_ten,dia_chi,lai_xe,huyen,tinh,cong_phutung,ma,ten,cong_viec,so_luong,gia_von,gia_ban,tien_ban,chiet_khau,sau_chietkhau,thue,doanh_thu,co_van,ten_kieu,back_color,phan_loai,date_time)VALUES('$ngay','$lenh','$bks','$so_khung','$ma_kieu','$so_km','$ho_ten','$dia_chi','$lai_xe','$huyen','$tinh','$cong_phutung','$ma','$ten','$cong_viec','$so_luong','$gia_von','$gia_ban','$tien_ban','$chiet_khau','$sau_chietkhau','$thue','$doanh_thu','$co_van','$ten_kieu','$back_color','$phan_loai','$date_time')");
	echo 'Đã thêm '.$bks.' - '.$cong_viec.'<br>';
}
?>