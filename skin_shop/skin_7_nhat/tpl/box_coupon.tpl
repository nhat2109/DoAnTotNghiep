<div class="box_coupon">
    <div class="container">
        <div class="box_title"><h2>Mã giảm giá</h2></div>
        <div class="list_coupon">
            {list_coupon}
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    if ($(window).width() < 768) {
       var sl=1;
    }else if($(window).width() < 1024){
        var sl=2;

    }
    else {
       var sl=3;
    }
    $('.box_coupon').show();
    $(".list_coupon").slick({
        dots: true,
        infinite: true,
        slidesToShow: sl,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        pauseOnHover: true
    });
})
</script>