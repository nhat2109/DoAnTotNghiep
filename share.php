<!DOCTYPE html>
<html>
<head>
  <title>Chia sẻ nhiều ảnh lên Zalo</title>
<meta property="og:url" content="https://socdo.vn/product/may-triet-long-tre-hoa-da-ipl-pro-tang-kem-kinh-ram-va-dao-cao.html" />
<meta property="og:title" content="Máy triệt lông & trẻ hóa da IPL PRO, tặng kèm kính râm và dao cạo" />
<meta property="og:image" content="https://socdo.vn/uploads/hinh-anh/may-lam-sua-hat-2good-e25-5-1680944384.jpg" />
<meta property="og:image" content="https://socdo.vn/uploads/hinh-anh/may-lam-sua-hat-2good-e25-1-1680944197.jpg" />
<meta property="og:description" content="IPL PRO 3 trong 1 với các tính năng triệt lông, trẻ hóa da, ngăn ngừa mụn. Nổi bật với công nghệ triệt lạnh Ice - Cool hiện đại nhất, giúp làm dịu vùng triệt, tạo cảm giác mát lạnh thư thái, xóa nỗi lo đau rát, khó chịu khi triệt lông ở các vùng nhạy cảm, nâng hiệu quả triệt lông gấp 3 lần so với máy thông thường." /> 
</head>
<body>
  <h1>Chia sẻ nhiều ảnh lên Zalo</h1>
  <button id="shareBtn">Chia sẻ ảnh</button>
  <script>
    const shareData = [
      {
        title: 'Ảnh thứ nhất',
        text: 'teaar',
        url: 'https://socdo.vn/uploads/minh-hoa/logo-1635145680.png',
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

    const shareBtn = document.getElementById('shareBtn');
    shareBtn.addEventListener('click', shareImages);
  </script>
</body>
</html>
