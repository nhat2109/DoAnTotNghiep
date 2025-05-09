<?php
include('../includes/tlca_world.php');
require_once '../PHPExcel/PHPExcel.php';
$file = 'tinh_ninja.xlsx';
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
for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
    }
}
$check=$tlca_do->load('class_check');
//print_r($data);
/*foreach ($data as $key => $value) {
	print_r($value);
	$ten_tinh=addslashes($value[0]);
	$ma_tinh=addslashes($value[1]);
	$ten_huyen=addslashes($value[2]);
	$ma_huyen=addslashes($value[3]);
	$ten_x=addslashes($value[4]);
	$ma_xa=addslashes($value[5]);
	$level=addslashes($value[6]);
	$thongtin=mysqli_query($conn,"SELECT * FROM tinh_ninja WHERE ma_tinh='$ma_tinh'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		mysqli_query($conn,"INSERT INTO tinh_ninja(ten_tinh,ma_tinh,thu_tu)VALUES('$ten_tinh','$ma_tinh','$ma_tinh')");
		echo 'Đã thêm '.$ten_tinh.'<br>';
	}else{
		echo 'Đã có '.$ten_tinh.'<br>';
	}
}*/
/*foreach ($data as $key => $value) {
	print_r($value);
	$ten_tinh=addslashes($value[0]);
	$ma_tinh=addslashes($value[1]);
	$ten_huyen=addslashes($value[2]);
	$ma_huyen=addslashes($value[3]);
	$ten_x=addslashes($value[4]);
	$ma_xa=addslashes($value[5]);
	$level=addslashes($value[6]);
	$thongtin=mysqli_query($conn,"SELECT * FROM huyen_ninja WHERE ma_huyen='$ma_huyen' AND ma_tinh='$ma_tinh'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		mysqli_query($conn,"INSERT INTO huyen_ninja(ma_tinh,ten_huyen,ma_huyen,thu_tu)VALUES('$ma_tinh','$ten_huyen','$ma_huyen','$ma_huyen')");
		echo 'Đã thêm '.$ten_huyen.'/'.$ten_tinh.'<br>';
	}else{
		echo 'Đã có '.$ten_huyen.'/'.$ten_tinh.'<br>';
	}
}*/
foreach ($data as $key => $value) {
	print_r($value);
	$ten_tinh=addslashes($value[0]);
	$ma_tinh=addslashes($value[1]);
	$ten_huyen=addslashes($value[2]);
	$ma_huyen=addslashes($value[3]);
	$ten_xa=addslashes($value[4]);
	$ma_xa=addslashes($value[5]);
	$level=addslashes($value[6]);
	$thongtin=mysqli_query($conn,"SELECT * FROM xa_ninja WHERE ma_huyen='$ma_huyen' AND ma_tinh='$ma_tinh' AND ma_xa='$ma_xa'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		mysqli_query($conn,"INSERT INTO xa_ninja(ma_tinh,ma_huyen,ma_xa,ten_xa,level,thu_tu)VALUES('$ma_tinh','$ma_huyen','$ma_xa','$ten_xa','$level','$ma_xa')");
		echo 'Đã thêm '.$ten_xa.'/'.$ten_huyen.'/'.$ten_tinh.'<br>';
	}else{
		echo 'Đã có '.$ten_xa.'/'.$ten_huyen.'/'.$ten_tinh.'<br>';
	}
}
?>