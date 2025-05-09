<?php
include('../includes/tlca_world.php');
require_once '../PHPExcel/PHPExcel.php';
$file = './kho/noi_that.xlsx';
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
	//$ma_kieu_moi=preg_replace('/[^0-9A-Z]/', '', $ma_kieu);
	$ma_vt=addslashes($value[1]);
	$ten_vt=addslashes($value[3]);
	$don_vi=addslashes($value[4]);
	$ma_kho=0201;
	$ten_kho='Kho phụ kiện nội thất';
	//$gia_mua=addslashes($value[5]);
	//$gia_ban=addslashes($value[6]);
	//$ma_thue=addslashes($value[7]);
	//$thue_suat=addslashes($value[8]);
	echo 'Tồn excel: '.str_replace(',', '.', $value[5]).'<br>';
	$ton=preg_replace('/[^0-9.]/', '', str_replace(',', '.', $value[5]));
	echo 'Tồn xử lý excel: '.$ton.'<br>';
	$kho='noithat';
	if(strlen($ma_vt)>2){
		$thongtin=mysqli_query($conn,"SELECT * FROM kho WHERE ma_vt='$ma_vt'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			mysqli_query($conn,"INSERT INTO kho(ma_vt,minh_hoa,ten_vt,don_vi,ma_kho,ten_kho,gia_mua,gia_ban,ma_thue,thue_suat,ton,kho)VALUES('$ma_vt','','$ten_vt','$don_vi','$ma_kho','$ten_kho','0','0','10','10','$ton','$kho')");
			echo 'Thêm mới '.$ten_vt.' thành '.$ton.'<br>';
		}else{
			mysqli_query($conn,"UPDATE kho SET ton='$ton',kho='$kho' WHERE ma_vt='$ma_vt'");
			echo 'Cập nhật tồn '.$ten_vt.' thành '.$ton.'<br>';
		}
	}else{

	}

}
?>