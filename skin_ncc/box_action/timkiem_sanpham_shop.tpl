<!-- huyphuc26/04/2025 -->
<style>
    .status {
        display: inline-block;
        padding: 5px 10px;
        margin-left: 5px;
        border-radius: 3px;
        font-size: 12px;
        color: #fff;
    }
    
    .status-0 {
        background-color: #ff9800; /* Màu cam cho "Đang chờ duyệt" */
    }
    
    .status-1 {
        background-color: #4caf50; /* Màu xanh cho "Đã duyệt" */
    }
    
    .post-socdo {
        display: inline-block;
        text-decoration: none;
        font-size: 12px;
    }
    
    .post-socdo:hover {
        color: #1976d2; /* Màu xanh đậm hơn khi hover */
    }
</style>

<script>
    function postToSocDo(id) {
        if (confirm('Bạn có chắc chắn muốn đăng sản phẩm này lên Sóc Đỏ?')) {
            $.ajax({
                url: '/ncc/process.php',
                type: 'post',
                data: {
                    action: 'post_to_socdo',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.ok == 1) {
                        alert('Đăng sản phẩm lên Sóc Đỏ thành công!');
                        window.location.reload(); // Tải lại trang để cập nhật trạng thái
                    } else {
                        alert('Lỗi: ' + response.thongbao);
                    }
                },
                error: function() {
                    alert('Đã có lỗi xảy ra, vui lòng thử lại!');
                }
            });
        }
    }
    </script>
    <!-- huyphuc24/04/2025 -->
<script>
  $(document).ready(function() {
  // 1. Xử lý checkbox "Chọn tất cả"
  $("#select-all").on("change", function() {
      var isChecked = $(this).is(":checked");
      $(".select-item").prop("checked", isChecked);
      updateSelectedCount(); // Cập nhật số bản ghi đã chọn
  });

  // 2. Xử lý khi checkbox của từng hàng thay đổi
  $(document).on("change", ".select-item", function() {
      updateSelectedCount(); // Cập nhật số bản ghi đã chọn
  });

  // 3. Hàm cập nhật số bản ghi đã chọn
  function updateSelectedCount() {
      var selectedCount = $(".select-item:checked").length;
      $("#selected-count").text("Đã chọn: " + selectedCount);
  }

  // 4. Xử lý nút "Duyệt"
  $("#approve-selected").on("click", function() {
  // Lấy tất cả các checkbox đã được chọn
  var selectedItems = $(".select-item:checked");
  if (selectedItems.length === 0) {
      alert("Vui lòng chọn ít nhất một thương hiệu để xóa!");
      return;
  }

  // Thu thập tất cả các ID của các bản ghi đã chọn
  var selectedIds = [];
  selectedItems.each(function() {
      var id = $(this).data("id");
      if (id) {
          selectedIds.push(id);
      }
  });

  // Gọi hàm confirm_phedhuyetnhieu_thuong_hieu với mảng ids
  confirm_xoanhieu_sanpham('del', 'xoanhieu_sanpham', 'Xác nhận xóa ' + selectedIds.length + ' sản phẩm', selectedIds);
});

  // Cập nhật số bản ghi đã chọn lần đầu khi trang tải
  updateSelectedCount();
});
</script>