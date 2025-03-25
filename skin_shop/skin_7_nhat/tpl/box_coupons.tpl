<section class="section awe-section-3 section-section_coupons">
    <!-- <link rel="preload" as="style" type="text/css" href="/skin_shop/skin_7_nhat/tpl/css/coupon.css" /> -->
    <!-- <link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/coupon.css" /> -->

    <div class="section_coupons">
        <div class="container border-0">
            <div class="row scroll scroll_s justify-content-xl-center">
                {list_coupon}
            </div>
        </div>
    </div>

    <script type="text/x-custom-template" data-template="couponPopup">
    <div id="coupon-modal" class="coupon-modal modal fade " role="dialog" style="display:none;">
        <div class="modal-dialog align-vertical">
        <div class="modal-content">
            <button type="button" class="close window-close" data-dismiss="modal" data-backdrop="false"
            aria-label="Close" style="z-index: 9;"><span aria-hidden="true">×</span></button>
            <div class="coupon-content"></div>
        </div>
        </div>
        </div>
  </script>
    <script src="/skin_shop/skin_7_nhat/tpl/js/coupon.js" defer></script>
</section>

<style>
  
    .coupon_item {
        position: relative;
        background: #fff;
        filter: drop-shadow(0px 0px 3px rgba(0, 0, 0, .15));
        padding: 10px;
        display: flex;
       
        min-height: 120px;
       border-radius: 5px;
       min-height: 100px;
   }
    .coupon_item .coupon_icon {
        width: 103px;
            flex: 0 0 103px;
      background-color: var(--coupon-code-background);
   }
   @media(max-width: 767px){
       .coupon_item {
           margin: 4px auto;
   
       }
        .coupon_item .coupon_icon {
          width: 44px;
         flex: 0 0 44px;
     }
     .coupon_title, .coupon-code-body {
         font-size: 12px !important;
     }
   }
    .coupon_item:before {
        content: "";
        position: absolute;
        top: 0;
        left: -3px;
        height: 100%;
        width: 10px;
        color: #fff;
        background-clip: padding-box;
            background: repeating-linear-gradient(#e5e5e5,#e5e5e5 5px,transparent 0,transparent 9px,#e5e5e5 0,#e5e5e5 10px) 0/1px 100% no-repeat,radial-gradient(circle at 0 7px,transparent,transparent 2px,#e5e5e5ee 0,#e5e5e5 3px,currentColor 0) 1px 0/100% 10px repeat-y;
   
   }
    .coupon_item:after {
        bottom: -4px;
        top: auto;
   }
   
    .coupon_item .coupon_body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 5px 5px 5px 15px;
      flex: 1;
   }
    .coupon_item .coupon_body .coupon_title {
        font-size: 14px;
        color: var(--coupon-title-color);
        font-weight: 600;
        margin-bottom: 3px;
   }
    .coupon_item .coupon_body .coupon_desc {
        font-size: 13px;
        line-height: 1.2;
        color: #727272;
        padding-bottom: 7px;
            min-height: 33px;
            overflow: hidden;
       display: -webkit-box;
       -webkit-box-orient: vertical;
       -webkit-line-clamp: 2;
   }
   .coupon_copy  {
        background:var(--coupon-button-color);
        color: #fff;
   }
   .coupon_copy:hover{
           color: #fff;
           filter: brightness(1.1)
   }
    .coupon_item .coupon_copy{
        border: none;
        padding: 2px 8px;
        margin-bottom: 3px;
   }
    .coupon_item .coupon_body button span {
        display: block;
        line-height: 24px;
        height: 24px;
        font-size: 12px;
   }
    .coupon_item.no-icon .coupon_body {
        width: 100%;
   }
   .coupon_info{
       display: none;
   }
   .coupon_info_toggle{
       font-size: 12px;
       text-decoration: underline;
       color: #2E72D2;
       cursor: pointer;
       margin-bottom: 3px;
   }
   .coupon-modal .coupon_desc{
       display: none;
   }
   .coupon-modal .coupon_info{
       display: block
   } 
   .coupon-modal .modal-content{
       padding: 15px 20px;
   }
   .coupon-modal{
       z-index: 99999
   }
   .coupon-modal .window-close {
       z-index: 9;
       position: absolute;
       right: 8px;
       top: -1px;
   }
   .coupon-action{
       --primary-color: var(--coupon-button-color);
           display: grid;
       grid-template-columns: 1fr 1fr;
       margin-top: 20px;
       padding-top: 20px;
       border-top: 1px solid #eee;
       grid-gap: 15px;
   }
   .coupon-title {
       color: var(--coupon-title-color);
       display: -webkit-box;
       -webkit-box-orient: vertical;
       -webkit-line-clamp: 1;
       overflow: hidden;
       text-overflow: ellipsis;
       letter-spacing: 0px;
       padding: 0px;
       font-size: 24px;
       line-height: 32px;
       max-height: 32px;
       font-weight: 600;
       margin: 0px 16px 16px;
       text-align: center;
   }
   
   .coupon-row {
       display: grid;
       grid-template-columns: 33% 1fr;
       grid-gap: 5px;
       padding: 10px 20px;
       margin-left: -20px;
       margin-right: -20px;
   }
   .coupon-row:nth-child(2n) {
       background-color: #f3f3f3;
   }
   .coupon-row .coupon-info{
       grid-column: 1/-1;
       grid-row: 2;
   }
   .coupon-action{
       margin-top: 20px;
       padding-top: 20px;
       border-top:1px solid #F0F1F2
   }
   .coupon-label{
       color: #4c4c4c
   }
    @media (max-width: 1024px) {
        .coupon_item {
                margin: 10px auto;
               height: auto;
        }
        .section_coupons .row {
            flex-wrap: nowrap;
            overflow-x: auto;
            flex-wrap: nowrap;
       }
        .section_coupons .col-lg {
            padding-right: 4px;
        }
            
            
        .section_coupons .row::-webkit-scrollbar {
            display: none;
       }
        .section_coupons .row {
            -ms-overflow-style: none;
           /* IE and Edge */
            scrollbar-width: none;
           /* Firefox */
       }
   }
   .coupon-action .btn {
       padding: 10px;
   }
   @media (max-width: 1024px) and (min-width: 992px){
    .section_coupons .col-lg {
                flex: 0 0 31%;
        }
   }
   @media(max-width: 767px){
   .coupon-modal .modal-dialog {
       position: absolute;
       bottom: 0;
       margin: 0;
       width: 100%;
           top:auto!important;
           transform: none!important;
       }
       .coupon-modal .modal-content{
           border-radius: 5px 5px 0 0;
       }
       
   }
   
   .coupon_item.coupon--new-style{
       position: relative;
       background: transparent;
       filter: drop-shadow(0px 0px 3px rgba(0, 0, 0, .15));
       padding: 10px;
       display: flex;
       min-height: 120px;
       border-radius: 5px;
       min-height: 100px;
       padding: 0;
       padding-left: 8px;
   }
   .coupon_item.coupon--new-style:before {
       content: "";
       position: absolute;
       top: 0;
       left: 0;
       height: 100%;
       width: 8px;
       color: #fff;
       background-clip: padding-box;
       background: var(--coupon-button-color);
       border-radius: 15px 0 0 15px;
   }
   .coupon_item.coupon--new-style .coupon_icon{
       border-radius: 0 15px 15px 0;
       filter: drop-shadow(0px 0px 0.5px rgba(0, 0, 0, .15));
       padding-left: 10px;
       padding-right: 10px;
       position: relative;
   }
   .coupon_item.coupon--new-style .coupon_icon img{
       max-width: 80%;
   }
   .coupon_item.coupon--new-style .coupon_icon:after {
       position: absolute;
       content: "";
       width: 2px;
       height: 50%;
       right: 0;
       top: 50%;
       transform: translateY(-50%);
       border: 1px solid dashed;
       border-right: 2px dashed #ccc;
   }
   .coupon_item.coupon--new-style .coupon_body{
       background: #fff;
       border-radius: 15px;
       filter: drop-shadow(0px 0px 0.5px rgba(0, 0, 0, .15));
       padding: 15px 12px;
       flex-grow: 1;
   }
   .coupon_item .coupon_head.coupon--has-info{
       position: relative;
       padding-right: 32px;
   }
   .coupon_item .coupon_head .coupon-icon-info{
       position: absolute;
       right: 0;
       top: 0;
       width: 22px;
       height: 22px;
       line-height: 16px;
       border: 2px solid var(--coupon-button-color);
       border-radius: 50%;
       cursor: pointer;
   }
   .coupon_item .coupon_head .coupon-icon-info i{
       font-size: 11px;
       color: var(--coupon-button-color);
   }
   .coupon-code-body{
       display: flex;
       font-size: 13px;
       min-height: 40px;
       flex-direction: column;
       justify-content: center;
   }
   .coupon-code-body .coupon-code-row span{
       color: #999;
   }
   .coupon-code-body .coupon-code-row span.date-warning{
       color: #dc3545;
       font-size: 12px;
   }
   .coupon-desc-info{
       display: none;
       position: absolute;
       width: 300px;
       background: #fff;
       right: calc(100% + 5px);
       top: 0;
       border-radius: 15px;
   }
   .coupon-item-wrap:first-child .coupon-desc-info{
   right: auto;
       left: calc(100% + 5px);
   }
   .coupon-desc-info:before{
       position: absolute;
       content: "";
       width: 20px;
       height: 50%;
       top: 0;
       right: 100%;
   }
   @media(min-width: 1200px){
       .coupon_item .coupon_head .coupon-icon-info:hover .coupon-desc-info{
           display: block;
           z-index: 99;
       }
   }
   .section_coupons > .container > .row.coupon--three-item > div:nth-child(3n) .coupon-desc-info,
   .section_coupons > .container > .row.coupon--four-item > div:nth-child(4n) .coupon-desc-info,
   .cart-coupon .coupon-desc-info,
   .details-product .coupon-desc-info{
       left: auto;
       right: calc(100% + 5px);
   }
   .section_coupons > .container > .row.coupon--three-item > div:nth-child(3n) .coupon-desc-info:before,
   .section_coupons > .container > .row.coupon--four-item > div:nth-child(4n) .coupon-desc-info:before,
   .cart-coupon .coupon-desc-info:before,
   .details-product .coupon-desc-info:before{
       left: 100%;
       right: auto;
   }
   .coupon_item:hover{
       z-index: 1;
   }
   .coupon-desc--head{
       padding: 10px;
       background: var(--coupon-button-color);
       color: #fff;
       border-top-left-radius: inherit;
       border-top-right-radius: inherit;
   }
   .coupon-desc--body{
       border-bottom-left-radius: inherit;
       border-bottom-right-radius: inherit;
   }
   .coupon-desc--row{
       display: grid;
       grid-template-columns: 40px 1fr;
       padding: 10px;
       background: #fff;
       margin: 5px 0;
       line-height: 1.3;
   }
   .coupon-desc--row:nth-child(2n) {
       background: #fafafa;
   }
   .coupon-desc--row.coupon-about{
       display: block;
       line-height: 1.5;
       text-align: justify;
       border-bottom-left-radius: inherit;
       border-bottom-right-radius: inherit;
   }
   .coupon-copy-code{
       display: inline-block;
       margin-left: 5px;
       background: initial;
       padding: 0 !important;
       margin-bottom: 0 !important;
       cursor: pointer;
   }
   .coupon-copy-code > i{
       font-size: 15px;
   }
   .coupon-copy-code.disabled > i:before{
       font-weight: 600;
   }
   
   
   
   .cart-coupon {
       --width: 412px;
       position: fixed;
       width: 100vw;
       height: 100%;
       top: 0;
       right: 0;
       transform: translateX(var(--width));
       z-index: -1;
       background: #fff;
       margin: 0 !important;
       transition: all 0.5s cubic-bezier(0.47, 1.64, 0.41, 0.8);
       visibility: hidden;
       opacity: 0;
       max-width: var(--width);
   }
   @media (max-width: 767px) {
       .cart-coupon {
           --width: 100%;
       }
   }
   @media (min-width: 413px) {
       .cart-coupon .section_coupons {
           padding: 0 20px;
       }
   }
   .cart-coupon.active {
       z-index: 9999;
       transform: translateX(0);
       visibility: visible;
       opacity: 1;
       border-left: 1px solid #eee;
   }
   .cart-coupon .section_coupons .col-lg {
       padding-right: 15px;
   }
   .cart-coupon .section_coupons .row {
       flex-wrap: wrap;
       overflow: auto;
       padding-bottom: 120px;
   }
   .cart-coupon-header {
       height: 40px;
       display: grid;
       grid-template-columns: 0 1fr;
       text-align: center;
       align-items: center;
       box-shadow: 0px 0px 0px rgba(63, 63, 68, 0.05), 0px 1px 3px rgba(63, 63, 68, 0.15);
       font-weight: 600;
   }
   .cart-coupon-header .coupon-toggle-btn {
       padding: 8px 12px;
       font-size: 20px;
       display: flex;
       color: #574141;
       align-items: center;
       z-index: 3;
   }
   .cart-coupon .section_coupons {
       margin-top: 10px;
       max-height: 100%;
       overflow: auto;
   }
   #coupon-modal.show ~ .modal-backdrop {
       z-index: 9999;
   }
   .cart-coupon-footer {
       height: 60px;
       display: flex;
       align-items: center;
       justify-content: center;
       padding: 10px;
       box-shadow: 0px 0px 0px rgba(63, 63, 68, 0.05), 0px 1px 3px rgba(63, 63, 68, 0.15);
       position: fixed;
       width: 100%;
       bottom: 0;
       z-index: 3;
       background: #fff;
       max-width: calc(var(--width) - 15px);
   }
   .cart-coupon-footer .btn {
       border-radius: 4px !important;
   }
   .cart-coupon.active + .cart-coupon-overlay {
       position: fixed;
       width: 100%;
       height: 100vh;
       background: rgba(0, 0, 0, 0.4);
       top: 0;
       left: 0;
       z-index: 1001;
   }
   .cart-coupon .section_coupons .coupon-item-wrap{
       -ms-flex: 0 0 100%;
       flex: 0 0 100%;
       max-width: 100%;
   }
   
   .product-coupons {
       display: flex;
       margin-left: -5px;
       margin-right: -5px;
       align-items: center;
       cursor: pointer;
       overflow-x: auto;
   }
   .coupon_item.lite {
       flex: 0 0 auto;
       border-radius: 0;
       filter: none;
       min-height: 0;
       overflow: hidden;
       padding: 0!important;
       margin-left: 5px;
       margin-right: 5px;
   }
   .coupon_item.lite:before {
       content: normal;
   }
   .coupon_item.lite .coupon_content {
       border: 1px solid var(--coupon-lite-border);
       color: var(--coupon-lite-border);
       border-radius: 5px;
       padding: 3px 12px;
       position: relative;
           font-size: 14px;
   
   }
   .coupon_item.lite .coupon_content:before, .coupon_item.lite .coupon_content:after {
       content: '';
       position: absolute;
       border-radius: 999px;
       width: 10px;
       height: 10px;
       background: #fff;
       border: 1px solid var(--coupon-lite-border);
       top: 50%;
       transform: translateY(-50%);
   }
   .coupon_item.lite .coupon_content:before {
       left: -5px;
   }
   .coupon_item.lite .coupon_content:after {
       right: -5px;	
   }
   @media (max-width: 767px) {
       .header-cart-price .coupon-toggle {
           display: none !important;
       }
       .coupon_item.lite .coupon_content {
           font-size: 12px;
       }
   }
   
   @media (min-width: 992px) and (max-width: 1600px){
       .coupon_item .coupon_icon{
           width: 50px;
           flex: 0 0 50px;
       }
       .coupon_item.coupon--new-style .coupon_body{
           padding: 10px 10px;
       }
       .coupon_item .coupon_body .coupon_desc{
           min-height: 33px;
       }
       .coupon_item .coupon_head + div{
           min-height: 44px;
       }
       .section_coupons [class*=col-] {
           padding: 5px 10px;
       }
   }
    
</style>
