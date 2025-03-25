function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 500));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*500));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookies() {
    var c = document.cookie,
        v = 0,
        cookies = {};
    if (document.cookie.match(/^\s*\$Version=(?:"1"|1);\s*(.*)/)) {
        c = RegExp.$1;
        v = 1;
    }
    if (v === 0) {
        c.split(/[,;]/).map(function(cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function($0, $1) {
            var name = $0,
                value = $1.charAt(0) === '"' ?
                $1.substr(1, -1).replace(/\\(.)/g, "$1") :
                $1;
            cookies[name] = value;
        });
    }
    return cookies;
}

function get_cookie(name) {
    return getCookies()[name];
}

function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}
function scrollSmoothToBottom(id) {
    var div = document.getElementById(id);
    $('#' + id).animate({
        scrollTop: div.scrollHeight - div.clientHeight
    }, 200);
}
function check_link(){
    link=$('.link_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if(info.ok==1){
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                }else{
                    if($('#link_old').length>0){
                        link_old=$('#link_old').val();
                        if(link_old==info.link){
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    }else{
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function check_blank(){
    link=$('.tieude_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if(info.ok==1){
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                }else{
                    if($('#link_old').length>0){
                        link_old=$('#link_old').val();
                        if(link_old==info.link){
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    }else{
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function confirm_del(action,id){
    if(action=='del_chap'){
        title='Xóa chap truyện';
    }else if(action=='del_truyen'){
        title='Xóa truyện';
    }else{
        title='Xóa dữ liệu';
    }
    $('#title_confirm').html(title);
    $('#button_thuchien').attr('action',action);
    $('#button_thuchien').attr('post_id',id);
    $('#box_pop_confirm').show();
}
$(document).ready(function() {
    /////////////////////////////
    setTimeout(function(){
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "get_popup"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    $('.box_popup .content_box').html(info.content);
                    $('.box_popup').fadeIn();
                }
                $('.count_note').html(info.count_note);
            }

        });
        
    },700);
    setTimeout(function(){
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_exp"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==0){
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function(){
                        window.location.href='https://socdo.vn/';
                    },700);
                }
            }

        });
        
    },500);
    $('.box_popup .box_title i').click(function(){
        $('.box_popup').fadeOut();
    });
    $('#trigger-mobile').on('click',function(){
        $('.c-menu--slide-left').toggleClass('active');
    });
    $('#close-nav').on('click',function(){
        $('.c-menu--slide-left').toggleClass('active');
    });
    $('.c-menu--slide-left .fa-plus').on('click',function(e){
        $(this).toggleClass('active')
        $(this).parent().parent().find('.ul-has-child1').toggle();
        e.stopPropagation();
        return false;
    });
    $('.footer-widget h3').on('click',function(){
        $(this).toggleClass('active')
        $(this).parent().find('.list-menu').toggle();
    });
    $('#loc_danhmuc').on('click',function(){
        $(this).toggleClass('active');
        $(this).parent().find('.list-inline').toggle();
    });
    $('#loc_thuonghieu').on('click',function(){
        $(this).toggleClass('active');
        $(this).parent().find('.block_content').toggle();
    });
    $('.faq-title').on('click',function(){
        $(this).parent().toggleClass('active');
    });
    $('.change_avatar').click(function() {
        $('#minh_hoa').click();
    });
    $('#preview-minhhoa').click(function() {
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function() {
        readURL(this, 'preview-minhhoa');
    });
    //////////////////////////
    $('.quickview-close').on('click',function(){
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    //////////////////////////
    $('.btn-continue').on('click',function(){
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    //////////////////////////
    $('#gallery_01 .swiper-slide img').on('click',function(){
        src=$(this).attr('src');
        $('.large_image_url').attr('href',src);
        $('#zoom_01').attr('src',src);

    });
    //////////////////////////
    $('.tbody-popup').on('click','.remove-item-cart',function(){
        id=$(this).data('id');
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'remove_cart',
                sp_id:id,
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.total_cart>0){
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-name').html(info.name);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                }else{
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.content_cart_header .count_item').html('0');

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('click','.btn-plus',function(){
        id=$(this).parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).parent().find('input[name=quantity]').val();
        quantity++;
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_cart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.total_cart>0){
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                }else{
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.content_cart_header .count_item').html('0');

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('click','.btn-minus',function(){
        id=$(this).parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).parent().find('input[name=quantity]').val();
        if(quantity>1){
            quantity--;
        }else{
            quantity=1;
        }
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_cart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.total_cart>0){
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                }else{
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.content_cart_header .count_item').html('0');

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('keyup','input[name=quantity]',function(){
        id=$(this).parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).val();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_cart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.total_cart>0){
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                }else{
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.content_cart_header .count_item').html('0');
                }
            }
        });
    });
    //////////////////////////
    $('.shopping-cart .cart-tbody').on('keyup','input[name=quantity]',function(){
        id=$(this).parent().parent().parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).val();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_shopcart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                $('.cart_page_mobile').html(info.list_shopcart_mobile);
                $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                $('.count_item_pr').html(info.total_cart);
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.totals_price').html(info.tongtien);
                $('.totals_price_mobile').html(info.tongtien);
            }
        });

    });
    //////////////////////////
    $('.shopping-cart .cart-tbody').on('click','.btn-plus',function(){
        id=$(this).parent().parent().parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).parent().find('input[name=quantity]').val();
        quantity++;
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_shopcart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                $('.cart_page_mobile').html(info.list_shopcart_mobile);
                $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                $('.count_item_pr').html(info.total_cart);
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.totals_price').html(info.tongtien);
                $('.totals_price_mobile').html(info.tongtien);
            }
        });

    });
    //////////////////////////
    $('.shopping-cart .cart-tbody').on('click','.btn-minus',function(){
        id=$(this).parent().parent().parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).parent().find('input[name=quantity]').val();
        if(quantity>1){
            quantity--;
        }else{
            quantity=1;
        }
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_shopcart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                $('.cart_page_mobile').html(info.list_shopcart_mobile);
                $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                $('.count_item_pr').html(info.total_cart);
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.totals_price').html(info.tongtien);
                $('.totals_price_mobile').html(info.tongtien);
            }
        });

    });
    //////////////////////////
    $('.shopping-cart .cart-tbody').on('click','.remove-item-cart',function(){
        id=$(this).data('id');
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'remove_shopcart',
                sp_id:id,
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.total_cart>0){
                    $('.cart_page_mobile').html(info.list_shopcart_mobile);
                    $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                    $('.count_item_pr').html(info.total_cart);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.totals_price').html(info.tongtien);
                    $('.totals_price_mobile').html(info.tongtien);
                }else{
                    $('.cart_page_mobile').html('');
                    $('.cart_desktop_page .cart-tbody').html('');
                    $('.count_item_pr').html('0');
                    $('#popup-cart .cart-popup-count').html('0');
                    $('.totals_price').html('0');
                    $('.totals_price_mobile').html('0');
                }
            }
        });
    });
    //////////////////////////
    $('.cart_page_mobile').on('click','.remove-item-cart',function(){
        id=$(this).data('id');
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'remove_shopcart',
                sp_id:id,
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.total_cart>0){
                    $('.cart_page_mobile').html(info.list_shopcart_mobile);
                    $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                    $('.count_item_pr').html(info.total_cart);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.totals_price').html(info.tongtien);
                    $('.totals_price_mobile').html(info.tongtien);
                }else{
                    $('.cart_page_mobile').html('');
                    $('.cart_desktop_page .cart-tbody').html('');
                    $('.count_item_pr').html('0');
                    $('#popup-cart .cart-popup-count').html('0');
                    $('.totals_price').html('0');
                    $('.totals_price_mobile').html('0');
                }
            }
        });
    });
    //////////////////////////
    $('.cart_page_mobile').on('keyup','input[name=quantity]',function(){
        id=$(this).parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).val();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_shopcart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                $('.cart_page_mobile').html(info.list_shopcart_mobile);
                $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                $('.count_item_pr').html(info.total_cart);
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.totals_price').html(info.tongtien);
                $('.totals_price_mobile').html(info.tongtien);
            }
        });

    });
    //////////////////////////
    $('.cart_page_mobile').on('click','.btn-plus',function(){
        id=$(this).parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).parent().find('input[name=quantity]').val();
        quantity++;
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_shopcart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                $('.cart_page_mobile').html(info.list_shopcart_mobile);
                $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                $('.count_item_pr').html(info.total_cart);
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.totals_price').html(info.tongtien);
                $('.totals_price_mobile').html(info.tongtien);
            }
        });

    });
    //////////////////////////
    $('.cart_page_mobile').on('click','.btn-minus',function(){
        id=$(this).parent().parent().find('.remove-item-cart').data('id');
        quantity=$(this).parent().find('input[name=quantity]').val();
        if(quantity>1){
            quantity--;
        }else{
            quantity=1;
        }
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'update_shopcart',
                sp_id:id,
                quantity:quantity
            },
            success: function(kq){
                var info=JSON.parse(kq);
                $('.cart_page_mobile').html(info.list_shopcart_mobile);
                $('.cart_desktop_page .cart-tbody').html(info.list_shopcart);
                $('.count_item_pr').html(info.total_cart);
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.totals_price').html(info.tongtien);
                $('.totals_price_mobile').html(info.tongtien);
            }
        });

    });
    //////////////////////////
    $('#customer_shipping_province').on('change',function(){
        tinh=$(this).val();
        if(tinh!=''){
            $.ajax({
                url:'/process.php',
                type:'post',
                data:{
                    action:'load_huyen',
                    tinh:tinh
                },
                success: function(kq){
                    var info=JSON.parse(kq);
                    $('#customer_shipping_district').html('<option value="">Chọn quận / huyện</option>'+info.list);
                }
            });
        }else{

        }

    });
    //////////////////////////
    $('.order-summary-toggle-text-show').on('click',function(){
        $(this).hide();
        $('.order-summary-toggle-text-hide').show();
        $('.thongtin_donhang .order-summary-section-discount').hide();
        $('.order-summary.thongtin_donhang').removeClass('order-summary-is-collapsed');
        $('.order-summary.thongtin_donhang').addClass('order-summary-is-expanded');
    });
    //////////////////////////
    $('.order-summary-toggle-text-hide').on('click',function(){
        $(this).hide();
        $('.order-summary-toggle-text-show').show();
        $('.order-summary.thongtin_donhang').removeClass('order-summary-is-expanded');
        $('.order-summary.thongtin_donhang').addClass('order-summary-is-collapsed');
    });
    //////////////////////////
    $('#checkout_step_1').on('click',function(){
        ho_ten=$('input[name=ho_ten]').val();
        email=$('input[name=email]').val();
        dien_thoai=$('input[name=dien_thoai]').val();
        dia_chi=$('input[name=dia_chi]').val();
        tinh=$('select[name=tinh]').val();
        huyen=$('select[name=huyen]').val();
        if(ho_ten.length<4){
            $('input[name=ho_ten]').focus();
        }else if(dien_thoai.length<8){
            $('input[name=dien_thoai]').focus();
        }else if(dia_chi.length<10){
            $('input[name=dia_chi]').focus();
        }else if(tinh==''){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn Tỉnh/Thành phố');
            }, 500);
            setTimeout(function(){
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            },700);
        }else if(huyen==''){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn Quận/huyện');
            }, 500);
            setTimeout(function(){
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            },700);
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url:'/process.php',
                type:'post',
                data:{
                    action:'checkout_step_1',
                    ho_ten:ho_ten,
                    email:email,
                    dien_thoai:dien_thoai,
                    dia_chi:dia_chi,
                    tinh:tinh,
                    huyen:huyen
                },
                success: function(kq){
                    var info=JSON.parse(kq);
                    if(info.ok==1){
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function(){
                            window.location.href='/checkout.html?step=2';
                        },700);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function(){
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        },700);

                    }
                }
            });

        }

    });
    //////////////////////////
    $('#checkout_step_2').on('click',function(){
        thanhtoan=$('input[name=payment_method_id]:checked').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'checkout_step_2',
                thanhtoan:thanhtoan
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.ok==1){
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function(){
                        window.location.href='/checkout.html?step=3';
                    },700);
                }else{
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },700);

                }
            }
        });
    });
    //////////////////////////
    $('#button_coupon_desktop').on('click',function(){
        coupon=$('input[name=coupon_desktop]').val();
        if(coupon.length<4){
            $('input[name=coupon_desktop]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url:'/process.php',
                type:'post',
                data:{
                    action:'apply_coupon',
                    coupon:coupon
                },
                success: function(kq){
                    var info=JSON.parse(kq);
                    if(info.ok==1){
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function(){
                            window.location.reload();
                        },700);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function(){
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        },700);

                    }
                }
            });

        }
    });
    //////////////////////////
    $('#button_coupon_mobile').on('click',function(){
        coupon=$('input[name=coupon_mobile]').val();
        if(coupon.length<4){
            $('input[name=coupon_mobile]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url:'/process.php',
                type:'post',
                data:{
                    action:'apply_coupon',
                    coupon:coupon
                },
                success: function(kq){
                    var info=JSON.parse(kq);
                    if(info.ok==1){
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function(){
                            window.location.reload();
                        },700);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function(){
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        },700);

                    }
                }
            });

        }

    });
    //////////////////////////
    $('.tab-content .show-more').on('click',function(){
        $('.product-well').toggleClass('expanded');
    });
    //////////////////////////
    $('.navbar-pills .fa-angle-down').on('click',function(){
        $(this).parent().toggleClass('active');
    });
    /////////////////////////////
    $('.add_muakem_view').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        main_product = $('input[name=main_product]').val();
        list_id = '';
        $('input[name^=sub_id]:checked').each(function() {
            list_id += $(this).val() + ',';
        });
        if (list_id == '') {
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm mua kèm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else {
            list_id = list_id.substring(0, list_id.length - 1);
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'add_muakem',
                    main_product: main_product,
                    list_id: list_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        setTimeout(function() {
                            $('.load_note').html('Hệ thống đang chuyển hướng...');
                        }, 500);
                        setTimeout(function() {
                            window.location.href='/gio-hang.html';
                        }, 2000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    }
                }
            });
        }
    });
    /////////////////////////////
    $('.add_muakem').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        main_product = $('input[name=main_product]').val();
        list_id = '';
        $('input[name^=sub_id]:checked').each(function() {
            list_id += $(this).val() + ',';
        });
        if (list_id == '') {
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm mua kèm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else {
            list_id = list_id.substring(0, list_id.length - 1);
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'add_muakem',
                    main_product: main_product,
                    list_id: list_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        setTimeout(function() {
                            $('.load_note').html('Hệ thống đang chuyển hướng...');
                        }, 500);
                        setTimeout(function() {
                            window.location.href='/gio-hang.html';
                        }, 2000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    }
                }
            });
        }
    });
    /////////////////////////////
    // $('.add_to_cart').on('click',function(){
    //     if(!$(this).hasClass('disabled')){
    //         sp_id=$(this).attr('sp_id');
    //         loai=$(this).attr('loai');
    //         if($('input[name=size]').length>0){
    //             size=$('input[name=size]:checked').val();
    //         }else{
    //             size='';
    //         }
    //         if($('input[name=mau]').length>0){
    //             mau=$('input[name=mau]:checked').val();
    //         }else{
    //             mau='';
    //         }
    //         if($('#quantity_view').length>0){
    //             quantity=$('#quantity_view').val();
    //         }else{
    //             quantity=1;
    //         }
    //         $('.load_overlay').show();
    //         $('.load_process').fadeIn();
    //         $.ajax({
    //             url:'/process.php',
    //             type:'post',
    //             data:{
    //                 action:'add_to_cart',
    //                 sp_id:sp_id,
    //                 loai:loai,
    //                 size:size,
    //                 mau:mau,
    //                 quantity:quantity
    //             },
    //             success: function(kq){
    //                  try {
    //                 var info = JSON.parse(kq);
    //                 setTimeout(function() {
    //                     $('.load_process').hide();
    //                     $('.load_note').html('Hệ thống đang xử lý');
    //                     $('#popup-cart').css('display', 'block');
    //                     $('#popup-cart .tbody-popup').html(info.list);
    //                     $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
    //                     $('#popup-cart .cart-popup-name').html(info.name);
    //                     $('#popup-cart .cart-popup-count').html(info.total_cart);
    //                     $('.count_item_pr').html(info.total);
    //                 }, 500);
    //             } catch (e) {
    //                 console.error('Invalid JSON response:', kq);
    //                 $('.load_process').hide();
    //                 $('.load_note').html('Có lỗi xảy ra, vui lòng thử lại sau.');
    //                 $('.load_overlay').hide();
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('AJAX error:', status, error);
    //             $('.load_process').hide();
    //             $('.load_note').html('Có lỗi xảy ra, vui lòng thử lại sau.');
    //             $('.load_overlay').hide();
    //         }
    //         });
    //         // console.log(total_cart);
    //     }
    // });
    /////////////////////////////
    $('.page_redirect a').on('click',function(){
        page=$(this).attr('page');
        var queryParams = new URLSearchParams(window.location.search);
        queryParams.set("page", page);
        history.replaceState(null, null, "?"+queryParams.toString());
        url=window.location.href;
        window.location.href=url;
    });
    /////////////////////////////
    $('select[name=sort]').on('change',function(){
        var queryParams = new URLSearchParams(window.location.search);
        var sort=$(this).val();
        queryParams.set("sort", sort);
        queryParams.set("page", 1);
        history.replaceState(null, null, "?"+queryParams.toString());
        url=window.location.href;
        window.location.href=url;
/*        if($('input[name=cat_id]').length>0){
            cat_id=$('input[name=cat_id]').val();
        }else{
            cat_id=0;
        }
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'load_product',
                url:url,
                cat_id:cat_id
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.list==null){
                    setTimeout(function() {
                        $('.load_note').html('Không có kết quả phù hợp');
                    }, 500);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },700);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 500);
                }
            }
        });*/
    });
    /////////////////////////////
    $('input[name=color-filter]').click(function(){
        var queryParams = new URLSearchParams(window.location.search);
        var color='';
        var c=0;
        $('input[name=color-filter]:checked').each(function() {
            c++;
            color+=$(this).val()+'*';
        });
        if(c>0){
            color=color.substring(0,color.length - 1);
            queryParams.set("color", color);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }else{
            url=window.location.href;
            url=removeURLParameter(url,'color');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }
        url=window.location.href;
        window.location.href=url;
/*        if($('input[name=cat_id]').length>0){
            cat_id=$('input[name=cat_id]').val();
        }else{
            cat_id=0;
        }
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'load_product',
                url:url,
                cat_id:cat_id
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.list==null){
                    setTimeout(function() {
                        $('.load_note').html('Không có kết quả phù hợp');
                    }, 500);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },700);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 500);
                }
            }
        });*/
    });
    /////////////////////////////
    $('input[name=price-filter]').click(function(){
        var queryParams = new URLSearchParams(window.location.search);
        var price='';
        var p=0;
        $('input[name=price-filter]:checked').each(function() {
            p++;
            price+=$(this).val()+'*';
        });
        if(p>0){
            price=price.substring(0,price.length - 1);
            queryParams.set("price", price);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }else{
            url=window.location.href;
            url=removeURLParameter(url,'price');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }
        url=window.location.href;
        window.location.href=url;
/*        if($('input[name=cat_id]').length>0){
            cat_id=$('input[name=cat_id]').val();
        }else{
            cat_id=0;
        }
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'load_product',
                url:url,
                cat_id:cat_id
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.list==null){
                    setTimeout(function() {
                        $('.load_note').html('Không có kết quả phù hợp');
                    }, 500);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },700);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 500);
                }
            }
        });*/
    });
    /////////////////////////////
    $('input[name=size-filter]').click(function(){
        var queryParams = new URLSearchParams(window.location.search);
        var size='';
        var s=0;
        $('input[name=size-filter]:checked').each(function() {
            s++;
            size+=$(this).val()+'*';
        });
        if(s>0){
            size=size.substring(0,size.length - 1);
            queryParams.set("size", size);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }else{
            url=window.location.href;
            url=removeURLParameter(url,'size');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }
        url=window.location.href;
        window.location.href=url;
/*        if($('input[name=cat_id]').length>0){
            cat_id=$('input[name=cat_id]').val();
        }else{
            cat_id=0;
        }
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'load_product',
                url:url,
                cat_id:cat_id
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.list==null){
                    setTimeout(function() {
                        $('.load_note').html('Không có kết quả phù hợp');
                    }, 500);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },700);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 500);
                }
            }
        });*/
    });
    /////////////////////////////
    $('input[name=brand-filter]').click(function(){
        var queryParams = new URLSearchParams(window.location.search);
        var brand='';
        var b=0;
        $('input[name=brand-filter]:checked').each(function() {
            b++;
            brand+=$(this).val()+'*';
        });
        if(b>0){
            brand=brand.substring(0,brand.length - 1);
            queryParams.set("brand", brand);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
        }else{
            url=window.location.href;
            url=removeURLParameter(url,'brand');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?"+queryParams.toString());
    
        }
        url=window.location.href;
        window.location.href=url;
/*        if($('input[name=cat_id]').length>0){
            cat_id=$('input[name=cat_id]').val();
        }else{
            cat_id=0;
        }
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url:'/process.php',
            type:'post',
            data:{
                action:'load_product',
                url:url,
                cat_id:cat_id
            },
            success: function(kq){
                var info=JSON.parse(kq);
                if(info.list==null){
                    setTimeout(function() {
                        $('.load_note').html('Không có kết quả phù hợp');
                    }, 500);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },700);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 500);
                }
            }
        });*/
    });
    //////////////////////////
    $('button[name=change_avatar]').on('click', function() {
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'change_avatar');
        form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 700);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 700);
            }

        });
    });
    /////////////////////////////
    $('button[name=change_password]').click(function(){
        password = $('input[name=password]').val();
        new_password = $('input[name=new_password]').val();
        confirm_password = $('input[name=confirm_password]').val();
        if (password.length < 6) {
            $('input[name=password]').focus();
        } else if (new_password.length<6) {
            $('input[name=new_password]').focus();
        } else if (new_password !=confirm_password) {
            $('input[name=confirm_password]').focus();
        }else{
            $('.box_pop').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'change_password',
                    password:password,
                    new_password:new_password,
                    confirm_password:confirm_password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if(info.ok==1){
                            window.location.href='/dang-nhap.html';
                        }
                    }, 700);
                }
            });
        }
    });
    /////////////////////////////
    $('#button_thuchien').click(function(){
        id=$('#button_thuchien').attr('post_id');
        action=$('#button_thuchien').attr('action');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: action,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 700);
            }
        });
    });
    //////////////////////
    $('button[name=quen_matkhau]').on('click', function() {
        email = $('input[name=email]').val();
        var form_data = new FormData();
        form_data.append('action', 'forgot_password');
        form_data.append('email', email);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        window.location.href='/dang-nhap.html';
                    }, 700);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 700);
            }

        });
    });
   
    $('button[name=dangky]').on('click', function() {
        // Lấy giá trị các trường input
        var username = $('input[name=username]').val().trim();
        var email = $('input[name=email]').val().trim();
        var password = $('input[name=password]').val();
        var confirm_password = $('input[name=re_password]').val();
        var ho_ten = $('input[name=ho_ten]').val().trim();
        var dien_thoai = $('input[name=dien_thoai]').val().trim();
        var gioi_tinh = $('input[name=gioi_tinh]').val();
        var tinh = $('input[name=tinh]').val();
        var huyen = $('input[name=huyen]').val();
        var xa = $('input[name=xa]').val();
        var maso_thue = $('input[name=maso_thue]').val().trim();
        var maso_thue_cap = $('input[name=maso_thue_cap]').val();
        var maso_thue_noicap = $('input[name=maso_thue_noicap]').val();
        var nhan_vien = $('input[name=nhan_vien]').val();
        var isValid = true;
    
        // Reset tất cả thông báo lỗi
        $('.error-message').hide();
    
        // Kiểm tra tuần tự từng trường
        if (username === '') {
            $('#username-error').text('Vui lòng nhập tên đăng nhập').show();
            $('input[name=username]').focus();
            isValid = false;
        } else if (username.length < 4) {
            $('#username-error').text('Tên đăng nhập phải có ít nhất 4 ký tự').show();
            $('input[name=username]').focus();
            isValid = false;
        } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
            $('#username-error').text('Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới').show();
            $('input[name=username]').focus();
            isValid = false;
        } else if (ho_ten === '') {
            $('#ho_ten-error').text('Vui lòng nhập họ tên').show();
            $('input[name=ho_ten]').focus();
            isValid = false;
        } else if (ho_ten.length < 5) {
            $('#ho_ten-error').text('Họ tên phải có ít nhất 5 ký tự').show();
            $('input[name=ho_ten]').focus();
            isValid = false;
        } else if (dien_thoai === '') {
            $('#dien_thoai-error').text('Vui lòng nhập số điện thoại').show();
            $('input[name=dien_thoai]').focus();
            isValid = false;
        } else if (!/^(0[3|5|7|8|9])+([0-9]{8})\b$/.test(dien_thoai)) {
            $('#dien_thoai-error').text('Số điện thoại không hợp lệ (phải có 10 số và bắt đầu bằng 03, 05, 07, 08, 09)').show();
            $('input[name=dien_thoai]').focus();
            isValid = false;
        } else if (email === '') {
            $('#email-error').text('Vui lòng nhập email').show();
            $('input[name=email]').focus();
            isValid = false;
        } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email)) {
            $('#email-error').text('Email không hợp lệ').show();
            $('input[name=email]').focus();
            isValid = false;
        } else if (password === '') {
            $('#password-error').text('Vui lòng nhập mật khẩu').show();
            $('input[name=password]').focus();
            isValid = false;
        } else if (password.length < 6) {
            $('#password-error').text('Mật khẩu phải có ít nhất 6 ký tự').show();
            $('input[name=password]').focus();
            isValid = false;
        } else if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/.test(password)) {
            $('#password-error').text('Mật khẩu phải chứa cả chữ và số').show();
            $('input[name=password]').focus();
            isValid = false;
        } else if (confirm_password === '') {
            $('#re_password-error').text('Vui lòng nhập lại mật khẩu').show();
            $('input[name=re_password]').focus();
            isValid = false;
        } else if (password !== confirm_password) {
            $('#re_password-error').text('Mật khẩu nhập lại không khớp').show();
            $('input[name=re_password]').focus();
            isValid = false;
        } else if (gioi_tinh === '') {
            $('#gioi_tinh-error').text('Vui lòng chọn giới tính').show();
            $('input[name=gioi_tinh]').focus();
            isValid = false;
        } else if (tinh === '') {
            $('#tinh-error').text('Vui lòng chọn tỉnh/thành phố').show();
            $('input[name=tinh]').focus();
            isValid = false;
        } else if (huyen === '') {
            $('#huyen-error').text('Vui lòng chọn quận/huyện').show();
            $('input[name=huyen]').focus();
            isValid = false;
        } else if (xa === '') {
            $('#xa-error').text('Vui lòng chọn phường/xã').show();
            $('input[name=xa]').focus();
            isValid = false;
        } else if (maso_thue === '') {
            $('#maso_thue-error').text('Vui lòng nhập mã số thuế').show();
            $('input[name=maso_thue]').focus();
            isValid = false;
        } else if (!/^\d{10}(\d{3})?$/.test(maso_thue)) {
            $('#maso_thue-error').text('Mã số thuế không hợp lệ (10 hoặc 13 số)').show();
            $('input[name=maso_thue]').focus();
            isValid = false;
        } else if (maso_thue_cap === '') {
            $('#maso_thue_cap-error').text('Vui lòng nhập ngày/tháng/năm cấp mã số thuế').show();
            $('input[name=maso_thue_cap]').focus();
            isValid = false;
        } else if (maso_thue_noicap === '') {
            $('#maso_thue_noicap-error').text('Vui lòng nhập nơi cấp mã số thuế').show();
            $('input[name=maso_thue_noicap]').focus();
            isValid = false;
        }
    
        if (isValid) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            
            // Gửi form nếu tất cả đều hợp lệ
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "register",
                    username: username,
                    email: email,
                    password: password,
                    re_password: confirm_password,
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    gioi_tinh: gioi_tinh,
                    tinh: tinh,
                    huyen: huyen,
                    xa: xa,
                    maso_thue: maso_thue,
                    maso_thue_cap: maso_thue_cap,
                    maso_thue_noicap: maso_thue_noicap,
                    nhan_vien: nhan_vien
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/dang-nhap.html';
                        }
                    }, 700);
                }
            });
        }
    });
    ////////////////////////
    $('button[name=change_profile]').on('click', function() {
        email = $('input[name=email]').val();
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        ngay_sinh = $('input[name=ngay_sinh]').val();
        dia_chi = $('input[name=dia_chi]').val();
        if (ho_ten.length < 5) {
            $('input[name=ho_ten]').focus();
        }else if (email.length < 4) {
            $('input[name=email]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (ngay_sinh.length < 6) {
            $('input[name=ngay_sinh]').focus();
        } else if (dia_chi.length < 6) {
            $('input[name=dia_chi]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "change_profile",
                    email: email,
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    ngay_sinh:ngay_sinh,
                    dia_chi:dia_chi
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 700);
                }

            });

        }

    });
    ////////////////////////
    $('.button_logout').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process_logout.php",
            type: "post",
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/';
                    } else {

                    }
                }, 700);
            }
        });
    });
    ////////////////////////
    $('button[name=dangky_dropship]').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data:{
                action:'dangky_dropship'
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {

                    }
                }, 700);
            }
        });
    });
    ////////////////////////
    $('button[name=button_subscribe]').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        email =$('input[name=email_subscribe]').val();
        if(email.length<5){
            $('input[name=email_subscribe]').focus();
        }else{
            $.ajax({
                url: "/process.php",
                type: "post",
                data:{
                    action:'dangky_nhantin',
                    email:email
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 700);
                }
            });
        }
    });
    ////////////////////////
    $('button[name=login]').on('click', function() {
        email = $('input[name=email]').val();
        password = $('input[name=password]').val();
        if (email.length < 4) {
            $('input[name=email]').focus();
            $('#email-error').text('Vui lòng nhập email').show();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
            $('#password-error').text('Vui lòng nhập password').show();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process_login.php",
                type: "post",
                data: {
                    email: email,
                    password: password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href='/tai-khoan.html';
                        } else {

                        }
                    }, 700);
                }
            });
        }
    });
    ////////////////////////
    $('button[name=button_lienhe]').on('click', function() {
        ho_ten = $('input[name=ho_ten]').val();
        email = $('input[name=email]').val();
        tieu_de = $('input[name=tieu_de]').val();
        shop = $('input[name=shop]').val();
        noi_dung = $('textarea[name=noi_dung]').val();
        if (ho_ten.length < 4) {
            $('input[name=ho_ten]').focus();
        } else if (email.length < 6) {
            $('input[name=email]').focus();
        } else if (tieu_de.length < 6) {
            $('input[name=tieu_de]').focus();
        } else if (noi_dung.length < 6) {
            $('textarea[name=noi_dung]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action:'lienhe',
                    ho_ten:ho_ten,
                    email: email,
                    tieu_de:tieu_de,
                    shop:shop,
                    noi_dung:noi_dung
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 700);
                }
            });
        }
    });
    ///////////////////////
    // $('input[name=input_search]').on('keyup', function () {
    //     let key = $(this).val().trim();
    //     if (key.length < 2) {
    //         $('#dropdown').addClass('hidden');
    //         $('#search_results').html('');
    //     } else {
    //         $('#dropdown').removeClass('hidden');
    //         $('#search_results').html('<center><img src="/images/loading.gif" alt="Loading..."></center>');
    //         $.ajax({
    //             url: '/process.php',
    //             type: 'post',
    //             data: {
    //                 action: 'search_products',
    //                 query: key
    //             },
    //             success: function (response) {
    //                 const data = JSON.parse(response);
    //                 if (data.ok) {
    //                     let html = '';
    //                     data.products.forEach(product => {
    //                         html += `
    //                             <a class="dropdown-item" href="${product.link}">
    //                                 <img src="${product.image}" alt="${product.title}" />
    //                                 <div>
    //                                     <h4>${product.title}</h4>
    //                                     <p>${product.price}</p>
    //                                 </div>
    //                             </a>`;
    //                     });
    //                     $('#search_results').html(html);
    //                 } else {
    //                     $('#search_results').html('<center>Không tìm thấy kết quả</center>');
    //                 }
    //             },
    //             error: function () {
    //                 $('#search_results').html('<center>Lỗi xử lý, vui lòng thử lại</center>');
    //             }
    //         });
    //     }
    // });
    
    ////////////////////////
    $('input[name=input_search]').on('keyup', function() {
        search_name = $(this).val();
        if (search_name.length < 2) {
            $('.kq_search').hide();
        } else {
            $('.kq_search').show();
            $('.kq_search').html('<center><img src="/images/loading.gif"></center>');
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'goi_y',
                    search_name: search_name
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.kq_search').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    $('input[name=key_search]').keypress(function(e) {
        if (e.which == 13) {
            search_name = $('input[name=key_search]').val();
            //link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            if (search_name.length < 2) {
                $('input[name=key_search]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action:'timkiem',
                        key_search:search_name
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                window.location.href=info.link;
                            } else {

                            }
                        }, 700);
                    }
                });
                
            }
            return false;
        }
    });
    ////////////////
    // $('input[name=input_search]').on('keyup', function () {
    //     let key = $(this).val();
    //     if (key.length < 2) {
    //         $('.kq_search').hide();
    //     } else {
    //         $('.kq_search').show();
    //         $('.kq_search').html('<center><img src="/images/loading.gif"></center>');
    //         $.ajax({
    //             url: '/process.php',
    //             type: 'post',
    //             data: {
    //                 action: 'goi_y',
    //                 key: key
    //             },
    //             success: function (response) {
    //                 const data = JSON.parse(response);
    //                 if (data.ok) {
    //                     let html = '';
    //                     data.products.forEach(product => {
    //                         html += `
    //                             <a class="ega-sm-item tw-no-underline tw-leading-4 tw-px-2.5 tw-py-2 tw-flex tw-border-x-0 tw-border-t-0 tw-border-b-slate-200 tw-border-solid tw-border-b tw-space-x-2.5" href="${product.link}">
    //                                 <div class="tw-flex-[0_0_70px]">
    //                                     <img class="tw-max-w-full" src="${product.image}" alt="${product.title}">
    //                                 </div>
    //                                 <div class="tw-flex-1">
    //                                     <h4 class="ega-sm-item-title tw-text-base tw-mb-0">${product.title}</h4>
    //                                     <div class="tw-mt-1.5">
    //                                         <ins class="ega-sm-item-price tw-text-base tw-no-underline tw-inline-block tw-mr-1.5 tw-font-medium tw-leading-none">${product.new_price}</ins>
    //                                         ${product.old_price ? `<del class="ega-sm-item-compare-price tw-text-sm tw-inline-block tw-leading-none">${product.old_price}</del>` : ''}
    //                                     </div>
    //                                 </div>
    //                             </a>`;
    //                     });
    //                     $('.kq_search').html(html);
    //                 } else {
    //                     $('.kq_search').html('<center>Không có kết quả phù hợp</center>');
    //                 }
    //             }
    //         });
    //     }
    // });
    // document.getElementById('searchInput').addEventListener('input', function() {
    //     const inputValue = this.value;
    
    //     fetch('process.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/x-www-form-urlencoded',
    //         },
    //         body: `key=${encodeURIComponent(inputValue)}`,
    //     })
    //         .then(response => response.text())
    //         .then(data => {
    //             console.log('Response from process.php:', data);
    //         })
    //         .catch(error => console.error('Error:', error));
    // });
    
    $('input[name=input_search]').on('keyup', function () {
        let search_name = $(this).val().trim();
        if (search_name.length < 2) {
            $('#dropdown').addClass('hidden');
            $('#search_results').html('');
        } else {
            $('#dropdown').removeClass('hidden');
            $('#search_results').html('<center><img src="/images/loading.gif" alt="Loading..."></center>');
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'goi_y',
                    search_name: search_name
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.ok) {
                        let html = '';
                        data.products.forEach(product => {
                            html += `
                                <a class="dropdown-item d-flex align-items-center" href="${product.link}">
                                    <img src="${product.image}" alt="${product.title}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    <div>
                                        <h6 class="mb-1">${product.title}</h6>
                                        <span style="font-size: 14px; color: #28a745;">${product.new_price}</span>
                                        ${product.old_price ? `<span style="font-size: 12px; text-decoration: line-through; color: #999;">${product.old_price}</span>` : ''}
                                    </div>
                                </a>`;
                        });
                        $('#search_results').html(html);
                    } else {
                        $('#search_results').html('<center>Không tìm thấy kết quả phù hợp</center>');
                    }
                },
                error: function () {
                    $('#search_results').html('<center>Lỗi xử lý, vui lòng thử lại</center>');
                }
            });
        }
    });
    
    
    /////////////////////////////
    $('.button_search').click(function(e) {
        search_name = $('input[name=key_search]').val();
        //link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
        if (search_name.length < 2) {
            $('input[name=key_search]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action:'timkiem',
                    key_search:search_name
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href=info.link;
                        } else {

                        }
                    }, 700);
                }
            });
            
        }
        return false;
    });
    $('.show_menu').click(function() {
        $('.menu_list').toggle();
    });
    /////////////////////
    $('.box_logo_mobile i').click(function() {
        $('.box_logo_mobile').toggle();
        $('.box_menu').toggle();
        $('.li_main i').addClass('fa-angle-down');
        $('.li_main i').removeClass('fa-angle-up');
        $('.sub_menu').hide();
    });
    /////////////////////
    $('.li_main i').click(function() {
        $(this).parent().find('.sub_menu').toggle();
        if ($(this).hasClass('fa-angle-down')) {
            $(this).removeClass('fa-angle-down');
            $(this).addClass('fa-angle-up');
        } else {
            $(this).addClass('fa-angle-down');
            $(this).removeClass('fa-angle-up');
        }

    });
    ////////////////////////
    $("body").keydown(function(e) {
        if ($('.content_view_chap').length > 0) {
            if (e.keyCode == 37) {
                if ($('.link-prev-chap').length > 0) {
                    link = $('.link-prev-chap').attr('href');
                    window.location.href = link;

                }
            } else if (e.keyCode == 39) {
                if ($('.link-next-chap').length > 0) {
                    link = $('.link-next-chap').attr('href');
                    window.location.href = link;
                }
            }
        } else {

        }
    });
});