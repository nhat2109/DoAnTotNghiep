<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = 'banggia_noithat.xlsx';
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
foreach ($data as $key => $value) {
	$model=addslashes($value[0]);
	$stt=intval($value[1]);
	$ma_nt=addslashes($value[2]);
	$ten_nt=addslashes($value[3]);
	$don_vi=addslashes($value[4]);
	$so_luong=addslashes($value[5]);
	$gia=addslashes($value[6]);
	$cong=addslashes($value[7]);
	$thanh_tien=addslashes($value[8]);
	$ghi_chu=addslashes($value[9]);
	if(strpos($thanh_tien, '=')!==false){
		$thanh_tien=$gia + $cong;
	}else{
		
	}
	mysqli_query($conn,"INSERT INTO gia_noithat(thu_tu,ma_nt,model,ten_nt,don_vi,so_luong,thanh_tien,ghi_chu)VALUES('$stt','$ma_nt','$model','$ten_nt','$don_vi','$so_luong','$thanh_tien','$ghi_chu')");
	print_r($value);
}
?>