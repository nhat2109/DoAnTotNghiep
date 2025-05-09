<?php
include('../includes/tlca_world.php');
require_once '../PHPExcel/PHPExcel.php';
$file = 'baoduong.xlsx';
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
	print_r($value);
	$ma_kieu=addslashes($value[2]);
	$ma_kieu_moi=preg_replace('/[^0-9A-Z]/', '', $ma_kieu);
	$dong_co=addslashes($value[1]);
	$ten_kieu=addslashes($value[0]);
	$ten_full=addslashes($value[0]);
	$tach_tenkieu=explode(' ', $ten_kieu);
	$model=addslashes(str_replace(':', '', $tach_tenkieu[0]));
	//$grade='';
	$ten_cv=addslashes($value[3]);
	$ma_cv=addslashes($value[4]);
	$donvi_tinh=addslashes($value[5]);
	$cap_baoduong=addslashes($value[7]);
	$gia=(float)$value[6];
	$gia_tri=(float)$value[8];
	if(strpos($ten_cv,'lao động')==!false){
		$ten_cv='Bảo dưỡng cấp '.$cap_baoduong;
		$donvi_tinh='hs';
	}
	if($ma_kieu!=''){
		if($donvi_tinh=='hs'){
			$thongtin=mysqli_query($conn,"SELECT * FROM bao_duong WHERE ma_kieu_moi='$ma_kieu_moi' AND cap_baoduong='$cap_baoduong'");
			$total=mysqli_num_rows($thongtin);
			if($total>0){
				$r_tt=mysqli_fetch_assoc($thongtin);
				mysqli_query($conn,"UPDATE bao_duong SET donvi_tinh='$donvi_tinh',gia='$gia',gia_tri='$gia_tri',ma_cv='$ma_cv' WHERE id='{$r_tt['id']}'");
				echo 'Cập nhật '.$ten_cv.'<br>';

			}else{
				mysqli_query($conn,"INSERT INTO bao_duong(ma_kieu,ma_kieu_moi,ten_kieu,ten_kieu_full,model,grade,dong_co,ten_cv,ma_cv,donvi_tinh,cap_baoduong,gia,gia_tri)VALUES('$ma_kieu','$ma_kieu_moi','$ten_kieu','$ten_full','$model','$grade','$dong_co','$ten_cv','$ma_cv','$donvi_tinh','$cap_baoduong','$gia','$gia_tri')");
				echo 'Thêm mới '.$ten_cv.'<br>';
			}
		}else{
			$thongtin=mysqli_query($conn,"SELECT * FROM bao_duong WHERE ma_kieu_moi='$ma_kieu_moi' AND cap_baoduong='$cap_baoduong' AND ma_cv='$ma_cv'");
			$total=mysqli_num_rows($thongtin);
			if($total>0){
				$r_tt=mysqli_fetch_assoc($thongtin);
				mysqli_query($conn,"UPDATE bao_duong SET donvi_tinh='$donvi_tinh',gia='$gia',gia_tri='$gia_tri' WHERE id='{$r_tt['id']}'");
				echo 'Cập nhật '.$ten_cv.'<br>';

			}else{
				mysqli_query($conn,"INSERT INTO bao_duong(ma_kieu,ma_kieu_moi,ten_kieu,ten_kieu_full,model,grade,dong_co,ten_cv,ma_cv,donvi_tinh,cap_baoduong,gia,gia_tri)VALUES('$ma_kieu','$ma_kieu_moi','$ten_kieu','$ten_full','$model','$grade','$dong_co','$ten_cv','$ma_cv','$donvi_tinh','$cap_baoduong','$gia','$gia_tri')");
				echo 'Thêm mới '.$ten_cv.'<br>';
			}
		}
	}
}
?>