<?php

$sp_id = intval($_REQUEST['sp_id']);
$loai = isset($_REQUEST['loai']) ? $_REQUEST['loai'] : '';
$currentTime = time();

// Truy vấn dữ liệu follow hiện tại của user
$query = "SELECT * FROM sanpham_follow WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

// Nếu chưa có record nào của user
if(mysqli_num_rows($result) == 0) {
    if($loai === 'add'){
        // Nếu là thêm, tạo record với sp_id mới
        mysqli_query($conn, "INSERT INTO sanpham_follow(user_id, sanpham, date_post) VALUES('$user_id', '$sp_id', '$currentTime')");
    } else {
        // Nếu là hủy nhưng chưa có record, ta tạo record rỗng (hoặc bỏ qua)
        mysqli_query($conn, "INSERT INTO sanpham_follow(user_id, sanpham, date_post) VALUES('$user_id', '', '$currentTime')");
    }
} else {
    // Nếu đã có record, lấy dữ liệu hiện tại
    $row = mysqli_fetch_assoc($result);
    $currentProducts = trim($row['sanpham']);
    // Chuyển chuỗi sản phẩm thành mảng, nếu chuỗi rỗng thì khởi tạo mảng rỗng
    $productArray = ($currentProducts !== '') ? array_filter(explode(',', $currentProducts)) : array();

    if($loai === 'add'){
        // Nếu chưa có sp_id trong danh sách thì thêm vào
        if(!in_array($sp_id, $productArray)){
            $productArray[] = $sp_id;
        }
    } else { // remove
        // Nếu có sp_id trong danh sách thì loại bỏ
        if(($key = array_search($sp_id, $productArray)) !== false){
            unset($productArray[$key]);
        }
    }
    // Cập nhật lại chuỗi sản phẩm từ mảng (nếu mảng rỗng sẽ thành chuỗi rỗng)
    $newProductList = implode(',', $productArray);
    mysqli_query($conn, "UPDATE sanpham_follow SET sanpham='$newProductList', date_post='$currentTime' WHERE user_id='$user_id'");
}

// Tính lại tổng số sản phẩm ưa thích của user
$query_new = "SELECT sanpham FROM sanpham_follow WHERE user_id='$user_id' LIMIT 1";
$result_new = mysqli_query($conn, $query_new);
if ($result_new && mysqli_num_rows($result_new) > 0) {
    $row_new = mysqli_fetch_assoc($result_new);
    $list_id = trim($row_new['sanpham']);
    if ($list_id !== '') {
        $total_follow = count(array_filter(explode(',', $list_id)));
    } else {
        $total_follow = 0;
    }
} else {
    $total_follow = 0;
}

// Trả về dữ liệu dạng JSON cho client
echo json_encode(array('total_follow' => $total_follow));
?>
