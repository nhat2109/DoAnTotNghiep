<div class="box_right">
    <style>
        .box_right {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin: 20px;
        }

        .page_title {
            margin-bottom: 30px;
        }

        .page_title h1 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .line {
            height: 2px;
            background: #f0f0f0;
            margin-top: 40px !important;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .row.g-3 {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .row.g-3:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
        }

        .row.g-3 .col-md-3,
        .row.g-3 .col-md-4,
        .row.g-3 .col-md-5 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 15px;
        }

        .row.g-3 .form-label {
            display: block;
            margin-bottom: 8px;
        }

        .row.g-3 .form-control {
            width: 100%;
        }

        @media (max-width: 768px) {

            .row.g-3 .col-md-3,
            .row.g-3 .col-md-4,
            .row.g-3 .col-md-5 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 15px;
            }

            .feature-box {
                min-width: 100%;
            }
        }

        .btn-primary {
            background: #4a90e2;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #357abd;
            transform: translateY(-1px);
        }

        .button_all {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button_all:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        .form_group {
            margin-top: 30px;
            text-align: right;
        }

        .col_50 {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .box-number {
            position: absolute;
            top: -10px;
            left: -10px;
            background: #4a90e2;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .icon-picker-btn {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .icon-picker-btn i {
            font-size: 16px;
            color: #4a90e2;
        }
        
        .icon-picker-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        
        .icon-picker-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .icon-picker-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .icon-picker-search {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
        }
        
        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .icon-item:hover {
            background: #f8f9fa;
            border-color: #4a90e2;
        }
        
        .icon-item i {
            font-size: 24px;
            margin-bottom: 5px;
            color: #4a90e2;
        }
        
        .icon-item span {
            font-size: 12px;
            color: #666;
            text-align: center;
            word-break: break-word;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        
        .close-modal:hover {
            color: #333;
        }
        .button_all {
            margin-top: 10px;
            float: right;
        }
    </style>
    
    <div class="icon-picker-modal" id="iconPickerModal">
        <div class="icon-picker-content">
            <div class="icon-picker-header">
                <h3>Chọn Icon</h3>
                <button class="close-modal">&times;</button>
            </div>
            <input type="text" class="icon-picker-search" placeholder="Tìm kiếm icon...">
            <div class="icon-grid" id="iconGrid">
            </div>
        </div>
    </div>

    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa cài đặt tính năng trang chủ website của bạn</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <form id="featureForm">
                    <div class="row g-3 mb-3">
                        <div class="box-number">1</div>
                        <div class="col-md-3">
                            <label class="form-label">Icon</label>
                            <div class="icon-picker-btn" onclick="openIconPicker(this)">
                                <i class="fa {icons_1}"></i>
                                <span>Chọn icon</span>
                            </div>
                            <input type="hidden" class="form-control" name="icons[]" value="{icons_1}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="titles[]" value="{titles_1}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Mô tả</label>
                            <input type="text" class="form-control" name="descs[]" value="{descs_1}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="box-number">2</div>
                        <div class="col-md-3">
                            <div class="icon-picker-btn" onclick="openIconPicker(this)">
                                <i class="fa {icons_2}"></i>
                                <span>Chọn icon</span>
                            </div>
                            <input type="hidden" class="form-control" name="icons[]" value="{icons_2}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="titles[]" value="{titles_2}">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="descs[]" value="{descs_2}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="box-number">3</div>
                        <div class="col-md-3">
                            <div class="icon-picker-btn" onclick="openIconPicker(this)">
                                <i class="fa {icons_3}"></i>
                                <span>Chọn icon</span>
                            </div>
                            <input type="hidden" class="form-control" name="icons[]" value="{icons_3}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="titles[]" value="{titles_3}">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="descs[]" value="{descs_3}">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="box-number">4</div>
                        <div class="col-md-3">
                            <div class="icon-picker-btn" onclick="openIconPicker(this)">
                                <i class="fa {icons_4}"></i>
                                <span>Chọn icon</span>
                            </div>
                            <input type="hidden" class="form-control" name="icons[]" value="{icons_4}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="titles[]" value="{titles_4}">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="descs[]" value="{descs_4}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="">Mô tả </label>
                        <textarea disabled name="description" class="form_control" placeholder="Nhập nội dung...">{description}</textarea>
                    </div>
                    <input type="hidden" name="id" value="{name}">
                    <button class="button_all" name="edit_setting_home_feature">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const faIcons = [
    // Web Application Icons
    'fa-adjust', 'fa-anchor', 'fa-archive', 'fa-area-chart', 'fa-arrows', 'fa-arrows-h', 'fa-arrows-v', 
    'fa-asterisk', 'fa-at', 'fa-automobile', 'fa-balance-scale', 'fa-ban', 'fa-bank', 'fa-bar-chart',
    'fa-bar-chart-o', 'fa-barcode', 'fa-bars', 'fa-bath', 'fa-bathtub', 'fa-battery', 'fa-battery-0',
    'fa-battery-1', 'fa-battery-2', 'fa-battery-3', 'fa-battery-4', 'fa-battery-empty', 'fa-battery-full',
    'fa-battery-half', 'fa-battery-quarter', 'fa-battery-three-quarters', 'fa-bed', 'fa-beer',
    'fa-bell', 'fa-bell-o', 'fa-bell-slash', 'fa-bell-slash-o', 'fa-bicycle', 'fa-binoculars',
    'fa-birthday-cake', 'fa-bluetooth', 'fa-bluetooth-b', 'fa-bolt', 'fa-bomb', 'fa-book',
    'fa-bookmark', 'fa-bookmark-o', 'fa-briefcase', 'fa-bug', 'fa-building', 'fa-building-o',
    'fa-bullhorn', 'fa-bullseye', 'fa-bus', 'fa-cab', 'fa-calculator', 'fa-calendar',
    'fa-calendar-check-o', 'fa-calendar-minus-o', 'fa-calendar-o', 'fa-calendar-plus-o',
    'fa-calendar-times-o', 'fa-camera', 'fa-camera-retro', 'fa-car', 'fa-caret-square-o-down',
    'fa-caret-square-o-left', 'fa-caret-square-o-right', 'fa-caret-square-o-up', 'fa-cart-arrow-down',
    'fa-cart-plus', 'fa-cc', 'fa-certificate', 'fa-check', 'fa-check-circle', 'fa-check-circle-o',
    'fa-check-square', 'fa-check-square-o', 'fa-child', 'fa-circle', 'fa-circle-o', 'fa-circle-o-notch',
    'fa-circle-thin', 'fa-clock-o', 'fa-clone', 'fa-close', 'fa-cloud', 'fa-cloud-download',
    'fa-cloud-upload', 'fa-code', 'fa-code-fork', 'fa-coffee', 'fa-cog', 'fa-cogs',
    'fa-comment', 'fa-comment-o', 'fa-commenting', 'fa-commenting-o', 'fa-comments', 'fa-comments-o',
    'fa-compass', 'fa-copyright', 'fa-creative-commons', 'fa-credit-card', 'fa-credit-card-alt',
    'fa-crop', 'fa-crosshairs', 'fa-cube', 'fa-cubes', 'fa-cutlery', 'fa-dashboard', 'fa-database',
    'fa-desktop', 'fa-diamond', 'fa-dot-circle-o', 'fa-download', 'fa-edit', 'fa-ellipsis-h',
    'fa-ellipsis-v', 'fa-envelope', 'fa-envelope-o', 'fa-envelope-square', 'fa-eraser',
    'fa-exchange', 'fa-exclamation', 'fa-exclamation-circle', 'fa-exclamation-triangle',
    'fa-external-link', 'fa-external-link-square', 'fa-eye', 'fa-eye-slash', 'fa-eyedropper',
    'fa-fax', 'fa-feed', 'fa-female', 'fa-fighter-jet', 'fa-file-archive-o', 'fa-file-audio-o',
    'fa-file-code-o', 'fa-file-excel-o', 'fa-file-image-o', 'fa-file-movie-o', 'fa-file-pdf-o',
    'fa-file-photo-o', 'fa-file-picture-o', 'fa-file-powerpoint-o', 'fa-file-sound-o',
    'fa-file-video-o', 'fa-file-word-o', 'fa-file-zip-o', 'fa-film', 'fa-filter', 'fa-fire',
    'fa-fire-extinguisher', 'fa-flag', 'fa-flag-checkered', 'fa-flag-o', 'fa-flash', 'fa-flask',
    'fa-folder', 'fa-folder-o', 'fa-folder-open', 'fa-folder-open-o', 'fa-frown-o', 'fa-futbol-o',
    'fa-gamepad', 'fa-gavel', 'fa-gear', 'fa-gears', 'fa-gift', 'fa-glass', 'fa-globe', 'fa-graduation-cap',
    'fa-group', 'fa-hand-grab-o', 'fa-hand-lizard-o', 'fa-hand-paper-o', 'fa-hand-peace-o',
    'fa-hand-pointer-o', 'fa-hand-rock-o', 'fa-hand-scissors-o', 'fa-hand-spock-o', 'fa-hand-stop-o',
    'fa-hashtag', 'fa-hdd-o', 'fa-headphones', 'fa-heart', 'fa-heart-o', 'fa-heartbeat',
    'fa-history', 'fa-home', 'fa-hotel', 'fa-hourglass', 'fa-hourglass-1', 'fa-hourglass-2',
    'fa-hourglass-3', 'fa-hourglass-end', 'fa-hourglass-half', 'fa-hourglass-o', 'fa-hourglass-start',
    'fa-i-cursor', 'fa-image', 'fa-inbox', 'fa-industry', 'fa-info', 'fa-info-circle', 'fa-institution',
    'fa-key', 'fa-keyboard-o', 'fa-language', 'fa-laptop', 'fa-leaf', 'fa-legal', 'fa-lemon-o',
    'fa-level-down', 'fa-level-up', 'fa-life-bouy', 'fa-life-buoy', 'fa-life-ring', 'fa-life-saver',
    'fa-lightbulb-o', 'fa-line-chart', 'fa-location-arrow', 'fa-lock', 'fa-magic', 'fa-magnet',
    'fa-mail-forward', 'fa-mail-reply', 'fa-mail-reply-all', 'fa-male', 'fa-map', 'fa-map-marker',
    'fa-map-o', 'fa-map-pin', 'fa-map-signs', 'fa-meh-o', 'fa-microphone', 'fa-microphone-slash',
    'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mobile', 'fa-mobile-phone',
    'fa-money', 'fa-moon-o', 'fa-mortar-board', 'fa-motorcycle', 'fa-mouse-pointer', 'fa-music',
    'fa-navicon', 'fa-newspaper-o', 'fa-object-group', 'fa-object-ungroup', 'fa-paint-brush',
    'fa-paper-plane', 'fa-paper-plane-o', 'fa-paw', 'fa-pencil', 'fa-pencil-square',
    'fa-pencil-square-o', 'fa-percent', 'fa-phone', 'fa-phone-square', 'fa-photo', 'fa-picture-o',
    'fa-pie-chart', 'fa-plane', 'fa-plug', 'fa-plus', 'fa-plus-circle', 'fa-plus-square',
    'fa-plus-square-o', 'fa-power-off', 'fa-print', 'fa-puzzle-piece', 'fa-qrcode', 'fa-question',
    'fa-question-circle', 'fa-question-circle-o', 'fa-quote-left', 'fa-quote-right', 'fa-random',
    'fa-recycle', 'fa-refresh', 'fa-registered', 'fa-remove', 'fa-reorder', 'fa-reply',
    'fa-reply-all', 'fa-retweet', 'fa-road', 'fa-rocket', 'fa-rss', 'fa-rss-square', 'fa-search',
    'fa-search-minus', 'fa-search-plus', 'fa-send', 'fa-send-o', 'fa-server', 'fa-share',
    'fa-share-alt', 'fa-share-alt-square', 'fa-share-square', 'fa-share-square-o', 'fa-shield',
    'fa-ship', 'fa-shopping-bag', 'fa-shopping-basket', 'fa-shopping-cart', 'fa-sign-in',
    'fa-sign-out', 'fa-signal', 'fa-sitemap', 'fa-sliders', 'fa-smile-o', 'fa-soccer-ball-o',
    'fa-sort', 'fa-sort-alpha-asc', 'fa-sort-alpha-desc', 'fa-sort-amount-asc', 'fa-sort-amount-desc',
    'fa-sort-asc', 'fa-sort-desc', 'fa-sort-down', 'fa-sort-numeric-asc', 'fa-sort-numeric-desc',
    'fa-sort-up', 'fa-space-shuttle', 'fa-spinner', 'fa-spoon', 'fa-square', 'fa-square-o',
    'fa-star', 'fa-star-half', 'fa-star-half-empty', 'fa-star-half-full', 'fa-star-half-o',
    'fa-star-o', 'fa-sticky-note', 'fa-sticky-note-o', 'fa-street-view', 'fa-suitcase',
    'fa-sun-o', 'fa-support', 'fa-tablet', 'fa-tachometer', 'fa-tag', 'fa-tags', 'fa-tasks',
    'fa-taxi', 'fa-television', 'fa-terminal', 'fa-thumb-tack', 'fa-thumbs-down', 'fa-thumbs-o-down',
    'fa-thumbs-o-up', 'fa-thumbs-up', 'fa-ticket', 'fa-times', 'fa-times-circle',
    'fa-times-circle-o', 'fa-tint', 'fa-toggle-down', 'fa-toggle-left', 'fa-toggle-off',
    'fa-toggle-on', 'fa-toggle-right', 'fa-toggle-up', 'fa-trademark', 'fa-trash', 'fa-trash-o',
    'fa-tree', 'fa-trophy', 'fa-truck', 'fa-tty', 'fa-tv', 'fa-umbrella', 'fa-university',
    'fa-unlock', 'fa-unlock-alt', 'fa-unsorted', 'fa-upload', 'fa-user', 'fa-user-plus',
    'fa-user-secret', 'fa-user-times', 'fa-users', 'fa-video-camera', 'fa-volume-down',
    'fa-volume-off', 'fa-volume-up', 'fa-warning', 'fa-wheelchair', 'fa-wifi', 'fa-wrench',
    'fa-ambulance', 'fa-automobile', 'fa-bicycle', 'fa-bus', 'fa-cab', 'fa-car', 'fa-fighter-jet',
    'fa-motorcycle', 'fa-plane', 'fa-rocket', 'fa-ship', 'fa-space-shuttle', 'fa-subway',
    'fa-taxi', 'fa-train', 'fa-truck', 'fa-wheelchair',
    'fa-genderless', 'fa-intersex', 'fa-mars', 'fa-mars-double', 'fa-mars-stroke',
    'fa-mars-stroke-h', 'fa-mars-stroke-v', 'fa-mercury', 'fa-neuter', 'fa-transgender',
    'fa-transgender-alt', 'fa-venus', 'fa-venus-double', 'fa-venus-mars',
    'fa-file', 'fa-file-archive-o', 'fa-file-audio-o', 'fa-file-code-o', 'fa-file-excel-o',
    'fa-file-image-o', 'fa-file-movie-o', 'fa-file-o', 'fa-file-pdf-o', 'fa-file-photo-o',
    'fa-file-picture-o', 'fa-file-powerpoint-o', 'fa-file-sound-o', 'fa-file-text',
    'fa-file-text-o', 'fa-file-video-o', 'fa-file-word-o', 'fa-file-zip-o',
    'fa-circle-o-notch', 'fa-cog', 'fa-gear', 'fa-refresh', 'fa-spinner',
    'fa-check-square', 'fa-check-square-o', 'fa-circle', 'fa-circle-o', 'fa-dot-circle-o',
    'fa-minus-square', 'fa-minus-square-o', 'fa-plus-square', 'fa-plus-square-o', 'fa-square',
    'fa-square-o',
    'fa-cc-amex', 'fa-cc-diners-club', 'fa-cc-discover', 'fa-cc-jcb', 'fa-cc-mastercard',
    'fa-cc-paypal', 'fa-cc-stripe', 'fa-cc-visa', 'fa-credit-card', 'fa-google-wallet',
    'fa-paypal',
    'fa-area-chart', 'fa-bar-chart', 'fa-bar-chart-o', 'fa-line-chart', 'fa-pie-chart',
    'fa-bitcoin', 'fa-btc', 'fa-cny', 'fa-dollar', 'fa-eur', 'fa-euro', 'fa-gbp', 'fa-gg',
    'fa-gg-circle', 'fa-ils', 'fa-inr', 'fa-jpy', 'fa-krw', 'fa-money', 'fa-rmb', 'fa-rouble',
    'fa-rub', 'fa-ruble', 'fa-rupee', 'fa-shekel', 'fa-sheqel', 'fa-try', 'fa-turkish-lira',
    'fa-usd', 'fa-won', 'fa-yen',
    'fa-align-center', 'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-bold',
    'fa-chain', 'fa-chain-broken', 'fa-clipboard', 'fa-columns', 'fa-copy', 'fa-cut',
    'fa-dedent', 'fa-eraser', 'fa-file', 'fa-file-o', 'fa-file-text', 'fa-file-text-o',
    'fa-files-o', 'fa-floppy-o', 'fa-font', 'fa-header', 'fa-indent', 'fa-italic',
    'fa-link', 'fa-list', 'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-outdent',
    'fa-paperclip', 'fa-paragraph', 'fa-paste', 'fa-repeat', 'fa-rotate-left',
    'fa-rotate-right', 'fa-save', 'fa-scissors', 'fa-strikethrough', 'fa-subscript',
    'fa-superscript', 'fa-table', 'fa-text-height', 'fa-text-width', 'fa-th', 'fa-th-large',
    'fa-th-list', 'fa-underline', 'fa-undo', 'fa-unlink',
    'fa-angle-double-down', 'fa-angle-double-left', 'fa-angle-double-right',
    'fa-angle-double-up', 'fa-angle-down', 'fa-angle-left', 'fa-angle-right',
    'fa-angle-up', 'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down',
    'fa-arrow-circle-o-left', 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-up',
    'fa-arrow-circle-right', 'fa-arrow-circle-up', 'fa-arrow-down', 'fa-arrow-left',
    'fa-arrow-right', 'fa-arrow-up', 'fa-arrows', 'fa-arrows-alt', 'fa-arrows-h',
    'fa-arrows-v', 'fa-caret-down', 'fa-caret-left', 'fa-caret-right', 'fa-caret-up',
    'fa-chevron-circle-down', 'fa-chevron-circle-left', 'fa-chevron-circle-right',
    'fa-chevron-circle-up', 'fa-chevron-down', 'fa-chevron-left', 'fa-chevron-right',
    'fa-chevron-up', 'fa-exchange', 'fa-hand-o-down', 'fa-hand-o-left', 'fa-hand-o-right',
    'fa-hand-o-up', 'fa-long-arrow-down', 'fa-long-arrow-left', 'fa-long-arrow-right',
    'fa-long-arrow-up'
];

let currentButton = null;

function openIconPicker(button) {
    currentButton = button;
    const modal = document.getElementById('iconPickerModal');
    const iconGrid = document.getElementById('iconGrid');
    const searchInput = document.querySelector('.icon-picker-search');

    iconGrid.innerHTML = '';

    faIcons.forEach(icon => {
        const iconItem = document.createElement('div');
        iconItem.className = 'icon-item';
        iconItem.innerHTML = `
            <i class="fa ${icon}"></i>
            <span>${icon}</span>
        `;
        iconItem.onclick = () => {
            const iconClass = icon;
            currentButton.querySelector('i').className = `fa ${iconClass}`;
            currentButton.nextElementSibling.value = iconClass;
            modal.style.display = 'none';
            currentButton = null;
        };
        iconGrid.appendChild(iconItem);
    });

    searchInput.value = ''; 
    searchInput.oninput = (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const iconItems = iconGrid.querySelectorAll('.icon-item');
        
        iconItems.forEach(item => {
            const iconName = item.querySelector('span').textContent;
            if (iconName.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    };
    
    modal.style.display = 'block';
}

window.onclick = function(event) {
    const modal = document.getElementById('iconPickerModal');
    if (event.target == modal) {
        modal.style.display = 'none';
        currentButton = null;
    }
}

document.querySelector('.close-modal').onclick = function() {
    document.getElementById('iconPickerModal').style.display = 'none';
    currentButton = null;
}
</script>