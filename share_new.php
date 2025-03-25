<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="/js/jquery-3.2.1.min.js"></script>
</head>
<body>
	<style type="text/css">
		button{
			width: 200px;
			margin-top: 20px;
			padding-top:10px;
			padding-bottom: 20px;
			background:#f60;
			color: #fff;
		}

	</style>
<script type="text/javascript">
	function filename(path){
	    path = path.substring(path.lastIndexOf("/")+ 1);
	    return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
	}
	function getImgURL(url, callback){
	    var xhr = new XMLHttpRequest();
	    xhr.onload = function() {
	        callback(xhr.response);
	    };
	    xhr.open('GET', url);
	    xhr.responseType = 'blob';
	    xhr.send();
	}
	function loadURLToInputField(url,id_input){
	  getImgURL(url, (imgBlob)=>{
	    // Load img blob to input
	    fileName = filename(url) // should .replace(/[/\\?%*:|"<>]/g, '-') for remove special char like / \
	    if(fileName.indexOf('.jpg')>-1){
	        file = new File([imgBlob], fileName,{type:"image/jpeg", lastModified:new Date().getTime()}, 'utf-8');
	    }else if(fileName.indexOf('.jpeg')>-1){
	        file = new File([imgBlob], fileName,{type:"image/jpeg", lastModified:new Date().getTime()}, 'utf-8');
	    }else if(fileName.indexOf('.png')>-1){
	        file = new File([imgBlob], fileName,{type:"image/png", lastModified:new Date().getTime()}, 'utf-8');
	    }else{
	        file = new File([imgBlob], fileName,{type:"image/jpeg", lastModified:new Date().getTime()}, 'utf-8');
	    }
	    container = new DataTransfer(); 
	    container.items.add(file);
	    document.querySelector(id_input).files = container.files;
	  })
	}
	$(document).ready(function(){
		$('#them_anh').on('click',function(){
			i=0;
	        $('img').each(function() {
	        	$('#them_anh').before('<input type="file" style="display:none;" id="input_'+i+'" name="file[]" multiple="multiple" />');
	        	src=$(this).attr('src');
	        	ten_file=filename(src);
	        	loadURLToInputField(src,'#input_'+i);
	        	console.log(src);
	        	i++;
	        });
	        $('#submit_button').click();
		});
		$('#submit_button').on('click',function(){
	        var file_store=[];
	        var i=0;
	        $("input[name^=file]").each(function() {
	        	file_store.push.apply(file_store,$(this)[0].files);
	        });
			total_file=file_store.length;
			if(file_store.length>0){
				if (navigator.share) {
			        navigator.share({
			            title: 'Bán hàng trên mạng xã hội',
			            text: 'Nội dung thử nghiệm!',
			            files: file_store,
			        })
			          .then(() => $('input[name=lan]').val('0'))
			          .catch((error) => console.log('Error sharing', error));
			        } else {
			        console.log('Không hỗ trợ trên trình duyệt này.');
			    }
			}else{
				setTimeout(function(){
			        $("input[name^=file]").each(function() {
			        	file_store.push.apply(file_store,$(this)[0].files);
			        });
			        total_file=file_store.length;
					if(file_store.length>0){
						if (navigator.share) {
					        navigator.share({
					            title: 'Bán hàng trên mạng xã hội',
					            text: 'Nội dung thử nghiệm!',
					            files: file_store,
					        })
					          .then(() => $('input[name=lan]').val('0'))
					          .catch((error) => console.log('Error sharing', error));
					        } else {
					        console.log('Không hỗ trợ trên trình duyệt này.');
					    }
					}else{
				        $("input[name^=file]").each(function() {
				        	file_store.push.apply(file_store,$(this)[0].files);
				        });
				        total_file=file_store.length;
						if(file_store.length>0){
							if (navigator.share) {
						        navigator.share({
						            title: 'Bán hàng trên mạng xã hội',
						            text: 'Nội dung thử nghiệm!',
						            files: file_store,
						        })
						          .then(() => $('input[name=lan]').val('0'))
						          .catch((error) => console.log('Error sharing', error));
						        } else {
						        console.log('Không hỗ trợ trên trình duyệt này.');
						    }
						}else{
							console.log('Không thể chia sẻ');
						}
					}
				},3000);
			}
		});
	});
</script>
<img src="https://socdo.vn/uploads/hinh-anh/05-04-2022/1-1649150621.jpg">
<img src="https://socdo.vn/uploads/hinh-anh/05-04-2022/2-1649150621.jpg">
<button type="button" id="them_anh">Đăng bán</button>
<button type="submit" id="submit_button" style="display: none;" onclick="return false;">Hoàn thành</button>
</body>
</html>