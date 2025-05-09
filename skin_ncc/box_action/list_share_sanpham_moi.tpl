<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <title>
        Nội dung bán hàng
    </title>
    <meta charset='utf-8' />
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon" />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <meta name='description' content='Socdo.vn - Nền tảng bán hàng Đa Kênh'>
    <meta property='og:title' content='Nội dung bán hàng' />
    <meta property='og:description' content='Socdo.vn - Nền tảng bán hàng Đa Kênh' />
    <link href='/skin_ncc/css/font-roboto.css' rel='stylesheet' />
    <link href='/skin_ncc/css/font-awesome.min.css' rel='stylesheet' />
    <link href='/skin_ncc/css/font-glyphicon.css' rel='stylesheet' />
    <link href='/skin_ncc/css/icomoon.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="/swiper/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="/fonts/icofont/icofont/icofont.min.css">
    <link rel="stylesheet" type="text/css" href="/skin_ncc/css/style.css?t=1684426845">
    <script src="/js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="page_body" style="display: block;">
        <div class="box_right" style="width: 100%;margin-left: 0px;">
            <div class="box_right_content">
                <div class="box_profile" style="width: 100%;padding: 10px;">
                    <div class="page_title">
                        <h1 class="undefined">Nội dung bán "{tieu_de}"</h1>
                        <div class="line"></div>
                        <hr>
                    </div>
                    <div class="list_dinhkem">
                        <div class="li_dinhkem">Đăng kèm:</div>
                        <div class="li_dinhkem"><input type="checkbox" checked="checked" name="rut_gon" value="{rut_gon}"> Link Affiliate</div>
                        <div class="li_dinhkem"><input type="checkbox" checked="checked" name="mobile_share" value="{mobile}"> Số điện thoại</div>
                    </div>
                    <div class="list_tab_noidung">{list_tab}</div>
                    <div class="list_share_sanpham">
                        {list_noidung}
                    </div>
                    {phantrang}
                </div>
            </div>
        </div>
        <div class="box_pop_xemtruoc">
            <div class="content_pop_xemtruoc">
                <div class="xemtruoc_title"><span>Xem trước nội dung</span><span class="close_pop"><i class="fa fa-times-circle"></i></span></div>
                <div class="noidung_xemtruoc scroll"></div>
                <div class="list_button"><button class="bg_green share_button" id="share_button" noidung_id="" minh_hoa=""><img src="/images/fb_zalo.png"> Bán ngay</button><button class="bg_orange copy_button" noidung_id="" minh_hoa=""><i class="fa fa-copy"></i> Sao chép</button></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    const shareData = [
      {
        title: 'Ảnh thứ nhất',
        text: 'teaar',
        url: 'https://socdo.vn/uploads/socdo.mp4',
      },
      {list_anh}
      // Thêm các ảnh khác vào đây
    ];
/*    const shareData = [
    ];*/
    const shareImages = async () => {
      const files = await Promise.all(shareData.map(async (item) => {
        const file = await getFileWithPermission(item.url);
        return file;
      }));

      if (navigator.share) {
        navigator.share({ files: files,title: 'Bán hàng trên mạng xã hội',text: 'Nội dung test'})
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

    const shareBtn = document.querySelector('.share_button');
    shareBtn.addEventListener('click', shareImages);
    </script>
</body>

</html>