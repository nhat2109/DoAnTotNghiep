<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = 'khach-hang.xlsx';
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
//print_r($data);
foreach ($data as $key => $value) {
	$ho_ten=$value[2];
	$dia_chi=addslashes($value[3]);
	$tinh=addslashes($value[4]);
	$huyen=addslashes($value[5]);
	$dien_thoai=$value[6];
	$email=$value[7];
	if(strpos($dien_thoai, 'blank')!==false){
		$dien_thoai='';
	}
	if(strpos($email, 'blank')!==false){
		$email='';
	}
	$bks=$value[0];
	$so_khung=$value[1];
	if(strpos($so_khung, 'blank')!==false){
		$so_khung='';
	}
	$ma_kx=$value[8];
	if(strpos($ma_kx, 'blank')!==false){
		$ma_kx='';
	}
	$hang_xe=$value[9];
	$model=$value[10];
	if(strpos($model, 'blank')!==false){
		$model='';
	}
	$kieu_xe=$value[11];
	if(strpos($kieu_xe, 'blank')!==false){
		$kieu_xe='';
	}
	$ma_mau=$value[12];
	if(strpos($ma_mau, 'blank')!==false){
		$ma_mau='';
	}
	$ten_mau=$value[13];
	if(strpos($ten_mau, 'blank')!==false){
		$ten_mau='';
	}

	mysqli_query($conn,"INSERT INTO khach_hang(user_id,ho_ten,dia_chi,dien_thoai,email,tinh,huyen,bks,so_khung,ma_kx,hang_xe,model,ten_kieu,ma_mau,ten_mau,date_post,update_post)VALUES('0','$ho_ten','$dia_chi','$dien_thoai','$email','$tinh','$huyen','$bks','$so_khung','$ma_kx','$hang_xe','$model','$kieu_xe','$ma_mau','$ten_mau',".time().",".time().")");
	echo 'Đã thêm khách hàng: '.$ho_ten.' - Xe: '.$hang_xe.' - model: '.$model.' - BKS: '.$bks.'<br>';
}
?>