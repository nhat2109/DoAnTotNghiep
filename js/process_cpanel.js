//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function scrollSmoothToBottom (id) {
   var div = document.getElementById(id);
   $('#' + id).animate({
      scrollTop: div.scrollHeight - div.clientHeight
   }, 200);
}
//var socket =io("http://localhost:3000");
var socket =io("https://chat.socdo.vn");
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
function check_link(loai) {
    link = $('.link_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/admincp/process.php",
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
            url: "/admincp/process.php",
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
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function tuchoi(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
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

function confirm_success(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
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

function del(loai, id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
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
        url: "/admincp/process.php",
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
    if($('#chon_kho').length>0){
        if(get_cookie('admin_kho')){
            $('#chon_kho').val(get_cookie('admin_kho'));
        }else{

        }
    }
    $('#chon_kho').on('change',function(){
        kho=$(this).val();
        create_cookie('admin_kho', kho, 365, '/');
        window.location.reload();
    });
    if($('#list_chat').length>0){
        setTimeout(function(){
            scrollSmoothToBottom('list_chat');
        },500);
    }
    /////////////////////////////
    $('body').on('click','.box_sticker .li_tab',function(){
        tab=$(this).attr('id');
        $('.list_sticker_content').removeClass('active');
        $('#'+tab+'_content').addClass('active');

    });
    /////////////////////////////
    $('body').on('click','#smile',function(){
        $('.box_sticker').toggle();
    });
    /////////////////////////////
    $('body').on('click', '#attachment', function() {
        $('#dinh_kem').click();
    });
    //////////////////////////////
    $('#dinh_kem').on('change', function() {
        var phien=$('#submit_yeucau').attr('phien');
        var user_out=$('.box_chat input[name=user_out]').val();
        if($('#list_chat .txt').length>0){
            sms_id=$('#list_chat .li_sms').last().attr('sms_id');
        }else{
            sms_id=0;
        }
        var form_data = new FormData();
        form_data.append('action', 'upload_dinhkem');
        $.each($("input[name=file]")[0].files, function(i, file) {
            form_data.append('file[]', file);
        });
        form_data.append('phien', phien);
        form_data.append('sms_id', sms_id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                        $('#list_chat').append(info.list);
                        scrollSmoothToBottom('list_chat');
                        var dulieu={
                            "list_out":info.list_out,
                            'list':info.list,
                            'phien':phien,
                            'loai':'admin',
                            'user_out':info.user_out,
                            'thanh_vien':info.thanh_vien
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_traodoi',info_chat);
                    }
                }, 3000);
            }

        });
    });
    ///////////////////
    setTimeout(function(){
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "get_total_cart"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.total_notification').html(info.total_noti);
                $('.total_ct_drop').html(info.total_cart_drop);
                $('.total_ct_ctv').html(info.total_cart_ctv);
                $('.total_ct_socdo').html(info.total_cart_socdo);
                $('.total_nap').html(info.total_nap);
                $('.total_rut').html(info.total_rut);
                $('.total_mua_seeding').html(info.total_mua_seeding);
                $('.total_mua_domain').html(info.total_mua_domain);
                $('.total_hotro_domain').html(info.total_hotro_domain);
                $('.total_dk_drop').html(info.total_dk_drop);
                $('.total_dk_ctv').html(info.total_dk_ctv);
                $('.total_hethang').html(info.total_hethang);
                $('.total_dat_live').html(info.total_dat_live);
                $('.total_tamkhoa').html(info.total_tamkhoa);
                $('.total_chat').html(info.total_chat);
            }

        });
        
    },3000);
    ////////////////////////////
    $('body').on('click','.hide_pop_thirth',function(){
        $('.pop_thirth').html('');
        $('.pop_thirth').hide();
        if($('.box_pop_add .pop_second').length<1){
            $('.box_pop_add').html('');
            $('.box_pop_add').hide();
        }else{

        }
    });
    ////////////////////////////
    $('body').on('click','.pop_second .title .material-icons',function(){
        $('.pop_second').hide();
        $('.pop_second').html('');
        if($('.box_pop_add_content').length<1){
            $('.box_pop_add').hide();
            $('.box_pop_add').html('');
        }
    });
    ///////////////////
    $('.box_select_product .box_title .fa').on('click',function(){
    	$('.box_select_product').hide();
    	$('.box_select_product .box_list').html('');
    	$('.box_select_product .box_list').attr('page',1);
    	$('input[name=key_deal]').val('');
    });
    $('.box_select_product').on('click','.action button',function(){
    	$(this).toggleClass('active');
    });
    $('.box_select_product .box_list').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 10) {
        	tiep=$('.box_select_product .box_list').attr('tiep');
        	page=$('.box_select_product .box_list').attr('page');
        	loaded=$('.box_select_product .box_list').attr('loaded');
        	key = $('input[name=key_deal]').val();
        	sort = $('.box_select_product select[name=sort]').val();
        	loai=$('button[name=select_main_product]').attr('loai');
        	if(loaded==1 && tiep==1 && page!=1 && key==''){
		    	$('.box_select_product .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
		    	$('.box_select_product .box_list').attr('loaded',0);
				var sp_id='';
		    	$('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
		    		sp_id+=$(this).attr('sp')+',';
		    	});
		    	if(loai=='main_product'){
			    	setTimeout(function(){
			            $.ajax({
			                url: "/admincp/process.php",
			                type: "post",
			                data: {
			                    action: 'load_product_main',
			                    list_id:sp_id,
			                    sort:sort,
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
			                url: "/admincp/process.php",
			                type: "post",
			                data: {
			                    action: 'load_product_sub',
			                    list_id:sp_id,
			                    sort:sort,
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
    $('body').on('keyup','.note_edit',function(){
        noidung=$(this).html();
        id=$(this).attr('id_bh');
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'update_note_baohanh',
                    noidung:noidung,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                }
            });
        },1000);

    });
    $('body').on('keyup','.note_edit_hotro',function(){
        noidung=$(this).html();
        id=$(this).attr('id_bh');
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'update_note_hotro',
                    noidung:noidung,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                }
            });
        },1000);

    });
    $('.select_product').on('click',function(){
    	$('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
    	$('.box_select_product').show();
    	$('.box_select_product .box_bottom button').attr('loai','main_product');
		var sp_id='';
    	$('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
    		sp_id+=$(this).attr('sp')+',';
    	});
    	setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_product_main',
                    list_id:sp_id,
                    sort:'id-desc',
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
    $('body').on('change','.box_select_product select[name=sort]',function(){
    	$('.box_select_product .box_list').attr('page','1');
    	$('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
		var sp_id='';
    	$('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
    		sp_id+=$(this).attr('sp')+',';
    	});
    	sort=$('.box_select_product select[name=sort]').val();
    	setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_product_main',
                    list_id:sp_id,
                    sort:sort,
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
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_product_sub',
                    list_id:sp_id,
                    sort:'id-desc',
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
                url: "/admincp/process.php",
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
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 10) {
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
                        url: "/admincp/process.php",
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
    ///////////////////
    $('body').on('click','.chon_quanly',function(){
        var user_id=$('.box_select_quanly .box_list').attr('user_id');
        var quanly=$(this).attr('quanly');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'chon_quanly',
                quanly:quanly,
                user_id:user_id
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
                    $('.box_select_quanly .box_list').html('');
                    $('.box_select_quanly .box_list').attr('user_id','');
                    $('.box_select_quanly').hide();
                    if(info.ok==1){
                        $('#tr_'+user_id+' .ten_quanly').html(info.ho_ten);
                    }
                }, 1500);
            }
        });

    });
    ///////////////////////////
    $('body').on('click','.menu_top .menu_top_right .notification .tab_notification .li_tab',function(){
        $('.tab_notification .li_tab').removeClass('active');
        $(this).addClass('active');
        tab=$('.tab_notification .li_tab.active').attr('id');
        if(tab=='tab_all'){
            loai='all';
        }else{
            loai='chuadoc';
        }
        $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_notification',
                loai:loai,
                page:1
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.list_notification .list_noti .loading_notification').remove();
                    $('.list_notification .list_noti').append(info.list);
                    $('.list_notification .list_noti').attr('page',info.page);
                    $('.list_notification .list_noti').attr('tiep',info.tiep);
                    $('.list_notification .list_noti').attr('loaded',1);
                }, 1000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click','.menu_top .menu_top_right .notification .icon_notification',function(){
        $('.list_notification').toggleClass('active');
        tab=$('.tab_notification .li_tab.active').attr('id');
        if(tab=='tab_all'){
            loai='all';
        }else{
            loai='chuadoc';
        }
        if($('.list_notification').hasClass('active')){
            $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_notification',
                    loai:loai,
                    page:1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.list_notification .list_noti .loading_notification').remove();
                        $('.list_notification .list_noti').append(info.list);
                        $('.list_notification .list_noti').attr('page',info.page);
                        $('.list_notification .list_noti').attr('tiep',info.tiep);
                        $('.list_notification .list_noti').attr('loaded',1);
                    }, 1000);
                }
            });
        }else{
        }
    });
        ////////////////////////
    $('.list_notification .list_noti').on('scroll', function() {
        tab=$('.tab_notification .li_tab.active').attr('id');
        if(tab=='tab_all'){
            loai='all';
        }else{
            loai='chuadoc';
        }
        div_notification=$('.list_notification .list_noti');
        if(div_notification.scrollTop() + div_notification.innerHeight() >= div_notification[0].scrollHeight - 10) {
            tiep=$('.list_notification .list_noti').attr('tiep');
            page=$('.list_notification .list_noti').attr('page');
            loaded=$('.list_notification .list_noti').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_notification .list_noti').prepend('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_notification .list_noti').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'load_notification',
                            loai:loai,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_notification .list_noti .loading_notification').remove();
                            $('.list_notification .list_noti').append(info.list);
                            $('.list_notification .list_noti').attr('page',info.page);
                            $('.list_notification .list_noti').attr('tiep',info.tiep);
                            $('.list_notification .list_noti').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
    })
    ///////////////////
    $('body').on('click','.capnhat_hh',function(){
        var btn=$(this);
        var hh=$(this).attr('hh');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'capnhat_hh',
                hh:hh
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 100);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        btn.html('Đã thanh toán');
                    }
                }, 1000);
            }
        });

    });
    ///////////////////
    $('body').on('click','.capnhat_donhang',function(){
        var btn=$(this);
        var user=$(this).attr('user');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'capnhat_donhang',
                user:user
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 100);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        btn.html('Đã cập nhật');
                    }
                }, 1000);
            }
        });

    });
    ///////////////////
    $('body').on('click','.capnhat_donhang_nhom',function(){
        var btn=$(this);
        var user=$(this).attr('user');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'capnhat_donhang_nhom',
                user:user
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 100);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        btn.html('Đã cập nhật');
                    }
                }, 1000);
            }
        });

    });
    ///////////////////
    $('body').on('click','.show_quanly',function(){
        var user_id=$(this).attr('user_id');
/*        $('.load_overlay').show();
        $('.load_process').fadeIn();*/
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_quanly',
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_select_quanly .box_list').append(info.list);
                $('.box_select_quanly .box_list').attr('user_id',user_id);
                $('.box_select_quanly').show();
            }
        });

    });
    ///////////////////
    $('.box_select_quanly .box_title .fa').on('click',function(){
        $('.box_select_quanly').hide();
        $('.box_select_quanly .box_list').html('');
        $('.box_select_quanly .box_list').attr('user_id','');
        $('.box_select_quanly input[name=key_quanly]').val('');
    });
    $('.box_select_quanly .search_member').on('click',function() {
        key = $('.box_select_quanly input[name=key_quanly]').val();
        if (key.length < 1) {
            $('.box_select_quanly input[name=key_quanly]').focus();
        } else {
            $('.box_select_quanly .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            setTimeout(function(){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'tim_quanly',
                        key:key
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('.box_select_quanly .box_list .loading_product').remove();
                        $('.box_select_quanly .box_list').html(info.list);
                    }
                });
            },1000);
        }
    });
    $('.box_select_quanly input[name=key_quanly]').keypress(function(e) {
        if (e.which == 13) {
            key = $('.box_select_quanly input[name=key_quanly]').val();
            if (key.length < 1) {
                $('.box_select_quanly input[name=key_quanly]').focus();
            } else {
                $('.box_select_quanly .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'tim_quanly',
                            key:key
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_quanly .box_list .loading_product').remove();
                            $('.box_select_quanly .box_list').html(info.list);
                        }
                    });
                },1000);
            }
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
                    url: "/admincp/process.php",
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
                        url: "/admincp/process.php",
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
    //////////////////////////
    $('.show_add_trend').on('click',function(){
        $('.box_select_product_trend .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_product_trend').show();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_product_trend',
                    page: 1,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_product_trend .box_list').html(info.list);
                    $('.box_select_product_trend .box_list').attr('page',info.page);
                    $('.box_select_product_trend .box_list').attr('tiep',info.tiep);
                    $('.box_select_product_trend .box_list').attr('loaded',1);
                }
            });
        },1000);

    });
    //////////////////////////
    $('.show_add_tuan').on('click',function(){
        $('.box_select_product_tuan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $('.box_select_product_tuan').show();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_product_tuan',
                    page: 1,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.box_select_product_tuan .box_list').html(info.list);
                    $('.box_select_product_tuan .box_list').attr('page',info.page);
                    $('.box_select_product_tuan .box_list').attr('tiep',info.tiep);
                    $('.box_select_product_tuan .box_list').attr('loaded',1);
                    $('.datetimepicker_mask').datetimepicker({
                        format:'H:i d/m/Y',
                        //mask:'16:35 26/07/1988',
                    });
                }
            });
        },1000);

    });
    //////////////////////////
    $('.show_add_marketing').on('click',function(){
        window.location.href='/admincp/add-remarketing';
    });
    ////////////////////////
    $('.box_select_product_trend .box_list').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 10) {
            tiep=$('.box_select_product_trend .box_list').attr('tiep');
            page=$('.box_select_product_trend .box_list').attr('page');
            loaded=$('.box_select_product_trend .box_list').attr('loaded');
            key = $('.box_select_product_trend input[name=key_deal]').val();
            if(loaded==1 && tiep==1 && page!=1 && key==''){
                $('.box_select_product_trend .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.box_select_product_trend .box_list').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'load_product_trend',
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product_trend .box_list .loading_product').remove();
                            $('.box_select_product_trend .box_list').append(info.list);
                            $('.box_select_product_trend .box_list').attr('page',info.page);
                            $('.box_select_product_trend .box_list').attr('tiep',info.tiep);
                            $('.box_select_product_trend .box_list').attr('loaded',1);
                        }
                    });
                },1000);
            }
            
        }
    })
        ////////////////////////
    $('.box_select_product_tuan .box_list').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 10) {
            tiep=$('.box_select_product_tuan .box_list').attr('tiep');
            page=$('.box_select_product_tuan .box_list').attr('page');
            loaded=$('.box_select_product_tuan .box_list').attr('loaded');
            key = $('.box_select_product_tuan input[name=key_deal]').val();
            if(loaded==1 && tiep==1 && page!=1 && key==''){
                $('.box_select_product_tuan .box_list').append('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.box_select_product_tuan .box_list').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'load_product_tuan',
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product_tuan .box_list .loading_product').remove();
                            $('.box_select_product_tuan .box_list').append(info.list);
                            $('.box_select_product_tuan .box_list').attr('page',info.page);
                            $('.box_select_product_tuan .box_list').attr('tiep',info.tiep);
                            $('.box_select_product_tuan .box_list').attr('loaded',1);
                            $('.datetimepicker_mask').datetimepicker({
                                format:'H:i d/m/Y',
                                //mask:'16:35 26/07/1988',
                            });
                        }
                    });
                },1000);
            }
            
        }
    })
    ///////////////////
    $('.box_select_product_trend .box_title .fa').on('click',function(){
        $('.box_select_product_trend').hide();
        $('.box_select_product_trend .box_list').html('');
        $('.box_select_product_trend .box_list').attr('page',1);
        $('.box_select_product_trend input[name=key_deal]').val('');
    });
    $('.box_select_product_trend').on('click','.action button',function(){
        var button=$(this);
        id=$(this).attr('sp');
        gia=$(this).parent().parent().find('input[type=text]').val();
        if(gia==''){
            $(this).parent().parent().find('input[type=text]').focus();
        }else{
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'add_product_trend',
                    id:id,
                    gia: gia,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    button.parent().parent().remove();
                    if(info.ok==1){
                        if(info.noti==1){
                            var dulieu={
                                'hd':'user_notification',
                            }
                            var info_chat=JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong',info_chat);
                        }
                        $('.list_baiviet').html(info.list);
                    }else{

                    }
                }
            });
        }
    });
    $('.box_select_product_trend .search_deal').on('click',function() {
        key = $('.box_select_product_trend input[name=key_deal]').val();
        if (key.length < 1) {
            $('.box_select_product_trend input[name=key_deal]').focus();
        } else {
            $('.box_select_product_trend .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            setTimeout(function(){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'search_product_trend',
                        key:key,
                        page: 1,
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('.box_select_product_trend .box_list').html(info.list);
                        $('.box_select_product_trend .box_list').attr('page',info.page);
                        $('.box_select_product_trend .box_list').attr('tiep',0);
                        $('.box_select_product_trend .box_list').attr('loaded',1);
                    }
                });
            },1000);
        }
    });
    $('.box_select_product_trend input[name=key_deal]').keypress(function(e) {
        if (e.which == 13) {
            key = $('.box_select_product_trend input[name=key_deal]').val();
            if (key.length < 1) {
                $('.box_select_product_trend input[name=key_deal]').focus();
            } else {
                $('.box_select_product_trend .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'search_product_trend',
                            key:key,
                            page: 1,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product_trend .box_list').html(info.list);
                            $('.box_select_product_trend .box_list').attr('page',info.page);
                            $('.box_select_product_trend .box_list').attr('tiep',0);
                            $('.box_select_product_trend .box_list').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
    });
    ///////////////////
    $('.box_select_product_tuan .box_title .fa').on('click',function(){
        $('.box_select_product_tuan').hide();
        $('.box_select_product_tuan .box_list').html('');
        $('.box_select_product_tuan .box_list').attr('page',1);
        $('.box_select_product_tuan input[name=key_deal]').val('');
    });
    $('.box_select_product_tuan').on('click','.action button',function(){
        var button=$(this);
        id=$(this).attr('sp');
        gia=$(this).attr('gia');
        gia_ctv=$(this).attr('gia_ctv');
        gia_tuan=$(this).parent().parent().find('input[name=gia_tuan]').val();
        gia_ctv_tuan=$(this).parent().parent().find('input[name=gia_ctv_tuan]').val();
        time_start=$(this).parent().parent().find('input[name=time_start]').val();
        time_end=$(this).parent().parent().find('input[name=time_end]').val();
        note_text=$(this).parent().parent().find('input[name=note_text]').val();
        if(gia_tuan==''){
            $(this).parent().parent().find('input[name=gia_tuan]').focus();
        }else if(time_start==''){
            $(this).parent().parent().find('input[name=time_start]').focus();
        }else if(time_end==''){
            $(this).parent().parent().find('input[name=time_end]').focus();
        }else{
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'add_product_tuan',
                    id:id,
                    gia_tuan:gia_tuan,
                    gia:gia,
                    gia_ctv_tuan:gia_ctv_tuan,
                    gia_ctv:gia_ctv,
                    time_start:time_start,
                    time_end:time_end,
                    note_text:note_text
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    button.parent().parent().remove();
                    if(info.ok==1){
                        if(info.noti==1){
                            var dulieu={
                                'hd':'user_notification',
                            }
                            var info_chat=JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong',info_chat);
                        }
                        $('.list_baiviet').html(info.list);
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
                    }else{

                    }
                }
            });
        }
    });
    $('.box_select_product_tuan .search_deal').on('click',function() {
        key = $('.box_select_product_tuan input[name=key_deal]').val();
        if (key.length < 1) {
            $('.box_select_product_tuan input[name=key_deal]').focus();
        } else {
            $('.box_select_product_tuan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            setTimeout(function(){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'search_product_tuan',
                        key:key,
                        page: 1,
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('.box_select_product_tuan .box_list').html(info.list);
                        $('.box_select_product_tuan .box_list').attr('page',info.page);
                        $('.box_select_product_tuan .box_list').attr('tiep',0);
                        $('.box_select_product_tuan .box_list').attr('loaded',1);
                        $('.datetimepicker_mask').datetimepicker({
                            format:'H:i d/m/Y',
                            //mask:'16:35 26/07/1988',
                        });
                    }
                });
            },1000);
        }
    });
    $('.box_select_product_tuan input[name=key_deal]').keypress(function(e) {
        if (e.which == 13) {
            key = $('.box_select_product_tuan input[name=key_deal]').val();
            if (key.length < 1) {
                $('.box_select_product_tuan input[name=key_deal]').focus();
            } else {
                $('.box_select_product_tuan .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'search_product_tuan',
                            key:key,
                            page: 1,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.box_select_product_tuan .box_list').html(info.list);
                            $('.box_select_product_tuan .box_list').attr('page',info.page);
                            $('.box_select_product_tuan .box_list').attr('tiep',0);
                            $('.box_select_product_tuan .box_list').attr('loaded',1);
                            $('.datetimepicker_mask').datetimepicker({
                                format:'H:i d/m/Y',
                                //mask:'16:35 26/07/1988',
                            });
                        }
                    });
                },1000);
            }
        }
    });
    $('.box_select_product .search_deal').on('click',function() {
        key = $('.box_select_product input[name=key_deal]').val();
        loai=$('.box_select_product button[name=select_main_product]').attr('loai');
		var sp_id='';
    	$('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
    		sp_id+=$(this).attr('sp')+',';
    	});
        if (key.length < 1) {
            $('.box_select_product input[name=key_deal]').focus();
        } else {
	    	$('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
	    	if(loai=='main_product'){
		    	setTimeout(function(){
		            $.ajax({
		                url: "/admincp/process.php",
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
		                url: "/admincp/process.php",
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
    $('.box_select_product input[name=key_deal]').keypress(function(e) {
        if (e.which == 13) {
            key = $('.box_select_product input[name=key_deal]').val();
	        loai=$('.box_select_product button[name=select_main_product]').attr('loai');
			var sp_id='';
	    	$('#list_product_main .li_product,#list_product_sub .li_product').each(function(){
	    		sp_id+=$(this).attr('sp')+',';
	    	});
            if (key.length < 1) {
                $('.box_select_product input[name=key_deal]').focus();
            } else {
		    	$('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
		    	if(loai=='main_product'){
			    	setTimeout(function(){
			            $.ajax({
			                url: "/admincp/process.php",
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
			                url: "/admincp/process.php",
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
    $('.box_select_product button[name=select_main_product]').on('click',function(){
    	loai=$(this).attr('loai');
    	if(loai=='main_product'){
	    	$('.box_select_product .box_list .li_product button.active').each(function(){
	    		sp_id=$(this).attr('sp');
	    		pl=$(this).attr('pl');
	    		if($('#list_product_main .li_product_'+sp_id).length<1){
	    			sanpham=$(this).parent().parent().html();
	    			sp=sanpham.replace("Chọn", "xóa");
	    			$('#list_product_main').append('<div class="li_product li_product_'+sp_id+'" sp="'+sp_id+'">'+sp+'</div>');
	    		}
	    	});
    	}else if(loai=='sub_product'){
    		kieu=$('input[name=loai]:checked').val();
    		var m=0;
    		var list_sub='';
	    	$('.box_select_product .box_list .li_product button.active').each(function(){
	    		m++;
	    		sp_id=$(this).attr('sp');
	    		pl=$(this).attr('pl');
	            if(m==1){
	                list_sub+= '{"sp_id":"'+sp_id+'"}';
	            }else{
	                list_sub+= ',{"sp_id":"'+sp_id+'"}';
	            }
	    	});
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'show_product_sub',
                    list_sub:list_sub,
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
        s=0;
        list='';
        list_product='';
        $('#list_product_sub .li_product').each(function(){
        	s++;
            sp_id=$(this).attr('sp');
            list_pl='';
            l=0;
            $(this).find('.li_pl').each(function(){
            	l++;
            	pl=$(this).attr('pl');
            	gia_cu=$(this).find('input[name^=gia_cu]').val();
                gia_moi=$(this).find('input[name^=gia_moi]').val();
            	gia=$(this).find('input[name^=gia_deal]').val();
            	so_luong=$(this).find('input[name^=so_luong]').val();
            	ten_color=$(this).find('.color span').text();
                color=$(this).find('.color').attr('color');
                ma_mau=$(this).find('.color').attr('ma_mau');
            	ten_size=$(this).find('.size span').text();
                size=$(this).find('.size').attr('size');
            	if(l==1){
            		list_pl+='{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'","so_luong":"'+so_luong+'"}';
            	}else{
            		list_pl+=',{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'","so_luong":"'+so_luong+'"}';
            	}
            });
            if(s==1){
            	list_product+='{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }else{
            	list_product+=',{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }
        });
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
        }else if(list_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'add_flash_sale',
                    tieu_de:tieu_de,
                    list_product:list_product,
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
    $('button[name=edit_flash_sale]').click(function() {
    	tieu_de=$('input[name=tieu_de]').val();
    	date_start=$('input[name=date_start]').val();
    	date_end=$('input[name=date_end]').val();
    	id=$('input[name=id]').val();
    	s=0;
        list='';
        list_product='';
        $('#list_product_sub .li_product').each(function(){
        	s++;
            sp_id=$(this).attr('sp');
            list_pl='';
            l=0;
            $(this).find('.li_pl').each(function(){
            	l++;
            	pl=$(this).attr('pl');
            	gia_cu=$(this).find('input[name^=gia_cu]').val();
                gia_moi=$(this).find('input[name^=gia_moi]').val();
            	gia=$(this).find('input[name^=gia_deal]').val();
            	so_luong=$(this).find('input[name^=so_luong]').val();
                ten_color=$(this).find('.color span').text();
                color=$(this).find('.color').attr('color');
                ma_mau=$(this).find('.color').attr('ma_mau');
                ten_size=$(this).find('.size span').text();
                size=$(this).find('.size').attr('size');
            	if(l==1){
            		list_pl+='{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'","so_luong":"'+so_luong+'"}';
            	}else{
            		list_pl+=',{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'","so_luong":"'+so_luong+'"}';
            	}
            });
            if(s==1){
            	list_product+='{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }else{
            	list_product+=',{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }
        });
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
        }else if(list_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
	        $.ajax({
	            url: "/admincp/process.php",
	            type: "post",
	            data: {
	                action: 'edit_flash_sale',
	                tieu_de:tieu_de,
	                list_product:list_product,
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
    $('button[name=add_deal]').click(function() {
    	tieu_de=$('input[name=tieu_de]').val();
    	loai=$('input[name=loai]:checked').val();
    	date_start=$('input[name=date_start]').val();
    	date_end=$('input[name=date_end]').val();
    	var main_product='';
    	$('#list_product_main .li_product').each(function(){
    		main_product+=$(this).attr('sp')+',';
    	});
    	s=0;
        list_product='';
        $('#list_product_sub .li_product').each(function(){
        	s++;
            sp_id=$(this).attr('sp');
            list_pl='';
            l=0;
            $(this).find('.li_pl').each(function(){
            	l++;
            	pl=$(this).attr('pl');
            	gia_cu=$(this).find('input[name^=gia_cu]').val();
                gia_moi=$(this).find('input[name^=gia_moi]').val();
            	gia=$(this).find('input[name^=gia_deal]').val();
                ten_color=$(this).find('.color span').text();
                color=$(this).find('.color').attr('color');
                ma_mau=$(this).find('.color').attr('ma_mau');
                ten_size=$(this).find('.size span').text();
                size=$(this).find('.size').attr('size');                
            	if(l==1){
            		list_pl+='{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'"}';
            	}else{
            		list_pl+=',{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'"}';
            	}
            });
            if(s==1){
            	list_product+='{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }else{
            	list_product+=',{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }
        });
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

        }else if(list_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm kèm theo');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
	        $.ajax({
	            url: "/admincp/process.php",
	            type: "post",
	            data: {
	                action: 'add_deal',
	                loai: loai,
	                tieu_de:tieu_de,
	                main_product:main_product,
	                list_product:list_product,
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
    	s=0;
        list_product='';
        $('#list_product_sub .li_product').each(function(){
        	s++;
            sp_id=$(this).attr('sp');
            list_pl='';
            l=0;
            $(this).find('.li_pl').each(function(){
            	l++;
            	pl=$(this).attr('pl');
            	gia_cu=$(this).find('input[name^=gia_cu]').val();
                gia_moi=$(this).find('input[name^=gia_moi]').val();
            	gia=$(this).find('input[name^=gia_deal]').val();
                ten_color=$(this).find('.color span').text();
                color=$(this).find('.color').attr('color');
                ma_mau=$(this).find('.color').attr('ma_mau');
                ten_size=$(this).find('.size span').text();
                size=$(this).find('.size').attr('size');
            	if(l==1){
            		list_pl+='{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'"}';
            	}else{
            		list_pl+=',{"pl": "'+pl+'","ten_color":"'+ten_color+'","color":"'+color+'","ma_mau":"'+ma_mau+'","ten_size":"'+ten_size+'","size":"'+size+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia":"'+gia+'"}';
            	}
            });
            if(s==1){
            	list_product+='{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }else{
            	list_product+=',{"sp_id": "'+sp_id+'","list_pl": ['+list_pl+']}';
            }
        });
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

        }else if(list_product==''){
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn sản phẩm kèm theo');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);

        }else{
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'edit_deal',
                    loai: loai,
                    tieu_de:tieu_de,
                    main_product:main_product,
                    list_product:list_product,
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
    $('.box_right_content').on('click', '.del_server', function() {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.box_right_content').on('click', '.add_server', function() {
        $('.block_bottom').before('<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link nguồn</label><input type="text" class="form_control" name="nguon" value="" placeholder="Nhập nguồn dữ liệu..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="button_select_photo">Chọn ảnh</button><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>');
    });
    /////////////////////////////
    $('.cover').click(function() {
        $('#cover').click();
    });
    /////////////////////////////
    $('.mh_minhhoa').click(function() {
        $('#cat_minhhoa').click();
    });
    $("#cat_minhhoa").change(function() {
        readURL(this, 'preview-cat-minhhoa');
    });
    /////////////////////////////
    $('.mh').click(function() {
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function() {
        readURL(this, 'preview-minhhoa');
    });
    $("#cover").change(function() {
        readURL(this, 'preview-cover');
    });
    /////////////////////////////
    $('.mh_socdo').click(function() {
        $('#minh_hoa_socdo').click();
    });
    $("#minh_hoa_socdo").change(function() {
        readURL(this, 'preview-minhhoa-socdo');
    });
    /////////////////////////////
    $('.mh_popup').click(function() {
        $('#popup').click();
    });
    $("#popup").change(function() {
        readURL(this, 'preview-popup');
    });
    /////////////////////////////
    $('.list_tab_member .li_tab_member').on('click', function() {
        $('.list_tab_member .li_tab_member').removeClass('active');
        $(this).addClass('active');
        var id = $(this).attr('id');
        $('.list_tab_content .li_tab_content').removeClass('active');
        $('#' + id + '_content').addClass('active');
        user_id = $('input[name=id]').val();
        page=1;
        load=1;
        if (id == 'tab_nap') {
            action = 'load_lichsu_nap';
        } else if (id == 'tab_order') {
            action = 'load_lichsu_dathang';
        } else if (id == 'tab_rut') {
            action = 'load_lichsu_rut';
        } else if (id == 'tab_chitieu') {
            action = 'load_lichsu_chitieu';
        } else if (id == 'tab_hoandon') {
            action = 'load_hoandon';
        } else if (id == 'tab_thanhvien_nhom_chuyennghiep') {
            action = 'load_thanhvien_nhom_chuyennghiep';
        } else if (id == 'tab_donhang_nhom_chuyennghiep') {
            action = 'load_donhang_nhom_chuyennghiep';
        } else if (id == 'tab_donhang_nhom_socdo_chuyennghiep') {
            action = 'load_donhang_nhom_socdo_chuyennghiep';
        } else {
            action = 'load_taikhoan';
            load = 0;
        }
        if (load == 1) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: action,
                    page: page,
                    user_id: user_id
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
                        $('#' + id + '_content .list_baiviet').html(info.list);
                        $('#' + id + '_content').attr('page',info.page);
                        $('#' + id + '_content').attr('load',info.load);
                    }, 1000);
                }
            });
        }

    });
    if($('.li_tab_member').length>0){
        $(window).scroll(function() {
            console.log($(window).scrollTop());
            console.log($(window).height());
            console.log($(document).height());
            console.log(($(window).scrollTop() + $(window).height()));
            console.log(($(document).height() - 50));
            console.log('-------------');
            if($(window).scrollTop() + $(window).height() > $(document).height() - 50) {
                console.log('bottom');
                var id=$('.li_tab_member.active').attr('id');
                console.log(id);
                user_id = $('input[name=id]').val();
                page=$('#'+id+"_content").attr('page');
                load=$('#'+id+"_content").attr('load');
                if(page>1){
                    if (id == 'tab_nap') {
                        action = 'load_lichsu_nap';
                    } else if (id == 'tab_order') {
                        action = 'load_lichsu_dathang';
                    } else if (id == 'tab_rut') {
                        action = 'load_lichsu_rut';
                    } else if (id == 'tab_chitieu') {
                        action = 'load_lichsu_chitieu';
                    } else if (id == 'tab_hoandon') {
                        action = 'load_hoandon';
                    } else if (id == 'tab_thanhvien_nhom_chuyennghiep') {
                        action = 'load_thanhvien_nhom_chuyennghiep';
                    } else if (id == 'tab_donhang_nhom_chuyennghiep') {
                        action = 'load_donhang_nhom_chuyennghiep';
                    } else if (id == 'tab_donhang_nhom_socdo_chuyennghiep') {
                        action = 'load_donhang_nhom_socdo_chuyennghiep';
                    } else {
                        action = 'load_taikhoan';
                        load = 0;
                    }
                    if (load == 1) {
                        $('#'+id+"_content").attr('load','0');
                        $.ajax({
                            url: "/admincp/process.php",
                            type: "post",
                            data: {
                                action: action,
                                page: page,
                                user_id: user_id
                            },
                            success: function(kq) {
                                var info = JSON.parse(kq);
                                $('#' + id + '_content .list_baiviet').append(info.list);
                                $('#' + id + '_content').attr('page',info.page);
                                $('#' + id + '_content').attr('load',info.load);
                            }
                        });
                    }
                }
           }
        });

    }
    /////////////////////////////
    $('input[name^=color]').on('click', function() {
        value = $(this).val();
        text = $(this).parent().find('span').html();
        if ($(this).is(':checked')) {
            $('.list_ma').append('<div class="li_ma" id="ma_sanpham_' + value + '"><input type="text" name="ma_sanpham[]" placeholder="Nhập mã sản phẩm" value="" mau="' + value + '"><i class="fa fa-arrow-right"></i><span>' + text + '</span></div>');
        } else {
            $('#ma_sanpham_' + value).remove();
        }

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
    $('#button_thuchien').click(function() {
        id = $('#button_thuchien').attr('post_id');
        loai = $('#button_thuchien').attr('loai');
        action = $('#button_thuchien').attr('action');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
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
    $('body').on('click', '.huy_donhang_drop', function() {
        id = $('#button_thuchien_action').attr('post_id');
        $('.box_pop').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'huy_donhang_drop',
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
    /////////////////////////////
    $('.box_profile').on('click', '.button_select_photo', function() {
        $('#photo-add').click();
    });
    $('.button_add_info').on('click', function() {
        $('.list_info').append('<div class="li_info"><div class="info_name"><input type="text" name="info_name[]" placeholder="Nhập tên thông tin"></div><div class="info_value"><input type="text" name="info_value[]" placeholder="Nhập giá trị thông tin"></div></div>');
    });
    $('.button_add_phanloai').on('click', function() {
        $('.list_phanloai').append('<div class="li_phanloai" pl=""><div class="info_ma"><input type="text" name="ma[]" placeholder="Mã"></div><div class="info_name"><input type="text" name="size[]" placeholder="Kích cỡ"><div class="list_goiy scroll"></div></div><div class="info_mau"><input type="text" name="color[]" placeholder="Màu sắc"><div class="list_goiy scroll"></div></div><div class="info_can_nang"><input type="text" name="can_nang[]" placeholder="Trọng lượng"></div><div class="info_gia"><input type="text" name="gia_cu[]" class="price_format" placeholder="Giá niêm yết"></div><div class="info_gia"><input type="text" name="gia_moi[]" class="price_format" placeholder="Giá bán"></div><div class="info_gia"><input type="text" name="gia_drop[]" class="price_format" placeholder="Giá Drop"></div><div class="info_gia"><input type="text" name="gia_ctv[]" class="price_format" placeholder="Giá CTV"></div><div class="info_gia"><input type="text" name="drop_min[]" class="price_format" placeholder="Giá tối thiểu"></div><div class="info_action"><i class="fa fa-trash-o"></i> Xóa</div></div>');
    });
    ////////////////
    $('body').on('keyup','.list_phanloai .li_phanloai input[name^=gia_moi]',function(){
        gia_moi=$(this).val();
        $(this).parent().parent().find('input[name^=drop_min]').val(gia_moi);
    });
    ////////////////
    $('body').on('keyup','.list_phanloai .li_phanloai input[name^=gia_drop]',function(){
        drop_min=parseFloat($(this).parent().parent().find('input[name^=drop_min]').val().replace(/,/g,''));
        gia_drop=parseFloat($(this).val().replace(/,/g,''));
        gia_ctv=gia_drop + ((drop_min - gia_drop)*0.3);
        $(this).parent().parent().find('input[name^=gia_ctv]').val(format_price(gia_ctv));
    });
    ////////////////
    $('body').on('keyup','.list_phanloai .li_phanloai input[name^=drop_min]',function(){
        gia_drop=parseFloat($(this).parent().parent().find('input[name^=gia_drop]').val().replace(/,/g,''));
        drop_min=parseFloat($(this).val().replace(/,/g,''));
        gia_ctv=gia_drop + ((drop_min - gia_drop)*0.3);
        $(this).parent().parent().find('input[name^=gia_ctv]').val(format_price(gia_ctv));
    });
    ////////////////
    $('body').on('click','.list_phanloai .list_goiy .li_goiy',function(){
        value=$(this).attr('value');
        text=$(this).text();
        $(this).parent().parent().find('input').val(text);
        $(this).parent().parent().find('input').attr('giatri',value);
        if($(this).attr('ma_mau') !== undefined){
            mm=$(this).attr('ma_mau');
            $(this).parent().parent().find('input').attr('ma_mau',mm);
        }else{

        }
        $(this).parent().html('');

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
            url: '/admincp/process.php',
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
    $('input[name=link_video]').on('paste', function(event) {
        setTimeout(function() {
            link_video = $('input[name=link_video]').val();
            var vars = [],
                hash;
            var hashes = link_video.slice(link_video.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            id_video = vars['v'];
            $('#preview-minhhoa').attr('src', 'https://i.ytimg.com/vi/' + id_video + '/sddefault.jpg');
        }, 500);
    });
    $('input[name=slug]').on('keyup', function() {
        slug = $(this).val();
        id = $('input[name=id]').val();
        $.ajax({
            url: "/admincp/process.php",
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
    $('body').on('click', '#main_category .li_input input', function() {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: '/admincp/process.php',
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
                url: '/admincp/process.php',
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
    $('#timkiem_thuonghieu').on('change', function() {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
    $('input[name=key]').keypress(function(e) {
        if (e.which == 13) {
            key = $('input[name=key]').val();
            if ($('button[name=timkiem_sanpham]').length > 0) {
                action = 'timkiem_sanpham';
            }else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
                action = 'timkiem_sanpham_trend';
            }else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
                action = 'timkiem_sanpham_tuan';
            } else if ($('button[name=timkiem_thanhvien]').length > 0) {
                action = 'timkiem_thanhvien';
            } else if ($('button[name=timkiem_thanhvien_nhom]').length > 0) {
                id=$('button[name=timkiem_thanhvien_nhom]').attr('nhom');
                action = 'timkiem_thanhvien_nhom';
            } else if ($('button[name=timkiem_thanhvien_drop]').length > 0) {
                action = 'timkiem_thanhvien_drop';
            } else if ($('button[name=timkiem_bom]').length > 0) {
                action = 'timkiem_bom';
            } else if ($('button[name=timkiem_donhang]').length > 0) {
                action = 'timkiem_donhang';
            }else if ($('button[name=timkiem_donhang_ctv]').length > 0) {
                var action = 'timkiem_donhang_ctv';
            }
            if (key.length < 1) {
                $('input[name=key]').focus();
            } else {
                if(action=='timkiem_thanhvien_nhom'){
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $.ajax({
                        url: '/admincp/process.php',
                        type: 'post',
                        data: {
                            action: action,
                            key: key,
                            id:id
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
                                    $('.pagination').hide();
                                } else {

                                }
                            }, 1000);
                        }
                    });
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $.ajax({
                        url: '/admincp/process.php',
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
                                    $('.pagination').hide();
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
        }
    });
    $('.button_timkiem').on('click', function() {
        key = $('input[name=key]').val();
        if ($('button[name=timkiem_sanpham]').length > 0) {
            var action = 'timkiem_sanpham';
        }else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
            var action = 'timkiem_sanpham_trend';
        }else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
            var action = 'timkiem_sanpham_tuan';
        } else if ($('button[name=timkiem_thanhvien]').length > 0) {
            var action = 'timkiem_thanhvien';
        } else if ($('button[name=timkiem_thanhvien_nhom]').length > 0) {
            id=$('button[name=timkiem_thanhvien_nhom]').attr('nhom');
            var action = 'timkiem_thanhvien_nhom';
        } else if ($('button[name=timkiem_thanhvien_drop]').length > 0) {
            var action = 'timkiem_thanhvien_drop';
        } else if ($('button[name=timkiem_bom]').length > 0) {
            var action = 'timkiem_bom';
        } else if ($('button[name=timkiem_donhang]').length > 0) {
            var action = 'timkiem_donhang';
        }else if ($('button[name=timkiem_donhang_ctv]').length > 0) {
            var action = 'timkiem_donhang_ctv';
        }
        if (key.length < 1) {
            $('input[name=key]').focus();
        } else {
            if(action=='timkiem_thanhvien_nhom'){
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admincp/process.php',
                    type: 'post',
                    data: {
                        action: action,
                        key: key,
                        id:id
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
                                $('.pagination').hide();
                            } else {

                            }
                        }, 1000);
                    }
                });
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/admincp/process.php',
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
                                $('.pagination').hide();
                                if(action=='timkiem_sanpham_tuan'){
                                    console.log('ok');
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
    $('body').on('click', '.li_photo i', function() {
        var item = $(this);
        if(item.parent().find('video').length>0){
            anh = item.parent().find('video').attr('src');

        }else{
            anh = item.parent().find('img').attr('src');
        }
        $.ajax({
            url: "/admincp/process.php",
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
    $('body').on('keyup','.box_yeucau .box_search input',function(){
        ten_khach=$(this).val();
        if(ten_khach.length>2){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'goiy_khach',
                    ten_khach:ten_khach,
                },
                dataType:'json',
                success: function(info) {
                    $('.box_yeucau .box_search .goi_y').html(info.list);
                    if(info.ok==1){
                        $('.box_yeucau .box_search .goi_y').show();
                    }else{
                        $('.box_yeucau .box_search .goi_y').hide();
                    }
                    
                }
            });
        }else{
            $('.box_yeucau .box_search .goi_y').html('');
            $('.box_yeucau .box_search .goi_y').hide();
        }
    });
    /////////////////////////////
    $('body').on('keyup','.list_phanloai input[name^=size]',function(){
        var li=$(this);
        key=$(this).val();
        if(key!=''){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'goiy_size',
                    key:key,
                },
                dataType:'json',
                success: function(info) {
                    li.parent().find('.list_goiy').html(info.list);                    
                }
            });
        }else{
            li.parent().find('.list_goiy').html('');
        }
    });
    /////////////////////////////
    $('body').on('keyup','.list_phanloai input[name^=color]',function(){
        var li=$(this);
        key=$(this).val();
        if(key!=''){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'goiy_color',
                    key:key,
                },
                dataType:'json',
                success: function(info) {
                    li.parent().find('.list_goiy').html(info.list);                    
                }
            });
        }else{
            li.parent().find('.list_goiy').html('');
        }
    });
    /////////////////////////////
    $('body').on('click','.box_yeucau .box_search .goi_y .li_goi_y',function(){
        thanh_vien=$(this).attr('thanhvien');
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_box_pop_thirth',
                thanh_vien:thanh_vien,
                loai: 'add_yeucau_lienhe'
            },
            success: function(kq) {
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
    $('body').on('click','.pop_add_lienhe #gui_ykien',function(){
        var noi_dung=$('.pop_add_lienhe textarea[name=noi_dung]').val();
        var thanh_vien=$('.pop_add_lienhe input[name=thanh_vien]').val();
        var user_out=$('.pop_add_lienhe input[name=user_out]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'add_yeucau_traodoi',
                thanh_vien:thanh_vien,
                noi_dung:noi_dung,
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        $('#list_yeucau .li_yeucau').removeClass('active');
                        $('#list_yeucau').prepend(info.list);
                        $('.box_yeucau_hotro #ten_khach').html(info.ho_ten);
                        $('.box_yeucau_hotro #submit_yeucau').attr('phien',info.phien_traodoi);
                        $('.box_yeucau_hotro #list_chat').html('');
                        $('.box_yeucau_hotro .note_content .txt').html(noi_dung);
                        $('.box_pop_add').hide();
                        $('.box_pop_add').html('');
                        var dulieu={
                            'user_out':user_out,
                            'thanh_vien':thanh_vien
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_list_yeucau',info_chat);
                    }else{

                    }
                }, 2000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.box_yeucau_hotro .box_yeucau .list_yeucau .list .li_yeucau',function(){
        var thanh_vien=$(this).attr('thanh_vien');
        var user_out=$('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=user_out]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_khach_traodoi',
                thanh_vien:thanh_vien,
                user_out:user_out
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    $('#list_yeucau').html(info.list);
                    $('.box_yeucau_hotro #ten_khach').html(info.ho_ten);
                    $('.box_yeucau_hotro #submit_yeucau').attr('phien',info.phien);
                    $('.box_yeucau_hotro #list_chat').html(info.list_chat);
                    $('input[name=load_chat]').val(info.load_chat);
                    $('.box_chat input[name=thanh_vien]').val(info.thanh_vien);
                    $('.box_yeucau_hotro .note_content .txt').html(info.note);
/*                    var dulieu={
                        'user_out':info.user_out,
                        'thanh_vien':info.thanh_vien
                    }
                    var info_chat=JSON.stringify(dulieu);
                    socket.emit('user_send_list_yeucau',info_chat);*/
                }else{

                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.box_chat #submit_yeucau',function(){
        var phien=$(this).attr('phien');
        var noi_dung=$('.box_chat input[name=noidung_yeucau]').val();
        var user_out=$('.box_chat input[name=user_out]').val();
        if($('#list_chat .txt').length>0){
            sms_id=$('#list_chat .li_sms').last().attr('sms_id');
        }else{
            sms_id=0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'add_sms_traodoi',
                phien:phien,
                noi_dung:noi_dung,
                sms_id:sms_id
            },
            success: function(kq) {
                $('.box_chat input[name=noidung_yeucau]').val('');
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                var info = JSON.parse(kq);
                $('#list_chat').append(info.list);
                scrollSmoothToBottom('list_chat');
                var dulieu={
                    "list_out":info.list_out,
                    'list':info.list,
                    'user_out':info.user_out,
                    'phien':info.phien,
                    'loai':'admin',
                    'thanh_vien':info.thanh_vien
                }
                var info_chat=JSON.stringify(dulieu);
                socket.emit('user_send_traodoi',info_chat);
            }
        });

    });
    $('body').on('keypress','.box_chat input[name=noidung_yeucau]',function(e){
        if(e.which == 13) {
            var phien=$('.box_chat #submit_yeucau').attr('phien');
            var noi_dung=$('.box_chat input[name=noidung_yeucau]').val();
            var user_out=$('.box_chat input[name=user_out]').val();
            if($('#list_chat .txt').length>0){
                sms_id=$('#list_chat .li_sms').last().attr('sms_id');
            }else{
                sms_id=0;
            }
            $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
            $('.box_chat .text_status .loading_chat').show();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'add_sms_traodoi',
                    phien:phien,
                    noi_dung:noi_dung,
                    sms_id:sms_id
                },
                success: function(kq) {
                    $('.box_chat input[name=noidung_yeucau]').val('');
                    $('.box_chat .text_status .loading_chat').hide();
                    $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                    var info = JSON.parse(kq);
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu={
                        "list_out":info.list_out,
                        'list':info.list,
                        'user_out':info.user_out,
                        'phien':info.phien,
                        'loai':'admin',
                        'thanh_vien':info.thanh_vien
                    }
                    var info_chat=JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi',info_chat);
                }
            });
        }else{
        }
    });
    $('body').on('click','.box_sticker .li_sticker img',function(e){
        $('.box_sticker').hide();
        var phien=$('.box_chat #submit_yeucau').attr('phien');
        var src=$(this).attr('src');
        var user_out=$('.box_chat input[name=user_out]').val();
        if($('#list_chat .txt').length>0){
            sms_id=$('#list_chat .li_sms').last().attr('sms_id');
        }else{
            sms_id=0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'add_sticker_traodoi',
                phien:phien,
                src:src,
                sms_id:sms_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                $('.box_chat input[name=noidung_yeucau]').val('');
                if(info.ok==1){
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu={
                        "list_out":info.list_out,
                        'list':info.list,
                        'phien':phien,
                        'loai':'admin',
                        'user_out':info.user_out,
                        'thanh_vien':info.thanh_vien
                    }
                    var info_chat=JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi',info_chat);
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
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
    $('#list_chat').scroll(function() {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {

        } else {
            load = $('input[name=load_chat]').val();
            loaded = $('input[name=load_chat]').attr('loaded');
            sms_id=$('#list_chat .li_sms').first().attr('sms_id');
            var phien=$('.box_chat #submit_yeucau').attr('phien');
            if(st < 50 && loaded == 1 && load == 1) {
                $('#list_chat').prepend('<div class="li_load_chat"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
                $('input[name=load_chat]').attr('loaded','0');
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_chat_sms",
                            phien:phien,
                            sms_id:sms_id
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_chat .li_load_chat').remove();
                            $('input[name=load_chat]').val(info.load_chat);
                            $('input[name=load_chat]').attr('loaded','1');
                            if(info.ok==1){
                                $('#list_chat').prepend(info.list_chat);
                                total_height=0;
                                $('#list_chat .li_sms').each(function(){
                                    if($(this).attr('sms_id')<sms_id){
                                        total_height+=$(this).outerHeight();
                                    }
                                });
                                $('#list_chat').animate({
                                    scrollTop: total_height - 50
                                }, 200);
                            }else{
                            }
                        }
                    });
                },3000);
            } else {

            }
        }
        lastScrollTop = st;

    });
    /////////////////////////////
    socket.on("server_send_hoatdong",function(data){
        var info=JSON.parse(data);
        bo_phan=$('input[name=bophan_hotro]').val();
        if(info.hd=='notification'){
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'load_tk_notification',
                        bo_phan:bo_phan
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('#play_chat_global').click();
                        $('.total_notification').html(info.total_notification);
                    }
                });
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_traodoi",function(data){
        user_out=$('.box_chat input[name=user_out]').val();
        phien=$('#submit_yeucau').attr('phien');
        bo_phan=$('input[name=bophan_hotro]').val();
        var info=JSON.parse(data);
        if(user_out==info.user_out){
        }else{
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $('#play_chat').click();
                if(phien==info.phien){
                    if(info.loai=='thanh_vien'){
                        $('#list_chat').append(info.list_out);
                    }else{
                        $('#list_chat').append(info.list);
                    }
                    scrollSmoothToBottom('list_chat');
                }
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_list_yeucau",function(data){
        phien=$('#submit_yeucau').attr('phien');
        user_out=$('.box_chat input[name=user_out]').val();
        bo_phan=$('input[name=bophan_hotro]').val();
        var info=JSON.parse(data);
        if(user_out==info.user_out){
        }else{
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'load_list_yeucau',
                        phien:phien
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('#play_chat_global').click();
                        $('#list_yeucau').html(info.list);
                    }
                });
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_dong_yeucau",function(data){
        phien=$('#submit_yeucau').attr('phien');
        user_out=$('.box_chat input[name=user_out]').val();
        bo_phan=$('input[name=bophan_hotro]').val();
        var info=JSON.parse(data);
        if(user_out==info.user_out){
        }else{
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'load_list_yeucau',
                        phien:phien
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('#list_yeucau').html(info.list);
                    }
                });
            }
        }
    });
    /////////////////////////////
    $('body').on('click','.box_chat #dong_yeucau',function(){
        phien=$('.box_chat #submit_yeucau').attr('phien');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'dong_yeucau',
                phien:phien
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', true);
                        var dulieu={
                            'user_out':info.user_out,
                            'thanh_vien':info.thanh_vien,
                            'phien':info.phien,
                            'bo_phan':info.bo_phan
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_dong_yeucau',info_chat);
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('.ctv_status input[type=radio]').on('click', function() {
        status = $(this).val();
        user_id = $(this).attr('name');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "update_ctv",
                user_id: user_id,
                status: status
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
                }, 2000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click','.drop_status input[type=radio]', function() {
        status = $(this).val();
        user_id = $(this).attr('name');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "update_drop",
                user_id: user_id,
                status: status
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
                }, 2000);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_naptien]').on('click', function() {
        username = $('input[name=username]').val();
        sotien = $('input[name=sotien]').val();
        loai = $('select[name=loai]').val();
        noidung = $('textarea[name=noidung]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "add_naptien",
                username: username,
                sotien: sotien,
                loai: loai,
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
                        window.location.reload();
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_naptien]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_naptien",
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
                        window.location.href = '/admincp/list-naptien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_ruttien]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_ruttien",
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
                        window.location.href = '/admincp/list-ruttien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_donhang]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
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
    $('button[name=edit_donhang_ctv]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_donhang_ctv",
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
    $('.select_vaitro').on('change', function() {
        user_id = $(this).attr('user_id');
        nhom = $(this).attr('nhom');
        vaitro = $(this).val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        var form_data = new FormData();
        form_data.append('action', 'select_vaitro');
        form_data.append('user_id', user_id);
        form_data.append('vaitro', vaitro);
        form_data.append('nhom', nhom);
        $.ajax({
            url: '/admincp/process.php',
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
    });
    /////////////////////////////
    $('button[name=edit_tichdiem]').on('click', function() {
        diem = $('input[name=diem]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
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
    $('button[name=add_nhom]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'add_nhom');
            form_data.append('tieu_de', tieu_de);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_nhom]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'edit_nhom');
            form_data.append('tieu_de', tieu_de);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
                            window.location.href = '/admincp/list-nhom';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_thanhvien_nhom]').on('click', function() {
        thanhvien = $('textarea[name=thanhvien]').val();
        id = $('input[name=id]').val();
        if (thanhvien.length < 2) {
            $('textarea[name=thanhvien]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'add_thanhvien_nhom');
            form_data.append('thanhvien', thanhvien);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
                            window.location.href = '/admincp/list-thanhvien-nhom?id=' + id;
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_goi_seeding_shopee]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia = $('input[name=gia]').val();
        thu_tu = $('input[name=thu_tu]').val();
        thoi_gian = $('input[name=thoi_gian]').val();
        loai = $('select[name=loai]').val();
        uu_dai = $('textarea[name=uu_dai]').val();
        if (tieu_de.length < 2) {
            $('tieu_de[name=thanhvien]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'add_seeding_shopee');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia', gia);
            form_data.append('uu_dai', uu_dai);
            form_data.append('thoi_gian', thoi_gian);
            form_data.append('loai', loai);
            form_data.append('thu_tu', thu_tu);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_goi_seeding_shopee]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        gia_cu = $('input[name=gia_cu]').val();
        gia = $('input[name=gia]').val();
        thu_tu = $('input[name=thu_tu]').val();
        uu_dai = $('textarea[name=uu_dai]').val();
        thoi_gian = $('input[name=thoi_gian]').val();
        loai = $('select[name=loai]').val();
        id=$('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('tieu_de[name=thanhvien]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'edit_seeding_shopee');
            form_data.append('tieu_de', tieu_de);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia', gia);
            form_data.append('uu_dai', uu_dai);
            form_data.append('thoi_gian', thoi_gian);
            form_data.append('thu_tu', thu_tu);
            form_data.append('loai', loai);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_mua_seeding]').on('click', function() {
        status = $('select[name=status]').val();
        id=$('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        var form_data = new FormData();
        form_data.append('action', 'edit_mua_seeding');
        form_data.append('status', status);
        form_data.append('id', id);
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.href='/admincp/list-mua-seeding';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_livestream]').on('click', function() {
        status = $('select[name=status]').val();
        id=$('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        var form_data = new FormData();
        form_data.append('action', 'edit_livestream');
        form_data.append('status', status);
        form_data.append('id', id);
        $.ajax({
            url: '/admincp/process.php',
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
                        window.location.href='/admincp/list-livestream';
                    } else {

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
                url: '/admincp/process.php',
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
                            $('#doanhthu_hoan').html(info.doanhthu_hoan);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#doanhthu_tiepnhan').html(info.doanhthu_tiepnhan);
                            $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
                            $('#donhang_giao').html(info.donhang_giao);
                            $('#donhang_huy').html(info.donhang_huy);
                            $('#donhang_hoan').html(info.donhang_hoan);
                            $('#donhang_cho').html(info.donhang_cho);
                            $('#donhang_tiepnhan').html(info.donhang_tiepnhan);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_thongke_drop]').on('click', function() {
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
            form_data.append('action', 'load_thongke_drop');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
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
                            $('.list_baiviet').html(info.list);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_thongke_ctv]').on('click', function() {
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
            form_data.append('action', 'load_thongke_ctv');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
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
                            $('.list_baiviet').html(info.list);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_thongke_muaweb]').on('click', function() {
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
            form_data.append('action', 'load_thongke_muaweb');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
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
                            $('.list_baiviet').html(info.list);
                            $('#doanhthu_tk').html(info.text_tk);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_seeding]').on('click', function() {
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
            form_data.append('action', 'load_seeding');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
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
                            $('#doanhthu_hoanthanh').html(info.doanhthu_finish);
                            $('#doanhthu_cho').html(info.doanhthu_wait);
                            $('#doanhthu_tiepnhan').html(info.doanhthu_run);
                            $('#donhang_hoanthanh').html(info.donhang_finish);
                            $('#donhang_cho').html(info.donhang_wait);
                            $('#donhang_tiepnhan').html(info.donhang_run);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_doanhthu_nhom]').on('click', function() {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        id = $(this).attr('id');
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhthu_nhom');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
                            $('#doanhthu_hoan').html(info.doanhthu_hoan);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#doanhthu_tiepnhan').html(info.doanhthu_tiepnhan);
                            $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
                            $('#donhang_giao').html(info.donhang_giao);
                            $('#donhang_huy').html(info.donhang_huy);
                            $('#donhang_hoan').html(info.donhang_hoan);
                            $('#donhang_cho').html(info.donhang_cho);
                            $('#donhang_tiepnhan').html(info.donhang_tiepnhan);
                            $('.list_baiviet').html(info.list_thanhvien);
                        } else {

                        }
                    }, 2000);
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
        dieu_kien = $('input[name=dieu_kien]').val();
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
            form_data.append('dieu_kien', dieu_kien);
            form_data.append('sanpham', main_product);
            form_data.append('time_start', time_start);
            form_data.append('date_start', date_start);
            form_data.append('time_expired', time_expired);
            form_data.append('date_expired', date_expired);
            $.ajax({
                url: '/admincp/process.php',
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
        dieu_kien = $('input[name=dieu_kien]').val();
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
            form_data.append('dieu_kien', dieu_kien);
            form_data.append('sanpham', main_product);
            form_data.append('time_start', time_start);
            form_data.append('date_start', date_start);
            form_data.append('time_expired', time_expired);
            form_data.append('date_expired', date_expired);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=add_idol]').on('click', function() {
        ho_ten = $('input[name=ho_ten]').val();
        nam_sinh = $('input[name=nam_sinh]').val();
        chieu_cao = $('input[name=chieu_cao]').val();
        can_nang = $('input[name=can_nang]').val();
        kinh_nghiem = $('textarea[name=kinh_nghiem]').val();
        time_start = $('input[name=time_start]').val();
        time_end = $('input[name=time_end]').val();
        ngan_sach = $('input[name=ngan_sach]').val();
        thu_tu = $('input[name=thu_tu]').val();
        video = $('input[name=video]').val();
        an = $('select[name=an]').val();
        if (ho_ten.length < 4) {
            $('input[name=ho_ten]').focus();
        }else if (nam_sinh.length < 4) {
            $('input[name=nam_sinh]').focus();
        }else if (chieu_cao.length < 2) {
            $('input[name=chieu_cao]').focus();
        }else if (can_nang.length < 2) {
            $('input[name=can_nang]').focus();
        }else if (kinh_nghiem.length < 4) {
            $('textarea[name=kinh_nghiem]').focus();
        }else if (time_start.length < 4) {
            $('input[name=time_start]').focus();
        }else if (time_end.length < 4) {
            $('input[name=time_end]').focus();
        }else if (ngan_sach.length < 2) {
            $('input[name=ngan_sach]').focus();
        }else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_idol');
            form_data.append('file', file_data);
            form_data.append('ho_ten', ho_ten);
            form_data.append('nam_sinh', nam_sinh);
            form_data.append('chieu_cao', chieu_cao);
            form_data.append('can_nang', can_nang);
            form_data.append('kinh_nghiem', kinh_nghiem);
            form_data.append('time_start', time_start);
            form_data.append('time_end', time_end);
            form_data.append('ngan_sach', ngan_sach);
            form_data.append('video', video);
            form_data.append('thu_tu', thu_tu);
            form_data.append('an', an);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_idol]').on('click', function() {
        ho_ten = $('input[name=ho_ten]').val();
        nam_sinh = $('input[name=nam_sinh]').val();
        chieu_cao = $('input[name=chieu_cao]').val();
        can_nang = $('input[name=can_nang]').val();
        kinh_nghiem = $('textarea[name=kinh_nghiem]').val();
        time_start = $('input[name=time_start]').val();
        time_end = $('input[name=time_end]').val();
        ngan_sach = $('input[name=ngan_sach]').val();
        video = $('input[name=video]').val();
        thu_tu = $('input[name=thu_tu]').val();
        an = $('select[name=an]').val();
        id = $('input[name=id]').val();
        if (ho_ten.length < 4) {
            $('input[name=ho_ten]').focus();
        }else if (nam_sinh.length < 4) {
            $('input[name=nam_sinh]').focus();
        }else if (chieu_cao.length < 2) {
            $('input[name=chieu_cao]').focus();
        }else if (can_nang.length < 2) {
            $('input[name=can_nang]').focus();
        }else if (kinh_nghiem.length < 4) {
            $('textarea[name=kinh_nghiem]').focus();
        }else if (time_start.length < 4) {
            $('input[name=time_start]').focus();
        }else if (time_end.length < 4) {
            $('input[name=time_end]').focus();
        }else if (ngan_sach.length < 2) {
            $('input[name=ngan_sach]').focus();
        }else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_idol');
            form_data.append('file', file_data);
            form_data.append('ho_ten', ho_ten);
            form_data.append('nam_sinh', nam_sinh);
            form_data.append('chieu_cao', chieu_cao);
            form_data.append('can_nang', can_nang);
            form_data.append('kinh_nghiem', kinh_nghiem);
            form_data.append('time_start', time_start);
            form_data.append('time_end', time_end);
            form_data.append('ngan_sach', ngan_sach);
            form_data.append('video', video);
            form_data.append('thu_tu', thu_tu);
            form_data.append('an', an);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=add_slide]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
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
                url: '/admincp/process.php',
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
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
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
                url: '/admincp/process.php',
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
                            window.location.href = '/admincp/list-slide';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });

    /////////////////////////////
    $('button[name=add_giaodien]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        demo = $('input[name=demo]').val();
        gia_moi = $('input[name=gia_moi]').val();
        gia_cu = $('input[name=gia_cu]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var file_data_socdo = $('#minh_hoa_socdo').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_giaodien');
            form_data.append('file', file_data);
            form_data.append('file_socdo', file_data_socdo);
            form_data.append('tieu_de', tieu_de);
            form_data.append('demo', demo);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('thu_tu', thu_tu);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_giaodien]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        demo = $('input[name=demo]').val();
        gia_moi = $('input[name=gia_moi]').val();
        gia_cu = $('input[name=gia_cu]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var file_data_socdo = $('#minh_hoa_socdo').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_giaodien');
            form_data.append('file', file_data);
            form_data.append('file_socdo', file_data_socdo);
            form_data.append('tieu_de', tieu_de);
            form_data.append('demo', demo);
            form_data.append('gia_cu', gia_cu);
            form_data.append('gia_moi', gia_moi);
            form_data.append('thu_tu', thu_tu);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
                            window.location.href = '/admincp/list-giaodien';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_banner]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        bg_banner = $('input[name=bg_banner]').val();
        target = $('select[name=target]').val();
        vi_tri = $('select[name=vi_tri]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_banner');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('bg_banner', bg_banner);
            form_data.append('target', target);
            form_data.append('vi_tri', vi_tri);
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_banner]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        bg_banner = $('input[name=bg_banner]').val();
        id = $('input[name=id]').val();
        target = $('select[name=target]').val();
        vi_tri = $('select[name=vi_tri]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_banner');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('bg_banner', bg_banner);
            form_data.append('target', target);
            form_data.append('vi_tri', vi_tri);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
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
                            window.location.href = '/admincp/list-banner';
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
            url: '/admincp/process.php',
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
                        window.location.href = '/admincp/list-setting';
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
            url: "/admincp/process.php",
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
                        window.location.href = '/admincp/list-setting';
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
            url: "/admincp/process.php",
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
                        window.location.href = '/admincp/list-setting';
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
    $('#kieu_price').on('change', function() {
        kieu = $('#kieu_price option:selected').val();
        if (kieu == 'khoang') {
            $('.khoang').show();
            $('.price_to').hide();
        } else {
            $('.khoang').hide();
            $('.price_to').show();
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
                url: "/admincp/process.php",
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
                url: "/admincp/process.php",
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
                            window.location.href = '/admincp/list-menu';
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
        cat_link = $('input[name=cat_link]').val();
        cat_thutu = $('input[name=cat_thutu]').val();
        cat_title = $('input[name=cat_title]').val();
        link_old = $('input[name=link_old]').val();
        hoa_hong = $('input[name=hoa_hong]').val();
        cat_description = $('textarea[name=cat_description]').val();
        cat_noidung = $('textarea[name=cat_noidung]').val();
        cat_id = $('input[name=id]').val();
        cat_icon = $('input[name=cat_icon]').val();
        cat_main = $('select[name=cat_main]').val();
        cat_index = $('input[name=cat_index]:checked').val();
        cat_trend = $('input[name=cat_trend]:checked').val();
        cat_noibat = $('input[name=cat_noibat]:checked').val();
        if (cat_tieude.length < 2) {
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var file_minhhoa_data = $('#cat_minhhoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_category');
            form_data.append('file', file_data);
            form_data.append('file_minhhoa', file_minhhoa_data);
            form_data.append('cat_tieude', cat_tieude);
            form_data.append('cat_blank', cat_blank);
            form_data.append('link_old', link_old);
            form_data.append('cat_title', cat_tieude);
            form_data.append('cat_description', cat_description);
            form_data.append('cat_noidung', cat_noidung);
            form_data.append('cat_main', cat_main);
            form_data.append('cat_icon', cat_icon);
            form_data.append('cat_index', cat_index);
            form_data.append('cat_trend', cat_trend);
            form_data.append('cat_noibat', cat_noibat);
            form_data.append('cat_thutu', cat_thutu);
            form_data.append('cat_link', cat_link);
            form_data.append('hoa_hong', hoa_hong);
            form_data.append('cat_id', cat_id);
            $.ajax({
                url: '/admincp/process.php',
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
                            window.location.href = '/admincp/list-category';
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
        cat_link = $('input[name=cat_link]').val();
        cat_thutu = $('input[name=cat_thutu]').val();
        cat_title = $('input[name=cat_title]').val();
        cat_description = $('textarea[name=cat_description]').val();
        cat_noidung = $('textarea[name=cat_noidung]').val();
        cat_main = $('select[name=cat_main]').val();
        cat_icon = $('input[name=cat_icon]').val();
        hoa_hong = $('input[name=hoa_hong]').val();
        cat_index = $('input[name=cat_index]:checked').val();
        cat_trend = $('input[name=cat_trend]:checked').val();
        cat_noibat = $('input[name=cat_noibat]:checked').val();
        if (cat_tieude.length < 2) {
            $('input[name=cat_tieude]').focus();
        } else if (cat_thutu == '') {
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var file_minhhoa_data = $('#cat_minhhoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_category');
            form_data.append('file', file_data);
            form_data.append('file_minhhoa', file_minhhoa_data);
            form_data.append('cat_tieude', cat_tieude);
            form_data.append('cat_blank', cat_blank);
            form_data.append('cat_title', cat_tieude);
            form_data.append('cat_description', cat_description);
            form_data.append('cat_noidung', cat_noidung);
            form_data.append('cat_main', cat_main);
            form_data.append('cat_icon', cat_icon);
            form_data.append('cat_index', cat_index);
            form_data.append('cat_trend', cat_trend);
            form_data.append('cat_noibat', cat_noibat);
            form_data.append('cat_thutu', cat_thutu);
            form_data.append('hoa_hong', hoa_hong);
            form_data.append('cat_link', cat_link);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_category_video]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'edit_category_video');
            form_data.append('tieu_de', tieu_de);
            form_data.append('thu_tu', thu_tu);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=add_category_video]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'add_category_video');
            form_data.append('tieu_de', tieu_de);
            form_data.append('thu_tu', thu_tu);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
                url: "/admincp/process.php",
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
                url: "/admincp/process.php",
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
    /////////////////////////////
    $('button[name=add_brand]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_brand",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu
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
    $('button[name=edit_brand]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_brand",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
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
                            window.location.href = '/admincp/list-brand';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_price]').on('click', function() {
        kieu = $('select[name=kieu]').val();
        price = $('input[name=price]').val();
        min_price = $('input[name=min_price]').val();
        max_price = $('input[name=max_price]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (kieu == 'khoang') {
            if (min_price.length < 1) {
                $('input[name=min_price]').focus();
            } else if (max_price.length < 1) {
                $('input[name=max_price]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "add_price",
                        kieu: kieu,
                        price: price,
                        min_price: min_price,
                        max_price: max_price,
                        thu_tu: thu_tu
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
        } else {
            if (price.length < 1) {
                $('input[name=price]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "add_price",
                        kieu: kieu,
                        price: price,
                        min_price: min_price,
                        max_price: max_price,
                        thu_tu: thu_tu
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

        }
    });
    /////////////////////////////
    $('button[name=edit_price]').on('click', function() {
        kieu = $('select[name=kieu]').val();
        price = $('input[name=price]').val();
        min_price = $('input[name=min_price]').val();
        max_price = $('input[name=max_price]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (kieu == 'khoang') {
            if (min_price.length < 1) {
                $('input[name=min_price]').focus();
            } else if (max_price.length < 1) {
                $('input[name=max_price]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "edit_price",
                        kieu: kieu,
                        price: price,
                        min_price: min_price,
                        max_price: max_price,
                        thu_tu: thu_tu,
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
                                window.location.href = '/admincp/list-price';
                            } else {

                            }
                        }, 3000);
                    }
                });
            }
        } else {
            if (price.length < 1) {
                $('input[name=price]').focus();
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: "edit_price",
                        kieu: kieu,
                        price: price,
                        min_price: min_price,
                        max_price: max_price,
                        thu_tu: thu_tu,
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
                                window.location.href = '/admincp/list-price';
                            } else {

                            }
                        }, 3000);
                    }
                });
            }

        }
    });
    /////////////////////////////
    $('button[name=add_size]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 1) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_size",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu
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
    $('button[name=edit_size]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 1) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_size",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
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
                            window.location.href = '/admincp/list-size';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });

    /////////////////////////////
    $('button[name=add_domain]').on('click', function() {
        domain = $('input[name=domain]').val();
        loai = $('select[name=loai]').val();
        gia = $('input[name=gia]').val();
        phi_caidat = $('input[name=phi_caidat]').val();
        gia_han = $('input[name=gia_han]').val();
        thu_tu = $('input[name=thu_tu]').val();
        if (domain.length < 1) {
            $('input[name=domain]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_domain",
                    domain: domain,
                    loai: loai,
                    gia: gia,
                    phi_caidat: phi_caidat,
                    gia_han: gia_han,
                    thu_tu: thu_tu
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
    $('button[name=edit_mua_domain]').on('click', function() {
        status = $('select[name=status]').val();
        id = $('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_mua_domain",
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
                        window.location.href = '/admincp/list-mua-tenmien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_hotro_domain]').on('click', function() {
        status = $('select[name=status]').val();
        id = $('input[name=id]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_hotro_domain",
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
                        window.location.href = '/admincp/list-hotro-tenmien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_domain]').on('click', function() {
        domain = $('input[name=domain]').val();
        loai = $('select[name=loai]').val();
        gia = $('input[name=gia]').val();
        phi_caidat = $('input[name=phi_caidat]').val();
        gia_han = $('input[name=gia_han]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (domain.length < 1) {
            $('input[name=tieu_de]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_domain",
                    domain: domain,
                    loai: loai,
                    gia: gia,
                    phi_caidat: phi_caidat,
                    gia_han: gia_han,
                    thu_tu: thu_tu,
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
                            window.location.href = '/admincp/list-domain';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_color]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        ma_mau = $('input[name=ma_mau]').attr('data-current-color');
        thu_tu = $('input[name=thu_tu]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (ma_mau.length < 6) {
            $('input[name=ma_mau]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_color",
                    tieu_de: tieu_de,
                    ma_mau: ma_mau,
                    thu_tu: thu_tu
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
    $('button[name=edit_color]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        ma_mau = $('input[name=ma_mau]').attr('data-current-color');
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (ma_mau.length < 6) {
            $('input[name=ma_mau]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_color",
                    tieu_de: tieu_de,
                    ma_mau: ma_mau,
                    thu_tu: thu_tu,
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
                            window.location.href = '/admincp/list-color';
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
            $('input[name=cat_thutu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
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
                            window.location.href = '/admincp/list-theloai';
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
                url: "/admincp/process.php",
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
        dien_thoai = $('input[name=dien_thoai]').val();
        active = $('select[name=active]').val();
        nhan_vien = $('select[name=nhan_vien]').val();
        dropship = $('select[name=dropship]').val();
        leader = $('select[name=leader]').val();
        id = $('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_thanhvien');
        form_data.append('file', file_data);
        form_data.append('name', name);
        form_data.append('dien_thoai', dien_thoai);
        form_data.append('active', active);
        form_data.append('nhan_vien', nhan_vien);
        form_data.append('dropship', dropship);
        form_data.append('leader', leader);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
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
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "dangnhap",
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
                            window.location.href = '/admincp/dashboard';
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
            url: "/admincp/process.php",
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
    $('button[name=button_profile]').on('click', function() {
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        if (name.length < 2) {
            $('input[name=name]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
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
    $('button[name=add_share_sanpham]').on('click', function() {
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_photo = [];
        $('.list_photo img, .list_photo video').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        sp_id=$('input[name=sp_id]').val();
        if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_share_sanpham');
            form_data.append('anh', anh);
            form_data.append('noidung', noidung);
            form_data.append('sp_id', sp_id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=edit_share_sanpham]').on('click', function() {
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_photo = [];
        $('.list_photo img, .list_photo video').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        id=$('input[name=id]').val();
        sp_id=$('input[name=sp_id]').val();
        if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var form_data = new FormData();
            form_data.append('action', 'edit_share_sanpham');
            form_data.append('anh', anh);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                window.location.href='/admincp/list-share-sanpham?id='+sp_id;
                            }
                        }, 3000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=add_noidung_nhiemvu').on('click', function() {
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_photo = [];
        $('.list_photo img, .list_photo video').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        tieu_de=$('input[name=tieu_de]').val();
        nhiemvu_id=$('input[name=nhiemvu_id]').val();
        if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_noidung_nhiemvu');
            form_data.append('anh', anh);
            form_data.append('tieu_de', tieu_de);
            form_data.append('noidung', noidung);
            form_data.append('nhiemvu_id', nhiemvu_id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=edit_noidung_nhiemvu]').on('click', function() {
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_photo = [];
        $('.list_photo img, .list_photo video').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        id=$('input[name=id]').val();
        tieu_de=$('input[name=tieu_de]').val();
        nhiemvu_id=$('input[name=nhiemvu_id]').val();
        if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var form_data = new FormData();
            form_data.append('action', 'edit_noidung_nhiemvu');
            form_data.append('anh', anh);
            form_data.append('tieu_de', tieu_de);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                window.location.href='/admincp/list-noidung-nhiemvu?id='+nhiemvu_id;
                            }
                        }, 3000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=add_banner_qc]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        active = $('input[name=active]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        if (tieu_de.length < 4) {
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
        } else if (document.getElementById("cover").files.length == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_cover = $('#preview-cover').offset().top;
                $('html,body').stop().animate({ scrollTop: top_cover - 150 }, 500, 'swing', function() {});
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var cover_data = $('#cover').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_banner_qc');
            form_data.append('file', file_data);
            form_data.append('cover', cover_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('noidung', noidung);
            form_data.append('active', active);
            form_data.append('thu_tu', thu_tu);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=edit_banner_qc]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        thu_tu = $('input[name=thu_tu]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        active = $('input[name=active]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        id = $('input[name=id]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        }else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var cover_data = $('#cover').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_banner_qc');
            form_data.append('file', file_data);
            form_data.append('cover', cover_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('noidung', noidung);
            form_data.append('active', active);
            form_data.append('thu_tu', thu_tu);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('body').on('click','.list_phanloai .li_phanloai .info_action',function(){
        $(this).parent().remove();
    });
    /////////////////////////////
    $('button[name=add_sanpham]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        kho = $('input[name=kho]').val();
        kho_hcm = $('input[name=kho_hcm]').val();
        box_noibat = $('input[name=box_noibat]:checked').val();
        cat_ma = $('input[name=cat_ma]:checked').val();
        box_banchay = $('input[name=box_banchay]:checked').val();
        box_flash = $('input[name=box_flash]:checked').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        var list_info = '';
        $('.li_info').each(function() {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        var list_phanloai = '';
        pl=0;
        $('.list_phanloai .li_phanloai').each(function() {
            ma_sp = $(this).find('input[name^=ma]').val();
            size = $(this).find('input[name^=size]').attr('giatri');
            color = $(this).find('input[name^=color]').attr('giatri');
            ma_mau = $(this).find('input[name^=color]').attr('ma_mau');
            ten_size = $(this).find('input[name^=size]').val();
            ten_color = $(this).find('input[name^=color]').val();
            can_nang = $(this).find('input[name^=can_nang]').val();
            gia_cu = $(this).find('input[name^=gia_cu]').val();
            gia_moi = $(this).find('input[name^=gia_moi]').val();
            gia_drop = $(this).find('input[name^=gia_drop]').val();
            gia_ctv = $(this).find('input[name^=gia_ctv]').val();
            drop_min = $(this).find('input[name^=drop_min]').val();
            pl++;
            if(pl==1){
                list_phanloai+= '{"ma_sp":"'+ma_sp+'","ma_mau":"'+ma_mau+'","color":"'+color+'","size":"'+size+'","ten_color":"'+ten_color+'","ten_size":"'+ten_size+'","can_nang":"'+can_nang+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia_drop":"'+gia_drop+'","gia_ctv":"'+gia_ctv+'","drop_min":"'+drop_min+'"}';
            }else{
                list_phanloai+= ',{"ma_sp":"'+ma_sp+'","ma_mau":"'+ma_mau+'","color":"'+color+'","size":"'+size+'","ten_color":"'+ten_color+'","ten_size":"'+ten_size+'","can_nang":"'+can_nang+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia_drop":"'+gia_drop+'","gia_ctv":"'+gia_ctv+'","drop_min":"'+drop_min+'"}';
            }
        });
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_noiban = [];
        $('.li_input input[name^=noiban]:checked').each(function() {
            list_noiban.push($(this).val());
        });
        list_noiban = list_noiban.toString();
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        if (tieu_de.length < 4) {
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
        } else if (list_phanloai=='') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng thêm phân loại sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (kho == '') {
            $('input[name=kho]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập đặc điểm nổi bật');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập chi tiết sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (title == '') {
            $('input[name=title]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui title sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_sanpham');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('kho', kho);
            form_data.append('kho_hcm', kho_hcm);
            form_data.append('box_noibat', box_noibat);
            form_data.append('box_banchay', box_banchay);
            form_data.append('box_flash', box_flash);
            form_data.append('anh', anh);
            form_data.append('link', link);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('info', list_info);
            form_data.append('phan_loai', list_phanloai);
            form_data.append('category', list_cat);
            form_data.append('noibat', noibat);
            form_data.append('cat_ma', cat_ma);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('noiban', list_noiban);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                if(info.noti==1){
                                    var dulieu={
                                        'hd':'user_notification',
                                    }
                                    var info_chat=JSON.stringify(dulieu);
                                    socket.emit('user_send_hoatdong',info_chat);
                                }
                                window.location.reload();
                            }
                        }, 3000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=add_nhiemvu]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        ngay = $('select[name=ngay]').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_nhiemvu');
            form_data.append('tieu_de', tieu_de);
            form_data.append('ngay', ngay);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=edit_nhiemvu]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        ngay = $('select[name=ngay]').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        id = $('input[name=id]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else {
            var form_data = new FormData();
            form_data.append('action', 'edit_nhiemvu');
            form_data.append('tieu_de', tieu_de);
            form_data.append('ngay', ngay);
            form_data.append('id', id);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
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
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('input[name=drop_min]').on('keyup', function() {
        gia_drop = $('input[name=gia_drop]').val();
        drop_min = $('input[name=drop_min]').val();
        var form_data = new FormData();
        form_data.append('action', 'tinh_gia');
        form_data.append('gia_drop', gia_drop);
        form_data.append('drop_min', drop_min);
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                $('input[name=gia_ctv]').val(info.gia_ctv);
            }

        });
    });
    $("input[name=drop_min]").bind("paste", function(e) {
        gia_drop = $('input[name=gia_drop]').val();
        drop_min = $('input[name=drop_min]').val();
        var form_data = new FormData();
        form_data.append('action', 'tinh_gia');
        form_data.append('gia_drop', gia_drop);
        form_data.append('drop_min', drop_min);
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                $('input[name=gia_ctv]').val(info.gia_ctv);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_sanpham]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        kho = $('input[name=kho]').val();
        kho_hcm = $('input[name=kho_hcm]').val();
        box_noibat = $('input[name=box_noibat]:checked').val();
        box_banchay = $('input[name=box_banchay]:checked').val();
        box_flash = $('input[name=box_flash]:checked').val();
        cat_ma = $('input[name=cat_ma]:checked').val();
        var list_photo = [];
        $('.list_photo img').each(function() {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        title = $('input[name=title]').val();
        description = $('textarea[name=description]').val();
        var list_noiban = [];
        $('.li_input input[name^=noiban]:checked').each(function() {
            list_noiban.push($(this).val());
        });
        list_noiban = list_noiban.toString();
        thuong_hieu = $('select[name=thuong_hieu]').val();
        var list_phanloai = '';
        pl=0;
        $('.list_phanloai .li_phanloai').each(function() {
            id_pl=$(this).attr('pl');
            ma_sp = $(this).find('input[name^=ma]').val();
            size = $(this).find('input[name^=size]').attr('giatri');
            color = $(this).find('input[name^=color]').attr('giatri');
            ma_mau = $(this).find('input[name^=color]').attr('ma_mau');
            ten_size = $(this).find('input[name^=size]').val();
            ten_color = $(this).find('input[name^=color]').val();
            can_nang = $(this).find('input[name^=can_nang]').val();
            gia_cu = $(this).find('input[name^=gia_cu]').val();
            gia_moi = $(this).find('input[name^=gia_moi]').val();
            gia_drop = $(this).find('input[name^=gia_drop]').val();
            gia_ctv = $(this).find('input[name^=gia_ctv]').val();
            drop_min = $(this).find('input[name^=drop_min]').val();
            pl++;
            if(pl==1){
                list_phanloai+= '{"id":"'+id_pl+'","ma_sp":"'+ma_sp+'","ma_mau":"'+ma_mau+'","color":"'+color+'","size":"'+size+'","ten_color":"'+ten_color+'","ten_size":"'+ten_size+'","can_nang":"'+can_nang+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia_drop":"'+gia_drop+'","gia_ctv":"'+gia_ctv+'","drop_min":"'+drop_min+'"}';
            }else{
                list_phanloai+= ',{"id":"'+id_pl+'","ma_sp":"'+ma_sp+'","ma_mau":"'+ma_mau+'","color":"'+color+'","size":"'+size+'","ten_color":"'+ten_color+'","ten_size":"'+ten_size+'","can_nang":"'+can_nang+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia_drop":"'+gia_drop+'","gia_ctv":"'+gia_ctv+'","drop_min":"'+drop_min+'"}';
            }
        });
        var list_info = '';
        $('.li_info').each(function() {
            info_name = $(this).find('input[name^=info_name]').val();
            info_value = $(this).find('input[name^=info_value]').val();
            if (info_name != '') {
                list_info += info_name + '&&' + info_value + '|';
            }
        });
        var list_cat = [];
        $('.li_input input[name^=category]:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        noibat = tinyMCE.get('noibat').getContent();
        noidung = tinyMCE.get('edit_textarea').getContent();
        link = $('input[name=link]').val();
        link_old = $('input[name=link_old]').val();
        id = $('input[name=id]').val();
        if (tieu_de.length < 4) {
            $('input[name=tieu_de]').focus();
        } else if (list_phanloai=='') {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng thêm phân loại sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (kho == '') {
            $('input[name=kho]').focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand('mceFocus', false, 'noibat');
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập đặc điểm nổi bật');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng nhập chi tiết sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else if (title == '') {
            $('input[name=title]').focus();
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui title sản phẩm');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
            }, 1500);
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_sanpham');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('kho', kho);
            form_data.append('kho_hcm', kho_hcm);
            form_data.append('box_noibat', box_noibat);
            form_data.append('box_banchay', box_banchay);
            form_data.append('box_flash', box_flash);
            form_data.append('anh', anh);
            form_data.append('link', link);
            form_data.append('link_old', link_old);
            form_data.append('category', list_cat);
            form_data.append('thuong_hieu', thuong_hieu);
            form_data.append('info', list_info);
            form_data.append('phan_loai', list_phanloai);
            form_data.append('noibat', noibat);
            form_data.append('cat_ma', cat_ma);
            form_data.append('noidung', noidung);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('noiban', list_noiban);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==true){
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                if(info.noti==1){
                                    var dulieu={
                                        'hd':'user_notification',
                                    }
                                    var info_chat=JSON.stringify(dulieu);
                                    socket.emit('user_send_hoatdong',info_chat);
                                }
                                //window.location.reload();
                            }
                        }, 3000);
                    }else{
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
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
    /////////////////////////////
    $('button[name=add_video]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        title = $('input[name=title]').val();
        link_video = $('input[name=link_video]').val();
        description = $('textarea[name=description]').val();
        var list_loai = [];
        $('.li_input input:checked').each(function() {
            list_loai.push($(this).val());
        });
        list_loai = list_loai.toString();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        noidung = tinyMCE.get('edit_textarea').getContent();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (title.length < 3) {
            $('input[name=title]').focus();
        } else if (description.length < 3) {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_video');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('title', title);
            form_data.append('link_video', link_video);
            form_data.append('cat', list_cat);
            form_data.append('loai', list_loai);
            form_data.append('description', description);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_video]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        title = $('input[name=title]').val();
        link_video = $('input[name=link_video]').val();
        description = $('textarea[name=description]').val();
        var list_loai = [];
        $('.li_input input:checked').each(function() {
            list_loai.push($(this).val());
        });
        list_loai = list_loai.toString();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        id = $('input[name=id]').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (title.length < 3) {
            $('input[name=title]').focus();
        } else if (description.length < 3) {
            $('textarea[name=description]').focus();
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_video');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('title', title);
            form_data.append('description', description);
            form_data.append('link_video', link_video);
            form_data.append('loai', list_loai);
            form_data.append('cat', list_cat);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==false){
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc xử lý');
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);
                    }else{
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
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    if(isJson(kq)==false){
                        setTimeout(function() {
                            $('.load_note').html('Gặp lỗi trong lúc xử lý');
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);
                    }else{
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
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=add_thongbao]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_noidang = [];
        $('.li_input input[name^=noi_dang]:checked').each(function() {
            list_noidang.push($(this).val());
        });
        list_noidang = list_noidang.toString();
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
            form_data.append('action', 'add_thongbao');
            form_data.append('file', file_data);
            form_data.append('file_popup', pop_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('pop', pop);
            form_data.append('noi_dang', list_noidang);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
    $('button[name=edit_thongbao]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_noidang = [];
        $('.li_input input[name^=noi_dang]:checked').each(function() {
            list_noidang.push($(this).val());
        });
        list_noidang = list_noidang.toString();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var pop_data = $('#popup').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_thongbao');
            form_data.append('file', file_data);
            form_data.append('file_popup', pop_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('pop', pop);
            form_data.append('noi_dang', list_noidang);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
                url: '/admincp/process.php',
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
                url: '/admincp/process.php',
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
                url: "/admincp/process.php",
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
    $('button[name=edit_quantri').on('click', function() {
        password = $('input[name=password]').val();
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        email = $('input[name=email]').val();
        address = $('input[name=address]').val();
        bo_phan = $('select[name=bo_phan]').val();
        var list_group = [];
        $('.li_input input:checked').each(function() {
            list_group.push($(this).val());
        });
        list_group = list_group.toString();
        id = $('input[name=id]').val();
        if (name.length < 2) {
            $('input[name=name]').focus();
        } else {
            var form_data = new FormData();
            form_data.append('action', 'edit_quantri');
            form_data.append('password', password);
            form_data.append('name', name);
            form_data.append('mobile', mobile);
            form_data.append('bo_phan', bo_phan);
            form_data.append('email', email);
            form_data.append('address', address);
            form_data.append('group', list_group);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
        }
    });
    /////////////////////////////
    $('button[name=add_quantri').on('click', function() {
        username = $('input[name=username]').val();
        password = $('input[name=password]').val();
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        email = $('input[name=email]').val();
        address = $('input[name=address]').val();
        bo_phan = $('select[name=bo_phan]').val();
        var list_group = [];
        $('.li_input input:checked').each(function() {
            list_group.push($(this).val());
        });
        list_group = list_group.toString();
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_quantri');
            form_data.append('username', username);
            form_data.append('password', password);
            form_data.append('name', name);
            form_data.append('mobile', mobile);
            form_data.append('email', email);
            form_data.append('address', address);
            form_data.append('group', list_group);
            form_data.append('bo_phan', bo_phan);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
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
        }
    });
    /////////////////////////////
    $('input[name=goi_y]').on('keyup', function() {
        tieu_de = $(this).val();
        cat = $('select[name=category]').val();
        if (tieu_de.length < 2) {} else {
            $.ajax({
                url: "/admincp/process.php",
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
    /////////////////////////////
    $(document).click(function() {
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
});