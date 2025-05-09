//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
/*var images = [];
var imgElements = document.querySelectorAll('.li_share_sanpham.active .minh_hoa img');
for (var i = 0; i < imgElements.length; i++) {
    const newItem = {
        text: 'Ảnh thứ '+i,
        url: imgElements[i].src,
    };
    images.push(newItem);
}
console.log(images);*/
    const shareData = [
      {
        title: 'Ảnh thứ nhất',
        text: 'teaar',
        url: 'https://socdo.vn/uploads/test.mp4',
      },
      {
        title: 'Ảnh thứ hai',
        text: 'Mô tả cho ảnh thứ hai',
        url: 'https://socdo.vn/uploads/hinh-anh/may-lam-sua-hat-2good-e25-5-1680944384.jpg',
      },
      {
        title: 'Ảnh thứ hai',
        text: 'Mô tả cho ảnh thứ hai',
        url: 'https://socdo.vn/uploads/hinh-anh/05-04-2022/2-1649150621.jpg',
      },
      {
        title: 'Ảnh thứ hai',
        text: 'Mô tả cho ảnh thứ hai',
        url: 'https://socdo.vn/uploads/hinh-anh/may-lam-sua-hat-2good-e25-5-1680944384.jpg',
      }
      // Thêm các ảnh khác vào đây
    ];

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