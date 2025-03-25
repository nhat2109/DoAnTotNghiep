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
// Function to handle sign-in callback
var googleClientId = '174528238670-pjvcs3qs0609ue8oirnbr85q6o52kq38.apps.googleusercontent.com';
// Function to sign in with Google
function signInWithGoogle() {
    gapi.load('auth2', function() {
        var auth2 = gapi.auth2.getAuthInstance();
        if (!auth2) {
            auth2 = gapi.auth2.init({
                client_id: googleClientId,
            });
        }
        auth2.signIn().then(onSignIn);
    });
}
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    var id_token = googleUser.getAuthResponse().id_token;
    $.ajax({
        url: "/login_google.php",
        type: "post",
        data: {
            id: profile.getId(),
            name: profile.getName(),
            avatar: profile.getImageUrl(),
            email: profile.getEmail(),
            id_token:id_token
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            if(info.ok==1){
                if(info.tiep==1){
                    $('.box_show_login .box_left_login').html(info.html);
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        window.location.href=info.link;
                    }, 3000);
                }
            }else{
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
function format_price(num) {
    var p = num.toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return num + (num != "-" && i && !(i % 3) ? "," : "") + acc;
    }, "");
}
function updateImageSrc() {
    var windowWidth = window.innerWidth;
    var boxTopIndex = document.querySelector('.box_top_index');
    if (boxTopIndex) {
        var img = boxTopIndex.querySelector('img');
        if (img) {
            var srcLaptop = img.getAttribute('src-laptop');
            var srcMobile = img.getAttribute('src-mobile');
            if (windowWidth < 768) {
                img.setAttribute('src', srcMobile);
            } else {
                img.setAttribute('src', srcLaptop);
            }
        }
    }
    var boxTopBH = document.querySelector('.box_top_baohanh');
    if (boxTopBH) {
        var img = boxTopBH.querySelector('img');
        if (img) {
            var srcLaptop = img.getAttribute('src-laptop');
            var srcMobile = img.getAttribute('src-mobile');
            if (windowWidth < 768) {
                img.setAttribute('src', srcMobile);
            } else {
                img.setAttribute('src', srcLaptop);
            }
        }
    }
}

// Gọi hàm updateImageSrc khi tải trang
updateImageSrc();

// Thêm sự kiện resize vào cửa sổ
window.addEventListener('resize', function() {
    updateImageSrc();
    console.log(window.innerWidth);        
});
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('utm_source')) {
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "update_click",
                link:window.location.href,
                referrer:document.referrer
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                console.log('ok');
            }
        });
        utm_source=urlParams.get('utm_source');
        setCookie('utm_source', utm_source, 60);
    }
    if (urlParams.has('utm_campaign')) {
        utm_campaign=urlParams.get('utm_campaign');
        setCookie('utm_campaign', utm_campaign, 60);
    }
    // header_height=$('header').height();
    // $('.box_sieu_sale').css('top',header_height+'px');
    // $('.box_sieu_sale').css('margin-bottom',header_height+'px');
    // if($(window).width()>=1024){
    //     $('.bread-crumb').css('padding-top',header_height+'px');
    //     $('.hr_home').css('padding-top',header_height+'px');
    // }

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
    $('body').on('click','.mota_sanpham .btn-detail',function(){
        if($('.mota_sanpham .mota_short').hasClass('active')){
            $('.mota_sanpham .btn-detail span').html('Xem thêm <i class="fa fa-angle-down"></i>');
            $('.bg-article').show();
        }else{
            $('.bg-article').hide();
            $('.mota_sanpham .btn-detail span').html('Thu nhỏ <i class="fa fa-angle-up"></i>');
        }
        $('.mota_sanpham .mota_short').toggleClass('active');
    });
    $('body').on('click','.box_up_index .box_up_index_content .content .text .list_button a.button_1',function(){
        $('.box_up_index').hide();
        setCookie('close_up', '1', 86400/86400);
    });
    $('body').on('click','.box_up_index .box_up_index_content .content .text .list_button a.button_2',function(){
        $('.box_up_index').hide();
        setCookie('close_up', '1', 86400/86400);
        window.location.href='/dangky-banhang.html';
    });
    $('body').on('click','.box_up_index .box_up_index_content .content .text .list_button a.button_3',function(){
        $('.box_up_index').hide();
        setCookie('close_up', '1', 86400/86400);
        $('.show_nnc').click();
    });
    /////////////
    $('body').on('click','.list_donhang .li_donhang .li_donhang_top',function(){
        $(this).parent().toggleClass('active');
    });
    /////////////
    $('body').on('click','.box_up_index .box_up_index_content .content .close',function(){
        $('.box_up_index').hide();
        setCookie('close_up', '1', 86400/86400);
    });
/*    if(get_cookie('close_up')){
    }else{
        setTimeout(function() {
            $('.box_up_index').fadeIn();
        }, 500);
    }*/
    $('body').on('click','.order-summary-toggle-text',function(){
        $('.order-summary-toggle-text-show').toggle();
        $('.order-summary-toggle-text-hide').toggle();
        $('.thongtin_donhang').toggleClass('order-summary-is-collapsed');
    });
    setTimeout(function() {
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "get_popup"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_popup .content_box').html(info.content);
                    $('.box_popup').fadeIn();
                }
            }

        });

    }, 3000);
    if ($('.list_skin').length > 0) {
        total_giaodien = $('.list_tab_skin .li_tab.active').attr('total');
        end_giaodien = $('.list_tab_skin .li_tab.active').attr('end');
        if (total_giaodien > end_giaodien) {
            $('.load_skin').show();
        }
    }
    $('.list_video_skin .small_video .box-video').on('click', function() {
        id_video = $(this).attr('video');
        tieu_de = $(this).find('h4 a').html();
        $('.list_video_skin .big_video .box-video').find('h4 a').html(tieu_de);
        $('.list_video_skin .big_video .box-video .thumbnail').html('<iframe width="560" height="315" src="https://www.youtube.com/embed/' + id_video + '?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    });
    $(".list_skin").on('mouseenter', '.product-image', function() {
        $(this).find('.add-to-cart a').fadeIn();
    });
    $(".list_skin").on('mouseleave', '.product-image', function() {
        $(this).find('.add-to-cart a').fadeOut();
    });
    $('body').on('click','.box_popup .box_title i',function() {
        $('.box_popup').fadeOut();
    });
    $('.show_nnc').click(function() {
        $('.box_nnc').fadeIn();
    });
    $('body').on('click','.box_nnc .box_title i',function() {
        $('.box_nnc').fadeOut();
    });
    $('.show_login').click(function() {
        $('.box_show_login').fadeIn();
    });
    $('body').on('click','.box_show_login .box_title i',function() {
        $('.box_show_login').fadeOut();
    });
    $('body').on('click','.box_show_update .box_title i',function() {
        $('.box_show_update').fadeOut();
    });
    $('#show_kichhoat_baohanh').click(function() {
        $('.box_kichhoat_baohanh').fadeIn();
    });
    $('body').on('change','.tab_box .tab .box_login .li_input select[name=tinh]',function(){
        tinh=$(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_huyen',
                tinh:tinh
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.tab_box .tab .box_login .li_input select[name=huyen]').html(info.list);
                $('.tab_box .tab .box_login .li_input select[name=xa]').html('<option value="">Chọn Xã/phường</option>');
            }
        });
    });
    $('body').on('change','.tab_box .tab .box_login .li_input select[name=huyen]',function(){
        huyen=$(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_xa',
                huyen:huyen
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.tab_box .tab .box_login .li_input select[name=xa]').html(info.list);
            }
        });
    });
    $('body').on('change','.box_thongtin_khach select[name=tinh]',function(){
        tinh=$(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_huyen',
                tinh:tinh
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_thongtin_khach select[name=huyen]').html(info.list);
                $('.box_thongtin_khach select[name=xa]').html('<option value="">Chọn Xã/phường</option>');
            }
        });
    });
    $('body').on('change','.box_thongtin_khach select[name=huyen]',function(){
        huyen=$(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_xa',
                huyen:huyen
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_thongtin_khach select[name=xa]').html(info.list);
            }
        });
    });
    ///////////////////////////
    $('body').on('click','.list_chinhsach .li_chinhsach',function(){
        div=$(this);
        $(this).toggleClass('active');
        id=$(this).attr('post');
        content=div.find('.content_chinhsach').text();
        if(content.length>10){
        }else{
            if(div.hasClass('active')){
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    data: {
                        action: 'load_content_chinhsach',
                        id:id
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        if (info.ok == 1) {
                            div.find('.content_chinhsach').html(info.content);

                        } else {
                        }
                    }
                });
            }

        }
    });
    ///////////////////////////
    $('body').on('click','.box_quanlity .fa-minus',function(){
        value=$(this).parent().parent().find('input[name=so_luong]').val();
        if(value>1){
            value--;
            $(this).parent().parent().find('input[name=so_luong]').val(value);
        }else{
            $(this).parent().parent().find('input[name=so_luong]').val(1);
        }
    });
    $('body').on('click','.box_quanlity .fa-plus',function(){
        value=$(this).parent().parent().find('input[name=so_luong]').val();
        value++;
        $(this).parent().parent().find('input[name=so_luong]').val(value);
    });
    $('body').on('click','.tichdiem_info .fa-question-circle',function(){
        $('.tichdiem_info .note_hatde').toggleClass('active');
    });
    $('body').on('click','.box_phanloai .list_color .li_color',function(){
        $(this).parent().find('.li_color').removeClass('active');
        $(this).addClass('active');
        ten_color=$(this).attr('tieu_de');
        $('.box_phanloai .title_color span').html(ten_color);
        size=$('.box_phanloai .list_color .li_color.active').attr('size');
        color=$('.box_phanloai .list_color .li_color.active').attr('color');
        pl=$('.box_phanloai .list_color .li_color.active').attr('pl');
        $('button.them_gio').attr('size',size);
        $('button.them_gio').attr('color',color);
        $('button.them_gio').attr('pl',pl);
        $('button.mua_ngay').attr('size',size);
        $('button.mua_ngay').attr('color',color);
        $('button.mua_ngay').attr('pl',pl);
    });
    $('body').on('click','.box_phanloai .list_color .li_color',function(){
        $(this).parent().find('.li_color').removeClass('active');
        $(this).addClass('active');
        sp_id=$(this).attr('sp_id');
        color=$(this).attr('color');
        gia_moi=$(this).attr('gia_moi');
        gia_cu=$(this).attr('gia_cu');
        sale=$(this).attr('sale');
        ten_color=$(this).attr('tieu_de');
        $('.box_right_info .price_new').html(gia_moi+' đ');
        $('.box_right_info .price_old').html(gia_cu+' đ');
        $('.box_right_info .sale').html(sale+'%');
        $('.box_phanloai .title_color span').html(ten_color);
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_size',
                sp_id:sp_id,
                color:color
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_phanloai .list_size').html(info.list);
                    $('.box_phanloai .title_size span').html(info.ten_size);
                    size=$('.box_phanloai .list_size .li_color.active').attr('size');
                    color=$('.box_phanloai .list_color .li_color.active').attr('color');
                    pl=$('.box_phanloai .list_size .li_color.active').attr('pl');
                    $('button.them_gio').attr('size',size);
                    $('button.them_gio').attr('color',color);
                    $('button.them_gio').attr('pl',pl);
                    $('button.mua_ngay').attr('size',size);
                    $('button.mua_ngay').attr('color',color);
                    $('button.mua_ngay').attr('pl',pl);
                } else {
                }
            }
        });
    });
    $('.box_kichhoat_baohanh .box_title i').click(function() {
        $('.box_kichhoat_baohanh').hide();
        $('.box_kichhoat_baohanh .box_kichhoat_baohanh_content').css('width','800px');
        $('.box_kichhoat_baohanh .box_kichhoat_baohanh_content .content').css('height','685px');
        $('.box_kichhoat_baohanh .box_noidung').css('display','block');
        $('.box_kichhoat_baohanh .box_form').css('display','block');
        $('.box_kichhoat_baohanh .box_chucmung').css('display','none');
        $('.box_kichhoat_baohanh .box_chucmung .text_account').css('display','none');
        $('.box_kichhoat_baohanh .box_chucmung .text_username').css('display','none');
        $('.box_kichhoat_baohanh .box_chucmung .text_password').css('display','none');
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
    ///////////////////////////
    $('body').on('click','.back_button',function(){
        $('.box_main_account_left').show();
        $('.box_main_account_right').hide();
    });
    //////////////////////////
    $('body').on('click','.box_main_account_left .li_action_menu a',function(e){
        text_menu=$(this).find('.text_menu').text();
        link=$(this).attr('href');
        $('.box_main_account_left .li_action_menu').removeClass('active');
        $(this).parent().addClass('active');
        if($(window).width()>768){

        }else{
            if(link=='/dang-xuat.html'){
            }else{
                window.history.pushState("", "", link);
                $('title').text(text_menu);
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    data: {
                        action: 'load_content_right',
                        link:link
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        if (info.ok == 1) {
                            $('.box_main_account_left').hide();
                            $('.box_main_account_right').html(info.html);
                            $('.box_main_account_right').show();
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
                return false;
                e.stopPropagation();
            }
        }
    });
    //////////////////////////
    $('body').on('click','.show_update',function(e){
        loai=$(this).attr('loai');
        id=$(this).attr('value');
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'show_update',
                loai:loai,
                id:id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_show_update').html(info.html);
                    $('.box_show_update').show();
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
    $('body').on('change','.load_huyen',function(e){
        tinh=$(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_huyen',
                tinh:tinh
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_show_update_content select[name=huyen]').html(info.list);
                $('.box_show_update_content select[name=xa]').html('<option value="">Chọn xã</option>');
            }
        });
    });
    //////////////////////////
    $('body').on('change','.load_xa',function(e){
        huyen=$(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_xa',
                huyen:huyen
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_show_update_content select[name=xa]').html(info.list);
            }
        });
    });
    /////////////////////////////
    $('#box_pop_confirm .button_cancel').on('click', function() {
        $('#title_confirm').html('');
        $('#button_thuchien').attr('action', '');
        $('#button_thuchien').attr('post_id', '');
        $('#button_thuchien').attr('loai', '');
        $('#box_pop_confirm').hide();
    });
    /////////////////////////////
    $('body').on('click','.del_diachi',function(){
        id=$(this).attr('value');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang thực hiện <b>xóa</b> địa chị!<br>Bạn có chắc chắn thực hiện hành động này?');
        $('#button_thuchien').attr('action', 'del_diachi');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click','.set_default_diachi',function(){
        id=$(this).attr('value');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang đặt địa chỉ này thành <b>mặc định</b>!<br>Bạn có chắc chắn thực hiện hành động này?');
        $('#button_thuchien').attr('action', 'set_default_diachi');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click','#box_pop_confirm #button_thuchien',function(){
        action=$(this).attr('action');
        id=$(this).attr('post_id');
        loai=$(this).attr('loai');
        if(action=='del_diachi'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "del",
                    loai:'dia_chi',
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_process .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        }else if(action=='set_default_diachi'){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "set_default_diachi",
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_process .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////
    $('body').on('click','.box_media .button-radius',function(){
        $('.box_media').html('<iframe src="https://www.youtube.com/embed/rpkjJFeEwAI?rel=0&amp;autoplay=1&amp;controls=0&amp;mute=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>');

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
    $('.type_register button').on('click', function() {
        $('.type_register button').removeClass('active');
        $(this).addClass('active');
    });
    //////////////////////////
    $('body').on('click', '.btn-continue', function() {
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    //////////////////////////
    $('body').on('click', '#get_opt_password', function() {
        if($('#get_opt_password span').length>0){

        }else{
            dien_thoai = $('input[name=dien_thoai]').val();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'get_opt_password',
                    dien_thoai:dien_thoai
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    if(info.ok==1){
                        $('#get_opt').attr('time',60);
                        $('#get_opt').html('<span class="seconds"></span>');
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
                                /*$this.fadeTo('slow', .5);*/
                                $this.html('Lấy mã xác nhận');
                            finished = true;
                                    break;
                            }
                        }
                        $('.timer_countdown').each(function(){
                            con=$(this).attr('time')*1000;
                            $(this).countdown(con + currentDate.valueOf(), call_flash);
                        });
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
        }
    });
    //////////////////////////
    $('body').on('click', '#get_opt', function() {
        if($('#get_opt span').length>0){

        }else{
            dien_thoai = $('input[name=dien_thoai]').val();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/process.php',
                type: 'post',
                data: {
                    action: 'get_opt',
                    dien_thoai:dien_thoai
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    if(info.ok==1){
                        $('#get_opt').attr('time',60);
                        $('#get_opt').html('<span class="seconds"></span>');
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
                                /*$this.fadeTo('slow', .5);*/
                                $this.html('Lấy mã xác nhận');
                            finished = true;
                                    break;
                            }
                        }
                        $('.timer_countdown').each(function(){
                            con=$(this).attr('time')*1000;
                            $(this).countdown(con + currentDate.valueOf(), call_flash);
                        });
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
        }

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
                    if(info.ok==1){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_overlay').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                        }, 2000);
                    }
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
                    if (info.ok == 1) {
                        setTimeout(function() {
                            $('.load_note').html('Hệ thống đang chuyển hướng...');
                        }, 500);
                        setTimeout(function() {
                            window.location.href = '/gio-hang.html';
                        }, 2000);
                    } else {
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
                    if (info.ok == 1) {
                        setTimeout(function() {
                            $('.load_note').html('Hệ thống đang chuyển hướng...');
                        }, 500);
                        setTimeout(function() {
                            window.location.href = '/gio-hang.html';
                        }, 2000);
                    } else {
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
    $('body').on('click','.list_shopcart .fa-minus',function(){
        sp_id=$(this).parent().attr('sp_id');
        so_luong=$(this).parent().parent().find('input').val();
        if(so_luong>1){
            so_luong--;
            $(this).parent().parent().find('input').val(so_luong);
        }else{
            $(this).parent().parent().find('input').val('1');
        }
    });
    /////////////////////////////
    $('body').on('click','.list_shopcart .fa-plus',function(){
        sp_id=$(this).parent().attr('sp_id');
        so_luong=$(this).parent().parent().find('input').val();
        so_luong++;
        $(this).parent().parent().find('input').val(so_luong);
    });
    /////////////////////////////
    $('body').on('click','.li_shopcart .name .info .action',function(){
        sp_id=$(this).attr('sp_id');
        div=$(this);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'remove_shopcart',
                sp_id: sp_id,
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_overlay').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.box_welcome .tongdon .text').html(info.text_tongdon);
                        $('.box_welcome .tongdon .money').html(info.text_tamtinh);
                        $('.box_welcome .hoantien .money span').html(info.text_hoantien);
                        $('.box_tamtinh .tamtinh').html(info.tamtinh);
                        $('.box_tamtinh .tietkiem').html(info.tietkiem);
                        $('.box_tamtinh .giam').html(info.giam);
                        $('.box_tong .tongtien').html(info.tongtien);
                        $('.box_tong .tietkiem').html(info.tong_tietkiem);
                        div.parent().parent().parent().remove();
                    }, 2000);
                }else{
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_overlay').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                    }, 2000);
                }
            }
        });
    });
    /////////////////////////////
    $('.them_gio').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
            loai = $(this).attr('loai');
            color=$(this).attr('color');
            size=$(this).attr('size');
            pl=$(this).attr('pl');
            quantity = $('.box_quanlity input').val();
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
                    loai: loai,
                    size: size,
                    mau: color,
                    quantity: quantity,
                    flash_sale: flash_sale,
                    pl:pl
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            $('.cart_mobile .count_item').html(info.total);
                            $('.box_control .count_item').html(info.total);
                        }, 1000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_overlay').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                        }, 2000);
                    }
                }
            });
        }
    });
    /////////////////////////////
    $('.mua_ngay').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
            loai = $(this).attr('loai');
            color=$(this).attr('color');
            size=$(this).attr('size');
            pl=$(this).attr('pl');
            quantity = $('.box_quanlity input').val();
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
                    loai: loai,
                    size: size,
                    mau: color,
                    quantity: quantity,
                    flash_sale: flash_sale,
                    pl:pl
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        window.location.href='/gio-hang.html';
                    }else{
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_overlay').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                        }, 2000);
                    }
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
    $('#checkout_gopdon_step_1').on('click', function() {
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
                            window.location.href = '/checkout-gopdon.html?step=2';
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
    $('#checkout_gopdon_step_2').on('click', function() {
        thanhtoan = $('input[name=payment_method_id]:checked').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'checkout_gopdon_step_2',
                thanhtoan: thanhtoan
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        window.location.href = '/checkout-gopdon.html?step=3';
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
    $('.button_thanhtoan').on('click',function(){
        ho_ten = $('.box_shopcart input[name=ho_ten]').val();
        email = $('.box_shopcart input[name=email]').val();
        dien_thoai = $('.box_shopcart input[name=dien_thoai]').val();
        dia_chi = $('.box_shopcart input[name=dia_chi]').val();
        tinh = $('.box_shopcart select[name=tinh]').val();
        huyen = $('.box_shopcart select[name=huyen]').val();
        xa = $('.box_shopcart select[name=xa]').val();
        ghi_chu = $('.box_shopcart input[name=ghi_chu]').val();
        phuongthuc=$('.list_phuongthuc input[name=phuongthuc]:checked').val();
        if($('.box_aply_hatde input[name=apply_hatde]').is(':checked')){
            apply_hatde=1;
        }else{
            apply_hatde=0;

        }
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'order_step1',
                ho_ten:ho_ten,
                email:email,
                dien_thoai:dien_thoai,
                dia_chi:dia_chi,
                tinh:tinh,
                huyen:huyen,
                xa:xa,
                ghi_chu:ghi_chu,
                phuongthuc:phuongthuc,
                apply_hatde:apply_hatde
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        window.location.href=info.link;
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
    $('body').on('click','button[name=apply_coupon]', function() {
        coupon = $(this).parent().find('input[name=coupon]').val();
        if (coupon.length < 4) {
            $(this).parent().find('input[name=coupon]').focus();
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
    $('.box_list_sanpham select[name=sort]').on('change', function() {
        var queryParams = new URLSearchParams(window.location.search);
        var sort = $(this).val();
        queryParams.set("sort", sort);
        queryParams.set("page", 1);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        window.location.href = url;
    });
    /////////////////////////////
    $('.box_filter select[name=color_filter]').on('change',function() {
        var queryParams = new URLSearchParams(window.location.search);
        color= $(this).val();
        if (color!='') {
            color = color.substring(0, color.length);
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
    $('.box_filter select[name=price_filter]').on('change',function() {
        var queryParams = new URLSearchParams(window.location.search);
        price= $(this).val();
        if (price!='') {
            //price = price.substring(0, price.length);
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
    $('.box_filter select[name=size_filter]').on('change',function() {
        var queryParams = new URLSearchParams(window.location.search);
        size= $(this).val();
        if (size!='') {
            //size = size.substring(0, size.length);
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
    $('.box_filter select[name=brand_filter]').on('change',function() {
        var queryParams = new URLSearchParams(window.location.search);
        brand= $('.box_filter select[name=brand_filter]').val();
        if (brand!='') {
            //brand = brand.substring(0, brand.length);
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
    $('body').on('click','button[name=update_password]',function() {
        password = $('.form_update input[name=password]').val();
        new_password = $('.form_update input[name=new_password]').val();
        confirm_password = $('.form_update input[name=confirm_password]').val();
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
    $('body').on('click','button[name=update_profile]',function() {
        ho_ten = $('.form_update input[name=name]').val();
        gioi_tinh = $('.form_update select[name=gioi_tinh]').val();
        ngay_sinh = $('.form_update input[name=ngay_sinh]').val();
        email = $('.form_update input[name=email]').val();
        if (ho_ten.length < 2) {
            $('.form_update input[name=name]').focus();
        } else if (email.length < 6) {
            $('.form_update  input[name=email]').focus();
        } else if (ngay_sinh.length < 6) {
            $('.form_update  input[name=ngay_sinh]').focus();
        } else {
            $('.box_pop').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'update_profile',
                    ho_ten:ho_ten,
                    email:email,
                    gioi_tinh:gioi_tinh,
                    ngay_sinh:ngay_sinh
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
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=add_diachi]',function() {
        ho_ten = $('.form_update input[name=ho_ten]').val();
        dien_thoai = $('.form_update input[name=dien_thoai]').val();
        email = $('.form_update input[name=email]').val();
        tinh = $('.form_update select[name=tinh]').val();
        huyen = $('.form_update select[name=huyen]').val();
        xa = $('.form_update select[name=xa]').val();
        ten_tinh = $('.form_update select[name=tinh] option:selected').text();
        ten_huyen = $('.form_update select[name=huyen] option:selected').text();
        ten_xa = $('.form_update select[name=xa] option:selected').text();
        dia_chi = $('.form_update input[name=dia_chi]').val();
        active = $('.form_update select[name=active]').val();
        if (ho_ten.length < 2) {
            $('.form_update input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 10) {
            $('.form_update  input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 2) {
            $('.form_update  input[name=dia_chi]').focus();
        } else {
            $('.box_pop').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'add_diachi',
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    email:email,
                    tinh:tinh,
                    huyen:huyen,
                    xa:xa,
                    ten_xa:ten_xa,
                    ten_huyen:ten_huyen,
                    ten_tinh:ten_tinh,
                    dia_chi:dia_chi,
                    active:active
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
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=update_diachi]',function() {
        ho_ten = $('.form_update input[name=ho_ten]').val();
        dien_thoai = $('.form_update input[name=dien_thoai]').val();
        email = $('.form_update input[name=email]').val();
        tinh = $('.form_update select[name=tinh]').val();
        huyen = $('.form_update select[name=huyen]').val();
        xa = $('.form_update select[name=xa]').val();
        ten_tinh = $('.form_update select[name=tinh] option:selected').text();
        ten_huyen = $('.form_update select[name=huyen] option:selected').text();
        ten_xa = $('.form_update select[name=xa] option:selected').text();
        dia_chi = $('.form_update input[name=dia_chi]').val();
        active = $('.form_update select[name=active]').val();
        id = $('.form_update input[name=id]').val();
        if (ho_ten.length < 2) {
            $('.form_update input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 10) {
            $('.form_update  input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 2) {
            $('.form_update  input[name=dia_chi]').focus();
        } else {
            $('.box_pop').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: 'update_diachi',
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    email:email,
                    tinh:tinh,
                    huyen:huyen,
                    xa:xa,
                    ten_xa:ten_xa,
                    ten_huyen:ten_huyen,
                    ten_tinh:ten_tinh,
                    dia_chi:dia_chi,
                    active:active,
                    id:id
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
        }
    });
    //////////////////////
    $('button[name=quen_matkhau]').on('click', function() {
        dien_thoai = $('input[name=dien_thoai]').val();
        password = $('input[name=password]').val();
        re_password = $('input[name=re_password]').val();
        ma_xacnhan = $('input[name=ma_xacnhan]').val();
        var form_data = new FormData();
        form_data.append('action', 'forgot_password');
        form_data.append('dien_thoai', dien_thoai);
        form_data.append('password', password);
        form_data.append('re_password', re_password);
        form_data.append('ma_xacnhan', ma_xacnhan);
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
        password = $('input[name=password]').val();
        confirm_password = $('input[name=re_password]').val();
        ho_ten = $('input[name=ho_ten]').val();
        /*ma_xacnhan = $('input[name=ma_xacnhan]').val();*/
        dien_thoai = $('input[name=dien_thoai]').val();
        if (ho_ten.length < 5) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else if (password != confirm_password) {
            $('input[name=re_password]').focus();
        }/* else if (ma_xacnhan.length < 3) {
            $('input[name=ma_xacnhan]').focus();
        }*/ else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "register",
                    password: password,
                    re_password: confirm_password,
                    ho_ten: ho_ten,
                    /*ma_xacnhan: ma_xacnhan,*/
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
                            window.location.href = '/tai-khoan.html';
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
                    nganh_hang: nganh_hang,
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
    $('.dk_website').on('click', function() {
        email = $('#email_website').val();
        if (email != '') {
            window.location.href = '/dangky-banhang.html?email=' + email;
        } else {
            window.location.href = '/dangky-banhang.html';
        }
    });
    ////////////////////////
    $('.dk_web').on('click', function() {
        email = $('#email_web').val();
        if (email != '') {
            window.location.href = '/dangky-banhang.html?email=' + email;
        } else {
            window.location.href = '/dangky-banhang.html';
        }
    });
    ////////////////////////
    $('.list_tab_skin .li_tab').on('click', function() {
        $('.list_tab_skin .li_tab').removeClass('active');
        $(this).addClass('active');
        loai = $(this).attr('loai');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_skin",
                loai: loai,
                page: 1
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_skin').html(info.list);
                $('.list_skin').attr('page', info.page);
                if (info.total_giaodien > info.end) {
                    $('.load_skin').show();
                } else {
                    $('.load_skin').hide();
                }
            }

        });

    });
    ////////////////////////
    $('.load_skin span').on('click', function() {
        page = $('.list_skin').attr('page');
        loai = $('.list_tab_skin .li_tab.active').attr('loai');
        $('.load_skin span').html('Đang tải...');
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "load_skin",
                loai: loai,
                page: page
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.list_skin').append(info.list);
                $('.list_skin').attr('page', info.page);
                $('.load_skin span').html('xem thêm');
                if (info.total_giaodien > info.end) {
                    $('.load_skin').show();
                } else {
                    $('.load_skin').hide();
                }
            }

        });

    });
    ////////////////////////
    $('button[name=dangky_banhang]').on('click', function() {
        password = $('input[name=password]').val();
        confirm_password = $('input[name=re_password]').val();
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        email = $('input[name=email]').val();
        ma_gioithieu = $('input[name=ma_gioithieu]').val();
        maso_thue = $('input[name=maso_thue]').val();
        maso_thue_cap = $('input[name=maso_thue_cap]').val();
        maso_thue_noicap = $('input[name=maso_thue_noicap]').val();
        dia_chi = $('.tab_box .tab .box_login input[name=dia_chi]').val();
        tinh = $('.tab_box .tab .box_login .button_login select[name=tinh]').val();
        huyen = $('.tab_box .tab .box_login .button_login select[name=huyen]').val();
        xa = $('.tab_box .tab .box_login .button_login select[name=xa]').val();
        /*ma_xacnhan = $('input[name=ma_xacnhan]').val();*/
        if (ho_ten.length < 5) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 8) {
            $('input[name=dien_thoai]').focus();
        } else if (email.length < 5) {
            $('input[name=email]').focus();
        } else if (maso_thue.length < 5) {
            $('input[name=maso_thue]').focus();
        } else if (maso_thue_cap.length < 6) {
            $('input[name=maso_thue_cap]').focus();
        } else if (maso_thue_noicap.length < 3) {
            $('input[name=maso_thue_noicap]').focus();
        } else if (tinh=='') {
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn tỉnh/TP');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (huyen=='') {
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn quận/huyện');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (xa=='') {
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn xã/phường');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (dia_chi=='') {
            $('input[name=dia_chi]').focus();
        }else if (password.length < 6) {
            $('input[name=password]').focus();
        } else if (password != confirm_password) {
            $('input[name=re_password]').focus();
        }/* else if (ma_xacnhan.length < 3) {
            $('input[name=ma_xacnhan]').focus();
        }*/ else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "register_banhang",
                    password: password,
                    re_password: confirm_password,
                    ho_ten: ho_ten,
                    maso_thue:maso_thue,
                    maso_thue_cap:maso_thue_cap,
                    maso_thue_noicap:maso_thue_noicap,
                    tinh:tinh,
                    huyen:huyen,
                    xa:xa,
                    dia_chi:dia_chi,
                    /*ma_xacnhan: ma_xacnhan,*/
                    dien_thoai: dien_thoai,
                    email:email,
                    ma_gioithieu:ma_gioithieu
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
                            window.location.href = '/dropship/';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    //////////////////////////
    $('#save_baohanh').on('click', function() {
        ho_ten = $('.box_kichhoat_baohanh input[name=ho_ten]').val();
        dien_thoai = $('.box_kichhoat_baohanh input[name=dien_thoai]').val();
        var file_data = $('#file_donhang').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'save_baohanh');
        form_data.append('file', file_data);
        form_data.append('ho_ten', ho_ten);
        form_data.append('dien_thoai', dien_thoai);
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
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_kichhoat_baohanh_content').css('width','480px');
                        $('.box_kichhoat_baohanh .box_kichhoat_baohanh_content .content').css('height','550px');
                        $('.box_kichhoat_baohanh_content .box_noidung').hide();
                        $('.box_kichhoat_baohanh_content .box_form').hide();
                        $('.box_kichhoat_baohanh_content .box_chucmung').show();
                        if(info.add_user==1){
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_account').css('display','block');
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_username').css('display','flex');
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_password').css('display','flex');
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_username span').html(info.dien_thoai);
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_password span').html(info.password);

                        }
                        $('.box_kichhoat_baohanh_content .box_chucmung .coupon span').html(info.coupon);
                        $('.box_kichhoat_baohanh_content .box_chucmung .coupon_expired span').html(info.expired);
                    } else {
                    }
                }, 3000);
            }

        });
    });
    //////////////////////////
    $('button[name=save_baohanh]').on('click', function() {
        ho_ten = $('.box_baohanh input[name=ho_ten]').val();
        san_pham = $('.box_baohanh input[name=san_pham]').val();
        dien_thoai = $('.box_baohanh input[name=dien_thoai]').val();
        //var file_data = $('#file-input').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'save_baohanh');
        //form_data.append('file', file_data);
        for (var i = 0; i < filesToUpload.length; i++) {
            form_data.append('file', filesToUpload[i]);
        }
        form_data.append('ho_ten', ho_ten);
        form_data.append('san_pham', san_pham);
        form_data.append('dien_thoai', dien_thoai);
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
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_kichhoat_baohanh_content').css('width','480px');
                        $('.box_kichhoat_baohanh .box_kichhoat_baohanh_content .content').css('height','550px');
                        $('.box_kichhoat_baohanh_content .box_noidung').hide();
                        $('.box_kichhoat_baohanh_content .box_form').hide();
                        $('.box_kichhoat_baohanh_content .box_chucmung').show();
                        if(info.add_user==1){
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_account').css('display','block');
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_username').css('display','flex');
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_password').css('display','flex');
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_username span').html(info.dien_thoai);
                            $('.box_kichhoat_baohanh_content .box_chucmung .text_password span').html(info.password);

                        }
                        $('.box_kichhoat_baohanh_content .box_chucmung .coupon span').html(info.coupon);
                        $('.box_kichhoat_baohanh_content .box_chucmung .coupon_expired span').html(info.expired);
                    } else {
                    }
                }, 3000);
            }

        });
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
    $('body').on('click','.dangky_dropship', function() {
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
    $('.box_login button[name=login]').on('click', function() {
        email = $('.box_login input[name=email]').val();
        password = $('.box_login input[name=password]').val();
        if (email.length < 4) {
            $('.box_login input[name=email]').focus();
        } else if (password.length < 6) {
            $('.box_login input[name=password]').focus();
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
                            window.location.href = info.link;
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    ////////////////////////
    $('.box_show_login button[name=login]').on('click', function() {
        email = $('.box_show_login input[name=email]').val();
        password = $('.box_show_login input[name=password]').val();
        if (email.length < 4) {
            $('.box_show_login input[name=email]').focus();
        } else if (password.length < 6) {
            $('.box_show_login input[name=password]').focus();
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
                             window.location.href = info.link;
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    ////////////////////////
    $('body').on('click','.box_show_login button[name=google_step_2]', function() {
        ho_ten = $('.box_show_login input[name=ho_ten]').val();
        email = $('.box_show_login input[name=email]').val();
        mobile = $('.box_show_login input[name=mobile]').val();
        password = $('.box_show_login input[name=password]').val();
        avatar = $('.box_show_login input[name=avatar]').val();
        re_password = $('.box_show_login input[name=re_password]').val();
        if (mobile.length < 10) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Thất bại! Chưa nhập số điện thoại');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
            $('.box_show_login input[name=mobile]').focus();
        } else if (password.length < 6) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Thất bại! Mật khẩu dài từ 6 ký tự');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
            $('.box_show_login input[name=password]').focus();
        } else if (password!=re_password) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Thất bại! Xác nhận mật khẩu không khớp');
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
            $('.box_show_login input[name=re_password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    'action':'update_info',
                    ho_ten:ho_ten,
                    email:email,
                    mobile: mobile,
                    password: password,
                    avatar:avatar,
                    re_password:re_password
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
    var dropZone = $('#drop-zone');
    var fileInput = $('#file-input');
    var filesToUpload = [];

    dropZone.on('click', function() {
        fileInput.click();
    });

    dropZone.on('dragover', function(e) {
        e.preventDefault();
        dropZone.addClass('dragover');
    });

    dropZone.on('dragleave', function(e) {
        e.preventDefault();
        dropZone.removeClass('dragover');
    });

    dropZone.on('drop', function(e) {
        e.preventDefault();
        dropZone.removeClass('dragover');
        var files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
        //uploadFiles(files);

    });
    function handleFiles(files) {
        for (var i = 0; i < files.length; i++) {
            filesToUpload.push(files[i]);
            //fileList.append('<div class="file-item">' + files[i].name + '</div>');
            $('.button_file_bh').html('<i class="icon icon-image5"></i> '+files[i].name); // Hiển thị tên tệp
        }
    }
    fileInput.on('change', function() {
        var files = fileInput[0].files;
        handleFiles(files);
        //uploadFiles(files);
        var fileName = $(this).val().split('\\').pop(); // Lấy tên tệp từ đường dẫn
        $('.button_file_bh').html('<i class="icon icon-image5"></i> '+fileName); // Hiển thị tên tệp
    });
    function uploadFiles(files) {
        var formData = new FormData();
        for (var i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        $.ajax({
            url: 'upload_test.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.list_file_bh').append()
            },
            error: function(jqXHR, textStatus, errorMessage) {
                alert('Error: ' + errorMessage);
            }
        });
    }
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