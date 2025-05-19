//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function scrollSmoothToBottom(id) {
    var div = document.getElementById(id);
    $("#" + id).animate(
        {
            scrollTop: div.scrollHeight - div.clientHeight,
        },
        200
    );
}
//var socket =io("http://localhost:3000");
var socket = io("https://chat.socdo.vn");
function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + days2expire * 24 * 60 * 60 * 1000);
    var expires = date.toUTCString();
    document.cookie =
        name +
        "=" +
        value +
        ";" +
        "expires=" +
        expires +
        ";" +
        "path=" +
        path +
        ";";
}
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#" + id).attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function readURLPreViewMinhHoa(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
                if (img.width === 600 && img.height === 600) {
                    $("#" + id).attr("src", e.target.result);
                } else {
                    alert("Nhập kích thước ảnh phù hợp nhất.");
                    $("#" + id).attr("src", "");
                }
            };
            img.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
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
    var div = $(".list_result .domain").not(".loaded").first();
    domain = div.attr("domain");
    $.ajax({
        url: "/ncc/process.php",
        type: "post",
        data: {
            action: "check_domain",
            domain: domain,
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            div.parent().find(".btn-domain").html(info.button);
            div.addClass("loaded");
            if ($(".list_result .domain").not(".loaded").length > 0) {
                check_domain();
            } else {
            }
        },
    });
}
function check_post(id) {
    $.ajax({
        url: "/ncc/process.php",
        type: "post",
        data: {
            action: "check_post",
            id: id,
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            if (info.ok == 1) {
                window.location.href = "/ncc/add-sanpham?step=2&id=" + id;
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(info.thongbao);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 2000);
            }
        },
    });
}
function check_link(loai) {
    link = $(".link_seo").val();
    if (link.length < 2) {
        $(".check_link").removeClass("ok");
        $(".check_link").addClass("error");
        $(".check_link").html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link,
                loai: loai,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".link_seo").val(info.link);
                if (info.ok == 1) {
                    $(".check_link").removeClass("error");
                    $(".check_link").addClass("ok");
                    $(".check_link").html(
                        '<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ'
                    );
                } else {
                    if ($("#link_old").length > 0) {
                        link_old = $("#link_old").val();
                        if (link_old == info.link) {
                            $(".check_link").removeClass("error");
                            $(".check_link").addClass("ok");
                            $(".check_link").html(
                                '<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ'
                            );
                        }
                    } else {
                        $(".check_link").removeClass("ok");
                        $(".check_link").addClass("error");
                        $(".check_link").html(
                            '<i class="fa fa-ban"></i> Đường dẫn đã tồn tại'
                        );
                    }
                }
            },
        });
    }
}

function check_blank(loai) {
    link = $(".tieude_seo").val();
    if (link.length < 2) {
        $(".check_link").removeClass("ok");
        $(".check_link").addClass("error");
        $(".check_link").html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link,
                loai: loai,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".link_seo").val(info.link);
                if (info.ok == 1) {
                    $(".check_link").removeClass("error");
                    $(".check_link").addClass("ok");
                    $(".check_link").html(
                        '<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ'
                    );
                } else {
                    if ($("#link_old").length > 0) {
                        link_old = $("#link_old").val();
                        if (link_old == info.link) {
                            $(".check_link").removeClass("error");
                            $(".check_link").addClass("ok");
                            $(".check_link").html(
                                '<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ'
                            );
                        }
                    } else {
                        $(".check_link").removeClass("ok");
                        $(".check_link").addClass("error");
                        $(".check_link").html(
                            '<i class="fa fa-ban"></i> Đường dẫn đã tồn tại'
                        );
                    }
                }
            },
        });
    }
}

function tuchoi(id) {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
        url: "/ncc/process.php",
        type: "post",
        data: {
            action: "tuchoi",
            id: id,
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {
                }
            }, 2000);
        },
    });
}

function confirm_success(id) {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
        url: "/ncc/process.php",
        type: "post",
        data: {
            action: "confirm_success",
            id: id,
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {
                }
            }, 2000);
        },
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
    xhr.open("GET", url);
    xhr.responseType = "blob";
    xhr.send();
}
function loadURLToInputField(url, id_input) {
    getImgURL(url, (imgBlob) => {
        // Load img blob to input
        fileName = filename(url); // should .replace(/[/\\?%*:|"<>]/g, '-') for remove special char like / \
        if (fileName.indexOf(".jpg") > -1) {
            file = new File(
                [imgBlob],
                fileName,
                { type: "image/jpeg", lastModified: new Date().getTime() },
                "utf-8"
            );
        } else if (fileName.indexOf(".jpeg") > -1) {
            file = new File(
                [imgBlob],
                fileName,
                { type: "image/jpeg", lastModified: new Date().getTime() },
                "utf-8"
            );
        } else if (fileName.indexOf(".png") > -1) {
            file = new File(
                [imgBlob],
                fileName,
                { type: "image/png", lastModified: new Date().getTime() },
                "utf-8"
            );
        } else {
            file = new File(
                [imgBlob],
                fileName,
                { type: "image/jpeg", lastModified: new Date().getTime() },
                "utf-8"
            );
        }
        container = new DataTransfer();
        container.items.add(file);
        document.querySelector(id_input).files = container.files;
    });
}
function copy_text(element) {
    $("#" + element).select();
    text = $("#" + element).val();
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
}
function copy_text_share(element, rut_gon, mobile) {
    if (rut_gon == 1) {
        link_rutgon = "\nXem chi tiết: " + $("input[name=rut_gon]").val();
    } else {
        link_rutgon = "";
    }
    if (mobile == 1) {
        dien_thoai = "\nLiên hệ ngay: " + $("input[name=mobile_share]").val();
    } else {
        dien_thoai = "";
    }
    $("#" + element).select();
    text = $("#" + element).val();
    text = text + "" + link_rutgon + "" + dien_thoai;
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
}
function confirm_del(action, loai, title, id) {
    $("#title_confirm").html(title);
    $("#button_thuchien").attr("action", action);
    $("#button_thuchien").attr("post_id", id);
    $("#button_thuchien").attr("loai", loai);
    $("#box_pop_confirm").show();
}

function confirm_action(action, title, id) {
    $("#box_pop_confirm_action .title_confirm").html(title);
    $("#button_thuchien_action").attr("action", action);
    $("#button_ok").attr("class", action);
    $("#button_thuchien_action").attr("post_id", id);
    $("#box_pop_confirm_action").show();
}

function confirm_action_domain(action, title, id) {
    $("#box_pop_confirm_action_domain .title_confirm").html(title);
    $("#box_pop_confirm_action_domain .title_confirm").html(title);
    $("#button_thuchien_action_domain").attr("action", action);
    $("#button_ok_domain").attr("class", action);
    $("#button_thuchien_action_domain").attr("post_id", id);
    $("#box_pop_confirm_action_domain").show();
}

function del(loai, id) {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
        url: "/ncc/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
            id: id,
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                if (info.ok == 1) {
                    $("#tr_" + id).remove();
                    // nhatthem114
                    $("#address_" + id).remove();
                    $("#bank_" + id).remove();
                } else {
                }
            }, 2000);
        },
    });
}

function huy(id) {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
        url: "/ncc/process.php",
        type: "post",
        data: {
            action: "huy",
            id: id,
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {
                }
            }, 2000);
        },
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
                value =
                    parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(
            /(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g
        ).map(function ($0, $1) {
            var name = $0,
                value =
                    $1.charAt(0) === '"' ? $1.substr(1, -1).replace(/\\(.)/g, "$1") : $1;
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
    return p[0]
        .split("")
        .reverse()
        .reduce(function (acc, num, i, orig) {
            return num + (num != "-" && i && !(i % 3) ? "," : "") + acc;
        }, "");
}
function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split("?");
    if (urlparts.length >= 2) {
        var prefix = encodeURIComponent(parameter) + "=";
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? "?" + pars.join("&") : "");
    }
    return url;
}
// nhatthem94
// Show Add Address Modal
// function showAddAddressModal() {
//     $('#modalTitle').text('Thêm địa chỉ mới');
//     $('#address_id').val('');
//     $('#addressForm')[0].reset();
//     $('#load_xa').html('<option value="">Chọn quận / huyện</option>');
//     $('select[name="xa"]').html('<option value="">Chọn xã / phường</option>');
//     $('#addressModal').modal('show');
// }

// // Show Edit Address Modal
// function showEditAddressModal(id) {
//     $.ajax({
//         url: '/ncc/process.php',
//         type: 'POST',
//         data: {
//             action: 'get_address',
//             id: id
//         },
//         success: function(response) {
//             var data = JSON.parse(response);
//             if (data.status === 'success') {
//                 $('#address_id').val(data.data.id);
//                 $('#fullname').val(data.data.fullname);
//                 $('#mobile').val(data.data.mobile);

//                 $('#load_huyen').val(data.data.province);

//                 // Load quận/huyện
//                 $.ajax({
//                     url: '/ncc/process.php',
//                     type: 'POST',
//                     data: {
//                         action: 'get_huyen',
//                         tinh: data.data.province
//                     },
//                     success: function(html) {
//                         $('#load_xa').html(html);
//                         $('#load_xa').val(data.data.district);

//                         // Load xã/phường
//                         $.ajax({
//                             url: '/ncc/process.php',
//                             type: 'POST',
//                             data: {
//                                 action: 'get_xa',
//                                 huyen: data.data.district
//                             },
//                             success: function(html) {
//                                 $('select[name="xa"]').html(html);
//                                 $('select[name="xa"]').val(data.data.ward);
//                             }
//                         });
//                     }
//                 });

//                 $('#address_detail').val(decodeURIComponent(data.data.address_detail));
//                 $('#is_default').prop('checked', data.data.is_default == 1);
//                 $('#is_pickup').prop('checked', data.data.is_pickup == 1);
//                 $('#is_return').prop('checked', data.data.is_return == 1);

//                 $('#modalTitle').text('Sửa địa chỉ');
//                 $('#addressModal').modal('show');
//             } else {
//                 $('.load_note').html('Không thể tải thông tin địa chỉ');
//             }
//         },
//         error: function() {
//             $('.load_note').html('Có lỗi xảy ra khi tải thông tin địa chỉ');
//         }
//     });
// }

// function saveAddress() {
//     // Lấy dữ liệu từ form
//     var fullname = $('#fullname').val();
//     var mobile = $('#mobile').val();
//     var tinh = $('#load_huyen').val();
//     var huyen = $('#load_xa').val();
//     var xa = $('select[name="xa"]').val();
//     var address_detail = $('#address_detail').val();

//     // Kiểm tra các trường bắt buộc
//     if (fullname.length < 1) {
//         $('#fullname').focus();
//         return;
//     }
//     if (mobile.length < 1) {
//         $('#mobile').focus();
//         return;
//     }
//     if (!tinh) {
//         $('#load_huyen').focus();
//         return;
//     }
//     if (!huyen) {
//         $('#load_xa').focus();
//         return;
//     }
//     if (!xa) {
//         $('select[name="xa"]').focus();
//         return;
//     }
//     if (address_detail.length < 1) {
//         $('#address_detail').focus();
//         return;
//     }

//     // Hiển thị overlay và trạng thái xử lý
//     $('.load_overlay').show();
//     $('.load_process').fadeIn();
//     $('.load_note').html('Đang xử lý...');

//     var formData = new FormData($('#addressForm')[0]);
//     formData.append('action', 'save_address');
//     console.log([...formData]);

//     $.ajax({
//         url: '/ncc/process.php',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//             console.log(response);
//             try {

//                 var info = JSON.parse(response);
//                 setTimeout(function() {
//                     $('.load_note').html(info.thongbao); // Hiển thị thông báo từ server
//                 }, 1000);
//                 setTimeout(function() {
//                     $('.load_process').hide();
//                     $('.load_note').html('Hệ thống đang xử lý');
//                     $('.load_overlay').hide();
//                     if (info.ok == 1) {
//                         $('#addressModal').modal('hide'); // Đóng modal
//                         window.location.reload(); // Tải lại trang nếu thành công
//                     }
//                 }, 3000);
//             } catch (e) {
//                 setTimeout(function() {
//                     $('.load_note').html('Định dạng phản hồi không hợp lệ');
//                 }, 1000);
//                 setTimeout(function() {
//                     $('.load_process').hide();
//                     $('.load_note').html('Hệ thống đang xử lý');
//                     $('.load_overlay').hide();
//                 }, 3000);
//             }
//         },
//         error: function() {
//             setTimeout(function() {
//                 $('.load_note').html('Có lỗi xảy ra khi lưu địa chỉ');
//             }, 1000);
//             setTimeout(function() {
//                 $('.load_process').hide();
//                 $('.load_note').html('Hệ thống đang xử lý');
//                 $('.load_overlay').hide();
//             }, 3000);
//         }
//     });
// }
// // Update Address List without reloading
// function updateAddressList() {
//     $.ajax({
//         url: '/ncc/action/transport.php', // Gọi lại file để lấy danh sách mới
//         type: 'GET',
//         success: function(response) {
//             var parser = new DOMParser();
//             var doc = parser.parseFromString(response, 'text/html');
//             var newAddressList = $(doc).find('#address_list').html();
//             $('#address_list').html(newAddressList);
//         },
//         error: function() {
//             alert('Lỗi khi cập nhật danh sách địa chỉ');
//         }
//     });
// }

$(document).ready(function () {
    if (get_cookie("show_huongdan")) {
        /*        setTimeout(function(){
                        $.ajax({
                            url: "/ncc/process.php",
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
    $("body").on("change", ".list_shopcart select[name^=size]", function () {
        var row = $(this);
        sp_id = $(this).attr("sp_id");
        size = $(this).val();
        gia = $(this).find(":selected").attr("gia");
        gia = parseFloat(gia);
        so_luong = $(this).parent().parent().find("input[name=quantity]").val();
        so_luong = parseFloat(so_luong);
        thanhtien = gia * so_luong;
        $(this)
            .parent()
            .parent()
            .find(".price")
            .html('<span class="text_price">Giá: </span>' + format_price(gia) + "₫");
        $(this)
            .parent()
            .parent()
            .find(".thanhtien")
            .html(
                '<span class="text_price">Giá: </span>' + format_price(thanhtien) + "₫"
            );
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_color",
                sp_id: sp_id,
                size: size,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    row.parent().parent().find("select[name^=color]").html(info.list);
                    pl = row
                        .parent()
                        .parent()
                        .find("select[name^=color] option:selected")
                        .attr("pl");
                    color = row
                        .parent()
                        .parent()
                        .find("select[name^=color] option:selected")
                        .val();
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "update_pl",
                            sp_id: sp_id,
                            size: size,
                            color: color,
                            pl: pl,
                        },
                        success: function (kq) { },
                    });
                } else {
                }
            },
        });
    });
    ////////////
    $("body").on("change", ".list_shopcart select[name^=color]", function () {
        sp_id = $(this).attr("sp_id");
        color = $(this)
            .parent()
            .parent()
            .find("select[name^=color] option:selected")
            .val();
        pl = $(this)
            .parent()
            .parent()
            .find("select[name^=color] option:selected")
            .attr("pl");
        size = $(this)
            .parent()
            .parent()
            .find("select[name^=size] option:selected")
            .val();
        $.ajax({
            url: "/ncc/process.php",
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
            },
        });
    });
    ////////////
    $("body").on("click", ".box_kichhoat .close", function () {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "close_kh",
            },
            success: function (kq) {
                $(".box_kichhoat").hide();
            },
        });
    });
    ////////////
    $("body").on("click", ".box_kichhoat #de_sau", function () {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "close_kh",
            },
            success: function (kq) {
                $(".box_kichhoat").hide();
            },
        });
    });
    ////////////
    $("body").on("click", ".box_kichhoat #nap_ngay", function () {
        $(".list_action").hide();
        $(".box_sotien").show();
    });
    /////////////////////////////
    $("body").on("click", "button#add_naptien_step2", function () {
        var id = $(this).attr("id_nap");
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "add_naptien_step2",
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        $(".box_time").html(info.html);
                        var dulieu = {
                            hd: "add_naptien",
                            id: id,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit("user_send_hoatdong", info_chat);
                    } else {
                    }
                }, 3000);
            },
        });
    });
    ////////////
    $("body").on("click", ".box_huongdan .button_next button", function (e) {
        step = $(this).attr("step");
        if ($(".add_donhang_drop_mobile").length > 0) {
            if (step == "box_welcome") {
                $(".box_pop_add").hide();
                $(".box_pop_add").html("");
                $("html,body")
                    .stop()
                    .animate({ scrollTop: 150 }, 500, "swing", function () { });
                first_buynow = $(".list_sanpham .buy_now").first();
                $(".load_overlay").show();
                $(".box_right_content .box_profile .box_timkiem").css({
                    "z-index": "99999",
                });
                $(".box_right_content .box_profile .box_timkiem .box_huongdan").css({
                    display: "block",
                    top: "-105px",
                });
            } else if (step == "box_timkiem") {
                $(".box_right_content .box_profile .box_timkiem").css({
                    "z-index": "999",
                });
                $(".box_right_content .box_profile .box_timkiem .box_huongdan").css({
                    display: "none",
                });
                $(".box_sms_bottom").css({ "z-index": "99999" });
                $(".box_sms_bottom .box_huongdan").css({ display: "block" });
            } else if (step == "box_hotro") {
                $(".box_sms_bottom").css({ "z-index": "999" });
                $(".box_sms_bottom .box_huongdan").css({ display: "none" });

                $(".add_cart_fixed").css({ "z-index": "99999" });
                $(".add_cart_fixed .box_huongdan").css({ display: "block" });
            } else if (step == "box_add_cart") {
                $(".add_cart_fixed").css({ "z-index": "999" });
                $(".add_cart_fixed .box_huongdan").css({ display: "none" });
                var top_download = $(".list_sanpham .buy_now").first().offset().top;
                $("html,body")
                    .stop()
                    .animate(
                        { scrollTop: top_download - 150 },
                        500,
                        "swing",
                        function () { }
                    );
                first_buynow = $(".list_sanpham .buy_now").first();
                first_buynow.prepend(
                    '<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để tạo ngay đơn hàng mới</div><div class="button_next"><button step="box_add_cart_new">Tiếp theo</button></div></div>'
                );
                first_buynow.css({ "z-index": "99999", position: "relative" });
                first_buynow.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "155px",
                    left: "unset",
                    right: "170px",
                    top: "0",
                    bottom: "0",
                    height: "115px",
                    "font-size": "initial",
                });
                first_buynow
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == "box_add_cart_new") {
                first_buynow = $(".list_sanpham .buy_now").first();
                first_buynow.css({ "z-index": "999" });
                first_buynow.find(".box_huongdan").remove();
                first_add_to_cart = $(".list_sanpham .add_to_cart").first();
                first_add_to_cart.prepend(
                    '<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào giỏ hàng</div><div class="button_next"><button step="box_to_cart">Tiếp theo</button></div></div>'
                );
                first_add_to_cart.css({ "z-index": "99999", position: "relative" });
                first_add_to_cart.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "155px",
                    left: "unset",
                    right: "170px",
                    top: "0",
                    bottom: "0",
                    height: "135px",
                    "font-size": "initial",
                });
                first_add_to_cart
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == "box_to_cart") {
                first_add_to_cart = $(".list_sanpham .add_to_cart").first();
                first_add_to_cart.css({ "z-index": "999" });
                first_add_to_cart.find(".box_huongdan").remove();
                first_share_facebook = $(".list_sanpham .share_facebook").first();
                first_share_facebook.prepend(
                    '<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để đăng bán sản phẩm trên mạng xã hội: facebook, zalo...</div><div class="button_next"><button step="box_share_facebook">Tiếp theo</button></div></div>'
                );
                first_share_facebook.css({
                    "z-index": "99999",
                    position: "relative",
                    overflow: "unset",
                });
                first_share_facebook.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "155px",
                    left: "unset",
                    right: "170px",
                    top: "0",
                    bottom: "0",
                    height: "160px",
                    "font-size": "initial",
                });
                first_share_facebook
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == "box_share_facebook") {
                first_share_facebook = $(".list_sanpham .share_facebook").first();
                first_share_facebook.css({ "z-index": "999" });
                first_share_facebook.find(".box_huongdan").remove();
                first_add_follow = $(".list_sanpham .add_follow").first();
                first_add_follow.prepend(
                    '<div class="box_huongdan"><div class="muiten muiten_right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào danh sách theo dõi...</div><div class="button_next"><button step="box_add_follow">Đã hiểu</button></div></div>'
                );
                first_add_follow.css({
                    "z-index": "99999",
                    position: "relative",
                    overflow: "unset",
                });
                first_add_follow.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "155px",
                    left: "unset",
                    right: "170px",
                    top: "0",
                    bottom: "0",
                    height: "132px",
                    "font-size": "initial",
                });
                first_add_follow
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                return false;
                e.stopPropagation();
            } else if (step == "box_add_follow") {
                first_add_follow = $(".list_sanpham .add_follow").first();
                first_add_follow.css({ "z-index": "999" });
                first_add_follow.find(".box_huongdan").remove();
                $(".load_overlay").hide();
                setCookie("show_huongdan", "ok", 3600);
            } else if (step == "box_ketthuc") {
                box_left = $(".page_body .box_left");
                box_left.css({ "z-index": "999" });
                box_left.find(".box_huongdan").remove();
                $(".load_overlay").hide();
                setCookie("show_huongdan", "ok", 3600);
            }
        } else {
            if (step == "box_welcome") {
                $(".box_pop_add").hide();
                $(".box_pop_add").html("");
                $(".load_overlay").show();
                $(".box_right_content .box_profile .box_timkiem").css({
                    "z-index": "99999",
                });
                $(".box_right_content .box_profile .box_timkiem .box_huongdan").css({
                    display: "block",
                    top: "-105px",
                });
            } else if (step == "box_timkiem") {
                $(".box_right_content .box_profile .box_timkiem").css({
                    "z-index": "999",
                });
                $(".box_right_content .box_profile .box_timkiem .box_huongdan").css({
                    display: "none",
                });
                $(".box_sms_bottom").css({ "z-index": "99999" });
                $(".box_sms_bottom .box_huongdan").css({ display: "block" });
            } else if (step == "box_hotro") {
                $(".box_sms_bottom").css({ "z-index": "999" });
                $(".box_sms_bottom .box_huongdan").css({ display: "none" });

                $(".add_cart_fixed").css({ "z-index": "99999" });
                $(".add_cart_fixed .box_huongdan").css({ display: "block" });
            } else if (step == "box_add_cart") {
                $(".add_cart_fixed").css({ "z-index": "999" });
                $(".add_cart_fixed .box_huongdan").css({ display: "none" });
                first_buynow = $(".list_baiviet .buy_now").first();
                first_buynow.prepend(
                    '<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để tạo ngay đơn hàng mới</div><div class="button_next"><button step="box_add_cart_new">Tiếp theo</button></div></div>'
                );
                first_buynow.css({ "z-index": "99999", position: "relative" });
                first_buynow.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "245px",
                    left: "unset",
                    right: "209px",
                    top: "0",
                    bottom: "0",
                    height: "90px",
                });
                first_buynow
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == "box_add_cart_new") {
                first_buynow = $(".list_baiviet .buy_now").first();
                first_buynow.css({ "z-index": "999" });
                first_buynow.find(".box_huongdan").remove();
                first_add_to_cart = $(".list_baiviet .add_to_cart").first();
                first_add_to_cart.prepend(
                    '<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào giỏ hàng</div><div class="button_next"><button step="box_to_cart">Tiếp theo</button></div></div>'
                );
                first_add_to_cart.css({ "z-index": "99999", position: "relative" });
                first_add_to_cart.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "255px",
                    left: "unset",
                    right: "209px",
                    top: "0",
                    bottom: "0",
                    height: "90px",
                });
                first_add_to_cart
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == "box_to_cart") {
                first_add_to_cart = $(".list_baiviet .add_to_cart").first();
                first_add_to_cart.css({ "z-index": "999" });
                first_add_to_cart.find(".box_huongdan").remove();
                first_share_facebook = $(".list_baiviet .share_facebook").first();
                first_share_facebook.prepend(
                    '<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để đăng bán sản phẩm trên mạng xã hội: facebook, zalo...</div><div class="button_next"><button step="box_share_facebook">Tiếp theo</button></div></div>'
                );
                first_share_facebook.css({
                    "z-index": "99999",
                    position: "relative",
                    overflow: "unset",
                });
                first_share_facebook.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "265px",
                    left: "unset",
                    right: "209px",
                    top: "0",
                    bottom: "0",
                    height: "115px",
                    "font-size": "initial",
                });
                first_share_facebook
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                e.stopPropagation();
            } else if (step == "box_share_facebook") {
                first_share_facebook = $(".list_baiviet .share_facebook").first();
                first_share_facebook.css({ "z-index": "999" });
                first_share_facebook.find(".box_huongdan").remove();
                first_add_follow = $(".list_baiviet .add_follow").first();
                first_add_follow.prepend(
                    '<div class="box_huongdan"><div class="muiten right"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Bấm để thêm sản phẩm vào danh sách theo dõi...</div><div class="button_next"><button step="box_add_follow">Tiếp theo</button></div></div>'
                );
                first_add_follow.css({
                    "z-index": "99999",
                    position: "relative",
                    overflow: "unset",
                });
                first_add_follow.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "250px",
                    left: "unset",
                    right: "209px",
                    top: "0",
                    bottom: "0",
                    height: "115px",
                    "font-size": "initial",
                });
                first_add_follow
                    .find(".box_huongdan .muiten i")
                    .css({ "font-size": "35px" });
                return false;
                e.stopPropagation();
            } else if (step == "box_add_follow") {
                first_add_follow = $(".list_baiviet .add_follow").first();
                first_add_follow.css({ "z-index": "999" });
                first_add_follow.find(".box_huongdan").remove();

                box_left = $(".page_body .box_left");
                box_left.prepend(
                    '<div class="box_huongdan"><div class="muiten left"><i class="fa fa-caret-up"></i></div><div class="noidung_huongdan">Khu vực chức năng quản lý, thống kê, thêm mới, nạp tiền, rút tiền...</div><div class="button_next"><button step="box_ketthuc">Đã hiểu</button></div></div>'
                );
                box_left.css({ "z-index": "99999", overflow: "unset" });
                box_left.find(".box_huongdan").css({
                    display: "block",
                    color: "#414141",
                    width: "275px",
                    right: "unset",
                    left: "280px",
                    top: "0",
                    bottom: "0",
                    height: "115px",
                    "font-size": "initial",
                });
                box_left.find(".box_huongdan .muiten i").css({ "font-size": "35px" });
                return false;
                e.stopPropagation();
            } else if (step == "box_ketthuc") {
                box_left = $(".page_body .box_left");
                box_left.css({ "z-index": "999" });
                box_left.find(".box_huongdan").remove();
                $(".load_overlay").hide();
                setCookie("show_huongdan", "ok", 3600);
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "load_pop_add",
                        loai: "show_vongquay",
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        if (info.ok == 1) {
                            $(".box_pop_add").html(info.html);
                            $(".box_pop_add").show();
                        } else {
                        }
                    },
                });
            }
        }
    });
    setTimeout(function () {
        $(".marquee marquee").mouseout();
    }, 500);
    $("#sort_product").on("change", function () {
        var queryParams = new URLSearchParams(window.location.search);
        var sort = $(this).val();
        queryParams.set("sort", sort);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        url = removeURLParameter(url, "page");
        queryParams.set("page", 1);
        window.location.href = url;
    });
    $("#timkiem_category").on("change", function () {
        var queryParams = new URLSearchParams(window.location.search);
        var cat = $(this).val();
        queryParams.set("cat", cat);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        url = removeURLParameter(url, "page");
        queryParams.set("page", 1);
        window.location.href = url;
    });
    $("#timkiem_thuonghieu").on("change", function () {
        var queryParams = new URLSearchParams(window.location.search);
        var brand = $(this).val();
        queryParams.set("brand", brand);
        history.replaceState(null, null, "?" + queryParams.toString());
        url = window.location.href;
        url = removeURLParameter(url, "page");
        queryParams.set("page", 1);
        window.location.href = url;
    });
    $("#sort_link_affiliate").on("change", function () {
        sort = $(this).val();
        window.location.href = "/ncc/add-donhang-drop?sort=" + sort;
    });
    if ($("#chon_kho").length > 0) {
        if (get_cookie("drop_kho")) {
            $("#chon_kho").val(get_cookie("drop_kho"));
        } else {
        }
    }
    if ($("#list_chat").length > 0) {
        setTimeout(function () {
            scrollSmoothToBottom("list_chat");
        }, 500);
    }
    ///////////////////////////
    $("body").on("keyup", ".input_nap", function () {
        sotien = $(this).val();
        if (sotien.length < 4) {
        } else {
            sotien = sotien.replace(/,/g, "");
            sotien = parseFloat(sotien, 2);
            $(this).val(format_price(sotien));
        }
    });
    ///////////////////////////
    link_hientai = window.location.pathname;
    a_menu = $(".main_menu").find('a[href="' + link_hientai + '"]');
    loai_a = a_menu.parent().attr("class");
    total_height = 0;
    var vitri = 0;
    $(".box_menu_left .main_menu a").each(function () {
        total_height += $(this).outerHeight();
        link_a = $(this).attr("href");
        if (link_a == link_hientai) {
            vitri = total_height - 90;
        }
    });
    $(".box_menu_left").animate({ scrollTop: vitri }, 1000);
    if (loai_a == "li_menu_sub_sub") {
        a_menu.parent().parent().addClass("active");
        a_menu
            .parent()
            .parent()
            .parent()
            .find(".a_sub .right")
            .html('<i class="fa fa-minus-square-o"></i>');
        a_menu.parent().parent().parent().parent().addClass("active");
        a_menu
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".a_main .right")
            .html('<i class="fa fa-minus-square-o"></i>');
    } else if (loai_a == "li_menu_sub") {
        a_menu.parent().parent().addClass("active");
        a_menu
            .parent()
            .parent()
            .parent()
            .find(".a_main .right")
            .html('<i class="fa fa-minus-square-o"></i>');
    }
    ///////////////////////////
    $("body").on("click", ".add_follow", function () {
        var $btn = $(this);
        var sp_id = $btn.attr("sp_id");
        var isAdd = $btn.find(".fa-square-o").length > 0;
        var loai = isAdd ? "add" : "remove";

        // Xác định thông báo và CSS cho thông báo dựa trên hành động
        var message, thongBaoCSS;
        if (loai === "add") {
            message = 'Đã thêm Yêu thích <i class="fa fa-check"></i>';
            thongBaoCSS = {
                "background-color": "#28a745", // màu nền xanh cho thêm yêu thích
                border: "1px solid #28a745",
            };
        } else {
            message = 'Đã bỏ yêu thích <i class="fa fa-times"></i>';
            thongBaoCSS = {
                "background-color": "#dc3545", // màu nền đỏ cho bỏ yêu thích
                border: "1px solid #dc3545",
            };
        }

        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            dataType: "json",
            data: {
                action: "update_follow",
                sp_id: sp_id,
                loai: loai,
            },
            success: function (response) {
                // Cập nhật số lượng sản phẩm follow
                $(".total_quantam").text(response.total_follow);
                // Cập nhật thông báo với message và áp dụng CSS mới
                $(".thongbao_add_follow")
                    .html(message)
                    .css(thongBaoCSS)
                    .addClass("show");

                setTimeout(function () {
                    $(".thongbao_add_follow").removeClass("show");
                }, 2000);
            },
        });
    });

    ///////////////////////////
    $("body").on(
        "click",
        ".menu_top .menu_top_right .notification .tab_notification .li_tab",
        function () {
            $(".tab_notification .li_tab").removeClass("active");
            $(this).addClass("active");
            tab = $(".tab_notification .li_tab.active").attr("id");
            if (tab == "tab_all") {
                loai = "all";
            } else {
                loai = "chuadoc";
            }
            $(".list_notification .list_noti").html(
                '<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
            );
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_notification",
                    loai: loai,
                    page: 1,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".list_notification .list_noti .loading_notification").remove();
                        $(".list_notification .list_noti").append(info.list);
                        $(".list_notification .list_noti").attr("page", info.page);
                        $(".list_notification .list_noti").attr("tiep", info.tiep);
                        $(".list_notification .list_noti").attr("loaded", 1);
                    }, 1000);
                },
            });
        }
    );
    ///////////////////////////
    $("body").on(
        "click",
        ".menu_top .menu_top_right .notification .icon_notification",
        function () {
            $(".list_notification").toggleClass("active");
            tab = $(".tab_notification .li_tab.active").attr("id");
            if (tab == "tab_all") {
                loai = "all";
            } else {
                loai = "chuadoc";
            }
            if ($(".list_notification").hasClass("active")) {
                $(".list_notification .list_noti").html(
                    '<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "load_notification",
                        loai: loai,
                        page: 1,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $(".list_notification .list_noti .loading_notification").remove();
                            $(".list_notification .list_noti").append(info.list);
                            $(".list_notification .list_noti").attr("page", info.page);
                            $(".list_notification .list_noti").attr("tiep", info.tiep);
                            $(".list_notification .list_noti").attr("loaded", 1);
                        }, 1000);
                    },
                });
            } else {
            }
        }
    );
    ////////////////////////
    $(".list_notification .list_noti").on("scroll", function () {
        tab = $(".tab_notification .li_tab.active").attr("id");
        if (tab == "tab_all") {
            loai = "all";
        } else {
            loai = "chuadoc";
        }
        div_notification = $(".list_notification .list_noti");
        if (
            div_notification.scrollTop() + div_notification.innerHeight() >=
            div_notification[0].scrollHeight - 10
        ) {
            tiep = $(".list_notification .list_noti").attr("tiep");
            page = $(".list_notification .list_noti").attr("page");
            loaded = $(".list_notification .list_noti").attr("loaded");
            if (loaded == 1 && tiep == 1) {
                $(".list_notification .list_noti").prepend(
                    '<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                $(".list_notification .list_noti").attr("loaded", 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "load_notification",
                            loai: "all",
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $(".list_notification .list_noti .loading_notification").remove();
                            $(".list_notification .list_noti").append(info.list);
                            $(".list_notification .list_noti").attr("page", info.page);
                            $(".list_notification .list_noti").attr("tiep", info.tiep);
                            $(".list_notification .list_noti").attr("loaded", 1);
                        },
                    });
                }, 1000);
            }
        }
    });
    ////////////////////////
    // Xử lý nút "Kích hoạt" (sử dụng số dư)
    $("body")
        .off("click", "#sudung_sodu")
        .on("click", "#sudung_sodu", function () {
            console.log("Nút Kích hoạt được bấm");

            // Hiển thị popup xác nhận
            $(".box_confirm").css({
                display: "flex",
                "background-color": "rgba(0, 0, 0, 0.5)",
                "z-index": "10000",
                position: "fixed",
                top: "0",
                left: "0",
                width: "100%",
                height: "100%",
                "justify-content": "center",
                "align-items": "center",
            });

            // Xử lý nút "Thực hiện"
            $("#confirm_yes")
                .off("click")
                .on("click", function () {
                    console.log("Nút Thực hiện được bấm");
                    $(".box_confirm").hide();
                    $(".box_xuly").html(
                        '<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...'
                    );

                    // Gọi API kích hoạt
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "sudung_sodu",
                        },
                        success: function (response) {
                            console.log("Phản hồi từ server:", response);
                            try {
                                const info = JSON.parse(response);
                                setTimeout(function () {
                                    switch (info.ok) {
                                        case 1: // Thành công
                                            $(".box_xuly").html(info.thongbao);
                                            // Chỉ thêm nếu #status_button tồn tại
                                            if ($("#status_button").length) {
                                                $("#status_button").html(
                                                    '<button style="color: #ffffff; display: block; margin-bottom: 5px;"><p style="text-align: center; margin: 0;">Bạn đã là thành viên chính thức</p></button>'
                                                );
                                            }
                                            setTimeout(() => location.reload(), 2000);
                                            break;

                                        case 0: // Cần nạp thêm tiền
                                            $(".title_note, .box_sotien, .box_thongbao").remove();
                                            $(
                                                ".sudung_sodu, #xacnhan_kichhoat, #sudung_sodu"
                                            ).remove();
                                            // Chỉ thêm nếu #text_note tồn tại
                                            if ($("#text_note").length) {
                                                $("#text_note").html(
                                                    "Chuyển khoản để hoàn thành giao dịch"
                                                );
                                            }
                                            $(".box_xuly").html(info.step2);
                                            break;

                                        case 2: // Lỗi xử lý
                                            $(".box_xuly").html(info.thongbao);
                                            break;

                                        default:
                                            $(".box_xuly").html("Có lỗi không xác định xảy ra");
                                    }
                                }, 2000);
                            } catch (e) {
                                console.error("Lỗi phân tích JSON:", e);
                                $(".box_xuly").html("Lỗi xử lý dữ liệu từ máy chủ");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Lỗi AJAX:", error);
                            $(".box_xuly").html("Lỗi kết nối đến máy chủ");
                        },
                    });
                });

            // Xử lý nút "Hủy"
            $("#confirm_no")
                .off("click")
                .on("click", function () {
                    console.log("Nút Hủy được bấm");
                    $(".box_confirm").fadeOut(300);
                });
        });

    ///////////////////////////
    $("body").on("click", "#datlich_hotro", function () {
        thoi_gian = $("#pop_hotro input[name=thoi_gian]").val();
        $("#pop_hotro").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "datlich_hotro",
                thoi_gian: thoi_gian,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 3000);
            },
        });
    });
    //
    ///////////////////////////
    $("body").on("click", ".copy_aff", function () {
        var input = $(this);
        element = $(this).parent().find("input").attr("id");
        copy_text(element);
        $(this).html("Đã copy");
        setTimeout(function () {
            input.html('<i class="icofont-ui-copy"></i> copy');
        }, 5000);
    });
    ///////////////////////////
    $("body").on("click", ".copy_rutgon_aff", function () {
        var input = $(this);
        element = $(this).parent().find("input").attr("id");
        copy_text(element);
        $(this).html("Đã copy");
        setTimeout(function () {
            input.html('<i class="icofont-ui-copy"></i> copy');
        }, 5000);
    });
    ///////////////////////////
    $("body").on("click", ".rutgon_link_drop", function () {
        var button = $(this);
        link = $(this).parent().parent().find("input[name=link_aff]").val();
        sp_id = $(this).attr("sp_id");
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "rut_gon",
                sp_id: sp_id,
                link: link,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        button.parent().parent().find(".input_rutgon").html(info.html);
                    }
                }, 3000);
            },
        });
    });
    ///////////////////////////
    $("body").on("click", ".rutgon_link", function () {
        var button = $(this);
        link = $(this).parent().find("input").val();
        sp_id = $(this).attr("sp_id");
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "rut_gon",
                sp_id: sp_id,
                link: link,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        button.parent().parent().find(".input_rutgon").html(info.html);
                    }
                }, 3000);
            },
        });
    });
    ///////////////////////////
    $("body").on(
        "click",
        ".page_body .box_left .box_menu_left .box_left_content .main_menu .list_menu .li_menu .a_main",
        function () {
            $(this).parent().find(".list_menu_sub").toggleClass("active");
            if ($(this).find(".right i").hasClass("fa-plus-square-o")) {
                $(this).find(".right i").removeClass("fa-plus-square-o");
                $(this).find(".right i").addClass("fa-minus-square-o");
            } else {
                $(this).find(".right i").addClass("fa-plus-square-o");
                $(this).find(".right i").removeClass("fa-minus-square-o");
            }
        }
    );
    ///////////////////////////
    $("body").on(
        "click",
        ".page_body .box_left .box_menu_left .box_left_content .main_menu .list_menu .li_menu .list_menu_sub .li_menu_sub .a_sub",
        function () {
            $(this).parent().find(".list_menu_sub_sub").toggleClass("active");
            if ($(this).find(".right i").hasClass("fa-plus-square-o")) {
                $(this).find(".right i").removeClass("fa-plus-square-o");
                $(this).find(".right i").addClass("fa-minus-square-o");
            } else {
                $(this).find(".right i").addClass("fa-plus-square-o");
                $(this).find(".right i").removeClass("fa-minus-square-o");
            }
        }
    );
    $("#chon_kho").on("change", function () {
        kho = $(this).val();
        if (kho == "kho_hcm") {
            $(".pagination").hide();
            $(".load_sanpham").hide();
            $(".load_overlay").show();
            tr = $("body .list_baiviet tr").first().html();
            td_lengt = $("body .list_baiviet tr").first().children("th").length;
            $("body .list_baiviet").html(
                "<tr>" +
                tr +
                '</tr><tr><td colspan="' +
                td_lengt +
                '" align="center">Dữ liệu đang cập nhật...</td></tr>'
            );

            $(".load_process").fadeIn();
            $(".load_note").html("Dữ liệu đang cập nhật");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 3000);
        } else {
            create_cookie("drop_kho", kho, 365, "/");
            window.location.reload();
        }
    });
    setTimeout(function () {
        $(".loadpage").fadeOut();
        $(".page_body").fadeIn();
    }, 300);
    ////////////////////////////
    $("body").on("click", ".box_pop_add .pop_title .fa-close", function () {
        $(".box_pop_add").html("");
        $(".box_pop_add").hide();
    });
    ////////////////////////////
    $("body").on("click", ".box_pop_add .cancel_leader", function () {
        $(".box_pop_add").html("");
        $(".box_pop_add").hide();
    });
    ////////////////////////////
    $("body").on("click", ".hide_pop_thirth", function () {
        $(".pop_thirth").html("");
        $(".pop_thirth").hide();
        if ($(".box_pop_add .pop_second").length < 1) {
            $(".box_pop_add").html("");
            $(".box_pop_add").hide();
        } else {
        }
    });
    ///////////////////
    setTimeout(function () {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "get_total_cart",
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                console.log(info);
                $(".total_ct_shop").html(info.total);
                $(".notification .total_notification").html(info.total_noti);
                $(".total_ct_tuan").html(info.total_tuan);
                $(".total_hethang").html(info.total_hethang);
                $(".total_catma").html(info.total_catma);
                $(".total_thongbao").html(info.total_thongbao);
                $(".total_chat").html(info.total_chat);
                $(".total_follow").html(info.total_follow);
            },
        });
    }, 2000);
    ///////////////////
    $("body").on("click", ".info_thuonghieu .menu_thuonghieu span", function () {
        $(".info_thuonghieu").hide();
        window.location.reload();
        /*        if($('.list_thuonghieu.add_sanpham').length>0){
                        kieu=$('.button_timkiem').attr('kieu');
                        $('.load_sanpham').show();
                        $.ajax({
                            url: "/ncc/process.php",
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
                            url: "/ncc/process.php",
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
                            url: "/ncc/process.php",
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
    $("body").on(
        "click",
        ".list_thuonghieu.list_link_affiliate .li_thuonghieu",
        function () {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            thuong_hieu = $(this).attr("thuong_hieu");
            loai = "list_link_affiliate";
            kieu = $(".button_timkiem").attr("kieu");
            $(".pagination").hide();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_info_thuonghieu",
                    thuong_hieu: thuong_hieu,
                    kieu: kieu,
                    loai: loai,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.kieu == "mobile") {
                            $(".list_sanpham").html(info.list);
                        } else {
                            $(".list_baiviet").html(info.list);
                        }
                        $(".load_sanpham").hide();
                        $(".info_thuonghieu").css("display", "flex");
                        $(".info_thuonghieu .cover_thuonghieu img").attr("src", info.cover);
                        $(".info_thuonghieu .noidung_thuonghieu").html(info.noi_dung);
                    }, 1000);
                },
            });
        }
    );
    ///////////////////
    $("body").on(
        "click",
        ".list_thuonghieu.add_donhang_drop .li_thuonghieu",
        function () {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            thuong_hieu = $(this).attr("thuong_hieu");
            loai = "add_donhang_drop";
            kieu = $(".button_timkiem").attr("kieu");
            $(".pagination").hide();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_info_thuonghieu",
                    thuong_hieu: thuong_hieu,
                    kieu: kieu,
                    loai: loai,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.kieu == "mobile") {
                            $(".list_sanpham").html(info.list);
                        } else {
                            $(".list_baiviet").html(info.list);
                        }
                        $(".load_sanpham").hide();
                        $(".info_thuonghieu").css("display", "flex");
                        $(".info_thuonghieu .cover_thuonghieu img").attr("src", info.cover);
                        $(".info_thuonghieu .noidung_thuonghieu").html(info.noi_dung);
                    }, 1000);
                },
            });
        }
    );
    ///////////////////
    $("body").on(
        "click",
        ".list_thuonghieu.add_sanpham .li_thuonghieu",
        function () {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            thuong_hieu = $(this).attr("thuong_hieu");
            loai = "add_sanpham";
            kieu = $(".button_timkiem").attr("kieu");
            $(".pagination").hide();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_info_thuonghieu",
                    thuong_hieu: thuong_hieu,
                    kieu: kieu,
                    loai: loai,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.kieu == "mobile") {
                            $(".list_sanpham").html(info.list);
                        } else {
                            $(".list_baiviet").html(info.list);
                        }
                        $(".load_sanpham").hide();
                        $(".info_thuonghieu").css("display", "flex");
                        $(".info_thuonghieu .cover_thuonghieu img").attr("src", info.cover);
                        $(".info_thuonghieu .noidung_thuonghieu").html(info.noi_dung);
                    }, 1000);
                },
            });
        }
    );
    /////////////////////////////
    $("body").on("click", ".box_yeucau .box_search #show_add_hotro", function () {
        thanh_vien = $(this).attr("thanhvien");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_box_pop_thirth",
                thanh_vien: thanh_vien,
                loai: "add_yeucau_lienhe",
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".box_pop_add").html('<div class="pop_thirth"></div>');
                $(".pop_thirth").html(info.html);
                $(".pop_thirth").fadeIn();
                $(".box_pop_add").show();
                $(".box_yeucau .box_search input").val("");
                $(".box_yeucau .box_search .goi_y").html("");
                $(".box_yeucau .box_search .goi_y").hide();
            },
        });
    });

    /////////////////////////////
    $("body").on("click", ".pop_add_lienhe #gui_ykien", function () {
        var noi_dung = $(".pop_add_lienhe textarea[name=noi_dung]").val();
        var quy_trinh = $(".pop_add_lienhe select[name=quy_trinh]").val();
        var user_out = $(".box_chat input[name=user_out]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "add_yeucau_traodoi",
                quy_trinh: quy_trinh,
                noi_dung: noi_dung,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý...");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        $("#list_yeucau .li_yeucau").removeClass("active");
                        $("#list_yeucau").prepend(info.list);
                        $(".box_yeucau_hotro #ten_khach").html(info.ho_ten);
                        $(".box_yeucau_hotro #submit_yeucau").attr(
                            "phien",
                            info.phien_traodoi
                        );
                        $(
                            ".box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]"
                        ).prop("disabled", false);
                        $(".box_yeucau_hotro #list_chat").html("");
                        $(".box_yeucau_hotro .note_content .txt").html(noi_dung);
                        $(".box_pop_add").hide();
                        $(".box_pop_add").html("");
                        setTimeout(function () {
                            var top_dong = $(".bottom_chat").offset().top;
                            $("html,body")
                                .stop()
                                .animate(
                                    { scrollTop: top_dong - 150 },
                                    500,
                                    "swing",
                                    function () { }
                                );
                        }, 500);
                        var dulieu = {
                            user_out: user_out,
                            thanh_vien: info.thanh_vien,
                            bo_phan: info.bo_phan,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit("user_send_list_yeucau", info_chat);
                    } else {
                    }
                }, 2000);
            },
        });
    });
    /////////////////////////////
    $("body").on(
        "click",
        ".box_yeucau_hotro .box_yeucau .list_yeucau .list .li_yeucau",
        function () {
            var phien = $(this).attr("phien");
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_khach_traodoi",
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $("#list_yeucau").html(info.list);
                        $(".box_yeucau_hotro #submit_yeucau").attr("phien", info.phien);
                        $(".box_yeucau_hotro #list_chat").html(info.list_chat);
                        $(".box_yeucau_hotro .note_content .txt").html(info.note);
                        $("input[name=load_chat]").val(info.load_chat);
                        scrollSmoothToBottom("list_chat");
                        if (info.active == 1) {
                            $(
                                ".box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]"
                            ).prop("disabled", false);
                        } else {
                            $(
                                ".box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]"
                            ).prop("disabled", true);
                        }
                    } else {
                    }
                },
            });
        }
    );
    /////////////////////////////
    $("body").on("click", ".box_chat #submit_yeucau", function () {
        var phien = $(this).attr("phien");
        var noi_dung = $(".box_chat input[name=noidung_yeucau]").val();
        var user_out = $(".box_chat input[name=user_out]").val();
        if ($("#list_chat .txt").length > 0) {
            sms_id = $("#list_chat .li_sms").last().attr("sms_id");
        } else {
            sms_id = 0;
        }
        $(".box_chat .text_status .loading_chat").html(
            '<i class="icofont-spinner spinx"></i> Đang gửi tin'
        );
        $(".box_chat .text_status .loading_chat").show();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "add_sms_traodoi",
                phien: phien,
                noi_dung: noi_dung,
                sms_id: sms_id,
            },
            success: function (kq) {
                $(".box_chat input[name=noidung_yeucau]").val("");
                $(".box_chat .text_status .loading_chat").hide();
                $(".box_chat .text_status .loading_chat").html(
                    '<i class="icofont-spinner spinx"></i> Đang gửi tin'
                );
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $("#list_chat").append(info.list);
                    scrollSmoothToBottom("list_chat");
                    var dulieu = {
                        list_out: info.list_out,
                        list: info.list,
                        phien: phien,
                        loai: "thanh_vien",
                        user_out: info.user_out,
                        bo_phan: info.bo_phan,
                        thanh_vien: user_out,
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit("user_send_traodoi", info_chat);
                } else {
                    $(".load_overlay").show();
                    $(".load_process").fadeIn();
                    $(".load_note").html(info.thongbao);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý...");
                        $(".load_overlay").hide();
                    }, 2000);
                }
            },
        });
    });
    $("body").on(
        "keypress",
        ".box_chat input[name=noidung_yeucau]",
        function (e) {
            if (e.which == 13) {
                var phien = $(".box_chat #submit_yeucau").attr("phien");
                var noi_dung = $(".box_chat input[name=noidung_yeucau]").val();
                var user_out = $(".box_chat input[name=user_out]").val();
                if ($("#list_chat .txt").length > 0) {
                    sms_id = $("#list_chat .li_sms").last().attr("sms_id");
                } else {
                    sms_id = 0;
                }
                $(".box_chat .text_status .loading_chat").html(
                    '<i class="icofont-spinner spinx"></i> Đang gửi tin'
                );
                $(".box_chat .text_status .loading_chat").show();
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "add_sms_traodoi",
                        phien: phien,
                        noi_dung: noi_dung,
                        sms_id: sms_id,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $(".box_chat .text_status .loading_chat").hide();
                        $(".box_chat .text_status .loading_chat").html(
                            '<i class="icofont-spinner spinx"></i> Đang gửi tin'
                        );
                        $(".box_chat input[name=noidung_yeucau]").val("");
                        if (info.ok == 1) {
                            $("#list_chat").append(info.list);
                            scrollSmoothToBottom("list_chat");
                            var dulieu = {
                                list_out: info.list_out,
                                list: info.list,
                                phien: phien,
                                loai: "thanh_vien",
                                bo_phan: info.bo_phan,
                                user_out: info.user_out,
                                thanh_vien: user_out,
                            };
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit("user_send_traodoi", info_chat);
                        } else {
                            $(".load_overlay").show();
                            $(".load_process").fadeIn();
                            $(".load_note").html(info.thongbao);
                            setTimeout(function () {
                                $(".load_process").hide();
                                $(".load_note").html("Hệ thống đang xử lý...");
                                $(".load_overlay").hide();
                            }, 2000);
                        }
                    },
                });
            } else {
            }
        }
    );
    $("body").on("click", ".box_sticker .li_sticker img", function (e) {
        $(".box_sticker").hide();
        var phien = $(".box_chat #submit_yeucau").attr("phien");
        var src = $(this).attr("src");
        var user_out = $(".box_chat input[name=user_out]").val();
        if ($("#list_chat .txt").length > 0) {
            sms_id = $("#list_chat .li_sms").last().attr("sms_id");
        } else {
            sms_id = 0;
        }
        $(".box_chat .text_status .loading_chat").html(
            '<i class="icofont-spinner spinx"></i> Đang gửi tin'
        );
        $(".box_chat .text_status .loading_chat").show();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "add_sticker_traodoi",
                phien: phien,
                src: src,
                sms_id: sms_id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".box_chat .text_status .loading_chat").hide();
                $(".box_chat .text_status .loading_chat").html(
                    '<i class="icofont-spinner spinx"></i> Đang gửi tin'
                );
                $(".box_chat input[name=noidung_yeucau]").val("");
                if (info.ok == 1) {
                    $("#list_chat").append(info.list);
                    scrollSmoothToBottom("list_chat");
                    var dulieu = {
                        list_out: info.list_out,
                        list: info.list,
                        phien: phien,
                        loai: "thanh_vien",
                        user_out: info.user_out,
                        thanh_vien: user_out,
                        bo_phan: info.bo_phan,
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit("user_send_traodoi", info_chat);
                } else {
                    $(".load_overlay").show();
                    $(".load_process").fadeIn();
                    $(".load_note").html(info.thongbao);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý...");
                        $(".load_overlay").hide();
                    }, 2000);
                }
            },
        });
    });
    //////////////////////////
    var lastScrollTop = 0;
    $("#list_chat").scroll(function () {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {
        } else {
            load = $("input[name=load_chat]").val();
            loaded = $("input[name=load_chat]").attr("loaded");
            sms_id = $("#list_chat .li_sms").first().attr("sms_id");
            var phien = $(".box_chat #submit_yeucau").attr("phien");
            if (st < 50 && loaded == 1 && load == 1) {
                $("#list_chat").prepend(
                    '<div class="li_load_chat"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                $("input[name=load_chat]").attr("loaded", "0");
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "load_chat_sms",
                            phien: phien,
                            sms_id: sms_id,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $("#list_chat .li_load_chat").remove();
                            $("input[name=load_chat]").val(info.load_chat);
                            $("input[name=load_chat]").attr("loaded", "1");
                            if (info.ok == 1) {
                                $("#list_chat").prepend(info.list_chat);
                                total_height = 0;
                                $("#list_chat .li_sms").each(function () {
                                    if ($(this).attr("sms_id") < sms_id) {
                                        total_height += $(this).outerHeight();
                                    }
                                });
                                $("#list_chat").animate(
                                    {
                                        scrollTop: total_height - 50,
                                    },
                                    200
                                );
                            } else {
                            }
                        },
                    });
                }, 3000);
            } else {
            }
        }
        lastScrollTop = st;
    });
    /////////////////////////////
    socket.on("server_send_traodoi", function (data) {
        user_out = $(".box_chat input[name=user_out]").val();
        thanhvien_chat = $("input[name=thanhvien_chat]").val();
        phien = $("#submit_yeucau").attr("phien");
        var info = JSON.parse(data);
        if (thanhvien_chat == info.user_out) {
        } else {
            if (thanhvien_chat == info.thanh_vien) {
                $("#play_chat").click();
            }
            if (phien == info.phien) {
                $("#list_chat").append(info.list_out);
                scrollSmoothToBottom("list_chat");
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_hoatdong", function (data) {
        var info = JSON.parse(data);
        bo_phan = $("input[name=bophan_hotro]").val();
        if (info.hd == "user_notification") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_tk_notification",
                    bo_phan: bo_phan,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("#play_chat_global").click();
                    $(".total_notification").html(info.total_notification);
                },
            });
        }
    });
    /////////////////////////////
    socket.on("server_send_list_yeucau", function (data) {
        phien = $("#submit_yeucau").attr("phien");
        user_out = $(".box_chat input[name=user_out]").val();
        var info = JSON.parse(data);
        if (user_out == info.user_out || user_out != info.thanh_vien) {
        } else {
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_list_yeucau",
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("#list_yeucau").html(info.list);
                },
            });
        }
    });
    /////////////////////////////
    socket.on("server_send_dong_yeucau", function (data) {
        phien = $("#submit_yeucau").attr("phien");
        user_out = $(".box_chat input[name=user_out]").val();
        var info = JSON.parse(data);
        if (user_out == info.user_out || user_out != info.thanh_vien) {
        } else {
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_list_yeucau",
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("#list_yeucau").html(info.list);
                },
            });
        }
    });
    /////////////////////////////
    $("body").on("click", ".box_chat #dong_yeucau", function () {
        phien = $(".box_chat #submit_yeucau").attr("phien");
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "dong_yeucau",
                phien: phien,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý...");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        $(
                            ".box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]"
                        ).prop("disabled", true);
                        var dulieu = {
                            user_out: info.user_out,
                            thanh_vien: info.thanh_vien,
                            phien: info.phien,
                            bo_phan: info.bo_phan,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit("user_send_dong_yeucau", info_chat);
                    }
                }, 3000);
            },
        });
    });
    ///////////////////
    $(".box_pop_xemtruoc .xemtruoc_title .fa").on("click", function () {
        $(".box_pop_xemtruoc").hide();
        $(".box_pop_xemtruoc .noidung_xemtruoc .trich").html("");
        $(".box_pop_xemtruoc .noidung_xemtruoc .minh_hoa").html("");
        $(".box_pop_xemtruoc .noidung_xemtruoc #textarea_1").val("");
    });
    ///////////////////
    $(".box_select_product .box_title .fa").on("click", function () {
        $(".box_select_product").hide();
        $(".box_select_product .box_list").html("");
        $(".box_select_product .box_list").attr("page", 1);
        $("input[name=key_deal]").val("");
    });
    ///////////////////
    $(".preview_button").on("click", function () {
        noidung_id = $(this).attr("noidung_id");
        minh_hoa = $(this).attr("minh_hoa");
        minh_hoa = "https://socdo.vn" + minh_hoa;
        noidung = $("#textarea_" + noidung_id).val();
        $(".box_pop_xemtruoc .list_button .copy_button").html(
            '<i class="fa fa-copy"></i> Sao chép'
        );
        $(".box_pop_xemtruoc .noidung_xemtruoc").html(
            noidung.replace(/\n/g, "<br />")
        );
        $(".box_pop_xemtruoc .list_button .share_button").attr(
            "noidung_id",
            noidung_id
        );
        $(".box_pop_xemtruoc .list_button .share_button").attr(
            "minh_hoa",
            minh_hoa
        );
        $(".box_pop_xemtruoc .list_button .copy_button").attr(
            "noidung_id",
            noidung_id
        );
        $(".box_pop_xemtruoc .list_button .copy_button").attr("minh_hoa", minh_hoa);
        $(".box_pop_xemtruoc").show();
    });
    ///////////////////
    $(".share_button_laptop").on("click", function () {
        noidung_id = $(this).attr("noidung_id");
        var bt_active = $(this);
        copy_text("textarea_" + noidung_id);
        $(this).html('<i class="fa fa-copy"></i> Đã sao chép');
        setTimeout(function () {
            bt_active.html('<i class="fa fa-copy"></i> Ssao chép');
        }, 2000);
    });
    ///////////////////
    $(".copy_button").on("click", function () {
        noidung_id = $(this).attr("noidung_id");
        copy_text("textarea_" + noidung_id);
        $(".box_pop_xemtruoc .list_button .copy_button").html(
            '<i class="fa fa-copy"></i> Đã sao chép'
        );
    });
    //////////////////////////
    $(".share_nhiemvu_button").on("click", function () {
        noidung_id = 1;
        rut_gon = 0;
        mobile = 0;
        copy_text_share("textarea_1", rut_gon, mobile);
        i = 0;
        $("#list_anh_1 img,#list_anh_1 video").each(function () {
            $(".list_input").append(
                '<input type="file" style="display:none;" id="input_' +
                i +
                '" name="file[]" multiple="multiple" />'
            );
            src = $(this).attr("src");
            ten_file = filename(src);
            loadURLToInputField(src, "#input_" + i);
            console.log(src);
            i++;
        });
        $("#submit_nhiemvu_button").click();
    });
    //////////////////////////
    $("#submit_nhiemvu_button").on("click", function () {
        var file_store = [];
        var i = 0;
        $("input[name^=file]").each(function () {
            file_store.push.apply(file_store, $(this)[0].files);
        });
        total_file = file_store.length;
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        noi_dung = $("#textarea_1").val();
        if (file_store.length > 0) {
            $(".load_overlay").hide();
            $(".load_process").hide();
            if (navigator.share) {
                navigator
                    .share({
                        title: "Chia sẻ nhiệm vụ trên mạng xã hội",
                        text: $("#textarea_1").val(),
                        files: file_store,
                    })
                    .then(() => (file_store = []))
                    .catch((error) => console.log("Error sharing", error));
            } else {
                console.log("Không hỗ trợ trên trình duyệt này.");
            }
        } else {
            setTimeout(function () {
                $("input[name^=file]").each(function () {
                    file_store.push.apply(file_store, $(this)[0].files);
                });
                total_file = file_store.length;
                if (file_store.length > 0) {
                    $(".load_overlay").hide();
                    $(".load_process").hide();
                    if (navigator.share) {
                        navigator
                            .share({
                                title: "Chia sẻ nhiệm vụ trên mạng xã hội",
                                text: $("#textarea_1").val(),
                                files: file_store,
                            })
                            .then(() => (file_store = []))
                            .catch((error) => console.log("Error sharing", error));
                    } else {
                        console.log("Không hỗ trợ trên trình duyệt này.");
                    }
                } else {
                    $("input[name^=file]").each(function () {
                        file_store.push.apply(file_store, $(this)[0].files);
                    });
                    total_file = file_store.length;
                    if (file_store.length > 0) {
                        if (navigator.share) {
                            navigator
                                .share({
                                    title: "Chia sẻ nhiệm vụ trên mạng xã hội",
                                    text: $("#textarea_1").val(),
                                    files: file_store,
                                })
                                .then(() => (file_store = []))
                                .catch((error) => console.log("Error sharing", error));
                        } else {
                            console.log("Không hỗ trợ trên trình duyệt này.");
                        }
                    } else {
                        console.log("Không thể chia sẻ");
                    }
                }
            }, 3000);
        }
    });
    //////////////////////////
    $(".share_button").on("click", function () {
        //$('input[name^=file]').remove();
        minh_hoa = $(this).attr("minh_hoa");
        minh_hoa = "https://socdo.vn" + minh_hoa;
        noidung_id = $(this).attr("noidung_id");
        if ($("input[name=rut_gon]").is(":checked")) {
            rut_gon = 1;
        } else {
            rut_gon = 0;
        }
        if ($("input[name=mobile_share]").is(":checked")) {
            mobile = 1;
        } else {
            mobile = 0;
        }
        copy_text_share("textarea_" + noidung_id, rut_gon, mobile);
        i = 0;
        $(
            "#list_anh_" + noidung_id + " img,#list_anh_" + noidung_id + " video"
        ).each(function () {
            $(".box_pop_xemtruoc").before(
                '<input type="file" style="display:none;" id="input_' +
                i +
                '" name="file[]" multiple="multiple" />'
            );
            src = $(this).attr("src");
            ten_file = filename(src);
            loadURLToInputField(src, "#input_" + i);
            console.log(src);
            i++;
        });
        $("#submit_button").click();
    });
    //////////////////////////
    $("#submit_button").on("click", function () {
        var file_store = [];
        var i = 0;
        $("input[name^=file]").each(function () {
            file_store.push.apply(file_store, $(this)[0].files);
        });
        total_file = file_store.length;
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        noi_dung = $("#textarea_" + noidung_id).val();
        if ($("input[name=rut_gon]").is(":checked")) {
            link_rutgon = "\nXem chi tiết: " + $("input[name=rut_gon]").val();
        } else {
            link_rutgon = "";
        }
        if ($("input[name=mobile_share]").is(":checked")) {
            mobile_share = "\nLiên hệ ngay: " + $("input[name=mobile_share]").val();
        } else {
            mobile_share = "";
        }
        noi_dung = noi_dung + "" + link_rutgon + "" + mobile_share;
        if (file_store.length > 0) {
            $(".load_overlay").hide();
            $(".load_process").hide();
            if (navigator.share) {
                navigator
                    .share({
                        title: "Bán hàng trên mạng xã hội",
                        text: $("#textarea_" + noidung_id).val(),
                        files: file_store,
                    })
                    .then(() => (file_store = []))
                    .catch((error) => console.log("Error sharing", error));
            } else {
                console.log("Không hỗ trợ trên trình duyệt này.");
            }
        } else {
            setTimeout(function () {
                $("input[name^=file]").each(function () {
                    file_store.push.apply(file_store, $(this)[0].files);
                });
                total_file = file_store.length;
                if (file_store.length > 0) {
                    $(".load_overlay").hide();
                    $(".load_process").hide();
                    if (navigator.share) {
                        navigator
                            .share({
                                title: "Bán hàng trên mạng xã hội",
                                text: $("#textarea_" + noidung_id).val(),
                                files: file_store,
                            })
                            .then(() => (file_store = []))
                            .catch((error) => console.log("Error sharing", error));
                    } else {
                        console.log("Không hỗ trợ trên trình duyệt này.");
                    }
                } else {
                    $("input[name^=file]").each(function () {
                        file_store.push.apply(file_store, $(this)[0].files);
                    });
                    total_file = file_store.length;
                    if (file_store.length > 0) {
                        if (navigator.share) {
                            navigator
                                .share({
                                    title: "Bán hàng trên mạng xã hội",
                                    text: $("#textarea_" + noidung_id).val(),
                                    files: file_store,
                                })
                                .then(() => (file_store = []))
                                .catch((error) => console.log("Error sharing", error));
                        } else {
                            console.log("Không hỗ trợ trên trình duyệt này.");
                        }
                    } else {
                        console.log("Không thể chia sẻ");
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
    $(".menu_thongbao .title .fa").on("click", function () {
        $(".menu_thongbao").hide();
        create_cookie("close_menu_thongbao", 1, 1, "/");
    });
    $(".box_select_product").on("click", ".action button", function () {
        $(this).toggleClass("active");
    });
    // voucher
    $(".box_select_product .box_list").on("scroll", function () {
        if (
            $(this).scrollTop() + $(this).innerHeight() >=
            $(this)[0].scrollHeight
        ) {
            tiep = $(".box_select_product .box_list").attr("tiep");
            page = $(".box_select_product .box_list").attr("page");
            loaded = $(".box_select_product .box_list").attr("loaded");
            key = $("input[name=key_deal]").val();
            loai = $("button[name=select_main_product]").attr("loai");
            if (loaded == 1 && tiep == 1 && page != 1 && key == "") {
                $(".box_select_product .box_list").append(
                    '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                $(".box_select_product .box_list").attr("loaded", 0);
                if (loai == "main_product") {
                    setTimeout(function () {
                        $.ajax({
                            url: "/ncc/process.php",
                            type: "post",
                            data: {
                                action: "load_product_main",
                                page: page,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $(".box_select_product .box_list .loading_product").remove();
                                $(".box_select_product .box_list").append(info.list);
                                $(".box_select_product .box_list").attr("page", info.page);
                                $(".box_select_product .box_list").attr("tiep", info.tiep);
                                $(".box_select_product .box_list").attr("loaded", 1);
                            },
                        });
                    }, 1000);
                } else {
                    var sp_id = "";
                    $(
                        "#list_product_main .li_product,#list_product_sub .li_product"
                    ).each(function () {
                        sp_id += $(this).attr("sp") + ",";
                    });
                    setTimeout(function () {
                        $.ajax({
                            url: "/ncc/process.php",
                            type: "post",
                            data: {
                                action: "load_product_sub",
                                list_id: sp_id,
                                page: page,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $(".box_select_product .box_list .loading_product").remove();
                                $(".box_select_product .box_list").append(info.list);
                                $(".box_select_product .box_list").attr("page", info.page);
                                $(".box_select_product .box_list").attr("tiep", info.tiep);
                                $(".box_select_product .box_list").attr("loaded", 1);
                            },
                        });
                    }, 1000);
                }
            }
        }
    });
    // voucher
    $(".select_product").on("click", function () {
        $(".box_select_product .box_list").html(
            '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        $(".box_select_product").show();
        $(".box_select_product .box_bottom button").attr("loai", "main_product");
        setTimeout(function () {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_product_main",
                    page: 1,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $(".box_select_product .box_list").html(info.list);
                    $(".box_select_product .box_list").attr("page", info.page);
                    $(".box_select_product .box_list").attr("tiep", info.tiep);
                    $(".box_select_product .box_list").attr("loaded", 1);
                },
            });
        }, 1000);
    });
    // $('.select_product_sub').on('click', function () {
    //     $('.box_select_product .box_list').html('<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
    //     $('.box_select_product').show();
    //     $('.box_select_product .box_bottom button').attr('loai', 'sub_product');
    //     var sp_id = '';
    //     $('#list_product_main .li_product,#list_product_sub .li_product').each(function () {
    //         sp_id += $(this).attr('sp') + ',';
    //     });
    //     setTimeout(function () {
    //         $.ajax({
    //             url: "/ncc/process.php",
    //             type: "post",
    //             data: {
    //                 action: 'load_product_sub',
    //                 list_id: sp_id,
    //                 page: 1,
    //             },
    //             success: function (kq) {
    //                 var info = JSON.parse(kq);
    //                 $('.box_select_product .box_list').html(info.list);
    //                 $('.box_select_product .box_list').attr('page', info.page);
    //                 $('.box_select_product .box_list').attr('tiep', info.tiep);
    //                 $('.box_select_product .box_list').attr('loaded', 1);
    //             }
    //         });
    //     }, 1000);

    // });
    $(".search_deal").on("click", function () {
        key = $("input[name=key_deal]").val();
        loai = $("button[name=select_main_product]").attr("loai");
        var sp_id = "";
        $("#list_product_main .li_product,#list_product_sub .li_product").each(
            function () {
                sp_id += $(this).attr("sp") + ",";
            }
        );
        if (key.length < 1) {
            $("input[name=key_deal]").focus();
        } else {
            $(".box_select_product .box_list").html(
                '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
            );
            if (loai == "main_product") {
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "search_product_main",
                            key: key,
                            page: 1,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $(".box_select_product .box_list").html(info.list);
                            $(".box_select_product .box_list").attr("page", info.page);
                            $(".box_select_product .box_list").attr("tiep", 0);
                            $(".box_select_product .box_list").attr("loaded", 1);
                        },
                    });
                }, 1000);
            } else {
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "search_product_sub",
                            key: key,
                            list_id: sp_id,
                            page: 1,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $(".box_select_product .box_list").html(info.list);
                            $(".box_select_product .box_list").attr("page", info.page);
                            $(".box_select_product .box_list").attr("tiep", 0);
                            $(".box_select_product .box_list").attr("loaded", 1);
                        },
                    });
                }, 1000);
            }
        }
    });
    $("input[name=key_deal]").keypress(function (e) {
        if (e.which == 13) {
            key = $("input[name=key_deal]").val();
            loai = $("button[name=select_main_product]").attr("loai");
            var sp_id = "";
            $("#list_product_main .li_product,#list_product_sub .li_product").each(
                function () {
                    sp_id += $(this).attr("sp") + ",";
                }
            );
            if (key.length < 1) {
                $("input[name=key_deal]").focus();
            } else {
                $(".box_select_product .box_list").html(
                    '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                if (loai == "main_product") {
                    setTimeout(function () {
                        $.ajax({
                            url: "/ncc/process.php",
                            type: "post",
                            data: {
                                action: "search_product_main",
                                key: key,
                                page: 1,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $(".box_select_product .box_list").html(info.list);
                                $(".box_select_product .box_list").attr("page", info.page);
                                $(".box_select_product .box_list").attr("tiep", 0);
                                $(".box_select_product .box_list").attr("loaded", 1);
                            },
                        });
                    }, 1000);
                } else {
                    setTimeout(function () {
                        $.ajax({
                            url: "/ncc/process.php",
                            type: "post",
                            data: {
                                action: "search_product_sub",
                                key: key,
                                list_id: sp_id,
                                page: 1,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $(".box_select_product .box_list").html(info.list);
                                $(".box_select_product .box_list").attr("page", info.page);
                                $(".box_select_product .box_list").attr("tiep", 0);
                                $(".box_select_product .box_list").attr("loaded", 1);
                            },
                        });
                    }, 1000);
                }
            }
        }
    });
    /////////////////////////////
    $("button[name=select_main_product]").on("click", function () {
        loai = $(this).attr("loai");
        if (loai == "main_product") {
            $(".box_select_product .box_list .li_product button.active").each(
                function () {
                    sp_id = $(this).attr("sp");
                    if ($("#list_product_main .li_product_" + sp_id).length < 1) {
                        sanpham = $(this).parent().parent().html();
                        sp = sanpham.replace("Chọn", "xóa");
                        $("#list_product_main").append(
                            '<div class="li_product li_product_' +
                            sp_id +
                            '" sp="' +
                            sp_id +
                            '">' +
                            sp +
                            "</div>"
                        );
                    }
                }
            );
        } else if (loai == "sub_product") {
            kieu = $("input[name=loai]:checked").val();
            var sp_id = "";
            $(".box_select_product .box_list .li_product button.active").each(
                function () {
                    sp_id += $(this).attr("sp") + ",";
                }
            );
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "show_product_sub",
                    list_id: sp_id,
                    kieu: kieu,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("#list_product_sub").append(info.list);
                },
            });
        }
        $(".box_select_product").hide();
        $(".box_select_product .box_list").html("");
        $(".box_select_product .box_list").attr("page", 1);
        $("input[name=key_deal]").val("");
    });
    $("#list_product_main").on("click", ".action button", function () {
        $(this).parent().parent().remove();
    });
    $("#list_product_sub").on("click", ".action button", function () {
        $(this).parent().parent().remove();
    });
    ///////////////////////////// voucher
    // $('select[name=apdung]').on('change', function () {
    //     kieu = $(this).val();
    //     if (kieu == 'all') {
    //         $('#box_sanpham').hide();
    //     } else {
    //         $('#box_sanpham').show();
    //     }

    // });
    $("select[name=apdung]")
        .on("change", function () {
            if ($(this).val() === "sanpham") {
                $("#box_sanpham").show();
            } else {
                $("#box_sanpham").hide();
            }
        })
        .trigger("change");
    /////////////////////////////
    $("button[name=add_flash_sale]").click(function () {
        tieu_de = $("input[name=tieu_de]").val();
        date_start = $("input[name=date_start]").val();
        date_end = $("input[name=date_end]").val();
        var sub_product = "";
        var product_length = $("#list_product_sub .li_product").length;
        s = 0;
        list = "";
        sub_ok = 1;
        $("#list_product_sub .li_product").each(function () {
            sub_product += $(this).attr("sp") + ",";
            sp_id = $(this).attr("sp");
            gia = $(this).find("input[name^=gia_deal]").val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '"},';
            }
            if (gia == "") {
                sub_ok = 0;
            }
        });
        var list_product_sub = "{" + list + "}";
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        if (tieu_de == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tên chương trình");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
            $("input[name=tieu_de]").focus();
        } else if (date_start == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thời gian bắt đầu");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (date_end == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thời gian kết thúc");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (sub_product == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn sản phẩm");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (sub_ok == 0) {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập giá khuyến mại");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_flash_sale",
                    tieu_de: tieu_de,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=add_deal]").click(function () {
        tieu_de = $("input[name=tieu_de]").val();
        loai = $("input[name=loai]:checked").val();
        date_start = $("input[name=date_start]").val();
        date_end = $("input[name=date_end]").val();
        var main_product = "";
        $("#list_product_main .li_product").each(function () {
            main_product += $(this).attr("sp") + ",";
        });
        var sub_product = "";
        var product_length = $("#list_product_sub .li_product").length;
        s = 0;
        list = "";
        sub_ok = 1;
        $("#list_product_sub .li_product").each(function () {
            sub_product += $(this).attr("sp") + ",";
            sp_id = $(this).attr("sp");
            gia = $(this).find("input[name^=gia_deal]").val();
            sale = $(this).find("input[name^=sale_deal]").val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"},';
            }
            if (gia == "" && sale == "") {
                sub_ok = 0;
            }
        });
        var list_product_sub = "{" + list + "}";
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        if (tieu_de == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tên chương trình");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
            $("input[name=tieu_de]").focus();
        } else if (date_start == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thời gian bắt đầu");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (date_end == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thời gian kết thúc");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (main_product == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn sản phẩm chính");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (sub_product == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn sản phẩm kèm theo");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (sub_ok == 0) {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập giá khuyến mại hoặc % khuyến mại");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_deal",
                    loai: loai,
                    tieu_de: tieu_de,
                    main_product: main_product,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_deal]").click(function () {
        tieu_de = $("input[name=tieu_de]").val();
        loai = $("input[name=loai]:checked").val();
        date_start = $("input[name=date_start]").val();
        date_end = $("input[name=date_end]").val();
        id = $("input[name=id]").val();
        var main_product = "";
        $("#list_product_main .li_product").each(function () {
            main_product += $(this).attr("sp") + ",";
        });
        var sub_product = "";
        var product_length = $("#list_product_sub .li_product").length;
        s = 0;
        list = "";
        sub_ok = 1;
        $("#list_product_sub .li_product").each(function () {
            sub_product += $(this).attr("sp") + ",";
            sp_id = $(this).attr("sp");
            gia = $(this).find("input[name^=gia_deal]").val();
            sale = $(this).find("input[name^=sale_deal]").val();
            s++;
            if (s == product_length) {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"}';
            } else {
                list += '"' + sp_id + '":{"gia":"' + gia + '","sale":"' + sale + '"},';
            }
            if (gia == "" && sale == "") {
                sub_ok = 0;
            }
        });
        var list_product_sub = "{" + list + "}";
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        if (tieu_de == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tên chương trình");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
            $("input[name=tieu_de]").focus();
        } else if (date_start == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thời gian bắt đầu");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (date_end == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thời gian kết thúc");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (main_product == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn sản phẩm chính");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (sub_product == "") {
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn sản phẩm kèm theo");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else if (sub_ok == 0) {
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập giá khuyến mại hoặc % khuyến mại");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 1500);
        } else {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "edit_deal",
                    loai: loai,
                    tieu_de: tieu_de,
                    main_product: main_product,
                    sub_product: sub_product,
                    list_product_sub: list_product_sub,
                    date_start: date_start,
                    date_end: date_end,
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    // $('button[name=edit_flash_sale]').click(function () {
    //     tieu_de = $('input[name=tieu_de]').val();
    //     date_start = $('input[name=date_start]').val();
    //     date_end = $('input[name=date_end]').val();
    //     id = $('input[name=id]').val();
    //     var sub_product = '';
    //     var product_length = $('#list_product_sub .li_product').length;
    //     s = 0;
    //     list = '';
    //     sub_ok = 1;
    //     $('#list_product_sub .li_product').each(function () {
    //         sub_product += $(this).attr('sp') + ',';
    //         sp_id = $(this).attr('sp');
    //         gia = $(this).find('input[name^=gia_deal]').val();
    //         s++;
    //         if (s == product_length) {
    //             list += '"' + sp_id + '":{"gia":"' + gia + '"}';
    //         } else {
    //             list += '"' + sp_id + '":{"gia":"' + gia + '"},';
    //         }
    //         if (gia == '') {
    //             sub_ok = 0;
    //         }
    //     });
    //     var list_product_sub = '{' + list + '}';
    //     $('.load_overlay').show();
    //     $('.load_process').fadeIn();
    //     if (tieu_de == '') {
    //         setTimeout(function () {
    //             $('.load_note').html('Vui lòng nhập tên chương trình');
    //         }, 500);
    //         setTimeout(function () {
    //             $('.load_process').hide();
    //             $('.load_note').html('Hệ thống đang xử lý');
    //             $('.load_overlay').hide();
    //         }, 1500);
    //         $('input[name=tieu_de]').focus();

    //     } else if (date_start == '') {
    //         setTimeout(function () {
    //             $('.load_note').html('Vui lòng nhập thời gian bắt đầu');
    //         }, 500);
    //         setTimeout(function () {
    //             $('.load_process').hide();
    //             $('.load_note').html('Hệ thống đang xử lý');
    //             $('.load_overlay').hide();
    //         }, 1500);
    //     } else if (date_end == '') {
    //         setTimeout(function () {
    //             $('.load_note').html('Vui lòng nhập thời gian kết thúc');
    //         }, 500);
    //         setTimeout(function () {
    //             $('.load_process').hide();
    //             $('.load_note').html('Hệ thống đang xử lý');
    //             $('.load_overlay').hide();
    //         }, 1500);
    //     } else if (sub_product == '') {
    //         setTimeout(function () {
    //             $('.load_note').html('Vui lòng chọn sản phẩm');
    //         }, 500);
    //         setTimeout(function () {
    //             $('.load_process').hide();
    //             $('.load_note').html('Hệ thống đang xử lý');
    //             $('.load_overlay').hide();
    //         }, 1500);

    //     } else if (sub_ok == 0) {
    //         setTimeout(function () {
    //             $('.load_note').html('Vui lòng nhập giá khuyến mại');
    //         }, 500);
    //         setTimeout(function () {
    //             $('.load_process').hide();
    //             $('.load_note').html('Hệ thống đang xử lý');
    //             $('.load_overlay').hide();
    //         }, 1500);

    //     } else {
    //         $.ajax({
    //             url: "/ncc/process.php",
    //             type: "post",
    //             data: {
    //                 action: 'edit_flash_sale',
    //                 tieu_de: tieu_de,
    //                 sub_product: sub_product,
    //                 list_product_sub: list_product_sub,
    //                 date_start: date_start,
    //                 date_end: date_end,
    //                 id: id
    //             },
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
    //                         window.location.reload();
    //                     }
    //                 }, 3000);
    //             }
    //         });
    //     }
    // });
    if ($(".list_baiviet tr").length < 2 && $(".li_sanpham_drop").length < 2) {
        $(".load_sanpham button").hide();
    }
    $("body").on("click", "#main_category .li_input input", function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_sub_category",
                    cat_id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($("#sub_category .li_input").length > 0) {
                            $("#sub_category").append(
                                '<hr class="hr_' + id + '">' + info.list
                            );
                        } else {
                            $("#sub_category").append(info.list);
                        }
                    } else {
                    }
                },
            });
        } else {
            id = $(this).val();
            $(".li_input_" + id).remove();
            $(".hr_" + id).remove();
            $(".hr_main_" + id).remove();
            $(".li_input_main_" + id).remove();
        }
    });
    $("body").on("click", "#sub_category .li_input input", function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            main = $(this).attr("main_id");
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_sub_sub_category",
                    cat_id: id,
                    main: main,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($("#sub_sub_category .li_input").length > 0) {
                            $("#sub_sub_category").append(
                                '<hr class="hr_' + id + " hr_main_" + main + '">' + info.list
                            );
                        } else {
                            $("#sub_sub_category").append(info.list);
                        }
                    } else {
                    }
                },
            });
        } else {
            id = $(this).val();
            $(".hr_" + id).remove();
            $(".li_input_" + id).remove();
        }
    });
    //ncc nhà cung cấp
    $("body").on("click", "#main_category_ncc .li_input input", function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_sub_category_ncc",
                    cat_id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($("#sub_category_ncc .li_input").length > 0) {
                            $("#sub_category_ncc").append(
                                '<hr class="hr_' + id + '">' + info.list
                            );
                        } else {
                            $("#sub_category_ncc").append(info.list);
                        }
                    } else {
                    }
                },
            });
        } else {
            id = $(this).val();
            $(".li_input_" + id).remove();
            $(".hr_" + id).remove();
            $(".hr_main_" + id).remove();
            $(".li_input_main_" + id).remove();
        }
    });
    $("body").on("click", "#sub_category_ncc .li_input input", function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            main = $(this).attr("main_id");
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_sub_sub_category_ncc",
                    cat_id: id,
                    main: main,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($("#sub_sub_category_ncc .li_input").length > 0) {
                            $("#sub_sub_category_ncc").append(
                                '<hr class="hr_' + id + " hr_main_" + main + '">' + info.list
                            );
                        } else {
                            $("#sub_sub_category_ncc").append(info.list);
                        }
                    } else {
                    }
                },
            });
        } else {
            id = $(this).val();
            $(".hr_" + id).remove();
            $(".li_input_" + id).remove();
        }
    });
    //////////////////////////
    $(".quickview-close").on("click", function () {
        $(".load_overlay").hide();
        $(".modal").hide();
    });
    //////////////////////////
    $(".btn-continue").on("click", function () {
        $(".load_overlay").hide();
        $(".modal").hide();
    });
    $(".box_check_domain .tab").on("click", function () {
        $(".box_check_domain .tab").removeClass("active");
        $(this).addClass("active");
        id = $(this).attr("id");
        $(".box_check_domain .content_tab").removeClass("active");
        $(".box_check_domain #content_" + id).addClass("active");
    });
    /////////////////////////////
    $("#box_pop_confirm .button_cancel").on("click", function () {
        $("#title_confirm").html("");
        $("#button_thuchien").attr("action", "");
        $("#button_thuchien").attr("post_id", "");
        $("#button_thuchien").attr("loai", "");
        $("#box_pop_confirm").hide();
    });
    /////////////////////////////
    $("#box_pop_confirm_action .button_cancel").on("click", function () {
        $("#box_pop_confirm_action .title_confirm").html("");
        $("#button_thuchien_action").attr("action", "");
        $("#button_thuchien_action").attr("post_id", "");
        $("#button_thuchien_action").attr("loai", "");
        $("#box_pop_confirm_action").hide();
    });
    /////////////////////////////
    $("#box_pop_confirm_action_domain .button_cancel").on("click", function () {
        $("#box_pop_confirm_action_domain .title_confirm").html("");
        $("#button_thuchien_action_domain").attr("action", "");
        $("#button_thuchien_action_domain").attr("post_id", "");
        $("#button_thuchien_action_domain").attr("loai", "");
        $("#box_pop_confirm_action_domain").hide();
    });
    /////////////////////////////
    $("#button_thuchien").click(function () {
        id = $("#button_thuchien").attr("post_id");
        loai = $("#button_thuchien").attr("loai");
        action = $("#button_thuchien").attr("action");
        selectedIds = $("#button_thuchien").attr("data-ids");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: action,
                loai: loai,
                id: id,
                "selectedIds[]":
                    typeof selectedIds === "string"
                        ? JSON.parse(selectedIds)
                        : selectedIds,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        // nhatthem114
                        $("#tr_" + id).remove();
                        $("#address_" + id).remove();
                        $("#bank_" + id).remove();
                        if (info.reload == 1) {
                            window.location.reload();
                        }
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("#button_thuchien_action").click(function () {
        $("#button_ok").click();
    });
    /////////////////////////////
    $("#button_thuchien_action_domain").click(function () {
        $("#button_ok_domain").click();
    });
    /////////////////////////////
    $("body").on("click", ".li_noidung", function () {
        noidung = $(this).attr("noidung");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_noidung_nhiemvu",
                noidung: noidung,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".box_pop_xemtruoc").show();
                $(".noidung_xemtruoc .trich").html(info.noidung);
                $(".noidung_xemtruoc #textarea_1").html(info.noidung_share);
                $(".noidung_xemtruoc .minh_hoa").html(info.list_anh);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".mo_nhiemvu", function () {
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        nhiemvu = $(this).attr("nhiemvu");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "mo_nhiemvu",
                nhiemvu: nhiemvu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".hoanthanh_nhiemvu", function () {
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        nhiemvu = $(this).attr("nhiemvu");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "hoanthanh_nhiemvu",
                nhiemvu: nhiemvu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".huy_donhang_drop", function () {
        id = $("#button_thuchien_action").attr("post_id");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "huy_donhang_drop",
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".huy_donhang_socdo", function () {
        id = $("#button_thuchien_action").attr("post_id");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "huy_donhang_socdo",
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            },
        });
    });
    //////////////////////
    $(".check_domain input[name=loai]").on("click", function () {
        loai = $(this).val();
        $(".li_domain input").prop("checked", false);
        if (loai == "all") {
            $(".li_domain").addClass("active");
        } else if (loai == "quocte") {
            $(".li_domain").removeClass("active");
            $(".li_domain_quocte").addClass("active");
        } else if (loai == "vietnam") {
            $(".li_domain").removeClass("active");
            $(".li_domain_vietnam").addClass("active");
        }
    });
    /////////////////////////////
    $("body").on("click", ".apply_subdomain", function () {
        domain = $("input[name=subdomain]").val();
        $(".text_check_subdomain").html(
            '<i class="fa fa-spinner fa-pulse"></i><span> Đang xử lý...</span>'
        );
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "apply_subdomain",
                domain: domain,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".text_check_subdomain").html(info.thongbao);
                if (info.ok == 1) {
                    $(".load_overlay").show();
                    $(".load_process").fadeIn();
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        window.location.reload();
                    }, 3000);
                }
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".button_check_subdomain", function () {
        domain = $("input[name=subdomain]").val();
        if (domain.length < 2) {
            $(".text_check_subdomain").html(
                '<i class="fa fa-warning"></i><span> Vui lòng nhập tên miền..</span>'
            );
            $("input[name=subdomain]").focus();
        } else {
            $(".text_check_subdomain").html(
                '<i class="fa fa-spinner fa-pulse"></i><span> Đang kiểm tra...</span>'
            );
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "check_subdomain",
                    domain: domain,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $(".text_check_subdomain").html(info.thongbao);
                },
            });
        }
    });
    /////////////////////////////
    $("body").on("click", ".set_skin", function () {
        id = $("#button_thuchien_action").attr("post_id");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "set_skin",
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/list-giaodien?step=2";
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".hotro_domain", function () {
        id = $("#button_thuchien_action").attr("post_id");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "hotro_domain",
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".mua_domain", function () {
        domain = $("#button_thuchien_action_domain").attr("post_id");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "mua_domain",
                domain: domain,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        var dulieu = {
                            hd: "notification",
                            bo_phan: "hotro_chung",
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit("user_send_hoatdong", info_chat);
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".mua_seeding", function () {
        id = $("#button_thuchien_action").attr("post_id");
        $(".box_pop").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "mua_seeding",
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("button[name=add_naptien]").on("click", function () {
        sotien = $("input[name=sotien]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "add_naptien",
                sotien: sotien,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/add-naptien?step=2";
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("button[name=button_hoanthanh]").on("click", function () {
        ho_ten = $("input[name=ho_ten]").val();
        dien_thoai = $("input[name=dien_thoai]").val();
        dia_chi = $("input[name=dia_chi]").val();
        ghi_chu = $("textarea[name=ghi_chu]").val();
        tinh = $("select[name=tinh]").val();
        huyen = $("select[name=huyen]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        if (ho_ten == "") {
            $("input[name=ho_ten]").focus();
            $(".load_note").html("Vui lòng nhập họ và tên");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (dien_thoai == "") {
            $("input[name=dien_thoai]").focus();
            $(".load_note").html("Vui lòng nhập số điện thoại");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } /* else if (dia_chi == '') {
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
            var file_data = $("#minh_hoa").prop("files")[0];
            var file_data2 = $("#minh_hoa2").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "hoanthanh_donhang");
            form_data.append("file", file_data);
            form_data.append("file2", file_data2);
            form_data.append("ho_ten", ho_ten);
            form_data.append("dien_thoai", dien_thoai);
            form_data.append("dia_chi", dia_chi);
            form_data.append("ghi_chu", ghi_chu);
            form_data.append("tinh", tinh);
            form_data.append("huyen", huyen);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            if (info.noti == 1) {
                                var dulieu = {
                                    hd: "user_notification",
                                };
                                var info_chat = JSON.stringify(dulieu);
                                socket.emit("user_send_hoatdong", info_chat);
                                var dulieu_admin = {
                                    hd: "notification",
                                    bo_phan: "don_hang",
                                };
                                var info_chat_admin = JSON.stringify(dulieu_admin);
                                socket.emit("user_send_hoatdong", info_chat_admin);
                            }
                            window.location.href = "/ncc/list-donhang-ncc";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=button_hoanthanh_gop]").on("click", function () {
        check_ok = $(this).attr("check_ok");
        if (check_ok == 1) {
            if ($('.box_khach_order[xuly="0"]').length > 0) {
                $(".list_khach_order")
                    .find(".info_khach_order:visible")
                    .parent()
                    .find(".title")
                    .click();
                var box = $('.box_khach_order[xuly="0"]').first();
                box.find(".title").click();
                box.find(".text_xuly").show();
                loai_box = box.attr("loai_box");
                don = box.find(".title .number").html();
                if (loai_box == "khach_san") {
                    ho_ten = box.find("input[name=ho_ten]").val();
                    dien_thoai = box.find("input[name=dien_thoai]").val();
                    dia_chi = box.find("input[name=dia_chi]").val();
                    ghi_chu = box.find("textarea[name=ghi_chu]").val();
                    tinh = box.find("select[name=tinh]").val();
                    huyen = box.find("select[name=huyen]").val();
                    $(".load_overlay").show();
                    $(".load_process").fadeIn();
                    if (ho_ten == "") {
                        box.find("input[name=ho_ten]").focus();
                        box.find(".text_xuly").hide();
                        $(".load_note").html("Vui lòng nhập họ và tên");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (dien_thoai == "") {
                        box.find(".text_xuly").hide();
                        box.find("input[name=dien_thoai]").focus();
                        $(".load_note").html("Vui lòng nhập số điện thoại");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else {
                        var file_data = box.find("#minh_hoa").prop("files")[0];
                        var file_data2 = box.find("#minh_hoa2").prop("files")[0];
                        var form_data = new FormData();
                        form_data.append("action", "hoanthanh_donhang_gop");
                        form_data.append("loai_don", loai_box);
                        form_data.append("don", don);
                        form_data.append("file", file_data);
                        form_data.append("file2", file_data2);
                        form_data.append("ho_ten", ho_ten);
                        form_data.append("dien_thoai", dien_thoai);
                        form_data.append("dia_chi", dia_chi);
                        form_data.append("ghi_chu", ghi_chu);
                        form_data.append("tinh", tinh);
                        form_data.append("huyen", huyen);
                        $(".load_overlay").show();
                        $(".load_process").fadeIn();
                        $.ajax({
                            url: "/ncc/process.php",
                            type: "post",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                setTimeout(function () {
                                    $(".load_note").html(info.thongbao);
                                }, 1000);
                                setTimeout(function () {
                                    $(".load_process").hide();
                                    $(".load_note").html("Hệ thống đang xử lý");
                                    $(".load_overlay").hide();
                                    if (info.ok == 1) {
                                        if (info.noti == 1) {
                                            var dulieu = {
                                                hd: "user_notification",
                                            };
                                            var info_chat = JSON.stringify(dulieu);
                                            socket.emit("user_send_hoatdong", info_chat);
                                            var dulieu_admin = {
                                                hd: "notification",
                                                bo_phan: "don_hang",
                                            };
                                            var info_chat_admin = JSON.stringify(dulieu_admin);
                                            socket.emit("user_send_hoatdong", info_chat_admin);
                                        }
                                        box.attr("xuly", "1");
                                        box.find(".text_xuly").html("Đã hoàn thành");
                                        $("button[name=button_hoanthanh_gop]").click();
                                    } else {
                                    }
                                }, 3000);
                            },
                        });
                    }
                } else {
                    ho_ten = box.find("input[name=ho_ten]").val();
                    dien_thoai = box.find("input[name=dien_thoai]").val();
                    dia_chi = box.find("input[name=dia_chi]").val();
                    ghi_chu = box.find("textarea[name=ghi_chu]").val();
                    tinh = box.find("select[name=tinh]").val();
                    ten_tinh = box.find("select[name=tinh] option:selected").text();
                    huyen = box.find("select[name=huyen]").val();
                    ten_huyen = box.find("select[name=huyen] option:selected").text();
                    xa = box.find("select[name=xa]").val();
                    ten_xa = box.find("select[name=xa] option:selected").text();
                    chiu_ship = box.find("select[name=chiu_ship]").val();
                    congty_ship = box.find("select[name=congty_ship]").val();
                    dichvu_ship = box.find("select[name=dichvu_ship]").val();
                    phi_ship = box
                        .find("select[name=dichvu_ship] option:selected")
                        .attr("phi_ship");
                    cod = box.find("input[name=cod]").val();
                    $(".load_overlay").show();
                    $(".load_process").fadeIn();
                    if (cod == "") {
                        box.find(".text_xuly").hide();
                        box.find("input[name=cod]").focus();
                        $(".load_note").html("Vui lòng nhập COD");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (ho_ten == "") {
                        box.find(".text_xuly").hide();
                        box.find("input[name=ho_ten]").focus();
                        $(".load_note").html("Vui lòng nhập họ và tên");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (dien_thoai == "") {
                        box.find(".text_xuly").hide();
                        box.find("input[name=dien_thoai]").focus();
                        $(".load_note").html("Vui lòng nhập số điện thoại");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (dia_chi == "") {
                        box.find(".text_xuly").hide();
                        box.find("input[name=dia_chi]").focus();
                        $(".load_note").html("Vui lòng nhập địa chỉ");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (tinh == "") {
                        box.find(".text_xuly").hide();
                        $(".load_note").html("Vui lòng chọn tỉnh/thành phố");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (huyen == "") {
                        box.find(".text_xuly").hide();
                        $(".load_note").html("Vui lòng chọn quận/huyện");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (xa == "") {
                        box.find(".text_xuly").hide();
                        $(".load_note").html("Vui lòng chọn xã/phường");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (congty_ship == "") {
                        box.find(".text_xuly").hide();
                        $(".load_note").html("Vui lòng chọn công ty vận chuyển");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else if (dichvu_ship == "") {
                        box.find(".text_xuly").hide();
                        $(".load_note").html("Vui lòng chọn dịch vụ giao hàng");
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    } else {
                        var form_data = new FormData();
                        form_data.append("action", "hoanthanh_donhang_gop");
                        form_data.append("loai_don", loai_box);
                        form_data.append("don", don);
                        form_data.append("ho_ten", ho_ten);
                        form_data.append("dien_thoai", dien_thoai);
                        form_data.append("dia_chi", dia_chi);
                        form_data.append("ghi_chu", ghi_chu);
                        form_data.append("tinh", tinh);
                        form_data.append("huyen", huyen);
                        form_data.append("xa", xa);
                        form_data.append("ten_tinh", ten_tinh);
                        form_data.append("ten_huyen", ten_huyen);
                        form_data.append("ten_xa", ten_xa);
                        form_data.append("chiu_ship", chiu_ship);
                        form_data.append("congty_ship", congty_ship);
                        form_data.append("dichvu_ship", dichvu_ship);
                        form_data.append("phi_ship", phi_ship);
                        form_data.append("cod", cod);
                        $(".load_overlay").show();
                        $(".load_process").fadeIn();
                        $.ajax({
                            url: "/ncc/process.php",
                            type: "post",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                setTimeout(function () {
                                    $(".load_note").html(info.thongbao);
                                }, 1000);
                                setTimeout(function () {
                                    $(".load_process").hide();
                                    $(".load_note").html("Hệ thống đang xử lý");
                                    $(".load_overlay").hide();
                                    if (info.ok == 1) {
                                        if (info.noti == 1) {
                                            var dulieu = {
                                                hd: "user_notification",
                                            };
                                            var info_chat = JSON.stringify(dulieu);
                                            socket.emit("user_send_hoatdong", info_chat);
                                            var dulieu_admin = {
                                                hd: "notification",
                                                bo_phan: "don_hang",
                                            };
                                            var info_chat_admin = JSON.stringify(dulieu_admin);
                                            socket.emit("user_send_hoatdong", info_chat_admin);
                                        }
                                        box.attr("xuly", "1");
                                        box.find(".text_xuly").html("Đã hoàn thành");
                                        $("button[name=button_hoanthanh_gop]").click();
                                    } else {
                                    }
                                }, 3000);
                            },
                        });
                    }
                }
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                var form_data = new FormData();
                form_data.append("action", "del_cart_gop");
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (kq) {
                        setTimeout(function () {
                            $(".load_note").html("Đã hoàn tất xử lý...");
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            window.location.href = "/ncc/";
                        }, 3000);
                    },
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
            $(".box_khach_order").each(function () {
                var div_this = $(this);
                loai_khach = div_this.attr("loai_box");
                if (loai_khach == "khach_san") {
                    tt = div_this.find(".tongtien_don span").html();
                    if (tt == "") {
                        tiep_san = 0;
                    } else {
                        tt = tt.replace(/,|đ/g, "");
                        tong_tiensan += parseInt(tt);
                    }
                } else if (loai_khach == "khach_socdo") {
                    cod = div_this.find("input[name=cod]").val();
                    if (cod == "") {
                        tiep_cod = 0;
                    } else {
                        total_cod += parseInt(cod);
                    }
                    hoa_hong = div_this.find(".hoahong_don span").html();
                    if (hoa_hong == "") {
                    } else {
                        hoa_hong = hoa_hong.replace(/,|đ/g, "");
                        if (hoa_hong < 0) {
                            tong_hoahong += parseInt(hoa_hong);
                        } else {
                        }
                    }
                    phi = div_this.find(".phiship_don").attr("phi");
                    if (phi == "") {
                        tiep_ship = 0;
                    } else {
                        phi_ship += parseInt(phi);
                    }
                }
            });
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            if (tiep_san == 0) {
                setTimeout(function () {
                    $(".load_note").html("Vui lòng chọn sản phẩm cho người nhận");
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 1500);
            } else if (tiep_cod == 0) {
                setTimeout(function () {
                    $(".load_note").html("Vui lòng nhập tiền COD");
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 1500);
            } else if (tiep_ship == 0) {
                setTimeout(function () {
                    $(".load_note").html("Vui lòng chọn dịch vụ giao hàng");
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 1500);
            } else {
                var form_data = new FormData();
                form_data.append("action", "check_ok");
                form_data.append("phi_ship", phi_ship);
                form_data.append("tong_hoahong", tong_hoahong);
                form_data.append("tongtien_san", tong_tiensan);
                form_data.append("total_cod", total_cod);
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            if (info.ok == 0) {
                                $(".load_note").html(info.thongbao);
                            }
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            if (info.ok == 1) {
                                $("button[name=button_hoanthanh_gop]").attr("check_ok", "1");
                                $("button[name=button_hoanthanh_gop]").click();
                            } else {
                            }
                        }, 1500);
                    },
                });
            }
        }
    });
    /////////////////////////////
    $("button[name=button_hoanthanh_ncc]").on("click", function () {
        ho_ten = $("input[name=ho_ten]").val();
        dien_thoai = $("input[name=dien_thoai]").val();
        dia_chi = $("input[name=dia_chi]").val();
        ghi_chu = $("textarea[name=ghi_chu]").val();
        tinh = $("select[name=tinh]").val();
        ten_tinh = $("select[name=tinh] option:selected").text();
        huyen = $("select[name=huyen]").val();
        ten_huyen = $("select[name=huyen] option:selected").text();
        xa = $("select[name=xa]").val();
        ten_xa = $("select[name=xa] option:selected").text();
        chiu_ship = $("select[name=chiu_ship]").val();
        congty_ship = $("select[name=congty_ship]").val();
        dichvu_ship = $("select[name=dichvu_ship]").val();
        phi_ship = $("select[name=dichvu_ship] option:selected").attr("phi_ship");
        cod = $("input[name=cod]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        if (cod == "") {
            $("input[name=cod]").focus();
            $(".load_note").html("Vui lòng nhập COD");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (ho_ten == "") {
            $("input[name=ho_ten]").focus();
            $(".load_note").html("Vui lòng nhập họ và tên");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (dien_thoai == "") {
            $("input[name=dien_thoai]").focus();
            $(".load_note").html("Vui lòng nhập số điện thoại");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (dia_chi == "") {
            $("input[name=dia_chi]").focus();
            $(".load_note").html("Vui lòng nhập địa chỉ");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (tinh == "") {
            $(".load_note").html("Vui lòng chọn tỉnh/thành phố");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (huyen == "") {
            $(".load_note").html("Vui lòng chọn quận/huyện");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (xa == "") {
            $(".load_note").html("Vui lòng chọn xã/phường");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (congty_ship == "") {
            $(".load_note").html("Vui lòng chọn công ty vận chuyển");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (dichvu_ship == "") {
            $(".load_note").html("Vui lòng chọn dịch vụ giao hàng");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else {
            var form_data = new FormData();
            form_data.append("action", "hoanthanh_donhang_ncc");
            form_data.append("ho_ten", ho_ten);
            form_data.append("dien_thoai", dien_thoai);
            form_data.append("dia_chi", dia_chi);
            form_data.append("ghi_chu", ghi_chu);
            form_data.append("tinh", tinh);
            form_data.append("huyen", huyen);
            form_data.append("xa", xa);
            form_data.append("ten_tinh", ten_tinh);
            form_data.append("ten_huyen", ten_huyen);
            form_data.append("ten_xa", ten_xa);
            form_data.append("chiu_ship", chiu_ship);
            form_data.append("congty_ship", congty_ship);
            form_data.append("dichvu_ship", dichvu_ship);
            form_data.append("phi_ship", phi_ship);
            form_data.append("cod", cod);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            if (info.noti == 1) {
                                var dulieu = {
                                    hd: "user_notification",
                                };
                                var info_chat = JSON.stringify(dulieu);
                                socket.emit("user_send_hoatdong", info_chat);
                                var dulieu_admin = {
                                    hd: "notification",
                                    bo_phan: "san_pham",
                                };
                                var info_chat_admin = JSON.stringify(dulieu_admin);
                                socket.emit("user_send_hoatdong", info_chat_admin);
                            }
                            window.location.href = "/ncc/list-donhang-socdo";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("body").on("click", ".dat_ngay", function () {
        if (!$(this).hasClass("disabled")) {
            sp_id = $(this).attr("sp_id");
            size = $(this).attr("size");
            color = $(this).attr("color");
            pl = $(this).attr("pl");
            quantity = 1;
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_to_cart",
                    sp_id: sp_id,
                    size: size,
                    mau: color,
                    pl: pl,
                    quantity: quantity,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            window.location.href = "/ncc/add-donhang-drop?step=2";
                        }, 3000);
                    } else {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_overlay").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                        }, 2000);
                    }
                },
            });
        }
    });
    /////////////////////////////
    $("body").on("click", ".buy_now", function () {
        if (!$(this).hasClass("disabled")) {
            sp_id = $(this).attr("sp_id");
            if ($("input[name=size]").length > 0) {
                size = $("input[name=size]:checked").val();
            } else {
                size = "";
            }
            if ($("input[name=mau]").length > 0) {
                mau = $("input[name=mau]:checked").val();
            } else {
                mau = "";
            }
            if ($("#quantity_view").length > 0) {
                quantity = $("#quantity_view").val();
            } else {
                quantity = 1;
            }
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_to_cart",
                    sp_id: sp_id,
                    size: size,
                    mau: color,
                    pl: pl,
                    quantity: quantity,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            window.location.href = "/ncc/add-donhang-drop?step=2";
                        }, 3000);
                    } else {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_overlay").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                        }, 2000);
                    }
                },
            });
        }
    });
    /////////////////////////////
    $("body").on("click", ".add_to_cart_new", function () {
        if (!$(this).hasClass("disabled")) {
            sp_id = $(this).attr("sp_id");
            size = $(this).attr("size");
            color = $(this).attr("color");
            pl = $(this).attr("pl");
            quantity = 1;
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_to_cart",
                    sp_id: sp_id,
                    size: size,
                    mau: color,
                    pl: pl,
                    quantity: quantity,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".box_shopcart span").html(info.total_cart);
                            $(".load_overlay").hide();
                        }, 2000);
                    } else {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_overlay").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                        }, 2000);
                    }
                },
            });
        }
    });
    /////////////////////////////
    $("body").on("click", ".add_to_cart", function () {
        if (!$(this).hasClass("disabled")) {
            sp_id = $(this).attr("sp_id");
            if ($("input[name=size]").length > 0) {
                size = $("input[name=size]:checked").val();
            } else {
                size = "";
            }
            if ($("input[name=mau]").length > 0) {
                mau = $("input[name=mau]:checked").val();
            } else {
                mau = "";
            }
            if ($("#quantity_view").length > 0) {
                quantity = $("#quantity_view").val();
            } else {
                quantity = 1;
            }
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_to_cart",
                    sp_id: sp_id,
                    size: size,
                    mau: mau,
                    quantity: quantity,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $("#popup-cart").css("display", "block");
                            $("#popup-cart .tbody-popup").html(info.list);
                            $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                            $("#popup-cart .cart-popup-name").html(info.name);
                            $("#popup-cart .cart-popup-count").html(info.total_cart);
                            $(".box_shopcart span").html(info.total_cart);
                        }, 1000);
                    } else {
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_overlay").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                        }, 2000);
                    }
                },
            });
        }
    });
    //////////////////////////
    $(".tbody-popup").on("click", ".remove-item-cart", function () {
        id = $(this).data("id");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "remove_cart",
                sp_id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $("#popup-cart .tbody-popup").html(info.list);
                    $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                    $("#popup-cart .cart-popup-name").html(info.name);
                    $("#popup-cart .cart-popup-count").html(info.total_cart);
                    $(".box_shopcart span").html(info.total_cart);
                } else {
                    $(".load_overlay").hide();
                    $(".modal").hide();
                    $("#popup-cart .tbody-popup").html("");
                    $("#popup-cart .tfoot-popup .total-price").html("");
                    $("#popup-cart .cart-popup-name").html("");
                    $("#popup-cart .cart-popup-count").html("");
                    $(".box_shopcart span").html(info.total_cart);
                }
            },
        });
    });
    //////////////////////////
    $(".tbody-popup").on("click", ".btn-plus", function () {
        id = $(this).parent().parent().find(".remove-item-cart").data("id");
        quantity = $(this).parent().find("input[name=quantity]").val();
        quantity++;
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_cart",
                sp_id: id,
                quantity: quantity,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $("#popup-cart .tbody-popup").html(info.list);
                    $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                    $("#popup-cart .cart-popup-count").html(info.total_cart);
                    $(".box_shopcart span").html(info.total_cart);
                } else {
                    $(".load_overlay").hide();
                    $(".modal").hide();
                    $("#popup-cart .tbody-popup").html("");
                    $("#popup-cart .tfoot-popup .total-price").html("");
                    $("#popup-cart .cart-popup-name").html("");
                    $("#popup-cart .cart-popup-count").html("");
                    $(".box_shopcart span").html(info.total_cart);
                }
            },
        });
    });
    //////////////////////////
    $(".tbody-popup").on("click", ".btn-minus", function () {
        id = $(this).parent().parent().find(".remove-item-cart").data("id");
        quantity = $(this).parent().find("input[name=quantity]").val();
        if (quantity > 1) {
            quantity--;
        } else {
            quantity = 1;
        }
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_cart",
                sp_id: id,
                quantity: quantity,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $("#popup-cart .tbody-popup").html(info.list);
                    $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                    $("#popup-cart .cart-popup-count").html(info.total_cart);
                    $(".box_shopcart span").html(info.total_cart);
                } else {
                    $(".load_overlay").hide();
                    $(".modal").hide();
                    $("#popup-cart .tbody-popup").html("");
                    $("#popup-cart .tfoot-popup .total-price").html("");
                    $("#popup-cart .cart-popup-name").html("");
                    $("#popup-cart .cart-popup-count").html("");
                    $(".box_shopcart span").html(info.total_cart);
                }
            },
        });
    });
    //////////////////////////
    $(".tbody-popup").on("keyup", "input[name=quantity]", function () {
        id = $(this).parent().parent().find(".remove-item-cart").data("id");
        quantity = $(this).val();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_cart",
                sp_id: id,
                quantity: quantity,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.total_cart > 0) {
                    $("#popup-cart .tbody-popup").html(info.list);
                    $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                    $("#popup-cart .cart-popup-count").html(info.total_cart);
                } else {
                    $(".load_overlay").hide();
                    $(".modal").hide();
                    $("#popup-cart .tbody-popup").html("");
                    $("#popup-cart .tfoot-popup .total-price").html("");
                    $("#popup-cart .cart-popup-name").html("");
                    $("#popup-cart .cart-popup-count").html("");
                    $(".box_shopcart span").html(info.total_cart);
                }
            },
        });
    });
    /////////////////////////////
    $(".box_right_content").on("click", ".del_server", function () {
        $(this).parent().remove();
    });
    /////////////////////////////
    $(".box_right_content").on("click", ".add_server", function () {
        $(".block_bottom").before(
            '<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link nguồn</label><input type="text" class="form_control" name="nguon" value="" placeholder="Nhập nguồn dữ liệu..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="button_select_photo">Chọn ảnh</button><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>'
        );
    });
    $(".button_add_info").on("click", function () {
        $(".list_info").append(
            '<div class="li_info"><div class="info_name"><input type="text" name="info_name[]" placeholder="Nhập tên thông tin"></div><div class="info_value"><input type="text" name="info_value[]" placeholder="Nhập giá trị thông tin"></div></div>'
        );
    });
    /////////////////////////////
    $(".mh").click(function () {
        $("#minh_hoa").click();
    });
    $("#minh_hoa").change(function () {
        readURL(this, "preview-minhhoa");
    });
    /////////////////////////////
    $(".mh_popup").click(function () {
        $("#popup").click();
    });
    $("#popup").change(function () {
        readURL(this, "preview-popup");
    });
    /////////////////////////////huyphuc12/05/2025
    const uploadedFiles = [];
    $(".box_profile").on("click", ".button_select_photo", function () {
        total_photo = $(".li_photo").length;

        if (total_photo < 8) {
            $("#photo-add").click();
        } else {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Bạn chỉ được phép chọn tối đa 8 ảnh đa chiều sản phẩm!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
        }
    });
    $("#photo-add").on("change", function () {
        var files = $("input[name=file]")[0].files;
        var form_data = new FormData();
        form_data.append("action", "upload_photo");

        var filesToUpload = [];
        var hasDuplicate = false;

        function isDuplicate(file) {
            return uploadedFiles.some(
                (f) => f.name === file.name && f.size === file.size
            );
        }

        $.each(files, function (i, file) {
            if (isDuplicate(file)) {
                hasDuplicate = true;
            } else {
                filesToUpload.push(file);
            }
        });
        const totalCurrentPhotos = uploadedFiles.length; // Số ảnh đã upload
        const totalNewPhotos = files.length; // Số ảnh vừa chọn
        const totalPhotosAfterUpload = totalCurrentPhotos + totalNewPhotos;
        if (totalPhotosAfterUpload > 8) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Bạn chỉ được phép chọn tối đa 8 ảnh đa chiều sản phẩm!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            $(this).val(""); // Reset input
            return;
        }
        if (hasDuplicate) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Ảnh đa chiều sản phẩm không được phép trùng!");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            $(this).val("");
            return;
        }
        $.each(filesToUpload, function (i, file) {
            form_data.append("file[]", file);
        });

        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        $(".list_photo").append(info.list);
                        $.each(filesToUpload, function (i, file) {
                            uploadedFiles.push({
                                name: file.name,
                                size: file.size,
                            });
                        });
                        console.log(uploadedFiles); // Kiểm tra mảng đã được cập nhật chưa
                    }
                }, 3000);
            },
            error: function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("Lỗi khi upload ảnh.");
            },
        });

        // Reset input
        $(this).val("");
    });
    //
    //huyphuc12/05/2025
    $(document).ready(function () {
        $(".list_photo").on("click", ".fa-close", function () {
            var $photo = $(this).closest(".li_photo");
            var src = $photo.find("img").attr("src");
            var name = $photo.find("img").attr("name_pt");
            var form_data = new FormData();
            form_data.append("src", src);
            form_data.append("action", "delete_photo");
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if (response.ok === 1) {
                        $photo.fadeOut(300, function () {
                            $(this).remove();
                        });
                        // Tìm và xoá phần tử trong uploadedFiles theo src
                        const index = uploadedFiles.findIndex((f) => f.name === name);
                        if (index !== -1) {
                            uploadedFiles.splice(index, 1);
                        }
                    } else {
                        alert(response.thongbao || "Xóa ảnh thất bại!");
                    }
                },
                error: function () {
                    alert("Lỗi kết nối đến server.");
                },
            });
            // uploadedFiles.length = 0;
        });
    });
    /////////////////////////////
    $("body").on("click", "#attachment", function () {
        $("#dinh_kem").click();
    });
    //////////////////////////////
    $("#dinh_kem").on("change", function () {
        var phien = $("#submit_yeucau").attr("phien");
        var user_out = $(".box_chat input[name=user_out]").val();
        if ($("#list_chat .txt").length > 0) {
            sms_id = $("#list_chat .li_sms").last().attr("sms_id");
        } else {
            sms_id = 0;
        }
        var form_data = new FormData();
        form_data.append("action", "upload_dinhkem");
        $.each($("input[name=file]")[0].files, function (i, file) {
            form_data.append("file[]", file);
        });
        form_data.append("phien", phien);
        form_data.append("sms_id", sms_id);
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        $("#list_chat").append(info.list);
                        scrollSmoothToBottom("list_chat");
                        var dulieu = {
                            list_out: info.list_out,
                            list: info.list,
                            phien: phien,
                            loai: "thanh_vien",
                            user_out: info.user_out,
                            thanh_vien: user_out,
                            bo_phan: info.bo_phan,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit("user_send_traodoi", info_chat);
                    }
                }, 3000);
            },
        });
    });
    $(".tieude_seo").on("paste", function (event) {
        if ($(this).hasClass("uncheck_blank")) {
        } else {
            setTimeout(function () {
                check_blank();
            }, 1000);
        }
    });
    $("input[name=slug]").on("keyup", function () {
        slug = $(this).val();
        id = $("input[name=id]").val();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "check_slug",
                slug: slug,
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".check_slug").html(info.thongbao);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".box_sticker .li_tab", function () {
        tab = $(this).attr("id");
        $(".list_sticker_content").removeClass("active");
        $("#" + tab + "_content").addClass("active");
    });
    /////////////////////////////
    $("body").on("click", "#smile", function () {
        $(".box_sticker").toggle();
    });
    /////////////////////////////
    $("body").on("click", ".drop_down button", function () {
        //$('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).parent().find(".drop_menu").is(":visible")) {
            $(this).parent().find(".drop_menu").slideUp("300");
        } else {
            $(this).parent().find(".drop_menu").slideDown("300");
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
    $("body").on(
        "click",
        ".menu_top .menu_top_left .drop_menu .main_menu .list_menu .li_menu .a_main",
        function () {
            $(this).parent().find(".list_menu_sub").toggleClass("active");
            if ($(this).find(".right i").hasClass("fa-plus-square-o")) {
                $(this).find(".right i").removeClass("fa-plus-square-o");
                $(this).find(".right i").addClass("fa-minus-square-o");
            } else {
                $(this).find(".right i").addClass("fa-plus-square-o");
                $(this).find(".right i").removeClass("fa-minus-square-o");
            }
        }
    );
    ///////////////////////////
    $("body").on(
        "click",
        ".menu_top .menu_top_left .drop_menu .main_menu .list_menu .li_menu .list_menu_sub .li_menu_sub .a_sub",
        function () {
            $(this).parent().find(".list_menu_sub_sub").toggleClass("active");
            if ($(this).find(".right i").hasClass("fa-plus-square-o")) {
                $(this).find(".right i").removeClass("fa-plus-square-o");
                $(this).find(".right i").addClass("fa-minus-square-o");
            } else {
                $(this).find(".right i").addClass("fa-plus-square-o");
                $(this).find(".right i").removeClass("fa-minus-square-o");
            }
        }
    );

    // Reset form lọc
    $(".btn-reset").click(function () {
        $('input[type="date"]').val("");
        $(".btn-filter").click();
    });
    $("input[name=input_search_donhang]").keypress(function (e) {
        key = $(this).val();
        if (e.which == 13) {
            if (key.length < 1) {
                $("input[name=key]").focus();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "timkiem_donhang",
                        key: key,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            if (info.ok == 1) {
                                $(".list_baiviet tr:not(:first)").remove();
                                $(".list_baiviet tr:first").after(info.list);
                            } else {
                            }
                        }, 1000);
                    },
                });
            }
        }
    });
    $("input[name=input_search_donhang_socdo]").keypress(function (e) {
        key = $(this).val();
        if (e.which == 13) {
            if (key.length < 1) {
                $("input[name=input_search_donhang_socdo]").focus();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "timkiem_donhang_socdo",
                        key: key,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            if (info.ok == 1) {
                                $(".list_baiviet tr:not(:first)").remove();
                                $(".list_baiviet tr:first").after(info.list);
                            } else {
                            }
                        }, 1000);
                    },
                });
            }
        }
    });
    $("input[name=input_search_donhang_ncc]").keypress(function (e) {
        key = $(this).val();
        if (e.which == 13) {
            if (key.length < 1) {
                $("input[name=input_search_donhang_ncc]").focus();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "timkiem_donhang_ncc",
                        key: key,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            if (info.ok == 1) {
                                $(".list_baiviet tr:not(:first)").remove();
                                $(".list_baiviet tr:first").after(info.list);
                            } else {
                            }
                        }, 1000);
                    },
                });
            }
        }
    });
    $("input[name=key]").keypress(function (e) {
        if ($(".button_timkiem[kieu=mobile]").length > 0) {
            kieu = "mobile";
        } else {
            kieu = "laptop";
        }
        if (e.which == 13) {
            key = $("input[name=key]").val();
            if ($("button[name=timkiem_sanpham]").length > 0) {
                action = "timkiem_sanpham";
            } else if ($("button[name=timkiem_sanpham_shop]").length > 0) {
                action = "timkiem_sanpham_shop";
            } else if ($("button[name=timkiem_sanpham_follow]").length > 0) {
                action = "timkiem_sanpham_follow";
            } else if ($("button[name=timkiem_sanpham_trend]").length > 0) {
                action = "timkiem_sanpham_trend";
            } else if ($("button[name=timkiem_sanpham_tuan]").length > 0) {
                action = "timkiem_sanpham_tuan";
            } else if ($("button[name=timkiem_sanpham_hethang]").length > 0) {
                action = "timkiem_sanpham_hethang";
            } else if ($("button[name=timkiem_bom]").length > 0) {
                action = "timkiem_bom";
            } else if ($("button[name=timkiem_thanhvien]").length > 0) {
                action = "timkiem_thanhvien";
            } else if ($("button[name=timkiem_link_affiliate]").length > 0) {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("key", key);
                history.replaceState(null, null, "?" + queryParams.toString());
                url = window.location.href;
                url = removeURLParameter(url, "page");
                queryParams.set("page", 1);
                window.location.href = url;
            }
            if (key.length < 1) {
                $("input[name=key]").focus();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: action,
                        key: key,
                        kieu: kieu,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            if (info.ok == 1) {
                                if (info.kieu == "mobile") {
                                    $(".list_sanpham").html(info.list);
                                } else {
                                    $(".list_baiviet").html(info.list);
                                }
                                $(".pagination").hide();
                                $(".load_sanpham").hide();
                                if (action == "timkiem_sanpham_tuan") {
                                    var currentDate = new Date(),
                                        finished = false,
                                        availiableExamples = {
                                            set5ngay: 15 * 24 * 60 * 60 * 1000,
                                            set5phut: 5 * 60 * 1000,
                                            set1phut: 1 * 10 * 1000,
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
                                                $this.find("." + event.type).html(event.value);
                                                if (finished) {
                                                    $this.fadeTo(0, 1);
                                                    finished = false;
                                                }
                                                break;
                                            case "finished":
                                                status = $this.attr("status");
                                                if (status == 0) {
                                                    $this.find(".text_time").html("Kết thúc sau:");
                                                    con = $this.attr("thoigian") * 1000;
                                                    $this.countdown(
                                                        con + currentDate.valueOf(),
                                                        call_flash
                                                    );
                                                    $this.attr("status", 1);
                                                } else {
                                                    $this.fadeTo("slow", 0.5);
                                                    $this.html("Đã kết thúc");
                                                    finished = true;
                                                }
                                                break;
                                        }
                                    }
                                    $(".count_down").each(function () {
                                        con = $(this).attr("time") * 1000;
                                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                                    });
                                }
                            } else {
                            }
                        }, 1000);
                    },
                });
            }
        }
    });
    $("input[name=key_hieu]").keypress(function (e) {
        if ($(".button_timkiem[kieu=mobile]").length > 0) {
            kieu = "mobile";
        } else {
            kieu = "laptop";
        }
        if (e.which == 13) {
            key = $("input[name=key_hieu]").val();
            if ($("button[name=timkiem_sanpham]").length > 0) {
                action = "timkiem_sanpham";
            } else if ($("button[name=timkiem_sanpham_drop_hieu]").length > 0) {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("key", key);
                history.replaceState(null, null, "?" + queryParams.toString());
                url = window.location.href;
                url = removeURLParameter(url, "page");
                queryParams.set("page", 1);
                window.location.href = url;
            } else if ($("button[name=timkiem_sanpham_shop]").length > 0) {
                action = "timkiem_sanpham_shop";
            } else if ($("button[name=timkiem_sanpham_follow]").length > 0) {
                action = "timkiem_sanpham_follow";
            } else if ($("button[name=timkiem_sanpham_trend]").length > 0) {
                action = "timkiem_sanpham_trend";
            } else if ($("button[name=timkiem_sanpham_tuan]").length > 0) {
                action = "timkiem_sanpham_tuan";
            } else if ($("button[name=timkiem_sanpham_hethang]").length > 0) {
                action = "timkiem_sanpham_hethang";
            } else if ($("button[name=timkiem_bom]").length > 0) {
                action = "timkiem_bom";
            } else if ($("button[name=timkiem_thanhvien]").length > 0) {
                action = "timkiem_thanhvien";
            } else if ($("button[name=timkiem_link_affiliate]").length > 0) {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("key", key);
                history.replaceState(null, null, "?" + queryParams.toString());
                url = window.location.href;
                url = removeURLParameter(url, "page");
                queryParams.set("page", 1);
                window.location.href = url;
            }
            if (key.length < 1) {
                $("input[name=key_hieu]").focus();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: action,
                        key: key,
                        kieu: kieu,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            if (info.ok == 1) {
                                if (info.kieu == "mobile") {
                                    $(".list_sanpham").html(info.list);
                                } else {
                                    $(".list_baiviet").html(info.list);
                                }
                                $(".pagination").hide();
                                $(".load_sanpham").hide();
                                if (action == "timkiem_sanpham_tuan") {
                                    var currentDate = new Date(),
                                        finished = false,
                                        availiableExamples = {
                                            set5ngay: 15 * 24 * 60 * 60 * 1000,
                                            set5phut: 5 * 60 * 1000,
                                            set1phut: 1 * 10 * 1000,
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
                                                $this.find("." + event.type).html(event.value);
                                                if (finished) {
                                                    $this.fadeTo(0, 1);
                                                    finished = false;
                                                }
                                                break;
                                            case "finished":
                                                status = $this.attr("status");
                                                if (status == 0) {
                                                    $this.find(".text_time").html("Kết thúc sau:");
                                                    con = $this.attr("thoigian") * 1000;
                                                    $this.countdown(
                                                        con + currentDate.valueOf(),
                                                        call_flash
                                                    );
                                                    $this.attr("status", 1);
                                                } else {
                                                    $this.fadeTo("slow", 0.5);
                                                    $this.html("Đã kết thúc");
                                                    finished = true;
                                                }
                                                break;
                                        }
                                    }
                                    $(".count_down").each(function () {
                                        con = $(this).attr("time") * 1000;
                                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                                    });
                                }
                            } else {
                            }
                        }, 1000);
                    },
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
                  url: '/ncc/process.php',
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
    $("#timkiem_thuonghieu_add").on("change", function () {
        thuong_hieu = $(this).val();
        kieu = $(".button_timkiem").attr("kieu");
        $(".pagination").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "timkiem_sanpham_thuonghieu_add",
                thuong_hieu: thuong_hieu,
                kieu: kieu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        if (info.kieu == "mobile") {
                            $(".list_sanpham").html(info.list);
                        } else {
                            $(".list_baiviet").html(info.list);
                        }
                        $(".load_sanpham").hide();
                    } else {
                    }
                }, 1000);
            },
        });
    });
    $("#timkiem_thuonghieu_trend").on("change", function () {
        kieu = $(".button_timkiem").attr("kieu");
        thuong_hieu = $(this).val();
        $(".pagination").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "timkiem_sanpham_thuonghieu_trend",
                thuong_hieu: thuong_hieu,
                kieu: kieu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        if (info.kieu == "mobile") {
                            $(".list_sanpham").html(info.list);
                        } else {
                            $(".list_baiviet").html(info.list);
                        }
                        $(".load_sanpham").hide();
                    } else {
                    }
                }, 1000);
            },
        });
    });
    $("#timkiem_thuonghieu_tuan").on("change", function () {
        thuong_hieu = $(this).val();
        $(".pagination").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "timkiem_sanpham_thuonghieu_tuan",
                thuong_hieu: thuong_hieu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        $(".list_baiviet").html(info.list);
                        $(".load_sanpham").hide();
                        var currentDate = new Date(),
                            finished = false,
                            availiableExamples = {
                                set5ngay: 15 * 24 * 60 * 60 * 1000,
                                set5phut: 5 * 60 * 1000,
                                set1phut: 1 * 10 * 1000,
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
                                    $this.find("." + event.type).html(event.value);
                                    if (finished) {
                                        $this.fadeTo(0, 1);
                                        finished = false;
                                    }
                                    break;
                                case "finished":
                                    status = $this.attr("status");
                                    if (status == 0) {
                                        $this.find(".text_time").html("Kết thúc sau:");
                                        con = $this.attr("thoigian") * 1000;
                                        $this.countdown(con + currentDate.valueOf(), call_flash);
                                        $this.attr("status", 1);
                                    } else {
                                        $this.fadeTo("slow", 0.5);
                                        $this.html("Đã kết thúc");
                                        finished = true;
                                    }
                                    break;
                            }
                        }
                        $(".count_down").each(function () {
                            con = $(this).attr("time") * 1000;
                            $(this).countdown(con + currentDate.valueOf(), call_flash);
                        });
                    } else {
                    }
                }, 1000);
            },
        });
    });
    $(".button_timkiem").on("click", function () {
        if ($(".button_timkiem[kieu=mobile]").length > 0) {
            kieu = "mobile";
        } else {
            kieu = "laptop";
        }
        key = $("input[name=key]").val();
        if ($("button[name=timkiem_sanpham]").length > 0) {
            action = "timkiem_sanpham";
        } else if ($("button[name=timkiem_sanpham_shop]").length > 0) {
            action = "timkiem_sanpham_shop";
        } else if ($("button[name=timkiem_sanpham_follow]").length > 0) {
            action = "timkiem_sanpham_follow";
        } else if ($("button[name=timkiem_sanpham_trend]").length > 0) {
            action = "timkiem_sanpham_trend";
        } else if ($("button[name=timkiem_sanpham_tuan]").length > 0) {
            action = "timkiem_sanpham_tuan";
        } else if ($("button[name=timkiem_bom]").length > 0) {
            action = "timkiem_bom";
        } else if ($("button[name=timkiem_thanhviennhom]").length > 0) {
            action = "timkiem_thanhviennhom";
        } else if ($("button[name=timkiem_thanhvien]").length > 0) {
            action = "timkiem_thanhvien";
        } else if ($("button[name=timkiem_link_affiliate]").length > 0) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("key", key);
            history.replaceState(null, null, "?" + queryParams.toString());
            url = window.location.href;
            url = removeURLParameter(url, "page");
            queryParams.set("page", 1);
            window.location.href = url;
        }
        if (key.length < 1) {
            $("input[name=key]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: action,
                    key: key,
                    kieu: kieu,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 500);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            if (info.kieu == "mobile") {
                                $(".list_sanpham").html(info.list);
                            } else {
                                $(".list_baiviet").html(info.list);
                            }
                            $(".load_sanpham").hide();
                            if (action == "timkiem_sanpham_tuan") {
                                var currentDate = new Date(),
                                    finished = false,
                                    availiableExamples = {
                                        set5ngay: 15 * 24 * 60 * 60 * 1000,
                                        set5phut: 5 * 60 * 1000,
                                        set1phut: 1 * 10 * 1000,
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
                                            $this.find("." + event.type).html(event.value);
                                            if (finished) {
                                                $this.fadeTo(0, 1);
                                                finished = false;
                                            }
                                            break;
                                        case "finished":
                                            status = $this.attr("status");
                                            if (status == 0) {
                                                $this.find(".text_time").html("Kết thúc sau:");
                                                con = $this.attr("thoigian") * 1000;
                                                $this.countdown(
                                                    con + currentDate.valueOf(),
                                                    call_flash
                                                );
                                                $this.attr("status", 1);
                                            } else {
                                                $this.fadeTo("slow", 0.5);
                                                $this.html("Đã kết thúc");
                                                finished = true;
                                            }
                                            break;
                                    }
                                }
                                $(".count_down").each(function () {
                                    con = $(this).attr("time") * 1000;
                                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                                });
                            }
                        } else {
                        }
                    }, 1000);
                },
            });
        }
    });
    $(".button_timkiem_hieu").on("click", function () {
        if ($(".button_timkiem[kieu=mobile]").length > 0) {
            kieu = "mobile";
        } else {
            kieu = "laptop";
        }
        key = $("input[name=key_hieu]").val();
        if ($("button[name=timkiem_sanpham]").length > 0) {
            action = "timkiem_sanpham";
        } else if ($("button[name=timkiem_sanpham_drop_hieu]").length > 0) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("key", key);
            history.replaceState(null, null, "?" + queryParams.toString());
            url = window.location.href;
            url = removeURLParameter(url, "page");
            queryParams.set("page", 1);
            window.location.href = url;
        } else if ($("button[name=timkiem_sanpham_shop]").length > 0) {
            action = "timkiem_sanpham_shop";
        } else if ($("button[name=timkiem_sanpham_follow]").length > 0) {
            action = "timkiem_sanpham_follow";
        } else if ($("button[name=timkiem_sanpham_trend]").length > 0) {
            action = "timkiem_sanpham_trend";
        } else if ($("button[name=timkiem_sanpham_tuan]").length > 0) {
            action = "timkiem_sanpham_tuan";
        } else if ($("button[name=timkiem_bom]").length > 0) {
            action = "timkiem_bom";
        } else if ($("button[name=timkiem_thanhviennhom]").length > 0) {
            action = "timkiem_thanhviennhom";
        } else if ($("button[name=timkiem_thanhvien]").length > 0) {
            action = "timkiem_thanhvien";
        } else if ($("button[name=timkiem_link_affiliate]").length > 0) {
            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("key", key);
            history.replaceState(null, null, "?" + queryParams.toString());
            url = window.location.href;
            url = removeURLParameter(url, "page");
            queryParams.set("page", 1);
            window.location.href = url;
        }
        if (key.length < 1) {
            $("input[name=key_hieu]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: action,
                    key: key,
                    kieu: kieu,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 500);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            if (info.kieu == "mobile") {
                                $(".list_sanpham").html(info.list);
                            } else {
                                $(".list_baiviet").html(info.list);
                            }
                            $(".load_sanpham").hide();
                            if (action == "timkiem_sanpham_tuan") {
                                var currentDate = new Date(),
                                    finished = false,
                                    availiableExamples = {
                                        set5ngay: 15 * 24 * 60 * 60 * 1000,
                                        set5phut: 5 * 60 * 1000,
                                        set1phut: 1 * 10 * 1000,
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
                                            $this.find("." + event.type).html(event.value);
                                            if (finished) {
                                                $this.fadeTo(0, 1);
                                                finished = false;
                                            }
                                            break;
                                        case "finished":
                                            status = $this.attr("status");
                                            if (status == 0) {
                                                $this.find(".text_time").html("Kết thúc sau:");
                                                con = $this.attr("thoigian") * 1000;
                                                $this.countdown(
                                                    con + currentDate.valueOf(),
                                                    call_flash
                                                );
                                                $this.attr("status", 1);
                                            } else {
                                                $this.fadeTo("slow", 0.5);
                                                $this.html("Đã kết thúc");
                                                finished = true;
                                            }
                                            break;
                                    }
                                }
                                $(".count_down").each(function () {
                                    con = $(this).attr("time") * 1000;
                                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                                });
                            }
                        } else {
                        }
                    }, 1000);
                },
            });
        }
    });

    $("button[name=add_size]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        thu_tu = $("input[name=thu_tu]").val();
        if (tieu_de.length < 1) {
            $("input[name=tieu_de]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_size",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_size]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        thu_tu = $("input[name=thu_tu]").val();
        id = $("input[name=id]").val();
        if (tieu_de.length < 1) {
            $("input[name=tieu_de]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "edit_size",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-size";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });

    /////////////////////////////
    // $('button[name=add_brand]').on('click', function () {
    //     tieu_de = $('input[name=tieu_de]').val();
    //     thu_tu = $('input[name=thu_tu]').val();
    //     if (tieu_de.length < 2) {
    //         $('input[name=tieu_de]').focus();
    //     } else {
    //         $('.load_overlay').show();
    //         $('.load_process').fadeIn();
    //         $.ajax({
    //             url: "/ncc/process.php",
    //             type: "post",
    //             data: {
    //                 action: "add_brand",
    //                 tieu_de: tieu_de,
    //                 thu_tu: thu_tu
    //             },
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
    //                         window.location.reload();
    //                     } else {

    //                     }
    //                 }, 3000);
    //             }

    //         });
    //     }
    // });
    // Xử lý khi nhấn nút Thêm
    $("button[name=add_brand]").on("click", function () {
        var tieu_de = $("input[name=tieu_de]").val();
        var thu_tu = $("input[name=thu_tu]").val();
        var id_thuonghieu_socdo = $("input[name=id_thuonghieu_socdo]").val();
        var brand = $('input[name="brand[]"]').val();
        if (tieu_de.length < 2) {
            $("input[name=tieu_de]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_brand",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
                    brand: brand,
                    id_thuonghieu_socdo: id_thuonghieu_socdo,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_brand]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        thu_tu = $("input[name=thu_tu]").val();
        id = $("input[name=id]").val();
        if (tieu_de.length < 2) {
            $("input[name=tieu_de]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "edit_brand",
                    tieu_de: tieu_de,
                    thu_tu: thu_tu,
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-brand";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("#ckOk").on("click", function () {
        if ($("#ckOk").is(":checked")) {
            $("#lbtSubmit").attr("disabled", false);
        } else {
            $("#lbtSubmit").attr("disabled", true);
        }
    });
    /////////////////////////////
    $("#txbQuery").keypress(function (e) {
        if (e.which == 13) {
            key = $("#txbQuery").val();
            type = $("input[name=search_type]:checked").val();
            link =
                "/tim-kiem.html?type=" +
                type +
                "&q=" +
                encodeURI(key).replace(/%20/g, "+");
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////////////
    $(".show_add_marketing").on("click", function () {
        window.location.href = "/ncc/add-remarketing";
    });
    //////////////////
    $("#btnSearch").on("click", function () {
        key = $("#txbQuery").val();
        type = $("input[name=search_type]:checked").val();
        link =
            "/tim-kiem.html?type=" +
            type +
            "&q=" +
            encodeURI(key).replace(/%20/g, "+");
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $(".panel-lyrics .panel-heading").on("click", function () {
        var t = $(this);
        var p = $(this).parent().find(".panel-collapse");
        if (t.hasClass("active-panel")) {
            $(this).parent().find(".panel-collapse").slideUp();
        } else {
            $(this).parent().find(".panel-collapse").slideDown();
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
        $(this).toggleClass("active-panel");
    });
    /////////////////////////////
    $(".item-cat a").on("click", function () {
        $(this).parent().find("div").click();
    });
    /////////////////////////////
    $(".remember").on("click", function () {
        value = $(this).attr("value");
        if (value == "on") {
            $(".remember i").removeClass("fa-check-circle-o");
            $(".remember i").addClass("fa-circle-o");
            $(this).attr("value", "off");
        } else {
            $(".remember i").removeClass("fa-circle-o");
            $(".remember i").addClass("fa-check-circle-o");
            $(this).attr("value", "on");
        }
    });
    /////////////////////////////
    $(".li_photo i").on("click", function () {
        var item = $(this);
        anh = item.parent().find("img").attr("src");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "del_photo",
                anh: anh,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                item.parent().parent().remove();
            },
        });
    });
    /////////////////////////////
    $(".drop_status input[type=radio]").on("click", function () {
        status = $(this).val();
        user_id = $(this).attr("name");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_drop",
                user_id: user_id,
                status: status,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
            },
        });
    });
    /////////////////////////////
    $(".load_sanpham button").on("click", function () {
        page = $(this).attr("page");
        kieu = $(".button_timkiem").attr("kieu");
        $(this).html("Đang tải...");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_sanpham",
                page: page,
                kieu: kieu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".load_sanpham button").html("Tải thêm");
                $(".load_sanpham button").attr("page", info.page);
                if (info.kieu == "mobile") {
                    $(".list_sanpham").append(info.list);
                } else {
                    $(".list_baiviet tr:last").after(info.list);
                }
                if (info.list == null) {
                    $(".load_sanpham button").hide();
                }
            },
        });
    });
    /////////////////////////////
    $(".load_sanpham_trend button").on("click", function () {
        page = $(this).attr("page");
        kieu = $(".button_timkiem").attr("kieu");
        $(this).html("Đang tải...");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_sanpham_trend",
                page: page,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".load_sanpham_trend button").html("Tải thêm");
                $(".load_sanpham_trend button").attr("page", info.page);
                if (info.kieu == "mobile") {
                    $(".list_sanpham").append(info.list);
                } else {
                    $(".list_baiviet tr:last").after(info.list);
                }
                if (info.list == null) {
                    $(".load_sanpham_trend button").hide();
                }
            },
        });
    });
    /////////////////////////////
    $(".load_sanpham_tuan button").on("click", function () {
        page = $(this).attr("page");
        $(this).html("Đang tải...");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_sanpham_tuan",
                page: page,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".load_sanpham_tuan button").html("Tải thêm");
                $(".load_sanpham_tuan button").attr("page", info.page);
                $(".list_baiviet tr:last").after(info.list);
                if (info.list == null) {
                    $(".load_sanpham_tuan button").hide();
                } else {
                    var currentDate = new Date(),
                        finished = false,
                        availiableExamples = {
                            set5ngay: 15 * 24 * 60 * 60 * 1000,
                            set5phut: 5 * 60 * 1000,
                            set1phut: 1 * 10 * 1000,
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
                                $this.find("." + event.type).html(event.value);
                                if (finished) {
                                    $this.fadeTo(0, 1);
                                    finished = false;
                                }
                                break;
                            case "finished":
                                status = $this.attr("status");
                                if (status == 0) {
                                    $this.find(".text_time").html("Kết thúc sau:");
                                    con = $this.attr("thoigian") * 1000;
                                    $this.countdown(con + currentDate.valueOf(), call_flash);
                                    $this.attr("status", 1);
                                } else {
                                    $this.fadeTo("slow", 0.5);
                                    $this.html("Đã kết thúc");
                                    finished = true;
                                }
                                break;
                        }
                    }
                    $(".count_down").each(function () {
                        con = $(this).attr("time") * 1000;
                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                    });
                }
            },
        });
    });
    /////////////////////////////
    $("button[name=add_bom]").on("click", function () {
        ho_ten = $("input[name=ho_ten]").val();
        dien_thoai = $("input[name=dien_thoai]").val();
        dia_chi = $("input[name=dia_chi]").val();
        tinh_trang = $("textarea[name=tinh_trang]").val();
        if (ho_ten.length < 2) {
            $("input[name=ho_ten]").focus();
        } else if (dien_thoai.length < 2) {
            $("input[name=dien_thoai]").focus();
        } else if (dia_chi.length < 2) {
            $("input[name=dia_chi]").focus();
        } else if (tinh_trang.length < 2) {
            $("textarea[name=tinh_trang]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_bom",
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh_trang: tinh_trang,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_bom]").on("click", function () {
        ho_ten = $("input[name=ho_ten]").val();
        dien_thoai = $("input[name=dien_thoai]").val();
        dia_chi = $("input[name=dia_chi]").val();
        tinh_trang = $("textarea[name=tinh_trang]").val();
        id = $("input[name=id]").val();
        if (ho_ten.length < 2) {
            $("input[name=ho_ten]").focus();
        } else if (dien_thoai.length < 2) {
            $("input[name=dien_thoai]").focus();
        } else if (dia_chi.length < 2) {
            $("input[name=dia_chi]").focus();
        } else if (tinh_trang.length < 2) {
            $("textarea[name=tinh_trang]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "edit_bom",
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    dia_chi: dia_chi,
                    tinh_trang: tinh_trang,
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });

    $(".select_nguoinhan").on("click", function () {
        $(".box_select_nguoinhan .box_list").html(
            '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        $(".box_select_nguoinhan").show();
        $(".box_select_nguoinhan .box_bottom button").attr("loai", "sub_product");
        var member_id = "";
        $(".list_nguoinhan .li_member").each(function () {
            member_id += $(this).attr("user") + ",";
        });
        setTimeout(function () {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_nguoinhan",
                    list_id: member_id,
                    page: 1,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $(".box_select_nguoinhan .box_list").html(info.list);
                    $(".box_select_nguoinhan .box_list").attr("page", info.page);
                    $(".box_select_nguoinhan .box_list").attr("tiep", info.tiep);
                    $(".box_select_nguoinhan .box_list").attr("loaded", 1);
                },
            });
        }, 1000);
    });
    ////////////////////////
    $(".box_select_nguoinhan .box_list").on("scroll", function () {
        if (
            $(this).scrollTop() + $(this).innerHeight() >=
            $(this)[0].scrollHeight
        ) {
            tiep = $(".box_select_nguoinhan .box_list").attr("tiep");
            page = $(".box_select_nguoinhan .box_list").attr("page");
            loaded = $(".box_select_nguoinhan .box_list").attr("loaded");
            key = $(".box_select_nguoinhan input[name=key_member]").val();
            var member_id = "";
            $(".list_nguoinhan .li_member").each(function () {
                member_id += $(this).attr("user") + ",";
            });
            if (loaded == 1 && tiep == 1 && page != 1 && key == "") {
                $(".box_select_nguoinhan .box_list").append(
                    '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                $(".box_select_nguoinhan .box_list").attr("loaded", 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "load_nguoinhan",
                            list_id: member_id,
                            key: key,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $(".box_select_nguoinhan .box_list .loading_product").remove();
                            $(".box_select_nguoinhan .box_list").append(info.list);
                            $(".box_select_nguoinhan .box_list").attr("page", info.page);
                            $(".box_select_nguoinhan .box_list").attr("tiep", info.tiep);
                            $(".box_select_nguoinhan .box_list").attr("loaded", 1);
                        },
                    });
                }, 1000);
            }
        }
    });
    ///////////////////
    $(".box_select_nguoinhan .box_title .fa").on("click", function () {
        $(".box_select_nguoinhan").hide();
        $(".box_select_nguoinhan .box_list").html("");
        $(".box_select_nguoinhan .box_list").attr("page", 1);
        $(".box_select_nguoinhan input[name=key_member]").val("");
    });
    $(".box_select_nguoinhan").on("click", ".action button", function () {
        var button = $(this);
        user_id = $(this).attr("user");
        username = $(this).attr("username");
        $(".list_nguoinhan").append(
            '<div class="li_member ' +
            username +
            '" user="' +
            user_id +
            '">' +
            username +
            ' <i class="fa fa-close"></i>'
        );
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(".list_nguoinhan ." + username).remove();
        } else {
            $(this).addClass("active");
        }
    });
    $(".list_nguoinhan").on("click", ".li_member i", function () {
        $(this).parent().remove();
    });
    $(".box_select_nguoinhan .search_member").on("click", function () {
        key = $(".box_select_nguoinhan input[name=key_member]").val();
        var member_id = "";
        $(".list_nguoinhan .li_member").each(function () {
            member_id += $(this).attr("user") + ",";
        });
        if (key.length < 1) {
            $(".box_select_nguoinhan input[name=key_member]").focus();
        } else {
            $(".box_select_nguoinhan .box_list").html(
                '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
            );
            setTimeout(function () {
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "load_nguoinhan",
                        list_id: member_id,
                        key: key,
                        page: 1,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $(".box_select_nguoinhan .box_list .loading_product").remove();
                        $(".box_select_nguoinhan .box_list").append(info.list);
                        $(".box_select_nguoinhan .box_list").attr("page", info.page);
                        $(".box_select_nguoinhan .box_list").attr("tiep", info.tiep);
                        $(".box_select_nguoinhan .box_list").attr("loaded", 1);
                    },
                });
            }, 1000);
        }
    });
    $(".box_select_nguoinhan input[name=key_member]").keypress(function (e) {
        if (e.which == 13) {
            key = $(".box_select_nguoinhan input[name=key_member]").val();
            var member_id = "";
            $(".list_nguoinhan .li_member").each(function () {
                member_id += $(this).attr("user") + ",";
            });
            if (key.length < 1) {
                $(".box_select_nguoinhan input[name=key_member]").focus();
            } else {
                $(".box_select_nguoinhan .box_list").html(
                    '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
                );
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "load_nguoinhan",
                            key: key,
                            page: 1,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $(".box_select_nguoinhan .box_list .loading_product").remove();
                            $(".box_select_nguoinhan .box_list").append(info.list);
                            $(".box_select_nguoinhan .box_list").attr("page", info.page);
                            $(".box_select_nguoinhan .box_list").attr("tiep", info.tiep);
                            $(".box_select_nguoinhan .box_list").attr("loaded", 1);
                        },
                    });
                }, 1000);
            }
        }
    });

    /////////////////////////////
    $("button[name=add_remarketing]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        pop = $("input[name=pop]:checked").val();
        noidung = tinyMCE.get("edit_textarea").getContent();
        var member_id = "";
        $(".list_nguoinhan .li_member").each(function () {
            member_id += $(this).attr("user") + ",";
        });
        if (tieu_de.length < 3) {
            $("input[name=tieu_de]").focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn hình minh họa");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                var top_minhhoa = $("#preview-minhhoa").offset().top;
                $("html,body")
                    .stop()
                    .animate(
                        { scrollTop: top_minhhoa - 150 },
                        500,
                        "swing",
                        function () { }
                    );
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var pop_data = $("#popup").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "add_remarketing");
            form_data.append("file", file_data);
            form_data.append("file_popup", pop_data);
            form_data.append("tieu_de", tieu_de);
            form_data.append("member_id", member_id);
            form_data.append("pop", pop);
            form_data.append("noidung", noidung);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_remarketing]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        id = $("input[name=id]").val();
        pop = $("input[name=pop]:checked").val();
        noidung = tinyMCE.get("edit_textarea").getContent();
        var member_id = "";
        $(".list_nguoinhan .li_member").each(function () {
            member_id += $(this).attr("user") + ",";
        });
        if (tieu_de.length < 3) {
            $("input[name=tieu_de]").focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var pop_data = $("#popup").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "edit_remarketing");
            form_data.append("file", file_data);
            form_data.append("file_popup", pop_data);
            form_data.append("tieu_de", tieu_de);
            form_data.append("member_id", member_id);
            form_data.append("pop", pop);
            form_data.append("noidung", noidung);
            form_data.append("id", id);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    $("button[name=add_coupon]").on("click", function () {
        // Get form values
        let ma = $("input[name=ma]").val();
        let loai = $("select[name=loai]").val();
        let kieu = $("select[name=apdung]").val();
        let giam = $("input[name=giam]")
            .val()
            .replace(/[^0-9]/g, "");
        let min_price = $("input[name=min_price]")
            .val()
            .replace(/[^0-9]/g, "");
        let max_price = $("input[name=max_price]")
            .val()
            .replace(/[^0-9]/g, "");
        let allow_combination = $("input[name=allow_combination]").is(":checked")
            ? 1
            : 0;
        let max_uses_per_user = $("input[name=max_uses_per_user]")
            .val()
            .replace(/[^0-9]/g, "");
        let max_global_uses = $("input[name=max_global_uses]")
            .val()
            .replace(/[^0-9]/g, "");
        let time_start = $("input[name=time_start]").val();
        let date_start = $("input[name=date_start]").val();
        let time_expired = $("input[name=time_expired]").val();
        let date_expired = $("input[name=date_expired]").val();
        let main_product = "";
        $("#list_product_main .li_product").each(function () {
            main_product += $(this).attr("sp") + ",";
        });

        // Validations
        let error = "";

        // Validate coupon code
        if (ma.length !== 5) {
            error = "Mã coupon phải đúng 5 ký tự";
            $("input[name=ma]").focus();
        }
        // Validate discount value
        else if (!giam || parseInt(giam) <= 0) {
            error = "Giá trị khuyến mại phải lớn hơn 0";
            $("input[name=giam]").focus();
        }
        // Validate percentage discount (max 100%)
        else if (loai === "phantram" && parseInt(giam) > 100) {
            error = "Khuyến mại phần trăm không được vượt quá 100%";
            $("input[name=giam]").focus();
        }
        // Validate min/max price
        else if (
            min_price &&
            max_price &&
            parseInt(min_price) >= parseInt(max_price)
        ) {
            error = "Giá trị đơn hàng tối thiểu phải nhỏ hơn giá trị tối đa";
            $("input[name=min_price]").focus();
        }
        // Validate discount vs max price for fixed amount
        else if (
            loai === "tru" &&
            max_price &&
            parseInt(giam) >= parseInt(max_price)
        ) {
            error = "Giá trị khuyến mại không được lớn hơn giá trị đơn hàng tối đa";
            $("input[name=giam]").focus();
        }
        // Validate usage limits
        else if (
            max_uses_per_user &&
            max_global_uses &&
            parseInt(max_uses_per_user) > parseInt(max_global_uses)
        ) {
            error = "Giới hạn lượt sử dụng/tài khoản phải nhỏ hơn tổng lượt sử dụng";
            $("input[name=max_uses_per_user]").focus();
        }
        // Validate positive numbers
        else if (
            (min_price && parseInt(min_price) <= 0) ||
            (max_price && parseInt(max_price) <= 0) ||
            (max_uses_per_user && parseInt(max_uses_per_user) <= 0) ||
            (max_global_uses && parseInt(max_global_uses) <= 0)
        ) {
            error = "Các giá trị số phải lớn hơn 0";
        }
        // Validate expiration date
        else if (date_start && date_expired && time_start && time_expired) {
            const startDate = new Date(
                date_start.split("/").reverse().join("-") + "T" + time_start
            );
            const expiryDate = new Date(
                date_expired.split("/").reverse().join("-") + "T" + time_expired
            );
            const now = new Date();

            if (startDate >= expiryDate) {
                error = "Ngày hết hạn phải lớn hơn ngày bắt đầu";
                $("input[name=date_expired]").focus();
            } else if (expiryDate <= now) {
                error = "Ngày hết hạn phải lớn hơn ngày hiện tại";
                $("input[name=date_expired]").focus();
            }
        }
        // Validate product selection
        else if (kieu === "sanpham" && !main_product) {
            error = "Vui lòng chọn ít nhất một sản phẩm";
        }

        if (error) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $(".load_note").html(error);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 3000);
            return;
        }

        // Proceed with AJAX submission
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        let form_data = new FormData();
        form_data.append("action", "add_coupon");
        form_data.append("ma", ma);
        form_data.append("loai", loai);
        form_data.append("kieu", kieu);
        form_data.append("giam", giam);
        form_data.append("min_price", min_price);
        form_data.append("max_price", max_price);
        form_data.append("allow_combination", allow_combination);
        form_data.append("max_uses_per_user", max_uses_per_user);
        form_data.append("max_global_uses", max_global_uses);
        form_data.append("sanpham", main_product);
        form_data.append("time_start", time_start);
        form_data.append("date_start", date_start);
        form_data.append("time_expired", time_expired);
        form_data.append("date_expired", date_expired);

        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                let info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            },
        });
    });
    $("button[name=edit_coupon]").on("click", function () {
        // Get form values
        let id = $("input[name=id]").val();
        let ma = $("input[name=ma]").val();
        let loai = $("select[name=loai]").val();
        let kieu = $("select[name=apdung]").val();
        let giam = $("input[name=giam]")
            .val()
            .replace(/[^0-9]/g, "");
        let min_price = $("input[name=min_price]")
            .val()
            .replace(/[^0-9]/g, "");
        let max_price = $("input[name=max_price]")
            .val()
            .replace(/[^0-9]/g, "");
        let allow_combination = $("input[name=allow_combination]").is(":checked")
            ? 1
            : 0;
        let max_uses_per_user = $("input[name=max_uses_per_user]")
            .val()
            .replace(/[^0-9]/g, "");
        let max_global_uses = $("input[name=max_global_uses]")
            .val()
            .replace(/[^0-9]/g, "");
        let time_start = $("input[name=time_start]").val();
        let date_start = $("input[name=date_start]").val();
        let time_expired = $("input[name=time_expired]").val();
        let date_expired = $("input[name=date_expired]").val();
        let main_product = "";
        $("#list_product_main .li_product").each(function () {
            main_product += $(this).attr("sp") + ",";
        });

        // Validations
        let error = "";
        if (ma.length !== 5) {
            error = "Mã coupon phải đúng 5 ký tự";
            $("input[name=ma]").focus();
        }

        // Validate discount value
        if (!giam || parseInt(giam) <= 0) {
            error = "Giá trị khuyến mại phải lớn hơn 0";
            $("input[name=giam]").focus();
        }
        // Validate percentage discount (max 100%)
        else if (loai === "phantram" && parseInt(giam) > 100) {
            error = "Khuyến mại phần trăm không được vượt quá 100%";
            $("input[name=giam]").focus();
        }
        // Validate min/max price
        else if (
            min_price &&
            max_price &&
            parseInt(min_price) >= parseInt(max_price)
        ) {
            error = "Giá trị đơn hàng tối thiểu phải nhỏ hơn giá trị tối đa";
            $("input[name=min_price]").focus();
        }
        // Validate discount vs max price for fixed amount
        else if (
            loai === "tru" &&
            max_price &&
            parseInt(giam) >= parseInt(max_price)
        ) {
            error = "Giá trị khuyến mại không được lớn hơn giá trị đơn hàng tối đa";
            $("input[name=giam]").focus();
        }
        // Validate usage limits
        else if (
            max_uses_per_user &&
            max_global_uses &&
            parseInt(max_uses_per_user) > parseInt(max_global_uses)
        ) {
            error = "Giới hạn lượt sử dụng/tài khoản phải nhỏ hơn tổng lượt sử dụng";
            $("input[name=max_uses_per_user]").focus();
        }
        // Validate positive numbers
        else if (
            (min_price && parseInt(min_price) <= 0) ||
            (max_price && parseInt(max_price) <= 0) ||
            (max_uses_per_user && parseInt(max_uses_per_user) <= 0) ||
            (max_global_uses && parseInt(max_global_uses) <= 0)
        ) {
            error = "Các giá trị số phải lớn hơn 0";
        }
        // Validate dates
        else if (date_start && date_expired && time_start && time_expired) {
            const startDate = new Date(
                date_start.split("/").reverse().join("-") + "T" + time_start
            );
            const expiryDate = new Date(
                date_expired.split("/").reverse().join("-") + "T" + time_expired
            );
            const now = new Date();

            if (startDate >= expiryDate) {
                error = "Ngày hết hạn phải lớn hơn ngày bắt đầu";
                $("input[name=date_expired]").focus();
            } else if (expiryDate <= now) {
                error = "Ngày hết hạn phải lớn hơn ngày hiện tại";
                $("input[name=date_expired]").focus();
            }
        }
        // Validate product selection
        else if (kieu === "sanpham" && !main_product) {
            error = "Vui lòng chọn ít nhất một sản phẩm";
        }

        if (error) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $(".load_note").html(error);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 3000);
            return;
        }

        // Proceed with AJAX submission
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        let form_data = new FormData();
        form_data.append("action", "edit_coupon");
        form_data.append("id", id);
        form_data.append("ma", ma);
        form_data.append("loai", loai);
        form_data.append("kieu", kieu);
        form_data.append("giam", giam);
        form_data.append("min_price", min_price);
        form_data.append("max_price", max_price);
        form_data.append("allow_combination", allow_combination);
        form_data.append("max_uses_per_user", max_uses_per_user);
        form_data.append("max_global_uses", max_global_uses);
        form_data.append("sanpham", main_product);
        form_data.append("time_start", time_start);
        form_data.append("date_start", date_start);
        form_data.append("time_expired", time_expired);
        form_data.append("date_expired", date_expired);

        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                let info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/list-coupon";
                    }
                }, 3000);
            },
        });
    });

    /////////////////////////////
    $("body").on("click", ".list_tab_noidung .li_tab_noidung", function () {
        id = $(this).attr("tab_id");
        $(".list_tab_noidung .li_tab_noidung").removeClass("active");
        $(".list_share_sanpham .li_share_sanpham").removeClass("active");
        $(this).addClass("active");
        $("#tab_content_" + id).addClass("active");
        var file_store = [];
        if ($("input[name^=file]").length > 0) {
            $("input[name^=file]").remove();
        }
    });
    /////////////////////////////

    ///////////////////////////////
    $("button[name=edit_setting_img]").on("click", function () {
        name = $("input[name=id]").val();
        description = $("textarea[name=description]").val();
        var file_data = $("#minh_hoa").prop("files")[0];
        var form_data = new FormData();
        form_data.append("action", "edit_setting_img");
        form_data.append("file", file_data);
        form_data.append("name", name);
        form_data.append("description", description);
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/list-setting";
                    } else {
                    }
                }, 3000);
            },
        });
    });
    ///////////////////////////////
    $("button[name=edit_setting_css]").on("click", function () {
        background = $("input[name=background]").attr("data-current-color");
        topbar = $("input[name=topbar]").attr("data-current-color");
        header = $("input[name=header]").attr("data-current-color");
        hotline = $("input[name=hotline]").attr("data-current-color");
        menu = $("input[name=menu]").attr("data-current-color");
        title_menu = $("input[name=title_menu]").attr("data-current-color");
        title_box = $("input[name=title_box]").attr("data-current-color");
        button_top = $("input[name=button_top]").attr("data-current-color");
        subcribe = $("input[name=subcribe]").attr("data-current-color");
        top_menu_mobile = $("input[name=top_menu_mobile]").attr(
            "data-current-color"
        );
        label_sale = $("input[name=label_sale]").attr("data-current-color");
        ma_giamgia = $("input[name=ma_giamgia]").attr("data-current-color");
        top_footer = $("input[name=top_footer]").attr("data-current-color");
        text_top_footer = $("input[name=text_top_footer]").attr(
            "data-current-color"
        );
        bottom_footer = $("input[name=bottom_footer]").attr("data-current-color");
        text_bottom_footer = $("input[name=text_bottom_footer]").attr(
            "data-current-color"
        );
        timkiem = $("input[name=timkiem]").attr("data-current-color");
        nhantin = $("input[name=nhantin]").attr("data-current-color");
        text_title_top_footer = $("input[name=text_title_top_footer]").attr(
            "data-current-color"
        );
        description = $("textarea[name=description]").val();
        id = $("input[name=id]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
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
                text_title_top_footer: text_title_top_footer,
                description: description,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {
                    }
                }, 3000);
            },
        });
    });
    ///////////////////////////////
    $("button[name=edit_setting_html]").on("click", function () {
        name = $("input[name=id]").val();
        noidung = tinyMCE.activeEditor.getContent();
        description = $("textarea[name=description]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung,
                description: description,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/list-setting";
                    } else {
                    }
                }, 3000);
            },
        });
    });
    ///////////////////////////////
    $("button[name=edit_setting_text]").on("click", function () {
        name = $("input[name=id]").val();
        noidung = $("textarea[name=content]").val();
        description = $("textarea[name=description]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung,
                description: description,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/list-setting";
                    } else {
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("input[name=loai]").click(function () {
        loai = $("input[name=loai]:checked").val();
        if (loai == "link") {
            $("#select_theloai").hide();
            $("#select_category").hide();
            $("#select_page").hide();
            $("#input_link").show();
        } else if (loai == "category") {
            $("#select_theloai").hide();
            $("#select_category").show();
            $("#select_page").hide();
            $("#input_link").hide();
        } else if (loai == "theloai") {
            $("#select_theloai").show();
            $("#select_category").hide();
            $("#select_page").hide();
            $("#input_link").hide();
        } else if (loai == "page") {
            $("#select_theloai").hide();
            $("#select_category").hide();
            $("#select_page").show();
            $("#input_link").hide();
        } else {
            $("#select_theloai").hide();
            $("#select_category").hide();
            $("#select_page").hide();
            $("#input_link").show();
        }
    });
    /////////////////////////////
    $("#select_category select").on("change", function () {
        text = $("#select_category select option:selected").text();
        $("input[name=tieu_de]").val(text);
    });
    /////////////////////////////
    $("#select_theloai select").on("change", function () {
        text = $("#select_theloai select option:selected").text();
        $("input[name=tieu_de]").val(text);
    });
    /////////////////////////////
    $("#select_page select").on("change", function () {
        text = $("#select_page select option:selected").text();
        $("input[name=tieu_de]").val(text);
    });
    /////////////////////////////
    $("button[name=add_ruttien]").click(function () {
        so_tien = $("input[name=so_tien]").val();
        chu_khoan = $("input[name=chu_khoan]").val();
        so_taikhoan = $("input[name=so_taikhoan]").val();
        ngan_hang = $("input[name=ngan_hang]").val();
        if (so_tien < 1000) {
            $("input[name=so_tien]").focus();
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập số tiền lớn hơn 1000 đ");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (chu_khoan.length < 4) {
            $("input[name=chu_khoan]").focus();
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tên chủ tài khoản");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (so_taikhoan.length < 4) {
            $("input[name=so_taikhoan]").focus();
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập số tài khoản");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (ngan_hang.length < 4) {
            $("input[name=ngan_hang]").focus();
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tên ngân hàng");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_ruttien",
                    so_tien: so_tien,
                    chu_khoan: chu_khoan,
                    so_taikhoan: so_taikhoan,
                    ngan_hang: ngan_hang,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            var dulieu = {
                                hd: "notification",
                                bo_phan: "tai_chinh",
                            };
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit("user_send_hoatdong", info_chat);
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=add_menu]").click(function () {
        loai = $("input[name=loai]:checked").val();
        tieu_de = $("input[name=tieu_de]").val();
        link = $("input[name=link]").val();
        target = $("select[name=target]").val();
        thu_tu = $("input[name=thu_tu]").val();
        vi_tri = $("select[name=vi_tri]").val();
        category = $("select[name=category]").val();
        theloai = $("select[name=theloai]").val();
        page = $("select[name=page]").val();
        if (tieu_de.length < 2) {
            $("input[name=tieu_de]").focus();
        } else if (loai == "link" && link == "") {
            $("input[name=link]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
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
                    page: page,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_menu]").click(function () {
        loai = $("input[name=loai]:checked").val();
        tieu_de = $("input[name=tieu_de]").val();
        link = $("input[name=link]").val();
        target = $("select[name=target]").val();
        thu_tu = $("input[name=thu_tu]").val();
        vi_tri = $("select[name=vi_tri]").val();
        category = $("select[name=category]").val();
        theloai = $("select[name=theloai]").val();
        page = $("select[name=page]").val();
        id = $("input[name=id]").val();
        if (tieu_de.length < 2) {
            $("input[name=tieu_de]").focus();
        } else if (loai == "link" && link == "") {
            $("input[name=link]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
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
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-menu";
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////huyphuc06/05/2025
    $("button[name=add_slide]").on("click", function () {
        const tieu_de = $("input[name=tieu_de]").val();
        const link = $("input[name=link]").val();
        const thu_tu = $("input[name=thu_tu]").val();
        const target = $("select[name=target]").val();
        const file = $("#minh_hoa").prop("files")[0]; // Lấy file
        // Kiểm tra tiêu đề
        if (tieu_de.length < 2) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tiêu đề");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=tieu_de]").focus();
            return;
        }

        // Kiểm tra thứ tự
        if (thu_tu === "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thứ tự");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=thu_tu]").focus();
            return;
        }

        // Kiểm tra có file hay không
        if (!file) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn một ảnh!");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("#minh_hoa").focus();
            return;
        }

        // Kiểm tra kích thước ảnh
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = function () {
            const width = img.width;
            const height = img.height;
            // Log kích thước
            console.log("Kích thước ảnh:", width, "x", height, "px");
            // Validate kích thước
            if (width < 800 || width > 1900 || height < 300 || height > 580) {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                setTimeout(function () {
                    $(".load_note").html(
                        "Kích thước ảnh phải từ 800x300px đến 1900x580px."
                    );
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 2000);
                $("#minh_hoa").val(""); // Xóa file đã chọn
                $("#preview-minhhoa").attr("src", "/images/no-images.jpg"); // Reset preview
                URL.revokeObjectURL(objectUrl);
                return;
            }

            // Nếu tất cả hợp lệ, gửi AJAX
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            const form_data = new FormData();
            form_data.append("action", "add_slide");
            form_data.append("file", file);
            form_data.append("tieu_de", tieu_de);
            form_data.append("link", link);
            form_data.append("thu_tu", thu_tu);
            form_data.append("target", target);

            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    const info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
                error: function () {
                    $(".load_note").html("Lỗi hệ thống, vui lòng thử lại!");
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                    }, 3000);
                },
            });

            URL.revokeObjectURL(objectUrl);
        };

        img.onerror = function () {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Lỗi khi đọc file ảnh!");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("#minh_hoa").val("");
            $("#preview-minhhoa").attr("src", "/images/no-images.jpg");
            URL.revokeObjectURL(objectUrl);
        };

        img.src = objectUrl;
    });
    /////////////////////////////huyphuc06/05/2025
    $("button[name=edit_slide]").on("click", function () {
        const id = $("input[name=id]").val();
        const tieu_de = $("input[name=tieu_de]").val();
        const link = $("input[name=link]").val();
        const thu_tu = $("input[name=thu_tu]").val();
        const target = $("select[name=target]").val();
        const file = $("#minh_hoa").prop("files")[0]; // Lấy file
        // Kiểm tra tiêu đề
        if (tieu_de.length < 2) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tiêu đề");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=tieu_de]").focus();
            return;
        }

        // Kiểm tra thứ tự
        if (thu_tu === "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thứ tự");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=thu_tu]").focus();
            return;
        }
        // Kiểm tra có file hay không
        if (!file) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn một ảnh!");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("#minh_hoa").focus();
            return;
        }

        // Kiểm tra kích thước ảnh
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = function () {
            const width = img.width;
            const height = img.height;
            // Log kích thước
            console.log("Kích thước ảnh:", width, "x", height, "px");
            // Validate kích thước
            if (width < 800 || width > 1900 || height < 300 || height > 580) {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                setTimeout(function () {
                    $(".load_note").html(
                        "Kích thước ảnh phải từ 800x300px đến 1900x580px."
                    );
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 2000);
                $("#minh_hoa").val(""); // Xóa file đã chọn
                $("#preview-minhhoa").attr("src", "/images/no-images.jpg"); // Reset preview
                URL.revokeObjectURL(objectUrl);
                return;
            }

            // Nếu tất cả hợp lệ, gửi AJAX
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            const form_data = new FormData();
            form_data.append("action", "edit_slide");
            form_data.append("file", file);
            form_data.append("id", id);
            form_data.append("tieu_de", tieu_de);
            form_data.append("link", link);
            form_data.append("thu_tu", thu_tu);
            form_data.append("target", target);

            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    const info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
                error: function () {
                    $(".load_note").html("Lỗi hệ thống, vui lòng thử lại!");
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                    }, 3000);
                },
            });

            URL.revokeObjectURL(objectUrl);
        };

        img.onerror = function () {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Lỗi khi đọc file ảnh!");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("#minh_hoa").val("");
            $("#preview-minhhoa").attr("src", "/images/no-images.jpg");
            URL.revokeObjectURL(objectUrl);
        };

        img.src = objectUrl;
    });
    /////////////////////////////
    $("button[name=edit_category]").on("click", function () {
        cat_tieude = $("input[name=cat_tieude]").val();
        cat_blank = $("input[name=cat_blank]").val();
        cat_thutu = $("input[name=cat_thutu]").val();
        cat_title = $("input[name=cat_title]").val();
        link_old = $("input[name=link_old]").val();
        cat_link = $("input[name=cat_link]").val();
        cat_description = $("textarea[name=cat_description]").val();
        cat_noidung = $("textarea[name=cat_noidung]").val();
        cat_id = $("input[name=id]").val();
        cat_icon = $("input[name=cat_icon]").val();
        cat_main = $("select[name=cat_main]").val();
        cat_index = $("input[name=cat_index]:checked").val();
        let cat_id_socdo = $('input[name="category_ncc[]"]:checked')
            .map(function () {
                return this.value;
            })
            .get();
        if (cat_tieude.length < 2) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tiêu đề");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=cat_tieude]").focus();
        } else if (cat_thutu == "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thứ tự");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=cat_thutu]").focus();
        } else if (cat_id_socdo.length === 0) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();

            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn danh mục sóc đỏ");
            }, 500);

            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $('input[name="category_ncc[]"]').first().focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "edit_category");
            form_data.append("file", file_data);
            form_data.append("cat_tieude", cat_tieude);
            form_data.append("cat_blank", cat_blank);
            form_data.append("link_old", link_old);
            form_data.append("cat_title", cat_tieude);
            form_data.append("cat_description", cat_description);
            form_data.append("cat_noidung", cat_noidung);
            form_data.append("cat_main", cat_main);
            form_data.append("cat_icon", cat_icon);
            form_data.append("cat_index", cat_index);
            form_data.append("cat_thutu", cat_thutu);
            form_data.append("cat_link", cat_link);
            form_data.append("cat_id", cat_id);
            form_data.append("cat_id_socdo", cat_id_socdo); //1-4
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-category";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=add_category]").on("click", function () {
        cat_tieude = $("input[name=cat_tieude]").val();
        cat_blank = $("input[name=cat_blank]").val();
        cat_thutu = $("input[name=cat_thutu]").val();
        cat_title = $("input[name=cat_title]").val();
        cat_link = $("input[name=cat_link]").val();
        cat_description = $("textarea[name=cat_description]").val();
        cat_noidung = $("textarea[name=cat_noidung]").val();
        cat_main = $("select[name=cat_main]").val();
        cat_icon = $("input[name=cat_icon]").val();
        cat_index = $("input[name=cat_index]:checked").val();
        let cat_id_socdo = $('input[name="category_ncc[]"]:checked')
            .map(function () {
                return this.value;
            })
            .get();
        if (cat_tieude.length < 2) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tiêu đề");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=cat_tieude]").focus();
        } else if (cat_thutu == "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thứ tự");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=cat_thutu]").focus();
        } else if (cat_id_socdo.length === 0) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();

            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn danh mục sóc đỏ");
            }, 500);

            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $('input[name="category_ncc[]"]').first().focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "add_category");
            form_data.append("file", file_data);
            form_data.append("cat_tieude", cat_tieude);
            form_data.append("cat_blank", cat_blank);
            form_data.append("cat_title", cat_tieude);
            form_data.append("cat_description", cat_description);
            form_data.append("cat_noidung", cat_noidung);
            form_data.append("cat_main", cat_main);
            form_data.append("cat_icon", cat_icon);
            form_data.append("cat_index", cat_index);
            form_data.append("cat_thutu", cat_thutu);
            form_data.append("cat_link", cat_link);
            form_data.append("cat_id_socdo", cat_id_socdo); //1-4
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_donhang]").on("click", function () {
        id = $("input[name=id]").val();
        status = $("select[name=status]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "edit_donhang",
                status: status,
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {
                    }
                }, 3000);
            },
        });
    });
    ////////////////////////////8-5
    /////////////////////////////
    $("button[name=edit_donhang_socdo]").on("click", function () {
        id = $("input[name=id]").val();
        status = $("select[name=status]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "edit_donhang_socdo",
                status: status,
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("button[name=edit_livestream]").on("click", function () {
        id = $("input[name=id]").val();
        status = $("select[name=status]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "edit_livestream",
                status: status,
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("body").on("click", ".confirm_leader", function () {
        $(".box_pop_add").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "reg_leader",
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/list-tuyendung-nhom";
                    } else {
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("button[name=reg_leader]").on("click", function () {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_pop_add",
                loai: "confirm_leader",
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".box_pop_add").html(info.html);
                $(".box_pop_add").show();
            },
        });
    });
    /////////////////////////////
    $("button[name=edit_tichdiem]").on("click", function () {
        diem = $("input[name=diem]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "edit_tichdiem",
                diem: diem,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    } else {
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $("button[name=add_livestream]").on("click", function () {
        time_start = $("input[name=time_start]").val();
        time_end = $("input[name=time_end]").val();
        ngay = $("input[name=ngay]").val();
        san_pham = $("textarea[name=san_pham]").val();
        ghi_chu = $("textarea[name=ghi_chu]").val();
        id = $("input[name=id]").val();
        if (san_pham == "") {
            $("textarea[name=san_pham]").focus();
        } else if (time_start == "") {
            $("input[name=time_start]").focus();
        } else if (ngay == "") {
            $("input[name=ngay]").focus();
        } else if (time_end == "") {
            $("input[name=time_end]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "dat_livestream",
                    ngay: ngay,
                    time_start: time_start,
                    time_end: time_end,
                    san_pham: san_pham,
                    ghi_chu: ghi_chu,
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            var dulieu = {
                                hd: "notification",
                                bo_phan: "hotro_chung",
                            };
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit("user_send_hoatdong", info_chat);
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_theloai]").on("click", function () {
        cat_tieude = $("input[name=cat_tieude]").val();
        cat_blank = $("input[name=cat_blank]").val();
        cat_thutu = $("input[name=cat_thutu]").val();
        cat_title = $("input[name=cat_title]").val();
        link_old = $("input[name=link_old]").val();
        cat_description = $("textarea[name=cat_description]").val();
        cat_noidung = $("textarea[name=cat_noidung]").val();
        cat_id = $("input[name=id]").val();
        cat_icon = $("input[name=cat_icon]").val();
        cat_main = $("select[name=cat_main]").val();
        cat_index = $("input[name=cat_index]:checked").val();
        if (cat_tieude.length < 2) {
            $("input[name=cat_tieude]").focus();
        } else if (cat_thutu == "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập thứ tự");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
            $("input[name=cat_thutu]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
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
                    cat_id: cat_id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-theloai";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=add_theloai]").on("click", function () {
        cat_tieude = $("input[name=cat_tieude]").val();
        cat_blank = $("input[name=cat_blank]").val();
        cat_thutu = $("input[name=cat_thutu]").val();
        cat_title = $("input[name=cat_title]").val();
        cat_description = $("textarea[name=cat_description]").val();
        cat_noidung = $("textarea[name=cat_noidung]").val();
        cat_main = $("select[name=cat_main]").val();
        cat_icon = $("input[name=cat_icon]").val();
        cat_index = $("input[name=cat_index]:checked").val();
        if (cat_tieude.length < 2) {
            $("input[name=cat_tieude]").focus();
        } else if (cat_thutu == "") {
            $("input[name=cat_thutu]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
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
                    cat_thutu: cat_thutu,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_thanhvien]").on("click", function () {
        name = $("input[name=name]").val();
        active = $("select[name=active]").val();
        id = $("input[name=id]").val();
        var file_data = $("#minh_hoa").prop("files")[0];
        var form_data = new FormData();
        form_data.append("action", "edit_thanhvien");
        form_data.append("file", file_data);
        form_data.append("name", name);
        form_data.append("active", active);
        form_data.append("id", id);
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            },
        });
    });
    /////////////////////////////
    // $('button[name=button_doanhthu_cuaban]').on('click', function () {
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
    //         form_data.append('action', 'load_doanhthu_cuaban');
    //         form_data.append('time_begin', time_begin);
    //         form_data.append('time_end', time_end);
    //         $.ajax({
    //             url: '/ncc/process.php',
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
    //                         $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
    //                         $('#doanhthu_giao').html(info.doanhthu_giao);
    //                         $('#doanhthu_huy').html(info.doanhthu_huy);
    //                         $('#doanhthu_hoan').html(info.doanhthu_hoan);
    //                         $('#doanhthu_cho').html(info.doanhthu_cho);
    //                         $('#doanhthu_tiepnhan').html(info.doanhthu_tiepnhan);
    //                         $('#donhang_hoanthanh').html(info.donhang_hoanthanh);
    //                         $('#donhang_giao').html(info.donhang_giao);
    //                         $('#donhang_huy').html(info.donhang_huy);
    //                         $('#donhang_hoan').html(info.donhang_hoan);
    //                         $('#donhang_cho').html(info.donhang_cho);
    //                         $('#donhang_tiepnhan').html(info.donhang_tiepnhan);
    //                     } else {

    //                     }
    //                 }, 2000);
    //             }

    //         });
    //     }
    // });
    $("button[name=button_doanhthu_cuaban]").on("click", function () {
        const time_begin = $("input[name=begin]").val();
        const time_end = $("input[name=end]").val();
        if (time_begin.length < 10) {
            $("input[name=begin]").focus();
            return;
        }
        if (time_end.length < 10) {
            $("input[name=end]").focus();
            return;
        }

        $(".load_overlay").show();
        $(".load_process").fadeIn();
        const form_data = new FormData();
        form_data.append("action", "load_doanhthu_cuaban");
        form_data.append("time_begin", time_begin);
        form_data.append("time_end", time_end);

        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                const info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        // Cập nhật các phần tử HTML
                        $("#doanhthu_hoanthanh").html(info.doanhthu_hoanthanh);
                        $("#doanhthu_giao").html(info.doanhthu_giao);
                        $("#doanhthu_huy").html(info.doanhthu_huy);
                        $("#doanhthu_hoan").html(info.doanhthu_hoan);
                        $("#doanhthu_cho").html(info.doanhthu_cho);
                        $("#doanhthu_tiepnhan").html(info.doanhthu_tiepnhan);
                        $("#donhang_hoanthanh").html(info.donhang_hoanthanh);
                        $("#donhang_giao").html(info.donhang_giao);
                        $("#donhang_huy").html(info.donhang_huy);
                        $("#donhang_hoan").html(info.donhang_hoan);
                        $("#donhang_cho").html(info.donhang_cho);
                        $("#donhang_tiepnhan").html(info.donhang_tiepnhan);

                        // Cập nhật biểu đồ với dữ liệu mới
                        initChart(
                            {
                                doanhthu_hoanthanh: info.doanhthu_hoanthanh,
                                doanhthu_cho: info.doanhthu_cho,
                                doanhthu_tiepnhan: info.doanhthu_tiepnhan,
                                doanhthu_giao: info.doanhthu_giao,
                                doanhthu_huy: info.doanhthu_huy,
                                doanhthu_hoan: info.doanhthu_hoan,
                            },
                            {
                                donhang_hoanthanh: info.donhang_hoanthanh,
                                donhang_cho: info.donhang_cho,
                                donhang_tiepnhan: info.donhang_tiepnhan,
                                donhang_giao: info.donhang_giao,
                                donhang_huy: info.donhang_huy,
                                donhang_hoan: info.donhang_hoan,
                            }
                        );
                    }
                }, 2000);
            },
        });
    });
    /////////////////////////////
    $("button[name=button_doanhthu]").on("click", function () {
        time_begin = $("input[name=begin]").val();
        time_end = $("input[name=end]").val();
        if (time_begin.length < 10) {
            $("input[name=begin]").focus();
        } else if (time_end.length < 10) {
            $("input[name=end]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            var form_data = new FormData();
            form_data.append("action", "load_doanhthu");
            form_data.append("time_begin", time_begin);
            form_data.append("time_end", time_end);
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            $("#doanhthu_hoanthanh").html(info.doanhthu_hoanthanh);
                            $("#doanhthu_giao").html(info.doanhthu_giao);
                            $("#doanhthu_huy").html(info.doanhthu_huy);
                            $("#doanhthu_hoan").html(info.doanhthu_hoan);
                            $("#doanhthu_cho").html(info.doanhthu_cho);
                            $("#doanhthu_tiepnhan").html(info.doanhthu_tiepnhan);
                            $("#donhang_hoanthanh").html(info.donhang_hoanthanh);
                            $("#donhang_giao").html(info.donhang_giao);
                            $("#donhang_huy").html(info.donhang_huy);
                            $("#donhang_hoan").html(info.donhang_hoan);
                            $("#donhang_cho").html(info.donhang_cho);
                            $("#donhang_tiepnhan").html(info.donhang_tiepnhan);
                            $("#donhang_hoanthanh_san b").html(info.doanhthu_hoanthanh_san);
                            $("#donhang_giao_san b").html(info.doanhthu_giao_san);
                            $("#donhang_huy_san b").html(info.doanhthu_huy_san);
                            $("#donhang_hoan_san b").html(info.doanhthu_hoan_san);
                            $("#donhang_cho_san b").html(info.doanhthu_cho_san);
                            $("#donhang_tiepnhan_san b").html(info.doanhthu_tiepnhan_san);
                            $("#donhang_hoanthanh_san span").html(info.donhang_hoanthanh_san);
                            $("#donhang_giao_san span").html(info.donhang_giao_san);
                            $("#donhang_huy_san span").html(info.donhang_huy_san);
                            $("#donhang_hoan_san span").html(info.donhang_hoan_san);
                            $("#donhang_cho_san span").html(info.donhang_cho_san);
                            $("#donhang_tiepnhan_san span").html(info.donhang_tiepnhan_san);
                            $("#donhang_hoanthanh_socdo b").html(
                                info.doanhthu_hoanthanh_socdo
                            );
                            $("#donhang_giao_socdo b").html(info.doanhthu_giao_socdo);
                            $("#donhang_huy_socdo b").html(info.doanhthu_huy_socdo);
                            $("#donhang_hoan_socdo b").html(info.doanhthu_hoan_socdo);
                            $("#donhang_cho_socdo b").html(info.doanhthu_cho_socdo);
                            $("#donhang_tiepnhan_socdo b").html(info.doanhthu_tiepnhan_socdo);
                            $("#donhang_hoanthanh_socdo span").html(
                                info.donhang_hoanthanh_socdo
                            );
                            $("#donhang_giao_socdo span").html(info.donhang_giao_socdo);
                            $("#donhang_huy_socdo span").html(info.donhang_huy_socdo);
                            $("#donhang_hoan_socdo span").html(info.donhang_hoan_socdo);
                            $("#donhang_cho_socdo span").html(info.donhang_cho_socdo);
                            $("#donhang_tiepnhan_socdo span").html(
                                info.donhang_tiepnhan_socdo
                            );
                            $("#donhang_hoanthanh_aff b").html(info.doanhthu_hoanthanh_aff);
                            $("#donhang_giao_aff b").html(info.doanhthu_giao_aff);
                            $("#donhang_huy_aff b").html(info.doanhthu_huy_aff);
                            $("#donhang_hoan_aff b").html(info.doanhthu_hoan_aff);
                            $("#donhang_cho_aff b").html(info.doanhthu_cho_aff);
                            $("#donhang_tiepnhan_aff b").html(info.doanhthu_tiepnhan_aff);
                            $("#donhang_hoanthanh_aff span").html(info.donhang_hoanthanh_aff);
                            $("#donhang_giao_aff span").html(info.donhang_giao_aff);
                            $("#donhang_huy_aff span").html(info.donhang_huy_aff);
                            $("#donhang_hoan_aff span").html(info.donhang_hoan_aff);
                            $("#donhang_cho_aff span").html(info.donhang_cho_aff);
                            $("#donhang_tiepnhan_aff span").html(info.donhang_tiepnhan_aff);
                        } else {
                        }
                    }, 2000);
                },
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
    //             url: '/ncc/process.php',
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
    $("button[name=login]").on("click", function () {
        password = $("input[name=password]").val();
        username = $("input[name=username]").val();
        remember = $(".remember").attr("value");
        if (username.length < 4) {
            $("input[name=username]").focus();
        } else if (password.length < 6) {
            $("input[name=password]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process_login.php",
                type: "post",
                data: {
                    username: username,
                    password: password,
                    remember: remember,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/dashboard";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=forgot_password]").on("click", function () {
        email = $("input[name=email]").val();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "forgot_password",
                email: email,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 3000);
                setTimeout(function () {
                    if (info.ok == 1) {
                        window.location.href = "/forgot-password?step=2";
                    } else {
                    }
                }, 3500);
            },
        });
    });
    /////////////////////////////
    $("button[name=button_domain]").on("click", function () {
        domain = $("input[name=domain]").val();
        if (domain.length < 5) {
            $("input[name=domain]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "edit_domain",
                    domain: domain,
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
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                    }, 3000);
                },
            });
        }
    });
    //////////////////////////
    $(".list_shopcart").on("click", ".button_plus", function () {
        id = $(this).attr("sp_id");
        quantity = $(this).parent().find("input").val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $(this).parent().find("input").val("1");
            quantity = 1;
        } else {
            quantity++;
            $(this).parent().find("input").val(quantity);
        }
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_shopcart",
                sp_id: id,
                quantity: quantity,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".list_shopcart_mobile").html(info.list_shopcart_mobile);
                $(".list_shopcart").html(info.list_shopcart);
                $(".control-cart .count_item").html(info.total_cart);
                $(".count_shopcart").html("(" + info.total_cart + " sản phẩm)");
                $("#popup-cart .cart-popup-count").html(info.total_cart);
                $(".total_price").html(info.tongtien);
                $(".tamtinh").html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            },
        });
    });
    //////////////////////////
    $(".list_shopcart ").on("click", ".button_minus", function () {
        id = $(this).attr("sp_id");
        quantity = $(this).parent().find("input").val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $(this).parent().find("input").val("1");
            quantity = 1;
        } else {
            if (quantity <= 1) {
                $(this).parent().find("input").val("1");
                quantity = 1;
            } else {
                quantity--;
                $(this).parent().find("input").val(quantity);
            }
        }
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_shopcart",
                sp_id: id,
                quantity: quantity,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".list_shopcart_mobile").html(info.list_shopcart_mobile);
                $(".list_shopcart").html(info.list_shopcart);
                $(".control-cart .count_item").html(info.total_cart);
                $(".count_shopcart").html("(" + info.total_cart + " sản phẩm)");
                $("#popup-cart .cart-popup-count").html(info.total_cart);
                $(".total_price").html(info.tongtien);
                $(".tamtinh").html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            },
        });
    });
    //////////////////////////
    $(".list_shopcart ").on("keyup", "input[name=quantity]", function () {
        id = $(this).attr("sp_id");
        quantity = $(this).val();
        quantity = parseInt(quantity);
        if (isNaN(quantity) == true) {
            $(this).val("1");
            quantity = 1;
        } else {
            if (quantity <= 1) {
                $(this).val("1");
                quantity = 1;
            } else {
            }
        }
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_shopcart",
                sp_id: id,
                quantity: quantity,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".list_shopcart_mobile").html(info.list_shopcart_mobile);
                $(".list_shopcart").html(info.list_shopcart);
                $(".control-cart .count_item").html(info.total_cart);
                $(".count_shopcart").html("(" + info.total_cart + " sản phẩm)");
                $("#popup-cart .cart-popup-count").html(info.total_cart);
                $(".total_price").html(info.tongtien);
                $(".tamtinh").html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            },
        });
    });
    //////////////////////////
    $(".list_shopcart ").on("click", ".remove_cart", function () {
        id = $(this).attr("sp_id");
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "remove_shopcart",
                sp_id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(this).parent().parent().remove();
                $(".list_shopcart_mobile").html(info.list_shopcart_mobile);
                $(".list_shopcart").html(info.list_shopcart);
                $(".control-cart .count_item").html(info.total_cart);
                $(".count_shopcart").html("(" + info.total_cart + " sản phẩm)");
                $("#popup-cart .cart-popup-count").html(info.total_cart);
                $(".total_price").html(info.tongtien);
                $(".tamtinh").html(info.tongtien);
                /*$('.total_price_mobile').html(info.tongtien);*/
            },
        });
    });
    $("body").on("change", "#load_huyen", function () {
        tinh = $(this).val();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_huyen",
                tinh: tinh,
            },
            success: function (kq) {
                console.log(kq);
                var info = JSON.parse(kq);
                $(".box_profile select[name=huyen]").html(info.list);
                $(".box_profile select[name=xa]").html(
                    '<option value="">Chọn Xã/phường</option>'
                );
            },
        });
    });
    $("body").on("change", "#load_xa", function () {
        huyen = $(this).val();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_xa",
                huyen: huyen,
            },
            success: function (kq) {
                console.log(kq);
                var info = JSON.parse(kq);
                $(".box_profile select[name=xa]").html(info.list);
            },
        });
    });
    //////////////////////////
    $("#customer_shipping_district_bt").on("change", function () {
        if ($("select[name=congty_ship]").length > 0) {
            congty_ship = $("select[name=congty_ship]").val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        huyen = $(this).val();
        tinh = $("select[name=tinh]").val();
        if (tinh != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_xa",
                    congty_ship: congty_ship,
                    tinh: tinh,
                    huyen: huyen,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("#customer_shipping_ward_bt").html(
                        '<option value="">Chọn xã / phường</option>' + info.list
                    );
                    $("select[name=dichvu_ship]").html(
                        '<option value="">Chọn dịch vụ</option>'
                    );
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("body").on("change", "#customer_shipping_district_gop", function () {
        var div_this = $(this);
        if (
            div_this.parent().parent().parent().find("select[name=congty_ship]")
                .length > 0
        ) {
            congty_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=congty_ship]")
                .val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        huyen = $(this).val();
        tinh = $(this).parent().parent().parent().find("select[name=tinh]").val();
        if (tinh != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_xa",
                    congty_ship: congty_ship,
                    tinh: tinh,
                    huyen: huyen,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("#customer_shipping_ward_gop")
                        .html('<option value="">Chọn xã / phường</option>' + info.list);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("select[name=dichvu_ship]")
                        .html('<option value="">Chọn dịch vụ</option>');
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("#customer_shipping_province_bt").on("change", function () {
        if ($("select[name=congty_ship]").length > 0) {
            congty_ship = $("select[name=congty_ship]").val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        tinh = $(this).val();
        if (tinh != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_huyen",
                    congty_ship: congty_ship,
                    tinh: tinh,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("#customer_shipping_district_bt").html(
                        '<option value="">Chọn quận / huyện</option>' + info.list
                    );
                    $("#customer_shipping_ward_bt").html(
                        '<option value="">Chọn xã / phường</option>'
                    );
                    $("select[name=dichvu_ship]").html(
                        '<option value="">Chọn dịch vụ</option>'
                    );
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("body").on("change", "#customer_shipping_province_gop", function () {
        var div_this = $(this);
        if (
            div_this.parent().parent().parent().find("select[name=congty_ship]")
                .length > 0
        ) {
            congty_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=congty_ship]")
                .val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        tinh = $(this).val();
        if (tinh != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_huyen",
                    congty_ship: congty_ship,
                    tinh: tinh,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("#customer_shipping_district_gop")
                        .html('<option value="">Chọn quận / huyện</option>' + info.list);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("#customer_shipping_ward_gop")
                        .html('<option value="">Chọn xã / phường</option>');
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("select[name=dichvu_ship]")
                        .html('<option value="">Chọn dịch vụ</option>');
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("select[name=congty_ship]").on("change", function () {
        var div_this = $(this);
        if (
            div_this.parent().parent().parent().find("select[name=congty_ship]")
                .length > 0
        ) {
            congty_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=congty_ship]")
                .val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        if (congty_ship != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_tinh",
                    congty_ship: congty_ship,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("#customer_shipping_province_bt")
                        .html('<option value="">Chọn tỉnh/thành phố</option>' + info.list);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("#customer_shipping_district_bt")
                        .html('<option value="">Chọn quận / huyện</option>');
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("#customer_shipping_ward_bt")
                        .html('<option value="">Chọn xã / phường</option>');
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("select[name=dichvu_ship]")
                        .html('<option value="">Chọn dịch vụ</option>');
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("body").on(
        "change",
        ".box_khach_order select[name=congty_ship]",
        function () {
            var div_this = $(this);
            if (
                div_this.parent().parent().parent().find("select[name=congty_ship]")
                    .length > 0
            ) {
                congty_ship = div_this
                    .parent()
                    .parent()
                    .parent()
                    .find("select[name=congty_ship]")
                    .val();
                if (congty_ship == "ninja_van") {
                    congty_ship = "ninja_van";
                } else {
                    congty_ship = "viettel_post";
                }
            } else {
                congty_ship = "viettel_post";
            }
            if (congty_ship != "") {
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "load_tinh",
                        congty_ship: congty_ship,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        div_this
                            .parent()
                            .parent()
                            .parent()
                            .find("#customer_shipping_province_gop")
                            .html(
                                '<option value="">Chọn tỉnh/thành phố</option>' + info.list
                            );
                        div_this
                            .parent()
                            .parent()
                            .parent()
                            .find("#customer_shipping_district_gop")
                            .html('<option value="">Chọn quận / huyện</option>');
                        div_this
                            .parent()
                            .parent()
                            .parent()
                            .find("#customer_shipping_ward_gop")
                            .html('<option value="">Chọn xã / phường</option>');
                        div_this
                            .parent()
                            .parent()
                            .parent()
                            .find("select[name=dichvu_ship]")
                            .html('<option value="">Chọn dịch vụ</option>');
                    },
                });
            } else {
            }
        }
    );
    //////////////////////////
    $("#customer_shipping_ward_bt").on("change", function () {
        tinh = $("#customer_shipping_province_bt").val();
        huyen = $("#customer_shipping_district_bt").val();
        xa = $("#customer_shipping_ward_bt").val();
        cod = $("input[name=cod]").val();
        if ($("select[name=congty_ship]").length > 0) {
            congty_ship = $("select[name=congty_ship]").val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        if (tinh != "" && huyen != "" && xa != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_dichvu",
                    tinh: tinh,
                    huyen: huyen,
                    xa: xa,
                    congty_ship: congty_ship,
                    cod: cod,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $("select[name=dichvu_ship]").html(
                        '<option value="">Chọn dịch vụ</option>' + info.list
                    );
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("body").on("change", "#customer_shipping_ward_gop", function () {
        var div_this = $(this);
        tinh = div_this
            .parent()
            .parent()
            .parent()
            .find("#customer_shipping_province_gop")
            .val();
        huyen = div_this
            .parent()
            .parent()
            .parent()
            .find("#customer_shipping_district_gop")
            .val();
        xa = div_this
            .parent()
            .parent()
            .parent()
            .find("#customer_shipping_ward_gop")
            .val();
        cod = div_this.parent().parent().parent().find("input[name=cod]").val();
        don = div_this
            .parent()
            .parent()
            .parent()
            .find(".info_don_hang")
            .attr("box");
        tamtinh = div_this
            .parent()
            .parent()
            .parent()
            .find(".tongtien_don span")
            .html();
        if (
            div_this.parent().parent().parent().find("select[name=congty_ship]")
                .length > 0
        ) {
            congty_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=congty_ship]")
                .val();
            if (congty_ship == "ninja_van") {
                congty_ship = "ninja_van";
            } else {
                congty_ship = "viettel_post";
            }
        } else {
            congty_ship = "viettel_post";
        }
        if (tamtinh == "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $(this).val("");
            setTimeout(function () {
                $(".load_note").html("Thất bại! Vui lòng chọn sản phẩm");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (cod == "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $(this).val("");
            setTimeout(function () {
                $(".load_note").html("Thất bại! Vui lòng nhập tiền COD");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (tinh != "" && huyen != "" && xa != "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "load_dichvu_gop",
                    tinh: tinh,
                    huyen: huyen,
                    xa: xa,
                    congty_ship: congty_ship,
                    don: don,
                    tamtinh: tamtinh,
                    cod: cod,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    div_this
                        .parent()
                        .parent()
                        .parent()
                        .find("select[name=dichvu_ship]")
                        .html('<option value="">Chọn dịch vụ</option>' + info.list);
                },
            });
        } else {
        }
    });
    //////////////////////////
    $("body").on(
        "change",
        ".box_order_info_left_bt select[name=dichvu_ship]",
        function () {
            var div_this = $(this);
            phi_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=dichvu_ship] option:selected")
                .attr("phi_ship");
            phi_ship_text = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=dichvu_ship] option:selected")
                .attr("phi_ship_text");
            $(".total_phi").attr("phi", phi_ship);
            $(".total_phi").html(phi_ship_text);
            total_price = $(".total_price").attr("total_price");
            phi_ship = $(".total_phi").attr("phi");
            chiu_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=chiu_ship]")
                .val();
            cod = div_this.parent().parent().parent().find("input[name=cod]").val();
            cod = cod.replace(/,/g, "");
            if (chiu_ship == "shop") {
                hoahong = cod - total_price - phi_ship;
            } else {
                hoahong = cod - total_price;
            }
            $(".total_hoahong").html(format_price(hoahong) + "đ");
        }
    );
    //////////////////////////
    $("body").on(
        "change",
        ".box_order_info_left_gop select[name=dichvu_ship]",
        function () {
            var div_this = $(this);
            phi_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=dichvu_ship] option:selected")
                .attr("phi_ship");
            phi_ship_text = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=dichvu_ship] option:selected")
                .attr("phi_ship_text");
            div_this
                .parent()
                .parent()
                .parent()
                .find(".phiship_don")
                .attr("phi", phi_ship);
            div_this
                .parent()
                .parent()
                .parent()
                .find(".phiship_don span")
                .html(phi_ship_text);

            total_price = div_this
                .parent()
                .parent()
                .parent()
                .find(".tongtien_don")
                .attr("total_price");
            phi_ship = div_this
                .parent()
                .parent()
                .parent()
                .find(".phiship_don")
                .attr("phi");
            chiu_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=chiu_ship]")
                .val();
            cod = div_this.parent().parent().parent().find("input[name=cod]").val();
            cod = cod.replace(/,/g, "");
            if (chiu_ship == "shop") {
                hoahong = cod - total_price - phi_ship;
            } else {
                hoahong = cod - total_price;
            }
            div_this
                .parent()
                .parent()
                .parent()
                .find(".hoahong_don span")
                .html(format_price(hoahong) + "đ");
        }
    );
    ///////////////////
    $("body").on("keyup", ".box_order_info_left_bt input[name=cod]", function () {
        total_price = $(".total_price").attr("total_price");
        phi_ship = $(".total_phi").attr("phi");
        chiu_ship = $("select[name=chiu_ship]").val();
        cod = $(this).val();
        if (cod.length < 4) {
        } else {
            cod = cod.replace(/,/g, "");
            cod = parseFloat(cod, 2);
            $(this).val(format_price(cod));
        }
        if (chiu_ship == "shop") {
            hoahong = cod - total_price - phi_ship;
        } else {
            hoahong = cod - total_price;
        }
        $(".total_hoahong").html(format_price(hoahong) + "đ");
    });
    ///////////////////
    $("body").on(
        "keyup",
        ".box_order_info_left_gop input[name=cod]",
        function () {
            var div_this = $(this);
            total_price = div_this
                .parent()
                .parent()
                .parent()
                .find(".tongtien_don")
                .attr("total_price");
            phi_ship = div_this
                .parent()
                .parent()
                .parent()
                .find(".phiship_don")
                .attr("phi");
            chiu_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=chiu_ship]")
                .val();
            cod = $(this).val();
            if (cod.length < 4) {
            } else {
                cod = cod.replace(/,/g, "");
                cod = parseFloat(cod, 2);
                $(this).val(format_price(cod));
            }
            if (chiu_ship == "shop") {
                hoahong = cod - total_price - phi_ship;
            } else {
                hoahong = cod - total_price;
            }
            div_this
                .parent()
                .parent()
                .parent()
                .find(".hoahong_don span")
                .html(format_price(hoahong) + "đ");
        }
    );
    /////////////////////////////
    $("body").on(
        "change",
        ".box_order_info_left_bt select[name=chiu_ship]",
        function () {
            total_price = $(".total_price").attr("total_price");
            phi_ship = $(".total_phi").attr("phi");
            chiu_ship = $("select[name=chiu_ship]").val();
            cod = $("input[name=cod]").val();
            cod = cod.replace(/,/g, "");
            if (chiu_ship == "shop") {
                hoahong = cod - total_price - phi_ship;
            } else {
                hoahong = cod - total_price;
            }
            $(".total_hoahong").html(format_price(hoahong) + "đ");
        }
    );
    ////////////////////////////
    $("body").on(
        "change",
        ".box_order_info_left_gop select[name=chiu_ship]",
        function () {
            var div_this = $(this);
            total_price = div_this
                .parent()
                .parent()
                .parent()
                .find(".tongtien_don")
                .attr("total_price");
            phi_ship = div_this
                .parent()
                .parent()
                .parent()
                .find(".phiship_don")
                .attr("phi");
            chiu_ship = div_this
                .parent()
                .parent()
                .parent()
                .find("select[name=chiu_ship]")
                .val();
            cod = div_this.parent().parent().parent().find("input[name=cod]").val();
            cod = cod.replace(/,/g, "");
            if (chiu_ship == "shop") {
                hoahong = cod - total_price - phi_ship;
            } else {
                hoahong = cod - total_price;
            }
            div_this
                .parent()
                .parent()
                .parent()
                .find(".hoahong_don span")
                .html(format_price(hoahong) + "đ");
        }
    );
    //////////////////////////
    $(".button_dathang").on("click", function () {
        var list_mau = "";
        $(".li_shopcart").each(function () {
            if ($(this).find("input").length > 0) {
                mau = $(this).find("input:checked").val();
                sp_id = $(this).find("input:checked").attr("sp_id");
                list_mau += sp_id + "&&" + mau + "|";
            }
        });
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_mau",
                list_mau: list_mau,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/add-donhang-drop?step=3&type=san";
                    }
                }, 3000);
            },
        });
    });
    //////////////////////////
    $(".button_dathang_gopdon").on("click", function () {
        var list_mau = "";
        $(".li_shopcart").each(function () {
            if ($(this).find("input").length > 0) {
                mau = $(this).find("input:checked").val();
                sp_id = $(this).find("input:checked").attr("sp_id");
                list_mau += sp_id + "&&" + mau + "|";
            }
        });
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_mau",
                list_mau: list_mau,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/add-donhang-drop?step=3&type=gopdon";
                    }
                }, 3000);
            },
        });
    });
    //////////////////////////
    $(".add_order .li_doituong").on("click", function () {
        khach = $(this).attr("khach");
        total_sp = $(".li_shopcart_right").length;
        total_kh = $(".box_khach_order").length;
        if (total_sp <= total_kh) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Thất bại! Số người nhận vượt quá số sản phẩm");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (total_kh >= 5) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Thất bại! Chỉ thêm tối đa 5 người nhận");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else {
            if (total_kh < 1) {
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "add_doituong",
                        khach: khach,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $(".list_khach_order")
                            .find(".info_khach_order:visible")
                            .parent()
                            .find(".title")
                            .click();
                        $(".list_khach_order").append(info.html);
                        i = 0;
                        $(".box_khach_order").each(function () {
                            i++;
                            $(this).find(".number").html(i);
                            if ($(this).find(".info_don_hang").length > 0) {
                                $(this).find(".info_don_hang").attr("box", i);
                            }
                        });
                        $(".li_shopcart_right").each(function () {
                            don = 1;
                            sp_id = $(this).find(".list_kh").attr("sp_id");
                            sl = $(this).find(".list_kh").attr("sl");
                            stt = $(this).find(".list_kh").attr("i");
                            //$(this).parent().hide();
                            $(this).find(".don span").html(don);
                            $.ajax({
                                url: "/ncc/process.php",
                                type: "post",
                                data: {
                                    action: "update_cart_gop",
                                    don: don,
                                    sp_id: sp_id,
                                    sl: sl,
                                    stt: stt,
                                },
                                success: function (kq) {
                                    var info = JSON.parse(kq);
                                    var don_this = "";
                                    $(".box_khach_order").each(function () {
                                        don_this = $(this).find(".title .number").html();
                                        if (typeof info.tongtien_don[don_this] !== "undefined") {
                                            $(this)
                                                .find(".tongtien_don")
                                                .attr("total_price", info.tongtien_don[don_this]);
                                            $(this)
                                                .find(".tongtien_don span")
                                                .html(format_price(info.tongtien_don[don_this]) + " đ");
                                        } else {
                                        }
                                    });
                                },
                            });
                        });
                        $(".button_hoanthanh").show();
                    },
                });
            } else {
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: "add_doituong",
                        khach: khach,
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $(".list_khach_order")
                            .find(".info_khach_order:visible")
                            .parent()
                            .find(".title")
                            .click();
                        $(".list_khach_order").append(info.html);
                        i = 0;
                        $(".box_khach_order").each(function () {
                            i++;
                            $(this).find(".number").html(i);
                            if ($(this).find(".info_don_hang").length > 0) {
                                $(this).find(".info_don_hang").attr("box", i);
                            }
                        });
                        $(".button_hoanthanh").show();
                    },
                });
            }
        }
    });
    //////////////////////////
    $("body").on(
        "click",
        ".list_khach_order .box_khach_order .title",
        function () {
            $(this).parent().find(".info_khach_order").toggle();
            $(this).parent().find(".fa-chevron-up").toggle();
            $(this).parent().find(".fa-chevron-down").toggle();
        }
    );
    //////////////////////////
    $("body").on("click", ".del_khach_order", function () {
        $(this).parent().parent().parent().remove();
        i = 0;
        total_kh = $(".box_khach_order").length;
        if (total_kh == 0) {
            $(".button_hoanthanh").hide();
        } else {
            $(".button_hoanthanh").show();
        }
        $(".box_khach_order").each(function () {
            i++;
            $(this).find(".number").html(i);
            $(".don span").html("Chọn");
            if ($(this).find(".info_don_hang").length > 0) {
                $(this).find(".info_don_hang").attr("box", i);
            }
        });
    });
    //////////////////////////
    $("body").on(
        "click",
        ".li_shopcart_right .info .tieude .action_gop .don span",
        function () {
            total_kh = $(".box_khach_order").length;
            var div_sp = $(this);
            div_sp.parent().parent().find(".list_kh").html("");
            if (total_kh > 0) {
                i = 0;
                $(".box_khach_order").each(function () {
                    i++;
                    div_sp
                        .parent()
                        .parent()
                        .find(".list_kh")
                        .append(
                            '<div class="li_kh">Khách hàng <span>' + i + "</span></div>"
                        );
                });
                div_sp.parent().parent().find(".list_kh").toggle();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                setTimeout(function () {
                    $(".load_note").html("Thất bại! Vui lòng thêm người nhận trước");
                }, 500);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 2000);
            }
        }
    );
    //////////////////////////
    $("body").on(
        "click",
        ".li_shopcart_right .info .tieude .list_kh .li_kh",
        function () {
            don = $(this).find("span").html();
            sp_id = $(this).parent().attr("sp_id");
            sl = $(this).parent().attr("sl");
            stt = $(this).parent().attr("i");
            $(this).parent().hide();
            $(this).parent().parent().find(".don span").html(don);
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "update_cart_gop",
                    don: don,
                    sp_id: sp_id,
                    sl: sl,
                    stt: stt,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    var don_this = "";
                    $(".box_khach_order").each(function () {
                        don_this = $(this).find(".title .number").html();
                        if (typeof info.tongtien_don[don_this] !== "undefined") {
                            $(this)
                                .find(".tongtien_don")
                                .attr("total_price", info.tongtien_don[don_this]);
                            $(this)
                                .find(".tongtien_don span")
                                .html(format_price(info.tongtien_don[don_this]) + " đ");
                        } else {
                        }
                    });
                },
            });
        }
    );
    //////////////////////////
    $(".button_dathang_socdo").on("click", function () {
        var list_mau = "";
        $(".li_shopcart").each(function () {
            if ($(this).find("input").length > 0) {
                mau = $(this).find("input:checked").val();
                sp_id = $(this).find("input:checked").attr("sp_id");
                list_mau += sp_id + "&&" + mau + "|";
            }
        });
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "update_mau",
                list_mau: list_mau,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                    if (info.ok == 1) {
                        window.location.href = "/ncc/add-donhang-drop?step=3&type=socdo";
                    }
                }, 3000);
            },
        });
    });
    ///////////////////////////// nhatthem94
    $("body").on("click", "button[name=button_profile]", function () {
        var name = $("input[name=name]").val();
        var mobile = $("input[name=mobile]").val();
        var maso_thue = $("input[name=maso_thue]").val();
        var maso_thue_cap = $("input[name=maso_thue_cap]").val();
        var maso_thue_noicap = $("input[name=maso_thue_noicap]").val();
        var email = $("input[name=email]").val();
        var dia_chi = $("input[name=dia_chi]").val();
        var tinh = $("select[name=tinh]").val();
        var huyen = $("select[name=huyen]").val();
        var xa = $("select[name=xa]").val();
        var ten_daidien = $("input[name=ten_daidien]").val();
        var chucvu = $("input[name=chucvu]").val();

        var errorMessage = "";

        if (name.length < 2) {
            errorMessage =
                "Vui lòng nhập tên công ty/hộ kinh doanh đầy đủ (ít nhất 2 ký tự)";
            $("input[name=name]").focus();
        } else if (mobile.length < 10 || !/^[0-9]{10}$/.test(mobile)) {
            errorMessage = "Vui lòng nhập số điện thoại hợp lệ (10 chữ số)";
            $("input[name=mobile]").focus();
        } else if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errorMessage = "Vui lòng nhập email hợp lệ";
            $("input[name=email]").focus();
        } else if (!maso_thue) {
            errorMessage = "Vui lòng nhập mã số thuế hoặc CCCD";
            $("input[name=maso_thue]").focus();
        } else if (!ten_daidien) {
            errorMessage = "Vui lòng nhập tên người đại diện";
            $("input[name=ten_daidien]").focus();
        } else if (!chucvu) {
            errorMessage = "Vui lòng nhập chức vụ";
            $("input[name=chucvu]").focus();
        } else if (!tinh) {
            errorMessage = "Vui lòng chọn tỉnh/thành phố";
            $("select[name=tinh]").focus();
        } else if (!huyen) {
            errorMessage = "Vui lòng chọn quận/huyện";
            $("select[name=huyen]").focus();
        } else if (!xa) {
            errorMessage = "Vui lòng chọn phường/xã";
            $("select[name=xa]").focus();
        } else if (!dia_chi) {
            errorMessage = "Vui lòng nhập địa chỉ chi tiết";
            $("input[name=dia_chi]").focus();
        }

        if (errorMessage) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $(".load_note").html(errorMessage);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 3000);
            return;
        }

        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
            url: "/ncc/process.php",
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
                maso_thue_cap: maso_thue_cap,
                ten_daidien: ten_daidien,
                chucvu: chucvu,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
                setTimeout(function () {
                    $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 3000);
            },
            error: function (xhr, status, error) {
                $(".load_note").html("Có lỗi xảy ra: " + error);
                setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                }, 3000);
            },
        });
    });
    /////////////////////////////
    $(".button_change_avatar").click(function () {
        $("#file").click();
    });
    /////////////////////////////
    $(".cover_now .button_change").click(function () {
        $("#file_cover").click();
    });
    /////////////////////////////
    $(".button_check_domain").on("click", function () {
        key_domain = $("textarea[name=key_domain]").val();
        var list_loai = [];
        $("input[name^=loai_domain]:checked").each(function () {
            list_loai.push($(this).val());
        });
        list_loai = list_loai.toString();
        if (key_domain.length < 2) {
            $("textarea[name=key_domain]").focus();
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng nhập tên miền cần kiểm tra");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else if (list_loai.length < 2) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn loại tên miền");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 2000);
        } else {
            var form_data = new FormData();
            form_data.append("action", "get_domain");
            form_data.append("key_domain", key_domain);
            form_data.append("list_loai", list_loai);
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $(".list_result").html(info.list);
                        check_domain();
                    } else {
                        $(".load_overlay").show();
                        $(".load_process").fadeIn();
                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                        }, 2000);
                    }
                },
            });
        }
    });
    // Thêm màu cho nhà cung cấp
    /////////////////////////////
    $("button[name=add_color]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        ma_mau = $("input[name=ma_mau]").attr("data-current-color");
        thu_tu = $("input[name=thu_tu]").val();
        if (tieu_de.length < 2) {
            $("input[name=tieu_de]").focus();
        } else if (ma_mau.length < 6) {
            $("input[name=ma_mau]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "add_color",
                    tieu_de: tieu_de,
                    ma_mau: ma_mau,
                    thu_tu: thu_tu,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_color]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        ma_mau = $("input[name=ma_mau]").attr("data-current-color");
        thu_tu = $("input[name=thu_tu]").val();
        id = $("input[name=id]").val();
        if (tieu_de.length < 2) {
            $("input[name=tieu_de]").focus();
        } else if (ma_mau.length < 6) {
            $("input[name=ma_mau]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "edit_color",
                    tieu_de: tieu_de,
                    ma_mau: ma_mau,
                    thu_tu: thu_tu,
                    id: id,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-color";
                        } else {
                        }
                    }, 3000);
                },
            });
        }
    });
    // phân loại sản phẩm ngoài nhà cung cấp
    // $('.button_add_phanloai').on('click', function() {
    //     $('.list_phanloai').append('<div class="li_phanloai" pl=""><div class="info_ma"><input type="text" name="ma[]" placeholder="Mã"></div><div class="info_name"><input type="text" name="size[]" value="" giatri="" placeholder="Kích cỡ"><div class="list_goiy scroll"></div></div><div class="info_mau"><input type="text" name="color[]" value="" giatri="" placeholder="Màu sắc"><div class="list_goiy scroll"></div></div><div class="info_name"><input type="text" name="size[]" placeholder="Kích cỡ"><div class="list_goiy scroll"></div></div><div class="info_mau"><input type="text" name="color[]" placeholder="Màu sắc"><div class="list_goiy scroll"></div></div><div class="info_can_nang"><input type="text" name="can_nang[]" placeholder="Trọng lượng"></div><div class="info_gia"><input type="text" name="gia_cu[]" class="price_format" placeholder="Giá niêm yết"></div><div class="info_gia"><input type="text" name="gia_moi[]" class="price_format" placeholder="Giá bán"></div><div class="info_gia"><input type="text" name="gia_drop[]" class="price_format" placeholder="Giá Drop"></div><div class="info_gia"><input type="text" name="gia_ctv[]" class="price_format" placeholder="Giá CTV"></div><div class="info_action"><i class="fa fa-trash-o"></i> Xóa</div></div>');
    // });
    //////////////
    $("body").on(
        "keyup",
        ".list_phanloai .li_phanloai input[name^=gia_moi]",
        function () {
            gia_moi = $(this).val();
            $(this).parent().parent().find("input[name^=drop_min]").val(gia_moi);
        }
    );
    //////////////
    $("body").on(
        "keyup",
        ".list_phanloai .li_phanloai input[name^=gia_drop]",
        function () {
            drop_min = parseFloat(
                $(this)
                    .parent()
                    .parent()
                    .find("input[name^=drop_min]")
                    .val()
                    .replace(/,/g, "")
            );
            gia_drop = parseFloat($(this).val().replace(/,/g, ""));
            gia_ctv = gia_drop + (drop_min - gia_drop) * 0.3;
            $(this)
                .parent()
                .parent()
                .find("input[name^=gia_ctv]")
                .val(format_price(gia_ctv));
        }
    );
    //////////////
    $("body").on(
        "keyup",
        ".list_phanloai .li_phanloai input[name^=drop_min]",
        function () {
            gia_drop = parseFloat(
                $(this)
                    .parent()
                    .parent()
                    .find("input[name^=gia_drop]")
                    .val()
                    .replace(/,/g, "")
            );
            drop_min = parseFloat($(this).val().replace(/,/g, ""));
            gia_ctv = gia_drop + (drop_min - gia_drop) * 0.3;
            $(this)
                .parent()
                .parent()
                .find("input[name^=gia_ctv]")
                .val(format_price(gia_ctv));
        }
    );
    //////////////
    $("body").on("click", ".list_phanloai .list_goiy .li_goiy", function () {
        value = $(this).attr("value");
        text = $(this).text();
        $(this).parent().parent().find("input").val(text);
        $(this).parent().parent().find("input").attr("giatri", value);
        if ($(this).attr("ma_mau") !== undefined) {
            mm = $(this).attr("ma_mau");
            $(this).parent().parent().find("input").attr("ma_mau", mm);
        } else {
        }
        $(this).parent().html("");
    });
    //   gợi ý socdo

    //   Hàm xử lý sự kiện keyup cho size
    // $('body').on('keyup', '.list_phanloai input[name^=size]', function() {
    //     var li = $(this);
    //     var key = li.val();
    //     var url = li.attr('name') === 'size_shop[]' ? '/ncc/process.php' : '/admincp/process.php';
    //     var action = li.attr('name') === 'size_shop[]' ? 'goiy_size_ncc' : 'goiy_size';

    //     if (key !== '') {
    //         $.ajax({
    //             url: url,
    //             type: "post",
    //             data: { action: action, key: key },
    //             dataType: 'json',
    //             success: function(info) {
    //                 li.closest('.info_name').find('.list_goiy').html(info.list);
    //             }
    //         });
    //     } else {
    //         li.closest('.info_name').find('.list_goiy').html('');
    //     }
    // });

    // Hàm xử lý sự kiện keyup cho màu
    $("body").on("keyup", ".list_phanloai input[name^=color]", function () {
        var li = $(this);
        var key = li.val();
        var url =
            li.attr("name") === "color_shop[]"
                ? "/ncc/process.php"
                : "/admincp/process.php";
        var action =
            li.attr("name") === "color_shop[]" ? "goiy_color_ncc" : "goiy_color";

        if (key !== "") {
            $.ajax({
                url: url,
                type: "post",
                data: { action: action, key: key },
                dataType: "json",
                success: function (info) {
                    li.closest(".info_mau").find(".list_goiy").html(info.list);
                },
            });
        } else {
            li.closest(".info_mau").find(".list_goiy").html("");
        }
    });

    $("body").on(
        "click",
        ".list_phanloai .li_phanloai .info_action",
        function () {
            $(this).parent().remove();
        }
    );

    /////////////////////////////end nhà cung cấp
    // $('button[name=add_sanpham_ngoai]').on('click', function () {
    //     tieu_de = $('input[name=tieu_de]').val();
    //     // gia_cu = $('input[name=gia_cu]').val();
    //     // gia_moi = $('input[name=gia_moi]').val();
    //     kho = $('input[name=kho]').val();
    //     var list_photo = [];
    //     $('.list_photo img').each(function () {
    //         list_photo.push($(this).attr('src'));
    //     });
    //     anh = list_photo.toString();
    //     minh_hoa = $('#preview-minhhoa').attr('src');
    //     title = $('input[name=title]').val();
    //     description = $('textarea[name=description]').val();
    //     var list_cat = [];
    //     $('.li_input input[name^=category]:checked').each(function () {
    //         list_cat.push($(this).val());
    //     });
    //     list_cat = list_cat.toString();
    //     // cat của NCC
    //     var list_cat_ncc = [];
    //      $('.li_input input[name^=category_ncc]:checked').each(function() {
    //          list_cat_ncc.push($(this).val());
    //      });
    //      list_cat_ncc = list_cat_ncc.toString();
    //     var list_color = [];
    //     $('.li_input input[name^=color]:checked').each(function () {
    //         list_color.push($(this).val());
    //     });
    //     list_color = list_color.toString();
    //     /*        var list_size = [];
    //             $('.li_input input[name^=size]:checked').each(function() {
    //                 list_size.push($(this).val());
    //             });
    //             list_size = list_size.toString();*/
    //     size = $('select[name=size]').val();
    //     size_2 = $('input[name=size_2]').val();
    //     can_nang = $('input[name=can_nang]').val();
    //     thuong_hieu = $('select[name=thuong_hieu]').val();
    //     thuong_hieu_2 = $('input[name=thuong_hieu_2]').val();
    //     var list_info = '';
    //     $('.li_info').each(function () {
    //         info_name = $(this).find('input[name^=info_name]').val();
    //         info_value = $(this).find('input[name^=info_value]').val();
    //         if (info_name != '') {
    //             list_info += info_name + '&&' + info_value + '|';
    //         }
    //     });
    //     noibat = tinyMCE.get('noibat').getContent();
    //     noidung = tinyMCE.get('edit_textarea').getContent();
    //     link = $('input[name=link]').val();
    //     // thêm nơi bán
    //     var list_noiban = [];
    //      $('.li_input input[name^=noiban]:checked').each(function() {
    //          list_noiban.push($(this).val());
    //      });
    //      list_noiban = list_noiban.toString();
    //     // thêm phân loại
    //     var list_phanloai = '';
    //     pl=0;
    //     $('.list_phanloai .li_phanloai').each(function() {
    //         ma_sp = $(this).find('input[name^=ma]').val();
    //         size = $(this).find('input[name^=size]').attr('giatri');
    //         color = $(this).find('input[name^=color]').attr('giatri');
    //         ma_mau = $(this).find('input[name^=color]').attr('ma_mau');
    //         ten_size = $(this).find('input[name^=size]').val();
    //         ten_color = $(this).find('input[name^=color]').val();
    //         can_nang = $(this).find('input[name^=can_nang]').val();
    //         gia_cu = $(this).find('input[name^=gia_cu]').val();
    //         gia_moi = $(this).find('input[name^=gia_moi]').val();
    //         gia_drop = $(this).find('input[name^=gia_drop]').val();
    //         gia_ctv = $(this).find('input[name^=gia_ctv]').val();
    //         drop_min = $(this).find('input[name^=drop_min]').val();
    //         pl++;
    //         if(pl==1){
    //             list_phanloai+= '{"ma_sp":"'+ma_sp+'","ma_mau":"'+ma_mau+'","color":"'+color+'","size":"'+size+'","ten_color":"'+ten_color+'","ten_size":"'+ten_size+'","can_nang":"'+can_nang+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia_drop":"'+gia_drop+'","gia_ctv":"'+gia_ctv+'","drop_min":"'+drop_min+'"}';
    //         }else{
    //             list_phanloai+= ',{"ma_sp":"'+ma_sp+'","ma_mau":"'+ma_mau+'","color":"'+color+'","size":"'+size+'","ten_color":"'+ten_color+'","ten_size":"'+ten_size+'","can_nang":"'+can_nang+'","gia_cu":"'+gia_cu+'","gia_moi":"'+gia_moi+'","gia_drop":"'+gia_drop+'","gia_ctv":"'+gia_ctv+'","drop_min":"'+drop_min+'"}';
    //         }
    //     });

    //     if (tieu_de.length < 4) {
    //         $('input[name=tieu_de]').focus();
    //     } else if (gia_cu == '') {
    //         $('input[name=gia_cu]').focus();
    //     } else if (gia_moi == '') {
    //         $('input[name=gia_moi]').focus();
    //     } else if (noibat.length < 10) {
    //         tinymce.execCommand('mceFocus', false, 'noibat');
    //     } else if (noidung.length < 10) {
    //         tinymce.execCommand('mceFocus', false, 'edit_textarea');
    //     } else if (title == '') {
    //         $('input[name=title]').focus();
    //     } else if (description == '') {
    //         $('textarea[name=description]').focus();
    //     } else {
    //         var file_data = $('#minh_hoa').prop('files')[0];
    //         var form_data = new FormData();
    //         form_data.append('action', 'add_sanpham_ngoai');
    //         form_data.append('tieu_de', tieu_de);
    //         // form_data.append('gia_cu', gia_cu);
    //         // form_data.append('gia_moi', gia_moi);
    //         form_data.append('kho', kho);
    //         form_data.append('anh', anh);
    //         form_data.append('minh_hoa', minh_hoa);
    //         form_data.append('file', file_data);
    //         form_data.append('link', link);
    //         form_data.append('category', list_cat);
    //         //form_data.append('color', list_color);
    //         //form_data.append('size', size);
    //         //form_data.append('size_2', size_2);
    //         //form_data.append('can_nang', can_nang);
    //         // Thêm phân loại, nơi bán, danh mục của nhà cung cấp
    //         form_data.append('category_ncc', list_cat_ncc);
    //         form_data.append('phan_loai', list_phanloai);
    //         form_data.append('noiban', list_noiban);

    //         form_data.append('thuong_hieu', thuong_hieu);
    //         form_data.append('thuong_hieu_2', thuong_hieu_2);
    //         form_data.append('info', list_info);
    //         form_data.append('noibat', noibat);
    //         form_data.append('noidung', noidung);
    //         form_data.append('title', title);
    //         form_data.append('description', description);
    //         $('.load_overlay').show();
    //         $('.load_process').fadeIn();
    //         console.log('Data being sent:');
    //         for (var pair of form_data.entries()) {
    //             console.log(pair[0] + ':', pair[1]);
    //         }
    //         // $.ajax({
    //         //     url: '/ncc/process.php',
    //         //     type: 'post',
    //         //     cache: false,
    //         //     contentType: false,
    //         //     processData: false,
    //         //     data: form_data,

    //         //     success: function (kq) {
    //         //         var info = JSON.parse(kq);
    //         //         setTimeout(function () {
    //         //             $('.load_note').html(info.thongbao);
    //         //         }, 1000);
    //         //         setTimeout(function () {
    //         //             $('.load_process').hide();
    //         //             $('.load_note').html('Hệ thống đang xử lý');
    //         //             $('.load_overlay').hide();
    //         //             if (info.ok == 1) {
    //         //                 window.location.reload();
    //         //             }
    //         //         }, 3000);
    //         //     }

    //         // });

    //     }
    // });
    // test
    // Phân loại sản phẩm ngoài nhà cung cấp
    // Phân loại sản phẩm ngoài nhà cung cấp
    // comment từ chỗ này
    // Hàm tạo mã ngẫu nhiên theo định dạng: chữ cái + số + ngày tháng hiện tại
    function generateRandomCode() {
        // Lấy ngày tháng hiện tại
        const now = new Date();
        const day = String(now.getDate()).padStart(2, "0"); // DD
        const month = String(now.getMonth() + 1).padStart(2, "0"); // MM (tháng bắt đầu từ 0 nên +1)
        const year = now.getFullYear(); // YYYY
        const dateStr = `${day}${month}${year}`; // DDMMYYYY, ví dụ: 23032025

        // Tạo 3 ký tự ngẫu nhiên (2 chữ cái + 1 số)
        const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const numbers = "0123456789";
        const randomLetter1 = letters.charAt(
            Math.floor(Math.random() * letters.length)
        ); // Chữ cái 1
        const randomLetter2 = letters.charAt(
            Math.floor(Math.random() * letters.length)
        ); // Chữ cái 2
        const randomNumber = numbers.charAt(
            Math.floor(Math.random() * numbers.length)
        ); // Số

        // Kết hợp thành mã: chữ cái + số + ngày tháng
        const randomCode = `${randomLetter1}${randomNumber}${randomLetter2}${dateStr}`;
        return randomCode; // Ví dụ: K7X23032025
    }

    // Phân loại sản phẩm ngoài nhà cung cấp
    //3-4
    $(".button_add_phanloai").on("click", function () {
        // Tạo mã ngẫu nhiên
        const randomCode = generateRandomCode();

        // Thêm hàng phân loại mới với mã tự động
        $(".list_phanloai").append(
            '<div class="li_phanloai" pl="">' +
            '<div class="info_ma"><input type="text" name="ma[]" placeholder="Mã" value="' +
            randomCode +
            '"  ></div>' +
            '<div class="info_name"><input type="text" name="size[]" giatri="" placeholder="Kích cỡ">' +
            '<input type="hidden" name="ten_size[]"><div class="list_goiy scroll"></div></div>' +
            '<div class="info_mau"><input type="text" name="color[]" giatri="" placeholder="Màu sắc">' +
            '<input type="hidden" name="ten_color[]"><input type="hidden" name="ma_mau[]"><div class="list_goiy scroll"></div></div>' +
            '<div class="info_can_nang"><input type="text" name="can_nang[]" value="0" placeholder="Trọng lượng"></div>' +
            '<div class="info_gia"><input type="text" name="gia_cu[]" class="price_format" value="0" placeholder="Giá niêm yết"></div>' +
            '<div class="info_gia"><input type="text" name="gia_moi[]" class="price_format" value="0" placeholder="Giá bán"></div>' +
            '<div class="info_gia" style="display: none;"><input type="text" name="gia_drop[]" class="price_format" value="0" placeholder="Giá Drop"></div>' +
            '<div class="info_gia" style="display: none;"><input type="text" name="gia_ctv[]" class="price_format" value="0" placeholder="Giá CTV"></div>' +
            '<div class="info_gia" style="display: none;"><input type="text" name="gia_socdo[]" class="price_format" value="0" placeholder="Giá trên Sóc Đỏ"></div>' +
            '<div class="info_kho_sanpham_shop"><input type="text" name="kho_sanpham_shop[]" class="price_format" value="0" placeholder="Số hàng trong kho"></div>' +
            '<div class="info_trongluongtinhship"><input type="text" name="trongluongtinhship[]" class="price_format" value="0" readonly></div>' +
            '<div class="info_action"><i class="fa fa-trash-o"></i></div>' +
            '<div class="info_action_copy"><i class="fa fa-files-o"></i></div></div>'
        );
        updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship khi thêm mới
    });
    // '<div class="info_gia"><input type="text" name="gia_drop[]" style="display: none;" class="price_format" value="0" placeholder="Giá Drop"></div>' +
    //         '<div class="info_gia"><input type="text" name="gia_ctv[]" style="display: none;" class="price_format" value="0" placeholder="Giá CTV"></div>' +
    //         '<div class="info_gia"><input type="text" name="gia_socdo[]" style="display: none;" class="price_format" value="0" placeholder="Giá trên Sóc Đỏ"></div>' +

    // Tự động tính giá
    $("body").on(
        "keyup",
        ".list_phanloai .li_phanloai input[name^=gia_moi]",
        function () {
            gia_moi = $(this).val();
            $(this).parent().parent().find("input[name^=drop_min]").val(gia_moi);
            updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship
        }
    );

    $("body").on(
        "keyup",
        ".list_phanloai .li_phanloai input[name^=gia_drop]",
        function () {
            drop_min = parseFloat(
                $(this)
                    .parent()
                    .parent()
                    .find("input[name^=drop_min]")
                    .val()
                    .replace(/,/g, "")
            );
            gia_drop = parseFloat($(this).val().replace(/,/g, ""));
            gia_ctv = gia_drop + (drop_min - gia_drop) * 0.3;
            $(this)
                .parent()
                .parent()
                .find("input[name^=gia_ctv]")
                .val(format_price(gia_ctv));
            updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship
        }
    );

    $("body").on(
        "keyup",
        ".list_phanloai .li_phanloai input[name^=drop_min]",
        function () {
            gia_drop = parseFloat(
                $(this)
                    .parent()
                    .parent()
                    .find("input[name^=gia_drop]")
                    .val()
                    .replace(/,/g, "")
            );
            drop_min = parseFloat($(this).val().replace(/,/g, ""));
            gia_ctv = gia_drop + (drop_min - gia_drop) * 0.3;
            $(this)
                .parent()
                .parent()
                .find("input[name^=gia_ctv]")
                .val(format_price(gia_ctv));
            updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship
        }
    );

    // Tính trọng lượng tính ship khi thay đổi chiều dài, chiều rộng, chiều cao hoặc trọng lượng
    $("body").on(
        "keyup",
        "input[name=chieudai_shop], input[name=chieurong_shop], input[name=chieucao_shop], .list_phanloai .li_phanloai input[name^=can_nang]",
        function () {
            updateTrongLuongTinhShip();
        }
    );

    // Hàm tính và cập nhật trọng lượng tính ship
    function updateTrongLuongTinhShip() {
        var chieudai =
            parseFloat($("input[name=chieudai_shop]").val().replace(/,/g, "")) || 0;
        var chieurong =
            parseFloat($("input[name=chieurong_shop]").val().replace(/,/g, "")) || 0;
        var chieucao =
            parseFloat($("input[name=chieucao_shop]").val().replace(/,/g, "")) || 0;
        var thetich_sp = chieudai * chieurong * chieucao;
        var trongluong_kichthuoc = thetich_sp / 6000;

        $(".list_phanloai .li_phanloai").each(function () {
            var can_nang =
                parseFloat(
                    $(this).find("input[name^=can_nang]").val().replace(/,/g, "")
                ) || 0;
            var can_nang_tinhship = Math.max(can_nang, trongluong_kichthuoc);
            $(this)
                .find("input[name^=trongluongtinhship]")
                .val(format_price(can_nang_tinhship));
        });
    }

    // Chọn gợi ý từ danh sách
    $("body").on("click", ".list_phanloai .list_goiy .li_goiy", function () {
        value = $(this).attr("value");
        text = $(this).text();
        source = $(this).attr("data-source");
        $(this).parent().parent().find('input[name$="[]"]').val(text);
        $(this).parent().parent().find('input[name$="[]"]').attr("giatri", value);

        if (source === "shop") {
            if (
                $(this).parent().parent().find('input[name="color_shop[]"]').length > 0
            ) {
                $(this)
                    .parent()
                    .parent()
                    .find('input[name="ten_color_shop[]"]')
                    .val(text);
                if ($(this).attr("ma_mau") !== undefined) {
                    mm = $(this).attr("ma_mau");
                    $(this).parent().parent().find('input[name="ma_mau_shop[]"]').val(mm);
                }
            } else if (
                $(this).parent().parent().find('input[name="size_shop[]"]').length > 0
            ) {
                $(this)
                    .parent()
                    .parent()
                    .find('input[name="ten_size_shop[]"]')
                    .val(text);
            }
        } else if (source === "socdo") {
            if ($(this).parent().parent().find('input[name="color[]"]').length > 0) {
                $(this).parent().parent().find('input[name="ten_color[]"]').val(text);
                if ($(this).attr("ma_mau") !== undefined) {
                    mm = $(this).attr("ma_mau");
                    $(this).parent().parent().find('input[name="ma_mau[]"]').val(mm);
                }
            } else if (
                $(this).parent().parent().find('input[name="size[]"]').length > 0
            ) {
                $(this).parent().parent().find('input[name="ten_size[]"]').val(text);
            }
        }
        $(this).parent().html("");
        //  updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship
    });
    // Gợi ý thương hiệu khi nhập từ khóa
    // Gợi ý thương hiệu Sóc Đỏ khi nhập từ khóa
    $(".brand-socdo-input").on("keyup", function () {
        var input = $(this);
        var key = input.val();
        if (key !== "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: { action: "goiy_brand", key: key },
                dataType: "json",
                success: function (info) {
                    console.log("Gợi ý trả về:", info); // Debug: Kiểm tra dữ liệu trả về
                    input.closest(".info_name").find(".list_goiy").html(info.list);
                    $("input[name=tieu_de]").prop("disabled", true); //2-4
                },
                error: function (xhr, status, error) {
                    console.error("Lỗi khi gọi API gợi ý:", error); // Debug: Kiểm tra lỗi AJAX
                },
            });
        } else {
            input.closest(".info_name").find(".list_goiy").html("");
            $("input[name=id_thuonghieu_socdo]").val("0");
            $("input[name=tieu_de]").prop("disabled", false).val(""); //2-4
        }
    });

    // Khi chọn thương hiệu gợi ý
    $("body").on("click", ".li_phanloai .li_goiy", function () {
        var id = $(this).attr("value");
        var tieu_de = $(this).text().trim();
        $("input[name=id_thuonghieu_socdo]").val(id);
        $(".brand-socdo-input-text").val(tieu_de);
        $(".list_goiy").html(""); // Ẩn danh sách gợi ý sau khi chọn
    });
    // Gợi ý màu sắc Sóc Đỏ khi nhập từ khóa
    $(".color-socdo-input").on("keyup", function () {
        var input = $(this);
        var key = input.val();
        if (key !== "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: { action: "goiy_color", key: key },
                dataType: "json",
                success: function (info) {
                    console.log("Gợi ý trả về:", info); // Debug: Kiểm tra dữ liệu trả về
                    input.closest(".info_mau").find(".list_goiy").html(info.list);
                },
                error: function (xhr, status, error) {
                    console.error("Lỗi khi gọi API gợi ý:", error); // Debug: Kiểm tra lỗi AJAX
                },
            });
        } else {
            input.closest(".info_mau").find(".list_goiy").html("");
            $("input[name=id_mau_socdo]").val("0");
        }
    });

    // Khi chọn màu gợi ý
    $("body").on("click", ".li_goiy", function () {
        var id = $(this).attr("value");
        var tieu_de = $(this).find(".color-name").text();
        var ma_mau = $(this).attr("ma_mau");

        // Debug: Kiểm tra giá trị lấy được
        console.log("ID:", id);
        console.log("Tiêu đề:", tieu_de);
        console.log("Mã màu:", ma_mau);

        // Điền giá trị vào các ô
        // $('input[name=tieu_de]').val(tieu_de); //3-4
        $("input[name=ma_mau]").val(ma_mau);

        // Cập nhật giá trị cho jscolor
        // try {
        //     $('input[name=ma_mau]').get(0).jscolor.fromString(ma_mau);
        // } catch (e) {
        //     console.error('Lỗi khi cập nhật jscolor:', e); // Debug: Kiểm tra lỗi jscolor
        // }

        $("input[name=id_mau_socdo]").val(id);
        $(".color-socdo-input").val(tieu_de);
        $(".list_goiy").html(""); // Ẩn danh sách gợi ý sau khi chọn
    });
    // Gợi ý kích cỡ Sóc Đỏ khi nhập từ khóa
    $(".size-socdo-input").on("keyup", function () {
        var input = $(this);
        var key = input.val();
        if (key !== "") {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: { action: "goiy_size", key: key },
                dataType: "json",
                success: function (info) {
                    console.log("Gợi ý trả về:", info); // Debug: Kiểm tra dữ liệu trả về
                    input.closest(".info_name").find(".list_goiy").html(info.list);
                },
                error: function (xhr, status, error) {
                    console.error("Lỗi khi gọi API gợi ý:", error); // Debug: Kiểm tra lỗi AJAX
                },
            });
        } else {
            input.closest(".info_name").find(".list_goiy").html("");
            $("input[name=id_kichco_socdo]").val("0");
        }
    });
    //3-4
    // Khi chọn kích cỡ gợi ý
    // $('body').on('click', '.li_goiy', function() {
    //     var id = $(this).attr('value');
    //     var tieu_de = $(this).text().trim();

    //     // Debug: Kiểm tra giá trị lấy được
    //     console.log('ID:', id);
    //     console.log('Tiêu đề:', tieu_de);

    //     // Điền giá trị vào các ô
    //     $('input[name=tieu_de]').val(tieu_de);
    //     $('input[name=id_kichco_socdo]').val(id);
    //     $('.size-socdo-input').val(tieu_de);
    //     $('.list_goiy').html(''); // Ẩn danh sách gợi ý sau khi chọn
    // });

    // Gợi ý kích cỡ
    $("body").on("keyup", ".list_phanloai input[name^=size]", function () {
        var li = $(this);
        var key = li.val();
        var url = li.attr("name") === "size[]" ? "/ncc/process.php" : "";
        var action = li.attr("name") === "size[]" ? "goiy_size_ncc" : "";
        if (key !== "") {
            $.ajax({
                url: url,
                type: "post",
                data: { action: action, key: key },
                dataType: "json",
                success: function (info) {
                    li.closest(".info_name").find(".list_goiy").html(info.list);
                },
            });
        } else {
            li.closest(".info_name").find(".list_goiy").html("");
        }
    });

    // Gợi ý màu sắc
    $("body").on("keyup", ".list_phanloai input[name^=color]", function () {
        var li = $(this);
        var key = li.val();
        var url = li.attr("name") === "color[]" ? "/ncc/process.php" : "";
        var action = li.attr("name") === "color[]" ? "goiy_color_ncc" : "";
        if (key !== "") {
            $.ajax({
                url: url,
                type: "post",
                data: { action: action, key: key },
                dataType: "json",
                success: function (info) {
                    li.closest(".info_mau").find(".list_goiy").html(info.list);
                },
            });
        } else {
            li.closest(".info_mau").find(".list_goiy").html("");
        }
    });

    // Xóa phân loại
    $("body").on(
        "click",
        ".list_phanloai .li_phanloai .info_action",
        function () {
            $(this).parent().remove();
            updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship
        }
    );

    // Sao chép phân loại
    $("body").on(
        "click",
        ".list_phanloai .li_phanloai .info_action_copy",
        function () {
            var $row = $(this).closest(".li_phanloai");
            var $newRow = $row.clone();

            // Tạo mã ngẫu nhiên mới cho hàng sao chép
            const newRandomCode = generateRandomCode();

            // Cập nhật giá trị cho hàng mới
            $newRow.find("input[name^=ma]").val(newRandomCode); // Gán mã mới
            $newRow
                .find("input[name^=size_shop]")
                .val($row.find("input[name^=size_shop]").val());
            $newRow
                .find("input[name^=size_shop]")
                .attr("giatri", $row.find("input[name^=size_shop]").attr("giatri"));
            $newRow
                .find("input[name^=ten_size_shop]")
                .val($row.find("input[name^=ten_size_shop]").val());
            $newRow
                .find("input[name^=color_shop]")
                .val($row.find("input[name^=color_shop]").val());
            $newRow
                .find("input[name^=color_shop]")
                .attr("giatri", $row.find("input[name^=color_shop]").attr("giatri"));
            $newRow
                .find("input[name^=ten_color_shop]")
                .val($row.find("input[name^=ten_color_shop]").val());
            $newRow
                .find("input[name^=ma_mau_shop]")
                .val($row.find("input[name^=ma_mau_shop]").val());
            $newRow
                .find("input[name^=size]")
                .val($row.find("input[name^=size]").val());
            $newRow
                .find("input[name^=size]")
                .attr("giatri", $row.find("input[name^=size]").attr("giatri"));
            $newRow
                .find("input[name^=ten_size]")
                .val($row.find("input[name^=ten_size]").val());
            $newRow
                .find("input[name^=color]")
                .val($row.find("input[name^=color]").val());
            $newRow
                .find("input[name^=color]")
                .attr("giatri", $row.find("input[name^=color]").attr("giatri"));
            $newRow
                .find("input[name^=ten_color]")
                .val($row.find("input[name^=ten_color]").val());
            $newRow
                .find("input[name^=ma_mau]")
                .val($row.find("input[name^=ma_mau]").val());
            $newRow
                .find("input[name^=can_nang]")
                .val($row.find("input[name^=can_nang]").val());
            $newRow
                .find("input[name^=gia_cu]")
                .val($row.find("input[name^=gia_cu]").val());
            $newRow
                .find("input[name^=gia_moi]")
                .val($row.find("input[name^=gia_moi]").val());
            $newRow
                .find("input[name^=gia_drop]")
                .val($row.find("input[name^=gia_drop]").val());
            $newRow
                .find("input[name^=gia_ctv]")
                .val($row.find("input[name^=gia_ctv]").val());
            $newRow
                .find("input[name^=kho_sanpham_shop]")
                .val($row.find("input[name^=kho_sanpham_shop]").val());
            $newRow
                .find("input[name^=trongluongtinhship]")
                .val($row.find("input[name^=trongluongtinhship]").val());

            // Xóa danh sách gợi ý
            $newRow.find(".list_goiy").html("");

            // Thêm hàng mới vào danh sách
            $(".list_phanloai").append($newRow);
            updateTrongLuongTinhShip(); // Cập nhật trọng lượng tính ship
        }
    );

    //Gửi dữ liệu khi nhấn nút "Hoàn thành"
    // huyphuc12/05/2025
    $("button[name=add_sanpham_ngoai]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        //kho = $('input[name=kho]').val();
        var list_photo = [];
        $(".list_photo img").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        minh_hoa = $("#preview-minhhoa").attr("src");
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        // Danh mục website shop
        var list_cat = [];
        $(".li_input input[name^=category]:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        // Nơi bán
        var list_noiban = [];
        $(".li_input input[name^=noiban]:checked").each(function () {
            list_noiban.push($(this).val());
        });
        list_noiban = list_noiban.toString();

        // Thông số sản phẩm
        var list_info = "";
        $(".li_info").each(function () {
            info_name = $(this).find("input[name^=info_name]").val();
            info_value = $(this).find("input[name^=info_value]").val();
            if (info_name != "") {
                list_info += info_name + "&&" + info_value + "|";
            }
        });
        // Đặc điểm nổi bật và nội dung chi tiết
        noibat = tinyMCE.get("noibat").getContent();
        noibat2 = stripHtml(noibat);
        noidung = tinyMCE.get("edit_textarea").getContent();
        noidung2 = stripHtml(noidung);
        link = $("input[name=link]").val();
        thuong_hieu = $("select[name=thuong_hieu]").val();
        thuong_hieu_2 = $("input[name=thuong_hieu_2]").val();
        thongtin = $("input[name=thongtin]").val();
        chieudai_shop = $("input[name=chieudai_shop]").val();
        chieurong_shop = $("input[name=chieurong_shop]").val();
        chieucao_shop = $("input[name=chieucao_shop]").val();
        // console.log(noidung);
        // Phân loại sản phẩm
        var list_phanloai = [];
        $(".list_phanloai .li_phanloai").each(function () {
            var phanloai = {
                ma_sp: $(this).find("input[name^=ma]").val() || "",
                size_shop: $(this).find("input[name^=size_shop]").attr("giatri") || "0",
                color_shop:
                    $(this).find("input[name^=color_shop]").attr("giatri") || "0",
                ten_size_shop: $(this).find("input[name^=ten_size_shop]").val() || "",
                ten_color_shop: $(this).find("input[name^=ten_color_shop]").val() || "",
                ma_mau_shop: $(this).find("input[name^=ma_mau_shop]").val() || "",
                size: $(this).find("input[name^=size]").attr("giatri") || "0", // số size
                color: $(this).find("input[name^=color]").attr("giatri") || "0", // số color
                ten_size: $(this).find("input[name^=ten_size]").val() || "", // tên size
                ten_color: $(this).find("input[name^=ten_color]").val() || "", //tên color
                ma_mau: $(this).find("input[name^=ma_mau]").attr("ma_mau") || "", // mã màu  // cần sữa
                can_nang: $(this).find("input[name^=can_nang]").val() || "0",
                gia_cu: $(this).find("input[name^=gia_cu]").val() || "0",
                gia_moi: $(this).find("input[name^=gia_moi]").val() || "0",
                gia_drop: $(this).find("input[name^=gia_drop]").val() || "0",
                gia_ctv: $(this).find("input[name^=gia_ctv]").val() || "0",
                gia_socdo: $(this).find("input[name^=gia_socdo]").val() || "0",
                drop_min: $(this).find("input[name^=drop_min]").val() || "0",
                kho_sanpham_shop:
                    $(this).find("input[name^=kho_sanpham_shop]").val() || "0",
                trongluongtinhship:
                    $(this).find("input[name^=trongluongtinhship]").val() || "0",
            };
            list_phanloai.push(phanloai);
        });
        var tong_kho_sanpham = $(".list_phanloai .li_phanloai")
            .toArray()
            .reduce((sum, el) => {
                return (
                    sum +
                    (parseInt($(el).find("input[name^=kho_sanpham_shop]").val()) || 0)
                );
            }, 0);
        // Kiểm tra dữ liệu
        if (tieu_de.length < 4) {
            $("input[name=tieu_de]").focus();
        }
        // huyphuc08/05/225
        else if (list_photo.length > 8) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Tối đa 8 ảnh đa chiều sản phẩm");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
        } else if (!list_photo.length) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Vui lòng chọn ít nhất một ảnh đa chiều sản phẩm");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
        } else if (noibat2.length < 10) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Vui lòng nhập ít nhất 10 ký tự cho đặc điểm nổi bật!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noibat2.length > 600) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Đặc điểm nổi bật không được quá 600 ký tự!");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noidung2.length < 10) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Vui lòng nhập ít nhất 10 ký tự cho mô tả chi tiết!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (noidung2.length > 5000) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Nội dung chi tiết không được vượt quá 5000 ký tự!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        }
        //
        else if (title.length > 150) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Title không được vượt quá 150 ký tự!");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            $("input[name=title]").focus();
        } else if (description.length > 150) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("description không được vượt quá 150 ký tự!");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            $("textarea[name=description]").focus();
        } else if (title == "") {
            $("input[name=title]").focus();
        } else if (description == "") {
            $("textarea[name=description]").focus();
        } else if (list_phanloai.length === 0) {
            alert("Vui lòng thêm ít nhất một phân loại sản phẩm!");
        } else if (list_noiban.length === 0) {
            alert("Vui lòng chọn nơi bán!");
        } else {
            // Gửi dữ liệu qua AJAX
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "add_sanpham_ngoai");
            form_data.append("tieu_de", tieu_de);
            form_data.append("kho", tong_kho_sanpham); // = số sản phẩm phân loại
            form_data.append("anh", anh);
            form_data.append("minh_hoa", minh_hoa);
            form_data.append("file", file_data);
            form_data.append("link", link);
            form_data.append("category", list_cat);
            form_data.append("phan_loai", JSON.stringify(list_phanloai));
            form_data.append("noiban", list_noiban);
            form_data.append("thuong_hieu", thuong_hieu);
            form_data.append("thuong_hieu_2", thuong_hieu_2);
            form_data.append("info", list_info);
            form_data.append("noibat", noibat);
            form_data.append("noidung", noidung);
            form_data.append("title", title);
            form_data.append("description", description);
            form_data.append("chieudai_shop", chieudai_shop);
            form_data.append("chieurong_shop", chieurong_shop);
            form_data.append("chieucao_shop", chieucao_shop);
            form_data.append("thongtin", thongtin); // thông tin (thông số) 3-4
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            console.log("Data being sent:");
            for (var pair of form_data.entries()) {
                console.log(pair[0] + ":", pair[1]);
            }
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });

    // Hàm định dạng giá
    function format_price(number) {
        return Number(number).toLocaleString("en-US", { minimumFractionDigits: 0 });
    }

    // Tự động tạo mã cho hàng phân loại đầu tiên khi trang được tải
    //3-4
    $(document).ready(function () {
        const randomCode = generateRandomCode();
        $(".list_phanloai .li_phanloai input[name^=ma]").each(function () {
            if ($(this).val().trim() === "") {
                // Chỉ gán nếu input đang rỗng
                $(this).val(randomCode);
            }
        });
    });

    /////////////////////////////huyphuc/09/05/2025
    $("button[name=edit_sanpham_ngoai]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        gia_cu = $("input[name=gia_cu]").val();
        gia_moi = $("input[name=gia_moi]").val();
        //kho = $('input[name=kho]').val();
        can_nang = $("input[name=can_nang]").val();
        id = $("input[name=id]").val();
        var list_photo = [];
        $(".list_photo img").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        minh_hoa = $("#preview-minhhoa").attr("src");
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input[name^=category]:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $(".li_input input[name^=color]:checked").each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        size = $("select[name=size]").val();
        size_2 = $("input[name=size_2]").val();
        thuong_hieu = $("select[name=thuong_hieu]").val();
        thuong_hieu_2 = $("input[name=thuong_hieu_2]").val();
        chieudai_shop = $("input[name=chieudai_shop]").val();
        chieurong_shop = $("input[name=chieurong_shop]").val();
        chieucao_shop = $("input[name=chieucao_shop]").val();
        var list_info = "";
        $(".li_info").each(function () {
            info_name = $(this).find("input[name^=info_name]").val();
            info_value = $(this).find("input[name^=info_value]").val();
            if (info_name != "") {
                list_info += info_name + "&&" + info_value + "|";
            }
        });
        // Phân loại sản phẩm
        var list_phanloai = [];
        $(".list_phanloai .li_phanloai").each(function () {
            var phanloai = {
                ma_sp: $(this).find("input[name^=ma]").val() || "",
                size_shop: $(this).find("input[name^=size_shop]").attr("giatri") || "0",
                color_shop:
                    $(this).find("input[name^=color_shop]").attr("giatri") || "0",
                ten_size_shop: $(this).find("input[name^=ten_size_shop]").val() || "",
                ten_color_shop: $(this).find("input[name^=ten_color_shop]").val() || "",
                ma_mau_shop: $(this).find("input[name^=ma_mau_shop]").val() || "",
                size: $(this).find("input[name^=size]").attr("giatri") || "0",
                color: $(this).find("input[name^=color]").attr("giatri") || "0",
                ten_size: $(this).find("input[name^=ten_size]").val() || "",
                ten_color: $(this).find("input[name^=ten_color]").val() || "",
                ma_mau: $(this).find("input[name^=ma_mau]").attr("ma_mau") || "",
                can_nang: $(this).find("input[name^=can_nang]").val() || "0",
                gia_cu: $(this).find("input[name^=gia_cu]").val() || "0",
                gia_moi: $(this).find("input[name^=gia_moi]").val() || "0",
                gia_drop: $(this).find("input[name^=gia_drop]").val() || "0",
                gia_ctv: $(this).find("input[name^=gia_ctv]").val() || "0",
                gia_socdo: $(this).find("input[name^=gia_socdo]").val() || "0",
                drop_min: $(this).find("input[name^=drop_min]").val() || "0",
                kho_sanpham_shop:
                    $(this).find("input[name^=kho_sanpham_shop]").val() || "0",
                trongluongtinhship:
                    $(this).find("input[name^=trongluongtinhship]").val() || "0",
            };
            list_phanloai.push(phanloai);
        });
        var tong_kho_sanpham = $(".list_phanloai .li_phanloai")
            .toArray()
            .reduce((sum, el) => {
                return (
                    sum +
                    (parseInt($(el).find("input[name^=kho_sanpham_shop]").val()) || 0)
                );
            }, 0);
        noibat = tinyMCE.get("noibat").getContent();
        noibat2 = stripHtml(noibat);
        noidung = tinyMCE.get("edit_textarea").getContent();
        noidung2 = stripHtml(noidung);
        link = $("input[name=link]").val();
        link_old = $("input[name=link_old]").val();
        thongtin = $("input[name=thongtin]").val();
        if (tieu_de.length < 4) {
            $("input[name=tieu_de]").focus();
        } // huyphuc08/05/225
        else if (list_photo.length > 8) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Tối đa 8 ảnh đa chiều sản phẩm");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
        } else if (!list_photo.length) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Vui lòng chọn ít nhất một ảnh đa chiều sản phẩm");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
        } else if (noibat2.length < 10) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Vui lòng nhập ít nhất 10 ký tự cho đặc điểm nổi bật!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noibat2.length > 600) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html("Đặc điểm nổi bật không được quá 600 ký tự!");
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noidung2.length < 10) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Vui lòng nhập ít nhất 10 ký tự cho mô tả chi tiết!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (noidung2.length > 5000) {
            setTimeout(function () {
                $(".load_overlay").show();
                $(".load_process").fadeIn();
                $(".load_note").html(
                    "Nội dung chi tiết không được vượt quá 5000 ký tự!"
                );
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_overlay").hide();
                $(".load_note").html("");
            }, 3000);
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        }
        //
        else if (title == "") {
            $("input[name=title]").focus();
        } else if (description == "") {
            $("textarea[name=description]").focus();
        } else if (list_phanloai.length === 0) {
            alert("Vui lòng thêm ít nhất một phân loại sản phẩm!");
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "edit_sanpham_ngoai");
            form_data.append("tieu_de", tieu_de);
            form_data.append("gia_cu", gia_cu);
            form_data.append("gia_moi", gia_moi);
            form_data.append("kho", tong_kho_sanpham); // = số sản phẩm phân loại
            form_data.append("anh", anh);
            form_data.append("minh_hoa", minh_hoa);
            form_data.append("file", file_data);
            form_data.append("link", link);
            form_data.append("link_old", link_old);
            form_data.append("category", list_cat);
            form_data.append("color", list_color);
            form_data.append("size", size);
            form_data.append("size_2", size_2);
            form_data.append("can_nang", can_nang);
            form_data.append("thuong_hieu", thuong_hieu);
            form_data.append("thuong_hieu_2", thuong_hieu_2);
            form_data.append("info", list_info);
            form_data.append("noibat", noibat);
            form_data.append("noidung", noidung);
            form_data.append("title", title);
            form_data.append("description", description);
            form_data.append("id", id);
            form_data.append("phan_loai", JSON.stringify(list_phanloai));
            form_data.append("chieudai_shop", chieudai_shop);
            form_data.append("chieurong_shop", chieurong_shop);
            form_data.append("chieucao_shop", chieucao_shop);
            form_data.append("thongtin", thongtin); // thông tin (thông số) 3-4
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            // console.log([...form_data]);
            // debugger;
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    // console.log(kq);
                    // debugger
                    var info = JSON.parse(kq);
                    console.log(info);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    ///huyphuc08/04/2025
    /////////////////////////////
    $("button[name=add_share_sanpham]").on("click", function () {
        // console.log('abc');
        noidung = tinyMCE.get("edit_textarea").getContent();
        var list_photo = [];
        $(".list_photo img, .list_photo video").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        sp_id = $("input[name=sp_id]").val();
        if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else {
            var form_data = new FormData();
            form_data.append("action", "add_share_sanpham");
            form_data.append("anh", anh);
            form_data.append("noidung", noidung);
            form_data.append("sp_id", sp_id);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_share_sanpham]").on("click", function () {
        noidung = tinyMCE.get("edit_textarea").getContent();
        var list_photo = [];
        $(".list_photo img, .list_photo video").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        id = $("input[name=id]").val();
        sp_id = $("input[name=sp_id]").val();
        if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else {
            var form_data = new FormData();
            form_data.append("action", "edit_share_sanpham");
            form_data.append("anh", anh);
            form_data.append("noidung", noidung);
            form_data.append("id", id);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-noidung-bansp?id=" + sp_id;
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////
    /////////////////////////////
    $("button[name=add_sanpham_affiliate]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        gia_cu = $("input[name=gia_cu]").val();
        gia_moi = $("input[name=gia_moi]").val();
        link_aff = $("input[name=link_aff]").val();
        var list_photo = [];
        $(".list_photo img").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        minh_hoa = $("#preview-minhhoa").attr("src");
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input[name^=category]:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $(".li_input input[name^=color]:checked").each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        /*        var list_size = [];
                    $('.li_input input[name^=size]:checked').each(function() {
                        list_size.push($(this).val());
                    });
                    list_size = list_size.toString();*/
        size = $("select[name=size]").val();
        size_2 = $("input[name=size_2]").val();
        thuong_hieu = $("select[name=thuong_hieu]").val();
        thuong_hieu_2 = $("input[name=thuong_hieu_2]").val();
        var list_info = "";
        $(".li_info").each(function () {
            info_name = $(this).find("input[name^=info_name]").val();
            info_value = $(this).find("input[name^=info_value]").val();
            if (info_name != "") {
                list_info += info_name + "&&" + info_value + "|";
            }
        });
        noibat = tinyMCE.get("noibat").getContent();
        noidung = tinyMCE.get("edit_textarea").getContent();
        link = $("input[name=link]").val();
        if (tieu_de.length < 4) {
            $("input[name=tieu_de]").focus();
        } else if (gia_cu == "") {
            $("input[name=gia_cu]").focus();
        } else if (gia_moi == "") {
            $("input[name=gia_moi]").focus();
        } else if (link_aff == "") {
            $("input[name=link_aff]").focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (title == "") {
            $("input[name=title]").focus();
        } else if (description == "") {
            $("textarea[name=description]").focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "add_sanpham_affiliate");
            form_data.append("tieu_de", tieu_de);
            form_data.append("gia_cu", gia_cu);
            form_data.append("gia_moi", gia_moi);
            form_data.append("link_aff", link_aff);
            form_data.append("anh", anh);
            form_data.append("minh_hoa", minh_hoa);
            form_data.append("file", file_data);
            form_data.append("link", link);
            form_data.append("category", list_cat);
            form_data.append("color", list_color);
            form_data.append("size", size);
            form_data.append("size_2", size_2);
            form_data.append("thuong_hieu", thuong_hieu);
            form_data.append("thuong_hieu_2", thuong_hieu_2);
            form_data.append("info", list_info);
            form_data.append("noibat", noibat);
            form_data.append("noidung", noidung);
            form_data.append("title", title);
            form_data.append("description", description);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_sanpham_affiliate]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        gia_cu = $("input[name=gia_cu]").val();
        gia_moi = $("input[name=gia_moi]").val();
        link_aff = $("input[name=link_aff]").val();
        id = $("input[name=id]").val();
        var list_photo = [];
        $(".list_photo img").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        minh_hoa = $("#preview-minhhoa").attr("src");
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input[name^=category]:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $(".li_input input[name^=color]:checked").each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        /*        var list_size = [];
                    $('.li_input input[name^=size]:checked').each(function() {
                        list_size.push($(this).val());
                    });
                    list_size = list_size.toString();*/
        size = $("select[name=size]").val();
        size_2 = $("input[name=size_2]").val();
        thuong_hieu = $("select[name=thuong_hieu]").val();
        thuong_hieu_2 = $("input[name=thuong_hieu_2]").val();
        var list_info = "";
        $(".li_info").each(function () {
            info_name = $(this).find("input[name^=info_name]").val();
            info_value = $(this).find("input[name^=info_value]").val();
            if (info_name != "") {
                list_info += info_name + "&&" + info_value + "|";
            }
        });
        noibat = tinyMCE.get("noibat").getContent();
        noidung = tinyMCE.get("edit_textarea").getContent();
        link = $("input[name=link]").val();
        link_old = $("input[name=link_old]").val();
        if (tieu_de.length < 4) {
            $("input[name=tieu_de]").focus();
        } else if (gia_cu == "") {
            $("input[name=gia_cu]").focus();
        } else if (gia_moi == "") {
            $("input[name=gia_moi]").focus();
        } else if (link_aff == "") {
            $("input[name=link_aff]").focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (title == "") {
            $("input[name=title]").focus();
        } else if (description == "") {
            $("textarea[name=description]").focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "edit_sanpham_affiliate");
            form_data.append("tieu_de", tieu_de);
            form_data.append("gia_cu", gia_cu);
            form_data.append("gia_moi", gia_moi);
            form_data.append("link_aff", link_aff);
            form_data.append("anh", anh);
            form_data.append("minh_hoa", minh_hoa);
            form_data.append("file", file_data);
            form_data.append("link", link);
            form_data.append("link_old", link_old);
            form_data.append("category", list_cat);
            form_data.append("color", list_color);
            form_data.append("size", size);
            form_data.append("size_2", size_2);
            form_data.append("thuong_hieu", thuong_hieu);
            form_data.append("thuong_hieu_2", thuong_hieu_2);
            form_data.append("info", list_info);
            form_data.append("noibat", noibat);
            form_data.append("noidung", noidung);
            form_data.append("title", title);
            form_data.append("description", description);
            form_data.append("id", id);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=add_sanpham]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        gia_cu = $("input[name=gia_cu]").val();
        sp_id = $("input[name=sp_id]").val();
        gia_moi = $("input[name=gia_moi]").val();
        can_nang = $("input[name=can_nang]").val();
        var list_photo = [];
        $(".list_photo img").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        minh_hoa = $("#preview-minhhoa").attr("src");
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input[name^=category]:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $(".li_input input[name^=color]:checked").each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        var list_size = [];
        $(".li_input input[name^=size]:checked").each(function () {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();
        thuong_hieu = $("select[name=thuong_hieu]").val();
        var list_info = "";
        $(".li_info").each(function () {
            info_name = $(this).find("input[name^=info_name]").val();
            info_value = $(this).find("input[name^=info_value]").val();
            if (info_name != "") {
                list_info += info_name + "&&" + info_value + "|";
            }
        });
        noibat = tinyMCE.get("noibat").getContent();
        noidung = tinyMCE.get("edit_textarea").getContent();
        link = $("input[name=link]").val();
        if (tieu_de.length < 4) {
            $("input[name=tieu_de]").focus();
        } else if (gia_cu == "") {
            $("input[name=gia_cu]").focus();
        } else if (gia_moi == "") {
            $("input[name=gia_moi]").focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (title == "") {
            $("input[name=title]").focus();
        } else if (description == "") {
            $("textarea[name=description]").focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "add_sanpham");
            form_data.append("tieu_de", tieu_de);
            form_data.append("gia_cu", gia_cu);
            form_data.append("gia_moi", gia_moi);
            form_data.append("sp_id", sp_id);
            form_data.append("anh", anh);
            form_data.append("minh_hoa", minh_hoa);
            form_data.append("file", file_data);
            form_data.append("link", link);
            form_data.append("category", list_cat);
            form_data.append("color", list_color);
            form_data.append("size", list_size);
            form_data.append("can_nang", can_nang);
            form_data.append("thuong_hieu", thuong_hieu);
            form_data.append("info", list_info);
            form_data.append("noibat", noibat);
            form_data.append("noidung", noidung);
            form_data.append("title", title);
            form_data.append("description", description);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.href = "/ncc/list-sanpham";
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_sanpham]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        gia_cu = $("input[name=gia_cu]").val();
        gia_moi = $("input[name=gia_moi]").val();
        can_nang = $("input[name=can_nang]").val();
        var list_photo = [];
        $(".list_photo img").each(function () {
            list_photo.push($(this).attr("src"));
        });
        anh = list_photo.toString();
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input[name^=category]:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        var list_color = [];
        $(".li_input input[name^=color]:checked").each(function () {
            list_color.push($(this).val());
        });
        list_color = list_color.toString();
        var list_size = [];
        $(".li_input input[name^=size]:checked").each(function () {
            list_size.push($(this).val());
        });
        list_size = list_size.toString();
        thuong_hieu = $("select[name=thuong_hieu]").val();
        var list_info = "";
        $(".li_info").each(function () {
            info_name = $(this).find("input[name^=info_name]").val();
            info_value = $(this).find("input[name^=info_value]").val();
            if (info_name != "") {
                list_info += info_name + "&&" + info_value + "|";
            }
        });
        noibat = tinyMCE.get("noibat").getContent();
        noidung = tinyMCE.get("edit_textarea").getContent();
        link = $("input[name=link]").val();
        link_old = $("input[name=link_old]").val();
        minh_hoa = $("#preview-minhhoa").attr("src");
        id = $("input[name=sp_id]").val();
        if (tieu_de.length < 4) {
            $("input[name=tieu_de]").focus();
        } else if (gia_cu == "") {
            $("input[name=gia_cu]").focus();
        } else if (gia_moi == "") {
            $("input[name=gia_moi]").focus();
        } else if (noibat.length < 10) {
            tinymce.execCommand("mceFocus", false, "noibat");
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (title == "") {
            $("input[name=title]").focus();
        } else if (description == "") {
            $("textarea[name=description]").focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "edit_sanpham");
            form_data.append("tieu_de", tieu_de);
            form_data.append("gia_cu", gia_cu);
            form_data.append("gia_moi", gia_moi);
            form_data.append("anh", anh);
            form_data.append("minh_hoa", minh_hoa);
            form_data.append("file", file_data);
            form_data.append("link", link);
            form_data.append("link_old", link_old);
            form_data.append("category", list_cat);
            form_data.append("color", list_color);
            form_data.append("size", list_size);
            form_data.append("can_nang", can_nang);
            form_data.append("thuong_hieu", thuong_hieu);
            form_data.append("info", list_info);
            form_data.append("noibat", noibat);
            form_data.append("noidung", noidung);
            form_data.append("title", title);
            form_data.append("description", description);
            form_data.append("id", id);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=add_post]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        title = $("input[name=title]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        noidung = tinyMCE.get("edit_textarea").getContent();
        link = $("input[name=link]").val();
        if (tieu_de.length < 3) {
            $("input[name=tieu_de]").focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            setTimeout(function () {
                $(".load_note").html("Vui lòng chọn hình minh họa");
            }, 500);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                var top_minhhoa = $("#preview-minhhoa").offset().top;
                $("html,body")
                    .stop()
                    .animate(
                        { scrollTop: top_minhhoa - 150 },
                        500,
                        "swing",
                        function () { }
                    );
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (title.length < 3) {
            $("input[name=title]").focus();
        } else if (description.length < 3) {
            $("textarea[name=description]").focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "add_post");
            form_data.append("file", file_data);
            form_data.append("tieu_de", tieu_de);
            form_data.append("title", title);
            form_data.append("link", link);
            form_data.append("category", list_cat);
            form_data.append("description", description);
            form_data.append("noidung", noidung);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=edit_post]").on("click", function () {
        tieu_de = $("input[name=tieu_de]").val();
        title = $("input[name=title]").val();
        link = $("input[name=link]").val();
        link_old = $("input[name=link_old]").val();
        description = $("textarea[name=description]").val();
        var list_cat = [];
        $(".li_input input:checked").each(function () {
            list_cat.push($(this).val());
        });
        list_cat = list_cat.toString();
        id = $("input[name=id]").val();
        noidung = tinyMCE.get("edit_textarea").getContent();
        if (tieu_de.length < 3) {
            $("input[name=tieu_de]").focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand("mceFocus", false, "edit_textarea");
        } else if (title.length < 3) {
            $("input[name=title]").focus();
        } else if (description.length < 3) {
            $("textarea[name=description]").focus();
        } else {
            var file_data = $("#minh_hoa").prop("files")[0];
            var form_data = new FormData();
            form_data.append("action", "edit_post");
            form_data.append("file", file_data);
            form_data.append("tieu_de", tieu_de);
            form_data.append("title", title);
            form_data.append("description", description);
            form_data.append("link", link);
            form_data.append("link_old", link_old);
            form_data.append("category", list_cat);
            form_data.append("noidung", noidung);
            form_data.append("id", id);
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("button[name=button_password]").on("click", function () {
        old_pass = $("input[name=password_old]").val();
        new_pass = $("input[name=password]").val();
        confirm = $("input[name=confirm]").val();
        if (old_pass.length < 6) {
            $("input[name=password_old]").focus();
        } else if (new_pass.length < 6) {
            $("input[name=password]").focus();
        } else if (new_pass != confirm) {
            $("input[name=confirm]").focus();
        } else {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $(".load_note").html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $(".load_process").hide();
                        $(".load_note").html("Hệ thống đang xử lý");
                        $(".load_overlay").hide();
                        if (info.ok == 1) {
                            $("input[name=password_old]").val("");
                            $("input[name=password]").val("");
                            $("input[name=confirm]").val("");
                        }
                    }, 3000);
                },
            });
        }
    });
    /////////////////////////////
    $("input[name=goi_y]").on("keyup", function () {
        tieu_de = $(this).val();
        cat = $("select[name=category]").val();
        if (tieu_de.length < 2) {
        } else {
            $.ajax({
                url: "/ncc/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat: cat,
                    tieu_de: tieu_de,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $(".khung_goi_y ul").html(info.list);
                    if (info.list.length > 10) {
                        $(".khung_goi_y").show();
                    } else {
                        $(".khung_goi_y").hide();
                    }
                },
            });
        }
        e.stopPropagation();
    });
    /////////////////////////////
    setTimeout(function () {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "get_popup",
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $(".box_popup .content_box").html(info.content);
                    $(".box_popup").fadeIn();
                }
                $(".total_thongbao").html(info.total);
            },
        });
    }, 3000);
    $(".box_popup .box_title i").click(function () {
        $(".box_popup").fadeOut();
    });
    /////////////////////////////
    $(".khung_sanpham").on("click", "ul li i", function () {
        $(this).parent().remove();
    });
    /////////////////////////////
    $(".khung_goi_y").on("click", "ul li", function (e) {
        text = $(this).find("span").text();
        id = $(this).attr("value");
        $(".khung_sanpham ul").prepend(
            '<li value="' +
            id +
            '"><i class="icon icofont-close-circled"></i><span>' +
            text +
            "</span></li>"
        );
        e.stopPropagation();
    });
    $(".box_video .close").on("click", function () {
        $(".box_video").hide();
    });
    $(".pop_video").on("click", function () {
        video = $(this).attr("video");
        if (video == "") {
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $(".load_note").html("Chưa có video giới thiệu");
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
            }, 3000);
        } else {
            $(".box_video iframe").attr(
                "src",
                "https://www.youtube.com/embed/" + video
            );
            $(".box_video").show();
        }
    });
    /////////////////////////////
    $(document).click(function () {
        $(".khung_goi_y:visible").slideUp("300");
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
});

//1-4
// checked category (edit_category)
$(document).ready(function () {
    let cat_id_socdo = $("#checked_cat").data("categories");
    if (cat_id_socdo) {
        let selectedCategories = cat_id_socdo.split(",").map((id) => id.trim());
        $('.list_main_category input[type="checkbox"]').each(function () {
            if (selectedCategories.includes($(this).val())) {
                $(this).prop("checked", true);
                handleCategorySelection(this); // Gọi AJAX cho checkbox đã được đánh dấu
            }
        });
    }
});

function handleCategorySelection(checkbox) {
    let id = $(checkbox).val();

    if ($(checkbox).is(":checked")) {
        $.ajax({
            url: "/ncc/process.php",
            type: "post",
            data: {
                action: "load_sub_category_ncc",
                cat_id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    if ($("#sub_category_ncc .li_input").length > 0) {
                        $("#sub_category_ncc").append(
                            '<hr class="hr_' + id + '">' + info.list
                        );
                    } else {
                        $("#sub_category_ncc").append(info.list);
                    }
                    let selectedCategories = $("#checked_cat")
                        .data("categories")
                        .split(",")
                        .map((id) => id.trim());
                    $('#sub_category_ncc input[type="checkbox"]').each(function () {
                        if (selectedCategories.includes($(this).val())) {
                            $(this).prop("checked", true);
                        }
                    });
                }
            },
        });
    } else {
        $(".li_input_" + id).remove();
        $(".hr_" + id).remove();
        $(".hr_main_" + id).remove();
        $(".li_input_main_" + id).remove();
    }
}

//8-4
$("#featureForm").submit(function (e) {
    e.preventDefault();
    var icons = [];
    var titles = [];
    var descs = [];
    $(".row.g-3").each(function () {
        icons.push($(this).find('input[name="icons[]"]').val());
        titles.push($(this).find('input[name="titles[]"]').val());
        descs.push($(this).find('input[name="descs[]"]').val());
    });
    var formData = {
        icons: icons,
        titles: titles,
        descs: descs,
        description: $('textarea[name="description"]').val(),
        id: $('input[name="id"]').val(),
        action: "edit_setting_home_feature",
    };
    var submitBtn = $(this).find('button[name="edit_setting_home_feature"]');
    var originalText = submitBtn.html();
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
        url: "/ncc/process.php",
        type: "POST",
        data: formData,
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                if (info.ok == 1) {
                    window.location.href = "/ncc/list-setting";
                } else {
                }
            }, 3000);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Có lỗi kết nối, vui lòng thử lại!");
        },
        complete: function () {
            submitBtn.html(originalText);
            submitBtn.prop("disabled", false);
        },
    });
});

$("#minh_hoa, #bg_banner").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $(this)
                .closest(".form-group")
                .find(".image-preview img")
                .attr("src", e.target.result);
        }.bind(this);
        reader.readAsDataURL(file);
    }
});

//10-4
$("#feedbackForm").submit(function (e) {
    e.preventDefault();

    if ($(".feedback-item").length < 3 || $(".feedback-item").length > 10) {
        alert("Số lượng đánh giá phải từ 3 đến 10!");
        return;
    }

    const formData = new FormData();

    const hiddenFields = [
        "id",
        "shop",
        "tieu_de",
        "name",
        "loai",
        "giao_dien",
        "description",
    ];
    hiddenFields.forEach(function (field) {
        const value = $(`input[name="${field}"]`).val();
        if (value !== undefined) {
            formData.append(field, value);
        }
    });

    $(".feedback-item").each(function () {
        const user_name = $(this).find('input[name="user_name[]"]').val();
        const danh_gia = $(this).find('input[name="danh_gia[]"]').val();
        const noidung = $(this).find('textarea[name="noidung[]"]').val();
        const avatar = $(this).find('input[name="avatar[]"]')[0].files[0];

        formData.append("user_name[]", user_name);
        formData.append("danh_gia[]", danh_gia);
        formData.append("noidung[]", noidung);
        if (avatar) {
            formData.append("avatar[]", avatar);
        }
    });
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    formData.append("action", "edit_setting_home_feedback");
    $.ajax({
        url: "/ncc/process.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
                if (info.ok == 1) {
                    window.location.href = "/ncc/list-setting";
                }
            }, 3000);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Có lỗi xảy ra khi gửi dữ liệu!");
        },
    });
});
$(document).mouseup(function (e) {
    var container = $(".list_goiy.scroll");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.html("");
    }
});
function confirm_xoanhieu_sanpham(action, loai, title, ids) {
    $("#title_confirm").html(title); // Cập nhật tiêu đề của popup
    $("#button_thuchien").attr("action", action); // Gán thuộc tính action
    $("#button_thuchien").attr("loai", loai); // Gán thuộc tính loai
    $("#button_thuchien").attr("data-ids", JSON.stringify(ids)); // Lưu mảng ids dưới dạng JSON
    $("#box_pop_confirm").show(); // Hiển thị popup
}
function stripHtml(html) {
    const div = document.createElement("div");
    div.innerHTML = html;
    let text = div.textContent || div.innerText || "";
    text = text
        .replace(/[\n\r]+/g, " ") // Thay thế xuống dòng bằng khoảng trắng
        .replace(/\s+/g, " ") // Chuẩn hóa khoảng trắng
        .trim();
    return text;
}
