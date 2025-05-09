<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thiết lập giao diện</h1>
                <div class="text_muted">Thiết lập giao diện cho cửa hàng của bạn</div>
                <div class="line"></div>
                <hr>
            </div>
            <div class="title_sosanh"><span>Quá trình xử lý</span></div>
            <div class="list_giaodien">
                <div class="color_red bold" style="width: 100%;">Lưu ý: Không đóng cửa sổ khi hệ thống đang xử lý...</div>
                <input type="hidden" name="step" value="caidat">
                <input type="hidden" name="tieptuc" value="1">
                <input type="hidden" name="post_id" value="">
                <div class="list_success"><div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập cài đặt...</span></div></div>
                <div class="list_ketqua"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    function setup_data(){
        step=$('input[name=step]').val();
        tieptuc=$('input[name=tieptuc]').val();
        post_id=$('input[name=post_id]').val();
        if(tieptuc==1){
            $.ajax({
                url: "/dropship/process.php",
                type: "post",
                data: {
                    action: 'setup_data',
                    step:step,
                    post_id:post_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('input[name=step]').val(info.step);
                    $('input[name=tieptuc]').val(info.tieptuc);
                    $('input[name=post_id]').val(info.post_id);
                    $('.list_ketqua').html(info.list);
                    //$('.list_ketqua').prepend(info.list);
                    if(info.success==1){
                        $('.list_success .li_success').not('.success').html(info.text_success);
                        $('.list_success .li_success').not('.success').addClass('success');
                        if(info.tieptuc==1){
                            $('.list_success').append(info.text_tieptuc);
                        }
                    }else{

                    }
                    if(info.tieptuc==1){
                        setTimeout(function(){
                            setup_data();
                        },2000);
                    }else{
                        if(info.to==1){
                            window.location.href='/dropship/domain';
                        }
                    }
                }
            });
        }
    }
    setTimeout(function(){
        setup_data();
    },2000);
});
</script>