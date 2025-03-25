<!-- 
<div class="box_index flash-sale-heading">
    <div class="container"  style="display: flex; align-items: baseline; gap: 10px">
        <div class="box_title">
            <h2 class="heading-bar__title flashsale__title m-0"><a href="/san-pham/{cat_blank}.html">{cat_tieude}</a></h2>
            <span><button class="button_prev"><i class="fa fa-angle-left"></i></button><button class="button_next"><i class="fa fa-angle-right"></i></button></span>
        </div>
        <div class="list_sanpham">
            <div class="home-slider swiper-container slide_product">
                <div class="swiper-wrapper">
                    <div class="e-tabs">
                        <div class="row one-row">
                        {list_sanpham}
                    </div>
					</div>
                </div>
            </div>
           
        </div>                  
    </div>
</div> -->

<div class="box_title">
    <h2 class="heading-bar__title" style="color: #000000" ><a href="/san-pham/{cat_blank}.html">{cat_tieude}</a></h2>
    <div class="text_more">
        <a href="/san-pham/{cat_blank}.html">Xem tất cả <i class="fa fa-angle-double-right"></i></a>
    </div>
</div>
<div class="box_index flash-sale-heading">
    <div class="container title_module_main d-flex justify-content-between px-0" style="display: flex; align-items: baseline; gap: 10px">
        

        <div class="list_sanpham">
            <div class="home-slider swiper-container slide_product">
                <div class="swiper-wrapper">
                    <div class="e-tabs">
                        <div class="row one-row">
                            {list_sanpham}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> 

<style>
    .box_title h2 a {
        color: black !important;
    }
    .text_more a {
        color: black !important;
    }
    .box_title h2 a:hover {
            color: #ec720e !important;
    }
    .text_more a:hover {
            color: #ec720e !important;
    }
</style>