<div class="box_flash_sale">
    <div class="container">
        <div class="box_title"><h2>Flash sale</h2></div>
        <div class="list_flash_sale">
            {list_flash_sale}
        </div>
    </div>
</div>
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
            var slx=4;
        }else{
            var slx=$('.list_flash_sale .li_flash_sale').length;
        }
    }
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