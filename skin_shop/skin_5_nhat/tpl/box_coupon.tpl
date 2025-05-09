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
       var sl = 2;
    } else if($(window).width() < 1024) {
        var sl = 2;
    } else {
       var sl = 4;
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
});

function copyCode(code, button) {
    navigator.clipboard.writeText(code).then(function() {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i><span> Đã sao chép </span>';
        button.classList.add('copied'); // Add copied class for styling
        button.disabled = true;

        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('copied'); // Remove copied class to revert styling
            button.disabled = false;
        }, 2000);
    }, function(err) {
        alert('Lỗi khi sao chép mã: ' + err);
    });
}
</script>