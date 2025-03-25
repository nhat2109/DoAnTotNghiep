//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function scrollSmoothToBottom(id) {
    var div = document.getElementById(id);
    $('#' + id).animate({
        scrollTop: div.scrollHeight - div.clientHeight
    }, 200);
}
//var socket =io("http://localhost:3000");
var socket = io("https://chat.socdo.vn");
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
function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
/*$(function() {
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var img_name=input.files[i].name;
                $(placeToInsertImagePreview).append('<div class="li_upload"><div class="img"><i class="fa fa-picture-o"></i></div><div class="img_info"><div class="img_name">'+img_name+'</div><div class="img_icon"><i class="fa fa-spinner fa-spin"></i></div></div></div>');
            }
        }
    };
    $('#photo-add').on('change', function() {
        imagesPreview(this, '.list_upload');
    });
});*/
function check_domain() {
    var div = $('.list_result .domain').not('.loaded').first();
    domain = div.attr('domain');
    $.ajax({
        url: '/admin/process.php',
        type: 'post',
        data: {
            action: 'check_domain',
            domain: domain
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            div.parent().find('.btn-domain').html(info.button);
            div.addClass('loaded');
            if ($('.list_result .domain').not('.loaded').length > 0) {
                check_domain();
            } else {

            }
        }

    });

}
function check_post(id) {
    $.ajax({
        url: "/admin/process.php",
        type: "post",
        data: {
            action: "check_post",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            if (info.ok == 1) {
                window.location.href = '/admin/add-sanpham?step=2&id=' + id
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $('.load_note').html(info.thongbao);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 2000);
            }

        }

    });
}
function check_link(loai) {
    link = $('.link_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link,
                loai: loai
            },
            success: function (kq) {
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

function check_blank(loai) {
    link = $('.tieude_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link,
                loai: loai
            },
            success: function (kq) {
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

function tuchoi(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admin/process.php",
        type: "post",
        data: {
            action: "tuchoi",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}

function confirm_success(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admin/process.php",
        type: "post",
        data: {
            action: "confirm_success",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function filename(path) {
    path = path.substring(path.lastIndexOf("/") + 1);
    return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
}
function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        callback(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}
function loadURLToInputField(url, id_input) {
    getImgURL(url, (imgBlob) => {
        // Load img blob to input
        fileName = filename(url) // should .replace(/[/\\?%*:|"<>]/g, '-') for remove special char like / \
        if (fileName.indexOf('.jpg') > -1) {
            file = new File([imgBlob], fileName, { type: "image/jpeg", lastModified: new Date().getTime() }, 'utf-8');
        } else if (fileName.indexOf('.jpeg') > -1) {
            file = new File([imgBlob], fileName, { type: "image/jpeg", lastModified: new Date().getTime() }, 'utf-8');
        } else if (fileName.indexOf('.png') > -1) {
            file = new File([imgBlob], fileName, { type: "image/png", lastModified: new Date().getTime() }, 'utf-8');
        } else {
            file = new File([imgBlob], fileName, { type: "image/jpeg", lastModified: new Date().getTime() }, 'utf-8');
        }
        container = new DataTransfer();
        container.items.add(file);
        document.querySelector(id_input).files = container.files;
    })
}
function copy_text(element) {
    $('#' + element).select();
    text = $('#' + element).val();
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
}
function copy_text_share(element, rut_gon, mobile) {
    if (rut_gon == 1) {
        link_rutgon = "\nXem chi tiết: " + $('input[name=rut_gon]').val();
    } else {
        link_rutgon = '';
    }
    if (mobile == 1) {
        dien_thoai = "\nLiên hệ ngay: " + $('input[name=mobile_share]').val();
    } else {
        dien_thoai = '';
    }
    $('#' + element).select();
    text = $('#' + element).val();
    text = text + '' + link_rutgon + '' + dien_thoai;
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
}
function confirm_del(action, loai, title, id) {
    $('#title_confirm').html(title);
    $('#button_thuchien').attr('action', action);
    $('#button_thuchien').attr('post_id', id);
    $('#button_thuchien').attr('loai', loai);
    $('#box_pop_confirm').show();
}

function confirm_action(action, title, id) {
    $('#box_pop_confirm_action .title_confirm').html(title);
    $('#button_thuchien_action').attr('action', action);
    $('#button_ok').attr('class', action);
    $('#button_thuchien_action').attr('post_id', id);
    $('#box_pop_confirm_action').show();
}

function confirm_action_domain(action, title, id) {
    $('#box_pop_confirm_action_domain .title_confirm').html(title);
    $('#box_pop_confirm_action_domain .title_confirm').html(title);
    $('#button_thuchien_action_domain').attr('action', action);
    $('#button_ok_domain').attr('class', action);
    $('#button_thuchien_action_domain').attr('post_id', id);
    $('#box_pop_confirm_action_domain').show();
}

function del(loai, id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admin/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    $('#tr_' + id).remove();
                } else {

                }
            }, 2000);
        }

    });
}

function huy(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admin/process.php",
        type: "post",
        data: {
            action: "huy",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
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
        c.split(/[,;]/).map(function (cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function ($0, $1) {
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
function format_price(num) {
    var p = num.toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
        return num + (num != "-" && i && !(i % 3) ? "," : "") + acc;
    }, "");
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
$(document).ready(function () {
    if (get_cookie('show_huongdan')) {
        /*        setTimeout(function(){
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: "load_pop_add",
                            loai:'show_vongquay'
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            if(info.ok==1){
                                $('.box_pop_add').html(info.html);
                                $('.box_pop_add').fadeIn();
                            }else{
                                
                            }
                        }
        
                    });
                },2000);*/
    } else {
        /*        if($('.add_donhang_drop').length>0){
                    setTimeout(function(){
                        $('.box_pop_add').show();
                        $('.box_pop_add').html('<div class="box_huongdan" style="display: block;height: 100px;left: 0;right: 0;bottom: 0;top: 0;width: 300px;"><div class="noidung_huongdan">Chào mừng bạn ghé thăm socdo.vn, nền tảng bán hàng đa kênh</div><div class="button_next"><button step="box_welcome">Tiếp theo</button></div></div>');
                    },3000);
                }else{
        
                }*/
    }
    ////////////
    $('body').on('change', '.list_shopcart select[name^=size]', function () {
        var row = $(this);
        sp_id = $(this).attr('sp_id');
        size = $(this).val();
        gia = $(this).find(":selected").attr('gia');
        gia = parseFloat(gia);
        so_luong = $(this).parent().parent().find('input[name=quantity]').val();
        so_luong = parseFloat(so_luong);
        thanhtien = gia * so_luong;
        $(this).parent().parent().find('.price').html('<span class="text_price">Giá: </span>' + format_price(gia) + '₫');
        $(this).parent().parent().find('.thanhtien').html('<span class="text_price">Giá: </span>' + format_price(thanhtien) + '₫');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "load_color",
                sp_id: sp_id,
                size: size
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    row.parent().parent().find('select[name^=color]').html(info.list);
                    pl = row.parent().parent().find('select[name^=color] option:selected').attr('pl');
                    color = row.parent().parent().find('select[name^=color] option:selected').val();
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: "update_pl",
                            sp_id: sp_id,
                            size: size,
                            color: color,
                            pl: pl,
                        },
                        success: function (kq) {
                        }

                    });

                } else {

                }
            }

        });
    });
    ////////////
    $('body').on('change', '.list_shopcart select[name^=color]', function () {
        sp_id = $(this).attr('sp_id');
        color = $(this).parent().parent().find('select[name^=color] option:selected').val();
        pl = $(this).parent().parent().find('select[name^=color] option:selected').attr('pl');
        size = $(this).parent().parent().find('select[name^=size] option:selected').val();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "update_pl",
                sp_id: sp_id,
                size: size,
                color: color,
                pl: pl,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
            }

        });
    });
    ////////////
    $('body').on('click', '.box_kichhoat .close', function () {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "close_kh",
            },
            success: function (kq) {
                $('.box_kichhoat').hide();
            }

        });
    });
    ////////////
    $('body').on('click', '.box_kichhoat #de_sau', function () {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "close_kh",
            },
            success: function (kq) {
                $('.box_kichhoat').hide();
            }

        });
    });
    ////////////
    $('body').on('click', '.box_kichhoat #nap_ngay', function () {
        $('.list_action').hide();
        $('.box_sotien').show();
    });
    /////////////////////////////
    $('body').on('click', 'button#add_naptien_step2', function () {
        var id = $(this).attr('id_nap');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "add_naptien_step2",
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_time').html(info.html);
                        var dulieu = {
                            'hd': 'add_naptien',
                            'id': id
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {

                    }
                }, 3000);
            }

        });
    });
    ////////////
    $('body').on('click', '.box_huongdan .button_next button', function (e) {
        step = $(this).attr('step');
        if ($('.add_donhang_drop_mobile').length > 0) {
            if (step == 'box_welcome') {
                $('.box_pop_add').hide();
                $('.box_pop_add').html('');
                $('html,body').stop().animate({ scrollTop: 150 }, 500, 'swing', function () { });
                first_buynow = $('.list_sanpham .buy_now').first();
                $('.load_overlay').show();
                $('.box_right_content .box_profile .box_timkiem').css({ "z-index": "99999" });
                $('.box_right_content .box_profile .box_timkiem .box_huongdan').css({ "display": "block", "top": "-105px" });

            } else if (step == 'box_timkiem') {
                $('.box_right_content .box_profile .box_timkiem').css({ "z-index": "999" });
                $('.box_right_content .box_profile .box_timkiem .box_huongdan').css({ "display": "none" });
                $('.box_sms_bottom').css({ "z-index": "99999" });
                $('.box_sms_bottom .box_huongdan').css({ "display": "block" });
            } else if (step == 'box_hotro') {
                $('.box_sms_bottom').css({ "z-index": "999" });
                $('.box_sms_bottom .box_huongdan').css({ "display": "none" });

                $('.add_cart_fixed').css({ "z-index": "99999" });
                $('.add_cart_fixed .box_huongdan').css({ "display": "block" });
            } else if (step == 'box_add_cart') {
                $('.add_cart_fixed').css({ "z-index": "999" });
                $('.add_cart_fixed .box_huongdan').css({ "display": "none" });
                var top_download = $('.list_sanpham .buy_now').first().offset().top;
                $('html,body').stop().animate({ scrollTop: top_download - 150 }, 500, 'swing', function () { });
                first_buynow = $('.list_sanpham .buy_now').first();
                first_buynow.prepend('<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để tạo ngay đơn hàng mới</div><div class="button_next"><button step="box_add_cart_new">Tiếp theo</button></div></div>');
                first_buynow.css({ "z-index": "99999", "position": "relative" });
                first_buynow.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "155px", "left": "unset", "right": "170px", "top": "0", "bottom": "0", "height": "115px", "font-size": "initial" });
                first_buynow.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == 'box_add_cart_new') {
                first_buynow = $('.list_sanpham .buy_now').first();
                first_buynow.css({ "z-index": "999" });
                first_buynow.find('.box_huongdan').remove();
                first_add_to_cart = $('.list_sanpham .add_to_cart').first();
                first_add_to_cart.prepend('<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào giỏ hàng</div><div class="button_next"><button step="box_to_cart">Tiếp theo</button></div></div>');
                first_add_to_cart.css({ "z-index": "99999", "position": "relative" });
                first_add_to_cart.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "155px", "left": "unset", "right": "170px", "top": "0", "bottom": "0", "height": "135px", "font-size": "initial" });
                first_add_to_cart.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                e.stopPropagation();

            } else if (step == 'box_to_cart') {
                first_add_to_cart = $('.list_sanpham .add_to_cart').first();
                first_add_to_cart.css({ "z-index": "999" });
                first_add_to_cart.find('.box_huongdan').remove();
                first_share_facebook = $('.list_sanpham .share_facebook').first();
                first_share_facebook.prepend('<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để đăng bán sản phẩm trên mạng xã hội: facebook, zalo...</div><div class="button_next"><button step="box_share_facebook">Tiếp theo</button></div></div>');
                first_share_facebook.css({ "z-index": "99999", "position": "relative", "overflow": "unset" });
                first_share_facebook.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "155px", "left": "unset", "right": "170px", "top": "0", "bottom": "0", "height": "160px", "font-size": "initial" });
                first_share_facebook.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == 'box_share_facebook') {
                first_share_facebook = $('.list_sanpham .share_facebook').first();
                first_share_facebook.css({ "z-index": "999" });
                first_share_facebook.find('.box_huongdan').remove();
                first_add_follow = $('.list_sanpham .add_follow').first();
                first_add_follow.prepend('<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào danh sách theo dõi...</div><div class="button_next"><button step="box_add_follow">Đã hiểu</button></div></div>');
                first_add_follow.css({ "z-index": "99999", "position": "relative", "overflow": "unset" });
                first_add_follow.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "155px", "left": "unset", "right": "170px", "top": "0", "bottom": "0", "height": "132px", "font-size": "initial" });
                first_add_follow.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                return false;
                e.stopPropagation();
            } else if (step == 'box_add_follow') {
                first_add_follow = $('.list_sanpham .add_follow').first();
                first_add_follow.css({ "z-index": "999" });
                first_add_follow.find('.box_huongdan').remove();
                $('.load_overlay').hide();
                setCookie('show_huongdan', 'ok', 3600);
            } else if (step == 'box_ketthuc') {
                box_left = $('.page_body .box_left');
                box_left.css({ "z-index": "999" });
                box_left.find('.box_huongdan').remove();
                $('.load_overlay').hide();
                setCookie('show_huongdan', 'ok', 3600);
            }
        } else {
            if (step == 'box_welcome') {
                $('.box_pop_add').hide();
                $('.box_pop_add').html('');
                $('.load_overlay').show();
                $('.box_right_content .box_profile .box_timkiem').css({ "z-index": "99999" });
                $('.box_right_content .box_profile .box_timkiem .box_huongdan').css({ "display": "block", "top": "-105px" });
            } else if (step == 'box_timkiem') {
                $('.box_right_content .box_profile .box_timkiem').css({ "z-index": "999" });
                $('.box_right_content .box_profile .box_timkiem .box_huongdan').css({ "display": "none" });
                $('.box_sms_bottom').css({ "z-index": "99999" });
                $('.box_sms_bottom .box_huongdan').css({ "display": "block" });
            } else if (step == 'box_hotro') {
                $('.box_sms_bottom').css({ "z-index": "999" });
                $('.box_sms_bottom .box_huongdan').css({ "display": "none" });

                $('.add_cart_fixed').css({ "z-index": "99999" });
                $('.add_cart_fixed .box_huongdan').css({ "display": "block" });
            } else if (step == 'box_add_cart') {
                $('.add_cart_fixed').css({ "z-index": "999" });
                $('.add_cart_fixed .box_huongdan').css({ "display": "none" });
                first_buynow = $('.list_baiviet .buy_now').first();
                first_buynow.prepend('<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để tạo ngay đơn hàng mới</div><div class="button_next"><button step="box_add_cart_new">Tiếp theo</button></div></div>');
                first_buynow.css({ "z-index": "99999", "position": "relative" });
                first_buynow.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "245px", "left": "unset", "right": "209px", "top": "0", "bottom": "0", "height": "90px" });
                first_buynow.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == 'box_add_cart_new') {
                first_buynow = $('.list_baiviet .buy_now').first();
                first_buynow.css({ "z-index": "999" });
                first_buynow.find('.box_huongdan').remove();
                first_add_to_cart = $('.list_baiviet .add_to_cart').first();
                first_add_to_cart.prepend('<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào giỏ hàng</div><div class="button_next"><button step="box_to_cart">Tiếp theo</button></div></div>');
                first_add_to_cart.css({ "z-index": "99999", "position": "relative" });
                first_add_to_cart.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "255px", "left": "unset", "right": "209px", "top": "0", "bottom": "0", "height": "90px" });
                first_add_to_cart.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                e.stopPropagation();

            } else if (step == 'box_to_cart') {
                first_add_to_cart = $('.list_baiviet .add_to_cart').first();
                first_add_to_cart.css({ "z-index": "999" });
                first_add_to_cart.find('.box_huongdan').remove();
                first_share_facebook = $('.list_baiviet .share_facebook').first();
                first_share_facebook.prepend('<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để đăng bán sản phẩm trên mạng xã hội: facebook, zalo...</div><div class="button_next"><button step="box_share_facebook">Tiếp theo</button></div></div>');
                first_share_facebook.css({ "z-index": "99999", "position": "relative", "overflow": "unset" });
                first_share_facebook.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "265px", "left": "unset", "right": "209px", "top": "0", "bottom": "0", "height": "115px", "font-size": "initial" });
                first_share_facebook.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == 'box_share_facebook') {
                first_share_facebook = $('.list_baiviet .share_facebook').first();
                first_share_facebook.css({ "z-index": "999" });
                first_share_facebook.find('.box_huongdan').remove();
                first_add_follow = $('.list_baiviet .add_follow').first();
                first_add_follow.prepend('<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào danh sách theo dõi...</div><div class="button_next"><button step="box_add_follow">Tiếp theo</button></div></div>');
                first_add_follow.css({ "z-index": "99999", "position": "relative", "overflow": "unset" });
                first_add_follow.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "250px", "left": "unset", "right": "209px", "top": "0", "bottom": "0", "height": "115px", "font-size": "initial" });
                first_add_follow.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                return false;
                e.stopPropagation();
            } else if (step == 'box_add_follow') {
                first_add_follow = $('.list_baiviet .add_follow').first();
                first_add_follow.css({ "z-index": "999" });
                first_add_follow.find('.box_huongdan').remove();

                box_left = $('.page_body .box_left');
                box_left.prepend('<div class="box_huongdan"><div class="muiten left"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Khu vực chức năng quản lý, thống kê, thêm mới, nạp tiền, rút tiền...</div><div class="button_next"><button step="box_ketthuc">Đã hiểu</button></div></div>');
                box_left.css({ "z-index": "99999", "overflow": "unset" });
                box_left.find('.box_huongdan').css({ "display": "block", "color": "#414141", "width": "275px", "right": "unset", "left": "280px", "top": "0", "bottom": "0", "height": "115px", "font-size": "initial" });
                box_left.find('.box_huongdan .muiten i').css({ "font-size": "35px" });
                return false;
                e.stopPropagation();
            } else if (step == 'box_ketthuc') {
                box_left = $('.page_body .box_left');
                box_left.css({ "z-index": "999" });
                box_left.find('.box_huongdan').remove();
                $('.load_overlay').hide();
                setCookie('show_huongdan', 'ok', 3600);
                $.ajax({
                    url: "/admin/process.php",
                    type: "post",
                    data: {
                        action: "load_pop_add",
                        loai: 'show_vongquay'
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        if (info.ok == 1) {
                            $('.box_pop_add').html(info.html);
                            $('.box_pop_add').show();
                        } else {

                        }
                    }

                });
            }
        }

    });
    setTimeout(function () {
        $('.marquee marquee').mouseout();
    }, 500)
    $('#sort_product').on('change', function () {
        var queryParams = new URLSearchParams(window.location.search);
        var sort = $(this).val();
        queryParams.set("sort", sort);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        url = removeURLParameter(url, 'page');
        queryParams.set("page", 1);
        window.location.href = url;
    });
    $('#timkiem_category').on('change', function () {
        var queryParams = new URLSearchParams(window.location.search);
        var cat = $(this).val();
        queryParams.set("cat", cat);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        url = removeURLParameter(url, 'page');
        queryParams.set("page", 1);
        window.location.href = url;
    });
    $('#timkiem_thuonghieu').on('change', function () {
        var queryParams = new URLSearchParams(window.location.search);
        var brand = $(this).val();
        queryParams.set("brand", brand);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        url = removeURLParameter(url, 'page');
        queryParams.set("page", 1);
        window.location.href = url;
    });
    $('#sort_link_affiliate').on('change', function () {
        sort = $(this).val();
        window.location.href = '/admin/add-donhang-drop?sort=' + sort;
    });
    if ($('#chon_kho').length > 0) {
        if (get_cookie('drop_kho')) {
            $('#chon_kho').val(get_cookie('drop_kho'));
        } else {

        }
    }
    if ($('#list_chat').length > 0) {
        setTimeout(function () {
            scrollSmoothToBottom('list_chat');
        }, 500);
    }
    ///////////////////////////
    $('body').on('keyup', '.input_nap', function () {
        sotien = $(this).val();
        if (sotien.length < 4) {
        } else {
            sotien = sotien.replace(/,/g, '');
            sotien = parseFloat(sotien, 2);
            $(this).val(format_price(sotien));
        }
    });
    ///////////////////////////
    link_hientai = window.location.pathname;
    a_menu = $('.main_menu').find('a[href="' + link_hientai + '"]');
    loai_a = a_menu.parent().attr('class');
    total_height = 0;
    var vitri = 0;
    $('.box_menu_left .main_menu a').each(function () {
        total_height += $(this).outerHeight();
        link_a = $(this).attr('href');
        if (link_a == link_hientai) {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
    if (loai_a == 'li_menu_sub_sub') {
        a_menu.parent().parent().addClass('active');
        a_menu.parent().parent().parent().find('.a_sub .right').html('<i class="fa fa-minus-square-o"></i>');
        a_menu.parent().parent().parent().parent().addClass('active');
        a_menu.parent().parent().parent().parent().parent().find('.a_main .right').html('<i class="fa fa-minus-square-o"></i>');
    } else if (loai_a == 'li_menu_sub') {
        a_menu.parent().parent().addClass('active');
        a_menu.parent().parent().parent().find('.a_main .right').html('<i class="fa fa-minus-square-o"></i>');
    }
    ///////////////////////////
    $('body').on('click', '.add_follow', function () {
        var $btn = $(this);
        var sp_id = $btn.attr('sp_id');
        var isAdd = $btn.find('.fa-square-o').length > 0;
        var loai = isAdd ? 'add' : 'remove';
        
        // Xác định thông báo và CSS cho thông báo dựa trên hành động
        var message, thongBaoCSS;
        if (loai === 'add') {
            message = 'Đã thêm Yêu thích <i class="fa fa-check"></i>';
            thongBaoCSS = {
                'background-color': '#28a745', // màu nền xanh cho thêm yêu thích
                'border': '1px solid #28a745'
            };
        } else {
            message = 'Đã bỏ yêu thích <i class="fa fa-times"></i>';
            thongBaoCSS = {
                'background-color': '#dc3545', // màu nền đỏ cho bỏ yêu thích
                'border': '1px solid #dc3545'
            };
        }
        
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            dataType: "json",
            data: {
                action: 'update_follow',
                sp_id: sp_id,
                loai: loai
            },
            success: function (response) {
                // Cập nhật số lượng sản phẩm follow
                $('.total_quantam').text(response.total_follow);
                // Cập nhật thông báo với message và áp dụng CSS mới
                $('.thongbao_add_follow')
                    .html(message)
                    .css(thongBaoCSS)
                    .addClass('show');
                
                setTimeout(function () {
                    $('.thongbao_add_follow').removeClass('show');
                }, 2000);
            }
        });
    });
    
    ///////////////////////////
    $('body').on('click', '.menu_top .menu_top_right .notification .tab_notification .li_tab', function () {
        $('.tab_notification .li_tab').removeClass('active');
        $(this).addClass('active');
        tab = $('.tab_notification .li_tab.active').attr('id');
        if (tab == 'tab_all') {
            loai = 'all';
        } else {
            loai = 'chuadoc';
        }
        $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_notification',
                loai: loai,
                page: 1
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.list_notification .list_noti .loading_notification').remove();
                    $('.list_notification .list_noti').append(info.list);
                    $('.list_notification .list_noti').attr('page', info.page);
                    $('.list_notification .list_noti').attr('tiep', info.tiep);
                    $('.list_notification .list_noti').attr('loaded', 1);
                }, 1000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '.menu_top .menu_top_right .notification .icon_notification', function () {
        $('.list_notification').toggleClass('active');
        tab = $('.tab_notification .li_tab.active').attr('id');
        if (tab == 'tab_all') {
            loai = 'all';
        } else {
            loai = 'chuadoc';
        }
        if ($('.list_notification').hasClass('active')) {
            $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'load_notification',
                    loai: loai,
                    page: 1
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.list_notification .list_noti .loading_notification').remove();
                        $('.list_notification .list_noti').append(info.list);
                        $('.list_notification .list_noti').attr('page', info.page);
                        $('.list_notification .list_noti').attr('tiep', info.tiep);
                        $('.list_notification .list_noti').attr('loaded', 1);
                    }, 1000);
                }
            });
        } else {
        }
    });
    ////////////////////////
    $('.list_notification .list_noti').on('scroll', function () {
        tab = $('.tab_notification .li_tab.active').attr('id');
        if (tab == 'tab_all') {
            loai = 'all';
        } else {
            loai = 'chuadoc';
        }
        div_notification = $('.list_notification .list_noti');
        if (div_notification.scrollTop() + div_notification.innerHeight() >= div_notification[0].scrollHeight - 10) {
            tiep = $('.list_notification .list_noti').attr('tiep');
            page = $('.list_notification .list_noti').attr('page');
            loaded = $('.list_notification .list_noti').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('.list_notification .list_noti').prepend('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_notification .list_noti').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'load_notification',
                            loai: 'all',
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.list_notification .list_noti .loading_notification').remove();
                            $('.list_notification .list_noti').append(info.list);
                            $('.list_notification .list_noti').attr('page', info.page);
                            $('.list_notification .list_noti').attr('tiep', info.tiep);
                            $('.list_notification .list_noti').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
    })
    ///////////////////////////
    // $('body').on('click','#xacnhan_kichhoat',function(){
    //     sotien=$('.box_sotien input[name=so_tien]').val();
    //     if(sotien==''){
    //         $('.box_sotien input[name=so_tien]').focus();
    //     }else{
    //         $('.box_xuly').html('<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...');
    //         $.ajax({
    //             url: "/admin/process.php",
    //             type: "post",
    //             data: {
    //                 action: 'xacnhan_kichhoat',
    //                 sotien:sotien
    //             },
    //             success: function(kq) {
    //                 var info = JSON.parse(kq);
    //                 setTimeout(function(){
    //                     if(info.ok==0){
    //                         $('.box_xuly').html(info.thongbao);
    //                     }else{
    //                         $('.title_note').remove();
    //                         $('.box_sotien').remove();
    //                         $('.box_thongbao').remove();
    //                         $('#xacnhan_kichhoat').remove();
    //                         $('#sudung_sodu').remove();
    //                         $('#text_note').html('Chuyển khoản để hoàn thành giao dịch');
    //                         $('.box_xuly').html(info.step2);
    //                     }
    //                 },2000);
    //             }
    //         });
    //     }
    // });

    ///////////////////////////

    //  $('body').on('click','#sudung_sodu',function(){

    //         $('.box_xuly').html('<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...');
    //         $.ajax({
    //             url: "/admin/process.php",
    //             type: "post",
    //             data: {
    //                 action: 'sudung_sodu',
    //             },
    //             success: function(kq) {
    //                 // console.log("Kết quả trả về: ", kq); 
    //                 var info = JSON.parse(kq);
    //                 setTimeout(function(){
    //                     if(info.ok == 0){
    //                         $('.box_xuly').html(info.thongbao);
    //                         // Reload lại trang khi thành công
    //                         setTimeout(function(){
    //                             location.reload(); // Tự động reload trang
    //                         }, 2000); // Chờ 2 giây trước khi reload

    //                     }else {
    //                         $('.title_note').remove();
    //                         $('.box_sotien').remove();
    //                         $('.box_thongbao').remove();
    //                         $('#xacnhan_kichhoat').remove();
    //                         $('#sudung_sodu').remove();
    //                         $('#text_note').html('Chuyển khoản để hoàn thành giao dịch');
    //                         $('.box_xuly').html(info.step2);
    //                     }
    //                 },2000);
    //             }
    //         });

    // });
    $('body').on('click', '#sudung_sodu', function () {
        $('.box_xuly').html('<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'sudung_sodu',
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    switch (info.ok) {
                        case 0: // Thành công
                            // Hiển thị thông báo thành công
                            $('.box_xuly').html(info.thongbao);

                            // Cập nhật ô trạng thái
                            $('#status_button').html(
                                '<button id="status_button" style="color: #ffffff; display: block; margin-bottom: 5px;"><p style="text-align: center; margin: 0;">Bạn đã là thành viên chính thức</p></button>'
                            );

                            // (Tùy chọn) Tải lại trang sau 2 giây
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                            break;

                        case 1: // Cần nạp thêm tiền
                            $('.title_note').remove();
                            $('.box_sotien').remove();
                            $('.box_thongbao').remove();
                            $('.sudung_sodu').remove();
                            $('#xacnhan_kichhoat').remove();
                            $('#sudung_sodu').remove();
                            $('#text_note').html('Chuyển khoản để hoàn thành giao dịch');
                            $('.box_xuly').html(info.step2);
                            break;

                        case 2: // Lỗi xử lý
                            $('.box_xuly').html(info.thongbao);
                            break;

                        default:
                            $('.box_xuly').html('Có lỗi không xác định xảy ra');
                    }
                }, 2000);
            },
            error: function () {
                $('.box_xuly').html('Lỗi kết nối đến máy chủ');
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '#datlich_hotro', function () {
        thoi_gian = $('#pop_hotro input[name=thoi_gian]').val();
        $('#pop_hotro').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'datlich_hotro',
                thoi_gian: thoi_gian
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }
        });

    });
    //
    ///////////////////////////
    $('body').on('click', '.copy_aff', function () {
        var input = $(this);
        element = $(this).parent().find('input').attr('id');
        copy_text(element);
        $(this).html('Đã copy');
        setTimeout(function () {
            input.html('<i class="icofont-ui-copy"></i> copy');

        }, 5000);

    });
    ///////////////////////////
    $('body').on('click', '.copy_rutgon_aff', function () {
        var input = $(this);
        element = $(this).parent().find('input').attr('id');
        copy_text(element);
        $(this).html('Đã copy');
        setTimeout(function () {
            input.html('<i class="icofont-ui-copy"></i> copy');

        }, 5000);

    });
    ///////////////////////////
    $('body').on('click', '.rutgon_link_drop', function () {
        var button = $(this);
        link = $(this).parent().parent().find('input[name=link_aff]').val();
        sp_id = $(this).attr('sp_id');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'rut_gon',
                sp_id: sp_id,
                link: link
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        button.parent().parent().find('.input_rutgon').html(info.html);
                    }
                }, 3000);
            }
        });


    });
    ///////////////////////////
    $('body').on('click', '.rutgon_link', function () {
        var button = $(this);
        link = $(this).parent().find('input').val();
        sp_id = $(this).attr('sp_id');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'rut_gon',
                sp_id: sp_id,
                link: link
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        button.parent().parent().find('.input_rutgon').html(info.html);
                    }
                }, 3000);
            }
        });


    });
    ///////////////////////////
    $('body').on('click', '.page_body .box_left .box_menu_left .box_left_content .main_menu .list_menu .li_menu .a_main', function () {
        $(this).parent().find('.list_menu_sub').toggleClass('active');
        if ($(this).find('.right i').hasClass('fa-plus-square-o')) {
            $(this).find('.right i').removeClass('fa-plus-square-o');
            $(this).find('.right i').addClass('fa-minus-square-o');
        } else {
            $(this).find('.right i').addClass('fa-plus-square-o');
            $(this).find('.right i').removeClass('fa-minus-square-o');
        }
    });
    ///////////////////////////
    $('body').on('click', '.page_body .box_left .box_menu_left .box_left_content .main_menu .list_menu .li_menu .list_menu_sub .li_menu_sub .a_sub', function () {
        $(this).parent().find('.list_menu_sub_sub').toggleClass('active');
        if ($(this).find('.right i').hasClass('fa-plus-square-o')) {
            $(this).find('.right i').removeClass('fa-plus-square-o');
            $(this).find('.right i').addClass('fa-minus-square-o');
        } else {
            $(this).find('.right i').addClass('fa-plus-square-o');
            $(this).find('.right i').removeClass('fa-minus-square-o');
        }
    });
    $('#chon_kho').on('change', function () {
        kho = $(this).val();
        if (kho == 'kho_hcm') {
            $('.pagination').hide();
            $('.load_sanpham').hide();
            $('.load_overlay').show();
            tr = $('body .list_baiviet tr').first().html();
            td_lengt = $('body .list_baiviet tr').first().children('th').length;
            $('body .list_baiviet').html('<tr>' + tr + '</tr><tr><td colspan="' + td_lengt + '" align="center">Dữ liệu đang cập nhật...</td></tr>');

            $('.load_process').fadeIn();
            $('.load_note').html('Dữ liệu đang cập nhật');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else {
            create_cookie('drop_kho', kho, 365, '/');
            window.location.reload();
        }
    });
    setTimeout(function () {
        $('.loadpage').fadeOut();
        $('.page_body').fadeIn();
    }, 300);
    ////////////////////////////
    $('body').on('click', '.box_pop_add .pop_title .fa-close', function () {
        $('.box_pop_add').html('');
        $('.box_pop_add').hide();
    });
    ////////////////////////////
    $('body').on('click', '.box_pop_add .cancel_leader', function () {
        $('.box_pop_add').html('');
        $('.box_pop_add').hide();
    });
    ////////////////////////////
    $('body').on('click', '.hide_pop_thirth', function () {
        $('.pop_thirth').html('');
        $('.pop_thirth').hide();
        if ($('.box_pop_add .pop_second').length < 1) {
            $('.box_pop_add').html('');
            $('.box_pop_add').hide();
        } else {

        }
    });
    ///////////////////
    setTimeout(function () {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "get_total_cart"
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.total_ct_shop').html(info.total);
                $('.total_notification').html(info.total_noti);
                $('.total_ct_tuan').html(info.total_tuan);
                $('.total_hethang').html(info.total_hethang);
                $('.total_catma').html(info.total_catma);
                $('.total_thongbao').html(info.total_thongbao);
                $('.total_chat').html(info.total_chat);
                $('.total_follow').html(info.total_follow);
            }

        });

    }, 2000);
    ///////////////////
    $('body').on('click', '.info_thuonghieu .menu_thuonghieu span', function () {
        $('.info_thuonghieu').hide();
        window.location.reload();
        /*        if($('.list_thuonghieu.add_sanpham').length>0){
                    kieu=$('.button_timkiem').attr('kieu');
                    $('.load_sanpham').show();
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: "reload_sanpham",
                            page: page,
                            kieu:kieu
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.load_sanpham button').html('Tải thêm');
                            $('.load_sanpham button').attr('page', info.page);
                            if(info.kieu=='mobile'){
                                $('.list_sanpham').append(info.list);
                            }else{
                                $('.list_baiviet tr:last').after(info.list);
        
                            }
                            if (info.list == null) {
                                $('.load_sanpham button').hide();
                            }
                        }
        
                    });
                }else if($('.list_thuonghieu.add_donhang_drop').length>0){
                    loai='add_donhang_drop';
                    kieu=$('.button_timkiem').attr('kieu');
                    $('.pagination').show();
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'reload_sanpham_drop',
                            kieu:kieu,
                            loai:loai
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            setTimeout(function() {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                                if(info.kieu=='mobile'){
                                    $('.list_sanpham').html(info.list);
                                }else{
                                    $('.list_baiviet').html(info.list);
                                }
                            }, 1000);
                        }
                    });
                }else if($('.list_thuonghieu.list_link_affiliate').length>0){
                    loai='list_link_affiliate';
                    kieu=$('.button_timkiem').attr('kieu');
                    $('.pagination').show();
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'reload_list_link_affiliate',
                            kieu:kieu,
                            loai:loai
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            setTimeout(function() {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                                if(info.kieu=='mobile'){
                                    $('.list_sanpham').html(info.list);
                                }else{
                                    $('.list_baiviet').html(info.list);
                                }
                            }, 1000);
                        }
                    });
                }*/
    });
    ///////////////////
    $('body').on('click', '.list_thuonghieu.list_link_affiliate .li_thuonghieu', function () {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        thuong_hieu = $(this).attr('thuong_hieu');
        loai = 'list_link_affiliate';
        kieu = $('.button_timkiem').attr('kieu');
        $('.pagination').hide();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_info_thuonghieu',
                thuong_hieu: thuong_hieu,
                kieu: kieu,
                loai: loai
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.kieu == 'mobile') {
                        $('.list_sanpham').html(info.list);
                    } else {
                        $('.list_baiviet').html(info.list);
                    }
                    $('.load_sanpham').hide();
                    $('.info_thuonghieu').css('display', 'flex');
                    $('.info_thuonghieu .cover_thuonghieu img').attr('src', info.cover);
                    $('.info_thuonghieu .noidung_thuonghieu').html(info.noi_dung);
                }, 1000);
            }
        });
    });
    ///////////////////
    $('body').on('click', '.list_thuonghieu.add_donhang_drop .li_thuonghieu', function () {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        thuong_hieu = $(this).attr('thuong_hieu');
        loai = 'add_donhang_drop';
        kieu = $('.button_timkiem').attr('kieu');
        $('.pagination').hide();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_info_thuonghieu',
                thuong_hieu: thuong_hieu,
                kieu: kieu,
                loai: loai
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.kieu == 'mobile') {
                        $('.list_sanpham').html(info.list);
                    } else {
                        $('.list_baiviet').html(info.list);
                    }
                    $('.load_sanpham').hide();
                    $('.info_thuonghieu').css('display', 'flex');
                    $('.info_thuonghieu .cover_thuonghieu img').attr('src', info.cover);
                    $('.info_thuonghieu .noidung_thuonghieu').html(info.noi_dung);
                }, 1000);
            }
        });
    });
    ///////////////////
    $('body').on('click', '.list_thuonghieu.add_sanpham .li_thuonghieu', function () {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        thuong_hieu = $(this).attr('thuong_hieu');
        loai = 'add_sanpham';
        kieu = $('.button_timkiem').attr('kieu');
        $('.pagination').hide();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_info_thuonghieu',
                thuong_hieu: thuong_hieu,
                kieu: kieu,
                loai: loai
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.kieu == 'mobile') {
                        $('.list_sanpham').html(info.list);
                    } else {
                        $('.list_baiviet').html(info.list);
                    }
                    $('.load_sanpham').hide();
                    $('.info_thuonghieu').css('display', 'flex');
                    $('.info_thuonghieu .cover_thuonghieu img').attr('src', info.cover);
                    $('.info_thuonghieu .noidung_thuonghieu').html(info.noi_dung);
                }, 1000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_yeucau .box_search #show_add_hotro', function () {
        thanh_vien = $(this).attr('thanhvien');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_box_pop_thirth',
                thanh_vien: thanh_vien,
                loai: 'add_yeucau_lienhe'
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html('<div class="pop_thirth"></div>');
                $('.pop_thirth').html(info.html);
                $('.pop_thirth').fadeIn();
                $('.box_pop_add').show();
                $('.box_yeucau .box_search input').val('');
                $('.box_yeucau .box_search .goi_y').html('');
                $('.box_yeucau .box_search .goi_y').hide();
            }
        });
    });

    /////////////////////////////
    $('body').on('click', '.pop_add_lienhe #gui_ykien', function () {
        var noi_dung = $('.pop_add_lienhe textarea[name=noi_dung]').val();
        var quy_trinh = $('.pop_add_lienhe select[name=quy_trinh]').val();
        var user_out = $('.box_chat input[name=user_out]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'add_yeucau_traodoi',
                quy_trinh: quy_trinh,
                noi_dung: noi_dung,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#list_yeucau .li_yeucau').removeClass('active');
                        $('#list_yeucau').prepend(info.list);
                        $('.box_yeucau_hotro #ten_khach').html(info.ho_ten);
                        $('.box_yeucau_hotro #submit_yeucau').attr('phien', info.phien_traodoi);
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', false);
                        $('.box_yeucau_hotro #list_chat').html('');
                        $('.box_yeucau_hotro .note_content .txt').html(noi_dung);
                        $('.box_pop_add').hide();
                        $('.box_pop_add').html('');
                        setTimeout(function () {
                            var top_dong = $('.bottom_chat').offset().top;
                            $('html,body').stop().animate({ scrollTop: top_dong - 150 }, 500, 'swing', function () {
                            });
                        }, 500);
                        var dulieu = {
                            'user_out': user_out,
                            'thanh_vien': info.thanh_vien,
                            'bo_phan': info.bo_phan
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_list_yeucau', info_chat);
                    } else {

                    }
                }, 2000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_yeucau_hotro .box_yeucau .list_yeucau .list .li_yeucau', function () {
        var phien = $(this).attr('phien');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_khach_traodoi',
                phien: phien
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_yeucau').html(info.list);
                    $('.box_yeucau_hotro #submit_yeucau').attr('phien', info.phien);
                    $('.box_yeucau_hotro #list_chat').html(info.list_chat);
                    $('.box_yeucau_hotro .note_content .txt').html(info.note);
                    $('input[name=load_chat]').val(info.load_chat);
                    scrollSmoothToBottom('list_chat');
                    if (info.active == 1) {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', false);
                    } else {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', true);
                    }
                } else {

                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_chat #submit_yeucau', function () {
        var phien = $(this).attr('phien');
        var noi_dung = $('.box_chat input[name=noidung_yeucau]').val();
        var user_out = $('.box_chat input[name=user_out]').val();
        if ($('#list_chat .txt').length > 0) {
            sms_id = $('#list_chat .li_sms').last().attr('sms_id');
        } else {
            sms_id = 0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'add_sms_traodoi',
                phien: phien,
                noi_dung: noi_dung,
                sms_id: sms_id
            },
            success: function (kq) {
                $('.box_chat input[name=noidung_yeucau]').val('');
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu = {
                        "list_out": info.list_out,
                        'list': info.list,
                        'phien': phien,
                        'loai': 'thanh_vien',
                        'user_out': info.user_out,
                        'bo_phan': info.bo_phan,
                        'thanh_vien': user_out
                    }
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi', info_chat);
                } else {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý...');
                        $('.load_overlay').hide();
                    }, 2000);
                }
            }
        });

    });
    $('body').on('keypress', '.box_chat input[name=noidung_yeucau]', function (e) {
        if (e.which == 13) {
            var phien = $('.box_chat #submit_yeucau').attr('phien');
            var noi_dung = $('.box_chat input[name=noidung_yeucau]').val();
            var user_out = $('.box_chat input[name=user_out]').val();
            if ($('#list_chat .txt').length > 0) {
                sms_id = $('#list_chat .li_sms').last().attr('sms_id');
            } else {
                sms_id = 0;
            }
            $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
            $('.box_chat .text_status .loading_chat').show();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'add_sms_traodoi',
                    phien: phien,
                    noi_dung: noi_dung,
                    sms_id: sms_id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.box_chat .text_status .loading_chat').hide();
                    $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                    $('.box_chat input[name=noidung_yeucau]').val('');
                    if (info.ok == 1) {
                        $('#list_chat').append(info.list);
                        scrollSmoothToBottom('list_chat');
                        var dulieu = {
                            "list_out": info.list_out,
                            'list': info.list,
                            'phien': phien,
                            'loai': 'thanh_vien',
                            'bo_phan': info.bo_phan,
                            'user_out': info.user_out,
                            'thanh_vien': user_out
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_traodoi', info_chat);
                    } else {
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        $('.load_note').html(info.thongbao);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý...');
                            $('.load_overlay').hide();
                        }, 2000);
                    }
                }
            });
        } else {
        }
    });
    $('body').on('click', '.box_sticker .li_sticker img', function (e) {
        $('.box_sticker').hide();
        var phien = $('.box_chat #submit_yeucau').attr('phien');
        var src = $(this).attr('src');
        var user_out = $('.box_chat input[name=user_out]').val();
        if ($('#list_chat .txt').length > 0) {
            sms_id = $('#list_chat .li_sms').last().attr('sms_id');
        } else {
            sms_id = 0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'add_sticker_traodoi',
                phien: phien,
                src: src,
                sms_id: sms_id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                $('.box_chat input[name=noidung_yeucau]').val('');
                if (info.ok == 1) {
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu = {
                        "list_out": info.list_out,
                        'list': info.list,
                        'phien': phien,
                        'loai': 'thanh_vien',
                        'user_out': info.user_out,
                        'thanh_vien': user_out,
                        'bo_phan': info.bo_phan
                    }
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi', info_chat);
                } else {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý...');
                        $('.load_overlay').hide();
                    }, 2000);
                }
            }
        });
    });
    //////////////////////////
    var lastScrollTop = 0;
    $('#list_chat').scroll(function () {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {

        } else {
            load = $('input[name=load_chat]').val();
            loaded = $('input[name=load_chat]').attr('loaded');
            sms_id = $('#list_chat .li_sms').first().attr('sms_id');
            var phien = $('.box_chat #submit_yeucau').attr('phien');
            if (st < 50 && loaded == 1 && load == 1) {
                $('#list_chat').prepend('<div class="li_load_chat"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
                $('input[name=load_chat]').attr('loaded', '0');
                setTimeout(function () {
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: "load_chat_sms",
                            phien: phien,
                            sms_id: sms_id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_chat .li_load_chat').remove();
                            $('input[name=load_chat]').val(info.load_chat);
                            $('input[name=load_chat]').attr('loaded', '1');
                            if (info.ok == 1) {
                                $('#list_chat').prepend(info.list_chat);
                                total_height = 0;
                                $('#list_chat .li_sms').each(function () {
                                    if ($(this).attr('sms_id') < sms_id) {
                                        total_height += $(this).outerHeight();
                                    }
                                });
                                $('#list_chat').animate({
                                    scrollTop: total_height - 50
                                }, 200);
                            } else {
                            }
                        }
                    });
                }, 3000);
            } else {

            }
        }
        lastScrollTop = st;

    });
    /////////////////////////////
    socket.on("server_send_traodoi", function (data) {
        user_out = $('.box_chat input[name=user_out]').val();
        thanhvien_chat = $('input[name=thanhvien_chat]').val();
        phien = $('#submit_yeucau').attr('phien');
        var info = JSON.parse(data);
        if (thanhvien_chat == info.user_out) {
        } else {
            if (thanhvien_chat == info.thanh_vien) {
                $('#play_chat').click();
            }
            if (phien == info.phien) {
                $('#list_chat').append(info.list_out);
                scrollSmoothToBottom('list_chat');
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_hoatdong", function (data) {
        var info = JSON.parse(data);
        bo_phan = $('input[name=bophan_hotro]').val();
        if (info.hd == 'user_notification') {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'load_tk_notification',
                    bo_phan: bo_phan
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#play_chat_global').click();
                    $('.total_notification').html(info.total_notification);
                }
            });
        }
    });
    /////////////////////////////
    socket.on("server_send_list_yeucau", function (data) {
        phien = $('#submit_yeucau').attr('phien');
        user_out = $('.box_chat input[name=user_out]').val();
        var info = JSON.parse(data);
        if (user_out == info.user_out || user_out != info.thanh_vien) {
        } else {
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_list_yeucau',
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#list_yeucau').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    socket.on("server_send_dong_yeucau", function (data) {
        phien = $('#submit_yeucau').attr('phien');
        user_out = $('.box_chat input[name=user_out]').val();
        var info = JSON.parse(data);
        if (user_out == info.user_out || user_out != info.thanh_vien) {
        } else {
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_list_yeucau',
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#list_yeucau').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.box_chat #dong_yeucau', function () {
        phien = $('.box_chat #submit_yeucau').attr('phien');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'dong_yeucau',
                phien: phien
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', true);
                        var dulieu = {
                            'user_out': info.user_out,
                            'thanh_vien': info.thanh_vien,
                            'phien': info.phien,
                            'bo_phan': info.bo_phan
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_dong_yeucau', info_chat);
                    }
                }, 3000);
            }
        });
    });
    ///////////////////
    $('.box_pop_xemtruoc .xemtruoc_title .fa').on('click', function () {
        $('.box_pop_xemtruoc').hide();
        $('.box_pop_xemtruoc .noidung_xemtruoc .trich').html('');
        $('.box_pop_xemtruoc .noidung_xemtruoc .minh_hoa').html('');
        $('.box_pop_xemtruoc .noidung_xemtruoc #textarea_1').val('');
    });
    ///////////////////
    $('.box_select_product .box_title .fa').on('click', function () {
        $('.box_select_product').hide();
        $('.box_select_product .box_list').html('');
        $('.box_select_product .box_list').attr('page', 1);
        $('input[name=key_deal]').val('');
    });
    ///////////////////
    $('.preview_button').on('click', function () {
        noidung_id = $(this).attr('noidung_id');
        minh_hoa = $(this).attr('minh_hoa');
        minh_hoa = 'https://socdo.vn' + minh_hoa;
        noidung = $('#textarea_' + noidung_id).val();
        $('.box_pop_xemtruoc .list_button .copy_button').html('<i class="fa fa-copy"></i> Sao chép');
        $('.box_pop_xemtruoc .noidung_xemtruoc').html(noidung.replace(/\n/g, "<br />"));
        $('.box_pop_xemtruoc .list_button .share_button').attr('noidung_id', noidung_id);
        $('.box_pop_xemtruoc .list_button .share_button').attr('minh_hoa', minh_hoa);
        $('.box_pop_xemtruoc .list_button .copy_button').attr('noidung_id', noidung_id);
        $('.box_pop_xemtruoc .list_button .copy_button').attr('minh_hoa', minh_hoa);
        $('.box_pop_xemtruoc').show();
    });
    ///////////////////
    $('.share_button_laptop').on('click', function () {
        noidung_id = $(this).attr('noidung_id');
        var bt_active = $(this);
        copy_text('textarea_' + noidung_id);
        $(this).html('<i class="fa fa-copy"></i> Đã sao chép');
        setTimeout(function () {
            bt_active.html('<i class="fa fa-copy"></i> Ssao chép');
        }, 2000)
    });
    ///////////////////
    $('.copy_button').on('click', function () {
        noidung_id = $(this).attr('noidung_id');
        copy_text('textarea_' + noidung_id);
        $('.box_pop_xemtruoc .list_button .copy_button').html('<i class="fa fa-copy"></i> Đã sao chép');
    });
    //////////////////////////
    $('.share_nhiemvu_button').on('click', function () {
        noidung_id = 1;
        rut_gon = 0;
        mobile = 0;
        copy_text_share('textarea_1', rut_gon, mobile);
        i = 0;
        $('#list_anh_1 img,#list_anh_1 video').each(function () {
            $('.list_input').append('<input type="file" style="display:none;" id="input_' + i + '" name="file[]" multiple="multiple" />');
            src = $(this).attr('src');
            ten_file = filename(src);
            loadURLToInputField(src, '#input_' + i);
            console.log(src);
            i++;
        });
        $('#submit_nhiemvu_button').click();
    });
    //////////////////////////
    $('#submit_nhiemvu_button').on('click', function () {
        var file_store = [];
        var i = 0;
        $("input[name^=file]").each(function () {
            file_store.push.apply(file_store, $(this)[0].files);
        });
        total_file = file_store.length;
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        noi_dung = $('#textarea_1').val();
        if (file_store.length > 0) {
            $('.load_overlay').hide();
            $('.load_process').hide();
            if (navigator.share) {
                navigator.share({
                    title: 'Chia sẻ nhiệm vụ trên mạng xã hội',
                    text: $('#textarea_1').val(),
                    files: file_store,
                })
                    .then(() => file_store = [])
                    .catch((error) => console.log('Error sharing', error));
            } else {
                console.log('Không hỗ trợ trên trình duyệt này.');
            }
        } else {
            setTimeout(function () {
                $("input[name^=file]").each(function () {
                    file_store.push.apply(file_store, $(this)[0].files);
                });
                total_file = file_store.length;
                if (file_store.length > 0) {
                    $('.load_overlay').hide();
                    $('.load_process').hide();
                    if (navigator.share) {
                        navigator.share({
                            title: 'Chia sẻ nhiệm vụ trên mạng xã hội',
                            text: $('#textarea_1').val(),
                            files: file_store,
                        })
                            .then(() => file_store = [])
                            .catch((error) => console.log('Error sharing', error));
                    } else {
                        console.log('Không hỗ trợ trên trình duyệt này.');
                    }
                } else {
                    $("input[name^=file]").each(function () {
                        file_store.push.apply(file_store, $(this)[0].files);
                    });
                    total_file = file_store.length;
                    if (file_store.length > 0) {
                        if (navigator.share) {
                            navigator.share({
                                title: 'Chia sẻ nhiệm vụ trên mạng xã hội',
                                text: $('#textarea_1').val(),
                                files: file_store,
                            })
                                .then(() => file_store = [])
                                .catch((error) => console.log('Error sharing', error));
                        } else {
                            console.log('Không hỗ trợ trên trình duyệt này.');
                        }
                    } else {
                        console.log('Không thể chia sẻ');
                    }
                }
            }, 3000);
        }
    });
    //////////////////////////
    $('.share_button').on('click', function () {
        //$('input[name^=file]').remove();
        minh_hoa = $(this).attr('minh_hoa');
        minh_hoa = 'https://socdo.vn' + minh_hoa;
        noidung_id = $(this).attr('noidung_id');
        if ($('input[name=rut_gon]').is(':checked')) {
            rut_gon = 1;
        } else {
            rut_gon = 0;
        }
        if ($('input[name=mobile_share]').is(':checked')) {
            mobile = 1;
        } else {
            mobile = 0;
        }
        copy_text_share('textarea_' + noidung_id, rut_gon, mobile);
        i = 0;
        $('#list_anh_' + noidung_id + ' img,#list_anh_' + noidung_id + ' video').each(function () {
            $('.box_pop_xemtruoc').before('<input type="file" style="display:none;" id="input_' + i + '" name="file[]" multiple="multiple" />');
            src = $(this).attr('src');
            ten_file = filename(src);
            loadURLToInputField(src, '#input_' + i);
            console.log(src);
            i++;
        });
        $('#submit_button').click();
    });
    //////////////////////////
    $('#submit_button').on('click', function () {
        var file_store = [];
        var i = 0;
        $("input[name^=file]").each(function () {
            file_store.push.apply(file_store, $(this)[0].files);
        });
        total_file = file_store.length;
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        noi_dung = $('#textarea_' + noidung_id).val();
        if ($('input[name=rut_gon]').is(':checked')) {
            link_rutgon = "\nXem chi tiết: " + $('input[name=rut_gon]').val();
        } else {
            link_rutgon = '';
        }
        if ($('input[name=mobile_share]').is(':checked')) {
            mobile_share = "\nLiên hệ ngay: " + $('input[name=mobile_share]').val();
        } else {
            mobile_share = '';
        }
        noi_dung = noi_dung + '' + link_rutgon + '' + mobile_share;
        if (file_store.length > 0) {
            $('.load_overlay').hide();
            $('.load_process').hide();
            if (navigator.share) {
                navigator.share({
                    title: 'Bán hàng trên mạng xã hội',
                    text: $('#textarea_' + noidung_id).val(),
                    files: file_store,
                })
                    .then(() => file_store = [])
                    .catch((error) => console.log('Error sharing', error));
            } else {
                console.log('Không hỗ trợ trên trình duyệt này.');
            }
        } else {
            setTimeout(function () {
                $("input[name^=file]").each(function () {
                    file_store.push.apply(file_store, $(this)[0].files);
                });
                total_file = file_store.length;
                if (file_store.length > 0) {
                    $('.load_overlay').hide();
                    $('.load_process').hide();
                    if (navigator.share) {
                        navigator.share({
                            title: 'Bán hàng trên mạng xã hội',
                            text: $('#textarea_' + noidung_id).val(),
                            files: file_store,
                        })
                            .then(() => file_store = [])
                            .catch((error) => console.log('Error sharing', error));
                    } else {
                        console.log('Không hỗ trợ trên trình duyệt này.');
                    }
                } else {
                    $("input[name^=file]").each(function () {
                        file_store.push.apply(file_store, $(this)[0].files);
                    });
                    total_file = file_store.length;
                    if (file_store.length > 0) {
                        if (navigator.share) {
                            navigator.share({
                                title: 'Bán hàng trên mạng xã hội',
                                text: $('#textarea_' + noidung_id).val(),
                                files: file_store,
                            })
                                .then(() => file_store = [])
                                .catch((error) => console.log('Error sharing', error));
                        } else {
                            console.log('Không hỗ trợ trên trình duyệt này.');
                        }
                    } else {
                        console.log('Không thể chia sẻ');
                    }
                }
            }, 3000);
        }
    });
    ///////////////////
    /*    const shareImages = async () => {
            i=0;
            var list='';
            noidung_id=$('.li_share_sanpham.active .share_button').attr('noidung_id');
            const list_sanpham=[];        const newItem = {
                text: 'Video giới thiệu',
                url: 'https://socdo.vn/uploads/socdo.mp4',
            }; 
            list_sanpham.push(newItem);    
            $('.li_share_sanpham.active .minh_hoa img, .li_share_sanpham.active .minh_hoa video').each(function() {
                i++;
                src=$(this).attr('src');
                const newItem = {
                    text: 'Ảnh thứ '+i,
                    url: src,
                };
                  list_sanpham.push(newItem);
            });
            console.log(list_sanpham);
            const files = await Promise.all(list_sanpham.map(async (item) => {
            const file = await getFileWithPermission(item.url);
            return file;
          }));
        if($('input[name=rut_gon]').is(':checked')){
            rut_gon=1;
        }else{
            rut_gon=0;
        }
        if($('input[name=mobile_share]').is(':checked')){
            mobile=1;
        }else{
            mobile=0;
        }
        copy_text_share('textarea_'+noidung_id,rut_gon,mobile);
        noi_dung=$('#textarea_'+noidung_id).val();
        if($('input[name=rut_gon]').is(':checked')){
            link_rutgon="\nXem chi tiết: "+$('input[name=rut_gon]').val();
        }else{
            link_rutgon='';
        }
        if($('input[name=mobile_share]').is(':checked')){
            mobile_share="\nLiên hệ ngay: "+$('input[name=mobile_share]').val();
        }else{
            mobile_share='';
        }
        noi_dung = noi_dung+''+link_rutgon+''+mobile_share;
          if (navigator.share) {
            navigator.share({ files: files, title: 'Bán hàng trên mạng xã hội', text: noi_dung })
              .then(() => console.log('Chia sẻ thành công!'))
              .catch((error) => console.error('Lỗi khi chia sẻ:', error));
          } else {
            alert('Trình duyệt của bạn không hỗ trợ chia sẻ!');
          }
        };
    
        const getFileWithPermission = async (url) => {
          const response = await fetch(url);
          const blob = await response.blob();
          const file = new File([blob], blob.webkitRelativePath || url.substring(url.lastIndexOf('/') + 1), { type: blob.type });
          return file;
        };
        $('.share_button').click(shareImages);*/
    ///////////////////
    $('.menu_thongbao .title .fa').on('click', function () {
        $('.menu_thongbao').hide();
        create_cookie('close_menu_thongbao', 1, 1, '/');
    });
    $('.box_select_product').on('click', '.action button', function () {
        $(this).toggleClass('active');
    });
    $('.box_select_product .box_list').on('scroll', function () {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            tiep = $('.box_select_product .box_list').attr('tiep');
            page = $('.box_select_product .box_list').attr('page');
            loaded = $('.box_select_product .box_list').attr('loaded');
            key = $('input[name=key_deal]').val();
            loai = $('button[name=select_main_product]').attr('loai');
            if (loaded == 1 && tiep == 1 && page != 1 && key == '') {
                $('.box_select_product .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.box_select_product .box_list').attr('loaded', 0);
                if (loai == 'main_product') {
                    setTimeout(function () {
                        $.ajax({
                            url: "/admin/process.php",
                            type: "post",
                            data: {
                                action: 'load_product_main',
                                page: page,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list .loading_product').remove();
                                $('.box_select_product .box_list').append(info.list);
                                $('.box_select_product .box_list').attr('page', info.page);
                                $('.box_select_product .box_list').attr('tiep', info.tiep);
                                $('.box_select_product .box_list').attr('loaded', 1);
                            }
                        });
                    }, 1000);
                } else {
                    var sp_id = '';
                    $('#list_product_main .li_product,#list_product_sub .li_product').each(function () {
                        sp_id += $(this).attr('sp') + ',';
                    });
                    setTimeout(function () {
                        $.ajax({
                            url: "/admin/process.php",
                            type: "post",
                            data: {
                                action: 'load_product_sub',
                                list_id: sp_id,
                                page: page,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list .loading_product').remove();
                                $('.box_select_product .box_list').append(info.list);
                                $('.box_select_product .box_list').attr('page', info.page);
                                $('.box_select_product .box_list').attr('tiep', info.tiep);
                                $('.box_select_product .box_list').attr('loaded', 1);
                            }
                        });
                    }, 1000);

                }

            }

        }
    })
    $('.select_product').on('click', function () {
        $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_product').show();
        $('.box_select_product .box_bottom button').attr('loai', 'main_product');
        setTimeout(function () {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'load_product_main',
                    page: 1,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_product .box_list').html(info.list);
                    $('.box_select_product .box_list').attr('page', info.page);
                    $('.box_select_product .box_list').attr('tiep', info.tiep);
                    $('.box_select_product .box_list').attr('loaded', 1);
                }
            });
        }, 1000);

    });
    $('.select_product_sub').on('click', function () {
        $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_product').show();
        $('.box_select_product .box_bottom button').attr('loai', 'sub_product');
        var sp_id = '';
        $('#list_product_main .li_product,#list_product_sub .li_product').each(function () {
            sp_id += $(this).attr('sp') + ',';
        });
        setTimeout(function () {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'load_product_sub',
                    list_id: sp_id,
                    page: 1,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_product .box_list').html(info.list);
                    $('.box_select_product .box_list').attr('page', info.page);
                    $('.box_select_product .box_list').attr('tiep', info.tiep);
                    $('.box_select_product .box_list').attr('loaded', 1);
                }
            });
        }, 1000);

    });
    $('.search_deal').on('click', function () {
        key = $('input[name=key_deal]').val();
        loai = $('button[name=select_main_product]').attr('loai');
        var sp_id = '';
        $('#list_product_main .li_product,#list_product_sub .li_product').each(function () {
            sp_id += $(this).attr('sp') + ',';
        });
        if (key.length < 1) {
            $('input[name=key_deal]').focus();
        } else {
            $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            if (loai == 'main_product') {
                setTimeout(function () {
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'search_product_main',
                            key: key,
                            page: 1,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product .box_list').html(info.list);
                            $('.box_select_product .box_list').attr('page', info.page);
                            $('.box_select_product .box_list').attr('tiep', 0);
                            $('.box_select_product .box_list').attr('loaded', 1);
                        }
                    });
                }, 1000);
            } else {
                setTimeout(function () {
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'search_product_sub',
                            key: key,
                            list_id: sp_id,
                            page: 1,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product .box_list').html(info.list);
                            $('.box_select_product .box_list').attr('page', info.page);
                            $('.box_select_product .box_list').attr('tiep', 0);
                            $('.box_select_product .box_list').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }

        }
    });
    $('input[name=key_deal]').keypress(function (e) {
        if (e.which == 13) {
            key = $('input[name=key_deal]').val();
            loai = $('button[name=select_main_product]').attr('loai');
            var sp_id = '';
            $('#list_product_main .li_product,#list_product_sub .li_product').each(function () {
                sp_id += $(this).attr('sp') + ',';
            });
            if (key.length < 1) {
                $('input[name=key_deal]').focus();
            } else {
                $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                if (loai == 'main_product') {
                    setTimeout(function () {
                        $.ajax({
                            url: "/admin/process.php",
                            type: "post",
                            data: {
                                action: 'search_product_main',
                                key: key,
                                page: 1,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list').html(info.list);
                                $('.box_select_product .box_list').attr('page', info.page);
                                $('.box_select_product .box_list').attr('tiep', 0);
                                $('.box_select_product .box_list').attr('loaded', 1);
                            }
                        });
                    }, 1000);
                } else {
                    setTimeout(function () {
                        $.ajax({
                            url: "/admin/process.php",
                            type: "post",
                            data: {
                                action: 'search_product_sub',
                                key: key,
                                list_id: sp_id,
                                page: 1,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list').html(info.list);
                                $('.box_select_product .box_list').attr('page', info.page);
                                $('.box_select_product .box_list').attr('tiep', 0);
                                $('.box_select_product .box_list').attr('loaded', 1);
                            }
                        });
                    }, 1000);
                }
            }
        }
    });
    /////////////////////////////
    $('button[name=select_main_product]').on('click', function () {
        loai = $(this).attr('loai');
        if (loai == 'main_product') {
            $('.box_select_product .box_list .li_product button.active').each(function () {
                sp_id = $(this).attr('sp');
                if ($('#list_product_main .li_product_' + sp_id).length < 1) {
                    sanpham = $(this).parent().parent().html();
                    sp = sanpham.replace("Chọn", "xóa");
                    $('#list_product_main').append('<div class="li_product li_product_' + sp_id + '" sp="' + sp_id + '">' + sp + '</div>');
                }
            });
        } else if (loai == 'sub_product') {
            kieu = $('input[name=loai]:checked').val();
            var sp_id = '';
            $('.box_select_product .box_list .li_product button.active').each(function () {
                sp_id += $(this).attr('sp') + ',';
            });
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'show_product_sub',
                    list_id: sp_id,
                    kieu: kieu
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#list_product_sub').append(info.list);
                }
            });
        }
        $('.box_select_product').hide();
        $('.box_select_product .box_list').html('');
        $('.box_select_product .box_list').attr('page', 1);
        $('input[name=key_deal]').val('');
    })
    $('#list_product_main').on('click', '.action button', function () {
        $(this).parent().parent().remove();
    });
    $('#list_product_sub').on('click', '.action button', function () {
        $(this).parent().parent().remove();
    });
    /////////////////////////////
    $('select[name=apdung]').on('change', function () {
        kieu = $(this).val();
        if (kieu == 'all') {
            $('#box_sanpham').hide();
        } else {
            $('#box_sanpham').show();
        }

    });
    /////////////////////////////
    $('button[name=add_flash_sale]').click(function () {
        tieu_de = $('input[name=tieu_de]').val();
        date_start = $('input[name=date_start]').val();
        date_end = $('input[name=date_end]').val();
        var sub_product = '';
        var product_length = $('#list_product_sub .li_product').length;
        s = 0;
        list = '';
        sub_ok = 1;
        $('#list_product_sub .li_product').each(function () {
            sub_product += $(this).attr('sp') + ',';
            sp_id = $(this).attr('sp');
            gia = $(this).find('input[name^=gia_deal]').val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '"},';
            }
            if (gia == '') {
                sub_ok = 0;
            }
        });
        var list_product_sub = '{' + list + '}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (tieu_de == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        } else if (date_start == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (date_end == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (sub_product == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else if (sub_ok == 0) {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập giá khuyến mại');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'add_flash_sale',
                    tieu_de: tieu_de,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=add_deal]').click(function () {
        tieu_de = $('input[name=tieu_de]').val();
        loai = $('input[name=loai]:checked').val();
        date_start = $('input[name=date_start]').val();
        date_end = $('input[name=date_end]').val();
        var main_product = '';
        $('#list_product_main .li_product').each(function () {
            main_product += $(this).attr('sp') + ',';
        });
        var sub_product = '';
        var product_length = $('#list_product_sub .li_product').length;
        s = 0;
        list = '';
        sub_ok = 1;
        $('#list_product_sub .li_product').each(function () {
            sub_product += $(this).attr('sp') + ',';
            sp_id = $(this).attr('sp');
            gia = $(this).find('input[name^=gia_deal]').val();
            sale = $(this).find('input[name^=sale_deal]').val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"},';
            }
            if (gia == '' && sale == '') {
                sub_ok = 0;
            }
        });
        var list_product_sub = '{' + list + '}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (tieu_de == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        } else if (date_start == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (date_end == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (main_product == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn sản phẩm chính');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else if (sub_product == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn sản phẩm kèm theo');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else if (sub_ok == 0) {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập giá khuyến mại hoặc % khuyến mại');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'add_deal',
                    loai: loai,
                    tieu_de: tieu_de,
                    main_product: main_product,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_deal]').click(function () {
        tieu_de = $('input[name=tieu_de]').val();
        loai = $('input[name=loai]:checked').val();
        date_start = $('input[name=date_start]').val();
        date_end = $('input[name=date_end]').val();
        id = $('input[name=id]').val();
        var main_product = '';
        $('#list_product_main .li_product').each(function () {
            main_product += $(this).attr('sp') + ',';
        });
        var sub_product = '';
        var product_length = $('#list_product_sub .li_product').length;
        s = 0;
        list = '';
        sub_ok = 1;
        $('#list_product_sub .li_product').each(function () {
            sub_product += $(this).attr('sp') + ',';
            sp_id = $(this).attr('sp');
            gia = $(this).find('input[name^=gia_deal]').val();
            sale = $(this).find('input[name^=sale_deal]').val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"},';
            }
            if (gia == '' && sale == '') {
                sub_ok = 0;
            }
        });
        var list_product_sub = '{' + list + '}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (tieu_de == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        } else if (date_start == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (date_end == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (main_product == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn sản phẩm chính');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else if (sub_product == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn sản phẩm kèm theo');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else if (sub_ok == 0) {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập giá khuyến mại hoặc % khuyến mại');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'edit_deal',
                    loai: loai,
                    tieu_de: tieu_de,
                    main_product: main_product,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_flash_sale]').click(function () {
        tieu_de = $('input[name=tieu_de]').val();
        date_start = $('input[name=date_start]').val();
        date_end = $('input[name=date_end]').val();
        id = $('input[name=id]').val();
        var sub_product = '';
        var product_length = $('#list_product_sub .li_product').length;
        s = 0;
        list = '';
        sub_ok = 1;
        $('#list_product_sub .li_product').each(function () {
            sub_product += $(this).attr('sp') + ',';
            sp_id = $(this).attr('sp');
            gia = $(this).find('input[name^=gia_deal]').val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '"},';
            }
            if (gia == '') {
                sub_ok = 0;
            }
        });
        var list_product_sub = '{' + list + '}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (tieu_de == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        } else if (date_start == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (date_end == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (sub_product == '') {
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else if (sub_ok == 0) {
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập giá khuyến mại');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        } else {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'edit_flash_sale',
                    tieu_de: tieu_de,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    if ($('.list_baiviet tr').length < 2 && $('.li_sanpham_drop').length < 2) {
        $('.load_sanpham button').hide();
    }
    $('body').on('click', '#main_category .li_input input', function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_category',
                    cat_id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {

                        if ($('#sub_category .li_input').length > 0) {
                            $('#sub_category').append('<hr class="hr_' + id + '">' + info.list);
                        } else {
                            $('#sub_category').append(info.list);
                        }
                    } else { }
                }
            });
        } else {
            id = $(this).val();
            $('.li_input_' + id).remove();
            $('.hr_' + id).remove();
            $('.hr_main_' + id).remove();
            $('.li_input_main_' + id).remove();
        }
    });
    $('body').on('click', '#sub_category .li_input input', function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            main = $(this).attr('main_id');
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_sub_category',
                    cat_id: id,
                    main: main
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($('#sub_sub_category .li_input').length > 0) {
                            $('#sub_sub_category').append('<hr class="hr_' + id + ' hr_main_' + main + '">' + info.list);
                        } else {
                            $('#sub_sub_category').append(info.list);
                        }
                    } else { }
                }
            });
        } else {
            id = $(this).val();
            $('.hr_' + id).remove();
            $('.li_input_' + id).remove();
        }
    });
    //admin
    $('body').on('click', '#main_category_admin .li_input input', function() {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_category_admin',
                    cat_id: id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
 
                        if ($('#sub_category_admin .li_input').length > 0) {
                            $('#sub_category_admin').append('<hr class="hr_' + id + '">' + info.list);
                        } else {
                            $('#sub_category_admin').append(info.list);
                        }
                    } else {}
                }
            });
        } else {
            id = $(this).val();
            $('.li_input_' + id).remove();
            $('.hr_' + id).remove();
            $('.hr_main_' + id).remove();
            $('.li_input_main_' + id).remove();
        }
    });
    $('body').on('click', '#sub_category_admin .li_input input', function() {
        if ($(this).is(":checked")) {
            id = $(this).val();
            main = $(this).attr('main_id');
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_sub_category_admin',
                    cat_id: id,
                    main: main
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($('#sub_sub_category_admin .li_input').length > 0) {
                            $('#sub_sub_category_admin').append('<hr class="hr_' + id + ' hr_main_' + main + '">' + info.list);
                        } else {
                            $('#sub_sub_category_admin').append(info.list);
                        }
                    } else {}
                }
            });
        } else {
            id = $(this).val();
            $('.hr_' + id).remove();
            $('.li_input_' + id).remove();
        }
    });
    //////////////////////////
    $('.quickview-close').on('click', function () {
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    //////////////////////////
    $('.btn-continue').on('click', function () {
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    $('.box_check_domain .tab').on('click', function () {
        $('.box_check_domain .tab').removeClass('active');
        $(this).addClass('active');
        id = $(this).attr('id');
        $('.box_check_domain .content_tab').removeClass('active');
        $('.box_check_domain #content_' + id).addClass('active');

    });
    /////////////////////////////
    $('#box_pop_confirm .button_cancel').on('click', function () {
        $('#title_confirm').html('');
        $('#button_thuchien').attr('action', '');
        $('#button_thuchien').attr('post_id', '');
        $('#button_thuchien').attr('loai', '');
        $('#box_pop_confirm').hide();
    });
    /////////////////////////////
    $('#box_pop_confirm_action .button_cancel').on('click', function () {
        $('#box_pop_confirm_action .title_confirm').html('');
        $('#button_thuchien_action').attr('action', '');
        $('#button_thuchien_action').attr('post_id', '');
        $('#button_thuchien_action').attr('loai', '');
        $('#box_pop_confirm_action').hide();
    });
    /////////////////////////////
    $('#box_pop_confirm_action_domain .button_cancel').on('click', function () {
        $('#box_pop_confirm_action_domain .title_confirm').html('');
        $('#button_thuchien_action_domain').attr('action', '');
        $('#button_thuchien_action_domain').attr('post_id', '');
        $('#button_thuchien_action_domain').attr('loai', '');
        $('#box_pop_confirm_action_domain').hide();
    });
    /////////////////////////////
    $('#button_thuchien').click(function () {
        id = $('#button_thuchien').attr('post_id');
        loai = $('#button_thuchien').attr('loai');
        action = $('#button_thuchien').attr('action');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: action,
                loai: loai,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#tr_' + id).remove();
                        if (info.reload == 1) {
                            window.location.reload();
                        }
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('#button_thuchien_action').click(function () {
        $('#button_ok').click();
    });
    /////////////////////////////
    $('#button_thuchien_action_domain').click(function () {
        $('#button_ok_domain').click();
    });
    /////////////////////////////
    $('body').on('click', '.li_noidung', function () {
        noidung = $(this).attr('noidung');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'load_noidung_nhiemvu',
                noidung: noidung
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_xemtruoc').show();
                $('.noidung_xemtruoc .trich').html(info.noidung);
                $('.noidung_xemtruoc #textarea_1').html(info.noidung_share);
                $('.noidung_xemtruoc .minh_hoa').html(info.list_anh);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.mo_nhiemvu', function () {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        nhiemvu = $(this).attr('nhiemvu');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'mo_nhiemvu',
                nhiemvu: nhiemvu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('body').on('click', '.hoanthanh_nhiemvu', function () {
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        nhiemvu = $(this).attr('nhiemvu');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'hoanthanh_nhiemvu',
                nhiemvu: nhiemvu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('body').on('click', '.huy_donhang_drop', function () {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'huy_donhang_drop',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('body').on('click', '.huy_donhang_socdo', function () {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'huy_donhang_socdo',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    $('.check_domain input[name=loai]').on('click', function () {
        loai = $(this).val();
        $(".li_domain input").prop('checked', false);
        if (loai == 'all') {
            $('.li_domain').addClass('active');
        } else if (loai == 'quocte') {
            $('.li_domain').removeClass('active');
            $('.li_domain_quocte').addClass('active');
        } else if (loai == 'vietnam') {
            $('.li_domain').removeClass('active');
            $('.li_domain_vietnam').addClass('active');
        }
    });
    /////////////////////////////
    $('body').on('click', '.apply_subdomain', function () {
        domain = $('input[name=subdomain]').val();
        $('.text_check_subdomain').html('<i class="fa fa-spinner fa-pulse"></i><span> Đang xử lý...</span>');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'apply_subdomain',
                domain: domain
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.text_check_subdomain').html(info.thongbao);
                if (info.ok == 1) {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        window.location.reload();
                    }, 3000);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.button_check_subdomain', function () {
        domain = $('input[name=subdomain]').val();
        if (domain.length < 2) {
            $('.text_check_subdomain').html('<i class="fa fa-warning"></i><span> Vui lòng nhập tên miền..</span>');
            $('input[name=subdomain]').focus();
        } else {
            $('.text_check_subdomain').html('<i class="fa fa-spinner fa-pulse"></i><span> Đang kiểm tra...</span>');
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'check_subdomain',
                    domain: domain
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.text_check_subdomain').html(info.thongbao);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.set_skin', function () {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'set_skin',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/list-giaodien?step=2';
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.hotro_domain', function () {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'hotro_domain',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.mua_domain', function () {
        domain = $('#button_thuchien_action_domain').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'mua_domain',
                domain: domain
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        var dulieu = {
                            'hd': 'notification',
                            'bo_phan': 'hotro_chung'
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.mua_seeding', function () {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: 'mua_seeding',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=add_naptien]').on('click', function () {
        sotien = $('input[name=sotien]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'add_naptien',
                sotien: sotien
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/add-naptien?step=2';
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=button_hoanthanh]').on('click', function () {
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        dia_chi = $('input[name=dia_chi]').val();
        ghi_chu = $('textarea[name=ghi_chu]').val();
        tinh = $('select[name=tinh]').val();
        huyen = $('select[name=huyen]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (ho_ten == '') {
            $('input[name=ho_ten]').focus();
            $('.load_note').html('Vui lòng nhập họ và tên');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (dien_thoai == '') {
            $('input[name=dien_thoai]').focus();
            $('.load_note').html('Vui lòng nhập số điện thoại');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        }/* else if (dia_chi == '') {
             $('input[name=dia_chi]').focus();
             $('.load_note').html('Vui lòng nhập địa chỉ');
             setTimeout(function() {
                 $('.load_process').hide();
                 $('.load_note').html('Hệ thống đang xử lý');
                 $('.load_overlay').hide();
             }, 2000);
         } else if (tinh == '') {
             $('.load_note').html('Vui lòng chọn tỉnh');
             setTimeout(function() {
                 $('.load_process').hide();
                 $('.load_note').html('Hệ thống đang xử lý');
                 $('.load_overlay').hide();
             }, 2000);
         } else if (huyen == '') {
             $('.load_note').html('Vui lòng chọn huyện');
             setTimeout(function() {
                 $('.load_process').hide();
                 $('.load_note').html('Hệ thống đang xử lý');
                 $('.load_overlay').hide();
             }, 2000);
 
         }*/ else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var file_data2 = $('#minh_hoa2').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'hoanthanh_donhang');
            form_data.append('file', file_data);
            form_data.append('file2', file_data2);
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('dia_chi', dia_chi);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            if (info.noti == 1) {
                                var dulieu = {
                                    'hd': 'user_notification',
                                }
                                var info_chat = JSON.stringify(dulieu);
                                socket.emit('user_send_hoatdong', info_chat);
                                var dulieu_admin = {
                                    'hd': 'notification',
                                    'bo_phan': 'don_hang'
                                }
                                var info_chat_admin = JSON.stringify(dulieu_admin);
                                socket.emit('user_send_hoatdong', info_chat_admin);
                            }
                            window.location.href = '/admin/list-donhang-admin';
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=button_hoanthanh_gop]').on('click', function () {
        check_ok = $(this).attr('check_ok');
        if (check_ok == 1) {
            if ($('.box_khach_order[xuly="0"]').length > 0) {
                $('.list_khach_order').find('.info_khach_order:visible').parent().find('.title').click();
                var box = $('.box_khach_order[xuly="0"]').first();
                box.find('.title').click();
                box.find('.text_xuly').show();
                loai_box = box.attr('loai_box');
                don = box.find('.title .number').html();
                if (loai_box == 'khach_san') {
                    ho_ten = box.find('input[name=ho_ten]').val();
                    dien_thoai = box.find('input[name=dien_thoai]').val();
                    dia_chi = box.find('input[name=dia_chi]').val();
                    ghi_chu = box.find('textarea[name=ghi_chu]').val();
                    tinh = box.find('select[name=tinh]').val();
                    huyen = box.find('select[name=huyen]').val();
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    if (ho_ten == '') {
                        box.find('input[name=ho_ten]').focus();
                        box.find('.text_xuly').hide();
                        $('.load_note').html('Vui lòng nhập họ và tên');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else if (dien_thoai == '') {
                        box.find('.text_xuly').hide();
                        box.find('input[name=dien_thoai]').focus();
                        $('.load_note').html('Vui lòng nhập số điện thoại');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else {
                        var file_data = box.find('#minh_hoa').prop('files')[0];
                        var file_data2 = box.find('#minh_hoa2').prop('files')[0];
                        var form_data = new FormData();
                        form_data.append('action', 'hoanthanh_donhang_gop');
                        form_data.append('loai_don', loai_box);
                        form_data.append('don', don);
                        form_data.append('file', file_data);
                        form_data.append('file2', file_data2);
                        form_data.append('ho_ten', ho_ten);
                        form_data.append('dien_thoai', dien_thoai);
                        form_data.append('dia_chi', dia_chi);
                        form_data.append('ghi_chu', ghi_chu);
                        form_data.append('tinh', tinh);
                        form_data.append('huyen', huyen);
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        $.ajax({
                            url: '/admin/process.php',
                            type: 'post',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                setTimeout(function () {
                                    $('.load_note').html(info.thongbao);
                                }, 1000);
                                setTimeout(function () {
                                    $('.load_process').hide();
                                    $('.load_note').html('Hệ thống đang xử lý');
                                    $('.load_overlay').hide();
                                    if (info.ok == 1) {
                                        if (info.noti == 1) {
                                            var dulieu = {
                                                'hd': 'user_notification',
                                            }
                                            var info_chat = JSON.stringify(dulieu);
                                            socket.emit('user_send_hoatdong', info_chat);
                                            var dulieu_admin = {
                                                'hd': 'notification',
                                                'bo_phan': 'don_hang'
                                            }
                                            var info_chat_admin = JSON.stringify(dulieu_admin);
                                            socket.emit('user_send_hoatdong', info_chat_admin);
                                        }
                                        box.attr('xuly', '1');
                                        box.find('.text_xuly').html('Đã hoàn thành');
                                        $('button[name=button_hoanthanh_gop]').click();
                                    } else {

                                    }
                                }, 3000);
                            }
                        });
                    }
                } else {
                    ho_ten = box.find('input[name=ho_ten]').val();
                    dien_thoai = box.find('input[name=dien_thoai]').val();
                    dia_chi = box.find('input[name=dia_chi]').val();
                    ghi_chu = box.find('textarea[name=ghi_chu]').val();
                    tinh = box.find('select[name=tinh]').val();
                    ten_tinh = box.find('select[name=tinh] option:selected').text();
                    huyen = box.find('select[name=huyen]').val();
                    ten_huyen = box.find('select[name=huyen] option:selected').text();
                    xa = box.find('select[name=xa]').val();
                    ten_xa = box.find('select[name=xa] option:selected').text();
                    chiu_ship = box.find('select[name=chiu_ship]').val();
                    congty_ship = box.find('select[name=congty_ship]').val();
                    dichvu_ship = box.find('select[name=dichvu_ship]').val();
                    phi_ship = box.find('select[name=dichvu_ship] option:selected').attr('phi_ship');
                    cod = box.find('input[name=cod]').val();
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    if (cod == '') {
                        box.find('.text_xuly').hide();
                        box.find('input[name=cod]').focus();
                        $('.load_note').html('Vui lòng nhập COD');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else if (ho_ten == '') {
                        box.find('.text_xuly').hide();
                        box.find('input[name=ho_ten]').focus();
                        $('.load_note').html('Vui lòng nhập họ và tên');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else if (dien_thoai == '') {
                        box.find('.text_xuly').hide();
                        box.find('input[name=dien_thoai]').focus();
                        $('.load_note').html('Vui lòng nhập số điện thoại');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else if (dia_chi == '') {
                        box.find('.text_xuly').hide();
                        box.find('input[name=dia_chi]').focus();
                        $('.load_note').html('Vui lòng nhập địa chỉ');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else if (tinh == '') {
                        box.find('.text_xuly').hide();
                        $('.load_note').html('Vui lòng chọn tỉnh/thành phố');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    } else if (huyen == '') {
                        box.find('.text_xuly').hide();
                        $('.load_note').html('Vui lòng chọn quận/huyện');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);

                    } else if (xa == '') {
                        box.find('.text_xuly').hide();
                        $('.load_note').html('Vui lòng chọn xã/phường');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);

                    } else if (congty_ship == '') {
                        box.find('.text_xuly').hide();
                        $('.load_note').html('Vui lòng chọn công ty vận chuyển');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);

                    } else if (dichvu_ship == '') {
                        box.find('.text_xuly').hide();
                        $('.load_note').html('Vui lòng chọn dịch vụ giao hàng');
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);

                    } else {
                        var form_data = new FormData();
                        form_data.append('action', 'hoanthanh_donhang_gop');
                        form_data.append('loai_don', loai_box);
                        form_data.append('don', don);
                        form_data.append('ho_ten', ho_ten);
                        form_data.append('dien_thoai', dien_thoai);
                        form_data.append('dia_chi', dia_chi);
                        form_data.append('ghi_chu', ghi_chu);
                        form_data.append('tinh', tinh);
                        form_data.append('huyen', huyen);
                        form_data.append('xa', xa);
                        form_data.append('ten_tinh', ten_tinh);
                        form_data.append('ten_huyen', ten_huyen);
                        form_data.append('ten_xa', ten_xa);
                        form_data.append('chiu_ship', chiu_ship);
                        form_data.append('congty_ship', congty_ship);
                        form_data.append('dichvu_ship', dichvu_ship);
                        form_data.append('phi_ship', phi_ship);
                        form_data.append('cod', cod);
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        $.ajax({
                            url: '/admin/process.php',
                            type: 'post',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                setTimeout(function () {
                                    $('.load_note').html(info.thongbao);
                                }, 1000);
                                setTimeout(function () {
                                    $('.load_process').hide();
                                    $('.load_note').html('Hệ thống đang xử lý');
                                    $('.load_overlay').hide();
                                    if (info.ok == 1) {
                                        if (info.noti == 1) {
                                            var dulieu = {
                                                'hd': 'user_notification',
                                            }
                                            var info_chat = JSON.stringify(dulieu);
                                            socket.emit('user_send_hoatdong', info_chat);
                                            var dulieu_admin = {
                                                'hd': 'notification',
                                                'bo_phan': 'don_hang'
                                            }
                                            var info_chat_admin = JSON.stringify(dulieu_admin);
                                            socket.emit('user_send_hoatdong', info_chat_admin);
                                        }
                                        box.attr('xuly', '1');
                                        box.find('.text_xuly').html('Đã hoàn thành');
                                        $('button[name=button_hoanthanh_gop]').click();
                                    } else {

                                    }
                                }, 3000);
                            }
                        });
                    }

                }
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                var form_data = new FormData();
                form_data.append('action', 'del_cart_gop');
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (kq) {
                        setTimeout(function () {
                            $('.load_note').html('Đã hoàn tất xử lý...');
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            window.location.href = '/admin/'
                        }, 3000);
                    }
                });
            }
        } else {
            phi_ship = 0;
            tiep_ship = 1;
            tiep_cod = 1;
            total_cod = 0;
            tong_hoahong = 0;
            tiep_san = 1;
            tong_tiensan = 0;
            $('.box_khach_order').each(function () {
                var div_this = $(this);
                loai_khach = div_this.attr('loai_box');
                if (loai_khach == 'khach_san') {
                    tt = div_this.find('.tongtien_don span').html();
                    if (tt == '') {
                        tiep_san = 0;
                    } else {
                        tt = tt.replace(/,|đ/g, "");
                        tong_tiensan += parseInt(tt);
                    }
                } else if (loai_khach == 'khach_socdo') {
                    cod = div_this.find('input[name=cod]').val();
                    if (cod == '') {
                        tiep_cod = 0;
                    } else {
                        total_cod += parseInt(cod);
                    }
                    hoa_hong = div_this.find('.hoahong_don span').html();
                    if (hoa_hong == '') {
                    } else {
                        hoa_hong = hoa_hong.replace(/,|đ/g, "");
                        if (hoa_hong < 0) {
                            tong_hoahong += parseInt(hoa_hong);
                        } else {

                        }
                    }
                    phi = div_this.find('.phiship_don').attr('phi');
                    if (phi == '') {
                        tiep_ship = 0;
                    } else {
                        phi_ship += parseInt(phi);
                    }
                }
            });
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            if (tiep_san == 0) {
                setTimeout(function () {
                    $('.load_note').html('Vui lòng chọn sản phẩm cho người nhận');
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 1500);
            } else if (tiep_cod == 0) {
                setTimeout(function () {
                    $('.load_note').html('Vui lòng nhập tiền COD');
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 1500);
            } else if (tiep_ship == 0) {
                setTimeout(function () {
                    $('.load_note').html('Vui lòng chọn dịch vụ giao hàng');
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 1500);
            } else {
                var form_data = new FormData();
                form_data.append('action', 'check_ok');
                form_data.append('phi_ship', phi_ship);
                form_data.append('tong_hoahong', tong_hoahong);
                form_data.append('tongtien_san', tong_tiensan);
                form_data.append('total_cod', total_cod);
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            if (info.ok == 0) {
                                $('.load_note').html(info.thongbao);
                            }
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                $('button[name=button_hoanthanh_gop]').attr('check_ok', '1');
                                $('button[name=button_hoanthanh_gop]').click();
                            } else {

                            }
                        }, 1500);
                    }
                });
            }
        }
    });
    /////////////////////////////
    $('button[name=button_hoanthanh_admin]').on('click', function () {
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        dia_chi = $('input[name=dia_chi]').val();
        ghi_chu = $('textarea[name=ghi_chu]').val();
        tinh = $('select[name=tinh]').val();
        ten_tinh = $('select[name=tinh] option:selected').text();
        huyen = $('select[name=huyen]').val();
        ten_huyen = $('select[name=huyen] option:selected').text();
        xa = $('select[name=xa]').val();
        ten_xa = $('select[name=xa] option:selected').text();
        chiu_ship = $('select[name=chiu_ship]').val();
        congty_ship = $('select[name=congty_ship]').val();
        dichvu_ship = $('select[name=dichvu_ship]').val();
        phi_ship = $('select[name=dichvu_ship] option:selected').attr('phi_ship');
        cod = $('input[name=cod]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (cod == '') {
            $('input[name=cod]').focus();
            $('.load_note').html('Vui lòng nhập COD');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (ho_ten == '') {
            $('input[name=ho_ten]').focus();
            $('.load_note').html('Vui lòng nhập họ và tên');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (dien_thoai == '') {
            $('input[name=dien_thoai]').focus();
            $('.load_note').html('Vui lòng nhập số điện thoại');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (dia_chi == '') {
            $('input[name=dia_chi]').focus();
            $('.load_note').html('Vui lòng nhập địa chỉ');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (tinh == '') {
            $('.load_note').html('Vui lòng chọn tỉnh/thành phố');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (huyen == '') {
            $('.load_note').html('Vui lòng chọn quận/huyện');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);

        } else if (xa == '') {
            $('.load_note').html('Vui lòng chọn xã/phường');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);

        } else if (congty_ship == '') {
            $('.load_note').html('Vui lòng chọn công ty vận chuyển');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);

        } else if (dichvu_ship == '') {
            $('.load_note').html('Vui lòng chọn dịch vụ giao hàng');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);

        } else {
            var form_data = new FormData();
            form_data.append('action', 'hoanthanh_donhang_admin');
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('dia_chi', dia_chi);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('chiu_ship', chiu_ship);
            form_data.append('congty_ship', congty_ship);
            form_data.append('dichvu_ship', dichvu_ship);
            form_data.append('phi_ship', phi_ship);
            form_data.append('cod', cod);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            if (info.noti == 1) {
                                var dulieu = {
                                    'hd': 'user_notification',
                                }
                                var info_chat = JSON.stringify(dulieu);
                                socket.emit('user_send_hoatdong', info_chat);
                                var dulieu_admin = {
                                    'hd': 'notification',
                                    'bo_phan': 'san_pham'
                                }
                                var info_chat_admin = JSON.stringify(dulieu_admin);
                                socket.emit('user_send_hoatdong', info_chat_admin);
                            }
                            window.location.href = '/admin/list-donhang-socdo';
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.dat_ngay', function () {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
            size = $(this).attr('size');
            color = $(this).attr('color');
            pl = $(this).attr('pl');
            quantity = 1;
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'add_to_cart',
                    sp_id: sp_id,
                    size: size,
                    mau: color,
                    pl: pl,
                    quantity: quantity
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            window.location.href = '/admin/add-donhang-drop?step=2';
                        }, 3000);
                    } else {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
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
    $('body').on('click', '.buy_now', function () {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
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
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'add_to_cart',
                    sp_id: sp_id,
                    size: size,
                    mau: color,
                    pl: pl,
                    quantity: quantity
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            window.location.href = '/admin/add-donhang-drop?step=2';
                        }, 3000);
                    } else {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
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
    $('body').on('click', '.add_to_cart_new', function () {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
            size = $(this).attr('size');
            color = $(this).attr('color');
            pl = $(this).attr('pl');
            quantity = 1;
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'add_to_cart',
                    sp_id: sp_id,
                    size: size,
                    mau: color,
                    pl: pl,
                    quantity: quantity
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.box_shopcart span').html(info.total_cart);
                            $('.load_overlay').hide();
                        }, 2000);

                    } else {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
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
    $('body').on('click', '.add_to_cart', function () {
        if (!$(this).hasClass('disabled')) {
            sp_id = $(this).attr('sp_id');
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
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'add_to_cart',
                    sp_id: sp_id,
                    size: size,
                    mau: mau,
                    quantity: quantity
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('#popup-cart').css('display', 'block');
                            $('#popup-cart .tbody-popup').html(info.list);
                            $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                            $('#popup-cart .cart-popup-name').html(info.name);
                            $('#popup-cart .cart-popup-count').html(info.total_cart);
                            $('.box_shopcart span').html(info.total_cart);
                        }, 1000);

                    } else {
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
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
    $('.tbody-popup').on('click', '.remove-item-cart', function () {
        id = $(this).data('id');
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'remove_cart',
                sp_id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-name').html(info.name);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.box_shopcart span').html(info.total_cart);
                } else {
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.box_shopcart span').html(info.total_cart);

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('click', '.btn-plus', function () {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).parent().find('input[name=quantity]').val();
        quantity++;
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_cart',
                sp_id: id,
                quantity: quantity
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.box_shopcart span').html(info.total_cart);
                } else {
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.box_shopcart span').html(info.total_cart);

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('click', '.btn-minus', function () {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).parent().find('input[name=quantity]').val();
        if (quantity > 1) {
            quantity--;
        } else {
            quantity = 1;
        }
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_cart',
                sp_id: id,
                quantity: quantity
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                    $('.box_shopcart span').html(info.total_cart);
                } else {
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.box_shopcart span').html(info.total_cart);

                }
            }
        });
    });
    //////////////////////////
    $('.tbody-popup').on('keyup', 'input[name=quantity]', function () {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).val();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_cart',
                sp_id: id,
                quantity: quantity
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $('#popup-cart .tbody-popup').html(info.list);
                    $('#popup-cart .tfoot-popup .total-price').html(info.total_price);
                    $('#popup-cart .cart-popup-count').html(info.total_cart);
                } else {
                    $('.load_overlay').hide();
                    $('.modal').hide();
                    $('#popup-cart .tbody-popup').html('');
                    $('#popup-cart .tfoot-popup .total-price').html('');
                    $('#popup-cart .cart-popup-name').html('');
                    $('#popup-cart .cart-popup-count').html('');
                    $('.box_shopcart span').html(info.total_cart);
                }
            }
        });
    });
    /////////////////////////////
    $('.box_right_content').on('click', '.del_server', function () {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.box_right_content').on('click', '.add_server', function () {
        $('.block_bottom').before('<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link nguồn</label><input type="text" class="form_control" name="nguon" value="" placeholder="Nhập nguồn dữ liệu..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="button_select_photo">Chọn ảnh</button><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>');
    });
    $('.button_add_info').on('click', function () {
        $('.list_info').append('<div class="li_info"><div class="info_name"><input type="text" name="info_name[]" placeholder="Nhập tên thông tin"></div><div class="info_value"><input type="text" name="info_value[]" placeholder="Nhập giá trị thông tin"></div></div>');
    });
    /////////////////////////////
    $('.mh').click(function () {
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function () {
        readURL(this, 'preview-minhhoa');
    });
    /////////////////////////////
    $('.mh_popup').click(function () {
        $('#popup').click();
    });
    $("#popup").change(function () {
        readURL(this, 'preview-popup');
    });
    /////////////////////////////
    $('.box_profile').on('click', '.button_select_photo', function () {
        $('#photo-add').click();
    });
    $('#photo-add').on('change', function () {
        var form_data = new FormData();
        form_data.append('action', 'upload_photo');
        $.each($("input[name=file]")[0].files, function (i, file) {
            form_data.append('file[]', file);
        });
        //form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.list_photo').append(info.list);
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '#attachment', function () {
        $('#dinh_kem').click();
    });
    //////////////////////////////
    $('#dinh_kem').on('change', function () {
        var phien = $('#submit_yeucau').attr('phien');
        var user_out = $('.box_chat input[name=user_out]').val();
        if ($('#list_chat .txt').length > 0) {
            sms_id = $('#list_chat .li_sms').last().attr('sms_id');
        } else {
            sms_id = 0;
        }
        var form_data = new FormData();
        form_data.append('action', 'upload_dinhkem');
        $.each($("input[name=file]")[0].files, function (i, file) {
            form_data.append('file[]', file);
        });
        form_data.append('phien', phien);
        form_data.append('sms_id', sms_id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#list_chat').append(info.list);
                        scrollSmoothToBottom('list_chat');
                        var dulieu = {
                            "list_out": info.list_out,
                            'list': info.list,
                            'phien': phien,
                            'loai': 'thanh_vien',
                            'user_out': info.user_out,
                            'thanh_vien': user_out,
                            'bo_phan': info.bo_phan
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_traodoi', info_chat);
                    }
                }, 3000);
            }

        });
    });
    $('.tieude_seo').on('paste', function (event) {
        if ($(this).hasClass('uncheck_blank')) { } else {
            setTimeout(function () {
                check_blank();
            }, 1000);
        }
    });
    $('input[name=slug]').on('keyup', function () {
        slug = $(this).val();
        id = $('input[name=id]').val();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "check_slug",
                slug: slug,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.check_slug').html(info.thongbao);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '.box_sticker .li_tab', function () {
        tab = $(this).attr('id');
        $('.list_sticker_content').removeClass('active');
        $('#' + tab + '_content').addClass('active');

    });
    /////////////////////////////
    $('body').on('click', '#smile', function () {
        $('.box_sticker').toggle();
    });
    /////////////////////////////
    $('body').on('click', '.drop_down button', function () {
        //$('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).parent().find('.drop_menu').is(':visible')) {
            $(this).parent().find('.drop_menu').slideUp('300');
        } else {
            $(this).parent().find('.drop_menu').slideDown('300');
        }
    });
    /////////////////////////////
    /*    $(document).mouseup(function(e) {
            var dr = $(".drop_menu");
            if (!dr.is(e.target) && dr.has(e.target).length === 0) {
                $('.drop_menu').slideUp('300');
            }
        });*/
    ///////////////////////////
    $('body').on('click', '.menu_top .menu_top_left .drop_menu .main_menu .list_menu .li_menu .a_main', function () {
        $(this).parent().find('.list_menu_sub').toggleClass('active');
        if ($(this).find('.right i').hasClass('fa-plus-square-o')) {
            $(this).find('.right i').removeClass('fa-plus-square-o');
            $(this).find('.right i').addClass('fa-minus-square-o');
        } else {
            $(this).find('.right i').addClass('fa-plus-square-o');
            $(this).find('.right i').removeClass('fa-minus-square-o');
        }
    });
    ///////////////////////////
    $('body').on('click', '.menu_top .menu_top_left .drop_menu .main_menu .list_menu .li_menu .list_menu_sub .li_menu_sub .a_sub', function () {
        $(this).parent().find('.list_menu_sub_sub').toggleClass('active');
        if ($(this).find('.right i').hasClass('fa-plus-square-o')) {
            $(this).find('.right i').removeClass('fa-plus-square-o');
            $(this).find('.right i').addClass('fa-minus-square-o');
        } else {
            $(this).find('.right i').addClass('fa-plus-square-o');
            $(this).find('.right i').removeClass('fa-minus-square-o');
        }
    });    

    // Reset form lọc
    $('.btn-reset').click(function () {
        $('input[type="date"]').val('');
        $('.btn-filter').click();
    });
    $('input[name=input_search_donhang]').keypress(function (e) {
        key = $(this).val();
        if (e.which == 13) {
            if (key.length < 1) {
                $('input[name=key]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: 'timkiem_donhang',
                        key: key
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                $(".list_baiviet tr:not(:first)").remove();
                                $(".list_baiviet tr:first").after(info.list);
                            } else {

                            }
                        }, 1000);
                    }
                });
            }
        }
    });
    $('input[name=input_search_donhang_socdo]').keypress(function (e) {
        key = $(this).val();
        if (e.which == 13) {
            if (key.length < 1) {
                $('input[name=input_search_donhang_socdo]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: 'timkiem_donhang_socdo',
                        key: key
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                $(".list_baiviet tr:not(:first)").remove();
                                $(".list_baiviet tr:first").after(info.list);
                            } else {

                            }
                        }, 1000);
                    }
                });
            }
        }
    });
    $('input[name=input_search_donhang_admin]').keypress(function (e) {
        key = $(this).val();
        if (e.which == 13) {
            if (key.length < 1) {
                $('input[name=input_search_donhang_admin]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: 'timkiem_donhang_admin',
                        key: key
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                $(".list_baiviet tr:not(:first)").remove();
                                $(".list_baiviet tr:first").after(info.list);
                            } else {

                            }
                        }, 1000);
                    }
                });
            }
        }
    });
    $('input[name=key]').keypress(function (e) {
        if ($('.button_timkiem[kieu=mobile]').length > 0) {
            kieu = 'mobile';
        } else {
            kieu = 'laptop';
        }
        if (e.which == 13) {
            key = $('input[name=key]').val();
            if ($('button[name=timkiem_sanpham]').length > 0) {
                action = 'timkiem_sanpham';
            } else if ($('button[name=timkiem_sanpham_shop]').length > 0) {
                action = 'timkiem_sanpham_shop';
            } else if ($('button[name=timkiem_sanpham_follow]').length > 0) {
                action = 'timkiem_sanpham_follow';
            } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
                action = 'timkiem_sanpham_trend';
            } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
                action = 'timkiem_sanpham_tuan';
            } else if ($('button[name=timkiem_sanpham_hethang]').length > 0) {
                action = 'timkiem_sanpham_hethang';
            } else if ($('button[name=timkiem_bom]').length > 0) {
                action = 'timkiem_bom';
            } else if ($('button[name=timkiem_thanhvien]').length > 0) {
                action = 'timkiem_thanhvien';
            } else if ($('button[name=timkiem_link_affiliate]').length > 0) {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("key", key);
                history.replaceState(null, null, "?" + queryParams.toString());
                url = window.location.href;
                url = removeURLParameter(url, 'page');
                queryParams.set("page", 1);
                window.location.href = url;
            }
            if (key.length < 1) {
                $('input[name=key]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: action,
                        key: key,
                        kieu: kieu
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                if (info.kieu == 'mobile') {
                                    $('.list_sanpham').html(info.list);
                                } else {
                                    $('.list_baiviet').html(info.list);
                                }
                                $('.pagination').hide();
                                $('.load_sanpham').hide();
                                if (action == 'timkiem_sanpham_tuan') {
                                    var currentDate = new Date(),
                                        finished = false,
                                        availiableExamples = {
                                            set5ngay: 15 * 24 * 60 * 60 * 1000,
                                            set5phut: 5 * 60 * 1000,
                                            set1phut: 1 * 10 * 1000
                                        };
                                    function call_flash(event) {
                                        $this = $(this);
                                        switch (event.type) {
                                            case "seconds":
                                            case "minutes":
                                            case "hours":
                                            case "days":
                                            case "weeks":
                                            case "daysLeft":
                                                $this.find('.' + event.type).html(event.value);
                                                if (finished) {
                                                    $this.fadeTo(0, 1);
                                                    finished = false;
                                                }
                                                break;
                                            case "finished":
                                                status = $this.attr('status');
                                                if (status == 0) {
                                                    $this.find('.text_time').html('Kết thúc sau:');
                                                    con = $this.attr('thoigian') * 1000;
                                                    $this.countdown(con + currentDate.valueOf(), call_flash);
                                                    $this.attr('status', 1);
                                                } else {
                                                    $this.fadeTo('slow', .5);
                                                    $this.html('Đã kết thúc');
                                                    finished = true;
                                                }
                                                break;
                                        }
                                    }
                                    $('.count_down').each(function () {
                                        con = $(this).attr('time') * 1000;
                                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                                    });
                                }
                            } else {

                            }
                        }, 1000);
                    }
                });
            }
        }
    });
 $('input[name=key_hieu]').keypress(function (e) {
        if ($('.button_timkiem[kieu=mobile]').length > 0) {
            kieu = 'mobile';
        } else {
            kieu = 'laptop';
        }
        if (e.which == 13) {
            key = $('input[name=key_hieu]').val();
            if ($('button[name=timkiem_sanpham]').length > 0) {
                action = 'timkiem_sanpham';
            } else if ($('button[name=timkiem_sanpham_drop_hieu]').length > 0) {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("key", key);
                history.replaceState(null, null, "?" + queryParams.toString());
                url = window.location.href;
                url = removeURLParameter(url, 'page');
                queryParams.set("page", 1);
                window.location.href = url;
            } else if ($('button[name=timkiem_sanpham_shop]').length > 0) {
                action = 'timkiem_sanpham_shop';
            } else if ($('button[name=timkiem_sanpham_follow]').length > 0) {
                action = 'timkiem_sanpham_follow';
            } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
                action = 'timkiem_sanpham_trend';
            } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
                action = 'timkiem_sanpham_tuan';
            } else if ($('button[name=timkiem_sanpham_hethang]').length > 0) {
                action = 'timkiem_sanpham_hethang';
            } else if ($('button[name=timkiem_bom]').length > 0) {
                action = 'timkiem_bom';
            } else if ($('button[name=timkiem_thanhvien]').length > 0) {
                action = 'timkiem_thanhvien';
            } else if ($('button[name=timkiem_link_affiliate]').length > 0) {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("key", key);
                history.replaceState(null, null, "?" + queryParams.toString());
                url = window.location.href;
                url = removeURLParameter(url, 'page');
                queryParams.set("page", 1);
                window.location.href = url;
            }
            if (key.length < 1) {
                $('input[name=key_hieu]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: action,
                        key: key,
                        kieu: kieu
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                if (info.kieu == 'mobile') {
                                    $('.list_sanpham').html(info.list);
                                } else {
                                    $('.list_baiviet').html(info.list);
                                }
                                $('.pagination').hide();
                                $('.load_sanpham').hide();
                                if (action == 'timkiem_sanpham_tuan') {
                                    var currentDate = new Date(),
                                        finished = false,
                                        availiableExamples = {
                                            set5ngay: 15 * 24 * 60 * 60 * 1000,
                                            set5phut: 5 * 60 * 1000,
                                            set1phut: 1 * 10 * 1000
                                        };
                                    function call_flash(event) {
                                        $this = $(this);
                                        switch (event.type) {
                                            case "seconds":
                                            case "minutes":
                                            case "hours":
                                            case "days":
                                            case "weeks":
                                            case "daysLeft":
                                                $this.find('.' + event.type).html(event.value);
                                                if (finished) {
                                                    $this.fadeTo(0, 1);
                                                    finished = false;
                                                }
                                                break;
                                            case "finished":
                                                status = $this.attr('status');
                                                if (status == 0) {
                                                    $this.find('.text_time').html('Kết thúc sau:');
                                                    con = $this.attr('thoigian') * 1000;
                                                    $this.countdown(con + currentDate.valueOf(), call_flash);
                                                    $this.attr('status', 1);
                                                } else {
                                                    $this.fadeTo('slow', .5);
                                                    $this.html('Đã kết thúc');
                                                    finished = true;
                                                }
                                                break;
                                        }
                                    }
                                    $('.count_down').each(function () {
                                        con = $(this).attr('time') * 1000;
                                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                                    });
                                }
                            } else {

                            }
                        }, 1000);
                    }
                });
            }
        }
    });
    /*    $('#timkiem_thuonghieu').on('change', function() {
            thuong_hieu = $(this).val();
            kieu=$('.button_timkiem').attr('kieu');
            $('.pagination').hide();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'timkiem_sanpham_thuonghieu',
                    thuong_hieu: thuong_hieu,
                    kieu:kieu
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
                            if(info.kieu=='mobile'){
                                $('.list_sanpham').html(info.list);
                            }else{
                                $('.list_baiviet').html(info.list);
                            }
                            $('.load_sanpham').hide();
                        } else {
    
                        }
                    }, 1000);
                }
            });
        });*/
    $('#timkiem_thuonghieu_add').on('change', function () {
        thuong_hieu = $(this).val();
        kieu = $('.button_timkiem').attr('kieu');
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu_add',
                thuong_hieu: thuong_hieu,
                kieu: kieu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        if (info.kieu == 'mobile') {
                            $('.list_sanpham').html(info.list);
                        } else {
                            $('.list_baiviet').html(info.list);
                        }
                        $('.load_sanpham').hide();
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('#timkiem_thuonghieu_trend').on('change', function () {
        kieu = $('.button_timkiem').attr('kieu');
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu_trend',
                thuong_hieu: thuong_hieu,
                kieu: kieu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        if (info.kieu == 'mobile') {
                            $('.list_sanpham').html(info.list);
                        } else {
                            $('.list_baiviet').html(info.list);
                        }
                        $('.load_sanpham').hide();
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('#timkiem_thuonghieu_tuan').on('change', function () {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu_tuan',
                thuong_hieu: thuong_hieu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.list_baiviet').html(info.list);
                        $('.load_sanpham').hide();
                        var currentDate = new Date(),
                            finished = false,
                            availiableExamples = {
                                set5ngay: 15 * 24 * 60 * 60 * 1000,
                                set5phut: 5 * 60 * 1000,
                                set1phut: 1 * 10 * 1000
                            };
                        function call_flash(event) {
                            $this = $(this);
                            switch (event.type) {
                                case "seconds":
                                case "minutes":
                                case "hours":
                                case "days":
                                case "weeks":
                                case "daysLeft":
                                    $this.find('.' + event.type).html(event.value);
                                    if (finished) {
                                        $this.fadeTo(0, 1);
                                        finished = false;
                                    }
                                    break;
                                case "finished":
                                    status = $this.attr('status');
                                    if (status == 0) {
                                        $this.find('.text_time').html('Kết thúc sau:');
                                        con = $this.attr('thoigian') * 1000;
                                        $this.countdown(con + currentDate.valueOf(), call_flash);
                                        $this.attr('status', 1);
                                    } else {
                                        $this.fadeTo('slow', .5);
                                        $this.html('Đã kết thúc');
                                        finished = true;
                                    }
                                    break;
                            }
                        }
                        $('.count_down').each(function () {
                            con = $(this).attr('time') * 1000;
                            $(this).countdown(con + currentDate.valueOf(), call_flash);
                        });
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('.button_timkiem').on('click', function () {
        if ($('.button_timkiem[kieu=mobile]').length > 0) {
            kieu = 'mobile';
        } else {
            kieu = 'laptop';
        }
        key = $('input[name=key]').val();
        if ($('button[name=timkiem_sanpham]').length > 0) {
            action = 'timkiem_sanpham';
        } else if ($('button[name=timkiem_sanpham_shop]').length > 0) {
            action = 'timkiem_sanpham_shop';
        } else if ($('button[name=timkiem_sanpham_follow]').length > 0) {
            action = 'timkiem_sanpham_follow';
        } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
            action = 'timkiem_sanpham_trend';
        } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
            action = 'timkiem_sanpham_tuan';
        } else if ($('button[name=timkiem_bom]').length > 0) {
            action = 'timkiem_bom';
        } else if ($('button[name=timkiem_thanhviennhom]').length > 0) {
            action = 'timkiem_thanhviennhom';
        } else if ($('button[name=timkiem_thanhvien]').length > 0) {
            action = 'timkiem_thanhvien';
        } else if ($('button[name=timkiem_link_affiliate]').length > 0) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("key", key);
            history.replaceState(null, null, "?" + queryParams.toString());
            url = window.location.href;
            url = removeURLParameter(url, 'page');
            queryParams.set("page", 1);
            window.location.href = url;
        }
        if (key.length < 1) {
            $('input[name=key]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: action,
                    key: key,
                    kieu: kieu
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            if (info.kieu == 'mobile') {
                                $('.list_sanpham').html(info.list);
                            } else {
                                $('.list_baiviet').html(info.list);
                            }
                            $('.load_sanpham').hide();
                            if (action == 'timkiem_sanpham_tuan') {
                                var currentDate = new Date(),
                                    finished = false,
                                    availiableExamples = {
                                        set5ngay: 15 * 24 * 60 * 60 * 1000,
                                        set5phut: 5 * 60 * 1000,
                                        set1phut: 1 * 10 * 1000
                                    };
                                function call_flash(event) {
                                    $this = $(this);
                                    switch (event.type) {
                                        case "seconds":
                                        case "minutes":
                                        case "hours":
                                        case "days":
                                        case "weeks":
                                        case "daysLeft":
                                            $this.find('.' + event.type).html(event.value);
                                            if (finished) {
                                                $this.fadeTo(0, 1);
                                                finished = false;
                                            }
                                            break;
                                        case "finished":
                                            status = $this.attr('status');
                                            if (status == 0) {
                                                $this.find('.text_time').html('Kết thúc sau:');
                                                con = $this.attr('thoigian') * 1000;
                                                $this.countdown(con + currentDate.valueOf(), call_flash);
                                                $this.attr('status', 1);
                                            } else {
                                                $this.fadeTo('slow', .5);
                                                $this.html('Đã kết thúc');
                                                finished = true;
                                            }
                                            break;
                                    }
                                }
                                $('.count_down').each(function () {
                                    con = $(this).attr('time') * 1000;
                                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                                });
                            }
                        } else {

                        }
                    }, 1000);
                }
            });
        }
    });
$('.button_timkiem_hieu').on('click', function () {
        if ($('.button_timkiem[kieu=mobile]').length > 0) {
            kieu = 'mobile';
        } else {
            kieu = 'laptop';
        }
        key = $('input[name=key_hieu]').val();
        if ($('button[name=timkiem_sanpham]').length > 0) {
            action = 'timkiem_sanpham';
        } else if ($('button[name=timkiem_sanpham_drop_hieu]').length > 0) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("key", key);
            history.replaceState(null, null, "?" + queryParams.toString());
            url = window.location.href;
            url = removeURLParameter(url, 'page');
            queryParams.set("page", 1);
            window.location.href = url;
        } else if ($('button[name=timkiem_sanpham_shop]').length > 0) {
            action = 'timkiem_sanpham_shop';
        } else if ($('button[name=timkiem_sanpham_follow]').length > 0) {
            action = 'timkiem_sanpham_follow';
        } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
            action = 'timkiem_sanpham_trend';
        } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
            action = 'timkiem_sanpham_tuan';
        } else if ($('button[name=timkiem_bom]').length > 0) {
            action = 'timkiem_bom';
        } else if ($('button[name=timkiem_thanhviennhom]').length > 0) {
            action = 'timkiem_thanhviennhom';
        } else if ($('button[name=timkiem_thanhvien]').length > 0) {
            action = 'timkiem_thanhvien';
        } else if ($('button[name=timkiem_link_affiliate]').length > 0) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("key", key);
            history.replaceState(null, null, "?" + queryParams.toString());
            url = window.location.href;
            url = removeURLParameter(url, 'page');
            queryParams.set("page", 1);
            window.location.href = url;
        }
        if (key.length < 1) {
            $('input[name=key_hieu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: action,
                    key: key,
                    kieu: kieu
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 500);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            if (info.kieu == 'mobile') {
                                $('.list_sanpham').html(info.list);
                            } else {
                                $('.list_baiviet').html(info.list);
                            }
                            $('.load_sanpham').hide();
                            if (action == 'timkiem_sanpham_tuan') {
                                var currentDate = new Date(),
                                    finished = false,
                                    availiableExamples = {
                                        set5ngay: 15 * 24 * 60 * 60 * 1000,
                                        set5phut: 5 * 60 * 1000,
                                        set1phut: 1 * 10 * 1000
                                    };
                                function call_flash(event) {
                                    $this = $(this);
                                    switch (event.type) {
                                        case "seconds":
                                        case "minutes":
                                        case "hours":
                                        case "days":
                                        case "weeks":
                                        case "daysLeft":
                                            $this.find('.' + event.type).html(event.value);
                                            if (finished) {
                                                $this.fadeTo(0, 1);
                                                finished = false;
                                            }
                                            break;
                                        case "finished":
                                            status = $this.attr('status');
                                            if (status == 0) {
                                                $this.find('.text_time').html('Kết thúc sau:');
                                                con = $this.attr('thoigian') * 1000;
                                                $this.countdown(con + currentDate.valueOf(), call_flash);
                                                $this.attr('status', 1);
                                            } else {
                                                $this.fadeTo('slow', .5);
                                                $this.html('Đã kết thúc');
                                                finished = true;
                                            }
                                            break;
                                    }
                                }
                                $('.count_down').each(function () {
                                    con = $(this).attr('time') * 1000;
                                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                                });
                            }
                        } else {

                        }
                    }, 1000);
                }
            });
        }
    });

    $('button[name=add_size]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 1) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "add_size",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_size]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 1) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_size",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-size';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });

    /////////////////////////////
    $('button[name=add_brand]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "add_brand",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_brand]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_brand",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-brand';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('#ckOk').on('click', function () {
        if ($('#ckOk').is(":checked")) {
            $('#lbtSubmit').attr("disabled", false);
        } else {
            $('#lbtSubmit').attr("disabled", true);
        }
    });
    /////////////////////////////
    $('#txbQuery').keypress(function (e) {
        if (e.which == 13) {
            key = $('#txbQuery').val();
            type = $('input[name=search_type]:checked').val();
            link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////////////
    $('.show_add_marketing').on('click', function () {
        window.location.href = '/admin/add-remarketing';
    });
    //////////////////
    $('#btnSearch').on('click', function () {
        key = $('#txbQuery').val();
        type = $('input[name=search_type]:checked').val();
        link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $('.panel-lyrics .panel-heading').on('click', function () {
        var t = $(this);
        var p = $(this).parent().find('.panel-collapse');
        if (t.hasClass("active-panel")) {
            $(this).parent().find('.panel-collapse').slideUp();
        } else {
            $(this).parent().find('.panel-collapse').slideDown();
        }
        /*      if(p.hasClass("active-panel")){
                    setTimeout(function(){
                        $(this).parent().find('.panel-collapse').removeClass('in');
                    },1000);
                }else{
                    setTimeout(function(){
                        $(this).parent().find('.panel-collapse').addClass('in');
                    },1000);
                }*/
        $(this).toggleClass('active-panel');

    });
    /////////////////////////////
    $('.item-cat a').on('click', function () {
        $(this).parent().find('div').click();

    });
    /////////////////////////////
    $('.remember').on('click', function () {
        value = $(this).attr('value');
        if (value == 'on') {
            $('.remember i').removeClass('fa-check-circle-o');
            $('.remember i').addClass('fa-circle-o');
            $(this).attr('value', 'off');
        } else {
            $('.remember i').removeClass('fa-circle-o');
            $('.remember i').addClass('fa-check-circle-o');
            $(this).attr('value', 'on');
        }

    });
    /////////////////////////////
    $('.li_photo i').on('click', function () {
        var item = $(this);
        anh = item.parent().find('img').attr('src');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "del_photo",
                anh: anh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                item.parent().parent().remove();
            }

        });
    });
    /////////////////////////////
    $('.drop_status input[type=radio]').on('click', function () {
        status = $(this).val();
        user_id = $(this).attr('name');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "update_drop",
                user_id: user_id,
                status: status
            },
            success: function (kq) {
                var info = JSON.parse(kq);
            }

        });
    });
    /////////////////////////////
    $('.load_sanpham button').on('click', function () {
        page = $(this).attr('page');
        kieu = $('.button_timkiem').attr('kieu');
        $(this).html('Đang tải...');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "load_sanpham",
                page: page,
                kieu: kieu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.load_sanpham button').html('Tải thêm');
                $('.load_sanpham button').attr('page', info.page);
                if (info.kieu == 'mobile') {
                    $('.list_sanpham').append(info.list);
                } else {
                    $('.list_baiviet tr:last').after(info.list);

                }
                if (info.list == null) {
                    $('.load_sanpham button').hide();
                }
            }

        });
    });
    /////////////////////////////
    $('.load_sanpham_trend button').on('click', function () {
        page = $(this).attr('page');
        kieu = $('.button_timkiem').attr('kieu');
        $(this).html('Đang tải...');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "load_sanpham_trend",
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.load_sanpham_trend button').html('Tải thêm');
                $('.load_sanpham_trend button').attr('page', info.page);
                if (info.kieu == 'mobile') {
                    $('.list_sanpham').append(info.list);
                } else {
                    $('.list_baiviet tr:last').after(info.list);

                }
                if (info.list == null) {
                    $('.load_sanpham_trend button').hide();
                }
            }

        });
    });
    /////////////////////////////
    $('.load_sanpham_tuan button').on('click', function () {
        page = $(this).attr('page');
        $(this).html('Đang tải...');
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "load_sanpham_tuan",
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.load_sanpham_tuan button').html('Tải thêm');
                $('.load_sanpham_tuan button').attr('page', info.page);
                $('.list_baiviet tr:last').after(info.list);
                if (info.list == null) {
                    $('.load_sanpham_tuan button').hide();
                } else {
                    var currentDate = new Date(),
                        finished = false,
                        availiableExamples = {
                            set5ngay: 15 * 24 * 60 * 60 * 1000,
                            set5phut: 5 * 60 * 1000,
                            set1phut: 1 * 10 * 1000
                        };
                    function call_flash(event) {
                        $this = $(this);
                        switch (event.type) {
                            case "seconds":
                            case "minutes":
                            case "hours":
                            case "days":
                            case "weeks":
                            case "daysLeft":
                                $this.find('.' + event.type).html(event.value);
                                if (finished) {
                                    $this.fadeTo(0, 1);
                                    finished = false;
                                }
                                break;
                            case "finished":
                                status = $this.attr('status');
                                if (status == 0) {
                                    $this.find('.text_time').html('Kết thúc sau:');
                                    con = $this.attr('thoigian') * 1000;
                                    $this.countdown(con + currentDate.valueOf(), call_flash);
                                    $this.attr('status', 1);
                                } else {
                                    $this.fadeTo('slow', .5);
                                    $this.html('Đã kết thúc');
                                    finished = true;
                                }
                                break;
                        }
                    }
                    $('.count_down').each(function () {
                        con = $(this).attr('time') * 1000;
                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                    });
                }
            }

        });
    });
    /////////////////////////////
    $('button[name=add_bom]').on('click', function () {
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        dia_chi = $('input[name=dia_chi]').val();
        tinh_trang = $('textarea[name=tinh_trang]').val();
        if (ho_ten.length < 2) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 2) {
            $('input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 2) {
            $('input[name=dia_chi]').focus();
        } else if (tinh_trang.length < 2) {
            $('textarea[name=tinh_trang]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "add_bom",
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh_trang: tinh_trang
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_bom]').on('click', function () {
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        dia_chi = $('input[name=dia_chi]').val();
        tinh_trang = $('textarea[name=tinh_trang]').val();
        id = $('input[name=id]').val();
        if (ho_ten.length < 2) {
            $('input[name=ho_ten]').focus();
        } else if (dien_thoai.length < 2) {
            $('input[name=dien_thoai]').focus();
        } else if (dia_chi.length < 2) {
            $('input[name=dia_chi]').focus();
        } else if (tinh_trang.length < 2) {
            $('textarea[name=tinh_trang]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_bom",
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh_trang: tinh_trang,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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

    $('.select_nguoinhan').on('click', function () {
        $('.box_select_nguoinhan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_nguoinhan').show();
        $('.box_select_nguoinhan .box_bottom button').attr('loai', 'sub_product');
        var member_id = '';
        $('.list_nguoinhan .li_member').each(function () {
            member_id += $(this).attr('user') + ',';
        });
        setTimeout(function () {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: 'load_nguoinhan',
                    list_id: member_id,
                    page: 1,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_nguoinhan .box_list').html(info.list);
                    $('.box_select_nguoinhan .box_list').attr('page', info.page);
                    $('.box_select_nguoinhan .box_list').attr('tiep', info.tiep);
                    $('.box_select_nguoinhan .box_list').attr('loaded', 1);
                }
            });
        }, 1000);

    });
    ////////////////////////
    $('.box_select_nguoinhan .box_list').on('scroll', function () {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            tiep = $('.box_select_nguoinhan .box_list').attr('tiep');
            page = $('.box_select_nguoinhan .box_list').attr('page');
            loaded = $('.box_select_nguoinhan .box_list').attr('loaded');
            key = $('.box_select_nguoinhan input[name=key_member]').val();
            var member_id = '';
            $('.list_nguoinhan .li_member').each(function () {
                member_id += $(this).attr('user') + ',';
            });
            if (loaded == 1 && tiep == 1 && page != 1 && key == '') {
                $('.box_select_nguoinhan .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.box_select_nguoinhan .box_list').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'load_nguoinhan',
                            list_id: member_id,
                            key: key,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_nguoinhan .box_list .loading_product').remove();
                            $('.box_select_nguoinhan .box_list').append(info.list);
                            $('.box_select_nguoinhan .box_list').attr('page', info.page);
                            $('.box_select_nguoinhan .box_list').attr('tiep', info.tiep);
                            $('.box_select_nguoinhan .box_list').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }

        }
    })
    ///////////////////
    $('.box_select_nguoinhan .box_title .fa').on('click', function () {
        $('.box_select_nguoinhan').hide();
        $('.box_select_nguoinhan .box_list').html('');
        $('.box_select_nguoinhan .box_list').attr('page', 1);
        $('.box_select_nguoinhan input[name=key_member]').val('');
    });
    $('.box_select_nguoinhan').on('click', '.action button', function () {
        var button = $(this);
        user_id = $(this).attr('user');
        username = $(this).attr('username');
        $('.list_nguoinhan').append('<div class="li_member ' + username + '" user="' + user_id + '">' + username + ' <i class="fa fa-close"></i>');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.list_nguoinhan .' + username).remove();
        } else {
            $(this).addClass('active');
        }
    });
    $('.list_nguoinhan').on('click', '.li_member i', function () {
        $(this).parent().remove();
    });
    $('.box_select_nguoinhan .search_member').on('click', function () {
        key = $('.box_select_nguoinhan input[name=key_member]').val();
        var member_id = '';
        $('.list_nguoinhan .li_member').each(function () {
            member_id += $(this).attr('user') + ',';
        });
        if (key.length < 1) {
            $('.box_select_nguoinhan input[name=key_member]').focus();
        } else {
            $('.box_select_nguoinhan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            setTimeout(function () {
                $.ajax({
                    url: "/admin/process.php",
                    type: "post",
                    data: {
                        action: 'load_nguoinhan',
                        list_id: member_id,
                        key: key,
                        page: 1,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $('.box_select_nguoinhan .box_list .loading_product').remove();
                        $('.box_select_nguoinhan .box_list').append(info.list);
                        $('.box_select_nguoinhan .box_list').attr('page', info.page);
                        $('.box_select_nguoinhan .box_list').attr('tiep', info.tiep);
                        $('.box_select_nguoinhan .box_list').attr('loaded', 1);
                    }
                });
            }, 1000);
        }
    });
    $('.box_select_nguoinhan input[name=key_member]').keypress(function (e) {
        if (e.which == 13) {
            key = $('.box_select_nguoinhan input[name=key_member]').val();
            var member_id = '';
            $('.list_nguoinhan .li_member').each(function () {
                member_id += $(this).attr('user') + ',';
            });
            if (key.length < 1) {
                $('.box_select_nguoinhan input[name=key_member]').focus();
            } else {
                $('.box_select_nguoinhan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                setTimeout(function () {
                    $.ajax({
                        url: "/admin/process.php",
                        type: "post",
                        data: {
                            action: 'load_nguoinhan',
                            key: key,
                            page: 1,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_nguoinhan .box_list .loading_product').remove();
                            $('.box_select_nguoinhan .box_list').append(info.list);
                            $('.box_select_nguoinhan .box_list').attr('page', info.page);
                            $('.box_select_nguoinhan .box_list').attr('tiep', info.tiep);
                            $('.box_select_nguoinhan .box_list').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
    });

    /////////////////////////////
    $('button[name=add_remarketing]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var member_id = '';
        $('.list_nguoinhan .li_member').each(function () {
            member_id += $(this).attr('user') + ',';
        });
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_minhhoa = $('#preview-minhhoa').offset().top;
                $('html,body').stop().animate({ scrollTop: top_minhhoa - 150 }, 500, 'swing', function () { });
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var pop_data = $('#popup').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_remarketing');
            form_data.append('file', file_data);
            form_data.append('file_popup', pop_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('member_id', member_id);
            form_data.append('pop', pop);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_remarketing]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var member_id = '';
        $('.list_nguoinhan .li_member').each(function () {
            member_id += $(this).attr('user') + ',';
        });
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var pop_data = $('#popup').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_remarketing');
            form_data.append('file', file_data);
            form_data.append('file_popup', pop_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('member_id', member_id);
            form_data.append('pop', pop);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=add_coupon]').on('click', function () {
        ma = $('input[name=ma]').val();
        loai = $('select[name=loai]').val();
        kieu = $('select[name=apdung]').val();
        giam = $('input[name=giam]').val();
        time_start = $('input[name=time_start]').val();
        time_expired = $('input[name=time_expired]').val();
        date_start = $('input[name=date_start]').val();
        date_expired = $('input[name=date_expired]').val();
        var main_product = '';
        $('#list_product_main .li_product').each(function () {
            main_product += $(this).attr('sp') + ',';
        });
        if (ma.length < 2) {
            $('input[name=ma]').focus();
        } else if (giam == '') {
            $('input[name=giam]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'add_coupon');
            form_data.append('ma', ma);
            form_data.append('loai', loai);
            form_data.append('kieu', kieu);
            form_data.append('giam', giam);
            form_data.append('sanpham', main_product);
            form_data.append('time_start', time_start);
            form_data.append('date_start', date_start);
            form_data.append('time_expired', time_expired);
            form_data.append('date_expired', date_expired);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('body').on('click', '.list_tab_noidung .li_tab_noidung', function () {
        id = $(this).attr('tab_id');
        $('.list_tab_noidung .li_tab_noidung').removeClass('active');
        $('.list_share_sanpham .li_share_sanpham').removeClass('active');
        $(this).addClass('active');
        $('#tab_content_' + id).addClass('active');
        var file_store = [];
        if ($('input[name^=file]').length > 0) {
            $('input[name^=file]').remove();
        }

    });
    /////////////////////////////
    $('button[name=edit_coupon]').on('click', function () {
        ma = $('input[name=ma]').val();
        loai = $('select[name=loai]').val();
        giam = $('input[name=giam]').val();
        kieu = $('select[name=apdung]').val();
        time_start = $('input[name=time_start]').val();
        time_expired = $('input[name=time_expired]').val();
        date_start = $('input[name=date_start]').val();
        date_expired = $('input[name=date_expired]').val();
        var main_product = '';
        $('#list_product_main .li_product').each(function () {
            main_product += $(this).attr('sp') + ',';
        });
        id = $('input[name=id]').val();
        if (ma.length < 2) {
            $('input[name=ma]').focus();
        } else if (giam == '') {
            $('input[name=giam]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'edit_coupon');
            form_data.append('ma', ma);
            form_data.append('loai', loai);
            form_data.append('kieu', kieu);
            form_data.append('giam', giam);
            form_data.append('sanpham', main_product);
            form_data.append('time_start', time_start);
            form_data.append('date_start', date_start);
            form_data.append('time_expired', time_expired);
            form_data.append('date_expired', date_expired);
            form_data.append('id', id);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    ///////////////////////////////
    $('button[name=edit_setting_img]').on('click', function () {
        name = $('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_setting_img');
        form_data.append('file', file_data);
        form_data.append('name', name);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/list-setting';
                    } else {

                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////////
    $('button[name=edit_setting_css]').on('click', function () {
        background = $('input[name=background]').attr('data-current-color');
        topbar = $('input[name=topbar]').attr('data-current-color');
        header = $('input[name=header]').attr('data-current-color');
        hotline = $('input[name=hotline]').attr('data-current-color');
        menu = $('input[name=menu]').attr('data-current-color');
        title_menu = $('input[name=title_menu]').attr('data-current-color');
        title_box = $('input[name=title_box]').attr('data-current-color');
        button_top = $('input[name=button_top]').attr('data-current-color');
        subcribe = $('input[name=subcribe]').attr('data-current-color');
        top_menu_mobile = $('input[name=top_menu_mobile]').attr('data-current-color');
        label_sale = $('input[name=label_sale]').attr('data-current-color');
        ma_giamgia = $('input[name=ma_giamgia]').attr('data-current-color');
        top_footer = $('input[name=top_footer]').attr('data-current-color');
        text_top_footer = $('input[name=text_top_footer]').attr('data-current-color');
        bottom_footer = $('input[name=bottom_footer]').attr('data-current-color');
        text_bottom_footer = $('input[name=text_bottom_footer]').attr('data-current-color');
        timkiem = $('input[name=timkiem]').attr('data-current-color');
        nhantin = $('input[name=nhantin]').attr('data-current-color');
        text_title_top_footer = $('input[name=text_title_top_footer]').attr('data-current-color');
        id = $('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "edit_setting_css",
                name: id,
                background: background,
                topbar: topbar,
                header: header,
                hotline: hotline,
                menu: menu,
                title_menu: title_menu,
                title_box: title_box,
                button_top: button_top,
                subcribe: subcribe,
                top_menu_mobile: top_menu_mobile,
                label_sale: label_sale,
                ma_giamgia: ma_giamgia,
                top_footer: top_footer,
                bottom_footer: bottom_footer,
                text_top_footer: text_top_footer,
                text_bottom_footer: text_bottom_footer,
                timkiem: timkiem,
                nhantin: nhantin,
                text_title_top_footer: text_title_top_footer
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    ///////////////////////////////
    $('button[name=edit_setting_html]').on('click', function () {
        name = $('input[name=id]').val();
        noidung = tinyMCE.activeEditor.getContent();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    ///////////////////////////////
    $('button[name=edit_setting_text]').on('click', function () {
        name = $('input[name=id]').val();
        noidung = $('textarea[name=content]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('input[name=loai]').click(function () {
        loai = $('input[name=loai]:checked').val();
        if (loai == 'link') {
            $('#select_theloai').hide();
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').show();
        } else if (loai == 'category') {
            $('#select_theloai').hide();
            $('#select_category').show();
            $('#select_page').hide();
            $('#input_link').hide();
        } else if (loai == 'theloai') {
            $('#select_theloai').show();
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').hide();
        } else if (loai == 'page') {
            $('#select_theloai').hide();
            $('#select_category').hide();
            $('#select_page').show();
            $('#input_link').hide();
        } else {
            $('#select_theloai').hide();
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').show();
        }
    });
    /////////////////////////////
    $('#select_category select').on('change', function () {
        text = $('#select_category select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('#select_theloai select').on('change', function () {
        text = $('#select_theloai select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('#select_page select').on('change', function () {
        text = $('#select_page select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('button[name=add_ruttien]').click(function () {
        so_tien = $('input[name=so_tien]').val();
        chu_khoan = $('input[name=chu_khoan]').val();
        so_taikhoan = $('input[name=so_taikhoan]').val();
        ngan_hang = $('input[name=ngan_hang]').val();
        if (so_tien < 1000) {
            $('input[name=so_tien]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập số tiền lớn hơn 1000 đ');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (chu_khoan.length < 4) {
            $('input[name=chu_khoan]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên chủ tài khoản');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (so_taikhoan.length < 4) {
            $('input[name=so_taikhoan]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập số tài khoản');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (ngan_hang.length < 4) {
            $('input[name=ngan_hang]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên ngân hàng');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "add_ruttien",
                    so_tien: so_tien,
                    chu_khoan: chu_khoan,
                    so_taikhoan: so_taikhoan,
                    ngan_hang: ngan_hang
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            var dulieu = {
                                'hd': 'notification',
                                'bo_phan': 'tai_chinh'
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.reload();
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=add_menu]').click(function () {
        loai = $('input[name=loai]:checked').val();
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        target = $('select[name=target]').val();
        thu_tu = $('input[name=thu_tu]').val();
        vi_tri = $('select[name=vi_tri]').val();
        category = $('select[name=category]').val();
        theloai = $('select[name=theloai]').val();
        page = $('select[name=page]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (loai == 'link' && link == '') {
            $('input[name=link]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "add_menu",
                    loai: loai,
                    tieu_de: tieu_de,
                    link: link,
                    target: target,
                    thu_tu: thu_tu,
                    vi_tri: vi_tri,
                    category: category,
                    theloai: theloai,
                    page: page
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_menu]').click(function () {
        loai = $('input[name=loai]:checked').val();
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        target = $('select[name=target]').val();
        thu_tu = $('input[name=thu_tu]').val();
        vi_tri = $('select[name=vi_tri]').val();
        category = $('select[name=category]').val();
        theloai = $('select[name=theloai]').val();
        page = $('select[name=page]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (loai == 'link' && link == '') {
            $('input[name=link]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_menu",
                    loai: loai,
                    tieu_de: tieu_de,
                    link: link,
                    target: target,
                    thu_tu: thu_tu,
                    vi_tri: vi_tri,
                    category: category,
                    theloai: theloai,
                    page: page,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-menu';
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=add_slide]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_slide');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('target', target);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_slide]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_slide');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('target', target);
            form_data.append('id', id);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-slide';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_category]').on('click', function () {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank = $('input[name=cat_blank]').val();
        cat_thutu = $('input[name=cat_thutu]').val();
        cat_title = $('input[name=cat_title]').val();
        link_old = $('input[name=link_old]').val();
        cat_link = $('input[name=cat_link]').val();
        cat_description = $('textarea[name=cat_description]').val();
        cat_noidung = $('textarea[name=cat_noidung]').val();
        cat_id = $('input[name=id]').val();
        cat_icon = $('input[name=cat_icon]').val();
        cat_main = $('select[name=cat_main]').val();
        cat_index = $('input[name=cat_index]:checked').val();
        if (cat_tieude.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_category');
            form_data.append('file', file_data);
            form_data.append('cat_tieude', cat_tieude);
            form_data.append('cat_blank', cat_blank);
            form_data.append('link_old', link_old);
            form_data.append('cat_title', cat_tieude);
            form_data.append('cat_description', cat_description);
            form_data.append('cat_noidung', cat_noidung);
            form_data.append('cat_main', cat_main);
            form_data.append('cat_icon', cat_icon);
            form_data.append('cat_index', cat_index);
            form_data.append('cat_thutu', cat_thutu);
            form_data.append('cat_link', cat_link);
            form_data.append('cat_id', cat_id);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-category';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_category]').on('click', function () {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank = $('input[name=cat_blank]').val();
        cat_thutu = $('input[name=cat_thutu]').val();
        cat_title = $('input[name=cat_title]').val();
        cat_link = $('input[name=cat_link]').val();
        cat_description = $('textarea[name=cat_description]').val();
        cat_noidung = $('textarea[name=cat_noidung]').val();
        cat_main = $('select[name=cat_main]').val();
        cat_icon = $('input[name=cat_icon]').val();
        cat_index = $('input[name=cat_index]:checked').val();
        if (cat_tieude.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_thutu]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_category');
            form_data.append('file', file_data);
            form_data.append('cat_tieude', cat_tieude);
            form_data.append('cat_blank', cat_blank);
            form_data.append('cat_title', cat_tieude);
            form_data.append('cat_description', cat_description);
            form_data.append('cat_noidung', cat_noidung);
            form_data.append('cat_main', cat_main);
            form_data.append('cat_icon', cat_icon);
            form_data.append('cat_index', cat_index);
            form_data.append('cat_thutu', cat_thutu);
            form_data.append('cat_link', cat_link);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_donhang]').on('click', function () {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "edit_donhang",
                status: status,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('button[name=edit_livestream]').on('click', function () {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "edit_livestream",
                status: status,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('body').on('click', '.confirm_leader', function () {
        $('.box_pop_add').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "reg_leader",
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/list-tuyendung-nhom';
                    } else {

                    }
                }, 3000);
            }

        });
    })
    /////////////////////////////
    $('button[name=reg_leader]').on('click', function () {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "load_pop_add",
                loai: 'confirm_leader'
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_tichdiem]').on('click', function () {
        diem = $('input[name=diem]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "edit_tichdiem",
                diem: diem
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('button[name=add_livestream]').on('click', function () {
        time_start = $('input[name=time_start]').val();
        time_end = $('input[name=time_end]').val();
        ngay = $('input[name=ngay]').val();
        san_pham = $('textarea[name=san_pham]').val();
        ghi_chu = $('textarea[name=ghi_chu]').val();
        id = $('input[name=id]').val();
        if (san_pham == '') {
            $('textarea[name=san_pham]').focus();
        } else if (time_start == '') {
            $('input[name=time_start]').focus();
        } else if (ngay == '') {
            $('input[name=ngay]').focus();
        } else if (time_end == '') {
            $('input[name=time_end]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "dat_livestream",
                    ngay: ngay,
                    time_start: time_start,
                    time_end: time_end,
                    san_pham: san_pham,
                    ghi_chu: ghi_chu,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            var dulieu = {
                                'hd': 'notification',
                                'bo_phan': 'hotro_chung'
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_theloai]').on('click', function () {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank = $('input[name=cat_blank]').val();
        cat_thutu = $('input[name=cat_thutu]').val();
        cat_title = $('input[name=cat_title]').val();
        link_old = $('input[name=link_old]').val();
        cat_description = $('textarea[name=cat_description]').val();
        cat_noidung = $('textarea[name=cat_noidung]').val();
        cat_id = $('input[name=id]').val();
        cat_icon = $('input[name=cat_icon]').val();
        cat_main = $('select[name=cat_main]').val();
        cat_index = $('input[name=cat_index]:checked').val();
        if (cat_tieude.length < 2) {
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_theloai",
                    cat_tieude: cat_tieude,
                    cat_blank: cat_blank,
                    cat_title: cat_title,
                    cat_description: cat_description,
                    cat_noidung: cat_noidung,
                    cat_thutu: cat_thutu,
                    cat_main: cat_main,
                    cat_icon: cat_icon,
                    link_old: link_old,
                    cat_index: cat_index,
                    cat_id: cat_id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-theloai';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_theloai]').on('click', function () {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank = $('input[name=cat_blank]').val();
        cat_thutu = $('input[name=cat_thutu]').val();
        cat_title = $('input[name=cat_title]').val();
        cat_description = $('textarea[name=cat_description]').val();
        cat_noidung = $('textarea[name=cat_noidung]').val();
        cat_main = $('select[name=cat_main]').val();
        cat_icon = $('input[name=cat_icon]').val();
        cat_index = $('input[name=cat_index]:checked').val();
        if (cat_tieude.length < 2) {
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "add_theloai",
                    cat_tieude: cat_tieude,
                    cat_blank: cat_blank,
                    cat_title: cat_title,
                    cat_description: cat_description,
                    cat_noidung: cat_noidung,
                    cat_main: cat_main,
                    cat_icon: cat_icon,
                    cat_index: cat_index,
                    cat_thutu: cat_thutu
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_thanhvien]').on('click', function () {
        name = $('input[name=name]').val();
        active = $('select[name=active]').val();
        id = $('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_thanhvien');
        form_data.append('file', file_data);
        form_data.append('name', name);
        form_data.append('active', active);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    /////////////////////////////
    $('button[name=button_doanhthu_cuaban]').on('click', function () {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhthu_cuaban');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
                            $('#doanhthu_giao').html(info.doanhthu_giao);
                            $('#doanhthu_huy').html(info.doanhthu_huy);
                            $('#doanhthu_hoan').html(info.doanhthu_hoan);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#doanhthu_tiepnhan').html(info.doanhthu_tiepnhan);
                            $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
                            $('#donhang_giao').html(info.donhang_giao);
                            $('#donhang_huy').html(info.donhang_huy);
                            $('#donhang_hoan').html(info.donhang_hoan);
                            $('#donhang_cho').html(info.donhang_cho);
                            $('#donhang_tiepnhan').html(info.donhang_tiepnhan);
                            $('#doanhthu_hoanthanh_socdo').html(info.doanhthu_hoanthanh_socdo);
                            $('#doanhthu_giao_socdo').html(info.doanhthu_giao_socdo);
                            $('#doanhthu_huy_socdo').html(info.doanhthu_huy_socdo);
                            $('#doanhthu_hoan_socdo').html(info.doanhthu_hoan_socdo);
                            $('#doanhthu_cho_socdo').html(info.doanhthu_cho_socdo);
                            $('#doanhthu_tiepnhan_socdo').html(info.doanhthu_tiepnhan_socdo);
                            $('#donhang_hoanthanh_socdo').html(info.donhang_hoanthanh_socdo);
                            $('#donhang_giao_socdo').html(info.donhang_giao_socdo);
                            $('#donhang_huy_socdo').html(info.donhang_huy_socdo);
                            $('#donhang_hoan_socdo').html(info.donhang_hoan_socdo);
                            $('#donhang_cho_socdo').html(info.donhang_cho_socdo);
                            $('#donhang_tiepnhan_socdo').html(info.donhang_tiepnhan_socdo);
                            $('#doanhthu_hoanthanh_aff').html(info.doanhthu_hoanthanh_aff);
                            $('#doanhthu_giao_aff').html(info.doanhthu_giao_aff);
                            $('#doanhthu_huy_aff').html(info.doanhthu_huy_aff);
                            $('#doanhthu_hoan_aff').html(info.doanhthu_hoan_aff);
                            $('#doanhthu_cho_aff').html(info.doanhthu_cho_aff);
                            $('#doanhthu_tiepnhan_aff').html(info.doanhthu_tiepnhan_aff);
                            $('#donhang_hoanthanh_aff').html(info.donhang_hoanthanh_aff);
                            $('#donhang_giao_aff').html(info.donhang_giao_aff);
                            $('#donhang_huy_aff').html(info.donhang_huy_aff);
                            $('#donhang_hoan_aff').html(info.donhang_hoan_aff);
                            $('#donhang_cho_aff').html(info.donhang_cho_aff);
                            $('#donhang_tiepnhan_aff').html(info.donhang_tiepnhan_aff);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_doanhthu]').on('click', function () {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhthu');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
                            $('#doanhthu_giao').html(info.doanhthu_giao);
                            $('#doanhthu_huy').html(info.doanhthu_huy);
                            $('#doanhthu_hoan').html(info.doanhthu_hoan);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#doanhthu_tiepnhan').html(info.doanhthu_tiepnhan);
                            $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
                            $('#donhang_giao').html(info.donhang_giao);
                            $('#donhang_huy').html(info.donhang_huy);
                            $('#donhang_hoan').html(info.donhang_hoan);
                            $('#donhang_cho').html(info.donhang_cho);
                            $('#donhang_tiepnhan').html(info.donhang_tiepnhan);
                            $('#donhang_hoanthanh_san b').html(info.doanhthu_hoanthanh_san);
                            $('#donhang_giao_san b').html(info.doanhthu_giao_san);
                            $('#donhang_huy_san b').html(info.doanhthu_huy_san);
                            $('#donhang_hoan_san b').html(info.doanhthu_hoan_san);
                            $('#donhang_cho_san b').html(info.doanhthu_cho_san);
                            $('#donhang_tiepnhan_san b').html(info.doanhthu_tiepnhan_san);
                            $('#donhang_hoanthanh_san span').html(info.donhang_hoanthanh_san);
                            $('#donhang_giao_san span').html(info.donhang_giao_san);
                            $('#donhang_huy_san span').html(info.donhang_huy_san);
                            $('#donhang_hoan_san span').html(info.donhang_hoan_san);
                            $('#donhang_cho_san span').html(info.donhang_cho_san);
                            $('#donhang_tiepnhan_san span').html(info.donhang_tiepnhan_san);
                            $('#donhang_hoanthanh_socdo b').html(info.doanhthu_hoanthanh_socdo);
                            $('#donhang_giao_socdo b').html(info.doanhthu_giao_socdo);
                            $('#donhang_huy_socdo b').html(info.doanhthu_huy_socdo);
                            $('#donhang_hoan_socdo b').html(info.doanhthu_hoan_socdo);
                            $('#donhang_cho_socdo b').html(info.doanhthu_cho_socdo);
                            $('#donhang_tiepnhan_socdo b').html(info.doanhthu_tiepnhan_socdo);
                            $('#donhang_hoanthanh_socdo span').html(info.donhang_hoanthanh_socdo);
                            $('#donhang_giao_socdo span').html(info.donhang_giao_socdo);
                            $('#donhang_huy_socdo span').html(info.donhang_huy_socdo);
                            $('#donhang_hoan_socdo span').html(info.donhang_hoan_socdo);
                            $('#donhang_cho_socdo span').html(info.donhang_cho_socdo);
                            $('#donhang_tiepnhan_socdo span').html(info.donhang_tiepnhan_socdo);
                            $('#donhang_hoanthanh_aff b').html(info.doanhthu_hoanthanh_aff);
                            $('#donhang_giao_aff b').html(info.doanhthu_giao_aff);
                            $('#donhang_huy_aff b').html(info.doanhthu_huy_aff);
                            $('#donhang_hoan_aff b').html(info.doanhthu_hoan_aff);
                            $('#donhang_cho_aff b').html(info.doanhthu_cho_aff);
                            $('#donhang_tiepnhan_aff b').html(info.doanhthu_tiepnhan_aff);
                            $('#donhang_hoanthanh_aff span').html(info.donhang_hoanthanh_aff);
                            $('#donhang_giao_aff span').html(info.donhang_giao_aff);
                            $('#donhang_huy_aff span').html(info.donhang_huy_aff);
                            $('#donhang_hoan_aff span').html(info.donhang_hoan_aff);
                            $('#donhang_cho_aff span').html(info.donhang_cho_aff);
                            $('#donhang_tiepnhan_aff span').html(info.donhang_tiepnhan_aff);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
   // $('button[name=button_hoahong]').on('click', function () {
    //     time_begin = $('input[name=begin]').val();
    //     time_end = $('input[name=end]').val();
    //     if (time_begin.length < 10) {
    //         $('input[name=begin]').focus();
    //     } else if (time_end.length < 10) {
    //         $('input[name=end]').focus();
    //     } else {
    //         $('.load_overlay').show();
    //         $('.load_process').fadeIn();
    //         var form_data = new FormData();
    //         form_data.append('action', 'load_hoahong');
    //         form_data.append('time_begin', time_begin);
    //         form_data.append('time_end', time_end);
    //         $.ajax({
    //             url: '/admin/process.php',
    //             type: 'post',
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             data: form_data,
    //             success: function (kq) {
    //                 var info = JSON.parse(kq);
    //                 setTimeout(function () {
    //                     $('.load_note').html(info.thongbao);
    //                 }, 1000);
    //                 setTimeout(function () {
    //                     $('.load_process').hide();
    //                     $('.load_note').html('Hệ thống đang xử lý');
    //                     $('.load_overlay').hide();
    //                     if (info.ok == 1) {
    //                         $('#hoahong_nangcap').html(info.doanhthu_nangcap);
    //                         $('#donhang_nangcap').html(info.donhang_nangcap);
    //                         $('#hoahong_nhom').html(info.doanhthu_nhom);
    //                         $('#donhang_nhom').html(info.donhang_nhom);
    //                         $('#doanhthu_nhom_gioithieu').html(info.doanhthu_nhom_gioithieu);
    //                         $('#donhang_nhom_gioithieu').html(info.donhang_nhom_gioithieu);
    //                         $('#doanhthu_tong').html(info.doanhthu_tong);
    //                         $('#donhang_tong').html(info.donhang_tong);
    //                     } else {

    //                     }
    //                 }, 2000);
    //             }

    //         });
    //     }
    // });
    /////////////////////////////
    $('button[name=login]').on('click', function () {
        password = $('input[name=password]').val();
        username = $('input[name=username]').val();
        remember = $('.remember').attr('value');
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process_login.php",
                type: "post",
                data: {
                    username: username,
                    password: password,
                    remember: remember
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/dashboard';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=forgot_password]').on('click', function () {
        email = $('input[name=email]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "forgot_password",
                email: email
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
                setTimeout(function () {
                    if (info.ok == 1) {
                        window.location.href = '/forgot-password?step=2';
                    } else {

                    }
                }, 3500);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_domain]').on('click', function () {
        domain = $('input[name=domain]').val();
        if (domain.length < 5) {
            $('input[name=domain]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_domain",
                    domain: domain
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {

                    }
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }

            });
        }

    });
    //////////////////////////
    $('.list_shopcart').on('click', '.button_plus', function () {
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
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_shopcart',
                sp_id: id,
                quantity: quantity
            },
            success: function (kq) {
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
    $('.list_shopcart ').on('click', '.button_minus', function () {
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
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_shopcart',
                sp_id: id,
                quantity: quantity
            },
            success: function (kq) {
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
    $('.list_shopcart ').on('keyup', 'input[name=quantity]', function () {
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
            } else { }
        }
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_shopcart',
                sp_id: id,
                quantity: quantity
            },
            success: function (kq) {
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
    $('.list_shopcart ').on('click', '.remove_cart', function () {
        id = $(this).attr('sp_id');
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'remove_shopcart',
                sp_id: id
            },
            success: function (kq) {
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
    $('body').on('change', '#load_huyen', function () {
        tinh = $(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_huyen',
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_profile select[name=huyen]').html(info.list);
                $('.box_profile select[name=xa]').html('<option value="">Chọn Xã/phường</option>');
            }
        });
    });
    $('body').on('change', '#load_xa', function () {
        huyen = $(this).val();
        $.ajax({
            url: '/process.php',
            type: 'post',
            data: {
                action: 'load_xa',
                huyen: huyen
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_profile select[name=xa]').html(info.list);
            }
        });
    });
    //////////////////////////
    $('#customer_shipping_district_bt').on('change', function () {
        if ($('select[name=congty_ship]').length > 0) {
            congty_ship = $('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        huyen = $(this).val();
        tinh = $('select[name=tinh]').val();
        if (tinh != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_xa',
                    congty_ship: congty_ship,
                    tinh: tinh,
                    huyen: huyen
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#customer_shipping_ward_bt').html('<option value="">Chọn xã / phường</option>' + info.list);
                    $('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>');
                }
            });
        } else {

        }
    });
    //////////////////////////
    $('body').on('change', '#customer_shipping_district_gop', function () {
        var div_this = $(this);
        if (div_this.parent().parent().parent().find('select[name=congty_ship]').length > 0) {
            congty_ship = div_this.parent().parent().parent().find('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        huyen = $(this).val();
        tinh = $(this).parent().parent().parent().find('select[name=tinh]').val();
        if (tinh != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_xa',
                    congty_ship: congty_ship,
                    tinh: tinh,
                    huyen: huyen
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this.parent().parent().parent().find('#customer_shipping_ward_gop').html('<option value="">Chọn xã / phường</option>' + info.list);
                    div_this.parent().parent().parent().find('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>');
                }
            });
        } else {

        }

    });
    //////////////////////////
    $('#customer_shipping_province_bt').on('change', function () {
        if ($('select[name=congty_ship]').length > 0) {
            congty_ship = $('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        tinh = $(this).val();
        if (tinh != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_huyen',
                    congty_ship: congty_ship,
                    tinh: tinh
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#customer_shipping_district_bt').html('<option value="">Chọn quận / huyện</option>' + info.list);
                    $('#customer_shipping_ward_bt').html('<option value="">Chọn xã / phường</option>');
                    $('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>');
                }
            });
        } else {

        }

    });
    //////////////////////////
    $('body').on('change', '#customer_shipping_province_gop', function () {
        var div_this = $(this);
        if (div_this.parent().parent().parent().find('select[name=congty_ship]').length > 0) {
            congty_ship = div_this.parent().parent().parent().find('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        tinh = $(this).val();
        if (tinh != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_huyen',
                    congty_ship: congty_ship,
                    tinh: tinh
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this.parent().parent().parent().find('#customer_shipping_district_gop').html('<option value="">Chọn quận / huyện</option>' + info.list);
                    div_this.parent().parent().parent().find('#customer_shipping_ward_gop').html('<option value="">Chọn xã / phường</option>');
                    div_this.parent().parent().parent().find('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>');
                }
            });
        } else {

        }

    });
    //////////////////////////
    $('select[name=congty_ship]').on('change', function () {
        var div_this = $(this);
        if (div_this.parent().parent().parent().find('select[name=congty_ship]').length > 0) {
            congty_ship = div_this.parent().parent().parent().find('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        if (congty_ship != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_tinh',
                    congty_ship: congty_ship,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this.parent().parent().parent().find('#customer_shipping_province_bt').html('<option value="">Chọn tỉnh/thành phố</option>' + info.list);
                    div_this.parent().parent().parent().find('#customer_shipping_district_bt').html('<option value="">Chọn quận / huyện</option>');
                    div_this.parent().parent().parent().find('#customer_shipping_ward_bt').html('<option value="">Chọn xã / phường</option>');
                    div_this.parent().parent().parent().find('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>');
                }
            });
        } else {

        }

    });
    //////////////////////////
    $('body').on('change', '.box_khach_order select[name=congty_ship]', function () {
        var div_this = $(this);
        if (div_this.parent().parent().parent().find('select[name=congty_ship]').length > 0) {
            congty_ship = div_this.parent().parent().parent().find('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        if (congty_ship != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_tinh',
                    congty_ship: congty_ship,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this.parent().parent().parent().find('#customer_shipping_province_gop').html('<option value="">Chọn tỉnh/thành phố</option>' + info.list);
                    div_this.parent().parent().parent().find('#customer_shipping_district_gop').html('<option value="">Chọn quận / huyện</option>');
                    div_this.parent().parent().parent().find('#customer_shipping_ward_gop').html('<option value="">Chọn xã / phường</option>');
                    div_this.parent().parent().parent().find('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>');
                }
            });
        } else {

        }

    });
    //////////////////////////
    $('#customer_shipping_ward_bt').on('change', function () {
        tinh = $('#customer_shipping_province_bt').val();
        huyen = $('#customer_shipping_district_bt').val();
        xa = $('#customer_shipping_ward_bt').val();
        cod = $('input[name=cod]').val();
        if ($('select[name=congty_ship]').length > 0) {
            congty_ship = $('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        if (tinh != '' && huyen != '' && xa != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_dichvu',
                    tinh: tinh,
                    huyen: huyen,
                    xa: xa,
                    congty_ship: congty_ship,
                    cod: cod
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>' + info.list);
                }
            });
        } else {

        }
    });
    //////////////////////////
    $('body').on('change', '#customer_shipping_ward_gop', function () {
        var div_this = $(this);
        tinh = div_this.parent().parent().parent().find('#customer_shipping_province_gop').val();
        huyen = div_this.parent().parent().parent().find('#customer_shipping_district_gop').val();
        xa = div_this.parent().parent().parent().find('#customer_shipping_ward_gop').val();
        cod = div_this.parent().parent().parent().find('input[name=cod]').val();
        don = div_this.parent().parent().parent().find('.info_don_hang').attr('box');
        tamtinh = div_this.parent().parent().parent().find('.tongtien_don span').html();
        if (div_this.parent().parent().parent().find('select[name=congty_ship]').length > 0) {
            congty_ship = div_this.parent().parent().parent().find('select[name=congty_ship]').val();
            if (congty_ship == 'ninja_van') {
                congty_ship = 'ninja_van';
            } else {
                congty_ship = 'viettel_post';
            }
        } else {
            congty_ship = 'viettel_post';
        }
        if (tamtinh == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $(this).val('');
            setTimeout(function () {
                $('.load_note').html('Thất bại! Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);

        } else if (cod == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $(this).val('');
            setTimeout(function () {
                $('.load_note').html('Thất bại! Vui lòng nhập tiền COD');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (tinh != '' && huyen != '' && xa != '') {
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                data: {
                    action: 'load_dichvu_gop',
                    tinh: tinh,
                    huyen: huyen,
                    xa: xa,
                    congty_ship: congty_ship,
                    don: don,
                    tamtinh: tamtinh,
                    cod: cod
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this.parent().parent().parent().find('select[name=dichvu_ship]').html('<option value="">Chọn dịch vụ</option>' + info.list);
                }
            });
        } else {

        }
    });
    //////////////////////////
    $('body').on('change', '.box_order_info_left_bt select[name=dichvu_ship]', function () {
        var div_this = $(this);
        phi_ship = div_this.parent().parent().parent().find('select[name=dichvu_ship] option:selected').attr('phi_ship');
        phi_ship_text = div_this.parent().parent().parent().find('select[name=dichvu_ship] option:selected').attr('phi_ship_text');
        $('.total_phi').attr('phi', phi_ship);
        $('.total_phi').html(phi_ship_text);
        total_price = $('.total_price').attr('total_price');
        phi_ship = $('.total_phi').attr('phi');
        chiu_ship = div_this.parent().parent().parent().find('select[name=chiu_ship]').val();
        cod = div_this.parent().parent().parent().find('input[name=cod]').val();
        cod = cod.replace(/,/g, "");
        if (chiu_ship == 'shop') {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        $('.total_hoahong').html(format_price(hoahong) + 'đ');
    });
    //////////////////////////
    $('body').on('change', '.box_order_info_left_gop select[name=dichvu_ship]', function () {
        var div_this = $(this);
        phi_ship = div_this.parent().parent().parent().find('select[name=dichvu_ship] option:selected').attr('phi_ship');
        phi_ship_text = div_this.parent().parent().parent().find('select[name=dichvu_ship] option:selected').attr('phi_ship_text');
        div_this.parent().parent().parent().find('.phiship_don').attr('phi', phi_ship);
        div_this.parent().parent().parent().find('.phiship_don span').html(phi_ship_text);

        total_price = div_this.parent().parent().parent().find('.tongtien_don').attr('total_price');
        phi_ship = div_this.parent().parent().parent().find('.phiship_don').attr('phi');
        chiu_ship = div_this.parent().parent().parent().find('select[name=chiu_ship]').val();
        cod = div_this.parent().parent().parent().find('input[name=cod]').val();
        cod = cod.replace(/,/g, "");
        if (chiu_ship == 'shop') {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        div_this.parent().parent().parent().find('.hoahong_don span').html(format_price(hoahong) + 'đ');
    });
    ///////////////////
    $('body').on('keyup', '.box_order_info_left_bt input[name=cod]', function () {
        total_price = $('.total_price').attr('total_price');
        phi_ship = $('.total_phi').attr('phi');
        chiu_ship = $('select[name=chiu_ship]').val();
        cod = $(this).val();
        if (cod.length < 4) {
        } else {
            cod = cod.replace(/,/g, '');
            cod = parseFloat(cod, 2);
            $(this).val(format_price(cod));
        }
        if (chiu_ship == 'shop') {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        $('.total_hoahong').html(format_price(hoahong) + 'đ');
    });
    ///////////////////
    $('body').on('keyup', '.box_order_info_left_gop input[name=cod]', function () {
        var div_this = $(this);
        total_price = div_this.parent().parent().parent().find('.tongtien_don').attr('total_price');
        phi_ship = div_this.parent().parent().parent().find('.phiship_don').attr('phi');
        chiu_ship = div_this.parent().parent().parent().find('select[name=chiu_ship]').val();
        cod = $(this).val();
        if (cod.length < 4) {
        } else {
            cod = cod.replace(/,/g, '');
            cod = parseFloat(cod, 2);
            $(this).val(format_price(cod));
        }
        if (chiu_ship == 'shop') {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        div_this.parent().parent().parent().find('.hoahong_don span').html(format_price(hoahong) + 'đ');
    });
    /////////////////////////////
    $('body').on('change', '.box_order_info_left_bt select[name=chiu_ship]', function () {
        total_price = $('.total_price').attr('total_price');
        phi_ship = $('.total_phi').attr('phi');
        chiu_ship = $('select[name=chiu_ship]').val();
        cod = $('input[name=cod]').val();
        cod = cod.replace(/,/g, "");
        if (chiu_ship == 'shop') {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        $('.total_hoahong').html(format_price(hoahong) + 'đ');

    });
    ////////////////////////////
    $('body').on('change', '.box_order_info_left_gop select[name=chiu_ship]', function () {
        var div_this = $(this);
        total_price = div_this.parent().parent().parent().find('.tongtien_don').attr('total_price');
        phi_ship = div_this.parent().parent().parent().find('.phiship_don').attr('phi');
        chiu_ship = div_this.parent().parent().parent().find('select[name=chiu_ship]').val();
        cod = div_this.parent().parent().parent().find('input[name=cod]').val();
        cod = cod.replace(/,/g, "");
        if (chiu_ship == 'shop') {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        div_this.parent().parent().parent().find('.hoahong_don span').html(format_price(hoahong) + 'đ');

    });
    //////////////////////////
    $('.button_dathang').on('click', function () {
        var list_mau = '';
        $('.li_shopcart').each(function () {
            if ($(this).find('input').length > 0) {
                mau = $(this).find('input:checked').val();
                sp_id = $(this).find('input:checked').attr('sp_id');
                list_mau += sp_id + '&&' + mau + '|';
            }
        });
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_mau',
                list_mau: list_mau
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/add-donhang-drop?step=3&type=san';
                    }
                }, 3000);

            }
        });
    });
    //////////////////////////
    $('.button_dathang_gopdon').on('click', function () {
        var list_mau = '';
        $('.li_shopcart').each(function () {
            if ($(this).find('input').length > 0) {
                mau = $(this).find('input:checked').val();
                sp_id = $(this).find('input:checked').attr('sp_id');
                list_mau += sp_id + '&&' + mau + '|';
            }
        });
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_mau',
                list_mau: list_mau
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/add-donhang-drop?step=3&type=gopdon';
                    }
                }, 3000);

            }
        });
    });
    //////////////////////////
    $('.add_order .li_doituong').on('click', function () {
        khach = $(this).attr('khach');
        total_sp = $('.li_shopcart_right').length;
        total_kh = $('.box_khach_order').length;
        if (total_sp <= total_kh) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Thất bại! Số người nhận vượt quá số sản phẩm');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (total_kh >= 5) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Thất bại! Chỉ thêm tối đa 5 người nhận');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else {
            if (total_kh < 1) {
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: 'add_doituong',
                        khach: khach
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $('.list_khach_order').find('.info_khach_order:visible').parent().find('.title').click();
                        $('.list_khach_order').append(info.html);
                        i = 0;
                        $('.box_khach_order').each(function () {
                            i++;
                            $(this).find('.number').html(i);
                            if ($(this).find('.info_don_hang').length > 0) {
                                $(this).find('.info_don_hang').attr('box', i);
                            }
                        });
                        $('.li_shopcart_right').each(function () {
                            don = 1;
                            sp_id = $(this).find('.list_kh').attr('sp_id');
                            sl = $(this).find('.list_kh').attr('sl');
                            stt = $(this).find('.list_kh').attr('i');
                            //$(this).parent().hide();
                            $(this).find('.don span').html(don);
                            $.ajax({
                                url: '/admin/process.php',
                                type: 'post',
                                data: {
                                    action: 'update_cart_gop',
                                    don: don,
                                    sp_id: sp_id,
                                    sl: sl,
                                    stt: stt
                                },
                                success: function (kq) {
                                    var info = JSON.parse(kq);
                                    var don_this = '';
                                    $('.box_khach_order').each(function () {
                                        don_this = $(this).find('.title .number').html();
                                        if (typeof info.tongtien_don[don_this] !== 'undefined') {
                                            $(this).find('.tongtien_don').attr('total_price', info.tongtien_don[don_this]);
                                            $(this).find('.tongtien_don span').html(format_price(info.tongtien_don[don_this]) + ' đ');
                                        } else {
                                        }
                                    });
                                }
                            });
                        });
                        $('.button_hoanthanh').show();
                    }
                });
            } else {
                $.ajax({
                    url: '/admin/process.php',
                    type: 'post',
                    data: {
                        action: 'add_doituong',
                        khach: khach
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $('.list_khach_order').find('.info_khach_order:visible').parent().find('.title').click();
                        $('.list_khach_order').append(info.html);
                        i = 0;
                        $('.box_khach_order').each(function () {
                            i++;
                            $(this).find('.number').html(i);
                            if ($(this).find('.info_don_hang').length > 0) {
                                $(this).find('.info_don_hang').attr('box', i);
                            }
                        });
                        $('.button_hoanthanh').show();
                    }
                });
            }
        }
    });
    //////////////////////////
    $('body').on('click', '.list_khach_order .box_khach_order .title', function () {
        $(this).parent().find('.info_khach_order').toggle();
        $(this).parent().find('.fa-chevron-up').toggle();
        $(this).parent().find('.fa-chevron-down').toggle();
    });
    //////////////////////////
    $('body').on('click', '.del_khach_order', function () {
        $(this).parent().parent().parent().remove();
        i = 0;
        total_kh = $('.box_khach_order').length;
        if (total_kh == 0) {
            $('.button_hoanthanh').hide();
        } else {
            $('.button_hoanthanh').show();
        }
        $('.box_khach_order').each(function () {
            i++;
            $(this).find('.number').html(i);
            $('.don span').html('Chọn');
            if ($(this).find('.info_don_hang').length > 0) {
                $(this).find('.info_don_hang').attr('box', i);
            }
        });
    });
    //////////////////////////
    $('body').on('click', '.li_shopcart_right .info .tieude .action_gop .don span', function () {
        total_kh = $('.box_khach_order').length;
        var div_sp = $(this);
        div_sp.parent().parent().find('.list_kh').html('');
        if (total_kh > 0) {
            i = 0;
            $('.box_khach_order').each(function () {
                i++;
                div_sp.parent().parent().find('.list_kh').append('<div class="li_kh">Khách hàng <span>' + i + '</span></div>');
            });
            div_sp.parent().parent().find('.list_kh').toggle();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Thất bại! Vui lòng thêm người nhận trước');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        }
    });
    //////////////////////////
    $('body').on('click', '.li_shopcart_right .info .tieude .list_kh .li_kh', function () {
        don = $(this).find('span').html();
        sp_id = $(this).parent().attr('sp_id');
        sl = $(this).parent().attr('sl');
        stt = $(this).parent().attr('i');
        $(this).parent().hide();
        $(this).parent().parent().find('.don span').html(don);
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_cart_gop',
                don: don,
                sp_id: sp_id,
                sl: sl,
                stt: stt
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                var don_this = '';
                $('.box_khach_order').each(function () {
                    don_this = $(this).find('.title .number').html();
                    if (typeof info.tongtien_don[don_this] !== 'undefined') {
                        $(this).find('.tongtien_don').attr('total_price', info.tongtien_don[don_this]);
                        $(this).find('.tongtien_don span').html(format_price(info.tongtien_don[don_this]) + ' đ');
                    } else {
                    }
                });
            }
        });
    });
    //////////////////////////
    $('.button_dathang_socdo').on('click', function () {
        var list_mau = '';
        $('.li_shopcart').each(function () {
            if ($(this).find('input').length > 0) {
                mau = $(this).find('input:checked').val();
                sp_id = $(this).find('input:checked').attr('sp_id');
                list_mau += sp_id + '&&' + mau + '|';
            }
        });
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admin/process.php',
            type: 'post',
            data: {
                action: 'update_mau',
                list_mau: list_mau
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admin/add-donhang-drop?step=3&type=socdo';
                    }
                }, 3000);

            }
        });
    });
    /////////////////////////////
    $('button[name=button_profile]').on('click', function () {
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        maso_thue = $('input[name=maso_thue]').val();
        maso_thue_cap = $('input[name=maso_thue_cap]').val();
        maso_thue_noicap = $('input[name=maso_thue_noicap]').val();
        email = $('input[name=email]').val();
        dia_chi = $('input[name=dia_chi]').val();
        tinh = $('select[name=tinh]').val();
        huyen = $('select[name=huyen]').val();
        xa = $('select[name=xa]').val();
        if (name.length < 2) {
            $('input[name=name]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "edit_profile",
                    name: name,
                    mobile: mobile,
                    email: email,
                    dia_chi: dia_chi,
                    tinh: tinh,
                    huyen: huyen,
                    xa: xa,
                    maso_thue: maso_thue,
                    maso_thue_noicap: maso_thue_noicap,
                    maso_thue_cap: maso_thue_cap
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            //window.location.reload();
                        }, 3000);
                    } else {

                    }
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('.button_change_avatar').click(function () {
        $('#file').click();
    });
    /////////////////////////////
    $('.cover_now .button_change').click(function () {
        $('#file_cover').click();
    });
    /////////////////////////////
    $('.button_check_domain').on('click', function () {
        key_domain = $('textarea[name=key_domain]').val();
        var list_loai = [];
        $('input[name^=loai_domain]:checked').each(function () {
            list_loai.push($(this).val());
        });
        list_loai = list_loai.toString();
        if (key_domain.length < 2) {
            $('textarea[name=key_domain]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng nhập tên miền cần kiểm tra');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (list_loai.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn loại tên miền');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);

        } else {
            var form_data = new FormData();
            form_data.append('action', 'get_domain');
            form_data.append('key_domain', key_domain);
            form_data.append('list_loai', list_loai);
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('.list_result').html(info.list);
                        check_domain();
                    } else {
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
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
    $('button[name=add_sanpham_ngoai]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        kho = $('input[name=kho]').val();
        var list_photo = [];
        $('.list_photo img').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        /*        var list_size = [];
                $('.li_input input[name^=size]:checked').each(function() {
                    list_size.push($(this).val());
                });
                list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2 = $('input[name=size_2]').val();
        can_nang = $('input[name=can_nang]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2 = $('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function () {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (gia_cu == '') {
            $('input[name=gia_cu]').focus();
        } else if (gia_moi == '') {
            $('input[name=gia_moi]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title == '') {
            $('input[name=title]').focus();
        } else if (description == '') {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_sanpham_ngoai');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('kho', kho);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('category', list_cat);
            form_data.append('color', list_color);
            form_data.append('size', size);
            form_data.append('size_2', size_2);
            form_data.append('can_nang', can_nang);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('thuong_hieu_2', thuong_hieu_2);
            form_data.append('info', list_info);
            form_data.append('noibat', noibat);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_sanpham_ngoai]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        kho = $('input[name=kho]').val();
        can_nang = $('input[name=can_nang]').val();
        id = $('input[name=id]').val();
        var list_photo = [];
        $('.list_photo img').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        /*        var list_size = [];
                $('.li_input input[name^=size]:checked').each(function() {
                    list_size.push($(this).val());
                });
                list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2 = $('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2 = $('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function () {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (gia_cu == '') {
            $('input[name=gia_cu]').focus();
        } else if (gia_moi == '') {
            $('input[name=gia_moi]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title == '') {
            $('input[name=title]').focus();
        } else if (description == '') {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_sanpham_ngoai');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('kho', kho);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('link_old', link_old);
            form_data.append('category', list_cat);
            form_data.append('color', list_color);
            form_data.append('size', size);
            form_data.append('size_2', size_2);
            form_data.append('can_nang', can_nang);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('thuong_hieu_2', thuong_hieu_2);
            form_data.append('info', list_info);
            form_data.append('noibat', noibat);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=add_sanpham_affiliate]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        link_aff = $('input[name=link_aff]').val();
        var list_photo = [];
        $('.list_photo img').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        /*        var list_size = [];
                $('.li_input input[name^=size]:checked').each(function() {
                    list_size.push($(this).val());
                });
                list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2 = $('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2 = $('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function () {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (gia_cu == '') {
            $('input[name=gia_cu]').focus();
        } else if (gia_moi == '') {
            $('input[name=gia_moi]').focus();
        } else if (link_aff == '') {
            $('input[name=link_aff]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title == '') {
            $('input[name=title]').focus();
        } else if (description == '') {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_sanpham_affiliate');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('link_aff', link_aff);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('category', list_cat);
            form_data.append('color', list_color);
            form_data.append('size', size);
            form_data.append('size_2', size_2);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('thuong_hieu_2', thuong_hieu_2);
            form_data.append('info', list_info);
            form_data.append('noibat', noibat);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_sanpham_affiliate]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        link_aff = $('input[name=link_aff]').val();
        id = $('input[name=id]').val();
        var list_photo = [];
        $('.list_photo img').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        /*        var list_size = [];
                $('.li_input input[name^=size]:checked').each(function() {
                    list_size.push($(this).val());
                });
                list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2 = $('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2 = $('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function () {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (gia_cu == '') {
            $('input[name=gia_cu]').focus();
        } else if (gia_moi == '') {
            $('input[name=gia_moi]').focus();
        } else if (link_aff == '') {
            $('input[name=link_aff]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title == '') {
            $('input[name=title]').focus();
        } else if (description == '') {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_sanpham_affiliate');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('link_aff', link_aff);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('link_old', link_old);
            form_data.append('category', list_cat);
            form_data.append('color', list_color);
            form_data.append('size', size);
            form_data.append('size_2', size_2);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('thuong_hieu_2', thuong_hieu_2);
            form_data.append('info', list_info);
            form_data.append('noibat', noibat);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=add_sanpham]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        sp_id = $('input[name=sp_id]').val();
        gia_moi = $('input[name=gia_moi]').val();
        can_nang = $('input[name=can_nang]').val();
        var list_photo = [];
        $('.list_photo img').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function () {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        var list_info = '';
        $('.li_info').each(function () {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (gia_cu == '') {
            $('input[name=gia_cu]').focus();
        } else if (gia_moi == '') {
            $('input[name=gia_moi]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title == '') {
            $('input[name=title]').focus();
        } else if (description == '') {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_sanpham');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('sp_id', sp_id);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('category', list_cat);
            form_data.append('color', list_color);
            form_data.append('size', list_size);
            form_data.append('can_nang', can_nang);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('info', list_info);
            form_data.append('noibat', noibat);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admin/list-sanpham';
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=edit_sanpham]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        can_nang = $('input[name=can_nang]').val();
        var list_photo = [];
        $('.list_photo img').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function () {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        var list_info = '';
        $('.li_info').each(function () {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        minh_hoa = $('#preview-minhhoa').attr('src');
        id = $('input[name=sp_id]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (gia_cu == '') {
            $('input[name=gia_cu]').focus();
        } else if (gia_moi == '') {
            $('input[name=gia_moi]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title == '') {
            $('input[name=title]').focus();
        } else if (description == '') {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_sanpham');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('link_old', link_old);
            form_data.append('category', list_cat);
            form_data.append('color', list_color);
            form_data.append('size', list_size);
            form_data.append('can_nang', can_nang);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('info', list_info);
            form_data.append('noibat', noibat);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=add_post]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function () {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_minhhoa = $('#preview-minhhoa').offset().top;
                $('html,body').stop().animate({ scrollTop: top_minhhoa - 150 }, 500, 'swing', function () { });
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title.length < 3) {
            $('input[name=title]').focus();
        } else if (description.length < 3) {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_post');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('title', title);
            form_data.append('link', link);
            form_data.append('category', list_cat);
            form_data.append('description', description);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=edit_post]').on('click', function () {
        tieu_de = $('input[name=tieu_de]').val();
        title = $('input[name=title]').val();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input:checked').each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        id = $('input[name=id]').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else if (title.length < 3) {
            $('input[name=title]').focus();
        } else if (description.length < 3) {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_post');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('link', link);
            form_data.append('link_old', link_old);
            form_data.append('category', list_cat);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admin/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=button_password]').on('click', function () {
        old_pass = $('input[name=password_old]').val();
        new_pass = $('input[name=password]').val();
        confirm = $('input[name=confirm]').val();
        if (old_pass.length < 6) {
            $('input[name=password_old]').focus();
        } else if (new_pass.length < 6) {
            $('input[name=password]').focus();
        } else if (new_pass != confirm) {
            $('input[name=confirm]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('input[name=password_old]').val('');
                            $('input[name=password]').val('');
                            $('input[name=confirm]').val('');
                        }
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('input[name=goi_y]').on('keyup', function () {
        tieu_de = $(this).val();
        cat = $('select[name=category]').val();
        if (tieu_de.length < 2) { } else {
            $.ajax({
                url: "/admin/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat: cat,
                    tieu_de: tieu_de
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.khung_goi_y ul').html(info.list);
                    if (info.list.length > 10) {
                        $('.khung_goi_y').show();
                    } else {
                        $('.khung_goi_y').hide();

                    }
                }

            });

        }
        e.stopPropagation();
    });
    /////////////////////////////
    setTimeout(function () {
        $.ajax({
            url: "/admin/process.php",
            type: "post",
            data: {
                action: "get_popup"
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_popup .content_box').html(info.content);
                    $('.box_popup').fadeIn();
                }
                $('.total_thongbao').html(info.total);
            }

        });

    }, 3000);
    $('.box_popup .box_title i').click(function () {
        $('.box_popup').fadeOut();
    });
    /////////////////////////////
    $('.khung_sanpham').on('click', 'ul li i', function () {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.khung_goi_y').on('click', 'ul li', function (e) {
        text = $(this).find('span').text();
        id = $(this).attr('value');
        $('.khung_sanpham ul').prepend('<li value="' + id + '"><i class="icon icofont-close-circled"></i><span>' + text + '</span></li>');
        e.stopPropagation();
    });
    $('.box_video .close').on('click', function () {
        $('.box_video').hide();
    });
    $('.pop_video').on('click', function () {
        video = $(this).attr('video');
        if (video == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Chưa có video giới thiệu');
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        } else {
            $('.box_video iframe').attr('src', 'https://www.youtube.com/embed/' + video);
            $('.box_video').show();
        }
    });
    /////////////////////////////
    $(document).click(function () {
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
});