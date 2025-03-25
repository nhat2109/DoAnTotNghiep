function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
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

function check_link() {
    link = $('.link_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
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
                if (info.ok == 1) {
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                } else {
                    if ($('#link_old').length > 0) {
                        link_old = $('#link_old').val();
                        if (link_old == info.link) {
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    } else {
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}

function check_blank() {
    link = $('.tieude_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
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
                if (info.ok == 1) {
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                } else {
                    if ($('#link_old').length > 0) {
                        link_old = $('#link_old').val();
                        if (link_old == info.link) {
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    } else {
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}

function confirm_del(action, id) {
    if (action == 'del_chap') {
        title = 'Xóa chap truyện';
    } else if (action == 'del_truyen') {
        title = 'Xóa truyện';
    } else {
        title = 'Xóa dữ liệu';
    }
    $('#title_confirm').html(title);
    $('#button_thuchien').attr('action', action);
    $('#button_thuchien').attr('post_id', id);
    $('#box_pop_confirm').show();
}
$(document).ready(function() {
/*    $(window).scroll(function() {
        if($(window).scrollTop()>=168) {
            setTimeout(function(){
                $('header').css('position','fixed');
            },100);
        }else{
            setTimeout(function(){
                $('header').css('position','relative');
            },100);  
        }
    });*/
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
            }

        });
        
    },3000);
    if($('.list_skin').length>0){
        total_giaodien=$('.list_tab_skin .li_tab.active').attr('total');
        end_giaodien=$('.list_tab_skin .li_tab.active').attr('end');
        if(total_giaodien>end_giaodien){
            $('.load_skin').show();
        }
    }
    $('.list_video_skin .small_video .box-video').on('click',function(){
        id_video=$(this).attr('video');
        tieu_de=$(this).find('h4 a').html();
        $('.list_video_skin .big_video .box-video').find('h4 a').html(tieu_de);
        $('.list_video_skin .big_video .box-video .thumbnail').html('<iframe width="560" height="315" src="https://www.youtube.com/embed/'+id_video+'?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    });
    $(".list_skin").on('mouseenter', '.product-image', function() {
        $(this).find('.add-to-cart a').fadeIn();
    });
    $(".list_skin").on('mouseleave', '.product-image', function() {
        $(this).find('.add-to-cart a').fadeOut();
    });
    $('.box_popup .box_title i').click(function(){
        $('.box_popup').fadeOut();
    });
    $('.show_nnc').click(function(){
        $('.box_nnc').fadeIn();
    });
    $('.box_nnc .box_title i').click(function(){
        $('.box_nnc').fadeOut();
    });
    $('.load_overlay').on('click', function() {
        if ($('#mobile-menu').hasClass('active')) {
            $('#mobile-menu').removeClass('active');
            $('.load_overlay').hide();
        }
        if ($('.mobile-filters').hasClass('active')) {
            $('.mobile-filters').removeClass('active');
            $('.load_overlay').hide();
            $('body').css('overflow-y', 'auto');
        }
    });
    $('.list_box_tab_banhang .tab').on('click', function() {
        $('.list_box_tab_banhang .tab').removeClass('active');
        $(this).addClass('active');
        id = $(this).attr('id');
        $('.content_tab').removeClass('active');
        if (id == 'tab_reg_drop') {
            $('#content_tab_drop').addClass('active');
        } else {
            $('#content_tab_ctv').addClass('active');
        }
    });
    $('.main-header-mobile .button_menu').on('click', function() {
        $('#mobile-menu').addClass('active');
        $('.load_overlay').show();
    });
    $('.menu-item .fa-chevron-right').click(function(e) {
        $(this).parent().parent().addClass('active');
        e.stopPropagation();
        return false;
    });
    $('#open-filters').click(function() {
        $('.load_overlay').show();
        $('.mobile-filters').addClass('active');
        $('body').css('overflow-y', 'hidden');
    });
    $('.button-filters').click(function() {
        $('.mobile-filters').removeClass('active');
        $('.load_overlay').hide();
        $('body').css('overflow-y', 'auto');
    });
    $('.toggle-submenu').click(function(e) {
        $(this).parent().parent().removeClass('active');
    });
    $('.footer-click .title-menu').on('click', function() {
        $(this).parent().find('.list-menu').toggle();
    });
    $('.faq-title').on('click', function() {
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
    $('.load_product_sub').on('click', function() {
        cat_id = $(this).attr('cat_id');
        element = $(this);
        if (element.hasClass('current')) {

        } else {
            $(this).parent().find('li').removeClass('current');
            $(this).addClass('current');
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'load_product_sub',
                    cat_id: cat_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        element.parent().parent().parent().find('.tab').html(info.list);
                    } else {
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);
                    }
                }
            });
        }
    });
    //////////////////////////
    $('body').on('click', '.quickview-close', function() {
        $('.load_overlay').hide();
        $('.modal').hide();
        $('.box_quickview').hide();
    });
    //////////////////////////
    $('.type_register button').on('click',function(){
        $('.type_register button').removeClass('active');
        $(this).addClass('active');
    });
    //////////////////////////
    $('body').on('click', '.btn-continue', function() {
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    //////////////////////////
    $('body').on('click', '.xem_nhanh', function() {
        id = $(this).attr('sp_id');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_quickview',
                sp_id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.q_add_to_cart').attr('sp_id', id);
                    $('.box_quickview').show();
                    $('.box_quickview h2').html(info.tieu_de);
                    $('.box_quickview .group_status').html(info.group_status);
                    $('.box_quickview .price').html(info.gia_moi);
                    $('.box_quickview .old_price').html(info.gia_cu);
                    $('.box_quickview .kq_mau').html(info.list_mau);
                    $('.box_quickview .kq_size').html(info.list_size);
                    //$('.quickview_big .swiper-wrapper').html(info.list_anh);
                    //$('.quickview_small .swiper-wrapper').html(info.list_anh);
                    quickview_Thumbs.removeAllSlides();
                    quickview_Top.removeAllSlides();
                    quickview_Top.addSlide(1, info.list_anh);
                    quickview_Thumbs.addSlide(1, info.list_anh);
                    quickview_Top.update(true);
                    quickview_Thumbs.update(true);
                } else {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }
            }
        });
    });
    //////////////////////////
    $('.list_shopcart').on('click', '.button_plus', function() {
        id = $(this).attr('sp_id');
        quantity = $(this).parent().find('input').val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $(this).parent().find('input').val('1');
            quantity = 1;
        } else {
            quantity++;
            $(this).parent().find('input').val(quantity);
        }
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'update_shopcart',
                sp_id: id,
                quantity: quantity
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_shopcart_mobile').html(info.list_shopcart_mobile);
                $('.list_shopcart').html(info.list_shopcart);
                $('.control-cart .count_item').html(info.total_cart);
                $('.count_shopcart').html('(' + info.total_cart + ' sản phẩm)');
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.total_price').html(info.tongtien);
                $('.tamtinh').html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            }
        });
    });
    //////////////////////////
    $('.list_shopcart ').on('click', '.button_minus', function() {
        id = $(this).attr('sp_id');
        quantity = $(this).parent().find('input').val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $(this).parent().find('input').val('1');
            quantity = 1;
        } else {
            if (quantity <= 1) {
                $(this).parent().find('input').val('1');
                quantity = 1;
            } else {
                quantity--;
                $(this).parent().find('input').val(quantity);
            }
        }
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'update_shopcart',
                sp_id: id,
                quantity: quantity
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_shopcart_mobile').html(info.list_shopcart_mobile);
                $('.list_shopcart').html(info.list_shopcart);
                $('.control-cart .count_item').html(info.total_cart);
                $('.count_shopcart').html('(' + info.total_cart + ' sản phẩm)');
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.total_price').html(info.tongtien);
                $('.tamtinh').html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            }
        });
    });
    //////////////////////////
    $('.list_shopcart ').on('keyup', 'input[name=quantity]', function() {
        id = $(this).attr('sp_id');
        quantity = $(this).val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $(this).val('1');
            quantity = 1;
        } else {
            if (quantity <= 1) {
                $(this).val('1');
                quantity = 1;
            } else {}
        }
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'update_shopcart',
                sp_id: id,
                quantity: quantity
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_shopcart_mobile').html(info.list_shopcart_mobile);
                $('.list_shopcart').html(info.list_shopcart);
                $('.control-cart .count_item').html(info.total_cart);
                $('.count_shopcart').html('(' + info.total_cart + ' sản phẩm)');
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.total_price').html(info.tongtien);
                $('.tamtinh').html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            }
        });
    });
    //////////////////////////
    $('.list_shopcart ').on('click', '.remove_cart', function() {
        id = $(this).attr('sp_id');
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'remove_shopcart',
                sp_id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $(this).parent().parent().remove();
                $('.list_shopcart_mobile').html(info.list_shopcart_mobile);
                $('.list_shopcart').html(info.list_shopcart);
                $('.control-cart .count_item').html(info.total_cart);
                $('.count_shopcart').html('(' + info.total_cart + ' sản phẩm)');
                $('#popup-cart .cart-popup-count').html(info.total_cart);
                $('.total_price').html(info.tongtien);
                $('.tamtinh').html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('click', '.remove-item-cart', function() {
        id = $(this).data('id');
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'remove_cart',
                sp_id: id,
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-name').html(info.name);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                    $('.control-cart .count_item').html(info.total_cart);
                } else {
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.content_cart_header .count_item').html('0');
                    $('.control-cart .count_item').html('0');

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('click', '.btn-plus', function() {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).parent().find('input[name=quantity]').val();
        quantity++;
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'update_cart',
                sp_id: id,
                quantity: quantity
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                } else {
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
    $('.tbody-popup').on('click', '.btn-minus', function() {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).parent().find('input[name=quantity]').val();
        if (quantity > 1) {
            quantity--;
        } else {
            quantity = 1;
        }
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'update_cart',
                sp_id: id,
                quantity: quantity
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                } else {
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
    $('.tbody-popup').on('keyup', 'input[name=quantity]', function() {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'update_cart',
                sp_id: id,
                quantity: quantity
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.content_cart_header .count_item').html(info.total);
                } else {
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
    /////////////////////////////
    $('.q_add_to_cart').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
            if ($('input[name=q_size]').length > 0) {
                size = $('input[name=q_size]:checked').val();
            } else {
                size = '';
            }
            if ($('input[name=q_mau]').length > 0) {
                mau = $('input[name=q_mau]:checked').val();
            } else {
                mau = '';
            }
            if ($('#q_view').length > 0) {
                quantity = $('#q_view').val();
            } else {
                quantity = 1;
            }
            $('.box_quickview').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'add_to_cart',
                    sp_id: sp_id,
                    size: size,
                    mau: mau,
                    quantity: quantity
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('#popup-cart').css('display', 'block');
                        $('#popup-cart .tbody-popup').html(info.list);
                        $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                        $('#popup-cart .cart-popup-name').html(info.name);
                        $('#popup-cart .cart-popup-count').html(info.total_cart);
                        $('.control-cart .count_item').html(info.total);
                    }, 1000);
                }
            });
        }
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
    $('.add_to_cart').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
            loai = $(this).attr('loai');
            if ($('input[name=size]').length > 0) {
                size = $('input[name=size]:checked').val();
            } else {
                size = '';
            }
            if ($('input[name=mau]').length > 0) {
                mau = $('input[name=mau]:checked').val();
            } else {
                mau = '';
            }
            if ($('#quantity_view').length > 0) {
                quantity = $('#quantity_view').val();
            } else {
                quantity = 1;
            }
            if ($('input[name=flash_sale]').length > 0) {
                flash_sale = $('input[name=flash_sale]').val();
            } else {
                flash_sale = '0';
            }
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'add_to_cart',
                    sp_id: sp_id,
                    loai:loai,
                    size: size,
                    mau: mau,
                    quantity: quantity,
                    flash_sale:flash_sale,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('#popup-cart').css('display', 'block');
                        $('#popup-cart .tbody-popup').html(info.list);
                        $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                        $('#popup-cart .cart-popup-name').html(info.name);
                        $('#popup-cart .cart-popup-count').html(info.total_cart);
                        $('.control-cart .count_item').html(info.total);
                    }, 1000);
                }
            });
        }
    });
    //////////////////////////
    $('#checkout_step_1').on('click', function() {
        ho_ten = $('input[name=ho_ten]').val();
        email = $('input[name=email]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        dia_chi = $('input[name=dia_chi]').val();
        tinh = $('select[name=tinh]').val();
        huyen = $('select[name=huyen]').val();
        if (ho_ten.length < 4) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 10) {
            $('input[name=dia_chi]').focus();
        } else if (tinh == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn Tỉnh/Thành phố');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else if (huyen == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn Quận/huyện');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'checkout_step_1',
                    ho_ten: ho_ten,
                    email: email,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh: tinh,
                    huyen: huyen
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            window.location.href = '/checkout.html?step=2';
                        }, 3000);
                    } else {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);

                    }
                }
            });

        }

    });
    //////////////////////////
    $('#checkout_step_2').on('click', function() {
        thanhtoan = $('input[name=payment_method_id]:checked').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'checkout_step_2',
                thanhtoan: thanhtoan
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        window.location.href = '/checkout.html?step=3';
                    }, 3000);
                } else {
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);

                }
            }
        });
    });
    //////////////////////////
    $('#button_coupon_desktop').on('click', function() {
        coupon = $('input[name=coupon_desktop]').val();
        if (coupon.length < 4) {
            $('input[name=coupon_desktop]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'apply_coupon',
                    coupon: coupon
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } else {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);

                    }
                }
            });

        }
    });
    //////////////////////////
    $('#button_coupon_mobile').on('click', function() {
        coupon = $('input[name=coupon_mobile]').val();
        if (coupon.length < 4) {
            $('input[name=coupon_mobile]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'apply_coupon',
                    coupon: coupon
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } else {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);

                    }
                }
            });

        }

    });
    //////////////////////////
    $('#customer_shipping_province').on('change', function() {
        tinh = $(this).val();
        if (tinh != '') {
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'load_huyen',
                    tinh: tinh
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('#customer_shipping_district').html('<option value="">Chọn quận / huyện</option>' + info.list);
                }
            });
        } else {

        }

    });
    //////////////////////////
    $('.custom-btn-number .button_minus').on('click', function() {
        quantity = $('.custom-btn-number input[name=quantity]').val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $('.custom-btn-number input[name=quantity]').val('1');
        } else {
            if (quantity < 2) {
                $('.custom-btn-number input[name=quantity]').val('1');
            } else {
                quantity--;
                $('.custom-btn-number input[name=quantity]').val(quantity);
            }
        }
    });
    //////////////////////////
    $('.custom-btn-number .button_plus').on('click', function() {
        quantity = $('.custom-btn-number input[name=quantity]').val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $('.custom-btn-number input[name=quantity]').val('1');
        } else {
            quantity++;
            $('.custom-btn-number input[name=quantity]').val(quantity);
        }
    });
    //////////////////////////
    $('.list_where input').on('click', function() {
        if ($(this).parent().find('.select_color').length > 0) {
            if ($(this).parent().find('.fa-check').length > 0) {
                $(this).parent().find('.fa-check').remove();
            } else {
                $(this).parent().find('.select_color').html('<i class="fa fa-check"></i>');
            }

        } else if ($(this).parent().parent().hasClass('select_size')) {
            $(this).parent().parent().toggleClass('active');
        } else {
            if ($(this).parent().find('.fa-square-o').length > 0) {
                $(this).parent().find('.fa-square-o').remove();
                $(this).parent().prepend('<i class="fa fa-check-square"></i>');
            } else {
                $(this).parent().find('.fa').remove();
                $(this).parent().prepend('<i class="fa fa-square-o"></i>');
            }
        }
    });

    /////////////////////////////
    $('.page_redirect a').on('click', function() {
        page = $(this).attr('page');
        var queryParams = new URLSearchParams(window.location.search);
        queryParams.set("page", page);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        window.location.href = url;
    });
    /////////////////////////////
    $('.content_ul li').on('click', function() {
        var queryParams = new URLSearchParams(window.location.search);
        var sort = $(this).attr('id');
        queryParams.set("sort", sort);
        queryParams.set("page", 1);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        window.location.href = url;
    });
    /////////////////////////////
    $('.box_left input[name=color-filter]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var color = '';
        var c = 0;
        $('.box_left input[name=color-filter]:checked').each(function() {
            c++;
            color += $(this).val() + '*';
        });
        if (c > 0) {
            color = color.substring(0, color.length - 1);
            queryParams.set("color", color);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'color');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        }
        url = window.location.href;
        window.location.href = url;
    });
    /////////////////////////////
    $('.box_left input[name=price-filter]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var price = '';
        var p = 0;
        $('.box_left input[name=price-filter]:checked').each(function() {
            p++;
            price += $(this).val() + '*';
        });
        if (p > 0) {
            price = price.substring(0, price.length - 1);
            queryParams.set("price", price);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'price');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        }
        url = window.location.href;
        window.location.href = url;
    });
    /////////////////////////////
    $('.box_left input[name=size-filter]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var size = '';
        var s = 0;
        $('.box_left input[name=size-filter]:checked').each(function() {
            s++;
            size += $(this).val() + '*';
        });
        if (s > 0) {
            size = size.substring(0, size.length - 1);
            queryParams.set("size", size);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'size');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        }
        url = window.location.href;
        window.location.href = url;
    });
    /////////////////////////////
    $('.box_left input[name=brand-filter]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var brand = '';
        var b = 0;
        $('.box_left input[name=brand-filter]:checked').each(function() {
            b++;
            brand += $(this).val() + '*';
        });
        if (b > 0) {
            brand = brand.substring(0, brand.length - 1);
            queryParams.set("brand", brand);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'brand');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());

        }
        url = window.location.href;
        window.location.href = url;
    });
    $('input[name=color-filter-mobile]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var color = '';
        var c = 0;
        $('input[name=color-filter-mobile]:checked').each(function() {
            c++;
            color += $(this).val() + '*';
        });
        if (c > 0) {
            color = color.substring(0, color.length - 1);
            queryParams.set("color", color);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'color');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        }
        url = window.location.href;
        if ($('input[name=cat_id]').length > 0) {
            cat_id = $('input[name=cat_id]').val();
        } else {
            cat_id = 0;
        }
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'load_product',
                url: url,
                cat_id: cat_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.list_tintuc .tab').html(info.list);
                }
            }
        });
    });
    /////////////////////////////
    $('input[name=price-filter-mobile]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var price = '';
        var p = 0;
        $('input[name=price-filter-mobile]:checked').each(function() {
            p++;
            price += $(this).val() + '*';
        });
        if (p > 0) {
            price = price.substring(0, price.length - 1);
            queryParams.set("price", price);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'price');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        }
        url = window.location.href;
        if ($('input[name=cat_id]').length > 0) {
            cat_id = $('input[name=cat_id]').val();
        } else {
            cat_id = 0;
        }
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'load_product',
                url: url,
                cat_id: cat_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.list_tintuc .tab').html(info.list);
                }
            }
        });
    });
    /////////////////////////////
    $('input[name=size-filter-mobile]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var size = '';
        var s = 0;
        $('input[name=size-filter-mobile]:checked').each(function() {
            s++;
            size += $(this).val() + '*';
        });
        if (s > 0) {
            size = size.substring(0, size.length - 1);
            queryParams.set("size", size);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'size');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        }
        url = window.location.href;
        if ($('input[name=cat_id]').length > 0) {
            cat_id = $('input[name=cat_id]').val();
        } else {
            cat_id = 0;
        }
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'load_product',
                url: url,
                cat_id: cat_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.list_tintuc .tab').html(info.list);
                }
            }
        });
    });
    /////////////////////////////
    $('input[name=brand-filter-mobile]').click(function() {
        var queryParams = new URLSearchParams(window.location.search);
        var brand = '';
        var b = 0;
        $('input[name=brand-filter-mobile]:checked').each(function() {
            b++;
            brand += $(this).val() + '*';
        });
        if (b > 0) {
            brand = brand.substring(0, brand.length - 1);
            queryParams.set("brand", brand);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());
        } else {
            url = window.location.href;
            url = removeURLParameter(url, 'brand');
            window.history.pushState('', '', url);
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("page", 1);
            history.replaceState(null, null, "?" + queryParams.toString());

        }
        url = window.location.href;
        if ($('input[name=cat_id]').length > 0) {
            cat_id = $('input[name=cat_id]').val();
        } else {
            cat_id = 0;
        }
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'load_product',
                url: url,
                cat_id: cat_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.list_tintuc .tab').html(info.list);
                }
            }
        });
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
                    }, 3000);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=change_password]').click(function() {
        password = $('input[name=password]').val();
        new_password = $('input[name=new_password]').val();
        confirm_password = $('input[name=confirm_password]').val();
        if (password.length < 6) {
            $('input[name=password]').focus();
        } else if (new_password.length < 6) {
            $('input[name=new_password]').focus();
        } else if (new_password != confirm_password) {
            $('input[name=confirm_password]').focus();
        } else {
            $('.box_pop').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'change_password',
                    password: password,
                    new_password: new_password,
                    confirm_password: confirm_password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/dang-nhap.html';
                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('#button_thuchien').click(function() {
        id = $('#button_thuchien').attr('post_id');
        action = $('#button_thuchien').attr('action');
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
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
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
                        window.location.href = '/dang-nhap.html';
                    }, 3000);
                } else {

                }
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }

        });
    });
    ////////////////////////
    $('button[name=dangky]').on('click', function() {
        username = $('input[name=username]').val();
        email = $('input[name=email]').val();
        password = $('input[name=password]').val();
        confirm_password = $('input[name=re_password]').val();
        ho_ten = $('input[name=ho_ten]').val();
        captcha = $('input[name=captcha]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (ho_ten.length < 5) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (email.length < 4) {
            $('input[name=email]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else if (password != confirm_password) {
            $('input[name=re_password]').focus();
        } else if (captcha.length < 6) {
            $('input[name=captcha]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
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
                    captcha:captcha,
                    dien_thoai: dien_thoai
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/dang-nhap.html';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    ////////////////////////
    $('button[name=dangky_nnc]').on('click', function() {
        ho_ten = $('.box_nnc input[name=ho_ten]').val();
        dien_thoai = $('.box_nnc input[name=dien_thoai]').val();
        dia_chi = $('.box_nnc input[name=dia_chi]').val();
        email = $('.box_nnc input[name=email]').val();
        cong_ty = $('.box_nnc input[name=cong_ty]').val();
        nganh_hang = $('.box_nnc textarea[name=nganh_hang]').val();
        ghi_chu = $('.box_nnc textarea[name=ghi_chu]').val();
        if (ho_ten.length < 2) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 8) {
            $('input[name=dia_chi]').focus();
        } else if (email.length < 4) {
            $('input[name=email]').focus();
        } else if (cong_ty.length < 4) {
            $('input[name=cong_ty]').focus();
        } else if (nganh_hang.length < 4) {
            $('textarea[name=nganh_hang').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "dangky_nnc",
                    ho_ten: ho_ten,
                    email: email,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    cong_ty: cong_ty,
                    nganh_hang:nganh_hang,
                    ghi_chu: ghi_chu
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    ////////////////////////
    $('.dk_website').on('click',function(){
        email=$('#email_website').val();
        if(email!=''){
            window.location.href='/dangky-banhang.html?email='+email;
        }else{
            window.location.href='/dangky-banhang.html';
        }
    });
    ////////////////////////
    $('.dk_web').on('click',function(){
        email=$('#email_web').val();
        if(email!=''){
            window.location.href='/dangky-banhang.html?email='+email;
        }else{
            window.location.href='/dangky-banhang.html';
        }
    });
    ////////////////////////
    $('.list_tab_skin .li_tab').on('click',function(){
        $('.list_tab_skin .li_tab').removeClass('active');
        $(this).addClass('active');
        loai=$(this).attr('loai');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_skin",
                loai: loai,
                page:1
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_skin').html(info.list);
                $('.list_skin').attr('page',info.page);
                if(info.total_giaodien>info.end){
                    $('.load_skin').show();
                }else{
                    $('.load_skin').hide();
                }
            }

        });

    });
    ////////////////////////
    $('.load_skin span').on('click',function(){
        page=$('.list_skin').attr('page');
        loai=$('.list_tab_skin .li_tab.active').attr('loai');
        $('.load_skin span').html('Đang tải...');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_skin",
                loai: loai,
                page:page
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_skin').append(info.list);
                $('.list_skin').attr('page',info.page);
                $('.load_skin span').html('xem thêm');
                if(info.total_giaodien>info.end){
                    $('.load_skin').show();
                }else{
                    $('.load_skin').hide();
                }
            }

        });

    });
    ////////////////////////
    $('button[name=dangky_banhang]').on('click', function() {
        username = $('input[name=username]').val();
        email = $('input[name=email]').val();
        about = $('textarea[name=about]').val();
        password = $('input[name=password]').val();
        confirm_password = $('input[name=re_password]').val();
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        captcha = $('input[name=captcha]').val();
        loai=$('.button_type.active').attr('loai');
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (ho_ten.length < 5) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (email.length < 4) {
            $('input[name=email]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else if (password != confirm_password) {
            $('input[name=re_password]').focus();
        } else if (captcha.length < 6) {
            $('input[name=captcha]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "register_banhang",
                    username: username,
                    email: email,
                    password: password,
                    re_password: confirm_password,
                    about:about,
                    loai:loai,
                    ho_ten: ho_ten,
                    captcha:captcha,
                    dien_thoai: dien_thoai
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/dang-nhap.html';
                        } else {

                        }
                    }, 3000);
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
        } else if (email.length < 4) {
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
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    ngay_sinh: ngay_sinh,
                    dia_chi: dia_chi
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    ////////////////////////
    $('button[name=dangky_email]').on('click', function() {
        co_quan = $('input[name=co_quan]').val();
        don_vi = $('input[name=don_vi]').val();
        so_hieu = $('input[name=so_hieu]').val();
        vv = $('input[name=vv]').val();
        kinh_gui = $('input[name=kinh_gui]').val();
        dia_danh = $('input[name=dia_danh]').val();
        email = $('input[name=email]').val();
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        ngay_sinh = $('input[name=ngay_sinh]').val();
        cmnd = $('input[name=cmnd]').val();
        ngay_cap = $('input[name=ngay_cap]').val();
        noi_cap = $('input[name=noi_cap]').val();
        dia_chi = $('input[name=dia_chi]').val();
        diachi_tiepnhan = $('input[name=diachi_tiepnhan]').val();
        chuc_vu = $('input[name=chuc_vu]').val();
        so_luong = $('input[name=so_luong]').val();
        noi_nhan = $('textarea[name=noi_nhan]').val();
        chucvu_daidien = $('textarea[name=chucvu_daidien]').val();
        nguoi_daidien = $('input[name=nguoi_daidien]').val();
        if ($('input[name=camket]').is(':checked')) {
            camket = 1;
        } else {
            camket = 0;
        }
        var list = [];
        i = 0;
        n = 0;
        var list_length = $('.table_danhsach tr').length - 1;
        $('.table_danhsach tr').each(function() {
            i++;
            n = i - 1;
            if (n > 0) {
                name = $(this).find('input[name^=name]').val();
                chucvu = $(this).find('input[name^=chucvu]').val();
                phong = $(this).find('input[name^=phong]').val();
                ngaysinh = $(this).find('input[name^=ngaysinh]').val();
                if (n == list_length) {
                    list += '"' + n + '":{"name":"' + name + '","chucvu":"' + chucvu + '","phong":"' + phong + '","ngaysinh":"' + ngaysinh + '"}';
                } else {
                    list += '"' + n + '":{"name":"' + name + '","chucvu":"' + chucvu + '","phong":"' + phong + '","ngaysinh":"' + ngaysinh + '"},';
                }
            }

        });
        var list_dangky = '{' + list + '}';
        if (ho_ten.length < 5) {
            $('input[name=ho_ten]').focus();
        } else if (cmnd.length < 6) {
            $('input[name=cmnd]').focus();
        } else if (ngay_cap.length < 6) {
            $('input[name=ngay_cap]').focus();
        } else if (noi_cap.length < 4) {
            $('input[name=noi_cap]').focus();
        } else if (email.length < 4) {
            $('input[name=email]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 6) {
            $('input[name=dia_chi]').focus();
        } else if (diachi_tiepnhan.length < 6) {
            $('input[name=diachi_tiepnhan]').focus();
        } else if (chuc_vu.length < 5) {
            $('input[name=chuc_vu]').focus();
        } else if (so_luong == '') {
            $('input[name=so_luong]').focus();
        } else if (i < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Bạn chưa nhập danh sách đăng ký');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else if (noi_nhan == '') {
            $('textarea[name=noi_nhan]').focus();
        } else if (camket == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Bạn chưa cam kết thông tin khai báo');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "dangky_email",
                    co_quan: co_quan,
                    don_vi: don_vi,
                    so_hieu: so_hieu,
                    vv: vv,
                    kinh_gui: kinh_gui,
                    dia_danh: dia_danh,
                    ho_ten: ho_ten,
                    cmnd: cmnd,
                    ngay_cap: ngay_cap,
                    noi_cap: noi_cap,
                    email: email,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    diachi_tiepnhan: diachi_tiepnhan,
                    chuc_vu: chuc_vu,
                    so_luong: so_luong,
                    list: list_dangky,
                    noi_nhan: noi_nhan,
                    chucvu_daidien: chucvu_daidien,
                    nguoi_daidien: nguoi_daidien,
                    camket: camket
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    ////////////////////////
    $('.add_list').on('click', function() {
        $('.table_danhsach tr:last').after('<tr><td><input type="text" name="stt[]" placeholder="STT"></td><td><input type="text" name="name[]" placeholder="Họ và tên"></td><td><input type="text" name="chucvu[]" placeholder="Chức vụ"></td><td><input type="text" name="phong[]" placeholder="Phòng/Ban/Đơn Vị"></td><td><input type="text" name="ngaysinh[]" placeholder="Ngày/Tháng/Năm"></td><td><a href="javascript:;" class="del_row">Xóa</a></td></tr>');
    });
    ////////////////////////
    $('.table_danhsach').on('click', '.del_row', function() {
        $(this).parent().parent().remove();
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
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/';
                    } else {

                    }
                }, 3000);
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
            data: {
                action: 'dangky_dropship'
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }
        });
    });
    ////////////////////////
    $('button[name=dangky_ctv]').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: 'dangky_ctv'
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }
        });
    });
    ////////////////////////
    $('button[name=login]').on('click', function() {
        email = $('input[name=email]').val();
        password = $('input[name=password]').val();
        if (email.length < 4) {
            $('input[name=email]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
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
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/tai-khoan.html';
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    ////////////////////////
    $('button[name=button_lienhe]').on('click', function() {
        ho_ten = $('input[name=ho_ten]').val();
        email = $('input[name=email]').val();
        tieu_de = $('input[name=tieu_de]').val();
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
                    action: 'lienhe',
                    ho_ten: ho_ten,
                    email: email,
                    tieu_de: tieu_de,
                    noi_dung: noi_dung
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('#newsletter-email').keypress(function(e) {
        if (e.which == 13) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            email = $('#newsletter-email').val();
            if (email.length < 5) {
                $('#newsletter-email]').focus();
            } else {
                $.ajax({
                    url: "/process.php",
                    type: "post",
                    data: {
                        action: 'dangky_nhantin',
                        email: email
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                window.location.reload();
                            } else {

                            }
                        }, 3000);
                    }
                });
            }
            return false;
        }
    });
    ////////////////////////
    $('button[name=subscribe]').on('click', function() {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        email = $('#newsletter-email').val();
        if (email.length < 5) {
            $('#newsletter-email]').focus();
        } else {
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'dangky_nhantin',
                    email: email
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    ////////////////////////
    $('input[name=input_search]').on('keyup', function() {
        key = $(this).val();
        if (key.length < 2) {
            $('.kq_search').hide();
        } else {
            $('.kq_search').show();
            $('.kq_search').html('<center><img src="/images/loading.gif"></center>');
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'goi_y',
                    key: key
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.kq_search').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    $('.form_search input[type=text]').keypress(function(e) {
        key = $('.form_search input[type=text]').val();
        if (e.which == 13) {
            link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            if (key.length < 2) {
                $('.form_search input[type=text]').focus();
            } else {
                link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
                window.location.href = link;
            }
            return false;
        }
    });
    /////////////////////////////
    $('.form_search button').click(function(e) {
        key = $('.form_search input[type=text]').val();
        //link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
        if (key.length < 2) {
            $('.form_search input[type=text]').focus();
        } else {
            link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
        }
        return false;
    });
    /////////////////////////////
    $('.box_search input[type=text]').keypress(function(e) {
        key = $('.box_search input[type=text]').val();
        if (e.which == 13) {
            link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            if (key.length < 2) {
                $('.box_search input[type=text]').focus();
            } else {
                link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
                window.location.href = link;
            }
            return false;
        }
    });
    /////////////////////////////
    $('.box_search button').click(function(e) {
        key = $('.box_search input[type=text]').val();
        //link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
        if (key.length < 2) {
            $('.box_search input[type=text]').focus();
        } else {
            link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
        }
        return false;
    });
    ////////////////////////////
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