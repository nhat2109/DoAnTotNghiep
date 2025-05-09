//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
$(window).on("beforeunload", function () {
  localStorage.setItem("scrollPosition", $(window).scrollTop());
});
function parseTimeString(timeString) {
  let days = 0,
    hours = 0,
    minutes = 0,
    seconds = 0;

  // Tách dữ liệu từ chuỗi "1 ngày 12 giờ 2 phút 30 giây"
  let matches = timeString.match(
    /(\d+)\s*ngày|(\d+)\s*giờ|(\d+)\s*phút|(\d+)\s*giây/gi
  );
  if (!matches) return 0; // Nếu không đúng format thì trả về 0

  matches.forEach((part) => {
    if (part.includes("ngày")) days = parseInt(part);
    if (part.includes("giờ")) hours = parseInt(part);
    if (part.includes("phút")) minutes = parseInt(part);
    if (part.includes("giây")) seconds = parseInt(part);
  });

  return (days * 86400 + hours * 3600 + minutes * 60 + seconds) * 1000; // Trả về tổng mili giây
}

function updateCountdown() {
  $(".countdown-cell").each(function () {
    let countdownCell = $(this);
    let timeString = countdownCell.attr("thongtin-date").trim();
    let timeLeft = parseTimeString(timeString);

    if (timeLeft <= 0) {
      countdownCell.text("Đã hết hạn").css("color", "red");
      return;
    }

    function countdown() {
      if (timeLeft > 0) {
        let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        let hours = Math.floor(
          (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        countdownCell.text(`${days} ngày ${hours} Giờ ${minutes} Phút`);
        timeLeft -= 1000; // Giảm 1 giây
        setTimeout(countdown, 15000);
      } else {
        countdownCell.text("Đã hết hạn").css("color", "red");
      }
    }

    countdown();
  });
}
function startCountdown(button) {
  let text = $(button).text();
  let match = text.match(/Còn\s* (\d+) phút/); // Lấy số phút trong dấu nháy đơn

  if (!match) return; // Nếu không tìm thấy số, thoát luôn

  let timeLeft = parseInt(match[1]) * 60; // Chuyển đổi phút thành giây

  function updateButton() {
    if (timeLeft > 0) {
      let minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;
      $(button).text(
        `Còn ${minutes} phút ${seconds < 10 ? "0" : ""}${seconds} giây `
      );
      timeLeft--; // Giảm 1 giây
      setTimeout(updateButton, 1000);
    } else {
      $(button).text("Đã hết hạn");
    }
  }

  updateButton();
}
$(document).ready(function () {
  $("body")
    .find("button[name='congviec_nv_d']")
    .each(function () {
      startCountdown(this);
    });
  updateCountdown();
});
$(document).ready(function () {
  const scrollPosition = localStorage.getItem("scrollPosition");
  if (scrollPosition) {
    $(window).scrollTop(scrollPosition);
  }
});
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
//var socket =io("https://beta.socdo.vn");
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

function readURL(input, id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#" + id).attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

function check_link(loai) {
  link = $(".link_seo").val();
  if (link.length < 2) {
    $(".check_link").removeClass("ok");
    $(".check_link").addClass("error");
    $(".check_link").html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
  } else {
    $.ajax({
      url: "/process.php",
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
      url: "/process.php",
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
function isJson(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}
function tuchoi(id) {
  $(".load_overlay").show();
  $(".load_process").fadeIn();
  $.ajax({
    url: "/process.php",
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

function confirm_success(id) {
  $(".load_overlay").show();
  $(".load_process").fadeIn();
  $.ajax({
    url: "/process.php",
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

function del(loai, id) {
  $(".load_overlay").show();
  $(".load_process").fadeIn();
  $.ajax({
    url: "/process.php",
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
    url: "/process.php",
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
$(document).ready(function () {
  setTimeout(function () {
    $(".loadpage").fadeOut();
    $(".page_body").fadeIn();
  }, 300);
  if ($("#chon_kho").length > 0) {
    if (get_cookie("admin_kho")) {
      $("#chon_kho").val(get_cookie("admin_kho"));
    } else {
    }
  }
  $("#chon_kho").on("change", function () {
    kho = $(this).val();
    create_cookie("admin_kho", kho, 365, "/");
    window.location.reload();
  });
  if ($("#list_chat").length > 0) {
    setTimeout(function () {
      scrollSmoothToBottom("list_chat");
    }, 500);
  }
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
      url: "/process.php",
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
              loai: "admin",
              user_out: info.user_out,
              thanh_vien: info.thanh_vien,
            };
            var info_chat = JSON.stringify(dulieu);
            socket.emit("user_send_traodoi", info_chat);
          }
        }, 3000);
      },
    });
  });
  ///////////////////
  setTimeout(function () {
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "get_total_cart",
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".total_notification").html(info.total_noti);
        $(".total_ct_drop").html(info.total_cart_drop);
        $(".total_ct_ctv").html(info.total_cart_ctv);
        $(".total_ct_socdo").html(info.total_cart_socdo);
        $(".total_nap").html(info.total_nap);
        $(".total_rut").html(info.total_rut);
        $(".total_mua_seeding").html(info.total_mua_seeding);
        $(".total_mua_domain").html(info.total_mua_domain);
        $(".total_hotro_domain").html(info.total_hotro_domain);
        $(".total_dk_drop").html(info.total_dk_drop);
        $(".total_dk_ctv").html(info.total_dk_ctv);
        $(".total_hethang").html(info.total_hethang);
        $(".total_dat_live").html(info.total_dat_live);
        $(".total_tamkhoa").html(info.total_tamkhoa);
        $(".total_chat").html(info.total_chat);
      },
    });
  }, 3000);
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
  ////////////////////////////
  $("body").on("click", ".pop_second .title .material-icons", function () {
    $(".pop_second").hide();
    $(".pop_second").html("");
    if ($(".box_pop_add_content").length < 1) {
      $(".box_pop_add").hide();
      $(".box_pop_add").html("");
    }
  });
  ///////////////////
  $(".box_select_product .box_title .fa").on("click", function () {
    $(".box_select_product").hide();
    $(".box_select_product .box_list").html("");
    $(".box_select_product .box_list").attr("page", 1);
    $("input[name=key_deal]").val("");
  });
  $(".box_select_product").on("click", ".action button", function () {
    $(this).toggleClass("active");
  });
  $(".box_select_product .box_list").on("scroll", function () {
    if (
      $(this).scrollTop() + $(this).innerHeight() >=
      $(this)[0].scrollHeight - 10
    ) {
      tiep = $(".box_select_product .box_list").attr("tiep");
      page = $(".box_select_product .box_list").attr("page");
      loaded = $(".box_select_product .box_list").attr("loaded");
      key = $("input[name=key_deal]").val();
      sort = $(".box_select_product select[name=sort]").val();
      loai = $("button[name=select_main_product]").attr("loai");
      if (loaded == 1 && tiep == 1 && page != 1 && key == "") {
        $(".box_select_product .box_list").append(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        $(".box_select_product .box_list").attr("loaded", 0);
        var sp_id = "";
        $("#list_product_main .li_product,#list_product_sub .li_product").each(
          function () {
            sp_id += $(this).attr("sp") + ",";
          }
        );
        if (loai == "main_product") {
          setTimeout(function () {
            $.ajax({
              url: "/process.php",
              type: "post",
              data: {
                action: "load_product_main",
                list_id: sp_id,
                sort: sort,
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
              url: "/process.php",
              type: "post",
              data: {
                action: "load_product_sub",
                list_id: sp_id,
                sort: sort,
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
  $("body").on("keyup", ".note_edit", function () {
    noidung = $(this).html();
    id = $(this).attr("id_bh");
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "update_note_baohanh",
          noidung: noidung,
          id: id,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
        },
      });
    }, 1000);
  });
  $("body").on("keyup", ".note_edit_hotro", function () {
    noidung = $(this).html();
    id = $(this).attr("id_bh");
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "update_note_hotro",
          noidung: noidung,
          id: id,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
        },
      });
    }, 1000);
  });
  $(".select_product").on("click", function () {
    $(".box_select_product .box_list").html(
      '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
    );
    $(".box_select_product").show();
    $(".box_select_product .box_bottom button").attr("loai", "main_product");
    var sp_id = "";
    $("#list_product_main .li_product,#list_product_sub .li_product").each(
      function () {
        sp_id += $(this).attr("sp") + ",";
      }
    );
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_product_main",
          list_id: sp_id,
          sort: "id-desc",
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
  $("body").on("change", ".box_select_product select[name=sort]", function () {
    $(".box_select_product .box_list").attr("page", "1");
    $(".box_select_product .box_list").html(
      '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
    );
    var sp_id = "";
    $("#list_product_main .li_product,#list_product_sub .li_product").each(
      function () {
        sp_id += $(this).attr("sp") + ",";
      }
    );
    sort = $(".box_select_product select[name=sort]").val();
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_product_main",
          list_id: sp_id,
          sort: sort,
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
  $(".select_product_sub").on("click", function () {
    $(".box_select_product .box_list").html(
      '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
    );
    $(".box_select_product").show();
    $(".box_select_product .box_bottom button").attr("loai", "sub_product");
    var sp_id = "";
    $("#list_product_main .li_product,#list_product_sub .li_product").each(
      function () {
        sp_id += $(this).attr("sp") + ",";
      }
    );
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_product_sub",
          list_id: sp_id,
          sort: "id-desc",
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
        url: "/process.php",
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
      $(this)[0].scrollHeight - 10
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
            url: "/process.php",
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
  ///////////////////
  $("body").on("click", ".chon_quanly", function () {
    var user_id = $(".box_select_quanly .box_list").attr("user_id");
    var quanly = $(this).attr("quanly");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "chon_quanly",
        quanly: quanly,
        user_id: user_id,
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
          $(".box_select_quanly .box_list").html("");
          $(".box_select_quanly .box_list").attr("user_id", "");
          $(".box_select_quanly").hide();
          if (info.ok == 1) {
            $("#tr_" + user_id + " .ten_quanly").html(info.ho_ten);
          }
        }, 1500);
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
        url: "/process.php",
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
          url: "/process.php",
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
            url: "/process.php",
            type: "post",
            data: {
              action: "load_notification",
              loai: loai,
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
  ///////////////////
  $("body").on("click", ".capnhat_hh", function () {
    var btn = $(this);
    var hh = $(this).attr("hh");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "capnhat_hh",
        hh: hh,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        setTimeout(function () {
          $(".load_note").html(info.thongbao);
        }, 100);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
          if (info.ok == 1) {
            btn.html("Đã thanh toán");
          }
        }, 1000);
      },
    });
  });
  ///////////////////
  $("body").on("click", ".capnhat_donhang", function () {
    var btn = $(this);
    var user = $(this).attr("user");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "capnhat_donhang",
        user: user,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        setTimeout(function () {
          $(".load_note").html(info.thongbao);
        }, 100);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
          if (info.ok == 1) {
            btn.html("Đã cập nhật");
          }
        }, 1000);
      },
    });
  });
  ///////////////////
  $("body").on("click", ".capnhat_donhang_nhom", function () {
    var btn = $(this);
    var user = $(this).attr("user");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "capnhat_donhang_nhom",
        user: user,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        setTimeout(function () {
          $(".load_note").html(info.thongbao);
        }, 100);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
          if (info.ok == 1) {
            btn.html("Đã cập nhật");
          }
        }, 1000);
      },
    });
  });
  ///////////////////
  $("body").on("click", ".show_quanly", function () {
    var user_id = $(this).attr("user_id");
    /*        $('.load_overlay').show();
         $('.load_process').fadeIn();*/
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "load_quanly",
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".box_select_quanly .box_list").append(info.list);
        $(".box_select_quanly .box_list").attr("user_id", user_id);
        $(".box_select_quanly").show();
      },
    });
  });
  // show_themhot

  // Xử lý sự kiện khi click nút "Thêm HOT"
  $("body").on("click", ".add_hot, .da_themhot", function () {
    var userId = $(this).closest("tr").attr("id").replace("tr_", "");
    var button = $(this);
    var action = button.hasClass("add_hot") ? "them_hot" : "huy_hot"; // Xác định action dựa vào class

    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: action,
        user_id: userId,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.ok == 1) {
          if (action === "them_hot") {
            button
              .removeClass("add_hot btn btn-success")
              .addClass("da_themhot btn btn-danger")
              .text("Đã thêm HOT");
          } else {
            button
              .removeClass("da_themhot btn btn-danger")
              .addClass("add_hot btn btn-success")
              .text("Thêm HOT");
          }
        } else {
          alert(data.thongbao);
        }
      },
    });
  });

  ///////////////////
  $(".box_select_quanly .box_title .fa").on("click", function () {
    $(".box_select_quanly").hide();
    $(".box_select_quanly .box_list").html("");
    $(".box_select_quanly .box_list").attr("user_id", "");
    $(".box_select_quanly input[name=key_quanly]").val("");
  });
  $(".box_select_quanly .search_member").on("click", function () {
    key = $(".box_select_quanly input[name=key_quanly]").val();
    if (key.length < 1) {
      $(".box_select_quanly input[name=key_quanly]").focus();
    } else {
      $(".box_select_quanly .box_list").html(
        '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
      );
      setTimeout(function () {
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "tim_quanly",
            key: key,
          },
          success: function (kq) {
            var info = JSON.parse(kq);
            $(".box_select_quanly .box_list .loading_product").remove();
            $(".box_select_quanly .box_list").html(info.list);
          },
        });
      }, 1000);
    }
  });

  $(".box_select_quanly input[name=key_quanly]").keypress(function (e) {
    if (e.which == 13) {
      key = $(".box_select_quanly input[name=key_quanly]").val();
      if (key.length < 1) {
        $(".box_select_quanly input[name=key_quanly]").focus();
      } else {
        $(".box_select_quanly .box_list").html(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        setTimeout(function () {
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: "tim_quanly",
              key: key,
            },
            success: function (kq) {
              var info = JSON.parse(kq);
              $(".box_select_quanly .box_list .loading_product").remove();
              $(".box_select_quanly .box_list").html(info.list);
            },
          });
        }, 1000);
      }
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
          url: "/process.php",
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
            url: "/process.php",
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
  //////////////////////////
  $(".show_add_trend").on("click", function () {
    $(".box_select_product_trend .box_list").html(
      '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
    );
    $(".box_select_product_trend").show();
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_product_trend",
          page: 1,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".box_select_product_trend .box_list").html(info.list);
          $(".box_select_product_trend .box_list").attr("page", info.page);
          $(".box_select_product_trend .box_list").attr("tiep", info.tiep);
          $(".box_select_product_trend .box_list").attr("loaded", 1);
        },
      });
    }, 1000);
  });
  //////////////////////////
  $(".show_add_tuan").on("click", function () {
    $(".box_select_product_tuan .box_list").html(
      '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
    );
    $(".box_select_product_tuan").show();
    setTimeout(function () {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_product_tuan",
          page: 1,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".box_select_product_tuan .box_list").html(info.list);
          $(".box_select_product_tuan .box_list").attr("page", info.page);
          $(".box_select_product_tuan .box_list").attr("tiep", info.tiep);
          $(".box_select_product_tuan .box_list").attr("loaded", 1);
          $(".datetimepicker_mask").datetimepicker({
            format: "H:i d/m/Y",
            //mask:'16:35 26/07/1988',
          });
        },
      });
    }, 1000);
  });
  //////////////////////////
  $(".show_add_marketing").on("click", function () {
    window.location.href = "/add-remarketing";
  });
  ////////////////////////
  $(".box_select_product_trend .box_list").on("scroll", function () {
    if (
      $(this).scrollTop() + $(this).innerHeight() >=
      $(this)[0].scrollHeight - 10
    ) {
      tiep = $(".box_select_product_trend .box_list").attr("tiep");
      page = $(".box_select_product_trend .box_list").attr("page");
      loaded = $(".box_select_product_trend .box_list").attr("loaded");
      key = $(".box_select_product_trend input[name=key_deal]").val();
      if (loaded == 1 && tiep == 1 && page != 1 && key == "") {
        $(".box_select_product_trend .box_list").append(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        $(".box_select_product_trend .box_list").attr("loaded", 0);
        setTimeout(function () {
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: "load_product_trend",
              page: page,
            },
            success: function (kq) {
              var info = JSON.parse(kq);
              $(
                ".box_select_product_trend .box_list .loading_product"
              ).remove();
              $(".box_select_product_trend .box_list").append(info.list);
              $(".box_select_product_trend .box_list").attr("page", info.page);
              $(".box_select_product_trend .box_list").attr("tiep", info.tiep);
              $(".box_select_product_trend .box_list").attr("loaded", 1);
            },
          });
        }, 1000);
      }
    }
  });
  ////////////////////////
  $(".box_select_product_tuan .box_list").on("scroll", function () {
    if (
      $(this).scrollTop() + $(this).innerHeight() >=
      $(this)[0].scrollHeight - 10
    ) {
      tiep = $(".box_select_product_tuan .box_list").attr("tiep");
      page = $(".box_select_product_tuan .box_list").attr("page");
      loaded = $(".box_select_product_tuan .box_list").attr("loaded");
      key = $(".box_select_product_tuan input[name=key_deal]").val();
      if (loaded == 1 && tiep == 1 && page != 1 && key == "") {
        $(".box_select_product_tuan .box_list").append(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        $(".box_select_product_tuan .box_list").attr("loaded", 0);
        setTimeout(function () {
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: "load_product_tuan",
              page: page,
            },
            success: function (kq) {
              var info = JSON.parse(kq);
              $(".box_select_product_tuan .box_list .loading_product").remove();
              $(".box_select_product_tuan .box_list").append(info.list);
              $(".box_select_product_tuan .box_list").attr("page", info.page);
              $(".box_select_product_tuan .box_list").attr("tiep", info.tiep);
              $(".box_select_product_tuan .box_list").attr("loaded", 1);
              $(".datetimepicker_mask").datetimepicker({
                format: "H:i d/m/Y",
                //mask:'16:35 26/07/1988',
              });
            },
          });
        }, 1000);
      }
    }
  });
  ///////////////////
  $(".box_select_product_trend .box_title .fa").on("click", function () {
    $(".box_select_product_trend").hide();
    $(".box_select_product_trend .box_list").html("");
    $(".box_select_product_trend .box_list").attr("page", 1);
    $(".box_select_product_trend input[name=key_deal]").val("");
  });
  $(".box_select_product_trend").on("click", ".action button", function () {
    var button = $(this);
    id = $(this).attr("sp");
    gia = $(this).parent().parent().find("input[type=text]").val();
    if (gia == "") {
      $(this).parent().parent().find("input[type=text]").focus();
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_product_trend",
          id: id,
          gia: gia,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          button.parent().parent().remove();
          if (info.ok == 1) {
            if (info.noti == 1) {
              var dulieu = {
                hd: "user_notification",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
            }
            $(".list_baiviet").html(info.list);
          } else {
          }
        },
      });
    }
  });
  $(".box_select_product_trend .search_deal").on("click", function () {
    key = $(".box_select_product_trend input[name=key_deal]").val();
    if (key.length < 1) {
      $(".box_select_product_trend input[name=key_deal]").focus();
    } else {
      $(".box_select_product_trend .box_list").html(
        '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
      );
      setTimeout(function () {
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "search_product_trend",
            key: key,
            page: 1,
          },
          success: function (kq) {
            var info = JSON.parse(kq);
            $(".box_select_product_trend .box_list").html(info.list);
            $(".box_select_product_trend .box_list").attr("page", info.page);
            $(".box_select_product_trend .box_list").attr("tiep", 0);
            $(".box_select_product_trend .box_list").attr("loaded", 1);
          },
        });
      }, 1000);
    }
  });
  $(".box_select_product_trend input[name=key_deal]").keypress(function (e) {
    if (e.which == 13) {
      key = $(".box_select_product_trend input[name=key_deal]").val();
      if (key.length < 1) {
        $(".box_select_product_trend input[name=key_deal]").focus();
      } else {
        $(".box_select_product_trend .box_list").html(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        setTimeout(function () {
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: "search_product_trend",
              key: key,
              page: 1,
            },
            success: function (kq) {
              var info = JSON.parse(kq);
              $(".box_select_product_trend .box_list").html(info.list);
              $(".box_select_product_trend .box_list").attr("page", info.page);
              $(".box_select_product_trend .box_list").attr("tiep", 0);
              $(".box_select_product_trend .box_list").attr("loaded", 1);
            },
          });
        }, 1000);
      }
    }
  });
  ///////////////////
  $(".box_select_product_tuan .box_title .fa").on("click", function () {
    $(".box_select_product_tuan").hide();
    $(".box_select_product_tuan .box_list").html("");
    $(".box_select_product_tuan .box_list").attr("page", 1);
    $(".box_select_product_tuan input[name=key_deal]").val("");
  });
  $(".box_select_product_tuan").on("click", ".action button", function () {
    var button = $(this);
    id = $(this).attr("sp");
    gia = $(this).attr("gia");
    gia_ctv = $(this).attr("gia_ctv");
    gia_tuan = $(this).parent().parent().find("input[name=gia_tuan]").val();
    gia_ctv_tuan = $(this)
      .parent()
      .parent()
      .find("input[name=gia_ctv_tuan]")
      .val();
    time_start = $(this).parent().parent().find("input[name=time_start]").val();
    time_end = $(this).parent().parent().find("input[name=time_end]").val();
    note_text = $(this).parent().parent().find("input[name=note_text]").val();
    if (gia_tuan == "") {
      $(this).parent().parent().find("input[name=gia_tuan]").focus();
    } else if (time_start == "") {
      $(this).parent().parent().find("input[name=time_start]").focus();
    } else if (time_end == "") {
      $(this).parent().parent().find("input[name=time_end]").focus();
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_product_tuan",
          id: id,
          gia_tuan: gia_tuan,
          gia: gia,
          gia_ctv_tuan: gia_ctv_tuan,
          gia_ctv: gia_ctv,
          time_start: time_start,
          time_end: time_end,
          note_text: note_text,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          button.parent().parent().remove();
          if (info.ok == 1) {
            if (info.noti == 1) {
              var dulieu = {
                hd: "user_notification",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
            }
            $(".list_baiviet").html(info.list);
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
        },
      });
    }
  });
  $(".box_select_product_tuan .search_deal").on("click", function () {
    key = $(".box_select_product_tuan input[name=key_deal]").val();
    if (key.length < 1) {
      $(".box_select_product_tuan input[name=key_deal]").focus();
    } else {
      $(".box_select_product_tuan .box_list").html(
        '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
      );
      setTimeout(function () {
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "search_product_tuan",
            key: key,
            page: 1,
          },
          success: function (kq) {
            var info = JSON.parse(kq);
            $(".box_select_product_tuan .box_list").html(info.list);
            $(".box_select_product_tuan .box_list").attr("page", info.page);
            $(".box_select_product_tuan .box_list").attr("tiep", 0);
            $(".box_select_product_tuan .box_list").attr("loaded", 1);
            $(".datetimepicker_mask").datetimepicker({
              format: "H:i d/m/Y",
              //mask:'16:35 26/07/1988',
            });
          },
        });
      }, 1000);
    }
  });
  $(".box_select_product_tuan input[name=key_deal]").keypress(function (e) {
    if (e.which == 13) {
      key = $(".box_select_product_tuan input[name=key_deal]").val();
      if (key.length < 1) {
        $(".box_select_product_tuan input[name=key_deal]").focus();
      } else {
        $(".box_select_product_tuan .box_list").html(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        setTimeout(function () {
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: "search_product_tuan",
              key: key,
              page: 1,
            },
            success: function (kq) {
              var info = JSON.parse(kq);
              $(".box_select_product_tuan .box_list").html(info.list);
              $(".box_select_product_tuan .box_list").attr("page", info.page);
              $(".box_select_product_tuan .box_list").attr("tiep", 0);
              $(".box_select_product_tuan .box_list").attr("loaded", 1);
              $(".datetimepicker_mask").datetimepicker({
                format: "H:i d/m/Y",
                //mask:'16:35 26/07/1988',
              });
            },
          });
        }, 1000);
      }
    }
  });
  $(".box_select_product .search_deal").on("click", function () {
    key = $(".box_select_product input[name=key_deal]").val();
    loai = $(".box_select_product button[name=select_main_product]").attr(
      "loai"
    );
    var sp_id = "";
    $("#list_product_main .li_product,#list_product_sub .li_product").each(
      function () {
        sp_id += $(this).attr("sp") + ",";
      }
    );
    if (key.length < 1) {
      $(".box_select_product input[name=key_deal]").focus();
    } else {
      $(".box_select_product .box_list").html(
        '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
      );
      if (loai == "main_product") {
        setTimeout(function () {
          $.ajax({
            url: "/process.php",
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
            url: "/process.php",
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
  $(".box_select_product input[name=key_deal]").keypress(function (e) {
    if (e.which == 13) {
      key = $(".box_select_product input[name=key_deal]").val();
      loai = $(".box_select_product button[name=select_main_product]").attr(
        "loai"
      );
      var sp_id = "";
      $("#list_product_main .li_product,#list_product_sub .li_product").each(
        function () {
          sp_id += $(this).attr("sp") + ",";
        }
      );
      if (key.length < 1) {
        $(".box_select_product input[name=key_deal]").focus();
      } else {
        $(".box_select_product .box_list").html(
          '<div class="loading_product"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>'
        );
        if (loai == "main_product") {
          setTimeout(function () {
            $.ajax({
              url: "/process.php",
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
              url: "/process.php",
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
  $(".box_select_product button[name=select_main_product]").on(
    "click",
    function () {
      loai = $(this).attr("loai");
      if (loai == "main_product") {
        $(".box_select_product .box_list .li_product button.active").each(
          function () {
            sp_id = $(this).attr("sp");
            pl = $(this).attr("pl");
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
        var m = 0;
        var list_sub = "";
        $(".box_select_product .box_list .li_product button.active").each(
          function () {
            m++;
            sp_id = $(this).attr("sp");
            pl = $(this).attr("pl");
            if (m == 1) {
              list_sub += '{"sp_id":"' + sp_id + '"}';
            } else {
              list_sub += ',{"sp_id":"' + sp_id + '"}';
            }
          }
        );
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "show_product_sub",
            list_sub: list_sub,
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
    }
  );
  $("#list_product_main").on("click", ".action button", function () {
    $(this).parent().parent().remove();
  });
  $("#list_product_sub").on("click", ".action button", function () {
    $(this).parent().parent().remove();
  });
  /////////////////////////////
  $("select[name=apdung]").on("change", function () {
    kieu = $(this).val();
    if (kieu == "all") {
      $("#box_sanpham").hide();
    } else {
      $("#box_sanpham").show();
    }
  });
  /////////////////////////////
  $("button[name=add_flash_sale]").click(function () {
    tieu_de = $("input[name=tieu_de]").val();
    date_start = $("input[name=date_start]").val();
    date_end = $("input[name=date_end]").val();
    s = 0;
    list = "";
    list_product = "";
    $("#list_product_sub .li_product").each(function () {
      s++;
      sp_id = $(this).attr("sp");
      list_pl = "";
      l = 0;
      $(this)
        .find(".li_pl")
        .each(function () {
          l++;
          pl = $(this).attr("pl");
          gia_cu = $(this).find("input[name^=gia_cu]").val();
          gia_moi = $(this).find("input[name^=gia_moi]").val();
          gia = $(this).find("input[name^=gia_deal]").val();
          so_luong = $(this).find("input[name^=so_luong]").val();
          ten_color = $(this).find(".color span").text();
          color = $(this).find(".color").attr("color");
          ma_mau = $(this).find(".color").attr("ma_mau");
          ten_size = $(this).find(".size span").text();
          size = $(this).find(".size").attr("size");
          if (l == 1) {
            list_pl +=
              '{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '","so_luong":"' +
              so_luong +
              '"}';
          } else {
            list_pl +=
              ',{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '","so_luong":"' +
              so_luong +
              '"}';
          }
        });
      if (s == 1) {
        list_product +=
          '{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      } else {
        list_product +=
          ',{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      }
    });
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
    } else if (list_product == "") {
      setTimeout(function () {
        $(".load_note").html("Vui lòng chọn sản phẩm");
      }, 500);
      setTimeout(function () {
        $(".load_process").hide();
        $(".load_note").html("Hệ thống đang xử lý");
        $(".load_overlay").hide();
      }, 1500);
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_flash_sale",
          tieu_de: tieu_de,
          list_product: list_product,
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
  $("button[name=edit_flash_sale]").click(function () {
    tieu_de = $("input[name=tieu_de]").val();
    date_start = $("input[name=date_start]").val();
    date_end = $("input[name=date_end]").val();
    id = $("input[name=id]").val();
    s = 0;
    list = "";
    list_product = "";
    $("#list_product_sub .li_product").each(function () {
      s++;
      sp_id = $(this).attr("sp");
      list_pl = "";
      l = 0;
      $(this)
        .find(".li_pl")
        .each(function () {
          l++;
          pl = $(this).attr("pl");
          gia_cu = $(this).find("input[name^=gia_cu]").val();
          gia_moi = $(this).find("input[name^=gia_moi]").val();
          gia = $(this).find("input[name^=gia_deal]").val();
          so_luong = $(this).find("input[name^=so_luong]").val();
          ten_color = $(this).find(".color span").text();
          color = $(this).find(".color").attr("color");
          ma_mau = $(this).find(".color").attr("ma_mau");
          ten_size = $(this).find(".size span").text();
          size = $(this).find(".size").attr("size");
          if (l == 1) {
            list_pl +=
              '{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '","so_luong":"' +
              so_luong +
              '"}';
          } else {
            list_pl +=
              ',{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '","so_luong":"' +
              so_luong +
              '"}';
          }
        });
      if (s == 1) {
        list_product +=
          '{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      } else {
        list_product +=
          ',{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      }
    });
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
    } else if (list_product == "") {
      setTimeout(function () {
        $(".load_note").html("Vui lòng chọn sản phẩm");
      }, 500);
      setTimeout(function () {
        $(".load_process").hide();
        $(".load_note").html("Hệ thống đang xử lý");
        $(".load_overlay").hide();
      }, 1500);
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "edit_flash_sale",
          tieu_de: tieu_de,
          list_product: list_product,
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
  $("button[name=add_deal]").click(function () {
    tieu_de = $("input[name=tieu_de]").val();
    loai = $("input[name=loai]:checked").val();
    date_start = $("input[name=date_start]").val();
    date_end = $("input[name=date_end]").val();
    var main_product = "";
    $("#list_product_main .li_product").each(function () {
      main_product += $(this).attr("sp") + ",";
    });
    s = 0;
    list_product = "";
    $("#list_product_sub .li_product").each(function () {
      s++;
      sp_id = $(this).attr("sp");
      list_pl = "";
      l = 0;
      $(this)
        .find(".li_pl")
        .each(function () {
          l++;
          pl = $(this).attr("pl");
          gia_cu = $(this).find("input[name^=gia_cu]").val();
          gia_moi = $(this).find("input[name^=gia_moi]").val();
          gia = $(this).find("input[name^=gia_deal]").val();
          ten_color = $(this).find(".color span").text();
          color = $(this).find(".color").attr("color");
          ma_mau = $(this).find(".color").attr("ma_mau");
          ten_size = $(this).find(".size span").text();
          size = $(this).find(".size").attr("size");
          if (l == 1) {
            list_pl +=
              '{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '"}';
          } else {
            list_pl +=
              ',{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '"}';
          }
        });
      if (s == 1) {
        list_product +=
          '{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      } else {
        list_product +=
          ',{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      }
    });
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
    } else if (list_product == "") {
      setTimeout(function () {
        $(".load_note").html("Vui lòng chọn sản phẩm kèm theo");
      }, 500);
      setTimeout(function () {
        $(".load_process").hide();
        $(".load_note").html("Hệ thống đang xử lý");
        $(".load_overlay").hide();
      }, 1500);
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_deal",
          loai: loai,
          tieu_de: tieu_de,
          main_product: main_product,
          list_product: list_product,
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
    s = 0;
    list_product = "";
    $("#list_product_sub .li_product").each(function () {
      s++;
      sp_id = $(this).attr("sp");
      list_pl = "";
      l = 0;
      $(this)
        .find(".li_pl")
        .each(function () {
          l++;
          pl = $(this).attr("pl");
          gia_cu = $(this).find("input[name^=gia_cu]").val();
          gia_moi = $(this).find("input[name^=gia_moi]").val();
          gia = $(this).find("input[name^=gia_deal]").val();
          ten_color = $(this).find(".color span").text();
          color = $(this).find(".color").attr("color");
          ma_mau = $(this).find(".color").attr("ma_mau");
          ten_size = $(this).find(".size span").text();
          size = $(this).find(".size").attr("size");
          if (l == 1) {
            list_pl +=
              '{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '"}';
          } else {
            list_pl +=
              ',{"pl": "' +
              pl +
              '","ten_color":"' +
              ten_color +
              '","color":"' +
              color +
              '","ma_mau":"' +
              ma_mau +
              '","ten_size":"' +
              ten_size +
              '","size":"' +
              size +
              '","gia_cu":"' +
              gia_cu +
              '","gia_moi":"' +
              gia_moi +
              '","gia":"' +
              gia +
              '"}';
          }
        });
      if (s == 1) {
        list_product +=
          '{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      } else {
        list_product +=
          ',{"sp_id": "' + sp_id + '","list_pl": [' + list_pl + "]}";
      }
    });
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
    } else if (list_product == "") {
      setTimeout(function () {
        $(".load_note").html("Vui lòng chọn sản phẩm kèm theo");
      }, 500);
      setTimeout(function () {
        $(".load_process").hide();
        $(".load_note").html("Hệ thống đang xử lý");
        $(".load_overlay").hide();
      }, 1500);
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "edit_deal",
          loai: loai,
          tieu_de: tieu_de,
          main_product: main_product,
          list_product: list_product,
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
  $(".box_right_content").on("click", ".del_server", function () {
    $(this).parent().remove();
  });
  /////////////////////////////
  $(".box_right_content").on("click", ".add_server", function () {
    $(".block_bottom").before(
      '<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link nguồn</label><input type="text" class="form_control" name="nguon" value="" placeholder="Nhập nguồn dữ liệu..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="button_select_photo">Chọn ảnh</button><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>'
    );
  });
  /////////////////////////////
  $(".cover").click(function () {
    $("#cover").click();
  });
  /////////////////////////////
  $(".mh_minhhoa").click(function () {
    $("#cat_minhhoa").click();
  });
  $("#cat_minhhoa").change(function () {
    readURL(this, "preview-cat-minhhoa");
  });
  /////////////////////////////
  $(".mh").click(function () {
    $("#minh_hoa").click();
  });
  $("#minh_hoa").change(function () {
    readURL(this, "preview-minhhoa");
  });
  $("#cover").change(function () {
    readURL(this, "preview-cover");
  });
  /////////////////////////////
  $(".mh_socdo").click(function () {
    $("#minh_hoa_socdo").click();
  });
  $("#minh_hoa_socdo").change(function () {
    readURL(this, "preview-minhhoa-socdo");
  });
  /////////////////////////////
  $(".mh_popup").click(function () {
    $("#popup").click();
  });
  $("#popup").change(function () {
    readURL(this, "preview-popup");
  });
  /////////////////////////////
  $(".list_tab_member .li_tab_member").on("click", function () {
    $(".list_tab_member .li_tab_member").removeClass("active");
    $(this).addClass("active");
    var id = $(this).attr("id");
    $(".list_tab_content .li_tab_content").removeClass("active");
    $("#" + id + "_content").addClass("active");
    user_id = $("input[name=id]").val();
    page = 1;
    load = 1;
    if (id == "tab_nap") {
      action = "load_lichsu_nap";
    } else if (id == "tab_order") {
      action = "load_lichsu_dathang";
    } else if (id == "tab_rut") {
      action = "load_lichsu_rut";
    } else if (id == "tab_chitieu") {
      action = "load_lichsu_chitieu";
    } else if (id == "tab_hoandon") {
      action = "load_hoandon";
    } else if (id == "tab_thanhvien_nhom_chuyennghiep") {
      action = "load_thanhvien_nhom_chuyennghiep";
    } else if (id == "tab_donhang_nhom_chuyennghiep") {
      action = "load_donhang_nhom_chuyennghiep";
    } else if (id == "tab_donhang_nhom_socdo_chuyennghiep") {
      action = "load_donhang_nhom_socdo_chuyennghiep";
    } else {
      action = "load_taikhoan";
      load = 0;
    }
    if (load == 1) {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: action,
          page: page,
          user_id: user_id,
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
            $("#" + id + "_content .list_baiviet").html(info.list);
            $("#" + id + "_content").attr("page", info.page);
            $("#" + id + "_content").attr("load", info.load);
          }, 1000);
        },
      });
    }
  });
  if ($(".li_tab_member").length > 0) {
    $(window).scroll(function () {
      console.log($(window).scrollTop());
      console.log($(window).height());
      console.log($(document).height());
      console.log($(window).scrollTop() + $(window).height());
      console.log($(document).height() - 50);
      console.log("-------------");
      if (
        $(window).scrollTop() + $(window).height() >
        $(document).height() - 50
      ) {
        console.log("bottom");
        var id = $(".li_tab_member.active").attr("id");
        console.log(id);
        user_id = $("input[name=id]").val();
        page = $("#" + id + "_content").attr("page");
        load = $("#" + id + "_content").attr("load");
        if (page > 1) {
          if (id == "tab_nap") {
            action = "load_lichsu_nap";
          } else if (id == "tab_order") {
            action = "load_lichsu_dathang";
          } else if (id == "tab_rut") {
            action = "load_lichsu_rut";
          } else if (id == "tab_chitieu") {
            action = "load_lichsu_chitieu";
          } else if (id == "tab_hoandon") {
            action = "load_hoandon";
          } else if (id == "tab_thanhvien_nhom_chuyennghiep") {
            action = "load_thanhvien_nhom_chuyennghiep";
          } else if (id == "tab_donhang_nhom_chuyennghiep") {
            action = "load_donhang_nhom_chuyennghiep";
          } else if (id == "tab_donhang_nhom_socdo_chuyennghiep") {
            action = "load_donhang_nhom_socdo_chuyennghiep";
          } else {
            action = "load_taikhoan";
            load = 0;
          }
          if (load == 1) {
            $("#" + id + "_content").attr("load", "0");
            $.ajax({
              url: "/process.php",
              type: "post",
              data: {
                action: action,
                page: page,
                user_id: user_id,
              },
              success: function (kq) {
                var info = JSON.parse(kq);
                $("#" + id + "_content .list_baiviet").append(info.list);
                $("#" + id + "_content").attr("page", info.page);
                $("#" + id + "_content").attr("load", info.load);
              },
            });
          }
        }
      }
    });
  }
  /////////////////////////////
  $("input[name^=color]").on("click", function () {
    value = $(this).val();
    text = $(this).parent().find("span").html();
    if ($(this).is(":checked")) {
      $(".list_ma").append(
        '<div class="li_ma" id="ma_sanpham_' +
          value +
          '"><input type="text" name="ma_sanpham[]" placeholder="Nhập mã sản phẩm" value="" mau="' +
          value +
          '"><i class="fa fa-arrow-right"></i><span>' +
          text +
          "</span></div>"
      );
    } else {
      $("#ma_sanpham_" + value).remove();
    }
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
  $("#button_thuchien").click(function () {
    id = $("#button_thuchien").attr("post_id");
    loai = $("#button_thuchien").attr("loai");
    action = $("#button_thuchien").attr("action");
    $(".box_pop").hide();
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: action,
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
  $("body").on("click", ".huy_donhang_drop", function () {
    id = $("#button_thuchien_action").attr("post_id");
    $(".box_pop").hide();
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
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
  $(".box_profile").on("click", ".button_select_photo", function () {
    $("#photo-add").click();
  });
  $(".button_add_info").on("click", function () {
    $(".list_info").append(
      '<div class="li_info"><div class="info_name"><input type="text" name="info_name[]" placeholder="Nhập tên thông tin"></div><div class="info_value"><input type="text" name="info_value[]" placeholder="Nhập giá trị thông tin"></div></div>'
    );
  });
  $(".button_add_phanloai").on("click", function () {
    $(".list_phanloai").append(
      '<div class="li_phanloai" pl=""><div class="info_ma"><input type="text" name="ma[]" placeholder="Mã"></div><div class="info_name"><input type="text" name="size[]" placeholder="Kích cỡ"><div class="list_goiy scroll"></div></div><div class="info_mau"><input type="text" name="color[]" placeholder="Màu sắc"><div class="list_goiy scroll"></div></div><div class="info_can_nang"><input type="text" name="can_nang[]" placeholder="Trọng lượng"></div><div class="info_gia"><input type="text" name="gia_cu[]" class="price_format" placeholder="Giá niêm yết"></div><div class="info_gia"><input type="text" name="gia_moi[]" class="price_format" placeholder="Giá bán"></div><div class="info_gia"><input type="text" name="gia_drop[]" class="price_format" placeholder="Giá Drop"></div><div class="info_gia"><input type="text" name="gia_ctv[]" class="price_format" placeholder="Giá CTV"></div><div class="info_gia"><input type="text" name="drop_min[]" class="price_format" placeholder="Giá tối thiểu"></div><div class="info_action"><i class="fa fa-trash-o"></i> Xóa</div></div>'
    );
  });
  ////////////////
  $("body").on(
    "keyup",
    ".list_phanloai .li_phanloai input[name^=gia_moi]",
    function () {
      gia_moi = $(this).val();
      $(this).parent().parent().find("input[name^=drop_min]").val(gia_moi);
    }
  );
  ////////////////
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
  ////////////////
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
  ////////////////
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
  $("#photo-add").on("change", function () {
    var form_data = new FormData();
    form_data.append("action", "upload_photo");
    $.each($("input[name=file]")[0].files, function (i, file) {
      form_data.append("file[]", file);
    });
    //form_data.append('file', file_data);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
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
  $("input[name=link_video]").on("paste", function (event) {
    setTimeout(function () {
      link_video = $("input[name=link_video]").val();
      var vars = [],
        hash;
      var hashes = link_video.slice(link_video.indexOf("?") + 1).split("&");
      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split("=");
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
      }
      id_video = vars["v"];
      $("#preview-minhhoa").attr(
        "src",
        "https://i.ytimg.com/vi/" + id_video + "/sddefault.jpg"
      );
    }, 500);
  });
  $("input[name=slug]").on("keyup", function () {
    slug = $(this).val();
    id = $("input[name=id]").val();
    $.ajax({
      url: "/process.php",
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
  $(".drop_down").on("click", function () {
    $(".drop_down").find(".drop_menu").slideUp("300");
    if ($(this).find(".drop_menu").is(":visible")) {
      $(this).find(".drop_menu").slideUp("300");
    } else {
      $(this).find(".drop_menu").slideDown("300");
    }
  });
  /////////////////////////////
  $(document).mouseup(function (e) {
    var dr = $(".drop_menu");
    if (!dr.is(e.target) && dr.has(e.target).length === 0) {
      $(".drop_menu").slideUp("300");
    }
  });
  $("body").on("click", "#main_category .li_input input", function () {
    if ($(this).is(":checked")) {
      id = $(this).val();
      $.ajax({
        url: "/process.php",
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
        url: "/process.php",
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
  $("#timkiem_thuonghieu").on("change", function () {
    thuong_hieu = $(this).val();
    $(".pagination").hide();
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "timkiem_sanpham_thuonghieu",
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
          } else {
          }
        }, 1000);
      },
    });
  });
  $("input[name=key]").keypress(function (e) {
    if (e.which == 13) {
      key = $("input[name=key]").val();
      if ($("button[name=timkiem_sanpham]").length > 0) {
        action = "timkiem_sanpham";
      } else if ($("button[name=timkiem_sanpham_trend]").length > 0) {
        action = "timkiem_sanpham_trend";
      } else if ($("button[name=timkiem_sanpham_tuan]").length > 0) {
        action = "timkiem_sanpham_tuan";
      } else if ($("button[name=timkiem_thanhvien]").length > 0) {
        action = "timkiem_thanhvien";
      } else if ($("button[name=timkiem_thanhvien_nhom]").length > 0) {
        id = $("button[name=timkiem_thanhvien_nhom]").attr("nhom");
        action = "timkiem_thanhvien_nhom";
      } else if ($("button[name=timkiem_thanhvien_drop]").length > 0) {
        action = "timkiem_thanhvien_drop";
      } else if ($("button[name=timkiem_bom]").length > 0) {
        action = "timkiem_bom";
      } else if ($("button[name=timkiem_donhang]").length > 0) {
        action = "timkiem_donhang";
      } else if ($("button[name=timkiem_donhang_ctv]").length > 0) {
        var action = "timkiem_donhang_ctv";
      }
      if (key.length < 1) {
        $("input[name=key]").focus();
      } else {
        if (action == "timkiem_thanhvien_nhom") {
          $(".load_overlay").show();
          $(".load_process").fadeIn();
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: action,
              key: key,
              id: id,
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
                  $(".pagination").hide();
                } else {
                }
              }, 1000);
            },
          });
        } else {
          $(".load_overlay").show();
          $(".load_process").fadeIn();
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: action,
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
                  $(".list_baiviet").html(info.list);
                  $(".pagination").hide();
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
                      $(this).countdown(
                        con + currentDate.valueOf(),
                        call_flash
                      );
                    });
                  }
                } else {
                }
              }, 1000);
            },
          });
        }
      }
    }
  });
  $("#filter_button").on("click", function () {
    var startDate = $("#start_date").val(); // Định dạng yyyy-MM-dd
    var endDate = $("#end_date").val(); // Định dạng yyyy-MM-dd
    var status = $("#status").val();

    // Chuyển đổi từ yyyy-MM-dd sang dd/MM/yyyy
    startDate = startDate.split("-").reverse().join("/");
    endDate = endDate.split("-").reverse().join("/");

    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "filter_thanhvien",
        start_date: startDate, // Định dạng dd/MM/yyyy
        end_date: endDate, // Định dạng dd/MM/yyyy
        status: status,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.ok == 1) {
          $(".list_baiviet").html(data.list);
          // Thêm màu nền cho các hàng có dropship = 1
          // $(".add_hot").css("background-color", "#FAFF9A");
        }
      },
    });
  });
  $("#filter_button_drop").on("click", function () {
    var startDate_drop = $("#start_date_drop").val(); // Định dạng yyyy-MM-dd
    var endDate_drop = $("#end_date_drop").val(); // Định dạng yyyy-MM-dd

    // Chuyển đổi từ yyyy-MM-dd sang dd/MM/yyyy
    startDate_drop = startDate_drop.split("-").reverse().join("/");
    endDate_drop = endDate_drop.split("-").reverse().join("/");

    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "filter_thanhvien_drop",
        start_date_drop: startDate_drop, // Định dạng dd/MM/yyyy
        end_date_drop: endDate_drop, // Định dạng dd/MM/yyyy
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.ok == 1) {
          $(".list_baiviet").html(data.list);
          // Thêm màu nền cho các hàng có dropship = 1
          // $(".add_hot").css("background-color", "#FAFF9A");
        }
      },
    });
  });
  $("input[name=key]").keypress(function (e) {
    if (e.which == 13) {
      key = $("input[name=key]").val();
      if ($("button[name=timkiem_sanpham]").length > 0) {
        action = "timkiem_sanpham";
      } else if ($("button[name=timkiem_sanpham_trend]").length > 0) {
        action = "timkiem_sanpham_trend";
      } else if ($("button[name=timkiem_sanpham_tuan]").length > 0) {
        action = "timkiem_sanpham_tuan";
      } else if ($("button[name=timkiem_thanhvien]").length > 0) {
        action = "timkiem_thanhvien";
      } else if ($("button[name=timkiem_thanhvien_nhom]").length > 0) {
        id = $("button[name=timkiem_thanhvien_nhom]").attr("nhom");
        action = "timkiem_thanhvien_nhom";
      } else if ($("button[name=timkiem_thanhvien_drop]").length > 0) {
        action = "timkiem_thanhvien_drop";
      } else if ($("button[name=timkiem_thanhvien_banhang]").length > 0) {
        action = "timkiem_thanhvien_banhang";
      } else if ($("button[name=timkiem_bom]").length > 0) {
        action = "timkiem_bom";
      } else if ($("button[name=timkiem_donhang]").length > 0) {
        action = "timkiem_donhang";
      } else if ($("button[name=timkiem_donhang_ctv]").length > 0) {
        var action = "timkiem_donhang_ctv";
      }
      if (key.length < 1) {
        $("input[name=key]").focus();
      } else {
        if (action == "timkiem_thanhvien_nhom") {
          $(".load_overlay").show();
          $(".load_process").fadeIn();
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: action,
              key: key,
              id: id,
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
                  $(".pagination").hide();
                } else {
                }
              }, 1000);
            },
          });
        } else {
          $(".load_overlay").show();
          $(".load_process").fadeIn();
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: action,
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
                  $(".list_baiviet").html(info.list);
                  $(".pagination").hide();
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
                      $(this).countdown(
                        con + currentDate.valueOf(),
                        call_flash
                      );
                    });
                  }
                } else {
                }
              }, 1000);
            },
          });
        }
      }
    }
  });

  // Hàm kích hoạt đếm ngược
  function activateCountdown() {
    let currentDate = new Date(),
      finished = false,
      availableExamples = {
        set5ngay: 15 * 24 * 60 * 60 * 1000,
        set5phut: 5 * 60 * 1000,
        set1phut: 1 * 10 * 1000,
      };

    function call_flash(event) {
      let $this = $(this);
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
          let status = $this.attr("status");
          if (status == 0) {
            $this.find(".text_time").html("Kết thúc sau:");
            let con = $this.attr("thoigian") * 1000;
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
      let con = $(this).attr("time") * 1000;
      $(this).countdown(con + currentDate.valueOf(), call_flash);
    });
  }
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
            url: "/process.php",
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
  socket.on("server_send_hoatdong", function (data) {
    var info = JSON.parse(data);
    bo_phan = $("input[name=bophan_hotro]").val();
    if (info.hd == "notification") {
      if (bo_phan == info.bo_phan || bo_phan == "all") {
        $.ajax({
          url: "/process.php",
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
    } else if (info.hd == "thongbao_nhanviec") {
      user_id = $("input[name=thanhvien_chat]").val();

      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_tk_notification",
        },
        success: function (kq) {
          var infod = JSON.parse(kq);
          if (info.nguoinhan === user_id) {
            console.log("nguoi nhan ne" + info.nguoinhan);

            $("#play_chat_global").click();
            $(".total_notification").html(infod.total_notification);
          }
          $.ajax({
            url: "/process.php",
            type: "post",
            data: {
              action: "load_function_giaoviec",
            },
            success: function (kq) {
              var infoo = JSON.parse(kq);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .tong_congviec_kk').text(infoo.total);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .chuatienhanh_kk').text(infoo.chuatienhanh);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .dangtienhanh_kk').text(infoo.dangtienhanh);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .chopheduyet_kk').text(infoo.chopheduyet);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .giahan_kk').text(infoo.giahan);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .miss_deadline_kk').text(infoo.missdeadline);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .tuchoi_kk').text(infoo.tuchoi);
              $('.congviec_cuanhanvien_a .thongke_g .thongtinthongke .grid_thongke .dahoanthanh_kk').text(infoo.dahoanthanh);


              //////////////////////////

              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .tong_congviec_kk').text(infoo.total_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .chuatienhanh_kk').text(infoo.chuatienhanh_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .dangtienhanh_kk').text(infoo.dangtienhanh_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .chopheduyet_kk').text(infoo.chopheduyet_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .giahan_kk').text(infoo.giahan_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .miss_deadline_kk').text(infoo.missdeadline_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .tuchoi_kk').text(infoo.tuchoi_admin);
              $('.congviec_cuaadanhsach_nhansu .thongke_g .thongtinthongke .grid_thongke .dahoanthanh_kk').text(infoo.dahoanthanh_admin);

              ///////////////////////////
              $(".list_viec_dagiao_ns .congviec_cuanhansu_a .table_nhansu_xemviec tbody").html(infoo.list_nhansu);
              // $(".thongke_g .list_viec_dagiao_ns .box_danhsachnhansu1 .congviec_cuanhansu_a .table_nhansu_xemviec tbody").html(infoo.list_nhansu);
              $(".list_viec_dagiao .congviec_cuanhansu_a .table_nhansu_xemviec tbody").html(infoo.list_nhansu);
              $(".list_viec_dagiao .box_danhsachnhansu1 table tbody").html(infoo.list_admin);
              $(".congviec_cuaadanhsach_nhansu .box_danhsachnhansu table tbody").html(
                infoo.list_dexuat_admin
              );
              $(".congviec_cuanhanvien_a .box_danhsachnhansu table tbody").html(
                infoo.list_dexuat_nhanvien
              );
              $('.bruh_l_a21').html( "("+infoo.so_o + ")");
              $("body")
                .find("button[name='congviec_nv_d']")
                .each(function () {
                  startCountdown(this);
                });
              updateCountdown();
            },
          });
        },
      });
    }
  });
  //////////////////////////////
  $('body').on('input','.baocao-phantram',function(){
    let val = $(this).val();

        val = val.replace(/[^0-9]/g, '');
        let num = parseInt(val, 10);
        if (isNaN(num)) {
            $(this).val('');
        } else {
            if (num > 100) num = 100;
            $(this).val(num);
        }
  })
  /////////////////////////////
  socket.on("server_send_traodoi", function (data) {
    user_out = $(".box_chat input[name=user_out]").val();
    phien = $("#submit_yeucau").attr("phien");
    bo_phan = $("input[name=bophan_hotro]").val();
    var info = JSON.parse(data);
    if (user_out == info.user_out) {
    } else {
      if (bo_phan == info.bo_phan || bo_phan == "all") {
        $("#play_chat").click();
        if (phien == info.phien) {
          if (info.loai == "thanh_vien") {
            $("#list_chat").append(info.list_out);
          } else {
            $("#list_chat").append(info.list);
          }
          scrollSmoothToBottom("list_chat");
        }
      }
    }
  });
  /////////////////////////////
  socket.on("server_send_list_yeucau", function (data) {
    phien = $("#submit_yeucau").attr("phien");
    user_out = $(".box_chat input[name=user_out]").val();
    bo_phan = $("input[name=bophan_hotro]").val();
    var info = JSON.parse(data);
    if (user_out == info.user_out) {
    } else {
      if (bo_phan == info.bo_phan || bo_phan == "all") {
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "load_list_yeucau",
            phien: phien,
          },
          success: function (kq) {
            var info = JSON.parse(kq);
            $("#play_chat_global").click();
            $("#list_yeucau").html(info.list);
          },
        });
      }
    }
  });
  /////////////////////////////
  socket.on("server_send_dong_yeucau", function (data) {
    phien = $("#submit_yeucau").attr("phien");
    user_out = $(".box_chat input[name=user_out]").val();
    bo_phan = $("input[name=bophan_hotro]").val();
    var info = JSON.parse(data);
    if (user_out == info.user_out) {
    } else {
      if (bo_phan == info.bo_phan || bo_phan == "all") {
        $.ajax({
          url: "/process.php",
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
    }
  });
  /////////////////////////////

  /////////////////////////////

  /////////////////////////////

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
        url: "/process.php",
        type: "post",
        data: {
          action: "dangnhap",
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
              window.location.href = "/dashboard";
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
      url: "/process.php",
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
  $("button[name=button_profile]").on("click", function () {
    name = $("input[name=name]").val();
    mobile = $("input[name=mobile]").val();
    if (name.length < 2) {
      $("input[name=name]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "edit_profile",
          name: name,
          mobile: mobile,
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
  /////////////////////////////
  $(".button_change_avatar").click(function () {
    $("#file").click();
  });
  /////////////////////////////
  $(".cover_now .button_change").click(function () {
    $("#file_cover").click();
  });
  /////////////////////////////

  /////////////////////////////

  /////////////////////////////

  /////////////////////////////

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
        url: "/process.php",
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
  $("button[name=edit_quantri").on("click", function () {
    password = $("input[name=password]").val();
    name = $("input[name=name]").val();
    mobile = $("input[name=mobile]").val();
    email = $("input[name=email]").val();
    address = $("input[name=address]").val();
    bo_phan = $("select[name=bo_phan]").val();
    var list_group = [];
    $(".li_input input:checked").each(function () {
      list_group.push($(this).val());
    });
    list_group = list_group.toString();
    id = $("input[name=id]").val();
    if (name.length < 2) {
      $("input[name=name]").focus();
    } else {
      var form_data = new FormData();
      form_data.append("action", "edit_quantri");
      form_data.append("password", password);
      form_data.append("name", name);
      form_data.append("mobile", mobile);
      form_data.append("bo_phan", bo_phan);
      form_data.append("email", email);
      form_data.append("address", address);
      form_data.append("group", list_group);
      form_data.append("id", id);
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
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
  /////////////////////////////
  $("button[name=add_quantri").on("click", function () {
    username = $("input[name=username]").val();
    password = $("input[name=password]").val();
    name = $("input[name=name]").val();
    mobile = $("input[name=mobile]").val();
    email = $("input[name=email]").val();
    address = $("input[name=address]").val();
    bo_phan = $("select[name=bo_phan]").val();
    var list_group = [];
    $(".li_input input:checked").each(function () {
      list_group.push($(this).val());
    });
    list_group = list_group.toString();
    if (username.length < 4) {
      $("input[name=username]").focus();
    } else if (password.length < 6) {
      $("input[name=password]").focus();
    } else {
      var form_data = new FormData();
      form_data.append("action", "add_quantri");
      form_data.append("username", username);
      form_data.append("password", password);
      form_data.append("name", name);
      form_data.append("mobile", mobile);
      form_data.append("email", email);
      form_data.append("address", address);
      form_data.append("group", list_group);
      form_data.append("bo_phan", bo_phan);
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
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
  /////////////////////////////
  $("input[name=goi_y]").on("keyup", function () {
    tieu_de = $(this).val();
    cat = $("select[name=category]").val();
    if (tieu_de.length < 2) {
    } else {
      $.ajax({
        url: "/process.php",
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
  /////////////////////////////
  $(document).click(function () {
    $(".khung_goi_y:visible").slideUp("300");
    //j('.main_list_menu:visible').hide();
  });
  /////////////////////////////
});

/////////////////////////
$(document).on("click", 'button[name="add_phongban"]', function () {
  var form_data = new FormData();
  nhanvien = [];
  $("#selected-users .selected-user").each(function () {
    nhanvien.push($(this).attr("data-id"));
  });
  truongphong = $("#selected-truongphong .selected-user").attr("data-id");
  phongban = $("input[name=tieu_de_phongban]").val();
  chon_phong_ban = $("select[name=select_phongban]").val();

  form_data.append("action", "aaddphongban");
  form_data.append("id_truongphong", truongphong);
  form_data.append("id_nhanvien", nhanvien);
  form_data.append("tieu_de_phongban", phongban);
  form_data.append("select_phongban", chon_phong_ban);
  $(".load_overlay").show();
  $(".load_process").fadeIn();

  $.ajax({
    url: "/process.php",
    type: "post",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (kq) {
      if (isJson(kq) == false) {
        setTimeout(function () {
          $(".load_note").html("Gặp lỗi trong lúc xử lý");
        }, 1000);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
        }, 3000);
      } else {
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
      }
    },
  });
});

// sáng 20/3
$(document).ready(function () {
  // Lưu danh sách nhân viên ban đầu
  let allEmployeeOptions = {
    nguoinhan: $("#nguoinhan_selected option").clone(),
    giamsat: $("#nguoigiam_sat_selected option").clone(),
  };

  // Xử lý khi chọn phòng ban
  $("#selected_phongban").on("change", function () {
    let selectedParentId = $(this).val(); // Lấy parent_id được chọn

    // Reset danh sách
    $("#nguoinhan_selected")
      .empty()
      .append('<option value="">Chọn người nhận</option>');
    $("#nguoigiam_sat_selected")
      .empty()
      .append('<option value="">Chọn người giám sát</option>');

    if (selectedParentId) {
      // Lọc nhân viên có id_phongban = parent_id được chọn
      allEmployeeOptions.nguoinhan.each(function () {
        if ($(this).data("phongban") == selectedParentId) {
          $("#nguoinhan_selected").append($(this).clone());
        }
      });

      allEmployeeOptions.giamsat.each(function () {
        if ($(this).data("phongban") == selectedParentId) {
          $("#nguoigiam_sat_selected").append($(this).clone());
        }
      });
    } else {
      // Nếu không chọn phòng ban thì hiện tất cả
      $("#nguoinhan_selected").append(allEmployeeOptions.nguoinhan.clone());
      $("#nguoigiam_sat_selected").append(allEmployeeOptions.giamsat.clone());
    }
  });
});

// 19/03
$(".scroll_hidden_fixxx").css("display", "none");

$(document).on("click", 'button[name="add_giaoviec"]', function () {
  $(".error-message").hide();

  var phong_ban = $("select[name='phongban_nhan[]']").val();
  var nguoinhan = $("select[name='id_nhanvien[]']").val();
  var ten_congviec = $("input[name='ten_congviec']").val().trim();
  var chitiet_congviec = $("textarea[name='chitiet_congviec']").val().trim();
  var thoi_han = $("input[name='thoi_han']").val().trim();
  var thoigian_phainhanviec = $("#thoigian_phainhanviec").val().trim();
  var nguoigiamsat = $("select[name='nguoigiamsat[]']").val() || [];
  var file = $("#file_dinhkem")[0].files[0];
  var uu_tien = $("#uu_tien").val();

  var isValid = true;

  // Validate các
  if (!phong_ban) {
    $("select[name='phongban_nhan[]']").next(".error-message").show();
    isValid = false;
  }
  if (!nguoinhan) {
    $("select[name='id_nhanvien[]']").next(".error-message").show();
    isValid = false;
  }
  if (!ten_congviec) {
    $("input[name='ten_congviec']").next(".error-message").show();
    isValid = false;
  }
  if (!chitiet_congviec) {
    $("textarea[name='chitiet_congviec']").next(".error-message").show();
    isValid = false;
  }
  if (!thoi_han) {
    $("input[name='thoi_han']")
      .next(".error-message")
      .text("Vui lòng nhập thời hạn")
      .show();
    isValid = false;
  }

  // **Validate trường "Trong vòng bao lâu phải nhận việc"**
  if (!thoigian_phainhanviec) {
    $("#thoigian_phainhanviec")
      .next(".error-message")
      .text("Vui lòng nhập thời gian nhận việc")
      .show();
    isValid = false;
  } else if (!/^\d+$/.test(thoigian_phainhanviec)) {
    $("#thoigian_phainhanviec")
      .next(".error-message")
      .text(
        "Vui lòng chỉ nhập số nguyên không âm (ví dụ: 30), không ký tự đặc biệt"
      )
      .show();
    isValid = false;
  } else {
    var thoigian_value = parseInt(thoigian_phainhanviec, 10);
    if (thoigian_value < 0) {
      $("#thoigian_phainhanviec")
        .next(".error-message")
        .text("Vui lòng nhập số nguyên không âm (ví dụ: 30)")
        .show();
      isValid = false;
    }
  }

  // **Validate trường "Chọn thời gian nhận việc"**

  // Nếu validate thất bại, dừng lại
  if (!isValid) {
    return;
  }

  // Nếu validate thành công, tiếp tục gửi form
  var form_data = new FormData();
  form_data.append("action", "add_giaoviec");
  form_data.append("id_nhanvien", nguoinhan);
  form_data.append("thoigian_phainhanviec", thoigian_phainhanviec);
  form_data.append("nguoigiamsat", nguoigiamsat);
  form_data.append("phongban_nhan", phong_ban);
  form_data.append("ten_congviec", ten_congviec);
  form_data.append("uu_tien", uu_tien);
  form_data.append("chitiet_congviec", chitiet_congviec);
  form_data.append("file", file);
  form_data.append("thoi_han", thoi_han);

  // Hiển thị overlay và gửi AJAX
  $(".load_overlay").show();
  $(".load_process").fadeIn();

  $.ajax({
    url: "/process.php",
    type: "post",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (kq) {
      if (isJson(kq) == true) {
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
              hd: "thongbao_nhanviec",
              nguoinhan: nguoinhan,
            };
            var info_chat = JSON.stringify(dulieu);
            socket.emit("user_send_hoatdong", info_chat);
            $(".thongke_g").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_thongke]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
          }
        }, 3000);
      } else {
        setTimeout(function () {
          $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
        }, 1000);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
        }, 3000);
      }
    },
  });
});

// Hàm parseCustomDate (đã định nghĩa trước đó)
function parseCustomDate(dateString) {
  var parts = dateString.split(" ");
  if (parts.length !== 2) return null;

  var timeParts = parts[0].split(":");
  var dateParts = parts[1].split("-");

  if (timeParts.length !== 3 || dateParts.length !== 3) return null;

  var seconds = timeParts[2].padStart(2, "0");
  var year = parseInt(dateParts[2], 10);
  var month = parseInt(dateParts[1], 10) - 1; // Tháng trong JS từ 0-11
  var day = parseInt(dateParts[0], 10);
  var hours = parseInt(timeParts[0], 10);
  var minutes = parseInt(timeParts[1], 10);
  var secondsInt = parseInt(seconds, 10);

  return new Date(year, month, day, hours, minutes, secondsInt);
}

$(document).ready(function () {
  $('button[name="add_phongbanmoi"]').on("click", function () {
    var form_data = new FormData();
    let ten_phongban = $("input[name=ten_phongban_moi]").val();
    let phongbancha = $("select[name=phongbancha]").val();
    console.log(ten_phongban);

    form_data.append("ten_phongban", ten_phongban);
    form_data.append("phongbancha", phongbancha);
    form_data.append("action", "add_phongbanmoi");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        setTimeout(function () {
          $(".load_note").html(info.thongbao);
          setTimeout(function () {
            window.location.reload();
          }, 3000);
        }, 1000);
      },
    });
  });
});
$(document).ready(function () {
  $("body").on("click", "button[name=xac_nhan_congviec_duocgiao]", function () {
    id = $(this).attr("data-id");
    var form_data = new FormData();
    form_data.append("id", id);
    form_data.append("action", "xac_nhan_congviec_duocgiao");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $(".box_popup_trang_nhansu").hide();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        $('.box_popup_trang_nhansu').remove();
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
              var dulieu = {
                hd: "thongbao_nhanviec",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });

    /////////////////////////
  });
  $("body").on("click", "button[name=submit_update_tiendo]", function () {
    let id = $(this).attr("data-id");
    var form_data = new FormData();
    let tiendo = $("input[name=update_tiendo" + id + "]").val();
    noidungbaocao = $("#baocaotiendohangngay" + id + "").val();
    let file = $("input[name=file_baocao_tiendo" + id + "]")[0].files[0];
    form_data.append("id", id);
    form_data.append("tiendo", tiendo);
    form_data.append("noidungbaocao", noidungbaocao);
    form_data.append("file", file);
    form_data.append("action", "update_tiendo_giaoviec");
    console.log(file);

    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        $('.chitiet_viecduocgiao').remove();
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
              var dulieu = {
                hd: "thongbao_nhanviec",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });
  $("body").on("click", ".xemchitiet_cv_cuanhanvien", function () {
    id = $(this).attr("data-id");
    var form_data = new FormData();
    form_data.append("action", "a_load_xem_chitiet_congviec_cuanhansu");
    form_data.append("id", id);
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".dongthechitietcongviec").html(info);
      },
    });
  });
  $("body").on("click", ".xemchitiet_cv_sep", function () {
    id = $(this).attr("data-id");
    var form_data = new FormData();
    form_data.append("action", "a_load_xem_chitiet_congviec_cuasep");
    form_data.append("id", id);
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".dongthechitietcongviec").html(info);
      },
    });
  });
  $("body").on("click", "button[name=xacnhanqua_hannhanviec]", function () {
    lydo = $("input[name=lydo_debiquahan]").val();
    // Thêm đoạn kiểm tra lý do trống
    if (lydo.trim() === '') {
      $(".load_note").html("Vui lòng nhập lý do trước khi xác nhận!");
      $(".box_main_mid_in_trang_nhansu").hide();
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      setTimeout(function () {
        $(".load_note").html("Vui lòng nhập lý do trước khi xác nhận!");
        $(".load_process").hide();
        $(".load_overlay").hide();
        $(".box_main_mid_in_trang_nhansu").show();
      }, 2000);
    }else{
      id = $(this).attr("data-id");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    var form_data = new FormData();
    form_data.append("action", "acp_khi_quahan");
    form_data.append("id", id);
    form_data.append("lydo", lydo);

    $.ajax({
      url: "/admincp/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        $('.box_popup_trang_nhansu').remove();
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_overlay").hide();
            var dulieu = {
              hd: "thongbao_nhanviec",
            };
            var info_chat = JSON.stringify(dulieu);
            socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
    }
  });
  $("body").on("click", ".xemchitiet_congviec_cuagiamsat", function () {
    id = $(this).attr("data-id");
    var form_data = new FormData();
    form_data.append("action", "load_chitiet_cv_cuagiamsat");
    form_data.append("id", id);
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".dongthechitietcongviec").html(info);
      },
    });
  });
  $("body").on("click", ".close_viec_cua_ban", function () {
    $(".chitiet_viecduocgiao").remove();
  });
  $("body").on("click", "button[name=baocao_cuanhanvien]", function () {
    id = $(this).attr("data-id");
    $(".baocao_" + id).css("display", "block");
  });
  $("body").on("click", "button[name=close_baocao_nhanvien]", function () {
    $(".baocaocuanhanvien").css("display", "none");
  });
  $("body").on("click", "button[name=yeucaugiahan]", function () {
    id = $(this).attr("data-id");
    $(".giahan_" + id).css("display", "block");
  });
  $("body").on("click", "button[name=close_baocao_nhanvien]", function () {
    $(".baocaocuanhanvien").css("display", "none");
  });
  $("body").on("click", "button[name=xingiahan]", function () {
    form_data = new FormData();
    id = $(this).attr("data-id");
    noidung_xingiahan = $("textarea[name=noidung_xingiahan" + id + "]").val();
    thoihan = $("input[name=date_line_xingiahan" + id + "]").val();
    let file = $("input[name=file_xingiahan" + id + "]")[0].files[0];
    form_data.append("action", "xingiahan_cuanhanvien");
    form_data.append("id", id);
    form_data.append("noidung", noidung_xingiahan);
    form_data.append("thoihan", thoihan);
    form_data.append("file", file);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        $(".chitiet_viecduocgiao").remove();
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
              var dulieu = {
                hd: "thongbao_nhanviec",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });
  $(document).on("click", "button[name=congviec_nv_d]", function () {
    id = $(this).data("id");
    form_data = new FormData();
    form_data.append("action", "a_load_acp_congviec_duocgiao_form");
    form_data.append("id", id);
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".bruh_nhansuuukakak").html(info);
      },
    });
  });
  $("body").on("click", "button[name=close_congviec_nv_d]", function () {
    $(".box_popup_trang_nhansu").remove();
  });
  $("body").on("click", "button[name=tuchoi_congviec_b]", function () {
    id = $(this).data("id");
    $(".value_id_tuchoixacnhan" + id).show();
  });
  $("body").on(
    "click",
    "button[name=xacnhan_tuchoi_congviec_duocgiao]",
    function () {
      id = $(this).attr("data-id");
      noidung = $("#lydotuchoi_congviec_ns" + id).val();
      if (noidung.trim() === '') {
        $(".load_note").html("Vui lòng nhập lý do trước khi xác nhận!");
        $(".box_main_mid_in_trang_nhansu").hide();
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        setTimeout(function () {
          $(".load_note").html("Vui lòng nhập lý do trước khi xác nhận!");
          $(".load_process").hide();
          $(".load_overlay").hide();
          $(".box_main_mid_in_trang_nhansu").show();
        }, 2000);
      }else{
        var form_data = new FormData();
      form_data.append("action", "tuchoi_congviec_duocgiao");
      form_data.append("id", id);
      form_data.append("noidung", noidung);
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (kq) {
          if (isJson(kq) == true) {
            var info = JSON.parse(kq);
            setTimeout(function () {
              $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
              $(".load_process").hide();
              $(".load_overlay").hide();
              if (info.ok == 1) {
                var dulieu = {
                  hd: "thongbao_nhanviec",
                };
                var info_chat = JSON.stringify(dulieu);
                socket.emit("user_send_hoatdong", info_chat);

                window.location.reload();
              }
            }, 3000);
          } else {
            setTimeout(function () {
              $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
            }, 1000);
            setTimeout(function () {
              $(".load_process").hide();
              $(".load_note").html("Hệ thống đang xử lý");
              $(".load_overlay").hide();
            }, 3000);
          }
        },
      });
      }
    }
  );

  $("body").on("click", "button[name=dexuat]", function () {
    $(".button_socdo_giaoviec").removeClass("active");
    $(this).addClass("active");
    $(".themphongban").css("display", "none");
    $(".dexuat_chosep").css("display", "block");
    $("body").on("click", "button[name=dexuat_cuatoi]", function () {
      $(".mau_dexuat").removeClass("active_success");
      $(this).addClass("active_success");
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "load_dexuat_cuatoi",
          },
          success: function (response) {
            try {
              const data = JSON.parse(response);
              $(".box_danhsach_dexuat").html(data.html);
            } catch (e) {
              console.error("Lỗi parse JSON:", e);
              alert("Có lỗi xảy ra khi xử lý dữ liệu");
            }
          },
        });
      });
  });

  $("body").on(
    "click",
    "button[name=search_dexuat_btn]",
    function () {
      keyword = $("input[name=search_dexuat]").val();
      // console.log(keyword);
      localStorage.setItem("prea", $(".add_form_dexuat_a").html());
      var form_data = new FormData();
      form_data.append("action", "search_dexuat");
      form_data.append("keyword", keyword);
      $.ajax({
        url: "/process.php",
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".box_danhsach_dexuat").html(info.html);
        },
      });
    }
  );

  $("body").on("click", "button[name=submit_dexuat]", function () {
    tieu_de = $("input[name=tieu_de_dexuat]").val();
    noi_dung = $("textarea[name=noi_dung_dexuat]").val();
    datetime_local = $("input[name=datetime_local]").val();
    nguoinhan = [];
    $("#sepnhan_selected .sepnhan_selected_c button").each(function () {
      nguoinhan.push($(this).attr("data-id"));
    });

    let file = $("input[name=file]")[0].files[0];
    var form_data = new FormData();
    form_data.append("action", "dexuat_chosep");
    form_data.append("tieu_de", tieu_de);
    form_data.append("noi_dung", noi_dung);
    form_data.append("datetime_local", datetime_local);
    form_data.append("nguoinhan", nguoinhan);
    form_data.append("file", file);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        if (isJson(kq) == true) {
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
                hd: "thongbao_nhanviec",
                nguoinhan: nguoinhan,
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
              if (info.all == 1) {
                
$(".dexuat").css("display", "block");
$(".btn_remove_giaoviec").removeClass("active");
$("button[name=tab_dexuat]").addClass("active");

var form_data = new FormData();
form_data.append("action", "tab_action_box_dexuat");
$.ajax({
  url: "/process.php",
  type: "POST",
  data: form_data,
  cache: false,
  contentType: false,
  processData: false,
  success: function (kq) {
    var info = JSON.parse(kq);
    $(".thongke_g").html(info);
  },
});
              }else{
                
$(".dexuat").css("display", "block");
$(".btn_remove_giaoviec").removeClass("active");
$("button[name=tab_dexuat_ns]").addClass("active");

var form_data = new FormData();
form_data.append("action", "tab_action_box_dexuat_ns");
$.ajax({
  url: "/process.php",
  type: "POST",
  data: form_data,
  cache: false,
  contentType: false,
  processData: false,
  success: function (kq) {
    var info = JSON.parse(kq);
    $(".thongke_g").html(info);
  },
});
              }
            }
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });

  $("body").on("click", "button[name=danhsachcongvieccuanhansu]", function () {
    $(".button_socdo_giaoviec").removeClass("active");
    $(this).addClass("active");
    $(".themphongban").css("display", "block");
    $(".dexuat_chosep").css("display", "none");
  });
  $("body").on("click", "button[name=xingiahan_cuanhanvien]", function () {
    id = $(this).attr("data-id");
    $(".tr_name_giahan" + id).css("display", "flex");
  });
  $(".cl_giahan_box button").on("click", function () {
    $(".tr_name_giahan" + id).css("display", "none");
  });
  $("body").on("click", "button[name=xacnhan_giahan_g]", function () {
    $('.xemchi_tiet_congviec').hide();
    var form_data = new FormData();
    id = $(this).attr("data-id");
    tgian = $("input[name=date_line" + id + "]").val();
    noidung = $("textarea[name=ghichu_xacnhan_giahan" + id + "]").val();
    form_data.append("action", "xacnhangiahan");
    form_data.append("tgian", tgian);
    form_data.append("noidung", noidung);
    form_data.append("id", id);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $(".box_xingiahan").hide();
    $(".xemchi_tiet_congviec").hide();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        flatpickr("#dateInput", {
          enableTime: true,  // Bật chọn thời gian
          dateFormat: "d-m-Y H:i", // Định dạng hiển thị
          time_24hr: true // Hiển thị 24 giờ thay vì AM/PM
        });
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
              var dulieu = {
                hd: "thongbao_nhanviec",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });
  $("body").on("click", "button[name=tuchoi_giahan_g]", function () {
    var form_data = new FormData();
    id = $(this).attr("data-id");
    tgian = $("input[name=date_line" + id + "]").val();
    noidung = $("input[name=ghichu_xacnhan_giahan" + id + "]").val();
    form_data.append("action", "tuchoigiahan");
    form_data.append("tgian", tgian);
    form_data.append("noidung", noidung);
    form_data.append("id", id);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        if (isJson(kq) == true) {
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
                hd: "thongbao_nhanviec",
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit("user_send_hoatdong", info_chat);

              window.location.reload();
            }
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });
  $("body").on(
    "click",
    "button[name=themnhanvien_vao_phong_ban_a]",
    function () {
      $(".danhsachnhansu").css("display", "block");
      let id_box = $(this).attr("data-id");

      // Gán sự kiện click cho nút tìm nhân viên
      $(document)
        .off("click", "button[name=search_nhanvien_button]")
        .on("click", "button[name=search_nhanvien_button]", function () {
          let id = $(this).attr("data-id");
          let name = $(this).attr("data-name");

          if ($("#nv_duoc_chon_vaopb" + id_box).length === 0) {
            console.log("❌ Không tìm thấy thẻ #nv_duoc_chon_vaopb" + id_box);
            return;
          }

          $("#nv_duoc_chon_vaopb" + id_box).append(`
                    <div class="selected_nhanvien_dathem" data-id="${id}">
                        <h6>${name}</h6>
                        <button name="xoa_dulieu_nv_dachon" data-id="${id}">X</button>
                    </div>
                `);

          $(this).hide();
        });
    }
  );

  $(".close_nhanvien_phongban").on("click", function () {
    $(".danhsachnhansu").css("display", "none");
  });

  // 🔥 Sửa lỗi: Bắt sự kiện cho nút "xóa" đúng cách
  $(document).on("click", "button[name=xoa_dulieu_nv_dachon]", function () {
    let id = $(this).attr("data-id");
    $(".dulieu_nhanvien_co_id_la" + id).show();
    $(this).closest(".selected_nhanvien_dathem").remove();
  });
});

////value_id_tuchoixacnhan

//////////////////////////////

$(document).ready(function () {
  $("body").on("click", "button[name=giaolai_giaoviec]", function () {
    id = $(this).attr("data-id");
    $(".xemchi_tiet_congviec").remove();
    var form_data = new FormData();
    form_data.append("id", id);
    form_data.append("action", "update_giaolai_congviec");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".box_right").html(info.list);
        $("button[name=search_nhanvien_button][data-id]").hide();
        $(".btn_remove_giaoviec").removeClass("active");
        $("button[name=giaoviec]").addClass("active");
        //////////////////////
        $("button[name=themphongban-form]")
          .off("button[name=themphongban-form]")
          .on("click", function () {
            $(".list_phongban_form").css("display", "block");
          });
        $("button[name=close_form_phongban]").on("click", function () {
          $(".list_phongban_form").css("display", "none");
        });
        $(document).on("click", "button[name=add_phong_ban_form]", function () {
          let id = $(this).attr("data-id");
          let id_nguoi = $("button[name=search_nhanvien_button][data-id]")
            .map(function () {
              return $(this).attr("data-phongban");
            })
            .get();
          id_nguoi.forEach(function (item, index) {
            if (item == id) {
              $(
                'button[name=search_nhanvien_button][data-phongban="' +
                  item +
                  '"]'
              ).show();
            }
          });
          let name_button = $(this).attr("data-name");
          $(this).hide();
          $("#selected_phongban").append(`
         <div class="selected_phongban_dathem" data-id="${id}">
             <h6>${name_button}</h6>
             <button name="xoa_dulieu_phongban_dachon" data-id="${id}">X</button>
         </div>
     `);
        });
        $(document).on(
          "click",
          "button[name=xoa_dulieu_phongban_dachon]",
          function () {
            let id = $(this).attr("data-id");
            $(".selected_nguoinhan_dathem")
              .filter(`[data-phongban='${id}']`)
              .remove();
            $(this).closest(".selected_phongban_dathem").remove();
            let id_nguoi = $("button[name=search_nhanvien_button][data-id]")
              .map(function () {
                return $(this).attr("data-phongban");
              })
              .get();
            id_nguoi.forEach(function (item, index) {
              if (item == id) {
                $(
                  'button[name=search_nhanvien_button][data-phongban="' +
                    item +
                    '"]'
                ).hide();
              }
            });
            $("button.value-id-" + id).show();
          }
        );
        /////////////////////////////////////
        let currentTarget = ""; // Biến lưu phần hiện tại đang mở

        // Khi mở danh sách từ nút "Thêm Người Nhận"
        $("body").on("click", "button[name=themnguoinhan]", function () {
          currentTarget = "nguoinhan";
          $(".list_danhsachnhansu_form").css("display", "block");
        });

        // Khi mở danh sách từ nút "Thêm Người Giám Sát"
        $("body").on("click", "button[name=nguoi_giamsat]", function () {
          currentTarget = "nguoigiamsat";
          $(".list_danhsachnhansu_form").css("display", "block");
        });

        // Đóng danh sách
        $("body").on("click", "button[name=close_add_nhanvien]", function () {
          $(".list_danhsachnhansu_form").css("display", "none");
        });

        // Xử lý chọn nhân viên theo phần đang mở
        $(document).on(
          "click",
          "button[name=search_nhanvien_button]",
          function () {
            let id_nv = $(this).attr("data-id");
            let name_button_nv = $(this).attr("data-name");
            let phongban_id = $(this).attr("data-phongban");
            $(this).hide();

            if (currentTarget === "nguoinhan") {
              $("#nguoinhan_selected").append(`
             <div class="selected_nguoinhan_dathem" data-id="${id_nv}">
                 <h6>${name_button_nv}</h6>
                 <button name="xoa_dulieu_nv_dachon" data-id="${id_nv}" data-phongban="${phongban_id}">X</button>
             </div>
         `);
            } else if (currentTarget === "nguoigiamsat") {
              $("#nguoigiam_sat_selected").append(`
             <div class="selected_giamsat_dathem" data-id="${id_nv}">
                 <h6>${name_button_nv}</h6>
                 <button name="xoa_dulieu_giamsat_dachon" data-id="${id_nv}" data-phongban="${phongban_id}">X</button>
             </div>
         `);
            }
          }
        );
        $(document).on(
          "click",
          "button[name=xoa_dulieu_nv_dachon]",
          function () {
            let id = $(this).attr("data-id");
            $(this).closest(".selected_nguoinhan_dathem").remove();
            $("button.value-id_nv-" + id).show();
          }
        );
        $(document).on(
          "click",
          "button[name=xoa_dulieu_giamsat_dachon]",
          function () {
            let id = $(this).attr("data-id");
            $(this).closest(".selected_giamsat_dathem").remove();
            $("button.value-id_nv-" + id).show();
          }
        );
        $(document).on("keyup", "input[name=search_phongban]", function () {
          let searchText = $(this).val().toLowerCase(); // Lấy nội dung nhập vào và chuyển thành chữ thường

          $("button[name=add_phong_ban_form]").each(function () {
            let phongbanName = $(this).attr("data-name").toLowerCase(); // Lấy tên phòng ban từ data-name

            if (phongbanName.includes(searchText)) {
              $(this).show(); // Hiện nếu có chứa từ khóa tìm kiếm
            } else {
              $(this).hide(); // Ẩn nếu không khớp
            }
          });
        });
        $(document).on("keyup", "input[name=search_nhanvien]", function () {
          let searchText = $(this).val().toLowerCase(); // Lấy nội dung nhập vào và chuyển thành chữ thường

          $("button[name=search_nhanvien_button]").each(function () {
            let phongbanName = $(this).attr("data-name").toLowerCase(); // Lấy tên phòng ban từ data-name

            if (phongbanName.includes(searchText)) {
              $(this).show(); // Hiện nếu có chứa từ khóa tìm kiếm
            } else {
              $(this).hide(); // Ẩn nếu không khớp
            }
          });
        });

        $("body").on("click", "button[name=giaolai_congviec]", function () {
          id_phanviec = $(this).attr("data-id");
          var form_data = new FormData();
          var phong_ban = $("select[name='phongban_nhan[]']").val();
          var nguoinhan = $("select[name='id_nhanvien[]']").val();
          var ten_congviec = $("input[name='ten_congviec']").val().trim();
          var chitiet_congviec = $("textarea[name='chitiet_congviec']")
            .val()
            .trim();
          var thoi_han = $("input[name='thoi_han']").val().trim();
          var thoigian_phainhanviec = $("#thoigian_phainhanviec").val().trim();
          var nguoigiamsat = $("select[name='nguoigiamsat[]']").val() || [];
          var file = $("#file_dinhkem")[0].files[0];
          var uu_tien = $("#uu_tien").val();
          form_data.append("action", "update_giaoviec");
          form_data.append("id_nhanvien", nguoinhan);
          form_data.append("id", id_phanviec);
          form_data.append("thoigian_phainhanviec", thoigian_phainhanviec);
          form_data.append("nguoigiamsat", nguoigiamsat);
          form_data.append("phongban_nhan", phong_ban);
          form_data.append("ten_congviec", ten_congviec);
          form_data.append("uu_tien", uu_tien);
          form_data.append("chitiet_congviec", chitiet_congviec);
          form_data.append("file", file);
          form_data.append("thoi_han", thoi_han);
          $(".load_overlay").show();
          $(".load_process").fadeIn();
          $.ajax({
            url: "/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
              if (isJson(kq) == true) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                  $(".load_note").html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                  $(".load_process").hide();
                  $(".load_note").html("Hệ thống đang xử lý");
                  $(".load_overlay").hide();

                  var dulieu = {
                    hd: "thongbao_nhanviec",
                    nguoinhan: nguoinhan,
                  };
                  var info_chat = JSON.stringify(dulieu);
                  socket.emit("user_send_hoatdong", info_chat);

                  window.location.reload();
                }, 3000);
              } else {
                setTimeout(function () {
                  $(".load_note").html(
                    "Gặp lỗi trong lúc đăng! Vui lòng thử lại"
                  );
                }, 1000);
                setTimeout(function () {
                  $(".load_process").hide();
                  $(".load_note").html("Hệ thống đang xử lý");
                  $(".load_overlay").hide();
                }, 3000);
              }
            },
          });
        });
      },
    });
  });

  $("body").on("click", "button[name=quay_tro_ve]", function () {
    location.reload();
  });
});

//sửa ngày 24/33
$(document).ready(function () {
  // Thêm HTML cho modal vào body
  $("body").append(`
        <div id="rejectModal" class="modal">
            <div class="modal-content">
                <h3>Lý do từ chối</h3> 
                <input type="text" id="rejectReason" style="width: 300px; height: 50px;" placeholder="Nhập lý do từ chối">
                <div class="modal-buttons">
                    <button id="confirmReject">Xác nhận</button>
                    <button id="cancelReject">Hủy</button>
                </div>
            </div>
        </div>
    `);

  // Thêm CSS vào head
  $("head").append(`
        <style>
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
            }
            .modal-content {
                background-color: white;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 400px;
                border-radius: 5px;
            }
            .modal-buttons {
                margin-top: 20px;
                text-align: right;
            }
            .modal-buttons button {
                margin-left: 10px;
            }
        </style>
    `);

  // Xử lý sự kiện cho nút tuchoi_dexuat
  $("body").on("click", "button[name=tuchoi_dexuat]", function () {
    var id = $(this).attr("data-id");

    // Lưu id vào data của modal
    $("#rejectModal").data("id", id);

    // Hiển thị modal
    $("#rejectModal").show();

    // Xử lý nút "Xác nhận" trong modal
    $("#confirmReject")
      .off("click")
      .on("click", function () {
        var noidung_dexuat = $("#rejectReason").val();
        var form_data = new FormData();
        form_data.append("action", "tuchoi_dexuat");
        form_data.append("id", id);
        form_data.append("noidung_dexuat", noidung_dexuat);

        $(".load_overlay").show();
        $(".load_process").fadeIn();

        $.ajax({
          url: "/process.php",
          type: "post",
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          success: function (kq) {
            if (isJson(kq) == true) {
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
                    var dulieu = { hd: "thongbao_nhanviec" };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit("user_send_hoatdong", info_chat);
                  }
                  window.location.reload();
                }
              }, 3000);
            } else {
              setTimeout(function () {
                $(".load_note").html(
                  "Gặp lỗi trong lúc đăng! Vui lòng thử lại"
                );
              }, 1000);
              setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
              }, 3000);
            }
          },
        });

        // Ẩn modal sau khi xác nhận
        $("#rejectModal").hide();
        $("#rejectReason").val("");
      });

    // Xử lý nút "Hủy" trong modal
    $("#cancelReject")
      .off("click")
      .on("click", function () {
        $("#rejectModal").hide();
        $("#rejectReason").val("");
      });
  });

  // Phần code còn lại của bạn (ví dụ: xacnhan_dexuat, xemchitiet, quay_tro_lai_dexuat)
  $("body").on("click", "button[name=xacnhan_dexuat]", function () {
    var id = $(this).attr("data-id");
    var form_data = new FormData();
    form_data.append("action", "xacnhan_dexuat");
    form_data.append("id", id);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
                var dulieu = { hd: "thongbao_nhanviec" };
                var info_chat = JSON.stringify(dulieu);
                socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });

  $("body").on("click", "button[name=xemchitiet]", function () {
    var id = $(this).attr("data-id");
    localStorage.setItem(
      "previousForm",
      $(".thongke_g .list_viec_dagiao").html()
    );
    var form_data = new FormData();
    form_data.append("action", "xemchitiet_dexuat");
    form_data.append("id", id);
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g .list_viec_dagiao .box_danhsachnhansu").html(info);
      },
    });
  });

  $("body").on("click", "button[name=quay_tro_lai_dexuat]", function () {
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_dexuat");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });

});



//kết thúc sửa ngày 24/3
//////////////////
$(document).ready(function () {
  $("body").on("click", ".li_phantrang", function () {
    page = $(this).attr("page");
    var form_data = new FormData();
    form_data.append("action", "aa_load_phantrang_giaoviec");
    form_data.append("page", page);
    $.ajax({
      url: "/process.php",
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".box_danhsachnhansu1").html(info);
      },
    });
  });
  //////////////////////////
  $("body").on("click", "button[name=filter_search_giaoviec]", function () {
    phongban = $("select[name=filter_phongban_giaoviec]").val();
    nhanvien = $("select[name=filter_nhanvien_giaoviec]").val();
    trangthai_congviec = $("select[name=trangthai_congviec_filter]").val();
    start_date = $("input[name=start_date]").val();
    end_date = $("input[name=end_date]").val();
    key = $("input[name=form_seach_giaoviec_list]").val();
    var form_data = new FormData();
    form_data.append("action", "aa_load_phantrang_giaoviec");
    form_data.append("phongban", phongban);
    form_data.append("nhanvien", nhanvien);
    form_data.append("trangthai_congviec", trangthai_congviec);
    form_data.append("start_date", start_date);
    form_data.append("end_date", end_date);
    form_data.append("key", key);
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".box_danhsachnhansu1").html(info);
        $("body")
          .off("click", ".li_phantrang")
          .on("click", ".li_phantrang", function () {
            page = $(this).attr("page");
            var form_data = new FormData();
            form_data.append("action", "aa_load_phantrang_giaoviec");
            form_data.append("page", page);
            form_data.append("phongban", phongban);
            form_data.append("nhanvien", nhanvien);
            form_data.append("trangthai_congviec", trangthai_congviec);
            form_data.append("start_date", start_date);
            form_data.append("end_date", end_date);
            form_data.append("key", key);
            $.ajax({
              url: "/process.php",
              type: "POST",
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              success: function (kq) {
                var info = JSON.parse(kq);
                $(".box_danhsachnhansu1").html(info);
              },
            });
          });
      },
    });
  });
  //////////////////////////////
  $("button[name=themnguoinhan_taiphongban]")
    .off("button[name=themnguoinhan_taiphongban]")
    .on("click", function () {
      $(".list_danhsachnhansu_form").css("display", "block");
      $("button[name=search_nhanvien_button]").on("click", function () {
        id = $(this).attr("data-id");
        name = $(this).attr("data-name");
        $("#nguoinhan_selected_taiphongban").append(
          '<div class="li_nguoinhan" data-id="' +
            id +
            '">' +
            name +
            '<button class="remove_nguoinhan">X</button></div>'
        );
        $(this).remove();
        $(".remove_nguoinhan").on("click", function () {
          $(this).parent().remove();
        });
      });
    });
  $("button[name=themtruongphong_taiphongban]")
    .off("button[name=themtruongphong_taiphongban]")
    .on("click", function () {
      $(".list_danhsachnhansu_form").css("display", "block");
      $("button[name=search_nhanvien_button]").on("click", function () {
        id = $(this).attr("data-id");
        name = $(this).attr("data-name");
        $("#truongphong_selected_taiphongban").html(
          '<div class="li_nguoinhan" data-id="' +
            id +
            '">' +
            name +
            '<button class="remove_nguoinhan">X</button></div>'
        );
        $(".remove_nguoinhan").on("click", function () {
          $(this).parent().remove();
        });
      });
    });
  $("button[name=close_add_nhanvien]").on("click", function () {
    $(".list_danhsachnhansu_form").css("display", "none");
  });
  $("button[name=themnvpb]").on("click", function () {
    id = $(this).attr("data-id");
    let nguoinhan = [];
    $("#nv_duoc_chon_vaopb" + id + " .selected_nhanvien_dathem").each(
      function () {
        nguoinhan.push($(this).attr("data-id"));
      }
    );
    truongphong = $("select[name=them_truongphong_pb" + id + "]").val();
    console.log(id);
    console.log(nguoinhan);
    console.log(truongphong);
    var form_data = new FormData();
    form_data.append("action", "themnvpb");
    form_data.append("nhanvien", nguoinhan);
    form_data.append("id", id);
    form_data.append("truongphong", truongphong);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        setTimeout(function () {
          $(".load_note").html(info.thongbao);
          setTimeout(function () {
            window.location.reload();
          }, 3000);
        }, 1000);
      },
    });
  });
});
$(document).ready(function () {
  $(".tr_phongban_box")
    .off(".tr_phongban_box")
    .on("click", function () {
      let id = $(this).attr("data-id");
      $(".chitietphongban_" + id).css("display", "block");
    });
  $(".close_add_nv_zo_phongban button")
    .off(".close_add_nv_zo_phongban button")
    .on("click", function () {
      id = $(this).attr("data-id");
      $(".chitietphongban_" + id).css("display", "none");
    });
});
$(document).ready(function () {
  $("body").on("click", "button[name=pheduyet_giaoviec]", function () {
    id = $(this).attr("gv");
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    var form_data = new FormData();
    form_data.append("action", "pheduyet_giaoviec");
    form_data.append("id", id);
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        $(".xemchi_tiet_congviec").remove();
        var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
        if (isJson(kq) == true) {
          var info = JSON.parse(kq);
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
            var dulieu = {
              hd: "thongbao_nhanviec",
            };
            var info_chat = JSON.stringify(dulieu);
            socket.emit("user_send_hoatdong", info_chat);
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
          }, 3000);
        }
      },
    });
  });
  $("body").on("click", "button[name=tuchoi_giaoviec]", function () {
    $('.xemchi_tiet_congviec').hide();
    id = $(this).attr("gv");
    noi_dung = $("input[name=ly_dotuchoi_acp]").val();
    var form_data = new FormData();
    form_data.append("action", "tuchoi_giaoviec");
    form_data.append("id", id);
    form_data.append("noi_dung", noi_dung);
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
          $(".xemchi_tiet_congviec").hide();
          if (info.ok == 1) {
            var dulieu = {
              hd: "thongbao_nhanviec",
            };
            var info_chat = JSON.stringify(dulieu);
            socket.emit("user_send_hoatdong", info_chat);
          }
        }, 10);
      },
    });
  });
});
$(document).ready(function () {
  $("body").on("click", "button[name=baocao_cuanhanvien]", function () {
    id = $(this).attr("data-id");
    $(".baocao_" + id).css("display", "block");
  });
  $("body").on("click", "button[name=close_baocao_nhanvien]", function () {
    $(".baocaocuanhanvien").css("display", "none");
  });
});
$(document).ready(function () {
  $("body").on("click", "button[name=lichsu_yeucau_giahan]", function () {
    id = $(this).attr("data-id");
    $(".lichsu_giahan" + id).css("display", "block");
  });
  $("body").on("click", "button[name=close_baocao_nhanvien]", function () {
    $(".baocaocuanhanvien").css("display", "none");
  });
});
////////////////////
$(document).ready(function () {
  $("body").on("click", ".hover_id_giaoviec", function () {
    let id = $(this).attr("data-id");
    var form_data = new FormData();
    console.log(id);

    form_data.append("action", "xemchitiet_adsns");
    form_data.append("id", id);
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".xemchitiet_congviec_dagiao").html(info);
      },
    });
  });
  $("body").on("click", ".close_chitiet_congviec", function () {
    $(".xemchi_tiet_congviec").remove();
  });
  // Ẩn box_chi_tiet_congviec khi click ra ngoài
});

////////////////////
$(document).ready(function () {
  $("body").on("click", ".box_icon_loc_nangcao", function () {
    var form_data = new FormData();
    form_data.append("action", "box_pop_loc_nangcao");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".xemchitiet_congviec_dagiao").html(info);
      },
    });
  });
});

//////////////////////////
$(document).ready(function () {
  $("body").on("click", "button[name=tab_dexuat]", function () {
    $(".dexuat").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_dexuat]").addClass("active");

    var form_data = new FormData();
    form_data.append("action", "tab_action_box_dexuat");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });

  $(document).ready(function () {
    $("body").on("click", "button[name=tab_dexuat_ns]", function () {
      $(".dexuat").css("display", "block");
      $(".btn_remove_giaoviec").removeClass("active");
      $("button[name=tab_dexuat_ns]").addClass("active");
  
      var form_data = new FormData();
      form_data.append("action", "tab_action_box_dexuat_ns");
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".thongke_g").html(info);
        },
      });
    });
  });
  
  ////////////////////////
  $("body")
    .off("click", "button[name=tab_phongban]")
    .on("click", "button[name=tab_phongban]", function () {
      $(".btn_remove_giaoviec").removeClass("active");
      $("button[name=tab_phongban]").addClass("active");
      var form_data = new FormData();
      form_data.append("action", "tab_action_box_phongban");
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(kq){
          var info = JSON.parse(kq);
          if (info.ok==1) {
            $(".thongke_g").html(info.list);
          }else{
            
          $('.thongke_g').html(info.list);
          /////////////////////////////
           
           currentDate_aa_n_b_ff = new Date();
           currentMonth_aa = currentDate_aa_n_b_ff.getMonth();
           currentYear_aa = currentDate_aa_n_b_ff.getFullYear();
           selectedDate_aa = null;
        
          // Dữ liệu mẫu từ database (sẽ được thay thế bằng dữ liệu thực tế)
          const workingDays_s_giaoviec = info.tuan; // Thứ 2 đến thứ 6
          const workSchedule_giaoviec_s = {
            morningStart: info.time_morning,
            lunchStart: info.time_end_morning,
            afternoonStart: info.time_afternoon,
            endTime: info.time_end_afternoon,
          };
        
          function updateCalendar() {
            const daysInMonth = new Date(
              currentYear_aa,
              currentMonth_aa + 1,
              0
            ).getDate();
            const firstDayOfMonth = new Date(currentYear_aa, currentMonth_aa, 1).getDay();
            const lastDayOfMonth = new Date(
              currentYear_aa,
              currentMonth_aa + 1,
              0
            ).getDay();
        
            // Tính số ngày của tháng trước
            const daysInPrevMonth = new Date(
              currentYear_aa,
              currentMonth_aa,
              0
            ).getDate();
        
            // Cập nhật tiêu đề tháng
            const monthNames = [
              "Tháng 1",
              "Tháng 2",
              "Tháng 3",
              "Tháng 4",
              "Tháng 5",
              "Tháng 6",
              "Tháng 7",
              "Tháng 8",
              "Tháng 9",
              "Tháng 10",
              "Tháng 11",
              "Tháng 12",
            ];
            $("#currentMonth_aa").text(`${monthNames[currentMonth_aa]}, ${currentYear_aa}`);
        
            // Xóa nội dung cũ
            $("#calendarDays").empty();
        
            // Thêm các ngày của tháng trước
            for (let i = 0; i < firstDayOfMonth; i++) {
              const prevMonthDay = daysInPrevMonth - firstDayOfMonth + i + 1;
              const prevMonth = currentMonth_aa === 0 ? 11 : currentMonth_aa - 1;
              const prevYear = currentMonth_aa === 0 ? currentYear_aa - 1 : currentYear_aa;
        
              const dayElement = createDayElement(
                prevMonthDay,
                prevMonth,
                prevYear,
                true
              );
              $("#calendarDays").append(dayElement);
            }
        
            // Thêm các ngày trong tháng hiện tại
            for (let day = 1; day <= daysInMonth; day++) {
              const dayElement = createDayElement(
                day,
                currentMonth_aa,
                currentYear_aa,
                false
              );
              $("#calendarDays").append(dayElement);
            }
        
            // Thêm các ngày của tháng sau
            const remainingDays = 42 - (firstDayOfMonth + daysInMonth); // 42 = 6 hàng x 7 cột
            for (let i = 1; i <= remainingDays; i++) {
              const nextMonth = currentMonth_aa === 11 ? 0 : currentMonth_aa + 1;
              const nextYear = currentMonth_aa === 11 ? currentYear_aa + 1 : currentYear_aa;
        
              const dayElement = createDayElement(i, nextMonth, nextYear, true);
              $("#calendarDays").append(dayElement);
            }
        
            // Thêm sự kiện click cho các ô thời gian
            $(".time-slot").on("click", function () {
              const dayElement = $(this).closest(".calendar-day");
              selectedDate_aa = dayElement.data("date");
              const timeType = $(this).data("type");
              const currentTime = $(this).text();
        
              $(`#${timeType}Time`).val(currentTime);
              $("#timeModal").show();
            });
          }
        
          function createDayElement(day, month, year, isOtherMonth) {
            const date = new Date(year, month, day);
            const dayOfWeek = date.getDay();
            const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;
            const isWorkingDay = workingDays_s_giaoviec.includes(dayOfWeek);
        
            const dayElement = $("<div>")
              .addClass("calendar-day")
              .addClass(isWeekend ? "weekend" : "")
              .addClass(isOtherMonth ? "other-month" : "")
              .addClass(!isWorkingDay ? "non-working-day" : "")
              .attr(
                "data-date",
                `${year}-${String(month + 1).padStart(2, "0")}-${String(
                  day
                ).padStart(2, "0")}`
              );
        
            dayElement.append($("<div>").addClass("day-number").text(day));
        
            if (isWorkingDay) {
              const timeSlots = [
                {
                  class: "morning",
                  time: `${workSchedule_giaoviec_s.morningStart} - ${workSchedule_giaoviec_s.lunchStart}`,
                },
                {
                  class: "lunch",
                  time: `${workSchedule_giaoviec_s.lunchStart} - ${workSchedule_giaoviec_s.afternoonStart}`,
                },
                {
                  class: "afternoon",
                  time: `${workSchedule_giaoviec_s.afternoonStart} - ${workSchedule_giaoviec_s.endTime}`,
                },
                {
                  class: "end",
                  time: workSchedule_giaoviec_s.endTime,
                },
              ];
        
              const slotsContainer = $("<div>").addClass("time-slots");
              timeSlots.forEach((slot) => {
                slotsContainer.append(
                  $("<div>")
                    .addClass("time-slot")
                    .addClass(slot.class)
                    .text(slot.time)
                    .attr("data-type", slot.class)
                );
              });
        
              dayElement.append(slotsContainer);
            } else {
              dayElement.append(
                $("<div>").addClass("non-working-text").text("Nghỉ")
              );
            }
        
            return dayElement;
          }
        
          function closeModal_a() {
            $("#timeModal").hide();
          }
        
          function saveTime() {
            if (!selectedDate_aa) return;
        
            const timeData = {
              morning: $("#morningTime").val(),
              lunch: $("#lunchTime").val(),
              afternoon: $("#afternoonTime").val(),
              end: $("#endTime").val(),
            };
        
            // Gửi yêu cầu cập nhật lên server
            $.ajax({
              url: "process.php",
              type: "POST",
              data: {
                action: "update_schedule",
                date: selectedDate_aa,
                times: timeData,
              },
              success: function (response) {
                if (response.success) {
                  updateCalendar();
                } else {
                  alert("Có lỗi xảy ra khi cập nhật thời gian");
                }
              },
            });
        
            closeModal_a();
          }
        
          // Xử lý nút tháng trước
          $("#prevMonth").click(function () {
            currentMonth_aa--;
            if (currentMonth_aa < 0) {
              currentMonth_aa = 11;
              currentYear_aa--;
            }
            updateCalendar();
          });
        
          // Xử lý nút tháng sau
          $("#nextMonth").click(function () {
            currentMonth_aa++;
            if (currentMonth_aa > 11) {
              currentMonth_aa = 0;
              currentYear_aa++;
            }
            updateCalendar();
          });
        
          // Khởi tạo lịch
          updateCalendar();
   
   
          }
        },
      });
    });
    //////////////////////////////
     $("body")
    .off("click", "button[name=tab_mini_add]")
    .on("click", "button[name=tab_mini_add]", function () {
      $(".btn_remove_giaoviec").removeClass("active");
      $("button[name=tab_phongban]").addClass("active");
      var form_data = new FormData();
      form_data.append("action", "tab_action_box_phongban");
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".thongke_g").html(info.list);
        },
      });
    });
    ///////////////////////////////
    $("body")
    .off("click", "button[name=tab_mini_add_ns]")
    .on("click", "button[name=tab_mini_add_ns]", function () {
      $(".btn_remove_giaoviec").removeClass("active");
      $("button[name=tab_phongban]").addClass("active");
      var form_data = new FormData();
      form_data.append("action", "tab_action_tgian_lamviec");
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".thongke_g .list_viec_dagiao").html(info.list);
        },
      });
    });
  ////////////////////////////////
  $("body").on("click", "button[name=tab_thongke]", function () {
    $(".thongke_g").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_thongke]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
  });

  $("body").on("click", "button[name=tab_hoatdong_capduoi]", function () {
    $(".thongke_g").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_hoatdong_capduoi]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke_hoatdong_capduoi");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
  });

  ////////////////////////////
  $("body").on("click", "button[name=tab_thongke_ns]", function () {
    $(".thongke_g").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_thongke_ns]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke_ns");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".tonghop-nhansu").html(info);
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
  });
  ///////////////////////////

  $("body").on("click", "button[name=dexuat_danhsach]", function () {
    $(".mau_dexuat").removeClass("active_success");
    $(this).addClass("active_success");
    var form_data = new FormData();
    form_data.append("action", "load_box_dexuat_danhsach");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".box_danhsach_dexuat").html(info.html);
      },
    });
  })

  ////////////////////////////
  $("body").on("click", "button[name=giaoviec]", function () {
    $("button[name=search_nhanvien_button][data-id]").hide();
    $(".giaoviec").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=giaoviec]").addClass("active");
    //////////////////////
    // selected_phongban là id sẽ hiển thị
    //themphongban-form là button ấn vào để hiển thị lên form
    //list_phongban_form là form phòng ban
    $("button[name=themphongban-form]")
      .off("button[name=themphongban-form]")
      .on("click", function () {
        $(".list_phongban_form").css("display", "block");
      });
    $("button[name=close_form_phongban]").on("click", function () {
      $(".list_phongban_form").css("display", "none");
    });
    var form_data = new FormData();
    form_data.append("action", "load_form_giaoviec_lmao");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        document.addEventListener("DOMContentLoaded", function () {
          flatpickr("#datepicker", {
            enableTime: true, // Bật chọn thời gian
            enableSeconds: true, // Bật chọn giây
            dateFormat: "H:i:s d-m-Y", // Định dạng hiển thị
            time_24hr: true, // Hiển thị 24 giờ thay vì AM/PM
          });
        });
        $(".thongke_g").html(info);
        document.addEventListener("DOMContentLoaded", function () {
          flatpickr("#datepicker", {
            enableTime: true, // Bật chọn thời gian
            enableSeconds: true, // Bật chọn giây
            dateFormat: "H:i:s d-m-Y", // Định dạng hiển thị
            time_24hr: true, // Hiển thị 24 giờ thay vì AM/PM
          });
        });
        let allEmployeeOptions = {
          nguoinhan: $("#nguoinhan_selected option").clone(),
        };

        // Xử lý khi chọn phòng ban
        $("#selected_phongban").on("change", function () {
          let selectedParentId = $(this).val(); // Lấy parent_id được chọn

          // Reset danh sách
          $("#nguoinhan_selected")
            .empty()
            .append('<option value="">Chọn người nhận</option>');
          // $("#nguoigiam_sat_selected")
          //   .empty()
          //   .append('<option value="">Chọn người giám sát</option>');

          if (selectedParentId) {
            // Lọc nhân viên có id_phongban = parent_id được chọn
            allEmployeeOptions.nguoinhan.each(function () {
              if ($(this).data("phongban") == selectedParentId) {
                $("#nguoinhan_selected").append($(this).clone());
              }
            });

            // allEmployeeOptions.giamsat.each(function () {
            //   if ($(this).data("phongban") == selectedParentId) {
            //     $("#nguoigiam_sat_selected").append($(this).clone());
            //   }
            // });
          } else {
            // Nếu không chọn phòng ban thì hiện tất cả
            $("#nguoinhan_selected").append(
              allEmployeeOptions.nguoinhan.clone()
            );
            // $("#nguoigiam_sat_selected").append(
            //   allEmployeeOptions.giamsat.clone()
            // );
          }
        });
      },
    });
  });
  $(document).on("keyup", "input[name=search_phongban]", function () {
    let searchText = $(this).val().toLowerCase(); // Lấy nội dung nhập vào và chuyển thành chữ thường

    $("button[name=add_phong_ban_form]").each(function () {
      let phongbanName = $(this).attr("data-name").toLowerCase(); // Lấy tên phòng ban từ data-name

      if (phongbanName.includes(searchText)) {
        $(this).show(); // Hiện nếu có chứa từ khóa tìm kiếm
      } else {
        $(this).hide(); // Ẩn nếu không khớp
      }
    });
  });
  $(document).on("keyup", "input[name=search_nhanvien]", function () {
    let searchText = $(this).val().toLowerCase(); // Lấy nội dung nhập vào và chuyển thành chữ thường

    $("button[name=search_nhanvien_button]").each(function () {
      let phongbanName = $(this).attr("data-name").toLowerCase(); // Lấy tên phòng ban từ data-name

      if (phongbanName.includes(searchText)) {
        $(this).show(); // Hiện nếu có chứa từ khóa tìm kiếm
      } else {
        $(this).hide(); // Ẩn nếu không khớp
      }
    });
  });
  $(document).on("click", "button[name=add_phong_ban_form]", function () {
    let id = $(this).attr("data-id");
    let id_nguoi = $("button[name=search_nhanvien_button][data-id]")
      .map(function () {
        return $(this).attr("data-phongban");
      })
      .get();
    id_nguoi.forEach(function (item, index) {
      if (item == id) {
        $(
          'button[name=search_nhanvien_button][data-phongban="' + item + '"]'
        ).show();
      }
    });
    let name_button = $(this).attr("data-name");
    $(this).hide();
    $("#selected_phongban").append(`
        <div class="selected_phongban_dathem" data-id="${id}">
            <h6>${name_button}</h6>
            <button name="xoa_dulieu_phongban_dachon" data-id="${id}">X</button>
        </div>
    `);
  });
  $(document).on(
    "click",
    "button[name=xoa_dulieu_phongban_dachon]",
    function () {
      let id = $(this).attr("data-id");
      $(".selected_nguoinhan_dathem")
        .filter(`[data-phongban='${id}']`)
        .remove();
      $(this).closest(".selected_phongban_dathem").remove();

      let id_nguoi = $("button[name=search_nhanvien_button][data-id]")
        .map(function () {
          return $(this).attr("data-phongban");
        })
        .get();
      id_nguoi.forEach(function (item, index) {
        if (item == id) {
          $(
            'button[name=search_nhanvien_button][data-phongban="' + item + '"]'
          ).hide();
        }
      });
      $("button.value-id-" + id).show();
    }
  );
  /////////////////////////////////////
  let currentTarget = ""; // Biến lưu phần hiện tại đang mở

  // Khi mở danh sách từ nút "Thêm Người Nhận"
  $("button[name=themnguoinhan]").on("click", function () {
    currentTarget = "nguoinhan";
    $(".list_danhsachnhansu_form").css("display", "block");
  });

  // Khi mở danh sách từ nút "Thêm Người Giám Sát"
  $("button[name=nguoi_giamsat]").on("click", function () {
    currentTarget = "nguoigiamsat";
    $(".list_danhsachnhansu_form").css("display", "block");
  });

  // Đóng danh sách
  $("button[name=close_add_nhanvien]").on("click", function () {
    $(".list_danhsachnhansu_form").css("display", "none");
  });

  // Xử lý chọn nhân viên theo phần đang mở
  $(document).on("click", "button[name=search_nhanvien_button]", function () {
    let id_nv = $(this).attr("data-id");
    let name_button_nv = $(this).attr("data-name");
    let phongban_id = $(this).attr("data-phongban");
    $(this).hide();

    if (currentTarget === "nguoinhan") {
      $("#nguoinhan_selected").append(`
            <div class="selected_nguoinhan_dathem" data-id="${id_nv}" data-phongban="${phongban_id}">
                <h6>${name_button_nv}</h6>
                <button name="xoa_dulieu_nv_dachon" data-id="${id_nv}" data-phongban="${phongban_id}">X</button>
            </div>
        `);
    } else if (currentTarget === "nguoigiamsat") {
      $("#nguoigiam_sat_selected").append(`
            <div class="selected_giamsat_dathem" data-id="${id_nv}" data-phongban="${phongban_id}">
                <h6>${name_button_nv}</h6>
                <button name="xoa_dulieu_giamsat_dachon" data-id="${id_nv}" data-phongban="${phongban_id}">X</button>
            </div>
        `);
    }
  });
  $(document).on("click", "button[name=xoa_dulieu_nv_dachon]", function () {
    let id = $(this).attr("data-id");
    $(this).closest(".selected_nguoinhan_dathem").remove();
    $("button.value-id_nv-" + id).show();
  });
  $(document).on(
    "click",
    "button[name=xoa_dulieu_giamsat_dachon]",
    function () {
      let id = $(this).attr("data-id");
      $(this).closest(".selected_giamsat_dathem").remove();
      $("button.value-id_nv-" + id).show();
    }
  );

  ////////////////////////
  $(".form_box_chonsep").hide();

  ///////////////////////////////////
  $("button[name=themphongban]").on("click", function () {
    $(".themphongban").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=themphongban]").addClass("active");
  });
  ///////////////////////////////////
  $("button[name=tab_daotao]").on("click", function () {
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_daotao]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_daotao");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });
  $("body").on("click", "button[name=quay_lai_cho_congviec]", function () {
    $(".thongke_g").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_thongke]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
  });
  $("body").on("click", "button[name=danhsachcongviec_cuaban_a]", function () {
    var thongtin_ddddd = $(".list_viec_dagiao").html();
    $(".scroll_hidden_fixxx").css("display", "none");
    id_nguoidung = $(this).attr("id_nguoidung");
    var form_data = new FormData();
    form_data.append("action", "load_danhsach_congviec_cuaadmin");
    form_data.append("id_nguoidung", id_nguoidung);
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".bruh_l_a21").text("(0)");
        $(".tong_congviec_kk").text(info.total);
        $(".miss_deadline_kk").text(info.missdeadline);
        $(".tuchoi_kk").text(info.tuchoi);
        $(".giahan_kk").text(info.giahan);
        $(".dangtienhanh_kk").text(info.dangtienhanh);
        $(".dahoanthanh_kk").text(info.dahoanthanh);
        $(".chopheduyet_kk").text(info.chopheduyet);
        $(".chuatienhanh_kk").text(info.chuatienhanh);
       
        function startCountdown(button) {
          let text = $(button).text();
          let match = text.match(/Còn\s* (\d+) phút/); // Lấy số phút trong dấu nháy đơn

          if (!match) return; // Nếu không tìm thấy số, thoát luôn

          let timeLeft = parseInt(match[1]) * 60; // Chuyển đổi phút thành giây

          function updateButton() {
            if (timeLeft > 0) {
              let minutes = Math.floor(timeLeft / 60);
              let seconds = timeLeft % 60;
              $(button).text(
                `Còn ${minutes}:${seconds < 10 ? "0" : ""}${seconds} phút`
              );
              timeLeft--; // Giảm 1 giây
              setTimeout(updateButton, 1000);
            } else {
              $(button).text("Đã hết hạn").css("color", "red");
            }
          }

          updateButton();
        }
        $("body")
          .find("button[name=congviec_nv_d]")
          .each(function () {
            startCountdown(this);
          });
        $(".scroll_hidden_fixxx").css("display", "none");
        $(".thongke_g .list_viec_dagiao").html(info.list);
        $("body").on(
          "click",
          "button[name=close_chitiet_congviec]",
          function () {
            $(".xemchi_tiet_congviec").hide();
          }
        );
        $("body").on(
          "click",
          "button[name=close_congviec_can_xac_nhan_cuasep]",
          function () {
            $(".scroll_hidden_fixxx").hide();
          }
        );
        $("body").on(
          "click",
          "button[name=xac_nhan_congviec_duocgiao]",
          function () {
            id = $(this).attr("data-id");
            var form_data = new FormData();
            form_data.append("id", id);
            form_data.append("action", "xac_nhan_congviec_duocgiao");
            $(".load_overlay").show();
            $(".load_process").fadeIn();
            $.ajax({
              url: "/process.php",
              type: "post",
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              success: function (kq) {
                $('.box_popup_trang_nhansu').remove();
                if (isJson(kq) == true) {
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
                        hd: "thongbao_nhanviec",
                      };
                      var info_chat = JSON.stringify(dulieu);
                      socket.emit("user_send_hoatdong", info_chat);
                    }
                  }, 3000);
                } else {
                  setTimeout(function () {
                    $(".load_note").html(
                      "Gặp lỗi trong lúc đăng! Vui lòng thử lại"
                    );
                  }, 1000);
                  setTimeout(function () {
                    $(".load_process").hide();
                    $(".load_note").html("Hệ thống đang xử lý");
                    $(".load_overlay").hide();
                  }, 3000);
                }
              },
            });

            /////////////////////////
          }
        );
      },
    });
  });
  $("body").on(
    "click",
    ".box_xingiahan .box_main_giahan .cl_giahan_box button",
    function () {
      $(".box_xingiahan").hide();
    }
  );
  var form_html_list_viec = $(".thongke_g .list_viec_dagiao").html();

  $("body").on("click", "button[name=dexuat_cuatoi_sep]", function () {
    $(".mau_dexuat").removeClass("active_success");
    $(this).addClass("active_success");
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "load_dexuat_cuatoi",
      },
      success: function (response) {
        try {
          const data = JSON.parse(response);
          $(".box_danhsach_dexuat").html(data.html);
        } catch (e) {
          console.error("Lỗi parse JSON:", e);
          alert("Có lỗi xảy ra khi xử lý dữ liệu");
        }
      },
    });
  });

  $("body").on("click", "button[name=them_de_xuat_chosep_a]", function () {
    $(".mau_dexuat").removeClass("active_success");
    $(this).addClass("active_success");
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "load_form_dexuat_a",
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g .list_viec_dagiao").html(info);
        // $("body").on("click", "button[name=chonsep_thoi]", function () {
        //   id_sep = $(this).attr("data-id");
        //   name_sep = $(this).attr("data-name");
        //   $("#sepnhan_selected").html(
        //     "<div class='sepnhan_selected_c value_duocchon_dexuat_sep39' data-id=" +
        //       id_sep +
        //       " data-name=" +
        //       name_sep +
        //       ">" +
        //       name_sep +
        //       "<button class='remove_dexuat_sep' data-id=" +
        //       id_sep +
        //       ">X</button></div>"
        //   );
        // });
      },
    });
  });
  $("body").on("click", "button[name=quay_trolai_formdexuat]", function () {
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_dexuat");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });

  $("body").on("click", "button[name=quay_trolai_formdexuat_ns]", function () {
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_dexuat_ns");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });
  
  $("body").on("click", "button[name=chon_nguoidexuat]", function () {
    $(".form_box_chonsep").show();
    if ($('.sepnhan_select').length <= 0) {
      $('.form_select_sep').html("Không có dữ liệu");
    }
  });
  $("body").on("click", "button[name=close_form_x]", function () {
    $(".form_box_chonsep").hide();
  });

  $("body").on(
    "change",
    ".form_search_danhsachcongviecdagiao select, .form_search_danhsachcongviecdagiao input",
    function () {
      phongban = $("select[name=filter_phongban_giaoviec]").val();
      nhanvien = $("select[name=filter_nhanvien_giaoviec]").val();
      trangthai_congviec = $("select[name=trangthai_congviec_filter]").val();
      start_date = $("input[name=start_date]").val();
      end_date = $("input[name=end_date]").val();
      key = $("input[name=form_seach_giaoviec_list]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_giaoviec");
      form_data.append("phongban", phongban);
      form_data.append("nhanvien", nhanvien);
      form_data.append("trangthai_congviec", trangthai_congviec);
      form_data.append("start_date", start_date);
      form_data.append("end_date", end_date);
      form_data.append("key", key);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".box_danhsachnhansu1").html(info);
          $("body")
            .off("click", ".li_phantrang")
            .on("click", ".li_phantrang", function () {
              page = $(this).attr("page");
              var form_data = new FormData();
              form_data.append("action", "aa_load_phantrang_giaoviec");
              form_data.append("page", page);
              form_data.append("phongban", phongban);
              form_data.append("nhanvien", nhanvien);
              form_data.append("trangthai_congviec", trangthai_congviec);
              form_data.append("start_date", start_date);
              form_data.append("end_date", end_date);
              form_data.append("key", key);
              $.ajax({
                url: "/process.php",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                  var info = JSON.parse(kq);
                  $(".box_danhsachnhansu1").html(info);
                },
              });
            });
        },
      });
    }
  );

  $("body").on(
    "change",
    ".form_search_danhsachcongviecdagiao_hoatdong_capduoi select, .form_search_danhsachcongviecdagiao_hoatdong_capduoi input",
    function () {
      phongban = $("select[name=filter_phongban_giaoviec]").val();
      nhanvien = $("select[name=filter_nhanvien_giaoviec]").val();
      trangthai_congviec = $("select[name=trangthai_congviec_filter]").val();
      start_date = $("input[name=start_date]").val();
      end_date = $("input[name=end_date]").val();
      key = $("input[name=form_seach_giaoviec_list]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_giaoviec_hoatdong_capduoi");
      form_data.append("phongban", phongban);
      form_data.append("nhanvien", nhanvien);
      form_data.append("trangthai_congviec", trangthai_congviec);
      form_data.append("start_date", start_date);
      form_data.append("end_date", end_date);
      form_data.append("key", key);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".box_danhsachnhansu1").html(info);
          $("body")
            .off("click", ".li_phantrang")
            .on("click", ".li_phantrang", function () {
              page = $(this).attr("page");
              var form_data = new FormData();
              form_data.append("action", "aa_load_phantrang_giaoviec_hoatdong_capduoi");
              form_data.append("page", page);
              form_data.append("phongban", phongban);
              form_data.append("nhanvien", nhanvien);
              form_data.append("trangthai_congviec", trangthai_congviec);
              form_data.append("start_date", start_date);
              form_data.append("end_date", end_date);
              form_data.append("key", key);
              $.ajax({
                url: "/process.php",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                  var info = JSON.parse(kq);
                  $(".box_danhsachnhansu1").html(info);
                },
              });
            });
        },
      });
    }
  );
  
  $("body").on(
    "change",
    ".tonghop-nhansu .form_search-cv_ns .search_tieude select[name=filter_option_trangthai], .tonghop-nhansu .form_search-cv_ns .search_tieude input[name=filter_date_time_nhansu]",
    function () {
      trangthai = $("select[name=filter_option_trangthai]").val();
      date_time = $("input[name=filter_date_time_nhansu]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_nhansu");
      form_data.append("trangthai", trangthai);
      form_data.append("date_time", date_time);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".congviec_cuanhansu_a .table_nhansu_xemviec tbody").html(info);
          $("body")
            .off("click", ".li_phantrang")
            .on("click", ".li_phantrang", function () {
              page = $(this).attr("page");
              var form_data = new FormData();
              form_data.append("action", "aa_load_phantrang_nhansu");
              form_data.append("trangthai", trangthai);
              form_data.append("date_time", date_time);
              //    $.ajax({
              //        url: '/process.php',
              //        type: 'POST',
              //        cache: false,
              //        contentType: false,
              //        processData: false,
              //        data: form_data,
              //        success: function(kq) {
              //         var info = JSON.parse(kq);
              //         $('.box_danhsachnhansu1').html(info);
              //     },
              //    })
            });
        },
      });
    }
  );
  ////////////////////////// kkk
  $("body").on("keyup", "input[name=filter_search_tieude]", function () {
    key = $("input[name=filter_search_tieude]").val();
    var form_data = new FormData();
    form_data.append("action", "aa_load_phantrang_nhansu");
    form_data.append("key", key);
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".congviec_cuanhansu_a .table_nhansu_xemviec tbody").html(info);
        $("body")
          .off("click", ".li_phantrang")
          .on("click", ".li_phantrang", function () {
            page = $(this).attr("page");
            var form_data = new FormData();
            form_data.append("action", "aa_load_phantrang_nhansu");
            form_data.append("key", key);
            //    $.ajax({
            //        url: '/process.php',
            //        type: 'POST',
            //        cache: false,
            //        contentType: false,
            //        processData: false,
            //        data: form_data,
            //        success: function(kq) {
            //         var info = JSON.parse(kq);
            //         $('.box_danhsachnhansu1').html(info);
            //     },
            //    })
          });
      },
    });
  });
  //sửa sáng ngày 24/3
  $("body").on("keyup", "input[name=form_seach_giaoviec_list]", function () {
    phongban = $("select[name=filter_phongban_giaoviec]").val();
    nhanvien = $("select[name=filter_nhanvien_giaoviec]").val();
    trangthai_congviec = $("select[name=trangthai_congviec_filter]").val();
    start_date = $("input[name=start_date]").val();
    end_date = $("input[name=end_date]").val();
    key = $("input[name=form_seach_giaoviec_list]").val();
    var form_data = new FormData();
    form_data.append("action", "aa_load_phantrang_giaoviec");
    form_data.append("phongban", phongban);
    form_data.append("nhanvien", nhanvien);
    form_data.append("trangthai_congviec", trangthai_congviec);
    form_data.append("start_date", start_date);
    form_data.append("end_date", end_date);
    form_data.append("key", key);
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".box_danhsachnhansu1").html(info);
        $("body")
          .off("click", ".li_phantrang")
          .on("click", ".li_phantrang", function () {
            page = $(this).attr("page");
            var form_data = new FormData();
            form_data.append("action", "aa_load_phantrang_giaoviec");
            form_data.append("page", page);
            form_data.append("phongban", phongban);
            form_data.append("nhanvien", nhanvien);
            form_data.append("trangthai_congviec", trangthai_congviec);
            form_data.append("start_date", start_date);
            form_data.append("end_date", end_date);
            form_data.append("key", key);
            $.ajax({
              url: "/process.php",
              type: "POST",
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              success: function (kq) {
                var info = JSON.parse(kq);
                $(".box_danhsachnhansu1").html(info);
              },
            });
          });
      },
    });
  });

  //sửa sáng ngày 24/3
  const scrollPosition = localStorage.getItem("scrollPosition");
  if (scrollPosition) {
    $(window).scrollTop(scrollPosition);
  }

 $('body').on("change", "select[name=filter_phongban_giaoviec]", function () {
  var phongban_id = $(this).val();

  // Ẩn tất cả nhân viên
  $("select[name=filter_nhanvien_giaoviec] option").hide();

  // Hiển thị nhân viên thuộc phòng ban đã chọn
  $(
    'select[name=filter_nhanvien_giaoviec] option[data-phongban="' + phongban_id + '"]'
  ).show();

  // Reset về "Chọn nhân sự"
  $("select[name=filter_nhanvien_giaoviec]").val("");
});

$('body').on("change", 'select[name="phongban_nhan[]"]', function () {
  var selectedPhongban = $(this).val();

  // Tìm select nhân viên trong cùng nhóm (form_group kế tiếp)
  var $wrap = $(this).closest('.form_group').nextAll('.form_group').first();
  var $selectNhanVien = $wrap.find('select[name="id_nhanvien[]"]');

  // Ẩn tất cả nhân viên
  $selectNhanVien.find('option').hide();
  $selectNhanVien.find('option[value=""]').show();
  // Hiện nhân viên thuộc phòng ban đã chọn
  $selectNhanVien.find('option[data-phongban="' + selectedPhongban + '"]').show();

  // Reset lại lựa chọn nhân viên
  $selectNhanVien.val('').trigger('change');
});

  $(".form_box_chonsep").hide();

  $("body").off("click", "button[name=add_dexuatmoi]").on("click", "button[name=add_dexuatmoi]", function () {
    $(".mau_dexuat").removeClass("active_success");
    $(this).addClass("active_success");
    localStorage.setItem("pre", $(".add_form_dexuat_a").html());
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "load_form_dexuat_a",
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".add_form_dexuat_a").html(info);
      },
    });
  });
  $("body").on("click", "button[name=quay_trolai_formdexuat]", function () {
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_dexuat");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });

  $("body").on("click", "button[name=chon_nguoidexuat]", function () {
    $(".form_box_chonsep").show();
    if ($('.sepnhan_select').length <= 0) {
      $('.form_select_sep').html("Không có dữ liệu");
    }
  });
  $("body").off("click", "button[name=chonsep_thoi]")
  .on("click", "button[name=chonsep_thoi]", function () {
    $(this).hide();
    let id = $(this).attr("data-id");
    let name = $(this).attr("data-name");

    // Thêm người được chọn vào danh sách đã chọn
    $("#sepnhan_selected").append(
      '<div class="sepnhan_selected_c value_duocchon_dexuat_sep' +
        id +
        '" data-id="' +
        id +
        '" data-name="' +
        name +
        '">' +
        name +
        ' <button class="remove_dexuat_sep" data-id="' +
        id +
        '">X</button></div>'
    );

    // Xóa thông báo cũ nếu có
    $(".form_select_sep .no-data-message").remove();

    // Kiểm tra tất cả button trong .sepnhan_select có đều đang bị ẩn không
    let allButtonsHidden = true;
    $(".form_select_sep .sepnhan_select button[name=chonsep_thoi]").each(function () {
      if ($(this).css("display") !== "none") {
        allButtonsHidden = false;
        return false; // Dừng vòng lặp nếu thấy ít nhất 1 cái đang hiển thị
      }
    });

    // Nếu tất cả button đều bị ẩn thì thêm thông báo
    if (allButtonsHidden) {
      $(".form_select_sep").append(
        '<div class="no-data-message" style="padding:10px; color:#888;">Không có dữ liệu hiển thị</div>'
      );
    }
  });

  $("body").on("click", "button.remove_dexuat_sep", function () {
    let id = $(this).attr("data-id");
    $(".value_duocchon_dexuat_sep" + id).remove();
    $(".value_id_sep" + id).show();
    $(".no-data-message").hide();
  });
  $("body").on("click", "button[name=close_form_x]", function () {
    $(".form_box_chonsep").hide();
  });
  $("body").on(
    "click",
    "button[name=xemchitiet_dexuat_cuanhanvien]",
    function () {
      id = $(this).attr("data-id");
      localStorage.setItem("prea", $(".add_form_dexuat_a").html());
      var form_data = new FormData();
      form_data.append("action", "xemchitiet_dexuat");
      form_data.append("id", id);
      $.ajax({
        url: "/process.php",
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".box_danhsach_dexuat").html(info);
        },
      });
    }
  );
  $("body").on("click", "button[name=quay_tro_lai_dexuat]", function () {
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_dexuat");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });

  $("button[name=tab_nhansu]").on("click", function () {
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_nhansu]").addClass("active");
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_nhansu");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  });

  $("body").on("click", "#box_pop_them_nhan_su", function () {
    // console.log("1234");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: {
        action: "box_pop_them_nhan_su",
      },
      dataType: "json",
      success: function (response) {
        if (response.ok == 1) {
          $('#modal_them_nhan_su select[name="id_phong_ban"]').html(
            '<option value="">Chọn phòng ban</option>' +
              response.option_phongban
          );
          $('#modal_them_nhan_su select[name="vai_tro"]')
            .html('<option value="">Chọn vai trò</option>')
            .prop("disabled", true);
          $("#modal_them_nhan_su").show();
        }
      },
    });
  });

  $("body").on("click", "#closeModal", function () {
    $("#modal_them_nhan_su").hide();
    $("#modal_sua_nhan_su").hide();
  });

  $("body").on("click", "#them_nhan_su", function () {
    var form_data = new FormData();
    form_data.append("action", "them_nhan_su");
    form_data.append("ten_dang_nhap", $("input[name=ten_dang_nhap]").val());
    form_data.append("mat_khau", $("input[name=mat_khau]").val());
    form_data.append("ho_ten", $("input[name=ho_ten]").val());
    form_data.append("email", $("input[name=email]").val());
    form_data.append("so_dien_thoai", $("input[name=so_dien_thoai]").val());
    form_data.append("dia_chi", $("input[name=dia_chi]").val());
    form_data.append("chuc_vu", $("input[name=chuc_vu]").val());
    form_data.append("id_phong_ban", $("select[name=id_phong_ban]").val());
    // form_data.append("level", $("select[name=level]").val());
    form_data.append("vai_tro", $("select[name=vai_tro]").val());

    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      processData: false,
      contentType: false,
      success: function (response) {
        try {
          var info = JSON.parse(response);
          if (info.ok == 1) {
            alert(info.thongbao);
            $("#modal_them_nhan_su").hide();
            window.location.reload();
          } else {
            alert(info.thongbao);
            // Focus vào trường đầu tiên bị lỗi
            if (info.missing_fields) {
              for (var field in info.missing_fields) {
                if (info.missing_fields[field]) {
                  $("[name=" + field + "]").focus();
                  break;
                }
              }
            }
          }
        } catch (e) {
          console.error("JSON Parse Error:", e);
          alert("Có lỗi xảy ra, vui lòng thử lại sau");
        }
      },
      error: function (xhr, status, error) {
        console.error("Ajax Error:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại sau");
      },
    });
  });

  function updateRoleOptions(phongBanId, selectedRole = "") {
    var roleSelect = $('select[name="vai_tro"]');
    roleSelect.empty();

    if (phongBanId == 37) {
      // ID của phòng Giám đốc
      roleSelect.append('<option value="all">Giám đốc</option>');
      roleSelect.append('<option value="all">Tổng giám đốc</option>');
    } else {
      roleSelect.append('<option value="all">Quản lý</option>');
      roleSelect.append('<option value="nhan_vien">Nhân viên</option>');
    }

    if (selectedRole) {
      roleSelect.val(selectedRole);
    }
  }

  $(document).on("change", 'select[name="id_phong_ban"]', function () {
    // console.log($(this).val());
    $('#modal_them_nhan_su select[name="vai_tro"]').prop("disabled", false);
    updateRoleOptions($(this).val());
  });

  $("body").on("click", "#btn-edit-nhansu", function () {
    var id_nhansu = $(this).attr("id_nhansu");
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: {
        action: "box_pop_sua_nhan_su",
        id_nhansu: id_nhansu,
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          var data = response.html;
          // Cập nhật các giá trị form
          $('#modal_sua_nhan_su input[name="ten_dang_nhap"]').val(
            data.username
          );
          $('#modal_sua_nhan_su input[name="id_nhansu"]').val(data.id);

          $('#modal_sua_nhan_su input[name="ho_ten"]').val(data.name);
          $('#modal_sua_nhan_su input[name="email"]').val(data.email);
          $('#modal_sua_nhan_su input[name="so_dien_thoai"]').val(data.mobile);
          $('#modal_sua_nhan_su input[name="dia_chi"]').val(data.address);
          $('#modal_sua_nhan_su input[name="chuc_vu"]').val(data.chuc_vu);
          $('#modal_sua_nhan_su select[name="id_phong_ban"]').html(
            data.list_phongban
          );

          // Cập nhật vai trò dựa trên phòng ban
          updateRoleOptions(data.id_phongban, data.role);

          $("#modal_sua_nhan_su").append(
            '<input type="hidden" name="id" value="' + data.id + '">'
          );
          $("#modal_sua_nhan_su").show();
        }
      },
    });
  });

  $("body").on("click", "#sua_nhan_su", function () {
    var form_data = new FormData();
    id_nhansu = $("input[name=id_nhansu]").val();
    ho_ten = $("input[name=ho_ten]").val();
    email = $("input[name=email]").val();
    form_data.append("action", "sua_nhan_su");
    form_data.append("id_nhansu", $("input[name=id_nhansu]").val());
    form_data.append("ten_dang_nhap", $("input[name=ten_dang_nhap]").val());
    form_data.append("ho_ten", $("input[name=ho_ten]").val());
    form_data.append("email", $("input[name=email]").val());
    form_data.append("so_dien_thoai", $("input[name=so_dien_thoai]").val());
    form_data.append("dia_chi", $("input[name=dia_chi]").val());
    form_data.append("chuc_vu", $("input[name=chuc_vu]").val());
    form_data.append("id_phong_ban", $("select[name=id_phong_ban]").val());
    // form_data.append("level", $("select[name=level]").val());
    form_data.append("vai_tro", $("select[name=vai_tro]").val());

    console.log(form_data);
    // $.ajax({
    //   url: "/process.php",
    //   type: "POST",
    //   data: form_data,
    //   processData: false,
    //   contentType: false,
    //   success: function (response) {
    //     try {
    //       var info = JSON.parse(response);
    //       if (info.ok == 1) {
    //         alert(info.thongbao);
    //         $("#modal_sua_nhan_su").hide();
    //         // window.location.reload();
    //       } else {
    //         alert(info.thongbao);
    //         // Focus vào trường đầu tiên bị lỗi
    //         if (info.missing_fields) {
    //           for (var field in info.missing_fields) {
    //             if (info.missing_fields[field]) {
    //               $("[name=" + field + "]").focus();
    //               break;
    //             }
    //           }
    //         }
    //       }
    //     } catch (e) {
    //       console.error("JSON Parse Error:", e);
    //       alert("Có lỗi xảy ra, vui lòng thử lại sau");
    //     }
    //   },
    //   error: function (xhr, status, error) {
    //     console.error("Ajax Error:", error);
    //     alert("Có lỗi xảy ra, vui lòng thử lại sau");
    //   },
    // });

  });
  $('body').off('click','button[name=xemchitiet_nhansu_do]').on('click','button[name=xemchitiet_nhansu_do]',function(){
    bruh_nhansuuukakak = $('.bruh_nhansuuukakak').html();
    id = $(this).data('id');
    var form_data=new FormData();
    form_data.append("action","xemchitiet_nhansu_a");
    form_data.append('id',id)
    $.ajax({
    url: "/process.php",
    type: "post",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (kq) {
      var info = JSON.parse(kq);
      $(".bruh_nhansuuukakak").html(info.list);
      $("input[name='loai_hopdong'][value='" + info.check + "']").prop("checked", true);
      $('body').on('click','#addEmployeeModal .close',function(){
        $('.bruh_nhansuuukakak').html(bruh_nhansuuukakak);
      })
    },
  });
  })
  $('body').on('click','#phantrang_nhansu_list .li_phantrang',function(){
    page = $(this).attr("page");
    form_data = new FormData();
    form_data.append("action","tab_action_box_nhansu");
    form_data.append("page",page); 
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
      },
    });
  })
  $('body').on('click',".click_search_nv",function(){
      key = $("input[name=search_nhanvien_list]").val();
      form_data = new FormData();
    form_data.append("action","tab_action_box_nhansu");
    form_data.append("key",key); 
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $('body').on('click','#phantrang_nhansu_list .li_phantrang',function(){
          page = $(this).attr("page");
          form_data = new FormData();
          form_data.append("action","tab_action_box_nhansu");
          form_data.append("page",page); 
          form_data.append("key",key);
          $.ajax({
            url: "/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
              var info = JSON.parse(kq);
              $(".thongke_g").html(info);
            },
          });
        })
      },
    });
  })
  ///////////////////////
  $('body').on('keydown',"input[name=search_nhanvien_list]",function(e){
    if (e.key === 'Enter') {
      key = $("input[name=search_nhanvien_list]").val();
    form_data = new FormData();
  form_data.append("action","tab_action_box_nhansu");
  form_data.append("key",key); 
  $.ajax({
    url: "/process.php",
    type: "post",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (kq) {
      var info = JSON.parse(kq);
      $(".thongke_g").html(info);
      $('body').on('click','#phantrang_nhansu_list .li_phantrang',function(){
        page = $(this).attr("page");
        form_data = new FormData();
        form_data.append("action","tab_action_box_nhansu");
        form_data.append("page",page); 
        form_data.append("key",key);
        $.ajax({
          url: "/process.php",
          type: "post",
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          success: function (kq) {
            var info = JSON.parse(kq);
            $(".thongke_g").html(info);
          },
        });
      })
    },
  });
    }
})


  /////////////// setting thời gian làm việc
  

  $('body').on('click','button[name=tab_mini_setting_time]',function(){
    var form_data = new FormData();
    form_data.append("action","tab_action_tgian_lamviec");
    $.ajax({
        url: '/process.php',
        type: 'POST',
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(kq){
          var info = JSON.parse(kq);
          $('.thongke_g .list_viec_dagiao .container112').html(info);
         
        }
      })
})

$('body').on('click','button[name=save_tgian_lamviec]',function(){
    time_start_morning = $("input[name=time_start_morning]").val();
    time_end_morning = $("input[name=time_end_morning]").val();
    time_start_afternoon = $('input[name=time_start_afternoon]').val();
    time_end_afternoon = $('input[name=time_end_afternoon]').val();
    ////////////////////////////////
    let weeks = [];
    $("input[name='weeks[]']:checked").each(function() {
        weeks.push($(this).val());
    });
    var form_data = new FormData();
    form_data.append("action","add_time_tgian_lamviec");
    form_data.append("time_start_morning",time_start_morning);
    form_data.append("time_end_morning",time_end_morning);
    form_data.append("time_start_afternoon",time_start_afternoon);
    form_data.append("time_end_afternoon",time_end_afternoon);
    form_data.append("weeks",weeks);
    $(".load_overlay").show();
   $(".load_process").fadeIn();
   $.ajax({
     url: "/process.php",
     type: "post",
     cache: false,
     contentType: false,
     processData: false,
     data: form_data,
     success: function (kq) {
       if (isJson(kq) == true) {
         var info = JSON.parse(kq);
         setTimeout(function () {
           $(".load_note").html(info.thongbao);
         }, 1000);
         setTimeout(function () {
           $(".load_process").hide();
           $(".load_note").html("Hệ thống đang xử lý");
           $(".load_overlay").hide();
               var dulieu = {
                'hd':'thongbao_nhanviec',
              };
              var info_chat = JSON.stringify(dulieu);
              socket.emit('user_send_hoatdong',info_chat);
         }, 3000);
       } else {
         setTimeout(function () {
           $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
         }, 1000);
         setTimeout(function () {
           $(".load_process").hide();
           $(".load_note").html("Hệ thống đang xử lý");
           $(".load_overlay").hide();
         }, 3000);
       }
     },
   });
    
})
/////////////////////////// setting thời gian làm việc


$('body').on('click','button[name=tab_mini_setting_time]',function(){
  var form_data = new FormData();
  form_data.append("action","tab_action_tgian_lamviec");
  $.ajax({
      url: '/process.php',
      type: 'POST',
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(kq){
        var info = JSON.parse(kq);
        $('.thongke_g .list_viec_dagiao .container112').html(info);
       
      }
    })
})

$('body').on('click','button[name=save_tgian_lamviec]',function(){
  time_start_morning = $("input[name=time_start_morning]").val();
  time_end_morning = $("input[name=time_end_morning]").val();
  time_start_afternoon = $('input[name=time_start_afternoon]').val();
  time_end_afternoon = $('input[name=time_end_afternoon]').val();
  ////////////////////////////////
  let weeks = [];
  $("input[name='weeks[]']:checked").each(function() {
      weeks.push($(this).val());
  });
  var form_data = new FormData();
  form_data.append("action","add_time_tgian_lamviec");
  form_data.append("time_start_morning",time_start_morning);
  form_data.append("time_end_morning",time_end_morning);
  form_data.append("time_start_afternoon",time_start_afternoon);
  form_data.append("time_end_afternoon",time_end_afternoon);
  form_data.append("weeks",weeks);
  $(".load_overlay").show();
 $(".load_process").fadeIn();
 $.ajax({
   url: "/process.php",
   type: "post",
   cache: false,
   contentType: false,
   processData: false,
   data: form_data,
   success: function (kq) {
     if (isJson(kq) == true) {
       var info = JSON.parse(kq);
       setTimeout(function () {
         $(".load_note").html(info.thongbao);
       }, 1000);
       setTimeout(function () {
         $(".load_process").hide();
         $(".load_note").html("Hệ thống đang xử lý");
         $(".load_overlay").hide();
             var dulieu = {
              'hd':'thongbao_nhanviec',
            };
            var info_chat = JSON.stringify(dulieu);
            socket.emit('user_send_hoatdong',info_chat);
       }, 3000);
     } else {
       setTimeout(function () {
         $(".load_note").html("Gặp lỗi trong lúc đăng! Vui lòng thử lại");
       }, 1000);
       setTimeout(function () {
         $(".load_process").hide();
         $(".load_note").html("Hệ thống đang xử lý");
         $(".load_overlay").hide();
       }, 3000);
     }
   },
 });
  
})

$("body")
    .off("click", "button[name=tab_mini_add_ns]")
    .on("click", "button[name=tab_mini_add_ns]", function () {
      $(".btn_remove_giaoviec").removeClass("active");
      $("button[name=tab_phongban]").addClass("active");
      var form_data = new FormData();
      form_data.append("action", "tab_action_tgian_lamviec");
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".thongke_g .list_viec_dagiao").html(info.list);
        },
      });
    });


    $('body').on('keydown',"input[name=search_nhanvien_list]",function(e){
      if (e.key === 'Enter') {
        key = $("input[name=search_nhanvien_list]").val();
      form_data = new FormData();
    form_data.append("action","tab_action_box_nhansu");
    form_data.append("key",key); 
    $.ajax({
      url: "/process.php",
      type: "post",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
        $('body').on('click','#phantrang_nhansu_list .li_phantrang',function(){
          page = $(this).attr("page");
          form_data = new FormData();
          form_data.append("action","tab_action_box_nhansu");
          form_data.append("page",page); 
          form_data.append("key",key);
          $.ajax({
            url: "/process.php",
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
              var info = JSON.parse(kq);
              $(".thongke_g").html(info);
            },
          });
        })
      },
    });
      }
  })

  
  $('body').on('click','button[name=tab_mini_setting_time_ns]',function(){
    var form_data = new FormData();
    form_data.append("action","tab_action_box_phongban");
    $.ajax({
        url: '/process.php',
        type: 'POST',
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(kq){
          var info = JSON.parse(kq);
          $('.thongke_g').html(info.list);
         /////////////////////////////
          
          currentDate_aa_n_b_ff = new Date();
          currentMonth_aa = currentDate_aa_n_b_ff.getMonth();
          currentYear_aa = currentDate_aa_n_b_ff.getFullYear();
          selectedDate_aa = null;
       
         // Dữ liệu mẫu từ database (sẽ được thay thế bằng dữ liệu thực tế)
         const workingDays_s_giaoviec = info.tuan; // Thứ 2 đến thứ 6
         const workSchedule_giaoviec_s = {
           morningStart: info.time_morning,
           lunchStart: info.time_end_morning,
           afternoonStart: info.time_afternoon,
           endTime: info.time_end_afternoon,
         };
       
         function updateCalendar() {
           const daysInMonth = new Date(
             currentYear_aa,
             currentMonth_aa + 1,
             0
           ).getDate();
           const firstDayOfMonth = new Date(currentYear_aa, currentMonth_aa, 1).getDay();
           const lastDayOfMonth = new Date(
             currentYear_aa,
             currentMonth_aa + 1,
             0
           ).getDay();
       
           // Tính số ngày của tháng trước
           const daysInPrevMonth = new Date(
             currentYear_aa,
             currentMonth_aa,
             0
           ).getDate();
       
           // Cập nhật tiêu đề tháng
           const monthNames = [
             "Tháng 1",
             "Tháng 2",
             "Tháng 3",
             "Tháng 4",
             "Tháng 5",
             "Tháng 6",
             "Tháng 7",
             "Tháng 8",
             "Tháng 9",
             "Tháng 10",
             "Tháng 11",
             "Tháng 12",
           ];
           $("#currentMonth_aa").text(`${monthNames[currentMonth_aa]}, ${currentYear_aa}`);
       
           // Xóa nội dung cũ
           $("#calendarDays").empty();
       
           // Thêm các ngày của tháng trước
           for (let i = 0; i < firstDayOfMonth; i++) {
             const prevMonthDay = daysInPrevMonth - firstDayOfMonth + i + 1;
             const prevMonth = currentMonth_aa === 0 ? 11 : currentMonth_aa - 1;
             const prevYear = currentMonth_aa === 0 ? currentYear_aa - 1 : currentYear_aa;
       
             const dayElement = createDayElement(
               prevMonthDay,
               prevMonth,
               prevYear,
               true
             );
             $("#calendarDays").append(dayElement);
           }
       
           // Thêm các ngày trong tháng hiện tại
           for (let day = 1; day <= daysInMonth; day++) {
             const dayElement = createDayElement(
               day,
               currentMonth_aa,
               currentYear_aa,
               false
             );
             $("#calendarDays").append(dayElement);
           }
       
           // Thêm các ngày của tháng sau
           const remainingDays = 42 - (firstDayOfMonth + daysInMonth); // 42 = 6 hàng x 7 cột
           for (let i = 1; i <= remainingDays; i++) {
             const nextMonth = currentMonth_aa === 11 ? 0 : currentMonth_aa + 1;
             const nextYear = currentMonth_aa === 11 ? currentYear_aa + 1 : currentYear_aa;
       
             const dayElement = createDayElement(i, nextMonth, nextYear, true);
             $("#calendarDays").append(dayElement);
           }
       
           // Thêm sự kiện click cho các ô thời gian
           $(".time-slot").on("click", function () {
             const dayElement = $(this).closest(".calendar-day");
             selectedDate_aa = dayElement.data("date");
             const timeType = $(this).data("type");
             const currentTime = $(this).text();
       
             $(`#${timeType}Time`).val(currentTime);
             $("#timeModal").show();
           });
         }
       
         function createDayElement(day, month, year, isOtherMonth) {
           const date = new Date(year, month, day);
           const dayOfWeek = date.getDay();
           const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;
           const isWorkingDay = workingDays_s_giaoviec.includes(dayOfWeek);
       
           const dayElement = $("<div>")
             .addClass("calendar-day")
             .addClass(isWeekend ? "weekend" : "")
             .addClass(isOtherMonth ? "other-month" : "")
             .addClass(!isWorkingDay ? "non-working-day" : "")
             .attr(
               "data-date",
               `${year}-${String(month + 1).padStart(2, "0")}-${String(
                 day
               ).padStart(2, "0")}`
             );
       
           dayElement.append($("<div>").addClass("day-number").text(day));
       
           if (isWorkingDay) {
             const timeSlots = [
               {
                 class: "morning",
                 time: `${workSchedule_giaoviec_s.morningStart} - ${workSchedule_giaoviec_s.lunchStart}`,
               },
               {
                 class: "lunch",
                 time: `${workSchedule_giaoviec_s.lunchStart} - ${workSchedule_giaoviec_s.afternoonStart}`,
               },
               {
                 class: "afternoon",
                 time: `${workSchedule_giaoviec_s.afternoonStart} - ${workSchedule_giaoviec_s.endTime}`,
               },
               {
                 class: "end",
                 time: workSchedule_giaoviec_s.endTime,
               },
             ];
       
             const slotsContainer = $("<div>").addClass("time-slots");
             timeSlots.forEach((slot) => {
               slotsContainer.append(
                 $("<div>")
                   .addClass("time-slot")
                   .addClass(slot.class)
                   .text(slot.time)
                   .attr("data-type", slot.class)
               );
             });
       
             dayElement.append(slotsContainer);
           } else {
             dayElement.append(
               $("<div>").addClass("non-working-text").text("Nghỉ")
             );
           }
       
           return dayElement;
         }
       
         function closeModal_a() {
           $("#timeModal").hide();
         }
       
         function saveTime() {
           if (!selectedDate_aa) return;
       
           const timeData = {
             morning: $("#morningTime").val(),
             lunch: $("#lunchTime").val(),
             afternoon: $("#afternoonTime").val(),
             end: $("#endTime").val(),
           };
       
           // Gửi yêu cầu cập nhật lên server
           $.ajax({
             url: "process.php",
             type: "POST",
             data: {
               action: "update_schedule",
               date: selectedDate_aa,
               times: timeData,
             },
             success: function (response) {
               if (response.success) {
                 updateCalendar();
               } else {
                 alert("Có lỗi xảy ra khi cập nhật thời gian");
               }
             },
           });
       
           closeModal_a();
         }
       
         // Xử lý nút tháng trước
         $("#prevMonth").click(function () {
           currentMonth_aa--;
           if (currentMonth_aa < 0) {
             currentMonth_aa = 11;
             currentYear_aa--;
           }
           updateCalendar();
         });
       
         // Xử lý nút tháng sau
         $("#nextMonth").click(function () {
           currentMonth_aa++;
           if (currentMonth_aa > 11) {
             currentMonth_aa = 0;
             currentYear_aa++;
           }
           updateCalendar();
         });
       
         // Khởi tạo lịch
         updateCalendar();
  
  
         /////////////////////////////
        }
      })
  })

  /////////////////
  $("body").on(
    "change",
    ".form_search_cv_sep select, .form_search_cv_sep input",
    function () {
      trangthai_congviec = $("select[name=filter_role_admin_cv]").val();
      key = $("input[name=filter_search_role_admin_name]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_cv_cuatoi");
      form_data.append("trangthai_congviec", trangthai_congviec);
      form_data.append("key", key);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".thongke_g .list_viec_dagiao .congviec_cuanhansu_a table tbody").html(info);
          
        },
      });
    }
  );

  $("body").on(
    "keyup",
    ".form_search_cv_sep select, .form_search_cv_sep input",
    function () {
      trangthai_congviec = $("select[name=filter_role_admin_cv]").val();
      key = $("input[name=filter_search_role_admin_name]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_cv_cuatoi");
      form_data.append("trangthai_congviec", trangthai_congviec);
      form_data.append("key", key);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".thongke_g .list_viec_dagiao .congviec_cuanhansu_a table tbody").html(info);
        },
      });
    }
  );

  //////////////////////////////
  $("body").on(
    "change",
    "select[name=filter_role_admin_cv_ns]",
    function () {
      trangthai_congviec = $("select[name=filter_role_admin_cv_ns]").val();
      key = $("input[name=filter_search_role_admin_name_ns]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_cv_cuatoi");
      form_data.append("trangthai_congviec", trangthai_congviec);
      form_data.append("key", key);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".congviec_cuanhansu_a table tbody").html(info);
        },
      });
    }
  );

  $("body").on(
    "keyup",
    "input[name=filter_search_role_admin_name_ns]",
    function () {
      trangthai_congviec = $("select[name=filter_role_admin_cv_ns]").val();
      key = $("input[name=filter_search_role_admin_name_ns]").val();
      var form_data = new FormData();
      form_data.append("action", "aa_load_phantrang_cv_cuatoi");
      form_data.append("trangthai_congviec", trangthai_congviec);
      form_data.append("key", key);
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".congviec_cuanhansu_a table tbody").html(info);
        },
      });
    }
  );
  $("body").on("click", ".close_add_congviec", function () {
    $(".thongke_g").css("display", "block");
    $(".btn_remove_giaoviec").removeClass("active");
    $("button[name=tab_thongke]").addClass("active");
  
    var form_data = new FormData();
    form_data.append("action", "tab_action_box_thongke");
  
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
  
        var info = JSON.parse(kq);
        $(".thongke_g").html(info);
  
        $("body")
          .find("button[name='congviec_nv_d']")
          .each(function () {
            startCountdown(this);
          });
        updateCountdown();
      },
    });
  });
  
  $('body').on('click',"i[name=edit_name_pb]",function(){
    id = $(this).attr('data-id');
    var form_data = new FormData();
    form_data.append("action", "box_pop_up_edit_name_pb");
    form_data.append('id',id);
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $('.bruh_nhansuuukakak').html(info);
      },
    });
  })
  $('body').on('click','button[name=close_button_edit_pb]',function(){
    $('.bruh_nhansuuukakak .box_shadow').hide();
  })
  $('body').off('click','button[name=submit_edit_pb]').on('click','button[name=submit_edit_pb]',function(){
    name_pb = $('input[name=value_pb_name_was_edit]').val();
    id = $(this).attr('data-id');
    var form_data = new FormData();
    form_data.append("action", "submit_edit_name_pb");
    form_data.append('id',id);
    form_data.append('name_pb',name_pb)
    $.ajax({
      url: "/process.php",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (kq) {
        var info = JSON.parse(kq);
        $('.bruh_nhansuuukakak .box_shadow').hide();
        $(".btn_remove_giaoviec").removeClass("active");
      $("button[name=tab_phongban]").addClass("active");
      var form_data = new FormData();
      form_data.append("action", "tab_action_box_phongban");
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(kq){
          var infoo = JSON.parse(kq);
            $(".thongke_g").html(infoo.list);
        },
      });
      },
    });
  })
});


