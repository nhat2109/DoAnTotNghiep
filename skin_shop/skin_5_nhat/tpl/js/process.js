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

function readURL(input, id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#" + id).attr("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
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
function scrollSmoothToBottom(id) {
  var div = document.getElementById(id);
  $("#" + id).animate(
    {
      scrollTop: div.scrollHeight - div.clientHeight,
    },
    200
  );
}
function check_link() {
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
function check_blank() {
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
function confirm_del(action, id) {
  if (action == "del_chap") {
    title = "Xóa chap truyện";
  } else if (action == "del_truyen") {
    title = "Xóa truyện";
  } else {
    title = "Xóa dữ liệu";
  }
  $("#title_confirm").html(title);
  $("#button_thuchien").attr("action", action);
  $("#button_thuchien").attr("post_id", id);
  $("#box_pop_confirm").show();
}
$(document).ready(function () {
  /////////////////////////////
  setTimeout(function () {
    $.ajax({
      url: "/process.php",
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
        $(".count_note").html(info.count_note);
      },
    });
  }, 3000);
  setTimeout(function () {
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "check_exp",
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        if (info.ok == 0) {
          $(".load_overlay").show();
          $(".load_process").fadeIn();
          $(".load_note").html(info.thongbao);
          setTimeout(function () {
            window.location.href = "https://socdo.vn/";
          }, 3000);
        }
      },
    });
  }, 1000);
  $(".box_popup .box_title i").click(function () {
    $(".box_popup").fadeOut();
  });
  $("#trigger-mobile").on("click", function () {
    $(".c-menu--slide-left").toggleClass("active");
  });
  $("#close-nav").on("click", function () {
    $(".c-menu--slide-left").toggleClass("active");
  });
  $(".c-menu--slide-left .fa-plus").on("click", function (e) {
    $(this).toggleClass("active");
    $(this).parent().parent().find(".ul-has-child1").toggle();
    e.stopPropagation();
    return false;
  });
  $(".footer-widget h3").on("click", function () {
    $(this).toggleClass("active");
    $(this).parent().find(".list-menu").toggle();
  });
  $("#loc_danhmuc").on("click", function () {
    $(this).toggleClass("active");
    $(this).parent().find(".list-inline").toggle();
  });
  $("#loc_thuonghieu").on("click", function () {
    $(this).toggleClass("active");
    $(this).parent().find(".block_content").toggle();
  });
  $(".faq-title").on("click", function () {
    $(this).parent().toggleClass("active");
  });
  $(".change_avatar").click(function () {
    $("#minh_hoa").click();
  });
  $("#preview-minhhoa").click(function () {
    $("#minh_hoa").click();
  });
  $("#minh_hoa").change(function () {
    readURL(this, "preview-minhhoa");
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
  //////////////////////////
  $("#gallery_01 .swiper-slide img").on("click", function () {
    src = $(this).attr("src");
    $(".large_image_url").attr("href", src);
    $("#zoom_01").attr("src", src);
  });
  //////////////////////////
  // $(".tbody-popup").on("click", ".remove-cart-popup", function() {
  //   var sp_id = $(this).data("id");
  //   var color = $(this).data("color") || '';
  //   var size = $(this).data("size") || '';

  //   $(".load_overlay").show();
  //   $(".load_process").fadeIn();

  //   $.ajax({
  //       url: "/process.php",
  //       type: "POST",
  //       data: {
  //           action: "remove_cart",
  //           sp_id: sp_id,
  //           color: color,
  //           size: size
  //       },
  //       success: function(kq) {
  //           try {
  //               var info = JSON.parse(kq);
  //               if (info.ok == 1) {
  //                   $(".count_item_pr").html(info.total);
  //                   $(".total-price").html(info.total_price);
  //                   $(".tbody-popup").html(info.list);
  //                   $(".content_cart_header .count_item").html(info.total);
  //               }
  //           } catch(e) {
  //               console.error("JSON parse error:", e);
  //           }
  //           $(".load_process").hide();
  //           $(".load_overlay").hide();
  //       },
  //       error: function() {
  //           $(".load_process").hide();
  //           $(".load_overlay").hide();
  //           alert("Có lỗi xảy ra, vui lòng thử lại!");
  //       }
  //   });
  // });
  $(".tbody-popup").on("click", ".remove-cart-popup", function () {
    var sp_id = $(this).data("id");
    var color = $(this).data("color") || "";
    var size = $(this).data("size") || "";

    $(".load_overlay").show();
    $(".load_process").fadeIn();

    $.ajax({
      url: "/process.php",
      type: "POST",
      data: {
        action: "remove_cart",
        sp_id: sp_id,
        color: color,
        size: size,
      },
      success: function (kq) {
        try {
          var info = JSON.parse(kq);
          if (info.ok == 1) {
            $(".cart-popup-count").html(info.total);
            $(".total-price").html(info.total_price);
            $(".tbody-popup").html(info.list);
            $(".content_cart_header .count_item").html(info.total);
          }
        } catch (e) {
          console.error("JSON parse error:", e);
        }
        $(".load_process").hide();
        $(".load_overlay").hide();
      },
      error: function () {
        $(".load_process").hide();
        $(".load_overlay").hide();
        alert("Có lỗi xảy ra, vui lòng thử lại!");
      },
    });
  });
  //////////////////////////
  $(".tbody-popup").on("click", ".btn-plus", function () {
    id = $(this).parent().parent().find(".remove-item-cart").data("id");
    quantity = $(this).parent().find("input[name=quantity]").val();
    quantity++;
    $.ajax({
      url: "/process.php",
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
          $(".content_cart_header .count_item").html(info.total);
        } else {
          $(".load_overlay").hide();
          $(".modal").hide();
          $("#popup-cart .tbody-popup").html("");
          $("#popup-cart .tfoot-popup .total-price").html("");
          $("#popup-cart .cart-popup-name").html("");
          $("#popup-cart .cart-popup-count").html("");
          $(".content_cart_header .count_item").html("0");
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
      url: "/process.php",
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
          $(".content_cart_header .count_item").html(info.total);
        } else {
          $(".load_overlay").hide();
          $(".modal").hide();
          $("#popup-cart .tbody-popup").html("");
          $("#popup-cart .tfoot-popup .total-price").html("");
          $("#popup-cart .cart-popup-name").html("");
          $("#popup-cart .cart-popup-count").html("");
          $(".content_cart_header .count_item").html("0");
        }
      },
    });
  });
  //////////////////////////
  $(".tbody-popup").on("keyup", "input[name=quantity]", function () {
    id = $(this).parent().parent().find(".remove-item-cart").data("id");
    quantity = $(this).val();
    $.ajax({
      url: "/process.php",
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
          $(".content_cart_header .count_item").html(info.total);
        } else {
          $(".load_overlay").hide();
          $(".modal").hide();
          $("#popup-cart .tbody-popup").html("");
          $("#popup-cart .tfoot-popup .total-price").html("");
          $("#popup-cart .cart-popup-name").html("");
          $("#popup-cart .cart-popup-count").html("");
          $(".content_cart_header .count_item").html("0");
        }
      },
    });
  });
  //////////////////////////
  $(".shopping-cart .cart-tbody").on(
    "keyup",
    "input[name=quantity]",
    function () {
      id = $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".remove-item-cart")
        .data("id");
      quantity = $(this).val();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "update_shopcart",
          sp_id: id,
          quantity: quantity,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".cart_page_mobile").html(info.list_shopcart_mobile);

          // $(".cart-items").html(info.list_shopcart);
          $(".count_item_pr").html(info.total_cart);
          $("#popup-cart .cart-popup-count").html(info.total_cart);
          $(".totals_price").html(info.tongtien);
          $(".totals_price_mobile").html(info.tongtien);
        },
      });
    }
  );

  $(".cart-items").on("click", ".btn-plus", function () {
    var $row = $(this).closest(".shopping-cart-item");
    var id = $row.find(".remove-item-cart").data("id");
    var color = $row.find(".remove-item-cart").data("color");
    var size = $row.find(".remove-item-cart").data("size");
    var quantity = parseInt($row.find("input[name=quantity]").val()) + 1;

    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "update_shopcart",
        sp_id: id,
        color: color,
        size: size,
        quantity: quantity,
      },
      success: function (kq) {
        console.log("Phản hồi từ server:", kq);
        var info = JSON.parse(kq);
        $(".cart-items").html(info.list_shopcart);
        // $(".count_item_pr").html(info.total_cart);
        $("#popup-cart .cart-popup-count").html(info.total_cart);
        $(".price").html(info.tongtien);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi AJAX:", status, error);
      },
    });
  });

  // Sự kiện giảm số lượng
  $(".cart-items").on("click", ".btn-minus", function () {
    var $row = $(this).closest(".shopping-cart-item");
    var id = $row.find(".remove-item-cart").data("id");
    var color = $row.find(".remove-item-cart").data("color");
    var size = $row.find(".remove-item-cart").data("size");
    var quantity = parseInt($row.find("input[name=quantity]").val());

    if (quantity > 1) {
      quantity--;
    } else {
      quantity = 1;
    }
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "update_shopcart",
        sp_id: id,
        color: color,
        size: size,
        quantity: quantity,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".cart-items").html(info.list_shopcart);
        // $(".count_item_pr").html(info.total_cart);
        $("#popup-cart .cart-popup-count").html(info.total_cart);
        $(".price").html(info.tongtien);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi AJAX:", status, error);
      },
    });
  });
  //////////////////////////

  $(".cart-items").on("click", ".remove-item-cart", function () {
    var $button = $(this); // Lưu tham chiếu đến nút xóa
    var sp_id = $button.data("id") || 0;
    var color = $button.data("color") || "";
    var size = $button.data("size") || "";
    var $item = $button.closest(".shopping-cart-item"); // Lấy phần tử sản phẩm cần xóa

    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "remove_shopcart",
        sp_id: sp_id,
        color: color,
        size: size,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        if (info.ok === 1) {
          if (info.total_cart > 0) {
            // Xóa chỉ sản phẩm bị xóa khỏi giao diện
            $item.remove();

            // Cập nhật số lượng sản phẩm trong giỏ
            $(".count_item_pr").html(info.total_cart);
            $("#popup-cart .cart-popup-count").html(info.total_cart);

            // Cập nhật tổng tiền
            $(".cart-summary-section .total .price").html(info.tongtien);
            $(".totals_price").html(info.tongtien); // Nếu có class này
            $(".totals_price_mobile").html(info.tongtien);

            // Cập nhật tạm tính (nếu cần)
            $(".cart-summary-section .summary-item:not(.total) .price").html(
              info.tamtinh
            );

            console.log("Đã xóa sản phẩm");
          } else {
            // Nếu giỏ hàng trống, xóa toàn bộ giao diện
            $(".cart_page_mobile").html("");
            $(".cart-items").html("<p>Giỏ hàng của bạn trống.</p>");
            $(".count_item_pr").html("0");
            $("#popup-cart .cart-popup-count").html("0");
            $(".cart-summary-section .total .price").html("0 ₫");
            $(".totals_price").html("0 ₫");
            $(".totals_price_mobile").html("0 ₫");
          }
        } else {
          alert(info.thongbao); // Hiển thị thông báo lỗi từ server
        }
      },
      error: function () {
        alert("Có lỗi xảy ra khi xóa sản phẩm!");
      },
    });
  });

  //////////////////////////
  $(".cart_page_mobile").on("click", ".remove-item-cart", function () {
    id = $(this).data("id");
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "remove_shopcart",
        sp_id: id,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        if (info.total_cart > 0) {
          $(".cart_page_mobile").html(info.list_shopcart_mobile);
          $(".cart_desktop_page .cart-tbody").html(info.list_shopcart);
          $(".count_item_pr").html(info.total_cart);
          $("#popup-cart .cart-popup-count").html(info.total_cart);
          $(".totals_price").html(info.tongtien);
          $(".totals_price_mobile").html(info.tongtien);
        } else {
          $(".cart_page_mobile").html("");
          $(".cart_desktop_page .cart-tbody").html("");
          $(".count_item_pr").html("0");
          $("#popup-cart .cart-popup-count").html("0");
          $(".totals_price").html("0");
          $(".totals_price_mobile").html("0");
        }
      },
    });
  });
  //////////////////////////
  $(".cart_page_mobile").on("keyup", "input[name=quantity]", function () {
    id = $(this).parent().parent().find(".remove-item-cart").data("id");
    quantity = $(this).val();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "update_shopcart",
        sp_id: id,
        quantity: quantity,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".cart_page_mobile").html(info.list_shopcart_mobile);
        $(".cart_desktop_page .cart-tbody").html(info.list_shopcart);
        $(".count_item_pr").html(info.total_cart);
        $("#popup-cart .cart-popup-count").html(info.total_cart);
        $(".totals_price").html(info.tongtien);
        $(".totals_price_mobile").html(info.tongtien);
      },
    });
  });
  //////////////////////////
  $(".cart_page_mobile").on("click", ".btn-plus", function () {
    id = $(this).parent().parent().find(".remove-item-cart").data("id");
    quantity = $(this).parent().find("input[name=quantity]").val();
    quantity++;
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "update_shopcart",
        sp_id: id,
        quantity: quantity,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".cart_page_mobile").html(info.list_shopcart_mobile);
        $(".cart_desktop_page .cart-tbody").html(info.list_shopcart);
        $(".count_item_pr").html(info.total_cart);
        $("#popup-cart .cart-popup-count").html(info.total_cart);
        $(".totals_price").html(info.tongtien);
        $(".totals_price_mobile").html(info.tongtien);
      },
    });
  });
  //////////////////////////
  $(".cart_page_mobile").on("click", ".btn-minus", function () {
    id = $(this).parent().parent().find(".remove-item-cart").data("id");
    quantity = $(this).parent().find("input[name=quantity]").val();
    if (quantity > 1) {
      quantity--;
    } else {
      quantity = 1;
    }
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "update_shopcart",
        sp_id: id,
        quantity: quantity,
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        $(".cart_page_mobile").html(info.list_shopcart_mobile);
        $(".cart_desktop_page .cart-tbody").html(info.list_shopcart);
        $(".count_item_pr").html(info.total_cart);
        $("#popup-cart .cart-popup-count").html(info.total_cart);
        $(".totals_price").html(info.tongtien);
        $(".totals_price_mobile").html(info.tongtien);
      },
    });
  });
  //////////////////////////
  $("#customer_shipping_province").on("change", function () {
    tinh = $(this).val();
    if (tinh != "") {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "load_huyen",
          tinh: tinh,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          $("#customer_shipping_district").html(
            '<option value="">Chọn quận / huyện</option>' + info.list
          );
        },
      });
    } else {
    }
  });
  //////////////////////////
  $(".order-summary-toggle-text-show").on("click", function () {
    $(this).hide();
    $(".order-summary-toggle-text-hide").show();
    $(".thongtin_donhang .order-summary-section-discount").hide();
    $(".order-summary.thongtin_donhang").removeClass(
      "order-summary-is-collapsed"
    );
    $(".order-summary.thongtin_donhang").addClass("order-summary-is-expanded");
  });
  //////////////////////////
  $(".order-summary-toggle-text-hide").on("click", function () {
    $(this).hide();
    $(".order-summary-toggle-text-show").show();
    $(".order-summary.thongtin_donhang").removeClass(
      "order-summary-is-expanded"
    );
    $(".order-summary.thongtin_donhang").addClass("order-summary-is-collapsed");
  });
  //////////////////////////
  // $("#checkout_step_1").on("click", function () {
  //   ho_ten = $("input[name=ho_ten]").val();
  //   email = $("input[name=email]").val();
  //   dien_thoai = $("input[name=dien_thoai]").val();
  //   dia_chi = $("input[name=dia_chi]").val();
  //   tinh = $("select[name=tinh]").val();
  //   huyen = $("select[name=huyen]").val();
  //   if (ho_ten.length < 4) {
  //     $("input[name=ho_ten]").focus();
  //   } else if (dien_thoai.length < 8) {
  //     $("input[name=dien_thoai]").focus();
  //   } else if (dia_chi.length < 10) {
  //     $("input[name=dia_chi]").focus();
  //   } else if (tinh == "") {
  //     $(".load_overlay").show();
  //     $(".load_process").fadeIn();
  //     setTimeout(function () {
  //       $(".load_note").html("Vui lòng chọn Tỉnh/Thành phố");
  //     }, 1000);
  //     setTimeout(function () {
  //       $(".load_process").hide();
  //       $(".load_note").html("Hệ thống đang xử lý");
  //       $(".load_overlay").hide();
  //     }, 3000);
  //   } else if (huyen == "") {
  //     $(".load_overlay").show();
  //     $(".load_process").fadeIn();
  //     setTimeout(function () {
  //       $(".load_note").html("Vui lòng chọn Quận/huyện");
  //     }, 1000);
  //     setTimeout(function () {
  //       $(".load_process").hide();
  //       $(".load_note").html("Hệ thống đang xử lý");
  //       $(".load_overlay").hide();
  //     }, 3000);
  //   } else {
  //     $(".load_overlay").show();
  //     $(".load_process").fadeIn();
  //     $.ajax({
  //       url: "/process.php",
  //       type: "post",
  //       data: {
  //         action: "checkout_step_1",
  //         ho_ten: ho_ten,
  //         email: email,
  //         dien_thoai: dien_thoai,
  //         dia_chi: dia_chi,
  //         tinh: tinh,
  //         huyen: huyen,
  //       },
  //       success: function (kq) {
  //         var info = JSON.parse(kq);
  //         if (info.ok == 1) {
  //           setTimeout(function () {
  //             $(".load_note").html(info.thongbao);
  //           }, 1000);
  //           setTimeout(function () {
  //             window.location.href = "/checkout.html?step=2";
  //           }, 3000);
  //         } else {
  //           setTimeout(function () {
  //             $(".load_note").html(info.thongbao);
  //           }, 1000);
  //           setTimeout(function () {
  //             $(".load_process").hide();
  //             $(".load_note").html("Hệ thống đang xử lý");
  //             $(".load_overlay").hide();
  //           }, 3000);
  //         }
  //       },
  //     });
  //   }
  // });
  // //////////////////////////
  // $("#checkout_step_2").on("click", function () {
  //   thanhtoan = $("input[name=payment_method_id]:checked").val();
  //   $(".load_overlay").show();
  //   $(".load_process").fadeIn();
  //   $.ajax({
  //     url: "/process.php",
  //     type: "post",
  //     data: {
  //       action: "checkout_step_2",
  //       thanhtoan: thanhtoan,
  //     },
  //     success: function (kq) {
  //       var info = JSON.parse(kq);
  //       if (info.ok == 1) {
  //         setTimeout(function () {
  //           $(".load_note").html(info.thongbao);
  //         }, 1000);
  //         setTimeout(function () {
  //           window.location.href = "/checkout.html?step=3";
  //         }, 3000);
  //       } else {
  //         setTimeout(function () {
  //           $(".load_note").html(info.thongbao);
  //         }, 1000);
  //         setTimeout(function () {
  //           $(".load_process").hide();
  //           $(".load_note").html("Hệ thống đang xử lý");
  //           $(".load_overlay").hide();
  //         }, 3000);
  //       }
  //     },
  //   });
  // });

  $("#checkout_complete").on("click", function () {
    var ho_ten = $("input[name=ho_ten]").val().trim();
    var email = $("input[name=email]").val().trim();
    var dien_thoai = $("input[name=dien_thoai]").val().trim();
    var dia_chi = $("input[name=dia_chi]").val().trim();
    var tinh = $("select[name=tinh]").val();
    var huyen = $("select[name=huyen]").val();
    var thanhtoan = $("input[name=thanhtoan]:checked").val();
    var ghi_chu = $("textarea[name=ghi_chu]").val().trim();
    var shop = $("input[name=shop]").val();
    var phi_ship = $('.phi_ship[name="phi_ship"]').val();
    parseInt($("input[name=phi_ship_raw]").val()) ||
      parseInt(
        $("#phi_ship")
          .text()
          .replace(/[^0-9]/g, "")
      ) ||
      28000;

    var error = false;
    if (ho_ten.length < 4) {
      $("input[name=ho_ten]").focus();
      showError("Vui lòng nhập họ và tên (ít nhất 4 ký tự)");
      error = true;
    } else if (dien_thoai.length < 8 || !/^[0-9]+$/.test(dien_thoai)) {
      $("input[name=dien_thoai]").focus();
      showError("Vui lòng nhập số điện thoại hợp lệ (ít nhất 8 số)");
      error = true;
    } else if (dia_chi.length < 10) {
      $("input[name=dia_chi]").focus();
      showError("Vui lòng nhập địa chỉ (ít nhất 10 ký tự)");
      error = true;
    } else if (!tinh || tinh === "") {
      showError("Vui lòng chọn Tỉnh/Thành phố");
      error = true;
    } else if (!huyen || huyen === "") {
      showError("Vui lòng chọn Quận/Huyện");
      error = true;
    } else if (!thanhtoan) {
      showError("Vui lòng chọn phương thức thanh toán");
      error = true;
    }

    if (!error) {
      $(".load_overlay").show();
      $(".load_process").fadeIn();

      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "checkout_complete",
          ho_ten: ho_ten,
          email: email,
          dien_thoai: dien_thoai,
          dia_chi: dia_chi,
          tinh: tinh,
          huyen: huyen,
          thanhtoan: thanhtoan,
          ghi_chu: ghi_chu,
          shop: shop,
          phi_ship: phi_ship,
        },
        success: function (kq) {
          try {
            var info = JSON.parse(kq);
            if (info.ok == 1) {
              setTimeout(function () {
                $(".load_note").html(info.thongbao);
              }, 1000);
              setTimeout(function () {
                window.location.href = "/checkout.html?step=3";
              }, 3000);
            } else {
              setTimeout(function () {
                $(".load_note").html(info.thongbao);
              }, 1000);
              setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $(".load_overlay").hide();
              }, 3000);
            }
          } catch (e) {
            showError("Dữ liệu trả về không hợp lệ, vui lòng thử lại!");
          }
        },
        error: function () {
          showError("Có lỗi xảy ra, vui lòng thử lại!");
        },
      });
    }
  });

  // Hàm hiển thị thông báo lỗi
  function showError(message) {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    setTimeout(function () {
      $(".load_note").html(message);
    }, 1000);
    setTimeout(function () {
      $(".load_process").hide();
      $(".load_note").html("Hệ thống đang xử lý");
      $(".load_overlay").hide();
    }, 3000);
  }

  //////////////////////////
  $("#button_coupon_desktop, .field-input-btn").on("click", function () {
    var coupon;
    if ($(this).attr("id") === "button_coupon_desktop") {
      // Nếu là nút "Sử dụng", lấy từ input
      coupon = $("input[name=coupon_desktop]").val();
      if (coupon.length < 4) {
        $("input[name=coupon_desktop]").focus();
        return;
      }
    } else {
      // Nếu là nút "Áp dụng", lấy từ data-coupon
      coupon = $(this).data("coupon");
      if (!coupon || coupon.length < 4) {
        return; // Không làm gì nếu mã không hợp lệ
      }
    }

    var $button = $(this); // Lưu tham chiếu nút để hiển thị spinner
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $button.find(".btn-spinner").show();
    $button.prop("disabled", true);

    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "apply_coupon",
        coupon: coupon,
        shop: $("input[name=shop]").val(), // Thêm shop từ input ẩn
      },
      success: function (kq) {
        var info = JSON.parse(kq);
        if (info.ok == 1) {
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            window.location.reload();
          }, 3000);
        } else {
          setTimeout(function () {
            $(".load_note").html(info.thongbao);
          }, 1000);
          setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
            $button.find(".btn-spinner").hide();
            $button.prop("disabled", false);
          }, 3000);
        }
      },
      error: function () {
        setTimeout(function () {
          $(".load_note").html("Có lỗi xảy ra, vui lòng thử lại!");
        }, 1000);
        setTimeout(function () {
          $(".load_process").hide();
          $(".load_note").html("Hệ thống đang xử lý");
          $(".load_overlay").hide();
          $button.find(".btn-spinner").hide();
          $button.prop("disabled", false);
        }, 3000);
      },
    });
  });
  //////////////////////////
  $("#button_coupon_mobile").on("click", function () {
    coupon = $("input[name=coupon_mobile]").val();
    if (coupon.length < 4) {
      $("input[name=coupon_mobile]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "apply_coupon",
          coupon: coupon,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          if (info.ok == 1) {
            setTimeout(function () {
              $(".load_note").html(info.thongbao);
            }, 1000);
            setTimeout(function () {
              window.location.reload();
            }, 3000);
          } else {
            setTimeout(function () {
              $(".load_note").html(info.thongbao);
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
  //////////////////////////
  $(".tab-content .show-more").on("click", function () {
    $(".product-well").toggleClass("expanded");
  });
  //////////////////////////
  $(".navbar-pills .fa-angle-down").on("click", function () {
    $(this).parent().toggleClass("active");
  });
  /////////////////////////////
  $(".add_muakem_view").on("click", function () {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    main_product = $("input[name=main_product]").val();
    list_id = "";
    $("input[name^=sub_id]:checked").each(function () {
      list_id += $(this).val() + ",";
    });
    if (list_id == "") {
      setTimeout(function () {
        $(".load_note").html("Vui lòng chọn sản phẩm mua kèm");
      }, 500);
      setTimeout(function () {
        $(".load_process").hide();
        $(".load_note").html("Hệ thống đang xử lý");
        $(".load_overlay").hide();
      }, 2000);
    } else {
      list_id = list_id.substring(0, list_id.length - 1);
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_muakem",
          main_product: main_product,
          list_id: list_id,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          if (info.ok == 1) {
            setTimeout(function () {
              $(".load_note").html("Hệ thống đang chuyển hướng...");
            }, 500);
            setTimeout(function () {
              window.location.href = "/gio-hang.html";
            }, 2000);
          } else {
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
  /////////////////////////////
  $(".add_muakem").on("click", function () {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    main_product = $("input[name=main_product]").val();
    list_id = "";
    $("input[name^=sub_id]:checked").each(function () {
      list_id += $(this).val() + ",";
    });
    if (list_id == "") {
      setTimeout(function () {
        $(".load_note").html("Vui lòng chọn sản phẩm mua kèm");
      }, 500);
      setTimeout(function () {
        $(".load_process").hide();
        $(".load_note").html("Hệ thống đang xử lý");
        $(".load_overlay").hide();
      }, 2000);
    } else {
      list_id = list_id.substring(0, list_id.length - 1);
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_muakem",
          main_product: main_product,
          list_id: list_id,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          if (info.ok == 1) {
            setTimeout(function () {
              $(".load_note").html("Hệ thống đang chuyển hướng...");
            }, 500);
            setTimeout(function () {
              window.location.href = "/gio-hang.html";
            }, 2000);
          } else {
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
  /////////////////////////////

  $("body").on("click", '.add_to_cart', function () {
    if (!$(this).hasClass("disabled")) {
      // Lấy thông tin từ nút button
      let sp_id = $(this).attr("sp_id");
      let loai = $(this).attr("loai");
      let variant_id = $(this).attr("data-variant-id");
      // console.log(variant_id);

      // Lấy kích cỡ (size) và tên kích cỡ (ten_size)
      let size = "";
      let ten_size = "";
      if ($("input[name=size]").length > 0) {
        size = $("input[name=size]:checked").val() || "";
        ten_size = $("input[name=size]:checked").next("label").text() || "";
      }

      // Lấy màu (mau) và tên màu (ten_color)
      let mau = "";
      let ten_color = "";
      if ($("input[name=mau]").length > 0) {
        mau = $("input[name=mau]:checked").val() || "";
        ten_color = $("input[name=mau]:checked").data("ten-color") || "";
      }

      // Lấy số lượng (quantity)
      let quantity = 1;
      if ($("#quantity_view").length > 0) {
        quantity = parseInt($("#quantity_view").val()) || 1;
      }

      // Lấy giá (gia_moi) từ biến thể đã chọn
      let gia_moi = 0;
      if (typeof variants !== "undefined" && size && mau) {
        const selectedVariant = variants.find(
          (v) => v.color === mau && v.size === size
        );
        gia_moi = selectedVariant ? selectedVariant.gia_moi : 0;
      } else if (mau) {
        gia_moi = $("input[name=mau]:checked").data("gia") || 0;
      } else if (size) {
        gia_moi = $("input[name=size]:checked").data("gia") || 0;
      }

      // Kiểm tra dữ liệu trước khi gửi
      if (!sp_id || quantity <= 0) {
        alert("Dữ liệu không hợp lệ, vui lòng thử lại!");
        return;
      }

      // Hiển thị loading
      $(".load_overlay").show();
      $(".load_process").fadeIn();

      // Gửi AJAX request tới process.php
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "add_to_cart",
          sp_id: sp_id,
          loai: loai,
          variant_id: variant_id,
          size: size,
          mau: mau,
          ten_color: ten_color,
          ten_size: ten_size,
          quantity: quantity,
          gia_moi: gia_moi,
        },


        success: function (kq) {
          try {
            var info = JSON.parse(kq);
            if (info.ok === 1) {
              setTimeout(function () {
                $(".load_process").hide();
                $(".load_note").html("Hệ thống đang xử lý");
                $("#popup-cart").css("display", "block");
                $("#popup-cart .tbody-popup").html(info.list);
                $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                $("#popup-cart .cart-popup-name").html(info.name);
                $("#popup-cart .cart-popup-count").html(info.total_cart);
                $(".content_cart_header .count_item").html(info.total);
              }, 1000);
            } else {
              alert(info.thongbao || "Có lỗi xảy ra, vui lòng thử lại!");
              $(".load_process").hide();
              $(".load_overlay").hide();
            }
          } catch (e) {
            console.error("Lỗi khi parse JSON:", e);
            alert("Có lỗi xảy ra, vui lòng thử lại!");
            $(".load_process").hide();
            $(".load_overlay").hide();
          }
        },
        error: function () {
          alert("Lỗi kết nối đến server, vui lòng thử lại!");
          $(".load_process").hide();
          $(".load_overlay").hide();
        },
      });
    }
  });

  // $(".quick-view").on("click", function () {
  //   var sp_id = $(this).data("id");
  //   var link = $(this).data("link");

  //   $.ajax({
  //     url: "/process.php",
  //     type: "POST",
  //     data: {
  //       action: "quick_view",
  //       sp_id: sp_id,
  //       link: link,
  //     },
  //     success: function (response) {
  //       $("#quick-view-content").html(response);
  //       $("#quick-view-popup").css("display", "flex");

  //       var galleryThumbs = new Swiper(".gallery-thumbs", {
  //         spaceBetween: 10,
  //         slidesPerView: 4,
  //         freeMode: true,
  //         watchSlidesVisibility: true,
  //         watchSlidesProgress: true,
  //       });
  //       var galleryTop = new Swiper(".gallery-top", {
  //         spaceBetween: 10,
  //         thumbs: {
  //           swiper: galleryThumbs,
  //         },
  //       });

  //       // Logic xử lý biến thể
  //       document.querySelectorAll(".variant-color").forEach((input) => {
  //         input.addEventListener("change", function () {
  //           const selectedColor = this.value;
  //           const sizeSwap = document.getElementById("size-swap");
  //           let sizeHtml = "";
  //           let firstSize = true;
  //           variants.forEach((variant) => {
  //             if (variant.color === selectedColor) {
  //               const checked = firstSize ? "checked" : "";
  //               sizeHtml += `
  //                               <div class="n-sd swatch-element">
  //                                   <input class="variant-size" id="size-${variant.size}" type="radio" name="size" value="${variant.size}" ${checked} data-kho="${variant.kho}" data-gia="${variant.gia_moi}" data-ten-size="${variant.ten_size}" />
  //                                   <label for="size-${variant.size}">${variant.ten_size}</label>
  //                               </div>`;
  //               firstSize = false;
  //             }
  //           });
  //           sizeSwap.innerHTML = sizeHtml;
  //           updateStockAndPrice();
  //           addSizeEventListeners();
  //         });
  //       });

  //       function addSizeEventListeners() {
  //         document.querySelectorAll(".variant-size").forEach((input) => {
  //           input.addEventListener("change", updateStockAndPrice);
  //         });
  //       }
  //       addSizeEventListeners();

  //       function updateStockAndPrice() {
  //         const selectedSize = document.querySelector(".variant-size:checked");
  //         if (selectedSize) {
  //           const kho = selectedSize.getAttribute("data-kho");
  //           const gia = selectedSize.getAttribute("data-gia");
  //           const stockStatus = kho > 0 ? "Còn hàng" : "Hết hàng";
  //           const buttonText = kho > 0 ? "Thêm vào giỏ hàng" : "Hết hàng";
  //           const disabled = kho > 0 ? "" : "disabled";

  //           document.getElementById("stock-status").innerText = stockStatus;
  //           document.getElementById("price").innerText =
  //             new Intl.NumberFormat().format(gia);
  //           document.getElementById("buy-button").innerText = buttonText;
  //           document
  //             .getElementById("buy-button")
  //             .classList.toggle("disabled", kho <= 0);
  //         }
  //       }
  //       $(".btn-plus").on("click", function () {
  //         var input = $(this).siblings("input.quantity");
  //         var currentVal = parseInt(input.val());
  //         input.val(currentVal + 1);
  //       });

  //       $(".btn-minus").on("click", function () {
  //         var input = $(this).siblings("input.quantity");
  //         var currentVal = parseInt(input.val());
  //         if (currentVal > 1) {
  //           input.val(currentVal - 1);
  //         }
  //       });

  //       // Xử lý thêm vào giỏ hàng
  //       $("#buy-button").on("click", function () {
  //         if ($(this).hasClass("disabled")) return;

  //         const selectedColor = document.querySelector(
  //           ".variant-color:checked"
  //         ).value;
  //         const selectedSize = document.querySelector(
  //           ".variant-size:checked"
  //         ).value;
  //         const selectedVariant = variants.find(
  //           (v) => v.color === selectedColor && v.size === selectedSize
  //         );
  //         const cartData = {
  //           action: "add_to_cart",
  //           sp_id: $(this).attr("sp_id"),
  //           loai: $(this).attr("loai"),
  //           mau: selectedColor,
  //           size: selectedSize,
  //           ten_color: selectedVariant.ten_color,
  //           ten_size: selectedVariant.ten_size,
  //           gia_moi: selectedVariant.gia_moi,
  //           kho: selectedVariant.kho,
  //           quantity: $("#quantity_quick_view").val(),
  //         };

  //         $.ajax({
  //           url: "/process.php",
  //           type: "POST",
  //           data: cartData,
  //           success: function (kq) {
  //             var info = JSON.parse(kq);
  //             setTimeout(function () {
  //               $("#popup-cart").css("display", "block");
  //               $("#popup-cart .tbody-popup").html(info.list);
  //               $("#popup-cart .tfoot-popup .total-price").html(
  //                 info.total_price
  //               );
  //               $("#popup-cart .cart-popup-name").html(info.name);
  //               $("#popup-cart .cart-popup-count").html(info.total_cart);
  //               $(".content_cart_header .count_item").html(info.total);
  //               $("#quick-view-popup").css("display", "none");
  //             }, 1000);
  //           },
  //         });
  //       });
  //     },
  //   });
  // });

  $(".close-quick-view").on("click", function () {
    $("#quick-view-popup").css("display", "none");
  });

  /////////////////////////////
  $(".page_redirect a").on("click", function () {
    page = $(this).attr("page");
    var queryParams = new URLSearchParams(window.location.search);
    queryParams.set("page", page);
    history.replaceState(null, null, "?" + queryParams.toString());
    url = window.location.href;
    window.location.href = url;
  });
  /////////////////////////////
  $("select[name=sort]").on("change", function () {
    var queryParams = new URLSearchParams(window.location.search);
    var sort = $(this).val();
    queryParams.set("sort", sort);
    queryParams.set("page", 1);
    history.replaceState(null, null, "?" + queryParams.toString());
    url = window.location.href;
    window.location.href = url;
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
                    }, 1000);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },3000);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 1000);
                }
            }
        });*/
  });
  /////////////////////////////
  $("input[name=color-filter]").click(function () {
    var queryParams = new URLSearchParams(window.location.search);
    var color = "";
    var c = 0;
    $("input[name=color-filter]:checked").each(function () {
      c++;
      color += $(this).val() + "*";
    });
    if (c > 0) {
      color = color.substring(0, color.length - 1);
      queryParams.set("color", color);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    } else {
      url = window.location.href;
      url = removeURLParameter(url, "color");
      window.history.pushState("", "", url);
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    }
    url = window.location.href;
    window.location.href = url;
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
                    }, 1000);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },3000);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 1000);
                }
            }
        });*/
  });
  /////////////////////////////
  $("input[name=price-filter]").click(function () {
    var queryParams = new URLSearchParams(window.location.search);
    var price = "";
    var p = 0;
    $("input[name=price-filter]:checked").each(function () {
      p++;
      price += $(this).val() + "*";
    });
    if (p > 0) {
      price = price.substring(0, price.length - 1);
      queryParams.set("price", price);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    } else {
      url = window.location.href;
      url = removeURLParameter(url, "price");
      window.history.pushState("", "", url);
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    }
    url = window.location.href;
    window.location.href = url;
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
                    }, 1000);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },3000);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 1000);
                }
            }
        });*/
  });
  /////////////////////////////
  $("input[name=size-filter]").click(function () {
    var queryParams = new URLSearchParams(window.location.search);
    var size = "";
    var s = 0;
    $("input[name=size-filter]:checked").each(function () {
      s++;
      size += $(this).val() + "*";
    });
    if (s > 0) {
      size = size.substring(0, size.length - 1);
      queryParams.set("size", size);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    } else {
      url = window.location.href;
      url = removeURLParameter(url, "size");
      window.history.pushState("", "", url);
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    }
    url = window.location.href;
    window.location.href = url;
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
                    }, 1000);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },3000);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 1000);
                }
            }
        });*/
  });
  /////////////////////////////
  $("input[name=brand-filter]").click(function () {
    var queryParams = new URLSearchParams(window.location.search);
    var brand = "";
    var b = 0;
    $("input[name=brand-filter]:checked").each(function () {
      b++;
      brand += $(this).val() + "*";
    });
    if (b > 0) {
      brand = brand.substring(0, brand.length - 1);
      queryParams.set("brand", brand);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    } else {
      url = window.location.href;
      url = removeURLParameter(url, "brand");
      window.history.pushState("", "", url);
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("page", 1);
      history.replaceState(null, null, "?" + queryParams.toString());
    }
    url = window.location.href;
    window.location.href = url;
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
                    }, 1000);
                    setTimeout(function(){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    },3000);
                }else{
                    setTimeout(function() {
                        $('.product-list').html(info.list+'<div style="clear: both;"></div>');
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.product-list').find('img').lazyload({
                            effect : "fadeIn"
                        });
                    }, 1000);
                }
            }
        });*/
  });
  //////////////////////////
  $("button[name=change_avatar]").on("click", function () {
    var file_data = $("#minh_hoa").prop("files")[0];
    var form_data = new FormData();
    form_data.append("action", "change_avatar");
    form_data.append("file", file_data);
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
  });
  /////////////////////////////
  $("button[name=change_password]").click(function () {
    password = $("input[name=password]").val();
    new_password = $("input[name=new_password]").val();
    confirm_password = $("input[name=confirm_password]").val();
    if (password.length < 6) {
      $("input[name=password]").focus();
    } else if (new_password.length < 6) {
      $("input[name=new_password]").focus();
    } else if (new_password != confirm_password) {
      $("input[name=confirm_password]").focus();
    } else {
      $(".box_pop").hide();
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "change_password",
          password: password,
          new_password: new_password,
          confirm_password: confirm_password,
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
              window.location.href = "/dang-nhap.html";
            }
          }, 3000);
        },
      });
    }
  });
  /////////////////////////////
  $("#button_thuchien").click(function () {
    id = $("#button_thuchien").attr("post_id");
    action = $("#button_thuchien").attr("action");
    $(".box_pop").hide();
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: action,
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
  $("button[name=quen_matkhau]").on("click", function () {
    email = $("input[name=email]").val();
    var form_data = new FormData();
    form_data.append("action", "forgot_password");
    form_data.append("email", email);
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
            window.location.href = "/dang-nhap.html";
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
  });
  ////////////////////////
  $("button[name=dangky]").on("click", function () {
    username = $("input[name=username]").val();
    email = $("input[name=email]").val();
    password = $("input[name=password]").val();
    confirm_password = $("input[name=re_password]").val();
    ho_ten = $("input[name=ho_ten]").val();
    dien_thoai = $("input[name=dien_thoai]").val();
    if (username.length < 4) {
      $("input[name=username]").focus();
    } else if (ho_ten.length < 5) {
      $("input[name=ho_ten]").focus();
    } else if (dien_thoai.length < 8) {
      $("input[name=dien_thoai]").focus();
    } else if (email.length < 4) {
      $("input[name=email]").focus();
    } else if (password.length < 6) {
      $("input[name=password]").focus();
    } else if (password != confirm_password) {
      $("input[name=re_password]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
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
              window.location.href = "/dang-nhap.html";
            } else {
            }
          }, 3000);
        },
      });
    }
  });
  ////////////////////////
  $("button[name=change_profile]").on("click", function () {
    email = $("input[name=email]").val();
    ho_ten = $("input[name=ho_ten]").val();
    dien_thoai = $("input[name=dien_thoai]").val();
    ngay_sinh = $("input[name=ngay_sinh]").val();
    dia_chi = $("input[name=dia_chi]").val();
    if (ho_ten.length < 5) {
      $("input[name=ho_ten]").focus();
    } else if (email.length < 4) {
      $("input[name=email]").focus();
    } else if (dien_thoai.length < 8) {
      $("input[name=dien_thoai]").focus();
    } else if (ngay_sinh.length < 6) {
      $("input[name=ngay_sinh]").focus();
    } else if (dia_chi.length < 6) {
      $("input[name=dia_chi]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "change_profile",
          email: email,
          ho_ten: ho_ten,
          dien_thoai: dien_thoai,
          ngay_sinh: ngay_sinh,
          dia_chi: dia_chi,
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
  ////////////////////////
  $(".button_logout").on("click", function () {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process_logout.php",
      type: "post",
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
            window.location.href = "/";
          } else {
          }
        }, 3000);
      },
    });
  });
  ////////////////////////
  $("button[name=dangky_dropship]").on("click", function () {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    $.ajax({
      url: "/process.php",
      type: "post",
      data: {
        action: "dangky_dropship",
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
  ////////////////////////
  $("button[name=button_subscribe]").on("click", function () {
    $(".load_overlay").show();
    $(".load_process").fadeIn();
    email = $("input[name=email_subscribe]").val();
    if (email.length < 5) {
      $("input[name=email_subscribe]").focus();
    } else {
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "dangky_nhantin",
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
            if (info.ok == 1) {
              window.location.reload();
            } else {
            }
          }, 3000);
        },
      });
    }
  });
  ////////////////////////
  $("button[name=login]").on("click", function () {
    email = $("input[name=email]").val();
    password = $("input[name=password]").val();
    if (email.length < 4) {
      $("input[name=email]").focus();
    } else if (password.length < 6) {
      $("input[name=password]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process_login.php",
        type: "post",
        data: {
          email: email,
          password: password,
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
              window.location.href = "/tai-khoan.html";
            } else {
            }
          }, 3000);
        },
      });
    }
  });
  ////////////////////////
  $("button[name=button_lienhe]").on("click", function () {
    ho_ten = $("input[name=ho_ten]").val();
    email = $("input[name=email]").val();
    tieu_de = $("input[name=tieu_de]").val();
    shop = $("input[name=shop]").val();
    noi_dung = $("textarea[name=noi_dung]").val();
    if (ho_ten.length < 4) {
      $("input[name=ho_ten]").focus();
    } else if (email.length < 6) {
      $("input[name=email]").focus();
    } else if (tieu_de.length < 6) {
      $("input[name=tieu_de]").focus();
    } else if (noi_dung.length < 6) {
      $("textarea[name=noi_dung]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "lienhe",
          ho_ten: ho_ten,
          email: email,
          tieu_de: tieu_de,
          shop: shop,
          noi_dung: noi_dung,
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
  ////////////////////////
  $("input[name=input_search]").on("keyup", function () {
    key = $(this).val();
    if (key.length < 2) {
      $(".kq_search").hide();
    } else {
      $(".kq_search").show();
      $(".kq_search").html('<center><img src="/images/loading.gif"></center>');
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "goi_y",
          key: key,
        },
        success: function (kq) {
          var info = JSON.parse(kq);
          $(".kq_search").html(info.list);
        },
      });
    }
  });
  /////////////////////////////
  $("input[name=key_search]").keypress(function (e) {
    if (e.which == 13) {
      key = $("input[name=key_search]").val();
      //link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
      if (key.length < 2) {
        $("input[name=key_search]").focus();
      } else {
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        $.ajax({
          url: "/process.php",
          type: "post",
          data: {
            action: "timkiem",
            key_search: key,
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
                window.location.href = info.link;
              } else {
              }
            }, 3000);
          },
        });
      }
      return false;
    }
  });
  /////////////////////////////
  $(".button_search").click(function (e) {
    key = $("input[name=key_search]").val();
    //link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
    if (key.length < 2) {
      $("input[name=key_search]").focus();
    } else {
      $(".load_overlay").show();
      $(".load_process").fadeIn();
      $.ajax({
        url: "/process.php",
        type: "post",
        data: {
          action: "timkiem",
          key_search: key,
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
              window.location.href = info.link;
            } else {
            }
          }, 3000);
        },
      });
    }
    return false;
  });
  $(".show_menu").click(function () {
    $(".menu_list").toggle();
  });
  /////////////////////
  $(".box_logo_mobile i").click(function () {
    $(".box_logo_mobile").toggle();
    $(".box_menu").toggle();
    $(".li_main i").addClass("fa-angle-down");
    $(".li_main i").removeClass("fa-angle-up");
    $(".sub_menu").hide();
  });
  /////////////////////
  $(".li_main i").click(function () {
    $(this).parent().find(".sub_menu").toggle();
    if ($(this).hasClass("fa-angle-down")) {
      $(this).removeClass("fa-angle-down");
      $(this).addClass("fa-angle-up");
    } else {
      $(this).addClass("fa-angle-down");
      $(this).removeClass("fa-angle-up");
    }
  });
  ////////////////////////
  $("body").keydown(function (e) {
    if ($(".content_view_chap").length > 0) {
      if (e.keyCode == 37) {
        if ($(".link-prev-chap").length > 0) {
          link = $(".link-prev-chap").attr("href");
          window.location.href = link;
        }
      } else if (e.keyCode == 39) {
        if ($(".link-next-chap").length > 0) {
          link = $(".link-next-chap").attr("href");
          window.location.href = link;
        }
      }
    } else {
    }
  });
   /////////////////
});

$(document).ready(function () {

   
  const searchInput = $("#search-input");
  const searchDropdown = $(".search-dropdown");
  const featuredProducts = $(".featured-products");
  const searchProducts = $(".search-products");
  const featuredList = $(".featured-list");
  const searchList = $(".search-list");
  let searchTimeout;

  // Load featured products on focus
  searchInput.on("focus", function () {
    if (!searchInput.val().trim()) {
      $.ajax({
        url: "/process.php",
        type: "POST",
        data: {
          action: "search_suggestions",
        },
        success: function (response) {
          const data = JSON.parse(response);
          featuredList.html(data.featured);
          featuredProducts.show();
          searchProducts.hide();
          searchDropdown.show();
        },
      });
    }
  });

  // Handle search input
  searchInput.on("input", function () {
    const keyword = $(this).val().trim();

    // Clear previous timeout
    clearTimeout(searchTimeout);

    // Set new timeout to prevent too many requests
    searchTimeout = setTimeout(function () {
      if (keyword) {
        $.ajax({
          url: "/process.php",
          type: "POST",
          data: {
            action: "search_suggestions",
            keyword: keyword,
          },
          success: function (response) {
            const data = JSON.parse(response);
            searchList.html(data.search);
            featuredProducts.hide();
            searchProducts.show();
            searchDropdown.show();
          },
        });
      } else {
        // If search is empty, show featured products
        $.ajax({
          url: "/process.php",
          type: "POST",
          data: {
            action: "search_suggestions",
          },
          success: function (response) {
            const data = JSON.parse(response);
            featuredList.html(data.featured);
            featuredProducts.show();
            searchProducts.hide();
            searchDropdown.show();
          },
        });
      }
    }, 300); // Delay 
    // 300ms
  });

  // Hide dropdown when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".header_search").length) {
      searchDropdown.hide();
    }
  });
  // Thêm nút đóng vào dropdown tìm kiếm
  if ($(".search-dropdown .close-search").length === 0) {
    $(".search-dropdown .search-result").prepend(
      '<div class="close-search"></div>'
    );
  }

  // Xử lý sự kiện click nút đóng
  $(document).on("click", ".close-search", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(".search-dropdown").hide();
  });

  // Ẩn dropdown khi click ra ngoài
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".header_search").length) {
      $(".search-dropdown").hide();
    }
  });

  // nút x dropdow tìm kiếm gợi ý
  $(document).on("click", ".search-dropdown button", function () {
    $(this).closest(".search-dropdown").hide();
    $(".featured-list").empty();
    $(".search-list").empty();
  });
 });

