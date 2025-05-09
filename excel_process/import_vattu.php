<?php
include('../includes/tlca_world.php');
require_once '../PHPExcel/PHPExcel.php';
$file = './kho/chinh_hang.xlsx';
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
for ($i = 10; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
    }
}
$check=$tlca_do->load('class_check');
//print_r($data);
foreach ($data as $key => $value) {
	print_r($value);
	$ma_kieu_moi=preg_replace('/[^0-9A-Z]/', '', $ma_kieu);
	$ma_vt=addslashes($value[1]);
	$ten_vt=addslashes($value[1]);
	$don_vi=addslashes($value[2]);
	$ma_kho=addslashes($value[3]);
	$ten_kho=addslashes($value[4]);
	$gia_mua=addslashes($value[5]);
	$gia_ban=addslashes($value[6]);
	$ma_thue=addslashes($value[7]);
	$thue_suat=addslashes($value[8]);
	$ton=intval($value[9]);
	$kho='phutung';
	//mysqli_query($conn,"INSERT INTO kho(ma_vt,ten_vt,don_vi,ma_kho,ten_kho,gia_mua,gia_ban,ma_thue,thue_suat,ton,kho)VALUES('$ma_vt','$ten_vt','$don_vi','$ma_kho','$ten_kho','$gia_mua','$gia_ban','$ma_thue','$thue_suat','$ton','$kho')");
	echo $ten_vt.'<br>';
}
?>