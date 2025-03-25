//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
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
        url: '/ctv/process.php',
        type: 'post',
        data: {
            action: 'check_domain',
            domain: domain
        },
        success: function(kq) {
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
        url: "/ctv/process.php",
        type: "post",
        data: {
            action: "check_post",
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            if(info.ok==1){
                window.location.href='/ctv/add-sanpham?step=2&id='+id
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $('.load_note').html(info.thongbao);
                setTimeout(function() {
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
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link,
                loai: loai
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

function check_blank(loai) {
    link = $('.tieude_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link,
                loai: loai
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

function tuchoi(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/ctv/process.php",
        type: "post",
        data: {
            action: "tuchoi",
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
        url: "/ctv/process.php",
        type: "post",
        data: {
            action: "confirm_success",
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
                } else {

                }
            }, 2000);
        }

    });
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
        url: "/ctv/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
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
        url: "/ctv/process.php",
        type: "post",
        data: {
            action: "huy",
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
function format_price(num) {
    var p = num.toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return num + (num != "-" && i && !(i % 3) ? "," : "") + acc;
    }, "");
}
$(document).ready(function() {
    setTimeout(function() {
        $('.loadpage').fadeOut();
        $('.page_body').fadeIn();
    }, 300);
    ///////////////////
    setTimeout(function(){
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "get_total_cart"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.total_ct_shop').html(info.total);
                $('.total_ct_tuan').html(info.total_tuan);
                $('.total_hethang').html(info.total_hethang);
            }

        });
        
    },2000);
    ///////////////////
    $('input[name=cod]').on('keyup',function(){
        total_price=$('.total_price').attr('total_price');
        phi_ship=$('.total_phi').attr('phi');
        chiu_ship=$('select[name=chiu_ship]').val();
        cod=$(this).val();
        cod = cod.replace(/,/g, "");
        if(chiu_ship=='shop'){
            hoahong=cod - total_price - phi_ship;
        }else{
            hoahong=cod - total_price;
        }
        $('.total_hoahong').html(format_price(hoahong)+'đ');
    });
    $('select[name=chiu_ship]').on('change',function(){
        total_price=$('.total_price').attr('total_price');
        phi_ship=$('.total_phi').attr('phi');
        chiu_ship=$('select[name=chiu_ship]').val();
        cod=$('input[name=cod]').val();
        cod = cod.replace(/,/g, "");
        if(chiu_ship=='shop'){
            hoahong=cod - total_price - phi_ship;
        }else{
            hoahong=cod - total_price;
        }
        $('.total_hoahong').html(format_price(hoahong)+'đ');

    });
    ///////////////////
    $('.box_select_product .box_title .fa').on('click',function(){
        $('.box_select_product').hide();
        $('.box_select_product .box_list').html('');
        $('.box_select_product .box_list').attr('page',1);
        $('input[name=key_deal]').val('');
    });
    ///////////////////
    $('.menu_thongbao .title .fa').on('click',function(){
        $('.menu_thongbao').hide();
        create_cookie('close_menu_thongbao', 1, 1, '/');
    });
    $('.box_select_product').on('click','.action button',function(){
        $(this).toggleClass('active');
    });
    $('.box_select_product .box_list').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            tiep=$('.box_select_product .box_list').attr('tiep');
            page=$('.box_select_product .box_list').attr('page');
            loaded=$('.box_select_product .box_list').attr('loaded');
            key = $('input[name=key_deal]').val();
            loai=$('button[name=select_main_product]').attr('loai');
            if(loaded==1 && tiep==1 && page!=1 && key==''){
                $('.box_select_product .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.box_select_product .box_list').attr('loaded',0);
                if(loai=='main_product'){
                    setTimeout(function(){
                        $.ajax({
                            url: "/ctv/process.php",
                            type: "post",
                            data: {
                                action: 'load_product_main',
                                page: page,
                            },
                            success: function(kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list .loading_product').remove();
                                $('.box_select_product .box_list').append(info.list);
                                $('.box_select_product .box_list').attr('page',info.page);
                                $('.box_select_product .box_list').attr('tiep',info.tiep);
                                $('.box_select_product .box_list').attr('loaded',1);
                            }
                        });
                    },1000);
                }else{
                    var sp_id='';
                    $('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
                        sp_id+=$(this).attr('sp')+',';
                    });
                    setTimeout(function(){
                        $.ajax({
                            url: "/ctv/process.php",
                            type: "post",
                            data: {
                                action: 'load_product_sub',
                                list_id:sp_id,
                                page: page,
                            },
                            success: function(kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list .loading_product').remove();
                                $('.box_select_product .box_list').append(info.list);
                                $('.box_select_product .box_list').attr('page',info.page);
                                $('.box_select_product .box_list').attr('tiep',info.tiep);
                                $('.box_select_product .box_list').attr('loaded',1);
                            }
                        });
                    },1000);

                }

            }
            
        }
    })
    $('.select_product').on('click',function(){
        $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_product').show();
        $('.box_select_product .box_bottom button').attr('loai','main_product');
        setTimeout(function(){
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'load_product_main',
                    page: 1,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_product .box_list').html(info.list);
                    $('.box_select_product .box_list').attr('page',info.page);
                    $('.box_select_product .box_list').attr('tiep',info.tiep);
                    $('.box_select_product .box_list').attr('loaded',1);
                }
            });
        },1000);

    });
    $('.select_product_sub').on('click',function(){
        $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_product').show();
        $('.box_select_product .box_bottom button').attr('loai','sub_product');
        var sp_id='';
        $('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
            sp_id+=$(this).attr('sp')+',';
        });
        setTimeout(function(){
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'load_product_sub',
                    list_id:sp_id,
                    page: 1,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_product .box_list').html(info.list);
                    $('.box_select_product .box_list').attr('page',info.page);
                    $('.box_select_product .box_list').attr('tiep',info.tiep);
                    $('.box_select_product .box_list').attr('loaded',1);
                }
            });
        },1000);

    });
    $('.search_deal').on('click',function() {
        key = $('input[name=key_deal]').val();
        loai=$('button[name=select_main_product]').attr('loai');
        var sp_id='';
        $('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
            sp_id+=$(this).attr('sp')+',';
        });
        if (key.length < 1) {
            $('input[name=key_deal]').focus();
        } else {
            $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            if(loai=='main_product'){
                setTimeout(function(){
                    $.ajax({
                        url: "/ctv/process.php",
                        type: "post",
                        data: {
                            action: 'search_product_main',
                            key:key,
                            page: 1,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product .box_list').html(info.list);
                            $('.box_select_product .box_list').attr('page',info.page);
                            $('.box_select_product .box_list').attr('tiep',0);
                            $('.box_select_product .box_list').attr('loaded',1);
                        }
                    });
                },1000);
            }else{
                setTimeout(function(){
                    $.ajax({
                        url: "/ctv/process.php",
                        type: "post",
                        data: {
                            action: 'search_product_sub',
                            key:key,
                            list_id:sp_id,
                            page: 1,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product .box_list').html(info.list);
                            $('.box_select_product .box_list').attr('page',info.page);
                            $('.box_select_product .box_list').attr('tiep',0);
                            $('.box_select_product .box_list').attr('loaded',1);
                        }
                    });
                },1000);
            }

        }
    });
    $('input[name=key_deal]').keypress(function(e) {
        if (e.which == 13) {
            key = $('input[name=key_deal]').val();
            loai=$('button[name=select_main_product]').attr('loai');
            var sp_id='';
            $('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
                sp_id+=$(this).attr('sp')+',';
            });
            if (key.length < 1) {
                $('input[name=key_deal]').focus();
            } else {
                $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                if(loai=='main_product'){
                    setTimeout(function(){
                        $.ajax({
                            url: "/ctv/process.php",
                            type: "post",
                            data: {
                                action: 'search_product_main',
                                key:key,
                                page: 1,
                            },
                            success: function(kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list').html(info.list);
                                $('.box_select_product .box_list').attr('page',info.page);
                                $('.box_select_product .box_list').attr('tiep',0);
                                $('.box_select_product .box_list').attr('loaded',1);
                            }
                        });
                    },1000);
                }else{
                    setTimeout(function(){
                        $.ajax({
                            url: "/ctv/process.php",
                            type: "post",
                            data: {
                                action: 'search_product_sub',
                                key:key,
                                list_id:sp_id,
                                page: 1,
                            },
                            success: function(kq) {
                                var info = JSON.parse(kq);
                                $('.box_select_product .box_list').html(info.list);
                                $('.box_select_product .box_list').attr('page',info.page);
                                $('.box_select_product .box_list').attr('tiep',0);
                                $('.box_select_product .box_list').attr('loaded',1);
                            }
                        });
                    },1000);
                }
            }
        }
    });
    /////////////////////////////
    $('button[name=select_main_product]').on('click',function(){
        loai=$(this).attr('loai');
        if(loai=='main_product'){
            $('.box_select_product .box_list .li_product button.active').each(function(){
                sp_id=$(this).attr('sp');
                if($('#list_product_main .li_product_'+sp_id).length<1){
                    sanpham=$(this).parent().parent().html();
                    sp=sanpham.replace("Chọn", "xóa");
                    $('#list_product_main').append('<div class="li_product li_product_'+sp_id+'" sp="'+sp_id+'">'+sp+'</div>');
                }
            });
        }else if(loai=='sub_product'){
            kieu=$('input[name=loai]:checked').val();
            var sp_id='';
            $('.box_select_product .box_list .li_product button.active').each(function(){
                sp_id+=$(this).attr('sp')+',';
            });
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'show_product_sub',
                    list_id:sp_id,
                    kieu:kieu
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('#list_product_sub').append(info.list);
                }
            });
        }
        $('.box_select_product').hide();
        $('.box_select_product .box_list').html('');
        $('.box_select_product .box_list').attr('page',1);
        $('input[name=key_deal]').val('');
    })
    $('#list_product_main').on('click','.action button',function(){
        $(this).parent().parent().remove();
    });
    $('#list_product_sub').on('click','.action button',function(){
        $(this).parent().parent().remove();
    });
    /////////////////////////////
    $('select[name=apdung]').on('change',function(){
        kieu=$(this).val();
        if(kieu=='all'){
            $('#box_sanpham').hide();
        }else{
            $('#box_sanpham').show();
        }

    });
    /////////////////////////////
    $('button[name=add_flash_sale]').click(function() {
        tieu_de=$('input[name=tieu_de]').val();
        date_start=$('input[name=date_start]').val();
        date_end=$('input[name=date_end]').val();
        var sub_product='';
        var product_length=$('#list_product_sub .li_product').length;
        s=0;
        list='';
        sub_ok=1;
        $('#list_product_sub .li_product').each(function(){
            sub_product+=$(this).attr('sp')+',';
            sp_id=$(this).attr('sp');
            gia=$(this).find('input[name^=gia_deal]').val();
            s++;
            if(s==product_length){
                list+= '"'+sp_id+'":{"gia":"'+gia+'"}';
            }else{
                list+= '"'+sp_id+'":{"gia":"'+gia+'"},';
            }
            if(gia==''){
                sub_ok=0;
            }
        });
        var list_product_sub='{'+list+'}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if(tieu_de==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        }else if(date_start==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(date_end==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(sub_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else if(sub_ok==0){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập giá khuyến mại');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'add_flash_sale',
                    tieu_de:tieu_de,
                    sub_product:sub_product,
                    list_product_sub:list_product_sub,
                    date_start:date_start,
                    date_end:date_end
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
    $('button[name=add_deal]').click(function() {
        tieu_de=$('input[name=tieu_de]').val();
        loai=$('input[name=loai]:checked').val();
        date_start=$('input[name=date_start]').val();
        date_end=$('input[name=date_end]').val();
        var main_product='';
        $('#list_product_main .li_product').each(function(){
            main_product+=$(this).attr('sp')+',';
        });
        var sub_product='';
        var product_length=$('#list_product_sub .li_product').length;
        s=0;
        list='';
        sub_ok=1;
        $('#list_product_sub .li_product').each(function(){
            sub_product+=$(this).attr('sp')+',';
            sp_id=$(this).attr('sp');
            gia=$(this).find('input[name^=gia_deal]').val();
            sale=$(this).find('input[name^=sale_deal]').val();
            s++;
            if(s==product_length){
                list+= '"'+sp_id+'":{"gia":"'+gia+'","sale":"'+sale+'"}';
            }else{
                list+= '"'+sp_id+'":{"gia":"'+gia+'","sale":"'+sale+'"},';
            }
            if(gia=='' && sale==''){
                sub_ok=0;
            }
        });
        var list_product_sub='{'+list+'}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if(tieu_de==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        }else if(date_start==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(date_end==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(main_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm chính');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else if(sub_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm kèm theo');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else if(sub_ok==0){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập giá khuyến mại hoặc % khuyến mại');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'add_deal',
                    loai: loai,
                    tieu_de:tieu_de,
                    main_product:main_product,
                    sub_product:sub_product,
                    list_product_sub:list_product_sub,
                    date_start:date_start,
                    date_end:date_end
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
    $('button[name=edit_deal]').click(function() {
        tieu_de=$('input[name=tieu_de]').val();
        loai=$('input[name=loai]:checked').val();
        date_start=$('input[name=date_start]').val();
        date_end=$('input[name=date_end]').val();
        id=$('input[name=id]').val();
        var main_product='';
        $('#list_product_main .li_product').each(function(){
            main_product+=$(this).attr('sp')+',';
        });
        var sub_product='';
        var product_length=$('#list_product_sub .li_product').length;
        s=0;
        list='';
        sub_ok=1;
        $('#list_product_sub .li_product').each(function(){
            sub_product+=$(this).attr('sp')+',';
            sp_id=$(this).attr('sp');
            gia=$(this).find('input[name^=gia_deal]').val();
            sale=$(this).find('input[name^=sale_deal]').val();
            s++;
            if(s==product_length){
                list+= '"'+sp_id+'":{"gia":"'+gia+'","sale":"'+sale+'"}';
            }else{
                list+= '"'+sp_id+'":{"gia":"'+gia+'","sale":"'+sale+'"},';
            }
            if(gia=='' && sale==''){
                sub_ok=0;
            }
        });
        var list_product_sub='{'+list+'}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if(tieu_de==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        }else if(date_start==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(date_end==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(main_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm chính');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else if(sub_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm kèm theo');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else if(sub_ok==0){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập giá khuyến mại hoặc % khuyến mại');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'edit_deal',
                    loai: loai,
                    tieu_de:tieu_de,
                    main_product:main_product,
                    sub_product:sub_product,
                    list_product_sub:list_product_sub,
                    date_start:date_start,
                    date_end:date_end,
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
    /////////////////////////////
    $('button[name=edit_flash_sale]').click(function() {
        tieu_de=$('input[name=tieu_de]').val();
        date_start=$('input[name=date_start]').val();
        date_end=$('input[name=date_end]').val();
        id=$('input[name=id]').val();
        var sub_product='';
        var product_length=$('#list_product_sub .li_product').length;
        s=0;
        list='';
        sub_ok=1;
        $('#list_product_sub .li_product').each(function(){
            sub_product+=$(this).attr('sp')+',';
            sp_id=$(this).attr('sp');
            gia=$(this).find('input[name^=gia_deal]').val();
            s++;
            if(s==product_length){
                list+= '"'+sp_id+'":{"gia":"'+gia+'"}';
            }else{
                list+= '"'+sp_id+'":{"gia":"'+gia+'"},';
            }
            if(gia==''){
                sub_ok=0;
            }
        });
        var list_product_sub='{'+list+'}';
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if(tieu_de==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên chương trình');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
            $('input[name=tieu_de]').focus();

        }else if(date_start==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(date_end==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thời gian kết thúc');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        }else if(sub_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else if(sub_ok==0){
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập giá khuyến mại');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'edit_flash_sale',
                    tieu_de:tieu_de,
                    sub_product:sub_product,
                    list_product_sub:list_product_sub,
                    date_start:date_start,
                    date_end:date_end,
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
    if ($('.list_baiviet tr').length < 2) {
        $('.load_sanpham button').hide();
    }
    $('body').on('click', '#main_category .li_input input', function() {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: '/ctv/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_category',
                    cat_id: id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {

                        if ($('#sub_category .li_input').length > 0) {
                            $('#sub_category').append('<hr class="hr_' + id + '">' + info.list);
                        } else {
                            $('#sub_category').append(info.list);
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
    $('body').on('click', '#sub_category .li_input input', function() {
        if ($(this).is(":checked")) {
            id = $(this).val();
            main = $(this).attr('main_id');
            $.ajax({
                url: '/ctv/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_sub_category',
                    cat_id: id,
                    main: main
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($('#sub_sub_category .li_input').length > 0) {
                            $('#sub_sub_category').append('<hr class="hr_' + id + ' hr_main_' + main + '">' + info.list);
                        } else {
                            $('#sub_sub_category').append(info.list);
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
    $('.quickview-close').on('click', function() {
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    //////////////////////////
    $('.btn-continue').on('click', function() {
        $('.load_overlay').hide();
        $('.modal').hide();
    });
    $('.box_check_domain .tab').on('click', function() {
        $('.box_check_domain .tab').removeClass('active');
        $(this).addClass('active');
        id = $(this).attr('id');
        $('.box_check_domain .content_tab').removeClass('active');
        $('.box_check_domain #content_' + id).addClass('active');

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
    $('#box_pop_confirm_action .button_cancel').on('click', function() {
        $('#box_pop_confirm_action .title_confirm').html('');
        $('#button_thuchien_action').attr('action', '');
        $('#button_thuchien_action').attr('post_id', '');
        $('#button_thuchien_action').attr('loai', '');
        $('#box_pop_confirm_action').hide();
    });
    /////////////////////////////
    $('#box_pop_confirm_action_domain .button_cancel').on('click', function() {
        $('#box_pop_confirm_action_domain .title_confirm').html('');
        $('#button_thuchien_action_domain').attr('action', '');
        $('#button_thuchien_action_domain').attr('post_id', '');
        $('#button_thuchien_action_domain').attr('loai', '');
        $('#box_pop_confirm_action_domain').hide();
    });
    /////////////////////////////
    $('#button_thuchien').click(function() {
        id = $('#button_thuchien').attr('post_id');
        loai = $('#button_thuchien').attr('loai');
        action = $('#button_thuchien').attr('action');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: action,
                loai: loai,
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
    $('#button_thuchien_action').click(function() {
        $('#button_ok').click();
    });
    /////////////////////////////
    $('#button_thuchien_action_domain').click(function() {
        $('#button_ok_domain').click();
    });
    /////////////////////////////
    $('body').on('click', '.huy_donhang_ctv', function() {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: 'huy_donhang_ctv',
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
    $('.check_domain input[name=loai]').on('click', function() {
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
    $('body').on('click', '.apply_subdomain', function() {
        domain = $('input[name=subdomain]').val();
        $('.text_check_subdomain').html('<i class="fa fa-spinner fa-pulse"></i><span> Đang xử lý...</span>');
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: 'apply_subdomain',
                domain: domain
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.text_check_subdomain').html(info.thongbao);
                if (info.ok == 1) {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
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
    $('body').on('click', '.button_check_subdomain', function() {
        domain = $('input[name=subdomain]').val();
        if (domain.length < 2) {
            $('.text_check_subdomain').html('<i class="fa fa-warning"></i><span> Vui lòng nhập tên miền..</span>');
            $('input[name=subdomain]').focus();
        } else {
            $('.text_check_subdomain').html('<i class="fa fa-spinner fa-pulse"></i><span> Đang kiểm tra...</span>');
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'check_subdomain',
                    domain: domain
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.text_check_subdomain').html(info.thongbao);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.set_skin', function() {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: 'set_skin',
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
                        window.location.href = '/ctv/list-giaodien?step=2';
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.hotro_domain', function() {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: 'hotro_domain',
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
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.mua_domain', function() {
        domain = $('#button_thuchien_action_domain').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: 'mua_domain',
                domain: domain
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
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.mua_seeding', function() {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: 'mua_seeding',
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
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=add_naptien]').on('click', function() {
        sotien = $('input[name=sotien]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
            type: 'post',
            data: {
                action: 'add_naptien',
                sotien: sotien
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
                        window.location.href = '/ctv/add-naptien?step=2';
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=button_hoanthanh]').on('click', function() {
        ho_ten = $('input[name=ho_ten]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        dia_chi = $('input[name=dia_chi]').val();
        ghi_chu = $('textarea[name=ghi_chu]').val();
        tinh = $('select[name=tinh]').val();
        huyen = $('select[name=huyen]').val();
        chiu_ship = $('select[name=chiu_ship]').val();
        cod = $('input[name=cod]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        if (ho_ten == '') {
            $('input[name=ho_ten]').focus();
            $('.load_note').html('Vui lòng nhập họ và tên');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (dien_thoai == '') {
            $('input[name=dien_thoai]').focus();
            $('.load_note').html('Vui lòng nhập số điện thoại');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (dia_chi == '') {
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

        } else if (cod == '') {
            $('input[name=cod]').focus();
            $('.load_note').html('Vui lòng nhập số điện thoại');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        }else {
            var form_data = new FormData();
            form_data.append('action', 'hoanthanh_donhang');
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('dia_chi', dia_chi);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('chiu_ship', chiu_ship);
            form_data.append('cod', cod);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/ctv/process.php',
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
                            window.location.href = '/ctv/list-donhang-ctv';
                        } else {

                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.buy_now', function() {
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
                url: '/ctv/process.php',
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
                    if (info.ok == 1) {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            window.location.href = '/ctv/add-donhang-ctv?step=2';
                        }, 3000);
                    } else {
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
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
    $('body').on('click', '.add_to_cart', function() {
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
                url: '/ctv/process.php',
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
                    if (info.ok == 1) {
                        setTimeout(function() {
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
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
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
    $('.tbody-popup').on('click', '.remove-item-cart', function() {
        id = $(this).data('id');
        $.ajax({
            url: '/ctv/process.php',
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
    $('.tbody-popup').on('click', '.btn-plus', function() {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).parent().find('input[name=quantity]').val();
        quantity++;
        $.ajax({
            url: '/ctv/process.php',
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
    $('.tbody-popup').on('click', '.btn-minus', function() {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).parent().find('input[name=quantity]').val();
        if (quantity > 1) {
            quantity--;
        } else {
            quantity = 1;
        }
        $.ajax({
            url: '/ctv/process.php',
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
    $('.tbody-popup').on('keyup', 'input[name=quantity]', function() {
        id = $(this).parent().parent().find('.remove-item-cart').data('id');
        quantity = $(this).val();
        $.ajax({
            url: '/ctv/process.php',
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
    $('.box_right_content').on('click', '.del_server', function() {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.box_right_content').on('click', '.add_server', function() {
        $('.block_bottom').before('<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link nguồn</label><input type="text" class="form_control" name="nguon" value="" placeholder="Nhập nguồn dữ liệu..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="button_select_photo">Chọn ảnh</button><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>');
    });
    $('.button_add_info').on('click', function() {
        $('.list_info').append('<div class="li_info"><div class="info_name"><input type="text" name="info_name[]" placeholder="Nhập tên thông tin"></div><div class="info_value"><input type="text" name="info_value[]" placeholder="Nhập giá trị thông tin"></div></div>');
    });
    /////////////////////////////
    $('.mh').click(function() {
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function() {
        readURL(this, 'preview-minhhoa');
    });
    /////////////////////////////
    $('.mh_popup').click(function() {
        $('#popup').click();
    });
    $("#popup").change(function() {
        readURL(this, 'preview-popup');
    });
    /////////////////////////////
    $('.box_profile').on('click', '.button_select_photo', function() {
        $('#photo-add').click();
    });
    $('#photo-add').on('change', function() {
        var form_data = new FormData();
        form_data.append('action', 'upload_photo');
        $.each($("input[name=file]")[0].files, function(i, file) {
            form_data.append('file[]', file);
        });
        //form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
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
                        $('.list_photo').append(info.list);
                    }
                }, 3000);
            }

        });
    });
    $('.tieude_seo').on('paste', function(event) {
        if ($(this).hasClass('uncheck_blank')) {} else {
            setTimeout(function() {
                check_blank();
            }, 1000);
        }
    });
    $('input[name=slug]').on('keyup', function() {
        slug = $(this).val();
        id = $('input[name=id]').val();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "check_slug",
                slug: slug,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.check_slug').html(info.thongbao);
            }

        });
    });
    /////////////////////////////
    $('.drop_down').on('click', function() {
        $('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).find('.drop_menu').is(':visible')) {
            $(this).find('.drop_menu').slideUp('300');
        } else {
            $(this).find('.drop_menu').slideDown('300');
        }
    });
    /////////////////////////////
    $(document).mouseup(function(e) {
        var dr = $(".drop_menu");
        if (!dr.is(e.target) && dr.has(e.target).length === 0) {
            $('.drop_menu').slideUp('300');
        }
    });
    $('input[name=key]').keypress(function(e) {
        if (e.which == 13) {
            key = $('input[name=key]').val();
            if ($('button[name=timkiem_sanpham]').length > 0) {
                action = 'timkiem_sanpham';
            } else if ($('button[name=timkiem_sanpham_ctv]').length > 0) {
                action = 'timkiem_sanpham_ctv';
            } else if ($('button[name=timkiem_sanpham_shop]').length > 0) {
                action = 'timkiem_sanpham_shop';
            } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
                action = 'timkiem_sanpham_trend';
            } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
                action = 'timkiem_sanpham_tuan';
            } else if ($('button[name=timkiem_bom]').length > 0) {
                action = 'timkiem_bom';
            } else if ($('button[name=timkiem_thanhvien]').length > 0) {
                action = 'timkiem_thanhvien';
            } else if ($('button[name=timkiem_donhang]').length > 0) {
                action = 'timkiem_donhang';
            }
            if (key.length < 1) {
                $('input[name=key]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/ctv/process.php',
                    type: 'post',
                    data: {
                        action: action,
                        key: key
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
                                $('.list_baiviet').html(info.list);
                                $('.load_sanpham').hide();
                                if(action=='timkiem_sanpham_tuan'){
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
                                        status=$this.attr('status');
                                        if(status==0){
                                          $this.find('.text_time').html('Kết thúc sau:');
                                          con=$this.attr('thoigian')*1000;
                                          $this.countdown(con + currentDate.valueOf(), call_flash);
                                          $this.attr('status',1);
                                        }else{
                                          $this.fadeTo('slow', .5);
                                          $this.html('Đã kết thúc');
                                          finished = true;              
                                        }
                                        break;
                                        }
                                    }
                                    $('.count_down').each(function(){
                                        con=$(this).attr('time')*1000;
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
    $('#timkiem_thuonghieu').on('change', function() {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu',
                thuong_hieu: thuong_hieu
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
                        $('.list_baiviet').html(info.list);
                        $('.load_sanpham').hide();
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('#timkiem_thuonghieu_add').on('change', function() {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu_add',
                thuong_hieu: thuong_hieu
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
                        $('.list_baiviet').html(info.list);
                        $('.load_sanpham').hide();
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('#timkiem_thuonghieu_trend').on('change', function() {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu_trend',
                thuong_hieu: thuong_hieu
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
                        $('.list_baiviet').html(info.list);
                        $('.load_sanpham').hide();
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('#timkiem_thuonghieu_tuan').on('change', function() {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu_tuan',
                thuong_hieu: thuong_hieu
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
                        $('.list_baiviet').html(info.list);
                        $('.load_sanpham').hide();
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
                            status=$this.attr('status');
                            if(status==0){
                              $this.find('.text_time').html('Kết thúc sau:');
                              con=$this.attr('thoigian')*1000;
                              $this.countdown(con + currentDate.valueOf(), call_flash);
                              $this.attr('status',1);
                            }else{
                              $this.fadeTo('slow', .5);
                              $this.html('Đã kết thúc');
                              finished = true;              
                            }
                            break;
                            }
                        }
                        $('.count_down').each(function(){
                            con=$(this).attr('time')*1000;
                            $(this).countdown(con + currentDate.valueOf(), call_flash);
                        });
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('.button_timkiem').on('click', function() {
        key = $('input[name=key]').val();
        if ($('button[name=timkiem_sanpham]').length > 0) {
            action = 'timkiem_sanpham';
        } else if ($('button[name=timkiem_sanpham_ctv]').length > 0) {
            action = 'timkiem_sanpham_ctv';
        } else if ($('button[name=timkiem_sanpham_shop]').length > 0) {
            action = 'timkiem_sanpham_shop';
        } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
            action = 'timkiem_sanpham_trend';
        } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
            action = 'timkiem_sanpham_tuan';
        } else if ($('button[name=timkiem_bom]').length > 0) {
            action = 'timkiem_bom';
        } else if ($('button[name=timkiem_thanhvien]').length > 0) {
            action = 'timkiem_thanhvien';
        } else if ($('button[name=timkiem_donhang]').length > 0) {
            action = 'timkiem_donhang';
        }
        if (key.length < 1) {
            $('input[name=key]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/ctv/process.php',
                type: 'post',
                data: {
                    action: action,
                    key: key
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
                            $('.list_baiviet').html(info.list);
                            $('.load_sanpham').hide();
                            if(action=='timkiem_sanpham_tuan'){
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
                                    status=$this.attr('status');
                                    if(status==0){
                                      $this.find('.text_time').html('Kết thúc sau:');
                                      con=$this.attr('thoigian')*1000;
                                      $this.countdown(con + currentDate.valueOf(), call_flash);
                                      $this.attr('status',1);
                                    }else{
                                      $this.fadeTo('slow', .5);
                                      $this.html('Đã kết thúc');
                                      finished = true;              
                                    }
                                    break;
                                    }
                                }
                                $('.count_down').each(function(){
                                    con=$(this).attr('time')*1000;
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
    /////////////////////////////
    $('#ckOk').on('click', function() {
        if ($('#ckOk').is(":checked")) {
            $('#lbtSubmit').attr("disabled", false);
        } else {
            $('#lbtSubmit').attr("disabled", true);
        }
    });
    /////////////////////////////
    $('#txbQuery').keypress(function(e) {
        if (e.which == 13) {
            key = $('#txbQuery').val();
            type = $('input[name=search_type]:checked').val();
            link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////////////
    $('.show_add_marketing').on('click',function(){
        window.location.href='/ctv/add-remarketing';
    });
    //////////////////
    $('#btnSearch').on('click', function() {
        key = $('#txbQuery').val();
        type = $('input[name=search_type]:checked').val();
        link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $('.panel-lyrics .panel-heading').on('click', function() {
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
    $('.item-cat a').on('click', function() {
        $(this).parent().find('div').click();

    });
    /////////////////////////////
    $('.remember').on('click', function() {
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
    $('.li_photo i').on('click', function() {
        var item = $(this);
        anh = item.parent().find('img').attr('src');
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "del_photo",
                anh: anh
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                item.parent().parent().remove();
            }

        });
    });
    /////////////////////////////
    $('.drop_status input[type=radio]').on('click', function() {
        status = $(this).val();
        user_id = $(this).attr('name');
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "update_ctv",
                user_id: user_id,
                status: status
            },
            success: function(kq) {
                var info = JSON.parse(kq);
            }

        });
    });
    /////////////////////////////
    $('.load_sanpham button').on('click', function() {
        page = $(this).attr('page');
        $(this).html('Đang tải...');
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "load_sanpham",
                page: page
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.load_sanpham button').html('Tải thêm');
                $('.load_sanpham button').attr('page', info.page);
                $('.list_baiviet tr:last').after(info.list);
                if (info.list == null) {
                    $('.load_sanpham button').hide();
                }
            }

        });
    });
    /////////////////////////////
    $('.load_sanpham_trend button').on('click', function() {
        page = $(this).attr('page');
        $(this).html('Đang tải...');
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "load_sanpham_trend",
                page: page
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.load_sanpham_trend button').html('Tải thêm');
                $('.load_sanpham_trend button').attr('page', info.page);
                $('.list_baiviet tr:last').after(info.list);
                if (info.list == null) {
                    $('.load_sanpham_trend button').hide();
                }
            }

        });
    });
    /////////////////////////////
    $('.load_sanpham_tuan button').on('click', function() {
        page = $(this).attr('page');
        $(this).html('Đang tải...');
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "load_sanpham_tuan",
                page: page
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.load_sanpham_tuan button').html('Tải thêm');
                $('.load_sanpham_tuan button').attr('page', info.page);
                $('.list_baiviet tr:last').after(info.list);
                if (info.list == null) {
                    $('.load_sanpham_tuan button').hide();
                }else{
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
                        status=$this.attr('status');
                        if(status==0){
                          $this.find('.text_time').html('Kết thúc sau:');
                          con=$this.attr('thoigian')*1000;
                          $this.countdown(con + currentDate.valueOf(), call_flash);
                          $this.attr('status',1);
                        }else{
                          $this.fadeTo('slow', .5);
                          $this.html('Đã kết thúc');
                          finished = true;              
                        }
                        break;
                        }
                    }
                    $('.count_down').each(function(){
                        con=$(this).attr('time')*1000;
                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                    });
                }
            }

        });
    });
    /////////////////////////////
    $('button[name=add_bom]').on('click', function() {
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
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "add_bom",
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh_trang: tinh_trang
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
    $('button[name=edit_bom]').on('click', function() {
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
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "edit_bom",
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh_trang: tinh_trang,
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
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });

    $('.select_nguoinhan').on('click',function(){
        $('.box_select_nguoinhan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_nguoinhan').show();
        $('.box_select_nguoinhan .box_bottom button').attr('loai','sub_product');
        var member_id='';
        $('.list_nguoinhan .li_member').each(function(){
            member_id+=$(this).attr('user')+',';
        });
        setTimeout(function(){
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: 'load_nguoinhan',
                    list_id:member_id,
                    page: 1,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_nguoinhan .box_list').html(info.list);
                    $('.box_select_nguoinhan .box_list').attr('page',info.page);
                    $('.box_select_nguoinhan .box_list').attr('tiep',info.tiep);
                    $('.box_select_nguoinhan .box_list').attr('loaded',1);
                }
            });
        },1000);

    });
    ////////////////////////
    $('.box_select_nguoinhan .box_list').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            tiep=$('.box_select_nguoinhan .box_list').attr('tiep');
            page=$('.box_select_nguoinhan .box_list').attr('page');
            loaded=$('.box_select_nguoinhan .box_list').attr('loaded');
            key = $('.box_select_nguoinhan input[name=key_member]').val();
            var member_id='';
            $('.list_nguoinhan .li_member').each(function(){
                member_id+=$(this).attr('user')+',';
            });
            if(loaded==1 && tiep==1 && page!=1 && key==''){
                $('.box_select_nguoinhan .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.box_select_nguoinhan .box_list').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/ctv/process.php",
                        type: "post",
                        data: {
                            action: 'load_nguoinhan',
                            list_id:member_id,
                            key:key,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_nguoinhan .box_list .loading_product').remove();
                            $('.box_select_nguoinhan .box_list').append(info.list);
                            $('.box_select_nguoinhan .box_list').attr('page',info.page);
                            $('.box_select_nguoinhan .box_list').attr('tiep',info.tiep);
                            $('.box_select_nguoinhan .box_list').attr('loaded',1);
                        }
                    });
                },1000);
            }
            
        }
    })
    ///////////////////
    $('.box_select_nguoinhan .box_title .fa').on('click',function(){
        $('.box_select_nguoinhan').hide();
        $('.box_select_nguoinhan .box_list').html('');
        $('.box_select_nguoinhan .box_list').attr('page',1);
        $('.box_select_nguoinhan input[name=key_member]').val('');
    });
    $('.box_select_nguoinhan').on('click','.action button',function(){
        var button=$(this);
        user_id=$(this).attr('user');
        username=$(this).attr('username');
        $('.list_nguoinhan').append('<div class="li_member '+username+'" user="'+user_id+'">'+username+' <i class="fa fa-close"></i>');
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('.list_nguoinhan .'+username).remove();
        }else{
            $(this).addClass('active');
        }
    });
    $('.list_nguoinhan').on('click','.li_member i',function(){
        $(this).parent().remove();
    });
    $('.box_select_nguoinhan .search_member').on('click',function() {
        key = $('.box_select_nguoinhan input[name=key_member]').val();
        var member_id='';
        $('.list_nguoinhan .li_member').each(function(){
            member_id+=$(this).attr('user')+',';
        });
        if (key.length < 1) {
            $('.box_select_nguoinhan input[name=key_member]').focus();
        } else {
            $('.box_select_nguoinhan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            setTimeout(function(){
                $.ajax({
                    url: "/ctv/process.php",
                    type: "post",
                    data: {
                        action: 'load_nguoinhan',
                        list_id:member_id,
                        key:key,
                        page: 1,
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('.box_select_nguoinhan .box_list .loading_product').remove();
                        $('.box_select_nguoinhan .box_list').append(info.list);
                        $('.box_select_nguoinhan .box_list').attr('page',info.page);
                        $('.box_select_nguoinhan .box_list').attr('tiep',info.tiep);
                        $('.box_select_nguoinhan .box_list').attr('loaded',1);
                    }
                });
            },1000);
        }
    });
    $('.box_select_nguoinhan input[name=key_member]').keypress(function(e) {
        if (e.which == 13) {
            key = $('.box_select_nguoinhan input[name=key_member]').val();
            var member_id='';
            $('.list_nguoinhan .li_member').each(function(){
                member_id+=$(this).attr('user')+',';
            });
            if (key.length < 1) {
                $('.box_select_nguoinhan input[name=key_member]').focus();
            } else {
                $('.box_select_nguoinhan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                setTimeout(function(){
                    $.ajax({
                        url: "/ctv/process.php",
                        type: "post",
                        data: {
                            action: 'load_nguoinhan',
                            key:key,
                            page: 1,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_nguoinhan .box_list .loading_product').remove();
                            $('.box_select_nguoinhan .box_list').append(info.list);
                            $('.box_select_nguoinhan .box_list').attr('page',info.page);
                            $('.box_select_nguoinhan .box_list').attr('tiep',info.tiep);
                            $('.box_select_nguoinhan .box_list').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
    });

    /////////////////////////////
    $('button[name=add_remarketing]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var member_id='';
        $('.list_nguoinhan .li_member').each(function(){
            member_id+=$(this).attr('user')+',';
        });
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_minhhoa = $('#preview-minhhoa').offset().top;
                $('html,body').stop().animate({ scrollTop: top_minhhoa - 150 }, 500, 'swing', function() {});
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_remarketing]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var member_id='';
        $('.list_nguoinhan .li_member').each(function(){
            member_id+=$(this).attr('user')+',';
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_coupon]').on('click', function() {
        ma = $('input[name=ma]').val();
        loai = $('select[name=loai]').val();
        kieu = $('select[name=apdung]').val();
        giam = $('input[name=giam]').val();
        time_start = $('input[name=time_start]').val();
        time_expired = $('input[name=time_expired]').val();
        date_start = $('input[name=date_start]').val();
        date_expired = $('input[name=date_expired]').val();
        var main_product='';
        $('#list_product_main .li_product').each(function(){
            main_product+=$(this).attr('sp')+',';
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_coupon]').on('click', function() {
        ma = $('input[name=ma]').val();
        loai = $('select[name=loai]').val();
        giam = $('input[name=giam]').val();
        kieu = $('select[name=apdung]').val();
        time_start = $('input[name=time_start]').val();
        time_expired = $('input[name=time_expired]').val();
        date_start = $('input[name=date_start]').val();
        date_expired = $('input[name=date_expired]').val();
        var main_product='';
        $('#list_product_main .li_product').each(function(){
            main_product+=$(this).attr('sp')+',';
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    ///////////////////////////////
    $('button[name=edit_setting_img]').on('click', function() {
        name = $('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_setting_img');
        form_data.append('file', file_data);
        form_data.append('name', name);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
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
                        window.location.href = '/ctv/list-setting';
                    } else {

                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////////
    $('button[name=edit_setting_css]').on('click', function() {
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
            url: "/ctv/process.php",
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
                top_footer:top_footer,
                bottom_footer:bottom_footer,
                text_top_footer:text_top_footer,
                text_bottom_footer:text_bottom_footer,
                timkiem:timkiem,
                nhantin:nhantin,
                text_title_top_footer:text_title_top_footer
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
    ///////////////////////////////
    $('button[name=edit_setting_html]').on('click', function() {
        name = $('input[name=id]').val();
        noidung = tinyMCE.activeEditor.getContent();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung
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
                        window.location.href = '/ctv/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    ///////////////////////////////
    $('button[name=edit_setting_text]').on('click', function() {
        name = $('input[name=id]').val();
        noidung = $('textarea[name=content]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung
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
                        window.location.href = '/ctv/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('input[name=loai]').click(function() {
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
    $('#select_category select').on('change', function() {
        text = $('#select_category select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('#select_theloai select').on('change', function() {
        text = $('#select_theloai select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('#select_page select').on('change', function() {
        text = $('#select_page select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('button[name=add_ruttien]').click(function() {
        so_tien = $('input[name=so_tien]').val();
        chu_khoan = $('input[name=chu_khoan]').val();
        so_taikhoan = $('input[name=so_taikhoan]').val();
        ngan_hang = $('input[name=ngan_hang]').val();
        if (so_tien < 1000) {
            $('input[name=so_tien]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập số tiền lớn hơn 1000 đ');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (chu_khoan.length < 4) {
            $('input[name=chu_khoan]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên chủ tài khoản');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (so_taikhoan.length < 4) {
            $('input[name=so_taikhoan]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập số tài khoản');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (ngan_hang.length < 4) {
            $('input[name=ngan_hang]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên ngân hàng');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "add_ruttien",
                    so_tien: so_tien,
                    chu_khoan: chu_khoan,
                    so_taikhoan: so_taikhoan,
                    ngan_hang: ngan_hang
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
    $('button[name=add_menu]').click(function() {
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
                url: "/ctv/process.php",
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
    $('button[name=edit_menu]').click(function() {
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
                url: "/ctv/process.php",
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
                            window.location.href = '/ctv/list-menu';
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=add_slide]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_slide]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function() {
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
                url: '/ctv/process.php',
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
                            window.location.href = '/ctv/list-slide';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_category]').on('click', function() {
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
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function() {
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
                url: '/ctv/process.php',
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
                            window.location.href = '/ctv/list-category';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_category]').on('click', function() {
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
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tiêu đề');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_donhang]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "edit_donhang",
                status: status,
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
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_livestream]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "edit_livestream",
                status: status,
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
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_tichdiem]').on('click', function() {
        diem = $('input[name=diem]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "edit_tichdiem",
                diem: diem
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
    /////////////////////////////
    $('button[name=add_livestream]').on('click', function() {
        time_start = $('input[name=time_start]').val();
        time_end = $('input[name=time_end]').val();
        ngay= $('input[name=ngay]').val();
        san_pham = $('textarea[name=san_pham]').val();
        ghi_chu = $('textarea[name=ghi_chu]').val();
        id = $('input[name=id]').val();
        if(san_pham==''){
            $('textarea[name=san_pham]').focus();
        }else if(time_start==''){
            $('input[name=time_start]').focus();
        }else if(ngay==''){
            $('input[name=ngay]').focus();
        }else if(time_end==''){
            $('input[name=time_end]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "dat_livestream",
                    ngay:ngay,
                    time_start:time_start,
                    time_end:time_end,
                    san_pham:san_pham,
                    ghi_chu:ghi_chu,
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
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_theloai]').on('click', function() {
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
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập thứ tự');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/ctv/process.php",
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
                            window.location.href = '/ctv/list-theloai';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_theloai]').on('click', function() {
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
                url: "/ctv/process.php",
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
    $('button[name=edit_thanhvien]').on('click', function() {
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
            url: '/ctv/process.php',
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
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_doanhthu]').on('click', function() {
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
                url: '/ctv/process.php',
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
                            $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
                            $('#doanhthu_giao').html(info.doanhthu_giao);
                            $('#doanhthu_huy').html(info.doanhthu_huy);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
                            $('#donhang_giao').html(info.donhang_giao);
                            $('#donhang_huy').html(info.donhang_huy);
                            $('#donhang_cho').html(info.donhang_cho);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_hoahong]').on('click', function() {
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
            form_data.append('action', 'load_hoahong');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/ctv/process.php',
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
                            $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
                            $('#doanhthu_giao').html(info.doanhthu_giao);
                            $('#doanhthu_huy').html(info.doanhthu_huy);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
                            $('#donhang_giao').html(info.donhang_giao);
                            $('#donhang_huy').html(info.donhang_huy);
                            $('#donhang_cho').html(info.donhang_cho);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=login]').on('click', function() {
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
                url: "/ctv/process_login.php",
                type: "post",
                data: {
                    username: username,
                    password: password,
                    remember: remember
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
                            window.location.href = '/ctv/dashboard';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=forgot_password]').on('click', function() {
        email = $('input[name=email]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/ctv/process.php",
            type: "post",
            data: {
                action: "forgot_password",
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
                }, 3000);
                setTimeout(function() {
                    if (info.ok == 1) {
                        window.location.href = '/forgot-password?step=2';
                    } else {

                    }
                }, 3500);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_domain]').on('click', function() {
        domain = $('input[name=domain]').val();
        if (domain.length < 5) {
            $('input[name=domain]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "edit_domain",
                    domain: domain
                },
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
        }

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
            url: '/ctv/process.php',
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
            url: '/ctv/process.php',
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
            url: '/ctv/process.php',
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
            url: '/ctv/process.php',
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
    $('#customer_shipping_province').on('change', function() {
        tinh = $(this).val();
        if (tinh != '') {
            $.ajax({
                url: '/ctv/process.php',
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
    $('.button_dathang').on('click', function() {
        var list_mau = '';
        $('.li_shopcart').each(function() {
            if ($(this).find('input').length > 0) {
                mau = $(this).find('input:checked').val();
                sp_id = $(this).find('input:checked').attr('sp_id');
                list_mau += sp_id + '&&' + mau + '|';
            }
        });
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/ctv/process.php',
            type: 'post',
            data: {
                action: 'update_mau',
                list_mau: list_mau
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
                        window.location.href = '/ctv/add-donhang-ctv?step=3';
                    }
                }, 3000);

            }
        });
    });
    /////////////////////////////
    $('button[name=button_profile]').on('click', function() {
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        if (name.length < 2) {
            $('input[name=name]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "edit_profile",
                    name: name,
                    mobile: mobile
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            //window.location.reload();
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
        }

    });
    /////////////////////////////
    $('.button_change_avatar').click(function() {
        $('#file').click();
    });
    /////////////////////////////
    $('.cover_now .button_change').click(function() {
        $('#file_cover').click();
    });
    /////////////////////////////
    $('.button_check_domain').on('click', function() {
        key_domain = $('textarea[name=key_domain]').val();
        var list_loai = [];
        $('input[name^=loai_domain]:checked').each(function() {
            list_loai.push($(this).val());
        });
        list_loai = list_loai.toString();
        if (key_domain.length < 2) {
            $('textarea[name=key_domain]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập tên miền cần kiểm tra');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 2000);
        } else if (list_loai.length < 2) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn loại tên miền');
            }, 500);
            setTimeout(function() {
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
                url: '/ctv/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('.list_result').html(info.list);
                        check_domain();
                    } else {
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
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
    $('button[name=add_sanpham_ngoai]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        can_nang = $('input[name=can_nang]').val();
        kho = $('input[name=kho]').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function() {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
/*        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function() {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2=$('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2=$('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=add_sanpham_aff]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        link_aff = $('input[name=link_aff]').val();
        kho = $('input[name=kho]').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function() {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
/*        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function() {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2=$('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2=$('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function() {
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
            form_data.append('action', 'add_sanpham_aff');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('kho', kho);
            form_data.append('anh', anh);
            form_data.append('minh_hoa', minh_hoa);
            form_data.append('file', file_data);
            form_data.append('link', link);
            form_data.append('link_aff', link_aff);
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=edit_sanpham_ngoai]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        kho = $('input[name=kho]').val();
        can_nang = $('input[name=can_nang]').val();
        id = $('input[name=id]').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function() {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
/*        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function() {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2=$('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2=$('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=edit_sanpham_affiliate]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        link_aff = $('input[name=link_aff]').val();
        id = $('input[name=id]').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function() {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
/*        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function() {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();*/
        size = $('select[name=size]').val();
        size_2=$('input[name=size_2]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        thuong_hieu_2=$('input[name=thuong_hieu_2]').val();
        var list_info = '';
        $('.li_info').each(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=add_sanpham]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        sp_id = $('input[name=sp_id]').val();
        gia_moi = $('input[name=gia_moi]').val();
        can_nang = $('input[name=can_nang]').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        minh_hoa = $('#preview-minhhoa').attr('src');
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function() {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function() {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        var list_info = '';
        $('.li_info').each(function() {
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
                url: '/ctv/process.php',
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
                            window.location.href = '/ctv/list-sanpham';
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=edit_sanpham]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia_moi = $('input[name=gia_moi]').val();
        can_nang = $('input[name=can_nang]').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $('.li_input input[name^=color]:checked').each(function() {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        var list_size = [];
        $('.li_input input[name^=size]:checked').each(function() {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        var list_info = '';
        $('.li_info').each(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });

        }
    });
    /////////////////////////////
    $('button[name=add_post]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
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
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_minhhoa = $('#preview-minhhoa').offset().top;
                $('html,body').stop().animate({ scrollTop: top_minhhoa - 150 }, 500, 'swing', function() {});
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_post]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        title = $('input[name=title]').val();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        description = $('textarea[name=description]').val();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
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
                url: '/ctv/process.php',
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
                            window.location.reload();
                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=button_password]').on('click', function() {
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
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm
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
    $('input[name=goi_y]').on('keyup', function() {
        tieu_de = $(this).val();
        cat = $('select[name=category]').val();
        if (tieu_de.length < 2) {} else {
            $.ajax({
                url: "/ctv/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat: cat,
                    tieu_de: tieu_de
                },
                success: function(kq) {
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
    setTimeout(function(){
        $.ajax({
            url: "/ctv/process.php",
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
                $('.total_thongbao').html(info.total);
            }

        });
        
    },3000);
    $('.box_popup .box_title i').click(function(){
        $('.box_popup').fadeOut();
    });
    /////////////////////////////
    $('.khung_sanpham').on('click', 'ul li i', function() {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.khung_goi_y').on('click', 'ul li', function(e) {
        text = $(this).find('span').text();
        id = $(this).attr('value');
        $('.khung_sanpham ul').prepend('<li value="' + id + '"><i class="icon icofont-close-circled"></i><span>' + text + '</span></li>');
        e.stopPropagation();
    });
    $('.box_video .close').on('click',function(){
        $('.box_video').hide();
    });
    $('.pop_video').on('click',function(){
        video=$(this).attr('video');
        if(video==''){
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $('.load_note').html('Chưa có video giới thiệu');
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 3000);
        }else{
            $('.box_video iframe').attr('src','https://www.youtube.com/embed/'+video);
            $('.box_video').show();
        }
    });
    /////////////////////////////
    $(document).click(function() {
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
});