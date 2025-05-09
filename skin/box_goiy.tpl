<style>
.goi_y_sp .container {
    background-color: #fff !important;
}
.goiy_heading .top_hotdeal{
    width: 100% !important;
}
.goiy__countdown-wrapper{
    margin-left: 10px;
}
.goiy__xemthem {
    text-align: center;
    padding:10px 0px;
    font-weight: bold;
    color: #d41e25;
    cursor: pointer;
}

.list_sanpham {
    background-color: #fff !important;
}
@media (max-width: 768px) {
    .home_deal .goiy_heading {
        padding: 5px 0px;
        height: 50px !important;
    }
    .goiy__countdown-label{
        margin-left: 7px;
    }
}
</style>
<div class="home_deal goi_y_sp">
    <div class="container">
        <div class="heading-bar goiy_heading" style="background-color: #fff;color: #000; border: 1px solid #0000001c; border-radius: 5px;">
            <div class="top_hotdeal">
                <div class="goiy__countdown-wrapper">
                    <span class="goiy__countdown-label" style="font-size: 20px; font-weight: bold; color: #000; text-align: left;"><i class="fa fa-shopping-cart" style="font-size: 18px; color: #d41e25"></i> Gợi ý hôm nay</span>
                </div>
            </div>
        </div>
        <div id="goiy__danhsach" class="list_sanpham" style="background-color: #fff !important;">
            {list_goi_y_home}
        </div>
        <div class="goiy__xemthem" data-page="1">Xem thêm >></div>

    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $(".goiy__xemthem").click(function () {
        let $btn = $(this);
        let currentPage = parseInt($btn.attr("data-page"));
        let nextPage = currentPage + 1;
        let limit = currentPage * 5;
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            method: "POST",
            data: {
                action: "goiy_home",
                page: currentPage,
                limit: limit
            },
            success: function (res) {
                var info = JSON.parse(res);
                // $("#goiy__danhsach").html('').append(info.data);
                $btn.attr("data-page", nextPage);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $("#goiy__danhsach").html('').append(info.data);
                    }
                }, 200);
            },
            error: function () {
                $btn.text("Lỗi, thử lại!");
            }
        });

    });
});

</script>