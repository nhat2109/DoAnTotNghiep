{header}
<body>
	{box_header}
    <h1 class="hidden">{site_name}</h1>
    <section class="awe-section-1">
        <div class="home-slider swiper-container slide_home">
            <div class="swiper-wrapper">
                {list_slide}
            </div>
        </div>
    </section>
    {box_coupon}
    {box_flash_sale}
    {list_box_index}
    <section class="awe-section-8">
        <section class="container section-news margin-bottom-20">
            <h2 class="home-title">
                <a href="/tin-tuc.html" title="Tin mới nhất">Tin mới nhất</a>
            </h2>
            <div class="list-blogs-link">
                <div class="row">
                	{list_tintuc}
                </div>
            </div>
        </section>
    </section>
    {footer}
    {script_footer}
    <script type="text/javascript" charset="utf-8">
        $(function() {
          var currentDate = new Date(),
              finished = false,
              availiableExamples = {
                set5ngay: 15 * 24 * 60 * 60 * 1000,
                set5phut  : 5 * 60 * 1000,
                set1phut  : 1 * 10 * 1000
              };         
            function call_flash(event) {
              $this = $(this);
                switch(event.type) {
                    case "seconds":
                    case "minutes":
                    case "hours":
                    case "days":
                    case "weeks":
                    case "daysLeft":
                      $this.find('.'+event.type).html(event.value);
                      if(finished) {
                        $this.fadeTo(0, 1);
                        finished = false;
                      }
                        break;
                    case "finished":
                $this.fadeTo('slow', .5);
                $this.html('Đã hết hạn');
                finished = true;
                        break;
                }
            }
            $('.box_flash_sale .count_down').each(function(){
                con=$(this).attr('time')*1000;
                $(this).countdown(con + currentDate.valueOf(), call_flash);
            });
        });
      </script>
    <script>
    var slide_recent = new Swiper('.slide_home', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 1,
        loop: true,
        observer: true,
        observeParents: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
          },
        // Navigation arrows
        navigation: {
            nextEl: '#gallery_01 .owl-next',
            prevEl: '#gallery_01 .owl-prev',
            disabledClass: 'hide_button',
            hiddenClass: 'hide_button'
        },
    });
    </script>
</body>

</html>