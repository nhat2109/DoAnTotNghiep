<?php
include './includes/tlca_world.php';
require_once './PHPExcel/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Tên thành viên')
	->setCellValue('B1', 'Số điện thoại');
$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_money>'0' ORDER BY user_money DESC ");
$i = 1;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $i, $r_tt['username'])
		->setCellValue('B' . $i, $r_tt['mobile'])
		->setCellValue('C' . $i, $r_tt['user_money']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
//ghi du lieu vao file,định dạng file excel 2007
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="thanhvien.xlsx"');
$objWriter->save('php://output');
?>