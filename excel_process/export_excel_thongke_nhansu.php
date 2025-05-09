<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/tlca_world.php';
require_once '../PHPExcel/PHPExcel.php';

$class_giaoviec_member = $tlca_do->load('class_giaoviec_member');
$user_info = $class_giaoviec_member->user_info($conn, $_COOKIE['emin_giaoviec_id']);
$time_start = $_POST['time_start_nhansu_thongke'];
$time_end = $_POST['time_end_nhansu_thongke'];

$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();

// --- DÒNG 1: Tiêu đề chính ---
$sheet->mergeCells('A1:R1');
$sheet->getStyle("A1:R1")->applyFromArray([
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
]);
$sheet->setCellValue('A1', 'TỔNG HỢP BÁO CÁO CÔNG VIỆC');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// --- DÒNG 2: Header ---
$sheet->setCellValue('A2', 'Số thứ tự');
$sheet->setCellValue('B2', 'Tên nhân sự');
$sheet->setCellValue('C2', 'Chức vụ');
$sheet->setCellValue('D2', 'Điện thoại');

// Gộp thời gian E2:F2
$sheet->mergeCells('E2:F2');
$sheet->setCellValue('E2', 'Thời gian');
$sheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Các cột khác
$sheet->setCellValue('G2', 'Tổng số công việc');
$sheet->setCellValue('H2', 'Chưa nhận việc ');
$sheet->setCellValue('I2', 'Đang tiến hành');
$sheet->setCellValue('J2', 'Chờ phê duyệt');
$sheet->setCellValue('K2', 'Xin gia hạn ');
$sheet->setCellValue('L2', 'Miss Deadline');
$sheet->setCellValue('M2', 'Từ chối');
$sheet->setCellValue('N2', 'Hoàn thành');
$sheet->setCellValue('O2', 'Tỷ lệ Miss Dealine');
$sheet->setCellValue('P2', 'Tỷ lệ từ chối công việc');
$sheet->setCellValue('Q2', 'Tỷ lệ gia hạn công việc');
$sheet->setCellValue('R2', 'Tỷ lệ hoàn thành công việc');

// --- DÒNG 3: Header phụ dưới "Thời gian" ---
$sheet->setCellValue('E3', 'Từ ngày');
$sheet->setCellValue('F3', 'Đến ngày');
$sheet->getStyle('E3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// --- Gộp các cột khác từ dòng 2 → 3 để không bị gộp dòng 3 ---
$mergeCols = ['A', 'B', 'C', 'D', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R'];
foreach ($mergeCols as $col) {
    $sheet->mergeCells("{$col}2:{$col}3");
    $sheet->getStyle("{$col}2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getStyle("{$col}2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

// --- Định dạng dòng tiêu đề ---
$sheet->getStyle("A2:R3")->getFont()->setBold(true);
$sheet->getStyle("A2:R3")->getAlignment()->setWrapText(true);

// --- Ghi dữ liệu từ dòng 4 ---
// --- Ghi dữ liệu từ dòng 4 ---
$thongtin = mysqli_query($conn, "SELECT * FROM emin_giaoviec_info WHERE location_giaoviec='{$user_info['location_giaoviec']}' ORDER BY id ASC");
$row = 3;
$stt = 1;
$created_start = strtotime($time_start);
$created_end = strtotime($time_end);
if (!empty($time_start) && !empty($time_end)) {
	$vali = "AND created_at >= '$created_start' AND created_at <= '$created_end'";
}else{
	$vali = "";
}
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $row++;
	$thongtin_ns = mysqli_query($conn,"SELECT * FROM giao_viec WHERE nguoi_nhan = '{$r_tt['id']}' $vali");
    $total_giaoviec = 0;
    $dangtienhanh = 0;
    $miss_deadline_kk = 0;
    $hoanthanh =0;
    $chuatienhanh = 0;
    $chopheduyet =0;
    $tuchoi=0;
    $giahan=0;

    while($row_d = mysqli_fetch_assoc($thongtin_ns)){
        $total_giaoviec++;
        if ($row_d['status'] === '0') {
            $chuatienhanh++;
            if ($row_d['miss_deadline']) {
                $miss_deadline_kk++;
            }
        }elseif($row_d['status']==='1'){
            $dangtienhanh++;
            if ($row_d['cham_tiendo']) {
                $chamtiendo++;
            }elseif($row_d['miss_deadline']){
                $miss_deadline_kk++;
            }
        }elseif ((int)$row_d['status'] === 2) { // 31-3
            if (is_null($row_d['xac_nhan'])) {
                $chopheduyet++;
            } elseif ((int)$row_d['xac_nhan'] === 0) {
                $hoanthanh++;
            } elseif ((int)$row_d['xac_nhan']===1)
            {
                $tuchoi++; // đã từ chối : status 2 , xac_nhan = 1 
            }
            if ($row_d['cham_tiendo']) {
            }elseif($row_d['miss_deadline']){
                $miss_deadline_kk++;
            }
            
        }elseif($row_d['status']==='4')
        {
            $tuchoi++; 
            if ($row_d['cham_tiendo']) {
            }elseif($row_d['miss_deadline']){
                $miss_deadline_kk++;
            }
        }
        if ($row_d['xac_nhan_giahan'] === '0') {
            $giahan++;
            if ($row_d['cham_tiendo']) {
                $chamtiendo++;
            }elseif($row_d['miss_deadline']){
                $miss_deadline_kk++;
            }
        }
    }
	$total_cv = mysqli_num_rows($thongtin_ns);
	$miss_deadline_rate = ($miss_deadline_kk/$total_cv)*100;
	$tuchoi_rate = ($tuchoi/$total_cv)*100;
	$giahan_rate = ($giahan/$total_cv)*100;
	$done_rate = ($hoanthanh/$total_cv)*100;
    $sheet->setCellValueExplicit("A{$row}", (string)$stt++, PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValue("B{$row}", $r_tt['name']);
    $sheet->setCellValue("C{$row}", $r_tt['chuc_vu'] ?? '');
    $sheet->setCellValue("D{$row}", $r_tt['mobile']);
    $sheet->setCellValue("E{$row}", $time_start);
    $sheet->setCellValue("F{$row}", $time_end);
    $sheet->setCellValue("G{$row}", $total_cv);
    $sheet->setCellValue("H{$row}", $chuatienhanh);
    $sheet->setCellValue("I{$row}", $dangtienhanh);
    $sheet->setCellValue("J{$row}", $chopheduyet);
    $sheet->setCellValue("K{$row}", $giahan);
    $sheet->setCellValue("L{$row}", $miss_deadline_kk);
    $sheet->setCellValue("M{$row}", $tuchoi);
    $sheet->setCellValue("N{$row}", $hoanthanh);
    $sheet->setCellValue("O{$row}", number_format($miss_deadline_rate,3,",",'.')."%");
    $sheet->setCellValue("P{$row}", number_format($tuchoi_rate,3,",",".")."%");
    $sheet->setCellValue("Q{$row}", number_format($giahan_rate,3,",",".")."%");
    $sheet->setCellValue("R{$row}", number_format($done_rate,3,",",".")."%");
	$sheet->getRowDimension($row)->setRowHeight(30);
	$sheet->getStyle("A2:R{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("A2:R{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle("A2:R{$row}")->getAlignment()->setWrapText(true);

}

// --- Áp dụng border toàn bảng từ A2 đến R(dòng cuối cùng) ---
$sheet->getStyle("A2:R{$row}")->applyFromArray([
    'borders' => [
        'allborders' => [
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
]);


// --- Định dạng độ rộng cột ---
foreach (range('B', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('G')->setWidth(12);
$sheet->getColumnDimension('H')->setWidth(12);
$sheet->getColumnDimension('I')->setWidth(12);
$sheet->getColumnDimension('J')->setWidth(12);
$sheet->getColumnDimension('K')->setWidth(12);
$sheet->getColumnDimension('M')->setWidth(12);
$sheet->getColumnDimension('L')->setWidth(12);
$sheet->getColumnDimension('N')->setWidth(12);
$sheet->getColumnDimension('O')->setWidth(12);
$sheet->getColumnDimension('P')->setWidth(12);
$sheet->getColumnDimension('Q')->setWidth(12);
$sheet->getColumnDimension('R')->setWidth(12);
$sheet->getStyle('A:A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A:A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('B:B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('C:C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('D:D')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('E:E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('F:F')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('G:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('G:G')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('H:H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('H:H')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('I:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('I:I')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('J:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('J:J')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('K:K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K:K')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('L:L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('L:L')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('M:M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('M:M')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('N:N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('N:N')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('O:O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('O:O')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('P:P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('P:P')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('Q:Q')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('Q:Q')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('R:R')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('R:R')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// --- Xuất file ---
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="thongke_nhansu.xlsx"');
$objWriter->save('php://output');
exit;
?>
