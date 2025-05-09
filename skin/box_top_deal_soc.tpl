<div class="box_top_soc">
    <script src="/carousel/owl.carousel.min.js"></script>
    <div class="box_content">
        <div class="top_box"></div>
        <div class="box_sanpham owl-carousel" id="slide_8">
            {list_top_deal_soc}
        </div>
        <script type="text/javascript">
        $(document).ready(function() {
            var owl_8 = $('#slide_8');
            owl_8.owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                autoplay: false,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    },
                    1280: {
                        items: 5
                    }
                }
            })
            $('.next_8').click(function() {
                owl_8.trigger('next.owl.carousel');
            });
            $('.prev_8').click(function() {
                owl_8.trigger('prev.owl.carousel');
            });
        });
        </script>
    </div>
</div>