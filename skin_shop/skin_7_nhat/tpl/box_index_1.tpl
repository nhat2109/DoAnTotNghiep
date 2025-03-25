
<div class="title_module_main heading-bar d-flex align-items-center flex-wrap justify-content-between">
    <h2 class="heading-bar__title" style="color: #000000" ><a href="/san-pham/{cat_blank}.html">{cat_tieude}</a></h2>
    <div class="text_more">
        <a href="/san-pham/{cat_blank}.html">Xem tất cả <i class="fa fa-angle-double-right"></i></a>
    </div>
</div>
<div class="body_module">
 
    <div class="row mt-3 multi_row" >
        {list_sanpham}
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
    @media (max-width: 768px) {
       
        .flashsale__item .item_product_main {
            
        }
    }

</style>