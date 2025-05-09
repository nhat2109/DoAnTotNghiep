<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="referrer" content="origin" />
    <meta name="description" content="Đang chuyển hướng..." />
    <title>Đang chuyển hướng</title>
    <!-- Google Analytics -->
    <style>
        * {padding: 0;margin: 0}
		body {font-family: Arial, sans-serif;color: #333}
		.rd-container {width: 100%;max-height: 100vh;float: left;background: #FFF}
		.rd-top {width: 100%;padding-top: 6vh}
		.rd-top .image-wrapper {
			width: 108px;
			margin: 0 auto;
			text-align: center;
			
		}
		.rd-top .rd-msg {
			color: #666;
			padding: 30px 0 20px;
			text-align: center;
			font-size: 20px;
			font-weight: 300;
			line-height: 35px
		}
		.rd-top .rd-msg span {color: #555;font-weight: bold}
		.rd-top .promo-code {position:relative;z-index:1;padding:0;text-align: center}
		.rd-top .rd-process {width: 100%;margin: 0 auto;text-align: center}
		.rd-top .merchant-logo-wrapper {
			position: relative;
			width: 108px;
			height: 108px;
		}
		.rd-top .merchant-logo-wrapper img {
			width: 96px;height: 96px;
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			border-radius: 50%;
		}
		.rd-bottom {
			width: 100%;
			background-color: #f7f7f7;
			text-align: center;
			position: absolute;
			bottom: 0;
			padding:8vh 0;
		}
		.rd-bottom .descript {width: 60%;margin: auto;padding-top: 5px;font-size: 16px;color: #666}
		.__tracking__ {display: none}
		
		@media screen and (max-width: 1367px) {
			.rd-bottom {padding:8vh 0;}
			.rd-top .rd-msg {padding: 30px 0 20px}
		}
		@media screen and (max-width: 600px) {
			.rd-top .image-wrapper{width:102px}
			.rd-top .merchant-logo-wrapper {width: 102px; height:102px} 
			.rd-top .merchant-logo-wrapper img{width: 90px; height:90px}

			.rd-top .rd-msg {padding: 2vh 0;font-size: 20px}
			.rd-top .rd-process .process-bar {max-width: 250px}
			
			
			.rd-bottom .descript {width: 95%;}
			.no-phone{display:none}
			
			.rd-bottom {
				padding: 2vh 0 !important
			}

			.rd-bottom .domain {
				background-size: 64vw !important
			}

			
		}
		.process-bar {position: absolute;top: 4px;width: 100%}
		.process-bar .process-value {
			width: 0;
			height: 4px;
			background: #1199d1;
			background: -moz-linear-gradient(30deg,#56e2e0 0%,#1199d1 100%);
			background: -webkit-gradient(linear,left bottom,right top,color-stop(0%,#56e2e0),color-stop(100%,#1199d1));
			background: -webkit-linear-gradient(30deg,#56e2e0 0%,#1199d1 100%);
			background: -o-linear-gradient(30deg,#56e2e0 0%,#1199d1 100%);
			background: -ms-linear-gradient(30deg,#56e2e0 0%,#1199d1 100%);
			background: linear-gradient(30deg,#56e2e0 0%,#1199d1 100%);
			-webkit-transition: all 4s;
			-moz-transition: all 4s;
			-ms-transition: all 4s;
			-o-transition: all 4s;
			transition: all 4s
		}
	</style>
    <script type="text/javascript" src="/js/progressbar.min.js"></script>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="rd-container">
        <div class="rd-top">
            <div class="image-wrapper">
                <div class="merchant-logo-wrapper" id="logo">
                    <img src="/skin/css/images/loading.gif">
                </div>
            </div>
            <div class="rd-msg">
                <div>{thongbao}</div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
    	var time = 0;
        setInterval(function() {
            time = time + 0.25;
            if (time == 1.25) {
                setTimeout(function() {
                    window.location.href = '{link}';
                    return false;
                }, 250);
            } else {
                if (time < 1.25) {
                    bar.animate(time); // Number from 0.0 to 1.0
                }
            }
        }, 1000);
        var bar = new ProgressBar.Circle(logo, {
            color: '#FFEA82',
            trailColor: '#eee',
            trailWidth: 1,
            duration: 1400,
            easing: 'easeInOut',
            strokeWidth: 3,
            from: { color: '#f60', a: 0 },
            //to: {color: '#3478F6', a:1},
            to: { color: '#f26b34', a: 1 },
            // Set default step function for all animate calls 
            step: function(state, circle) {
                circle.path.setAttribute('stroke', state.color);
            }
        });
    });
    </script>
</body>

</html>