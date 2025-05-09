<div class="box_right">
	<div class="box_right_content">
	  <div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title">
		  <h1 class="undefined">Danh mục sản phẩm</h1>
		  <div class="line"></div>
		  <hr>
		</div>
		<!-- Filter Section -->
		<div class="filter_section" style="margin-bottom: 20px; display: flex; gap: 20px; align-items: center; flex-direction: row-reverse;">
		  <!-- Search by Title -->
		  <div class="search_box" style="position: relative; width: 300px;">
			<input type="text" id="search_title" placeholder="Tìm kiếm tiêu đề..." style="width: 100%; padding: 8px 30px 8px 10px; border: 1px solid #ddd; border-radius: 4px;">
			<i class="fa fa-search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" onclick="filterCategories()"></i>
		  </div>
		  <!-- Filter by Parent Category -->
		  <div class="category_filter" style="display: none;">
			Danh mục mẹ :
			<select id="filter_parent" onchange="filterCategories()" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-width: 200px;">
			  <option value="">Tất cả danh mục mẹ</option>
			  {parent_categories}
			</select>
		  </div>
		</div>
		<style type="text/css">
		  .list_baiviet i {
			font-size: 35px;
		  }
		</style>
		<table class="list_baiviet">
		  <tr>
			<th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
			<th style="text-align: left;">Tiêu đề</th>
			<th style="text-align: left;">Danh mục mẹ</th>
			<th style="text-align: center;" class="hide_mobile">Thứ tự</th>
			<th style="text-align: center;width: 100px;">Hành động</th>
		  </tr>
		  {list_theloai}
		</table>
		{phantrang}
	  </div>
	</div>
  </div>
  <script type="text/javascript">
	$(document).ready(function(){
	  total_height=0;
	  $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
		total_height+=$(this).outerHeight();
		if($(this).attr('id')=='menu_danhmuc_sanpham'){
		  vitri=total_height - 90;
		}
	  });
	  $('.box_menu_left').animate({scrollTop: vitri}, 1000);
  
	  // Handle Enter key for search
	  $('#search_title').on('keypress', function(e) {
		if (e.which == 13) {
		  filterCategories();
		}
	  });
	});
  
	// Hàm chuẩn hóa chuỗi (bỏ dấu tiếng Việt)
	function normalizeString(str) {
	  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().trim();
	}
  
	function filterCategories() {
	  var searchTitle = $('#search_title').val();
	  var parentId = $('#filter_parent').val();
	  var normalizedSearchTitle = normalizeString(searchTitle);
  
	//   console.log('Parent ID selected:', parentId);
  
	  $('.list_baiviet tr').each(function(index) {
		if (index === 0) return; // Bỏ qua hàng tiêu đề
  
		var title = $(this).find('td').eq(1).text();
		var parent = $(this).attr('data-parent-id') || '0';
		var normalizedTitle = normalizeString(title);
  
		// console.log('Row title:', title, 'Parent ID:', parent);
  
		var showRow = true;
  
		// Lọc theo tiêu đề
		if (searchTitle && !normalizedTitle.includes(normalizedSearchTitle)) {
		  showRow = false;
		}
  
		// Lọc theo danh mục mẹ
		if (parentId) {
		  // Nếu là danh mục mẹ (parent = 0), vẫn hiển thị nếu không bị lọc bởi tiêu đề
		  if (parent === '0') {
			showRow = showRow; // Giữ nguyên trạng thái từ lọc tiêu đề
		  } else {
			// Nếu là danh mục con, chỉ hiển thị nếu parent khớp với parentId
			showRow = showRow && (parent === parentId);
		  }
		}
  
		$(this).toggle(showRow);
	  });
	}
  </script>