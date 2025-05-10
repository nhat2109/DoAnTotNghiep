<div class="box_flash_sale">
    <div class="container container_title">
        <div class="box_title">
            <h2><i class="fas fa-bolt"></i> <span>FLASH SALE - GIÁ SỐC!</span></h2>
            <div class="flash_sale_countdown" time="{flash_sale_expired}">
                <span class="time_unit days">00</span> Ngày
                <span class="time_unit hours">00</span> Giờ
                <span class="time_unit minutes">00</span> Phút
                <span class="time_unit seconds">00</span> Giây
            </div>
            
        </div>
        <div class="list_flash_sale">
            {list_flash_sale}
        </div>
    </div>
</div>
<style>
    .container_title{
        max-width: 1150px !important;
        background: #00a8e8;
        border-radius: 8px;
        padding-left: 30px !important;
        padding-right: 30px !important;
    }

</style>
<script type="text/javascript">
$(document).ready(function() {
    $('.box_flash_sale').show();

    // Đồng hồ đếm ngược cho Flash Sale
    function startCountdown($element, endTime) {
        function updateCountdown() {
            var now = new Date().getTime();
            var distance = endTime - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $element.find('.days').text(days < 10 ? "0" + days : days);
            $element.find('.hours').text(hours < 10 ? "0" + hours : hours);
            $element.find('.minutes').text(minutes < 10 ? "0" + minutes : minutes);
            $element.find('.seconds').text(seconds < 10 ? "0" + seconds : seconds);

            if (distance < 0) {
                clearInterval(interval);
                $element.text("Flash Sale đã kết thúc!");
            }
        }

        var interval = setInterval(updateCountdown, 1000);
        updateCountdown();
    }

    $('.flash_sale_countdown').each(function() {
        var endTime = new Date($(this).attr('time')).getTime();
        startCountdown($(this), endTime);
    });
});
</script>
<script type="text/javascript">
    
$(document).ready(function() {
    if ($(window).width() < 768) {
       var slx=1;
    }else if($(window).width() < 1024){
        if($('.list_flash_sale .li_flash_sale').length>=2){
            var slx=2;
        }else{
            var slx=$('.list_flash_sale .li_flash_sale').length;
        }
    }
    else {
        if($('.list_flash_sale .li_flash_sale').length>=4){
            var slx=2;
        }else{
            var slx=$('.list_flash_sale .li_flash_sale').length;
        }
    }
    $('.box_flash_sale').show();
    $(".list_flash_sale").slick({
        dots: true,
        infinite: true,
        slidesToShow: slx,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        pauseOnHover: true
    });
});
</script>