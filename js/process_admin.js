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
//var socket = io("https://chat.socdo.vn");
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
    // Hàm tạo box chuyển hướng
    function showRedirectBox(redirectUrl) {
        // Xóa box cũ nếu có
        $('.overlay, .redirect_box').remove();
        // Thêm overlay và box mới
        $('body').append(`
            <div class="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9998;"></div>
            <div class="redirect_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100px; height: 100px; background: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); display: flex; justify-content: center; align-items: center; z-index: 9999; overflow: hidden;">
                <div class="spinner" style="position: absolute; width: 80px; height: 80px; border: 4px solid rgba(52, 152, 219, 0.3); border-top: 4px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <div class="countdown" id="countdown" style="font-size: 28px; font-weight: bold; color: #2c3e50; z-index: 1;">3</div>
            </div>
            <style>
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        `);
        var seconds = 3;
        var countdown = setInterval(function() {
            seconds--;
            $('#countdown').text(seconds);
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = redirectUrl;
            }
        }, 1000);
    }

    // Xử lý form login
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        
        let username = $('input[name="username"]').val();
        let password = $('input[name="password"]').val();
        let remember = $('input[name="remember"]').is(':checked') ? 'on' : 'off';
        
        if (username.length < 4 || password.length < 6) {
            $('#message').html('<div class="error-message">Tài khoản hoặc mật khẩu không hợp lệ</div>').show();
            return false;
        }
        
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        
        $.ajax({
            url: '/admin/process_login.php',
            type: 'POST',
            data: {
                username: username,
                password: password,
                remember: remember
            },
            dataType: 'json',
            success: function(data) {
                $('.load_process').hide();
                $('.load_overlay').hide();
                if (data.ok == 1) {
                    showRedirectBox(data.redirect);
                } else {
                    $('#message').html('<div class="error-message">' + data.thongbao + '</div>').show();
                }
            },
            error: function(xhr, status, error) {
                $('.load_process').hide();
                $('.load_overlay').hide();
                $('#message').html('<div class="error-message">Lỗi kết nối đến server: ' + error + '</div>').show();
            }
        });
    });

    // Xử lý logout
    $('#logout-btn').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/admin/logout.php',
            type: 'GET', // Hoặc POST nếu cần
            dataType: 'json',
            success: function(data) {
                if (data.ok == 1) {
                    showRedirectBox(data.redirect);
                }
            },
            error: function(xhr, status, error) {
                alert('Lỗi khi đăng xuất: ' + error);
            }
        });
    });
    
    $('.remember').on('click', function(e) {
        e.preventDefault();
        let $checkbox = $(this).find('input[type="checkbox"]');
        $checkbox.prop('checked', !$checkbox.is(':checked'));
        $(this).find('i').toggleClass('fa-check-circle-o fa-circle-o');
    });
});