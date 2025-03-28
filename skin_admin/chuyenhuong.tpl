<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{title}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); 
            z-index: 9998;
        }
        
        .redirect_box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px; 
            height: 100px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            overflow: hidden;
        }
        .spinner {
            position: absolute;
            width: 80px; 
            height: 80px;
            border: 4px solid rgba(52, 152, 219, 0.3); 
            border-top: 4px solid #3498db; 
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        .countdown {
            font-size: 28px; 
            font-weight: bold;
            color: #2c3e50; 
            z-index: 1; 
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="redirect_box">
        <div class="spinner"></div>
        <div class="countdown" id="countdown">3</div>
    </div>

    <script>
        var seconds = 3;
        var countdown = setInterval(function() {
            seconds--;
            document.getElementById('countdown').textContent = seconds;
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '{link_chuyen}';
            }
        }, 1000);
    </script>
</body>
</html>