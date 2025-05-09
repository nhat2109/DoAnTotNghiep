<?php
include './includes/tlca_world.php';
require_once './PHPExcel/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Ngày')
	->setCellValue('B1', 'Mã đơn')
	->setCellValue('C1', 'User ID')
	->setCellValue('D1', 'Tài khoản')
	->setCellValue('E1', 'Họ tên')
	->setCellValue('F1', 'Email')
	->setCellValue('G1', 'Điện thoại')
	->setCellValue('H1', 'Địa chỉ')
	->setCellValue('I1', 'Tỉnh')
	->setCellValue('J1', 'Huyện')
	->setCellValue('K1', 'Xã')
	->setCellValue('L1', 'Sản phẩm')
	->setCellValue('M1', 'Số lượng')
	->setCellValue('N1', 'Cân nặng')
	->setCellValue('O1', 'Tạm tính')
	->setCellValue('P1', 'Phí ship')
	->setCellValue('Q1', 'Chịu phí ship')
	->setCellValue('R1', 'Tổng tiền')
	->setCellValue('S1', 'Tiền COD')
	->setCellValue('T1', 'Hoa hồng')
	->setCellValue('U1', 'Trạng thái')
	->setCellValue('V1', 'Ghi chú');
$thongtin = mysqli_query($conn, "SELECT * FROM donhang_ctv ORDER BY id DESC");
$i = 1;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$i++;
	if ($r_tt['status'] == 1) {
		$r_tt['status'] = 'Đã tiếp nhận đơn';
	} else if ($r_tt['status'] == 2) {
		$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
	} else if ($r_tt['status'] == 3) {
		$r_tt['status'] = 'Yêu cầu hủy đơn';
	} else if ($r_tt['status'] == 4) {
		$r_tt['status'] = 'Xác nhận hủy đơn';
	} else if ($r_tt['status'] == 5) {
		$r_tt['status'] = 'Giao thành công';
	} else if ($r_tt['status'] == 6) {
		$r_tt['status'] = 'Đã hoàn đơn';
	} else {
		$r_tt['status'] = 'Chờ xử lý';
	}
	$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
	$r_u=mysqli_fetch_assoc($thongtin_thanhvien);
	if($r_tt['chiu_ship']=='shop'){
		$chiu_ship='Shop';
	}else{
		$chiu_ship='Khách';
	}
	$tach_sanpham=json_decode($r_tt['sanpham'],true);
	foreach ($tach_sanpham as $key => $value) {
		$list_sp.=$value['tieu_de'].' x '.$value['soluong'].'x '.preg_replace('/[^0-9]/', '', $value['gia_ctv']).'='.$value['thanhtien']."; ";
	}
	$r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $i, $r_tt['date_post'])
		->setCellValue('B' . $i, $r_tt['ma_don'])
		->setCellValue('C' . $i, $r_tt['user_id'])
		->setCellValue('D' . $i, $r_u['username'])
		->setCellValue('E' . $i, $r_tt['ho_ten'])
		->setCellValue('F' . $i, $r_tt['email'])
		->setCellValue('G' . $i, $r_tt['dien_thoai'])
		->setCellValue('H' . $i, $r_tt['dia_chi'])
		->setCellValue('I' . $i, $r_tt['ten_tinh'])
		->setCellValue('J' . $i, $r_tt['ten_huyen'])
		->setCellValue('K' . $i, $r_tt['ten_xa'])
		->setCellValue('L' . $i, $list_sp)
		->setCellValue('M' . $i, $r_tt['so_luong'])
		->setCellValue('N' . $i, $r_tt['can_nang'])
		->setCellValue('O' . $i, $r_tt['tamtinh'])
		->setCellValue('P' . $i, $r_tt['phi_ship'])
		->setCellValue('Q' . $i, $chiu_ship)
		->setCellValue('R' . $i, $r_tt['tongtien'])
		->setCellValue('S' . $i, $r_tt['cod'])
		->setCellValue('T' . $i, $r_tt['hoahong'])
		->setCellValue('U' . $i, $r_tt['status'])
		->setCellValue('V' . $i, $r_tt['ghi_chu']);
		unset($list_sp);
}
/*$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("45");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");*/
//ghi du lieu vao file,định dạng file excel 2007
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="donhang_ctv.xlsx"');
$objWriter->save('php://output');
?>