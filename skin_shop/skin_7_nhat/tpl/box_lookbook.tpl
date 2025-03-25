<section class="section awe-section-6 section-section_lookbook_one_product">
    <section class="section_lookbook lookbook--oneproduct">
        <div class="container">
            <div class="lookbooks-container row mt-lg-4">
                <div class="col-12 lookbooks-column">
                    <div class="lookbooks-banner">
                        <div class="lookbooks-banner__photo">
                            <div class="lookbook-image-wrap">
                                <img class="img-fluid m-auto object-contain mh-100 w-auto" loading="lazy"
                                    width="520" height="675"
                                    src="{banner_mot}"
                                    alt="" />
                            </div>

                            <!-- <button type="button" class="popover-dot dot-1" data-toggle="popover"
                                data-placement="top" data-popover-content="#lookbook-oneproduct-1"
                                style="--posx: 4; --posy: 4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z">
                                    </path>
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                </svg>
                            </button>

                            <button type="button" class="popover-dot dot-2" data-toggle="popover"
                                data-placement="top" data-popover-content="#lookbook-oneproduct-2"
                                style="--posx: 6; --posy: 8">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z">
                                    </path>
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                </svg>
                            </button>

                            <button type="button" class="popover-dot dot-3" data-toggle="popover"
                                data-placement="bottom" data-popover-content="#lookbook-oneproduct-3"
                                style="--posx: 3; --posy: 13">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z">
                                    </path>
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                </svg>
                            </button> -->
                        </div>
                    </div>
                </div>
                <div class="col-12 lookbook-desc-body">
                    <div class="lookbook-desc-content-wrap" style="background-color: #ffebd4">
                        {banner_mot_text}
                    </div>
                </div>
            </div>
            <!-- bỏ -->
            <!-- <div id="lookbooks-stick-oneproduct" class="hidden">
                <div id="lookbook-oneproduct-1">
                    <div class="popover-content">
                        <a class="popover-product" href="/phong-ngu">
                            <h4 class="popover--title">100% OEKO-TEX®</h4>
                            <p class="popover--desc mb-0">
                                Mềm mại, thoải mái, an toàn - Bộ sản phẩm cotton OEKO-TEX®
                                giúp bạn có những giấc ngủ ngon và thư giãn!
                            </p>
                        </a>
                    </div>
                </div>

                <div id="lookbook-oneproduct-2">
                    <div class="popover-content">
                        <a class="popover-product" href="/phong-ngu">
                            <h4 class="popover--title">Rực rỡ bắt mắt</h4>
                            <p class="popover--desc mb-0">
                                Sự kết hợp màu sắc tương phản mang tính đối trọng, khiến món
                                đồ này trở thành một món đồ yên bình nhưng đáng chú ý, sẽ
                                làm bừng sáng một ngày của bạn.
                            </p>
                        </a>
                    </div>
                </div>

                <div id="lookbook-oneproduct-3">
                    <div class="popover-content">
                        <a class="popover-product" href="/phong-ngu">
                            <h4 class="popover--title">Sang trọng & hiện đại</h4>
                            <p class="popover--desc mb-0">
                                Chiếc bình này có sự kết hợp màu sắc giữa thủy tinh trong
                                suốt và màu nâu. Hình dáng của chiếc bình tạo nên vẻ sang
                                trọng và hiện đại, đủ cao để đựng và trưng bày những bông
                                hoa và cây lớn hơn.
                            </p>
                        </a>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <script>
        var egaLookBookOneProduct = {
            popover: function () {
                $('.popover-dot[data-toggle="popover"]').popover({
                    html: true,
                    animation: true,
                    placement: function (popover, trigger) {
                        var placement = jQuery(trigger).attr("data-placement");
                        var dataClass = jQuery(trigger).attr("data-class");
                        jQuery(trigger).addClass("is-active");
                        jQuery(popover).addClass(dataClass);
                        return placement;
                    },
                    content: function () {
                        var elementId = $(this).attr("data-popover-content");
                        return $(elementId).html();
                    },
                });
                setTimeout(function () {
                    $(".lookbooks-1 .popover-dot:eq(0)").click();
                }, 3000);
                jQuery("body").on(
                    "click",
                    '.popover-dot[data-toggle="popover"]',
                    function (e) {
                        $('.popover-dot[data-toggle="popover"]').each(function () {
                            if (
                                !$(this).is(e.target) &&
                                $(this).has(e.target).length === 0 &&
                                $(".popover").has(e.target).length === 0
                            ) {
                                $(this).popover("hide");
                            }
                        });
                    }
                );
                $("body").on("hidden.bs.popover", function (e) {
                    $(e.target).data("bs.popover").inState = {
                        click: false,
                        hover: false,
                        focus: false,
                    };
                });
            },
        };
    </script>
</section>
<style>
   

    @media (max-width: 779px) {
        .lookbook-desc-content .btn-main {
            position: absolute; /* Đặt vị trí tuyệt đối nếu cần */
            left: 50%;          /* Đặt tại 50% chiều rộng */
            transform: translateX(-50%); /* Căn giữa theo trục ngang */
        }
    }
    
    
</style>