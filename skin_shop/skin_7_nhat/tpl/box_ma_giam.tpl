<div class="box_ma_giam">
	<div class="box_title">Mã giảm giá</div>
	<div class="box_list">{list_giam}</div>
</div>
<!-- <script>
    $(document).ready(function () {
        $('#button_coupon_mobile').on('click', function () {
            console.log('click');
    
            const coupon = $('input[name=coupon_desktop]').val().trim();
    
            if (coupon.length < 4) {
                $('input[name=coupon_desktop]').focus();
                return;
            }
    
            $('.load_overlay').show();
            $('.load_process').fadeIn();
    
            $.ajax({
                url: '/process.php',
                type: 'POST',
                data: {
                    action: 'apply_coupon',
                    coupon: coupon
                },
                success: function (response) {
                    try {
                        const info = JSON.parse(response);
    
                        setTimeout(() => {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
    
                        if (info.ok === 1) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        } else {
                            setTimeout(() => {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                            }, 3000);
                        }
                    } catch (error) {
                        console.error('Lỗi xử lý dữ liệu:', error);
                    }
                },
                error: function () {
                    console.error('Lỗi kết nối đến máy chủ.');
                }
            });
        });
    });
    
</script> -->