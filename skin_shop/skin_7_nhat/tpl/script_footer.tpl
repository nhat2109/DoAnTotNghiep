

<link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/addthis-sharing.css"
    media="print" onload="this.media='all'" />

<!-- sharring_zalo_message_telephone -->
<div class="addThis_listSharing">
    <a href="#" id="back-to-top" class="backtop back-to-top d-flex align-items-center justify-content-center"
        title="Lên đầu trang">
        <svg class="icon" style="transform: rotate(-90deg)">
            <use xlink:href="#icon-arrow" />
        </svg>
    </a>

    <ul class="addThis_listing list-unstyled d-none d-sm-block">
        <li class="addThis_item">
            <a class="addThis_item--icon" href="tel:19006750" rel="nofollow">
                <img class="img-fluid"
                   src="/uploads/minh-hoa/addthis-phone.svg"
                    alt="Gọi ngay cho chúng tôi" loading="lazy" width="44" height="44" />
                <span class="tooltip-text">Gọi ngay cho chúng tôi</span>
            </a>
        </li>
        <li class="addThis_item">
            <a class="addThis_item--icon" href="https://zalo.me/834141234794359440" target="_blank" rel="nofollow">
                <img class="img-fluid"
                    src="/uploads/minh-hoa/addthis-zalo.svg"
                    alt="Gọi ngay cho chúng tôi" loading="lazy" width="44" height="44" />
                <span class="tooltip-text">Chat với chúng tôi qua Zalo</span>
            </a>
        </li>

        <li class="addThis_item">
            <a class="addThis_item--icon" href=" https://m.me/" target="_blank" rel="nofollow">
                <img class="img-fluid"
                    src="/uploads/minh-hoa/addthis-messenger.svg"
                    alt="Chat với chúng tôi qua Messenger" loading="lazy" width="44" height="44" />
                <span class="tooltip-text">Chat với chúng tôi qua Messenger</span>
            </a>
        </li>
    </ul>
</div>
<!-- Messenger Plugin chat Code -->

<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat"></div>
<!-- chưa biết làm gì -->
<script>
    $(document).ready(() => {
        const page_id = " 388836827817823";
        if (page_id && window.outerWidth > 600) {
            $(window).one(" mousemove touchstart scroll", () => {
                var chatbox = document.getElementById("fb-customer-chat");
                if (chatbox) {
                    chatbox.setAttribute("page_id", page_id);
                    chatbox.setAttribute("attribution", "biz_inbox");
                }
                window.fbAsyncInit = function () {
                    FB.init({
                        xfbml: true,
                        version: "v12.0",
                    });
                };

                (function (d, s, id) {
                    var js,
                        fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src =
                        "https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
                    fjs.parentNode.insertBefore(js, fjs);
                })(document, "script", "facebook-jssdk");
            });
        }
    });
</script>

<script type="text/x-custom-template" data-template="ItemDropCart">
  <li class="item productid-${id_item}">
      <div class="border_list"><div class="image_drop">
          <a class="product-image pos-relative embed-responsive embed-responsive-1by1" href="${url}" title="${title}">
              <img loading="lazy" alt="${title}" src="${image_url}"width="'+ '100' +'"\>
          </a>
          </div>
          <div class="detail-item">
              <div class="product-details">
                  <span href="javascript:;" data-id="${id_item}" title="Xóa" class="remove-item-cart fa fa-times"></span>
                  <p class="product-name"> <a class="link" href="${url}" title="${title}">${title}</a></p></div>
                  <span class="variant-title">${variant_title}</span>
              <div class="product-details-bottom"><span class="price">${price}</span>
                  <span class="quanlity">x ${quanty}</span>
                  <div class="quantity-select qty_drop_cart d-none">
                      <input class="variantID" type="hidden" name="variantId" value="${id_item}">
                      <button onClick="var result = document.getElementById('qty${id_item}'); var qty${id_item} = result.value; if( !isNaN( qty${id_item} ) &amp;&amp; qty${id_item} &gt; 1 ) result.value--;return false;" class="btn btn_reduced reduced items-count btn-minus" ${buttonQty} type="button">–</button>
                      <input type="text" maxlength="3" min="1" readonly class="form-control input-text number-sidebar qty${id_item}" id="qty${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
                      <button onClick="var result = document.getElementById('qty${id_item}'); var qty${id_item} = result.value; if( !isNaN( qty${id_item} )) result.value++;return false;" class=" btn btn_increase increase items-count btn-plus" type="button">+</button>
                  </div>
              </div>
          </div>
      </div>
    </li>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="HeaderCartPc">
   <div class="cart page_cart hidden-xs hidden-sm row">
  <form action="/cart" method="post" novalidate class="formcartpage col-lg-12 col-md-12 margin-bottom-0">
      <div class="bg-scroll">
          <div class="cart-thead">
              <div style="width: 18%" class="a-center">Ảnh sản phẩm</div>
              <div style="width: 32%" class="a-center">Tên sản phẩm</div>
              <div style="width: 17%" class="a-center">Đơn giá</div>
              <div style="width: 14%" class="a-center">Số lượng</div>
              <div style="width: 14%" class="a-center">Thầnh tiền</div>
              <div style="width: 5%" class="a-center">Xóa</div>
          </div>
          <div class="cart-tbody">
          </div>
      </div>
  </form>
   </div>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="pageCartCheckout">
   <div class="col-lg-7 col-md-7">
  <a href="/" class="form-cart-continue">Tiếp tục mua hàng</a>
   </div>
   <div class="col-lg-5 col-md-5">
  <div class="section bg_cart shopping-cart-table-total">
      <div class="table-total">
          <table class="table">
              <tr>
                  <td coldspan="20" class="total-text">Tổng tiền thanh toán: </td>
                  <td class="txt-right totals_price price_end a-right">${price_total}</td>
              </tr>
          </table>
      </div>
  </div>
  <div class="section continued">
      <a href="/checkout" class="btn-checkout-cart button_checkfor_buy">Tiến hành thanh toán</a>
  </div>
   </div>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="pageCartItem">
   <div class="item-cart productid-${id_item}">
  <div style="width: 18%" class="image">
      <a class="product-image a-left" title="${title}" href="${url}">
          <img loading="lazy" width="75" height="auto" alt="${title}" src="${image_url}">
      </a>
  </div>
  <div style="width: 32%" class="a-center">
      <h3 class="product-name"> <a class="text2line link" href="${url}" title="${title}">
      ${title}</a> </h3>
      <span class="variant-title">${variant_title}</span>
      <a class="remove-itemx remove-item-cart" title="Xóa" href="javascript:;" data-id="${id_item}">
          <span><i class="fa fa-times"></i></span>
      </a>
  </div>
  <div style="width: 17%" class="a-center">
      <span class="cart-prices">
          <span class="prices">${price}</span>
      </span>
  </div>
  <div style="width: 14%" class="a-center">
      <div class="input_qty_pr">
          <input class="variantID" type="hidden" name="variantId" value="${id_item}">
          <button onClick="var result = document.getElementById('qtyItem${id_item}'); var qtyItem${id_item} = result.value; if( !isNaN( qtyItem${id_item} ) &amp;&amp; qtyItem${id_item} &gt; 1 ) result.value--;return false;" ${buttonQty} class="reduced_pop items-count btn-minus" type="button">-</button>
          <input type="text" maxlength="3" readonly min="0" class="check_number_here input-text number-sidebar input_pop input_pop qtyItem${id_item}" id="qtyItem${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
          <button onClick="var result = document.getElementById('qtyItem${id_item}'); var qtyItem${id_item} = result.value; if( !isNaN( qtyItem${id_item} )) result.value++;return false;" class="increase_pop items-count btn-plus" type="button">+</button>
      </div>
  </div>
  <div style="width: 14%" class="a-center">
      <span class="cart-price">
          <span class="price">${price_quanty}</span>
      </span>
  </div>
  <div style="width: 5%" class="a-center">
      <a class="remove-itemx remove-item-cart" title="Xóa" href="javascript:;" data-id="${id_item}">
          <span><i class="fa fa-trash-alt"></i></span>
      </a>
  </div>
   </div>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="ItemCartMobile">
        <div class="item-product item productid-${id_item} ">
          <div class="text-center">
              <a class="remove-itemx remove-item-cart " title="Xóa" href="javascript:;" data-id="${id_item}">
                  <svg  class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
  <g clip-path="url(#clip0)">
  <path d="M0.620965 12C0.462896 12 0.304826 11.9399 0.184729 11.8189C-0.0563681 11.5778 -0.0563681 11.1869 0.184729 10.9458L10.9497 0.180823C11.1908 -0.0602744 11.5817 -0.0602744 11.8228 0.180823C12.0639 0.421921 12.0639 0.8128 11.8228 1.05405L1.05795 11.8189C0.936954 11.9392 0.778884 12 0.620965 12Z" fill="#8C9196"/>
  <path d="M11.3867 12C11.2287 12 11.0707 11.9399 10.9505 11.8189L0.184729 1.05405C-0.0563681 0.8128 -0.0563681 0.421921 0.184729 0.180823C0.425827 -0.0602744 0.816706 -0.0602744 1.05795 0.180823L11.8228 10.9458C12.0639 11.1869 12.0639 11.5778 11.8228 11.8189C11.7018 11.9392 11.5439 12 11.3867 12Z" fill="#8C9196"/>
  </g>
  <defs>
  <clipPath id="clip0">
  <rect width="12" height="12" fill="white"/>
  </clipPath>
  </defs>
  </svg>
              </a>
          </div>
          <div class="item-product-cart-mobile">
              <a href="${url}">
                  <a class="product-images1  pos-relative embed-responsive embed-responsive-1by1" href=""  title="${title}">
                      <img loading="lazy" class="img-fluid" src="${image_url}" alt="${title}">
                  </a>
              </a>
          </div>
          <div class="product-cart-infor">
          <div class="title-product-cart-mobile">
              <h3 class="product-name"> <a class="text2line link" href="${url}" title="${title}">
              ${title}</a>  </h3>
              <span class="variant-title">${variant_title}</span>
          </div>

          <div class="cart-price">
              <span class="product-price price">${price_quanty}</span>
          </div>
          <div class="select-item-qty-mobile">
              <div class="txt_center">
                  <input class="variantID" type="hidden" name="variantId" value="${id_item}">
                  <button onClick="var result = document.getElementById('qtyMobile${id_item}'); var qtyMobile${id_item} = result.value; if( !isNaN( qtyMobile${id_item} ) &amp;&amp; qtyMobile${id_item} &gt; 1 ) result.value--;return false;" class="reduced items-count btn-minus btn" type="button"><svg class="icon">
      <use xlink:href="#icon-minus" />
  </svg></button>
                  <input type="text" maxlength="3" min="1" class="form-control input-text number-sidebar qtyMobile${id_item}" id="qtyMobile${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
                  <button onClick="var result = document.getElementById('qtyMobile${id_item}'); var qtyMobile${id_item} = result.value; if( !isNaN( qtyMobile${id_item} )) result.value++;return false;" class="increase items-count btn-plus btn" type="button"><svg class="icon">
      <use xlink:href="#icon-plus" />
  </svg></button>
              </div>
          </div>
          </div>
        </div>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="pageCartCheckoutMobile">
                                  <div class='cart-upsell'>
      <div class='cart-upsell__progress-wrapper'>
          <div class='cart-upsell__progress'>
              <div class='cart-upsell__progress-bar'
                   style='background-color: #dae1e8'>
                  <div class='cart-upsell__percent'
                       style='width: 95%; background-color: #5bb72e;'>
                  </div>
              </div>
              <span style='color: #2EB346;'></span>
          </div>
      </div>

      <div class='cart-upsell__promotion-wrapper'>
          <div class='cart-upsell__promotion'
               style='border-width: 1px;
                      border-style: solid;
                      border-color: #f88b38;
                      color: #dc7322;
                      background: #feeee2;'>
                          <img src="/uploads/minh-hoa/cart_upsell_coupon.png" alt='cart-upsell'/>
                          <strong>EGAFREESHIP</strong>
              <button style='background-color: #f88b38;
                             color: #ffffff;
                             border-radius: 99999px;
                             border-color: rgb(255, 140, 0);'>
                  Sao chép
              </button>
          </div>
      </div>

      <div class='cart-upsell__content'
           style='--incomplete-color: #202223;
                  --incomplete-price: #d22d00;
                  --complete-color: #202223'>
      </div>
  </div>					  <div class="header-cart-price">
            <div class="timedeli-modal">
            <div class="timedeli-modal-content">
              <button type="button" class="close window-close d-sm-none" aria-label="Close" style="z-index: 9;"><span aria-hidden="true">×</span></button>
              <div class="timedeli d-sm-block"></div>
              <div class="timedeli-cta">
                  <button class="btn btn-block timedeli-btn  d-sm-none" type="button">
                    <span>Xong</span>
                  </button>
              </div>
            </div>
            <div class="timedeli-overaly"></div>
          </div>

  <div class="r-bill">
      <div class="checkbox">
          <input type="hidden" name="attributes[invoice]" id="re-checkbox-bill"
                 value='không'>
          <input type="checkbox" id="checkbox-bill" value="có"
                 class="regular-checkbox" />
          <label for="checkbox-bill" class="box"></label>
          <label for="checkbox-bill" class="title">Xuất hóa đơn công ty</label>
      </div>
      <div class="bill-field">
          <div class="form-group">
              <label>Tên công ty</label>
              <input type="text" class="form-control val-f"
                     name="attributes[company_name]"
                     value=""
                     placeholder="Tên công ty" >
          </div>
          <div class="form-group">
              <label>Mã số thuế</label>
              <input type="number" pattern=".{10,}" onkeydown="return FilterInput(event)"
                     onpaste="handlePaste(event)"
                     class="form-control val-f val-n"
                     name="attributes[tax_code]"
                     value=""
                     placeholder="Mã số thuế">
          </div>
          <div class="form-group">
              <label>Địa chỉ công ty</label>
              <textarea type="text" class="form-control val-f"
                        name="attributes[company_address]"
                        placeholder="Nhập địa chỉ công ty (bao gồm Phường/Xã, Quận/Huyện, Tỉnh/Thành phố nếu có)"></textarea>
          </div>
          <div class="form-group">
              <label>Email nhận hoá đơn</label>
              <input type="email" class="form-control val-f val-email"
                     name="attributes[invoice_email]"
                     value=""
                     placeholder="Email nhận hoá đơn">
          </div>
      </div>
  </div>


          <div class="title-cart d-none d-sm-flex ">
              <h3 class="text-xs-left">TỔNG CỘNG</h3>
              <span class="text-xs-right  totals_price_mobile">${price_total}</span>
              <i class="text-xs-right price_vat ">(Đã bao gồm VAT nếu có)</i>		</div>

                <div class='cart-limit-alert d-xs-none'
                       >
                      <i class="fa fa-info-circle mr-1" aria-hidden="true"></i> Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ
  Vui lòng chọn mua thêm sản phẩm
              </div>



          <div class="checkout mt-2">
              <button class="btn btn-block btn-proceed-checkout-mobile" title="Tiến hành thanh toán"
                      type="button" onclick='goToCheckout(event)'>
                  <span>Thanh Toán</span>
              </button>
          </div>

          <div class="cart-trustbadge mt-3">
              <div class="product-trustbadge d-flex flex-wrap align-items-center">
      <a href="/collections/all"
         target="_blank"
         title="Phương thức thanh toán">
          <img class=" img-fluid" loading="lazy"
               src="/uploads/minh-hoa/footer_trustbadge.png"
               alt="Phương thức thanh toán"
               width="301"
               height="36"
               >
      </a>
  </div>
          </div>
                </div>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="templateStickyCheckout">
    <div class="cart-sticky-cta">



                <div class='cart-limit-alert '
                       >
                      <i class="fa fa-info-circle mr-1" aria-hidden="true"></i> Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ
  Vui lòng chọn mua thêm sản phẩm
              </div>

          <div class="cart-cta">

                  <div class="toggle-delivery col-5 d-flex justify-content-start align-items-center flex-column px-2">
              <img loading="lazy" src="/uploads/minh-hoa/delivery-icon.png" alt="delivery" ->
              <span>HẸN GIỜ NHẬN HÀNG</span>
          </div>
                  <div>
                  <button class="btn btn-block btn-proceed-checkout-mobile" title="Tiến hành thanh toán"
                      type="button" onclick="goToCheckout(event)">
                  <span>Thanh Toán</span> <span class="text-xs-right  totals_price_mobile">${price_total}</span>
              </button>
                      <i class="text-xs-right price_vat ">(Đã bao gồm VAT nếu có)</i>			</div>
          </div>
          </div>
</script>
<!-- chưa biết làm gì -->
<script type="text/x-custom-template" data-template="TemplateItemPopupCart">
  <div class="item-popup productid-${id_item}">
      <div style="width: 13%;" class="height image_ text-left">
          <div class="item-image">
              <a class="product-image" href="${url}" title="${title}">
                  <img loading="lazy" alt="${title}" src="${image_url}"width="'+ '90' +'"\>
              </a>
          </div>
      </div>
      <div style="width:40%;" class="height text-left fix_info">
          <div class="item-info">
              <p class="item-name">
                  <a class="text2line textlinefix link" href="${url}" title="${title}">${title}</a>
              </p>
              <span class="variant-title-popup">${variant_title}</span>
              <a href="javascript:;" class="remove-item-cart" title="Xóa" data-id="${id_item}">
                  <i class="fa fa-times"></i>&nbsp;&nbsp;Bỏ sản phẩm
              </a>
              <p class="addpass" style="color:#fff;margin:0px;">${id_item}</p>
          </div>
      </div>
      <div style="width: 15%;" class="height text-center">
          <div class="item-price">
              <span class="price">${price}</span>
          </div>
      </div>
      <div style="width: 15%;" class="height text-center">
          <div class="qty_h check_">
              <input class="variantID" type="hidden" name="variantId" value="${id_item}">
              <button onClick="var result = document.getElementById('qtyItemP${id_item}'); var qtyItemP${id_item} = result.value; if( !isNaN( qtyItemP${id_item} ) &amp;&amp; qtyItemP${id_item} &gt; 1 ) result.value--;return false;" ${buttonQty} class="num1 reduced items-count btn-minus" type="button">-</button>
              <input type="text" maxlength="3" min="0" readonly class="input-text number-sidebar qtyItemP${id_item}" id="qtyItemP${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
              <button onClick="var result = document.getElementById('qtyItemP${id_item}'); var qtyItemP${id_item} = result.value; if( !isNaN( qtyItemP${id_item} )) result.value++;return false;" class="num2 increase items-count btn-plus" type="button">+</button>
          </div>
      </div>
      <div style="width: 17%;" class="height text-center">
          <span class="cart-price">
              <span class="price">${price_quanty}</span>
          </span>
      </div>
  </div>
</script>

<script src="/skin_shop/skin_7_nhat/tpl/js/api.jquery.js"></script>
<script src="/skin_shop/skin_7_nhat/tpl/js/ega-gateway-min.js" type="text/javascript"></script>
    <!-- proccess -->
<script>
    var GLOBAL = {
        common: {
            init: function () {
                $(document).on("click", ".add_to_cart", addToCart);
                $(document).on("click", ".buynow", buynow);
            },
        },
        templateIndex: {
            init: function () { },
        },
        templateProduct: {
            init: function () { },
        },
        templateCart: {
            init: function () { },
        },
        money_format: "{{amount_no_decimals_with_comma_separator}}₫",
        urlMailChimp:
            "https://egany.us5.list-manage.com/subscribe/post?u=30fc9d9e428051fcf936d142c&id=8a0a96cc36",
        vendorUrl: "/skin_shop/skin_7_nhat/tpl/js/vendors.js",
        newsletterFormAction:
            "https://egany.us11.list-manage.com/subscribe/post?u=5a58afacba94c1c4a94c354c9&id=2a7da1a514&f_id=000694e0f0",
        bannerPopupShow: true,
    };
    var UTIL = {
        fire: function (func, funcname, args) {
            var namespace = GLOBAL;
            funcname = funcname === undefined ? "init" : funcname;
            if (
                func !== "" &&
                namespace[func] &&
                typeof namespace[func][funcname] == "function"
            ) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function () {
            var bodyId = document.body.id;
            UTIL.fire("common");
            $.each(document.body.className.split(/\s+/), function (i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, bodyId);
            });
        },
    };
    $(document).ready(UTIL.loadEvents);
    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
            c = isNaN((c = Math.abs(c))) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "." : t,
            s = n < 0 ? "-" : "",
            i = parseInt((n = Math.abs(+n || 0).toFixed(c))) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return (
            s +
            (j ? i.substr(0, j) + t : "") +
            i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +
            (c
                ? d +
                Math.abs(n - i)
                    .toFixed(c)
                    .slice(2)
                : "")
        );
    };
    function addToCart(e) {
        if (typeof e !== "undefined") e.preventDefault();
        var $this = $(this);
        var form = $this.parents("form");
        $.ajax({
            type: "POST",
           // url: "/cart/add.js",
            async: false,
            data: form.serialize(),
            dataType: "json",
            error: addToCartFail,
            beforeSend: function () { },
            success: addToCartSuccess,
            cache: false,
        });
    }
    function buynow(e) {
        if (typeof e !== "undefined") e.preventDefault();
        var $this = $(this);
        var form = $this.parents("form");
        const callback = (cart) => {
            location.href = "/checkout";
        };

        $.ajax({
            type: "POST",
           // url: "/cart/add.js",
            async: false,
            data: form.serialize(),
            dataType: "json",
            error: addToCartFail,
            beforeSend: function () { },
            success: (jqXHR, textStatus, errorThrown) => {
                addToCartSuccess(jqXHR, textStatus, errorThrown, callback);
            },
            cache: false,
        });
    }
    function qty() {
        var dqty = $("#qtym").val();
        if (dqty == undefined) {
            return 1;
        }
        return dqty;
    }

    function checkCartLimit(e, totalPrice) {
        e.preventDefault();

        if (totalPrice < Number("100000")) {
            swal({
                title: `Thông báo`,
                text: `Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ 
Vui lòng chọn mua thêm sản phẩm`,
                type: "warning",
                className: "cart-limit-modal",
                button: "Xác nhận",
            });
            return;
        } else {
            location.href = "/checkout";
        }
    }
    function addToCartSuccess(jqXHR, textStatus, errorThrown, callback) {
        $.ajax({
            type: "GET",
            //// url: " ",,
            async: false,
            cache: false,
            dataType: "json",
            success: function (cart) {
                awe.hidePopup(".loading");
                var url_product = jqXHR["url"];
                var class_id = jqXHR["product_id"];
                var name = jqXHR["name"];
                var textDisplay =
                    '<i style="margin-right:5px; color:red; font-size:13px;" class="fa fa-check" aria-hidden="true"></i>Sản phẩm vừa thêm vào giỏ hàng';
                var id = jqXHR["variant_id"];
                var dataList = $(".item-name a")
                    .map(function () {
                        var plus = $(this).text();
                        return plus;
                    })
                    .get();
                $(".title-popup-cart .cart-popup-name").html(
                    '<a href="' +
                    url_product +
                    '" title="' +
                    name +
                    '">' +
                    name +
                    "</a> "
                );
                var nameid = dataList,
                    found = $.inArray(name, nameid);
                var textfind = found;

                var src = "";
                if (
                    Bizweb.resizeImage(jqXHR["image"], "small") == null ||
                    Bizweb.resizeImage(jqXHR["image"], "small") == "null" ||
                    Bizweb.resizeImage(jqXHR["image"], "small") == ""
                ) {
                    src =
                        "https://mixcdn.egany.com/themes/assets/thumb/large/noimage.gif";
                } else {
                    src = Bizweb.resizeImage(jqXHR["image"], "small");
                }
                $(".item-info > p:contains(" + id + ")").html(
                    '<span class="add_sus" style="color:#898989;"><i style="margin-right:5px; color:#3cb878; font-size:14px;" class="fa fa-check" aria-hidden="true"></i>Sản phẩm vừa thêm</span>'
                );

                var va_title = jqXHR["variant_title"];

                if (va_title == "Default Title") {
                    va_title = "";
                } else {
                    va_title = jqXHR["variant_title"];
                }
                var windowW = $(window).width();
                $("#popup-cart").addClass("opencart");
                $("body").addClass("opacitycart");
                $("#popup-cart").addClass("opencart");
                $("body").addClass("opacitycart");
                $("#popupCartModal").html("");
                const limit = Number("100000");
                const cart_action =
                    cart.total_price >= limit
                        ? `
        <a href="/checkout" class="btn btn-main btn-full">Thanh toán</a>
            <a  href="/cart" class="btn checkout_button btn-full">Xem giỏ hàng</a>

        `
                        : `
        <button type="button" class="btn btn-main" data-dismiss="modal" data-backdrop="false"
                aria-label="Close" >Mua thêm</button>
        <a  href="/cart" class="btn btn-main  checkout_button btn-full">Xem giỏ hàng</a>
        `;
                let limit_message = `Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ 
Vui lòng chọn mua thêm sản phẩm`;
                limit_message = limit_message
                    ? `<span class="mr-2"><i class="fa fa-info-circle" aria-hidden="true"></i></span> ${limit_message}`
                    : "";
                var $popupMobile = `<div class="modal-dialog align-vertical">
<div class="modal-content "><button type="button" class="close" data-dismiss="modal" data-backdrop="false"
    aria-label="Close" style="z-index: 9;"><span aria-hidden="true">×</span></button>
  <div class="row row-noGutter">
    <div class="modal-left col-sm-12 col-lg-12 col-md-12">
      <h3 class="modal-title"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.00006 15.3803C12.0761 15.3803 15.3804 12.076 15.3804 7.99995C15.3804 3.92391 12.0761 0.619629 8.00006 0.619629C3.92403 0.619629 0.619751 3.92391 0.619751 7.99995C0.619751 12.076 3.92403 15.3803 8.00006 15.3803Z" fill="#2EB346"/>
        <path d="M8 16C3.58916 16 0 12.4115 0 8C0 3.58916 3.58916 0 8 0C12.4115 0 16 3.58916 16 8C16 12.4115 12.4115 16 8 16ZM8 1.23934C4.27203 1.23934 1.23934 4.27203 1.23934 8C1.23934 11.728 4.27203 14.7607 8 14.7607C11.728 14.7607 14.7607 11.7273 14.7607 8C14.7607 4.27203 11.728 1.23934 8 1.23934Z" fill="#2EB346"/>
        <path d="M7.03336 10.9434C6.8673 10.9434 6.70865 10.8771 6.59152 10.7582L4.30493 8.43438C4.06511 8.19023 4.06821 7.7986 4.31236 7.55816C4.55652 7.31898 4.94877 7.32145 5.18858 7.5656L7.0154 9.42213L10.7948 5.25979C11.0259 5.00635 11.4176 4.98838 11.6698 5.21766C11.9232 5.44757 11.9418 5.8392 11.7119 6.09326L7.49193 10.7408C7.3773 10.8672 7.21618 10.9403 7.04577 10.944C7.04143 10.9434 7.03771 10.9434 7.03336 10.9434Z" fill="white"/>
        </svg>
        <span>Thêm vào giỏ hàng thành công</span></h3>
      <div class="modal-body">
        <div class="media">
          <div class="media-left thumb_img">
            <div class="thumb-1x1"><img loading="lazy"
                src="${src}"
                alt="${jqXHR["title"]}"></div>
          </div>
          <div class="media-body body_content">
            <div class="product-title">${jqXHR["title"]}</div>
            <div class="variant_title font-weight-light"><span>${va_title}</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-right margin-top-10 col-sm-12 col-lg-12 col-md-12">
      <div class="title right_title d-flex justify-content-between" ><a href="/cart"> Giỏ hàng hiện có </a>
    <div class="text-right">
        <span class="price">${Bizweb.formatMoney(
                    cart.total_price,
                    "{{amount_no_decimals_with_comma_separator}}₫"
                )}</span>
        <div class="count font-weight-light">
            (<span
        class="cart-popup-count">4</span>) sản phẩm 
        </div>
    </div>
        
  
      </div>
        
        ${cart.total_price < limit
                        ? `  <div class="cart-message">${limit_message}</div>`
                        : ""
                    }
          
          <div class="cart-action">
                        ${cart_action}

          </div>
    </div>
  </div>
</div>
</div>`;
                $("#popupCartModal").html($popupMobile);

                if (typeof callback == "function" && cart.total_price >= limit) {
                    return callback(cart);
                }
                $("#popupCartModal").modal();
                Bizweb.updateCartFromForm(
                    cart,
                    ".top-cart-content .mini-products-list"
                );
                Bizweb.updateCartPopupForm(
                    cart,
                    "#popup-cart-desktop .tbody-popup"
                );
            },
        });
    }
    function addToCartFail(jqXHR, textStatus, errorThrown) {
        var response = $.parseJSON(jqXHR.responseText);
        var $info = '<div class="error">' + response.description + "</div>";
    }
    function getDelivery() {
        if (!$(".ega-delivery").length && window.egaDeliveryValid) {
            var head = document.getElementsByTagName("head").item(0);
            var script = document.createElement("script");
            script.setAttribute(
                "src",
                "/skin_shop/skin_7_nhat/tpl/js/delivery-addon.js"
            );
            head.appendChild(script);
        }
    }
    $(document).on("click", ".remove-item-cart", function () {
        var variantId = $(this).attr("data-id");
        removeItemCart(variantId);
    });
    $(document).on("click", ".items-count", function () {
        $(this).parent().children(".items-count").prop("disabled", true);
        var thisBtn = $(this);
        var variantId = $(this).parent().find(".variantID").val();
        var qty = $(this).parent().children(".number-sidebar").val();
        updateQuantity(qty, variantId);
    });
    $(document).on("change", ".number-sidebar", function () {
        var variantId = $(this).parent().children(".variantID").val();
        var qty = $(this).val();
        updateQuantity(qty, variantId);
    });
    function updateQuantity(qty, variantId) {
        var variantIdUpdate = variantId;
        $.ajax({
            type: "POST",
            // url: " ",,
            data: { quantity: qty, variantId: variantId },
            dataType: "json",
            success: function (cart, variantId) {
                Bizweb.onCartUpdateClick(cart, variantIdUpdate);
                cart_min();
            },
            error: function (qty, variantId) {
                Bizweb.onError(qty, variantId);
            },
        });
    }
    function removeItemCart(variantId) {
        var variantIdRemove = variantId;
        $.ajax({
            type: "POST",
            // url: " ",,
            data: { quantity: 0, variantId: variantId },
            dataType: "json",
            success: function (cart, variantId) {
                Bizweb.onCartRemoveClick(cart, variantIdRemove);
                $(".productid-" + variantIdRemove).remove();
                if ($(".tbody-popup>div").length == "0") {
                    $("#popup-cart").removeClass("opencart");
                    $("body").removeClass("opacitycart");
                }
                if ($(".list-item-cart>li").length == "0") {
                    $(".mini-products-list").html(
                        '<div class="no-item"><p>Không có sản phẩm nào.</p></div>'
                    );
                }
                if ($(".cart-mobile .item-product").length == "0") {
                    $(".page_cart").empty();
                    $(".header-cart-content").empty();
                    $(".cart-mobile .header-cart").hide();
                    $(".title_cart_pc").html(
                        '<p class="hidden-xs-down">Không có sản phẩm nào. Quay lại <a href="/" style="color:;">cửa hàng</a> để tiếp tục mua sắm.</p>'
                    );
                    $(".cart-empty").show();
                    $(".cart-sticky-cta").remove();
                }
                cart_min();
            },
            error: function (variantId, r) {
                Bizweb.onError(variantId, r);
            },
        });
    }
    function render(props) {
        return function (tok, i) {
            return i % 2 ? props[tok] : tok;
        };
    }
    Bizweb.updateCartFromForm = function (
        cart,
        cart_summary_id,
        cart_count_id
    ) {
        if (typeof cart_summary_id === "string") {
            var cart_summary = jQuery(cart_summary_id);
            if (cart_summary.length) {
                // Start from scratch.
                cart_summary.empty();
                // Pull it all out.
                jQuery.each(cart, function (key, value) {
                    if (key === "items") {
                        var table = jQuery(cart_summary_id);
                        if (value.length) {
                            jQuery('<ul class="list-item-cart"></ul>').appendTo(table);
                            jQuery.each(value, function (i, item) {
                                var buttonQty = "";
                                if (item.quantity == "1") {
                                    buttonQty = "disabled";
                                } else {
                                    buttonQty = "";
                                }
                                var link_img0 = Bizweb.resizeImage(item.image, "compact");
                                if (
                                    link_img0 == "null" ||
                                    link_img0 == "" ||
                                    link_img0 == null
                                ) {
                                    link_img0 =
                                        "https://bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif";
                                }
                                if (item.variant_title == "Default Title") {
                                    var ItemDropCart = [
                                        {
                                            url: item.url,
                                            image_url: link_img0,
                                            price: Bizweb.formatMoney(
                                                item.price,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            title: item.title,
                                            buttonQty: buttonQty,
                                            quanty: item.quantity,
                                            id_item: item.variant_id,
                                            variant_title: "",
                                        },
                                    ];
                                } else {
                                    var ItemDropCart = [
                                        {
                                            url: item.url,
                                            image_url: link_img0,
                                            price: Bizweb.formatMoney(
                                                item.price,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            title: item.title,
                                            buttonQty: buttonQty,
                                            quanty: item.quantity,
                                            id_item: item.variant_id,
                                            variant_title: item.variant_title,
                                        },
                                    ];
                                }
                                $(function () {
                                    var TemplateItemDropCart = $(
                                        'script[data-template="ItemDropCart"]'
                                    )
                                        .text()
                                        .split(/\$\{(.+?)\}/g);
                                    $(".list-item-cart").append(
                                        ItemDropCart.map(function (item) {
                                            return TemplateItemDropCart.map(render(item)).join(
                                                ""
                                            );
                                        })
                                    );
                                });
                            });
                            jQuery(
                                '<div class="pd"><div class="top-subtotal">Tổng tiền tạm tính: <span class="price price_big">' +
                                Bizweb.formatMoney(
                                    cart.total_price,
                                    "{{amount_no_decimals_with_comma_separator}}₫"
                                ) +
                                "</span></div></div>"
                            ).appendTo(table);
                            jQuery(
                                '<div class="pd right_ct"><a href="/cart" class="btn btn-white"><span>Tiến hành thanh toán</span></a></div>'
                            ).appendTo(table);
                        } else {
                            jQuery(
                                '<div class="no-item"><p>Không có sản phẩm nào.</p></div>'
                            ).appendTo(table);
                        }
                    }
                });
            }
        }
        updateCartDesc(cart);
        var numInput = document.querySelector("#cart-sidebar input.input-text");
        if (numInput != null) {
            // Listen for input event on numInput.
            numInput.addEventListener(
                "input",
                function () {
                    // Let's match only digits.
                    var num = this.value.match(/^\d+$/);
                    if (num == 0) {
                        // If we have no match, value will be empty.
                        this.value = 1;
                    }
                    if (num === null) {
                        // If we have no match, value will be empty.
                        this.value = "";
                    }
                },
                false
            );
        }
    };

    Bizweb.updateCartPageForm = function (
        cart,
        cart_summary_id,
        cart_count_id
    ) {
        if (typeof cart_summary_id === "string") {
            var cart_summary = jQuery(cart_summary_id);
            if (cart_summary.length) {
                // Start from scratch.
                cart_summary.empty();
                // Pull it all out.
                jQuery.each(cart, function (key, value) {
                    if (key === "items") {
                        var table = jQuery(cart_summary_id);
                        if (value.length) {
                            var HeaderCartPc = $('script[data-template="HeaderCartPc"]')
                                .text()
                                .split(/\$\{(.+?)\}/g);
                            var pageCartCheckout = $(
                                'script[data-template="pageCartCheckout"]'
                            )
                                .text()
                                .split(/\$\{(.+?)\}/g);

                            $(table).append(function () {
                                return HeaderCartPc.map(render()).join("");
                            });

                            jQuery.each(value, function (i, item) {
                                var buttonQty = "";
                                if (item.quantity == "1") {
                                    buttonQty = "disabled";
                                } else {
                                    buttonQty = "";
                                }
                                var link_img1 = Bizweb.resizeImage(item.image, "compact");
                                if (
                                    link_img1 == "null" ||
                                    link_img1 == "" ||
                                    link_img1 == null
                                ) {
                                    link_img1 =
                                        "https://bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif";
                                }

                                if (item.variant_title == "Default Title") {
                                    var ItemCartPage = [
                                        {
                                            url: item.url,
                                            image_url: link_img1,
                                            price: Bizweb.formatMoney(
                                                item.price,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            title: item.title,
                                            buttonQty: buttonQty,
                                            quanty: item.quantity,
                                            variant_title: item.variant_title,
                                            price_quanty: Bizweb.formatMoney(
                                                item.price * item.quantity,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            id_item: item.variant_id,
                                            variant_title: "",
                                        },
                                    ];
                                } else {
                                    var ItemCartPage = [
                                        {
                                            url: item.url,
                                            image_url: link_img1,
                                            price: Bizweb.formatMoney(
                                                item.price,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            title: item.title,
                                            buttonQty: buttonQty,
                                            quanty: item.quantity,
                                            variant_title: item.variant_title,
                                            price_quanty: Bizweb.formatMoney(
                                                item.price * item.quantity,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            id_item: item.variant_id,
                                        },
                                    ];
                                }

                                $(function () {
                                    var pageCartItem = $(
                                        'script[data-template="pageCartItem"]'
                                    )
                                        .text()
                                        .split(/\$\{(.+?)\}/g);
                                    $(table.find(".cart-tbody")).append(
                                        ItemCartPage.map(function (item) {
                                            return pageCartItem.map(render(item)).join("");
                                        })
                                    );
                                });
                            });

                            var PriceTotalCheckout = [
                                {
                                    price_total: Bizweb.formatMoney(
                                        cart.total_price,
                                        "{{amount_no_decimals_with_comma_separator}}₫"
                                    ),
                                },
                            ];
                            $(table.children(".cart")).append(
                                PriceTotalCheckout.map(function (item) {
                                    return pageCartCheckout.map(render(item)).join("");
                                })
                            );
                        } else {
                            jQuery(
                                '<p class="hidden-xs-down ">Không có sản phẩm nào. Quay lại <a href="/collections/all" style="color:;">cửa hàng</a> để tiếp tục mua sắm.</p>'
                            ).appendTo(table);
                            jQuery(".cart_desktop_page").css("min-height", "auto");
                        }
                    }
                });
            }
        }
        updateCartDesc(cart);
        jQuery("#wait").hide();
    };
    Bizweb.updateCartPopupForm = function (
        cart,
        cart_summary_id,
        cart_count_id
    ) {
        if (typeof cart_summary_id === "string") {
            var cart_summary = jQuery(cart_summary_id);
            if (cart_summary.length) {
                // Start from scratch.
                cart_summary.empty();
                // Pull it all out.
                jQuery.each(cart, function (key, value) {
                    if (key === "items") {
                        var table = jQuery(cart_summary_id);
                        if (value.length) {
                            jQuery.each(value, function (i, item) {
                                var src = item.image;
                                if (src == null) {
                                    src =
                                        "https://bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif";
                                }
                                var buttonQty = "";
                                if (item.quantity == "1") {
                                    buttonQty = "disabled";
                                } else {
                                    buttonQty = "";
                                }

                                if (item.variant_title == "Default Title") {
                                    var ItemPopupCart = [
                                        {
                                            url: item.url,
                                            image_url: src,
                                            price: Bizweb.formatMoney(
                                                item.price,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            title: item.title,
                                            quanty: item.quantity,
                                            variant_title: "",
                                            price_quanty: Bizweb.formatMoney(
                                                item.price * item.quantity,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            id_item: item.variant_id,
                                        },
                                    ];
                                } else {
                                    var ItemPopupCart = [
                                        {
                                            url: item.url,
                                            image_url: src,
                                            price: Bizweb.formatMoney(
                                                item.price,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            title: item.title,
                                            quanty: item.quantity,
                                            variant_title: item.variant_title,
                                            price_quanty: Bizweb.formatMoney(
                                                item.price * item.quantity,
                                                "{{amount_no_decimals_with_comma_separator}}₫"
                                            ),
                                            id_item: item.variant_id,
                                        },
                                    ];
                                }

                                $(function () {
                                    var TemplateItemPopupCart = $(
                                        'script[data-template="TemplateItemPopupCart"]'
                                    )
                                        .text()
                                        .split(/\$\{(.+?)\}/g);
                                    $(table).append(
                                        ItemPopupCart.map(function (item) {
                                            return TemplateItemPopupCart.map(render(item)).join(
                                                ""
                                            );
                                        })
                                    );
                                });

                                $(".link_product").text();
                            });
                        }
                    }
                });
            }
        }
        jQuery(".total-price").html(
            Bizweb.formatMoney(
                cart.total_price,
                "{{amount_no_decimals_with_comma_separator}}₫"
            )
        );
        updateCartDesc(cart);
    };
    Bizweb.updateCartPageFormMobile = function (
        cart,
        cart_summary_id,
        cart_count_id
    ) {
        if (typeof cart_summary_id === "string") {
            var cart_summary = jQuery(cart_summary_id);
            if (cart_summary.length) {
                // Start from scratch.
                cart_summary.empty();
                // Pull it all out.
                if (cart.items && cart.items.length) {
                    var table = jQuery(cart_summary_id);
                    jQuery(
                        '<div class="cart_page_mobile content-product-list"></div>'
                    ).appendTo(table);
                    jQuery.each(cart.items, function (i, item) {
                        if (item.image != null) {
                            var src = Bizweb.resizeImage(item.image, "compact");
                        } else {
                            var src =
                                "https://mixcdn.egany.com/themes/assets/thumb/large/noimage.gif";
                        }
                        var ItemCartPageMobile = [
                            {
                                url: item.url,
                                image_url: src,
                                price: Bizweb.formatMoney(
                                    item.price,
                                    "{{amount_no_decimals_with_comma_separator}}₫"
                                ),
                                title: item.title,
                                quanty: item.quantity,
                                variant_title:
                                    item.variant_title !== "Default Title"
                                        ? item.variant_title
                                        : "",
                                price_quanty: Bizweb.formatMoney(
                                    item.price * item.quantity,
                                    "{{amount_no_decimals_with_comma_separator}}₫"
                                ),
                                id_item: item.variant_id,
                            },
                        ];

                        var pageCartItemMobile = $(
                            'script[data-template="ItemCartMobile"]'
                        )
                            .text()
                            .split(/\$\{(.+?)\}/g);

                        $(table.children(".content-product-list")).append(
                            ItemCartPageMobile.map(function (item) {
                                return pageCartItemMobile.map(render(item)).join("");
                            })
                        );
                    });

                    var pageCartCheckoutMobile = $(
                        'script[data-template="pageCartCheckoutMobile"]'
                    )
                        .text()
                        .split(/\$\{(.+?)\}/g);
                    var PriceTotalCheckoutMobile = [
                        {
                            price_total: Bizweb.formatMoney(
                                cart.total_price,
                                "{{amount_no_decimals_with_comma_separator}}₫"
                            ),
                        },
                    ];
                    if (window.outerWidth < 767) {
                        var stickyCartCheckout = $(
                            'script[data-template="templateStickyCheckout"]'
                        )
                            .text()
                            .split(/\$\{(.+?)\}/g);
                        $("body").append(
                            PriceTotalCheckoutMobile.map(function (item) {
                                return stickyCartCheckout.map(render(item)).join("");
                            })
                        );
                    }
                    $(table).append(
                        PriceTotalCheckoutMobile.map(function (item) {
                            return pageCartCheckoutMobile.map(render(item)).join("");
                        })
                    );

                    $(".cart_page_mobile").append(`<div class="cart-note">
                <label for="note" class="note-label">Ghi chú đơn hàng</label>
                <textarea id="note" name="note" rows="8"></textarea>
            </div>`);
                }
            }
        }
        updateCartDesc(cart);
        updateCartUpsell(cart);
    };

    function updateCartDesc(data) {
        var $cartPrice = Bizweb.formatMoney(
            data.total_price,
            "{{amount_no_decimals_with_comma_separator}}₫"
        ),
            $cartMobile = $("#header .cart-mobile .quantity-product"),
            $cartDesktop = $(".count_item_pr, .count_sidebar, .cart-popup-count"),
            $cartDesktopList = $(".cart-counter-list"),
            $cartPopup = $(".cart-popup-count");

        switch (data.item_count) {
            case 0:
                $cartMobile.text("0");
                $cartDesktop.text("0");
                $cartDesktopList.text("0");
                $cartPopup.text("0");

                break;
            case 1:
                $cartMobile.text("1");
                $cartDesktop.text("1");
                $cartDesktopList.text("1");
                $cartPopup.text("1");

                break;
            default:
                $cartMobile.text(data.item_count);
                $cartDesktop.text(data.item_count);
                $cartDesktopList.text(data.item_count);
                $cartPopup.text(data.item_count);

                break;
        }
        $(
            ".top-cart-content .top-subtotal .price, aside.sidebar .block-cart .subtotal .price, .popup-total .total-price"
        ).html($cartPrice);
        $(".popup-total .total-price").html($cartPrice);
        $(
            ".shopping-cart-table-total .totals_price, .price_sidebar .price_total_sidebar"
        ).html($cartPrice);
        $(".totals_price_mobile").html($cartPrice);
        $(".cartCount, .cart-popup-count, #ega-cart-count").html(
            data.item_count
        );
    }

    Bizweb.onCartUpdate = function (cart) {
        Bizweb.updateCartFromForm(cart, ".mini-products-list");
        Bizweb.updateCartPopupForm(cart, "#popup-cart-desktop .tbody-popup");
    };
    Bizweb.onCartUpdateClick = function (cart, variantId) {
        updateCartUpsell(cart);
        jQuery.each(cart, function (key, value) {
            if (key === "items") {
                jQuery.each(value, function (i, item) {
                    if (item.variant_id == variantId) {
                        $(".productid-" + variantId)
                            .find(".cart-price span.price")
                            .html(
                                Bizweb.formatMoney(
                                    item.price * item.quantity,
                                    "{{amount_no_decimals_with_comma_separator}}₫"
                                )
                            );
                        $(".productid-" + variantId)
                            .find(".items-count")
                            .prop("disabled", false);
                        $(".productid-" + variantId)
                            .find(".number-sidebar")
                            .prop("disabled", false);
                        $(".productid-" + variantId + " .number-sidebar").val(
                            item.quantity
                        );
                        $(".list-item-cart .item.productid-" + variantId)
                            .find(".quanlity")
                            .text("x " + item.quantity);
                        if (item.quantity == "1") {
                            $(".productid-" + variantId)
                                .find(".items-count.btn-minus")
                                .prop("disabled", true);
                        }
                    }
                });
            }
        });
        updateCartDesc(cart);
    };
    Bizweb.onCartRemoveClick = function (cart, variantId) {
        jQuery.each(cart, function (key, value) {
            if (key === "items") {
                jQuery.each(value, function (i, item) {
                    if (item.variant_id == variantId) {
                        $(".productid-" + variantId).remove();
                    }
                });
            }
        });
        updateCartDesc(cart);
        updateCartUpsell(cart);
    };
    const initCart = () => {
        $.ajax({
            type: "GET",
           // // url: " ",,
            async: false,
            cache: false,
            dataType: "json",
            success: function (cart) {
                Bizweb.updateCartFromForm(cart, ".mini-products-list");
                Bizweb.updateCartPopupForm(
                    cart,
                    "#popup-cart-desktop .tbody-popup"
                );

                if (!cart.item_count) {
                }
            },
        });

        var wDWs = $(window).width();
        if (wDWs < 1199) {
            $(".top-cart-content").remove();
        }
    };
    $(window).ready(function () {
        $(window).one(" mousemove touchstart scroll", initCart);
    });

    //Check inventory
    $(document).on("click", ".items-count", function () {
        $(this).parent().children(".items-count").prop("disabled", true);
        var variantId = $(this).parent().find(".variantID").val(),
            qty = $(this).parent().children(".number-sidebar").val(),
            url = $(this)
                .parent()
                .parent()
                .parent()
                .find(".product-name a")
                .attr("href");
        CheckQtyCart(qty, variantId, url);
    });
    function CheckQtyCart(qty, variantId, url) {
        if (!url) return;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "" + url + ".json",
            success: function (data) {
                locationData = data;
                for (var i = 0; i < locationData.variants.length; i++) {
                    if (locationData.variants[i].id == variantId) {
                        var maxS = locationData.variants[i].inventory_quantity,
                            allow = locationData.variants[i].inventory_management,
                            continues = locationData.variants[i].inventory_policy;
                        if (allow == "bizweb") {
                            $(".productid-" + variantId + "")
                                .find(".items-count.btn-plus")
                                .css("pointer-events", "auto");
                            if (continues == "deny") {
                                $(".productid-" + variantId + "")
                                    .find(".items-count.btn-plus")
                                    .css("pointer-events", "none");
                                if (qty >= maxS) {
                                    updateQuantity(maxS, variantId);
                                    $(".productid-" + variantId + "")
                                        .find(".quanlity")
                                        .text(`x ${maxS}`);
                                    $(".productid-" + variantId + "")
                                        .find(".items-count.btn-plus")
                                        .css("pointer-events", "none");
                                } else {
                                    $(".productid-" + variantId + "")
                                        .find(".items-count.btn-plus")
                                        .css("pointer-events", "auto");
                                }
                            } else if (continues == "continue") {
                                $(".productid-" + variantId + "")
                                    .find(".items-count.btn-plus")
                                    .css("pointer-events", "auto");
                            } else {
                                $(".productid-" + variantId + "")
                                    .find(".items-count.btn-plus")
                                    .css("pointer-events", "auto");
                            }
                        }
                    }
                }
            },
        });
    }
    function alertInvalidQty(qty) {
        alert(`Bạn chỉ có thể mua tối đa ${qty} sản phẩm`);
    }
    function validateQty(product, variantId, qty) {
        let isInValidQty = false;
        /** check variant **/
        let variant =
            product && product.variants.find((item) => item.id == variantId);
        if (
            variant &&
            variant.inventory_management === "bizweb" &&
            variant.inventory_policy == "deny"
        ) {
            isInValidQty = qty > variant.inventory_quantity;
            isInValidQty && alertInvalidQty(variant.inventory_quantity);
            return isInValidQty ? variant.inventory_quantity : false;
        }
        return isInValidQty;
    }
    function cart_min() {
        var sts = true;
        $.ajax({
            type: "GET",
          //  // url: " ",,
            async: false,
            success: function (data) {
                var cart = parseInt(data.total_price + "");
                var cart_compare = parseInt(100000);
                if (cart < cart_compare) {
                    $(".btn-proceed-checkout-mobile").addClass("disabled");
                    $(".cart-limit-alert").css("display", "block");
                    $("#template-cart").removeClass("cart-available");
                    sts = false;
                } else {
                    $(".btn-proceed-checkout-mobile").removeClass("disabled");
                    $(".cart-limit-alert").css("display", "none");
                    $("#template-cart").addClass("cart-available");
                }
            },
        });
        return sts;
    }

    $(document).ready(function () {
        $(window).one("mousemove touchstart scroll", cart_min);
    });

    function updateCartUpsell(cart) {
        const priceMin = 500000;
        const totalPrice = cart.total_price;
        let remain = priceMin > totalPrice ? priceMin - totalPrice : 0;
        let percent =
            priceMin > totalPrice
                ? Math.round((totalPrice / priceMin) * 100) === 100
                    ? "99%"
                    : Math.round((totalPrice / priceMin) * 100) + "%"
                : "100%";
        let incompleteInfo = "Bạn cần mua thêm [price] nữa để được Freeship";
        const completeInfo =
            "Chúc mừng! Đơn hàng của bạn đã đủ điều kiện được Freeship 🎉";
        const copyBtnContent = "Sao chép";
        const copiedBtnContent = "Đã sao chép";
        const coupon = "EGAFREESHIP";

        remain = `<span class="cart-upsell__price">${Bizweb.formatMoney(
            remain,
            "{{amount_no_decimals_with_comma_separator}}₫"
        )}</span>`;

        incompleteInfo = incompleteInfo.replaceAll("[price]", remain);

        $(".cart-upsell__percent").css("width", percent);

        // incomplete
        if (totalPrice === 0) {
            $(".cart-upsell__empty-wrapper").show();
            $(
                ".cart-upsell__progress-wrapper, .cart-upsell__promotion, .cart-upsell__content"
            ).hide();
        } else {
            $(".cart-upsell__empty-wrapper").hide();

            $(".cart-upsell__progress-wrapper, .cart-upsell__content").show();

            $(".cart-upsell__progress span").html(percent);

            if (totalPrice < priceMin) {
                $(".cart-upsell__content")
                    .removeClass("complete")
                    .addClass("incomplete")
                    .html(incompleteInfo);

                $(".cart-upsell__promotion-wrapper").hide();
            } else {
                $(".cart-upsell__content")
                    .removeClass("incomplete")
                    .addClass("complete")
                    .html(completeInfo);

                $(".cart-upsell__promotion-wrapper").show();
                $(".cart-upsell__promotion button:not(.disabled)").on(
                    "click",
                    function (e) {
                        e.preventDefault();
                        const _this = $(this);
                        _this.html(copiedBtnContent);
                        _this.addClass("disabled");
                        setTimeout(function () {
                            _this.html(copyBtnContent);
                            _this.removeClass("disabled");
                        }, 3000);
                        navigator.clipboard.writeText(coupon);
                    }
                );
            }
        }
    }
</script>
<script src="/skin_shop/skin_7_nhat/tpl/js/api-jquery-custom.js"></script>

<link rel="preload" as="script" href="/skin_shop/skin_7_nhat/tpl/js/main.js" />
<script src="/skin_shop/skin_7_nhat/tpl/js/main.js"
    type="text/javascript"></script>
<!-- Mobile ega-cr-addon -->
<script>
    var cro_show = true,
      cro_addcart_show = true,
      cro_cart_show = true,
      cro_addcart_title = "Thêm vào giỏ",
      cro_addcart_bg = "#090302",
      cro_addcart_color = "#fff",
      cro_price_color = "#e9330d",
      cro_compare_price_color = "#979797";
      (cro_variant_color = "#EC720E"),
      (cro_variant_bg = "#fff"),
      (cro_cta_bg = "#090302"),
      (cro_cta_color = ""),
      (cro_addcart_modal_mess = "Tiến hành thanh toán"),
      (cro_addcart_modal_redirect = ""),
      (cro_modal_btn_text = ""),
      (cro_modal_btn_bg = ""),
      (cro_modal_btn_color = ""),
      (cro_hotline_show = true),
      (cro_hotline_number = "{hotline}"),
      (cro_mess_show = true),
      (cro_mess_url = "https://m.me/SocDoPage/"),
      (cro_home_show = 3),
      (cro_home_title = "Ưu đãi"),
      (cro_home_url = "flash-sale.html"),
      (cro_coll_title = "Danh mục"),
      (cro_coll_url = "/san-pham.html"),
      (cro_blog_title = "Cửa hàng"),
      (cro_blog_url = "/lien-he.html"),
      (cro_general_color = "#EC720E"),
      (cro_product_color = "#EC720E"),
      (cro_background_color = "#fff"),
      (cro_label_background = " #e9330d"),
      (cro_label_color = "#ffffff");

    const crAddonScript =
      "/skin_shop/skin_7_nhat/tpl/js/index.min.js";
    window["cro-btn"] = {
      shop: "ega-furniture.mysapo.net",
      platform: "sapo",
      moneyFormat: "{{amount_no_decimals}}₫",
      currentTemplate: "collection",
      platformApi: Bizweb,
      scripts: [],
      lang: {
        email_invalid: "Email không đúng định dạng",
        phone_invalid: "Số điện thoại không đúng định dạng",
        require_invalid: "Vui lòng điền trường này",
        unavailable: "Liên hệ",
      },
    };
    window.egany = window.egany || {};

    window.egany["cro-btn"] = {
      mobile: {
        enable: true,
        general: {
          enable: true,
          design: {
            template: "shoppee",
            background: "#ffffff",
            customCss: "",
            croBorderRadius: 0,
            ctaBorderRadius: 5,
          },
          buttons: [
            {
              id: "cro-link-1",
              className: "",
              order: "4",
              type: "link",
              title: cro_coll_title,
              link: cro_coll_url,
              icon: "/uploads/minh-hoa/icon-cro-coll.png",
              background: "#fff",
              color: cro_general_color,
              action: "",
            },
            {
              id: "cro-link-2",
              className: "",
              order: "5",
              type: "link",
              title: cro_blog_title,
              link: cro_blog_url,
              icon: "/uploads/minh-hoa/icon-cro-blog.png",
              background: "#fff",
              color: cro_general_color,
              action: "",
            },

            {
              id: "cro-link-3",
              className: "",
              order: "3",
              type: "link",
              title: cro_home_title,
              link: cro_home_url,
              icon: "/uploads/minh-hoa/cro-home-icon.png",
              background: "#fff",
              color: cro_general_color,
              action: "",
            },

            {
              id: "cro-mess-1",
              className: "",
              order: "2",
              type: "chat",
              title: "Nhắn tin",
              link: cro_mess_url,
              icon: "/uploads/minh-hoa/cro-mess-icon.png",
              background: "#fff",
              color: cro_general_color,
            },

            {
              id: "cro-phone-1",
              className: "",
              order: "1",
              type: "call",
              title: "Gọi điện",
              link: cro_hotline_number,
              icon: "/uploads/minh-hoa/cro-phone-icon.png",
              background: "#fff",
              color: cro_general_color,
            },
          ],
        },
        product: {
          enable: true,
          buttons: [
            {
              id: "cro-mess-1",
              className: "",
              order: "2",
              type: "chat",
              title: "Nhắn tin",
              link: cro_mess_url,
              icon: "/uploads/minh-hoa/cro-mess-icon.png",
              background: "#fff",
              color: cro_general_color,
            },

            {
              id: "cro-phone-1",
              className: "",
              order: "1",
              type: "call",
              title: "Gọi điện",
              link: cro_hotline_number,
              icon: "/uploads/minh-hoa/cro-phone-icon.png",
              background: "#fff",
              color: cro_general_color,
            },

            {
              id: "cro-view-cart",
              order: 3,
              type: "cart",
              title: "Giỏ hàng",
              icon: "/uploads/minh-hoa/cro-cart-icon.png",
              background: "#ffff",
              color: cro_general_color,
              countColor: "red",
              countBg: "yellow",
              labelBackgorund: "#ff0000",
              labelColor: "#fff",
              labelBackground: "#ff0000",
            },

            {
              id: "cro-buy-add-cart",
              order: 5,
              type: "addtocart",
              title: "Thêm vào giỏ",
              subTitle: "Hết hàng",
              icon: "",
              background: cro_addcart_bg,
              color: cro_addcart_color,
              className: "",
              border: "none",
              borderColor: "transparent",
              padding: "transparent",
              borderRadius: "0px",
            },
          ],
        },
      },
      productPopup: {
        variantInfo: {
          enable: false,
          title: "<p><u>Bảng quy đổi kích cỡ</u></p>",
          color: "#2E72D2",
          url: "/",
          action: "new_page",
          
        },
        design: {
          comparePriceColor: cro_compare_price_color,
          variantBg: cro_variant_bg,
          variantBorderColor: cro_variant_color,
          priceColor: cro_price_color,
          variantBorderRadius: 20,
          variantColor: cro_variant_color,
          variantBorder: "1px solid",
          ctaIcon: true,
          template: "default",
        },
        saleLabel: {
          background: cro_label_background,
          priceColor: cro_price_color,
          color: cro_label_color,
          discountColor: "#000",
          title: "",
          template: "price",
        },
        qty: {
          borderRadius: 20,
          background: "#fff",
          borderColor: "#D7D7D7",
          enable: true,
          title: "Số lượng",
          color: "#8C9196",
          border: "1px solid",
        },
        cta: {
          animation: "",
          background: cro_addcart_bg,
          gaEventLabel: "",
          borderRadius: "4",
          color: cro_addcart_color,
          icon: "",
          id: "cro-product-cta",
          title: "Thêm vào giỏ",
          type: "cta",
          className: "",
        },
        auto: false,
        lang: {
          ctaDescription: "",
          contact: "Liên Hệ",
          soldout: "Hết hàng",
        },
        enable: true,
      },
      cartPopup: {
        header: {
          color: "#2EB346",
          background: "#EBF6ED",
          borderColor: "#2EB346",
          border: "1px dashed",
          icon: "http://theme.hstatic.net/1000406621/1000576502/14/cartpopup.header.icon-cro-icon.png?v=2134",
        },
        cta: {
          background: "#fe3945",
          title: "Xem giỏ hàng",
          color: "#fff",
          link: "/gio-hang.html",
          type: "cta",
          id: "cro-popup-cta",
          borderRadius: "4",
        },
        subCta: {
          borderColor: "#aeaeae",
          title: "Mua thêm",
          color: "#000000",
          border: "1px solid",
          id: "subCta",
          borderRadius: "4",
          link: "close",
          type: "cta",
        },
        title: "<p>Thêm vào giỏ hàng thành công</p>",
        subCtaEnable: false,
        closeCta: { title: "Mua thêm", color: "#212B36" },
        enable: false,
      },
    };

    $(document).ready(function ($) {
      if (window.outerWidth <= 600) {
        var isInit = false;
        window.egany["cro-btn"].mobile.general.buttons.sort((a, b) =>
          a.order > b.order ? 1 : -1
        );
        $(window).on("scroll click mousemove touchstart", () => {
          if (!isInit) {
            isInit = true;
            $("body").append(
              `<script src="${crAddonScript}" defer ><\/script>`
            );
          }
        });
      }
    });
  </script>

<!-- <link rel="preload" as="style" media="all"
    href="/skin_shop/skin_7_nhat/tpl/css/sapo-popup.css" />
<link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/sapo-popup.css"
    media="all" /> -->
    <style>
        .popup-sapo {
            position: fixed;
            bottom: 140px;
            left: 17px;
            margin: 0;
            z-index: 999;
            top: auto !important;
        }
        
        .popup-sapo .icon {
            position: relative;
            z-index: 4;
            height: 48px;
            width: 48px;
            text-align: center;
            border-radius: 50%;
            border: 1px solid #ffffff;
            cursor: pointer;
            background: var(--primary-color);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .popup-sapo .content {
            background:#fff;
            color: var(--color-foreground);
            padding: 20px 10px 20px;
            border-radius: 10px;
            width: 300px;
            position: absolute;
            bottom: 32px;
            left: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            -webkit-transform-origin: 100% bottom;
            transform-origin: 0 bottom;
            transform: scale(0);
            -webkit-transform: scale(0);
            -moz-transform: scale(0);
            -ms-transform: scale(0);
            -o-transform: scale(0);
            transition: -webkit-transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1),-webkit-transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            -webkit-transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .popup-sapo.active .content {
            -ms-transition-delay: 0.1s;
            -webkit-transition-delay: 0.15s;
            transition-delay: 0.1s;
            transform: scale(1);
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
        }
        
        .popup-sapo .content .close-popup-sapo {
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer;
        }
        
        @media (max-width: 500px) {
            .popup-sapo .content {
                width:250px
            }
        }
        
        .popup-sapo .content .title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px
        }
        
        .popup-sapo .content .close-popup-sapo {
            position: absolute;
            right: 5px;
            top: 5px;
            cursor: pointer
        }
        
        .popup-sapo .content .close-popup-sapo svg {
            width: 15px;
            height: 15px
        }
        
        .popup-sapo .content .close-popup-sapo svg path {
            fill: currentColor
        }
        
        .popup-sapo .content ul {
            margin-bottom: 10px
        }
        
        .popup-sapo .content ul li {
            margin-bottom: 0px
        }
        
        .popup-sapo .content ul li svg {
            margin-right: 10px
        }
        
        .popup-sapo .content ul li svg path {
            fill: #fff
        }
        
        .popup-sapo .content ul li a {
             
            font-size: 13px;
        }
        
        .popup-sapo .content ul li a:hover {
            opacity: 0.8
        }
        
        .popup-sapo .content .ghichu {
            font-style: italic;
            font-size: 13px
        }
        .popup-sapo .icon svg {
            fill: #ffffff;
            width: 20px;
            height: 20px;
            transition: opacity 0.35s ease-in-out, -webkit-transform 0.35s ease-in-out;
            transition: opacity 0.35s ease-in-out, transform 0.35s ease-in-out;
            transition: opacity 0.35s ease-in-out, transform 0.35s ease-in-out, -webkit-transform 0.35s ease-in-out;
            animation: iconSkew 1s infinite ease-out;
            min-height: -webkit-fill-available;
        }
        
        @keyframes iconSkew {
            0% {
                transform: rotate(0deg) scale(1) skew(1deg)
            }
        
            10% {
                transform: rotate(-25deg) scale(1) skew(1deg)
            }
        
            20% {
                transform: rotate(25deg) scale(1) skew(1deg)
            }
        
            30% {
                transform: rotate(-25deg) scale(1) skew(1deg)
            }
        
            40% {
                transform: rotate(25deg) scale(1) skew(1deg)
            }
        
            50% {
                transform: rotate(0deg) scale(1) skew(1deg)
            }
        
            100% {
                transform: rotate(0deg) scale(1) skew(1deg)
            }
        }
    </style>
<!-- icon chuông -->
<div class="popup-sapo active">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path
                d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z">
            </path>
        </svg>
    </div>
    <div class="content">
        <div class="title">Tích hợp sẵn các ứng dụng</div>
        <ul class="">
            <li>
                <a href="https://socdo.vn" target="_blank" title="Đánh giá sản phẩm"
                    aria-label="Đánh giá sản phẩm">Đánh giá sản phẩm</a>
            </li>

            <li>
                <a href="https://socdo.vn" target="_blank">Ứng dụng Affiliate</a>
            </li>
            <li>
                <a href="https://socdo.vn" target="_blank">
                    Đa ngôn ngữ</a>
            </li>
            <li>
                <a href="https://socdo.vn" target="_blank">
                    Mua X Tặng Y
                </a>
            </li>
            <li>
                <a href="https://socdo.vn/" target="_blank">Combo sản phẩm</a>
            </li>
        </ul>
        <div class="ghichu">
            Lưu ý với các ứng dụng trả phí bạn cần cài đặt và mua ứng dụng này
            trên Web Socdo.vn để sử dụng ngay
        </div>
        <span title="Đóng" class="close-popup-sapo">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                y="0px" viewBox="0 0 512.001 512.001" style="enable-background: new 0 0 512.001 512.001"
                xml:space="preserve">
                <g>
                    <g>
                        <path
                            d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z">
                        </path>
                    </g>
                </g>
            </svg>
        </span>
    </div>


    
</div>

<script>
    $(".popup-sapo .icon").click(function () {
        $(".popup-sapo").toggleClass("active");
    });
    $(".close-popup-sapo").click(function () {
        $(".popup-sapo").toggleClass("active");
    });
    setTimeout(() => {
        $(".popup-sapo").removeClass("active");
    }, 15000);
</script>
<script>
    window.EGASmartSearchConfigs = {
        // color
        colorBg: "#ffffff",
        colorBgHover: "#f7f7f7",
        colorItemTextTitle: "#000000",
        colorItemTextPrice: "#d82e4d",
        colorItemTextCompareAtPrice: "#8a8a8a",
        colorItemTextViewAll: "#ec720e",
        colorHeaderText: "#000000",
        navBg: "#faedd9",
        navTextColor: "#ec720e",
        navBgActive: "#ec720e",
        navTextColorActive: "#ffffff",
        colorLoading: "#d82e4d",
        // general
        searchAccuracy: "all",
        searchWidth: "450px",
        searchHeight: "400px",
        // product
        productSortby: "default",
        productLimit: 4,
        // article
        displayArticle: true,
        articleLimit: 4,
        moneyFormat: "{{amount_no_decimals_with_comma_separator}}₫",
        shopDomain: "",
        textHeaderSectionTitle: "Kết quả tìm kiếm cho ",
        textProductSectionTitle: "Sản phẩm ",
        textArticleSectionTitle: "Bài viết",
        notFound: "Không tìm thấy kết quả ",
        textFrom: "",
        textShowAll: "Xem thêm kết quả có chứa ",
    };
</script>

<!-- <link href="/skin_shop/skin_7_nhat/tpl/css/ae-multilang-custom.css"
    rel="stylesheet" type="text/css" media="all" /> -->
<style id="ae-switch-lang-css">
    .ae-lang-vi {
        display: inline !important;
    }
</style>
<style id="ae-position-lang-css">
    .ae-hover {
        box-shadow: 0 0 5px #bbb;
    }
</style>

<script>
    var arrTags = [],
        strSelector = "",
        Aecomapp = Aecomapp || {},
        positionObj = null,
        isClick = null,
        btnHtml = "",
        boxConfigHtml = "";
    (Aecomapp.init = function () {
        $(".ae-block-language").removeClass("ae-hide");
    }),
        (Aecomapp.updateCartAttributes = function (e, a) {
            $("body").addClass("ae-multilanguage-changing"),
                $.ajax({
                    type: "POST",
                    url: "/cart/update.js",
                    data: { "attributes[language]": e },
                    dataType: "json",
                    success: function (e) {
                        "function" == typeof a && a(e), window.location.reload();
                    },
                    error: function (e, a) { },
                    complete: function () {
                        $("body").removeClass("ae-multilanguage-changing");
                    },
                });
        }),
        (Aecomapp.gP = function (e, a) {
            a || (a = window.location.href);
            var t = RegExp(
                "[?&]" + (e = e.replace(/[\[\]]/g, "\\$&")) + "(=([^&#]*)|&|#|$)"
            ).exec(a);
            return t
                ? t[2]
                    ? decodeURIComponent(t[2].replace(/\+/g, " "))
                    : ""
                : null;
        }),
        (Aecomapp.aeRm = function (e) {
            try {
                var a = JSON.parse(e.data);
                if (
                    a &&
                    ("position" == a.action &&
                        void 0 !== a.type &&
                        "init" == a.type &&
                        ((btnHtml = a.html),
                            (boxConfigHtml =
                                '<div class="ae-box-lang ae-position-preview ae-type-dropdown">' +
                                btnHtml +
                                "</div>"),
                            (aeUrlDestination = a.des),
                            $("#admin_bar_iframe").remove()),
                        "translate" == a.action)
                ) {
                    void 0 !== a.type &&
                        "init" == a.type &&
                        ((aeUrlDestination = a.des), $("#admin_bar_iframe").remove());
                    var t = { message: window.location.href, action: "confirm" };
                    aeUrlDestination &&
                        window.parent.postMessage(JSON.stringify(t), aeUrlDestination);
                }
            } catch (n) { }
        }),
        (Aecomapp.detectHtml = function (e) {
            if (e) {
                if ("BODY" != e.tagName)
                    arrTags.push({ tag: ">" + e.tagName, index: $(e).index() }),
                        Aecomapp.detectHtml(e.parentElement);
                else {
                    var a = arrTags.length;
                    strSelector = "";
                    for (var t = "", n = a - 1; n >= 0; n--) {
                        var i = arrTags[n].index;
                        t += t ? "-" + i : i;
                    }
                    strSelector = t;
                }
            }
        }),
        (Aecomapp.switchAeLanguage = function (e) {
            var a = ".ae-lang-" + e + "{display:inline!important;}";
            $("#ae-switch-lang-css").html(a);
        }),
        (Aecomapp.aeRenderSelector = function (e) {
            if (!e) return "";
            for (var a = e.length, t = "$('BODY')", n = 0; n < a; n++)
                e[n] && (t = "$(" + t + ".children()[" + e[n] + "])");
            return t;
        }),
        (Aecomapp.replace = function () { }),
        (Aecomapp.validTag = function (e) {
            return (
                0 >
                [
                    "body",
                    "html",
                    "style",
                    "script",
                    "link",
                    "script",
                    "iframe",
                    "comment",
                ].indexOf(e)
            );
        }),
        (Aecomapp.tran = function (sel) {
            if (langDefault == currentLang && langDefault == defaultLangAdmin)
                return !1;
            if (!(!aeData || 0 == aeData.length || Aecomapp.gP("aeType"))) {
                var len = aeData.data.length;
                0 == sel.length && (sel = "body *");
                var listItem = [];
                $(sel).each(function () {
                    var e = $(this)[0].nodeName.toLowerCase();
                    Aecomapp.validTag(e) &&
                        $(this)
                            .contents()
                            .each(function () {
                                if (
                                    ((e = $(this)[0].nodeName.toLowerCase()),
                                        Aecomapp.validTag(e) && 0 == $(this).contents().length)
                                ) {
                                    var a = $(this)[0],
                                        t = a.textContent.trim();
                                   
                                }
                            });
                });
                
                for (var arrPositionBlanks = [], i = 0; i < len; i++) {
                    var item = aeData.data[i],
                        arr = item.position.split("-");
                    eval("var obj = " + (tag = Aecomapp.aeRenderSelector(arr)));
                    var txt = obj.length > 0 ? obj.text() : "";
                    if ((txt = txt.trim())) {
                        if (
                            txt == item.text &&
                            (void 0 === item.repeat || 0 == item.repeat)
                        )
                            try {
                                var desti = "";
                                eval(
                                    "if (typeof item != 'undefined' && typeof item.value != 'undefined' && typeof item.value." +
                                    currentLang +
                                    " != 'undefined') desti = item.value." +
                                    currentLang +
                                    ";"
                                ),
                                    obj.text(desti),
                                    obj.data("tran", !0);
                            } catch (error) { }
                        else arrPositionBlanks.push(i);
                    }
                }
                $(sel + " [title]").each(function () {
                    var item,
                        title = $(this).attr("title");
                    if (
                        void 0 !==
                        aeData.data.find(function (e) {
                            return e.text == title;
                        })
                    ) {
                        var desti = "";
                        eval(
                            "if (typeof item != 'undefined' && typeof item.value != 'undefined' && typeof item.value." +
                            currentLang +
                            " != 'undefined') desti = item.value." +
                            currentLang +
                            ";"
                        ),
                            $(this).attr("title", desti);
                    }
                }),
                    $(sel + " [placeholder]").each(function () {
                        var item,
                            title = $(this).attr("placeholder");
                        if (
                            void 0 !==
                            aeData.data.find(function (e) {
                                return e.text == title;
                            })
                        ) {
                            var desti = "";
                            eval(
                                "if (typeof item != 'undefined' && typeof item.value != 'undefined' && typeof item.value." +
                                currentLang +
                                " != 'undefined') desti = item.value." +
                                currentLang +
                                ";"
                            ),
                                $(this).attr("placeholder", desti);
                        }
                    }),
                    $(listItem).each(function (it) {
                        for (var i = 0; i < len; i++) {
                            var arr,
                                item = aeData.data[i],
                                tag = listItem[it],
                                objTag = tag.item,
                                text = tag.text,
                                desti = "";
                            eval(
                                "if (typeof item != 'undefined' && typeof item.value != 'undefined' && typeof item.value." +
                                currentLang +
                                " != 'undefined') desti = item.value." +
                                currentLang +
                                ";"
                            ),
                                text &&
                                ("1" == item.type
                                    ? text == item.text && (objTag.textContent = desti)
                                    : text.split(item.text).length > 1 &&
                                    (objTag.textContent = text.replace(
                                        item.text,
                                        desti
                                    )));
                        }
                    });
            }
        }),
        (Aecomapp.aeExtractText = function (e) {
            var a = $(e).text().trim();
            $(e)
                .clone()
                .children()
                .each(function () {
                    a = a.replace($(this).text().trim(), "[AE]");
                });
            var t = a.split("[AE]"),
                n = t.length;
            a = "";
            for (var i = 0; i < n; i++) {
                var o = t[i].trim();
                o.length > 0 && (a = a ? a + "[AE]" + o : o);
            }
            return a;
        }),
        (Aecomapp.aeValidHref = function (e) {
            for (
                var a = !0, t = ["mailto", "tel", "javascript;", "#"], n = 0;
                n < t.length;
                n++
            )
                if (0 == e.indexOf(t[n])) return !1;
            return a;
        }),
        (Aecomapp.changeBoxLang = function () {
            var e = $(window).width();
            if (
                ($(
                    ".ae-desktop-lang .ae-block-language, .ae-tablet-lang .ae-block-language, .ae-mobile-lang .ae-block-language"
                ).addClass("ae-hide"),
                    e >= 992 &&
                    $(".ae-desktop-lang .ae-block-language").removeClass("ae-hide"),
                    e < 992 &&
                    e >= 768 &&
                    $(".ae-tablet-lang .ae-block-language").removeClass("ae-hide"),
                    e < 768 &&
                    $(".ae-mobile-lang .ae-block-language").removeClass("ae-hide"),
                    $(".ae-desktop-lang").length > 0)
            ) {
                var a = $(
                    ".ae-desktop-lang .ae-item-lang[data-lang='" + currentLang + "']"
                );
                $(".ae-desktop-lang .ae-lang-selected>a .ae-flag").attr(
                    "src",
                    $(a).find("img").attr("src")
                ),
                    $(".ae-desktop-lang .ae-lang-selected>a span").text(
                        $(a).find("span").text()
                    );
            }
            if ($(".ae-tablet-lang").length > 0) {
                var a = $(
                    ".ae-tablet-lang .ae-item-lang[data-lang='" + currentLang + "']"
                );
                $(".ae-tablet-lang .ae-lang-selected>a .ae-flag").attr(
                    "src",
                    $(a).find("img").attr("src")
                ),
                    $(".ae-tablet-lang .ae-lang-selected>a span").text(
                        $(a).find("span").text()
                    );
            }
            if ($(".ae-mobile-lang").length > 0) {
                var a = $(
                    ".ae-mobile-lang .ae-item-lang[data-lang='" + currentLang + "']"
                );
                $(".ae-mobile-lang .ae-lang-selected>a .ae-flag").attr(
                    "src",
                    $(a).find("img").attr("src")
                ),
                    $(".ae-mobile-lang .ae-lang-selected>a span").text(
                        $(a).find("span").text()
                    );
            }
        }),
        (Aecomapp.initActionDefaultLang = function () {
            $(".ae-item-lang").click(function (e) {
                var a = new Date();
                a.setTime(a.getTime() + 2592e6);
                var t = $(this).data("lang"),
                    n = $(this).find("a").attr("href");
                return (
                    $.ajax({
                        type: "POST",
                        url: "/cart/update.js",
                        data: { "attributes[language]": t },
                        dataType: "json",
                        success: function (e) {
                            e.items && e.items.length > 0
                                ? (window.location.href = n)
                                : "undefined" != typeof requireInit && requireInit
                                    ? $.ajax({
                                        type: "POST",
                                       // url: "/cart/add.js",
                                        data: "quantity=1&variantId=" + productId,
                                        dataType: "json",
                                        success: function (e) {
                                            window.location.href = n;
                                        },
                                        error: function (e, a) { },
                                        complete: function () { },
                                    })
                                    : (window.location.href = n);
                        },
                        error: function (e, a) { },
                        complete: function () { },
                    }),
                    $(".ae-item-lang").removeClass("ae-active"),
                    $(this).addClass("ae-active"),
                    Aecomapp.switchAeLanguage(t),
                    e.preventDefault(),
                    !1
                );
            }),
                $(".ae-item-lang").each(function () {
                    if ($(this).data("lang") == langDefault) {
                        $(this).addClass("ae-active");
                        return;
                    }
                });
        }),
        $(function () {
            $(window).on("resize orientationchange", function () {
                Aecomapp.changeBoxLang();
            });
            var live = Aecomapp.gP("live", window.location.href);
            if ("position" == live)
                window.addEventListener("message", Aecomapp.aeRm),
                    $("*").mousedown(function (e) {
                        if (2 == e.button) {
                            this.tagName,
                                (positionObj = $(this)),
                                (isClick = !0),
                                $(".ae-box-lang").remove(),
                                (arrTags = []);
                            var a = $(this).index();
                            arrTags.push({
                                tag: ">" + this.tagName + ":eq(" + a + ")",
                                index: a,
                            }),
                                Aecomapp.detectHtml(this.parentElement);
                            var t = { position: strSelector, action: "save-position" };
                            return (
                                $(this).append(boxConfigHtml),
                                aeUrlDestination &&
                                (console.log("position====", t),
                                    window.parent.postMessage(
                                        JSON.stringify(t),
                                        aeUrlDestination
                                    )),
                                $(this).hasClass("ae-box-lang") &&
                                $(this).find("ul").toggleClass("ae-active"),
                                !1
                            );
                        }
                    }),
                    $("*")
                        .mouseenter(function () {
                            if (
                                $(this).is("script") ||
                                $(this).is("link") ||
                                $(this).is("style") ||
                                $(this).is("body") ||
                                $(this).is("html")
                            )
                                return !1;
                            $(this).addClass("ae-hover"),
                                $(this).parent().removeClass("ae-hover");
                            var e = !1;
                            return (
                                $(this)
                                    .children()
                                    .each(function () {
                                        $(this).hasClass("ae-box-lang") && (e = !0);
                                    }),
                                !e &&
                                ($(".ae-box-lang").remove(),
                                    $(this).append(boxConfigHtml),
                                    $(positionObj).append(boxConfigHtml),
                                    !1)
                            );
                        })
                        .mouseout(function () {
                            return (
                                $(this).removeClass("ae-hover"),
                                $(".ae-box-lang").remove(),
                                $(positionObj).append(boxConfigHtml),
                                !1
                            );
                        });
            else if ("translate" == live)
                document.addEventListener("contextmenu", function (e) { }, !0),
                    $("*").mousedown(function (e) {
                        if (2 == e.button) {
                            if ((e.preventDefault(), "BODY" == this.tagName)) return !1;
                            arrTags = [];
                            var a = $(this).index();
                            arrTags.push({
                                tag: ">" + this.tagName + ":eq(" + a + ")",
                                index: a,
                            }),
                                Aecomapp.detectHtml(this.parentElement);
                            var t = {
                                position: strSelector,
                                text: Aecomapp.aeExtractText(this),
                                action: "save-translate",
                            };
                            return (
                                console.log("translate===", t),
                                aeUrlDestination &&
                                window.parent.postMessage(
                                    JSON.stringify(t),
                                    aeUrlDestination
                                ),
                                !1
                            );
                        }
                    }),
                    $("*")
                        .mouseenter(function () {
                            if (
                                $(this).is("script") ||
                                $(this).is("link") ||
                                $(this).is("style") ||
                                $(this).is("body") ||
                                $(this).is("html") ||
                                0 == $(this).text().trim().trim().length
                            )
                                return !1;
                            $(this).addClass("ae-hover"),
                                $(this).parent().removeClass("ae-hover");
                        })
                        .mouseout(function () {
                            $(this).removeClass("ae-hover");
                        })
                        .click(function (e) { });
            /*else {
                try {
                    var msg = { message: window.location.href, action: "confirm" };
                    aeUrlDestination &&
                        window.parent.postMessage(
                            JSON.stringify(msg),
                            aeUrlDestination
                        );
                } catch (err) { }
                setTimeout(function () {
                    var tag = "";
                    if (position && position.length > 0) {
                        var arr = position.split("-");
                        tag = Aecomapp.aeRenderSelector(arr);
                    } else tag = Aecomapp.aeRenderSelector(null);
                    if (
                        (tag &&
                            eval(
                                tag +
                                ".append('<div id=\"ae-cover-lang\"class=\"ae-desktop-lang\">' + $(boxLang).html() + '</div>' );"
                            ),
                            (tag = ""),
                            positionTablet && positionTablet.length > 0)
                    ) {
                        var arr = positionTablet.split("-");
                        tag = Aecomapp.aeRenderSelector(arr);
                    } else tag = Aecomapp.aeRenderSelector(null);
                    if (
                        (tag &&
                            eval(
                                tag +
                                ".append('<div id=\"ae-cover-lang\" class=\"ae-tablet-lang\">' + $(boxLang).html() + '</div>' );"
                            ),
                            (tag = ""),
                            positionSmartphone && positionSmartphone.length > 0)
                    ) {
                        var arr = positionSmartphone.split("-");
                        tag = Aecomapp.aeRenderSelector(arr);
                    } else tag = Aecomapp.aeRenderSelector(null);
                    tag &&
                        eval(
                            tag +
                            ".append('<div id=\"ae-cover-lang\" class=\"ae-mobile-lang\">' + $(boxLang).html() + '</div>' );"
                        ),
                        Aecomapp.changeBoxLang(),
                        Aecomapp.initActionDefaultLang();
                    var aelang = Aecomapp.gP("aelang");
                    if (aelang != currentLang) {
                        var isExist = !1;
                        if (
                            ($(".ae-item-lang").each(function () {
                                $(this).data("lang") == aelang &&
                                    ((isExist = !0), $(this).trigger("click"));
                            }),
                                isExist)
                        )
                            return !1;
                    }
                    $(".ae-item-lang").removeClass("ae-active"),
                        $(".ae-item-lang[data-lang='" + currentLang + "']").addClass(
                            "ae-active"
                        );
                }, 1e3),
                    Aecomapp.init(),
                    Aecomapp.switchAeLanguage(langDefault),
                    setTimeout(function () {
                        Aecomapp.tran("body *");
                    }, 1e3),
                    "undefined" != typeof isChangeUrl &&
                    isChangeUrl &&
                    $("a").each(function () {
                        if (
                            void 0 !== $(this).attr("href") &&
                            Aecomapp.aeValidHref($(this).attr("href"))
                        ) {
                            var e =
                                $(this).attr("href").split("?").length > 1 ? "&" : "?";
                            Aecomapp.gP("aelang", $(this).attr("href"))
                                ? (e = "")
                                : (e += "aelang=" + currentLang),
                                $(this).attr("href", $(this).attr("href") + e);
                        }
                    });
            }
        */
        });
</script>

<script>
    
    //var boxLang =  '<div class="ae-cover-lang ae-hide"><div class="ae-block-language ae-type-dropdown ae-hide ae-no-float"><div class="ae-lang-selected"><a href="javascript:;"><img class="ae-icon-left ae-flag" src="data:image/gif;base64,R0lGODlhEAALANUAAPU8POwAAPQAAP96euUAAPdLS/QsHPk8Pf5dXf52dvZERPvMRPx3SvITE/1STvIuLvhSUvj4NflUVf5xcv1ubvQgIPUlJfENDfdDLfpAQPthYftFRfoAAPYqKv5ZWfn5PPr6QfxqavxmZvpdXfMZGfxLS/tKSfc3NvMzM/1UVOAAAPQfH/cxMfxPT/k6OvlzOvYzK/f3MPrAP/f3L/dgL/Z3KvlYWPYsLPzVS/fSMPg+NPX1JPZOKt0AAP0AAP8AACH5BAAAAAAALAAAAAAQAAsAAAaPwJ/w5yv6OByBUhAI/AbQRGJCCYk0Ixuk4BwgEJ6Ug8HIHE6sG/cJFpdkizOrY1EQfImwA7cAfWQ5MBYVAHcTKS0lDh8fETEYFiskhT4ULSYbGS8RMzWRJA0nBBwhmBkuETQ8O5INDSgqHCKZLjoYdAYGDRcXDyoCWDYSWwoKACcoKA8PPUtNzwTRKio91UEAOw==" alt="ap multilangauge"/><span>Tiếng Việt</span><img alt="ap multilangauge" class="ae-icon-right ae-caret" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAAAG1JREFUOI3tzj0Kg2AQhOFHqxAQyRkEIY0XsAl4gxAIHjoXsPIcFmpjLD7wJ5LSt5vdmdnl5O/ccdnwFIi+Ig6WDZ64LoRLdBjWLsSokQTzB/KN72YivJFOukK2ZFwreaHHB+3e62HJ7Ujw5AdGZAQIe/VHND0AAAAASUVORK5CYII="/></a><ul class="ae-box-lang none animated"><li data-lang="vi" title="Tiếng Việt" class="ae-item-lang"><a href="https://ega-furniture.mysapo.net/?aelang=vi"><img class="ae-icon-left" src="data:image/gif;base64,R0lGODlhEAALANUAAPU8POwAAPQAAP96euUAAPdLS/QsHPk8Pf5dXf52dvZERPvMRPx3SvITE/1STvIuLvhSUvj4NflUVf5xcv1ubvQgIPUlJfENDfdDLfpAQPthYftFRfoAAPYqKv5ZWfn5PPr6QfxqavxmZvpdXfMZGfxLS/tKSfc3NvMzM/1UVOAAAPQfH/cxMfxPT/k6OvlzOvYzK/f3MPrAP/f3L/dgL/Z3KvlYWPYsLPzVS/fSMPg+NPX1JPZOKt0AAP0AAP8AACH5BAAAAAAALAAAAAAQAAsAAAaPwJ/w5yv6OByBUhAI/AbQRGJCCYk0Ixuk4BwgEJ6Ug8HIHE6sG/cJFpdkizOrY1EQfImwA7cAfWQ5MBYVAHcTKS0lDh8fETEYFiskhT4ULSYbGS8RMzWRJA0nBBwhmBkuETQ8O5INDSgqHCKZLjoYdAYGDRcXDyoCWDYSWwoKACcoKA8PPUtNzwTRKio91UEAOw==" alt="ap multilangauge"/><span>Tiếng Việt</span></a></li><li data-lang="us" title="Tiếng Anh" class="ae-item-lang"><a href="https://ega-furniture.mysapo.net/?aelang=us"><img class="ae-icon-left" src="data:image/gif;base64,R0lGODlhEAALANUAAGNjtvr6+vb29fHx8fxGRvkQEP15eatjSuNjSjx6+TV0+f2Kd+np6dvb2PxUVPx4YttjSvsrK5q7/PxlZrpjSvw6Oubm5e7u7sljSgR09Z1jSvT080iB+gBMtkF9+vofHwBpu/f39uLi3/syMtVjSqG+/C9y+Ozs7KLA/GNlwPyBbO3t6gNx5QArs/2XhpGRgKysn+z+/rS0qPR0XuXl/P7KwcnJwf39Wzh3+f7+/fv/+vHx7wNv4df+/f3h3GNnxCH5BAAAAAAALAAAAAAQAAsAAAaMwJ/wl0oBjqoHYgmB/HIoXSkgoQYCoawA9kNxOJ5EAmcyTByEiouUmnoEiYspMxhcTreNrR1OKOYgaBUjEQsYAAEJAwonLCIddwwMFj0yABI4fzwgHS2DER8fCwciAQIbG3aRkxYNPi8qNWZoaRGgBbgqGg0BMVqoqTsrNBYiM0sITU0kGBQUBwca0kEAOw==" alt="ap multilangauge"/><span>Tiếng Anh</span></a></li></ul></div></div></div>';
    var langDefault = "vi";
    var currentLang = "vi";
    var defaultLangAdmin = "vi";
    var position = "0-0-0-2";
    var positionTablet = "";
    var positionSmartphone = "";
    var aeUrlDestination =
        window.location.protocol +
        "//aelang.aecomapp.com/bizweb/aelang/setting";
    var isChangeUrl = "";
    var aeData = { data: [] };

    var productId = "122127259";
    var requireInit = "";
    /*setTimeout(function() {
  if (document.getElementsByClassName("ae-block-language")) {
      document.getElementsByClassName("ae-block-language")[0].remove()
  }
}, 1000);
*/
</script>
<script>
    let elementDesktop = $("#desktop-lang")[0];
    let elementTablet = $("#desktop-lang")[0];
    let elementMobile = $("#desktop-lang")[0];

    function detectHTML(element) {
        var arrTags = [];

        function buildTagsArray(el) {
            if (el && el.tagName !== "BODY") {
                arrTags.push({ tag: ">" + el.tagName, index: $(el).index() });
                buildTagsArray(el.parentElement);
            }
        }

        buildTagsArray(element);

        var selector = "";
        for (var i = arrTags.length - 1; i >= 0; i--) {
            var index = arrTags[i].index;
            selector += selector ? "-" + index : index;
        }

        return selector;
    }
    var position = detectHTML(elementDesktop);
    var positionTablet = detectHTML(elementTablet);
    var positionSmartphone = detectHTML(elementMobile);
   
    </script>
<style>
    .list-group .list-group-item .mega-menu {
        height: 200% !important;
    }

    .navigation {
        --nav-height: 313px;
        min-height: 100%;
        overflow-x: auto; /* Cho phép cuộn ngang */
        display: flex;
        flex-direction: row;
        flex-wrap: wrap; /* Mặc định vẫn wrap */
        max-width: 100%;
        width: 100%;
    }
    
    /* Khi màn hình nhỏ hơn 1024px (tablet & mobile) */
    @media (max-width: 1024px) {
        .navigation {
            flex-wrap: nowrap; /* Không xuống dòng, giữ nguyên hàng ngang */
            overflow-x: auto; /* Vuốt ngang để xem nội dung */
            white-space: nowrap; /* Ngăn các phần tử xuống dòng */
            scrollbar-width: thin; /* Hiển thị thanh cuộn nhỏ */
        }
    
        .navigation > * {
            flex: 0 0 auto; /* Các phần tử con không co giãn */
        }
    }
    
</style>
<!-- Quick View Modal -->
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-views").forEach((button) => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("sp_id"); // Lấy ID sản phẩm từ thuộc tính sp_id
                
                // Gửi yêu cầu AJAX để lấy thông tin sản phẩm
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: "get_product_info",
                        sp_id: productId,
                    },
                    success: function (response) {
                        const product = JSON.parse(response);
                        
                        // Cập nhật nội dung modal
                        document.getElementById('quick_view_content').innerHTML = `
                            <h2>${product.tieu_de}</h2>
                            <img src="${product.minh_hoa}" width="300" alt="${product.tieu_de}">
                            <p>${product.noi_dung}</p>
                            <p><strong>Giá mới:</strong> ${product.gia_moi}₫</p>
                            <p><strong>Giá cũ:</strong> <del>${product.gia_cu}₫</del></p>
                            <p><strong>Kích thước:</strong> ${product.size}</p>
                            <p><strong>Màu sắc:</strong> ${product.mau}</p>
                            <p><strong>Thương hiệu:</strong> ${product.thuong_hieu}</p>
                            <p><strong>Tình trạng:</strong> ${product.tinh_trang}</p>
                        `;
    
                        // Hiển thị modal
                        const modal = document.getElementById("xem_nhanh");
                        modal.style.display = "block";
    
                        // Đóng modal khi nhấp vào nút đóng
                        document.querySelector(".close").onclick = function () {
                            modal.style.display = "none";
                        };
    
                        // Đóng modal khi nhấp ra ngoài modal
                        window.onclick = function (event) {
                            if (event.target == modal) {
                                modal.style.display = "none";
                            }
                        };
                    },
                    error: function () {
                        alert("Lỗi khi tải thông tin sản phẩm.");
                    }
                });
            });
        });
    });
    
</script> -->
