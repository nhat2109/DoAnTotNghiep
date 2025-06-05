<style>
    .btn-xs {
        width: 60px !important;
    }
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
			<div class="page_title">
				<h1>Quản lý đánh giá sản phẩm</h1>
				<div class="line"></div>
				<hr>
			</div>
			<table class="list_baiviet">
				<thead>
					<tr>
						<th style="text-align:center;width:40px;">ID</th>
						<th style="text-align:center;width:150px;">Sản phẩm</th>
						<th style="text-align:center;width:100px;">Minh họa</th>
						<th style="text-align:center;width:80px;">User</th>
						<th style="text-align:center;width:60px;">Điểm</th>
						<th style="text-align:left;">Bình luận</th>
						<th style="text-align:center;width:100px;">Ngày</th>
						<th style="text-align:center;width:80px;">Trạng thái</th>
						<th style="text-align:center;width:120px;">Hành động</th>
					</tr>
				</thead>
				<tbody>
					{list_danhgia}
				</tbody>
			</table>
			{phantrang}
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    // Hàm hiển thị thông báo
    function showNotification(message, type = 'success') {
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $(".load_note").html(message);
        setTimeout(function () {
            $(".load_process").hide();
            $(".load_overlay").hide();
            $(".load_note").html("");
        }, 2000);
    }

    $(document).on('click', '.btn-duyet-danhgia', function(){
        var id = $(this).data('id');
        var btn = $(this);
        showNotification("Đang xử lý...");
        
        $.post('/ncc/process/process_danhgia.php', {action:'duyet', id:id}, function(res){
            if(res.success){
                btn.prop('disabled', true);
                btn.closest('tr').find('.btn-an-danhgia').prop('disabled', false);
                btn.closest('tr').find('.badge').removeClass('badge-secondary').addClass('badge-success').text('Hiện');
                showNotification("Duyệt đánh giá thành công!");
            } else {
                showNotification("Có lỗi xảy ra khi duyệt đánh giá!", "error");
            }
        },'json').fail(function() {
            showNotification("Có lỗi xảy ra khi kết nối server!", "error");
        });
    });

    $(document).on('click', '.btn-an-danhgia', function(){
        var id = $(this).data('id');
        var btn = $(this);
        showNotification("Đang xử lý...");
        
        $.post('/ncc/process/process_danhgia.php', {action:'an', id:id}, function(res){
            if(res.success){
                btn.prop('disabled', true);
                btn.closest('tr').find('.btn-duyet-danhgia').prop('disabled', false);
                btn.closest('tr').find('.badge').removeClass('badge-success').addClass('badge-secondary').text('Ẩn');
                showNotification("Ẩn đánh giá thành công!");
            } else {
                showNotification("Có lỗi xảy ra khi ẩn đánh giá!", "error");
            }
        },'json').fail(function() {
            showNotification("Có lỗi xảy ra khi kết nối server!", "error");
        });
    });

    $(document).on('click', '.btn-xoa-danhgia', function(){
        if(!confirm('Bạn chắc chắn muốn xóa đánh giá này?')) return;
        
        var id = $(this).data('id');
        var btn = $(this);
        showNotification("Đang xử lý...");
        
        $.post('/ncc/process/process_danhgia.php', {action:'xoa', id:id}, function(res){
            if(res.success){
                btn.closest('tr').fadeOut(300, function() {
                    $(this).remove();
                });
                showNotification("Xóa đánh giá thành công!");
            } else {
                showNotification("Có lỗi xảy ra khi xóa đánh giá!", "error");
            }
        },'json').fail(function() {
            showNotification("Có lỗi xảy ra khi kết nối server!", "error");
        });
    });
});
</script> 