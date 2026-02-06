<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Mảng các ID được phép vào vùng Admin
$admin_roles = [1, 2, 3, 4, 5];

if (!isset($_SESSION['role_id']) || !in_array($_SESSION['role_id'], $admin_roles)) {
    // Nếu không có quyền, đuổi về trang login hoặc báo lỗi
    header("Location: login.php?error=access_denied");
    exit();
}
// Sử dụng đường dẫn tương đối để tránh lỗi trên Linux Server của InfinityFree
require_once dirname(__DIR__) . "/config.php";

// 2. Nạp db.php (Cùng nằm trong thư mục Models với file này)
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Customer.php";
$customerModel = new Customer();
// 2. XỬ LÝ AJAX POST TẠI ĐÂY (PHẢI ĐẶT TRƯỚC MỌI THẺ HTML)
// TÌM ĐOẠN XỬ LÝ AJAX POST Ở ĐẦU FILE VipVelations.php VÀ THAY BẰNG:

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type'])) {
    ob_clean();
    header('Content-Type: application/json');

    try {
        $action = $_POST['action_type'];

        // 1. LOGIC SỬA (GIỮ NGUYÊN CỦA BẠN)
        if ($action == 'save_customer') {
            $id = $_POST['id'] ?? null;
            $data = [
                'full_name'    => $_POST['full_name'],
                'email'        => $_POST['email'],
                'phone_number' => $_POST['phone'], // Bạn đang dùng phone_number ở Model
                'rank'         => $_POST['rank'],
                'bidding_limit' => $_POST['bidding_limit'],
                'avatar'       => $_POST['avatar']
            ];
            $result = $customerModel->update($id, $data);
        } else if ($action == 'portal_onboard') {
            $finalAvatar = '';

            // 1. Nhận dữ liệu
            $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $phone = !empty($_POST['phone_number']) ? trim($_POST['phone_number']) : null;

            // 2. Xử lý Đường dẫn File vật lý bằng __DIR__
            // __DIR__ là: D:\xampp\htdocs\License-plate-website_2\Admin
            // dirname(__DIR__) sẽ là: D:\xampp\htdocs\License-plate-website_2
            $baseDir = dirname(__DIR__);
            $uploadFolder = DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR;
            $absolutePath = $baseDir . $uploadFolder;

            // Kiểm tra và tạo thư mục nếu chưa tồn tại
            if (!is_dir($absolutePath)) {
                mkdir($absolutePath, 0777, true);
            }

            // Ưu tiên 1: Nếu có file upload thực tế
            if (isset($_FILES['avatar_file']) && $_FILES['avatar_file']['error'] == 0) {
                $fileName = time() . '_' . basename($_FILES['avatar_file']['name']);
                $targetFile = $absolutePath . $fileName;

                if (move_uploaded_file($_FILES['avatar_file']['tmp_name'], $targetFile)) {
                    // Lưu vào DB đường dẫn tương đối để hiển thị trên web
                    $finalAvatar = 'assets/uploads/avatars/' . $fileName;
                }
            }
            // Ưu tiên 2: Nếu không có file upload, lấy link ảnh mẫu (preset) hoặc mặc định
            else {
                $finalAvatar = !empty($_POST['avatar']) ? $_POST['avatar'] : 'https://i.pravatar.cc/150?u=' . time();
            }

            // 3. Chuẩn bị mảng data cho Model
            $data = [
                'full_name'     => $_POST['full_name'],
                'email'         => $email,
                'phone_number'  => $phone,
                'rank'          => ucfirst(strtolower($_POST['rank'])),
                'total_spent'   => (float)$_POST['deposit'],
                'bidding_limit' => (float)$_POST['deposit'] * 2,
                'avatar'        => $finalAvatar, // Đảm bảo cột trong DB tên là 'avatar'
                'password'      => '123456'
            ];

            // 4. Gọi hàm add trong model
            $result = $customerModel->add($data);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi SQL: Không thể thêm dữ liệu vào Database']);
            }
            exit();
        }

        echo json_encode(['success' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
        }

        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@400;700&display=swap');

        .font-serif {
            font-family: 'Cormorant+Garamond', serif;
        }

        .font-mono {
            font-family: 'Montserrat', sans-serif;
        }

        .animate-ticker {
            animation: ticker 30s linear infinite;
        }

        @keyframes ticker {
            0% {
                transform: translateX(10%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .pause-animate {
            animation-play-state: paused;
        }

        .privacy-blur {
            transition: filter 0.3s ease;
        }

        .privacy-blur.active {
            filter: blur(8px);
        }

        /* Hiệu ứng focus thanh search */
        #deep-search:focus~#search-suggestions {
            display: block;
        }

        /* Hiệu ứng khi di chuột vào từng mục gợi ý */
        .suggestion-item:hover {
            background-color: rgba(8, 145, 178, 0.1);
            border-left: 2px solid #0891B2;
        }

        /* Thêm hiệu ứng hover cho item để dễ nhìn */
        .suggestion-item {
            background: transparent;
            transition: all 0.2s;
        }

        #search-suggestions {
            z-index: 999999 !important;
            /* Đảm bảo cực cao */
            position: absolute;
            top: 100%;
            /* Luôn nằm dưới ô input */
            left: 0;
            right: 0;
            background: #0a0a0a;
            /* Nền tối đặc để không bị xuyên thấu */
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            display: none;
            /* Mặc định ẩn, JS sẽ điều khiển */
            margin-top: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Hiệu ứng tia sáng chạy quanh viền nút (Golden Pulse) */
        @keyframes pulse-gold {
            0% {
                box-shadow: 0 0 0 0 rgba(241, 196, 15, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(241, 196, 15, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(241, 196, 15, 0);
            }
        }

        .animate-pulse-gold {
            animation: pulse-gold 2s infinite;
        }

        /* Hiệu ứng Brushed Gold */
        .bg-brushed-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #F1C40F 50%, #C5A028 100%);
            background-size: 200% 200%;
        }

        /* Mobile Floating Action Button (FAB) */
        @media (max-width: 768px) {
            #add-vip-btn {
                position: fixed;
                bottom: 10px;
                right: 0px;
                z-index: 999;
                width: 45px;
                height: 45px;
                border-radius: 50%;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #add-vip-btn div {
                padding: 0;
                background: transparent;
                border: none;
                gap: 0;
            }

            #portal-content {
                height: 100vh;
                border-radius: 0;
                margin-top: 250%;
            }
        }

        /* Responsive cho Mobile */
        @media (max-width: 768px) {
            #vip-header {
                top: 0;
                left: 7px;
                right: 0;
            }

            .header-container {
                border-radius: 0 0 1.5rem 1.5rem;
                border-top: none;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Card Styles */
        .diamond-card {
            background: radial-gradient(circle at top left, #1a1a1a, #000);
        }

        .gold-card {
            background: linear-gradient(135deg, #1a120b 0%, #000 100%);
        }

        /* Metallic Badges */
        .rank-badge {
            padding: 4px 10px;
            border-radius: 4px;
        }

        .diamond-badge {
            background: linear-gradient(90deg, #e2e8f0, #94a3b8);
            color: #0f172a;
            border-color: #fff;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }

        .gold-badge {
            background: linear-gradient(90deg, #F1C40F, #D4AC0D);
            color: #000;
            border-color: #fde68a;
        }

        /* Online Border Flow */
        .online-flow {
            position: absolute;
            inset: 0;
            /* Thay vì -2px nếu nó làm card bị to ra */
            pointer-events: none;
            z-index: 5;
            border-radius: 1.5rem;
            padding: 2px;
            background: conic-gradient(from 0deg, transparent 70%, #0891B2);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }

        .diamond-card .online-flow {
            display: block;
        }



        @keyframes rotate-border {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }


        /* Ghost Overlay (Phần phản biện bảo mật) */
        .ghost-info.blurred {
            filter: blur(6px);
            opacity: 0.5;
            transition: all 0.5s ease;
        }

        /* Compare Mode Layout */
        .comparing {
            transform: scale(1.05);
            z-index: 50;
            border-color: #0891B2 !important;
            box-shadow: 0 0 40px rgba(8, 145, 178, 0.3);
        }

        @media (max-width: 768px) {
            #elite-grid {
                margin-left: 0% !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            #member-masonry {
                grid-template-columns: 1fr !important;
                /* Ép về 1 cột duy nhất */
                gap: 1rem !important;
                margin-left: 0 !important;
            }
        }

        /* Hiệu ứng rung khung khi Reject */
        .shake-error {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }

        #reject-modal.show {
            display: flex !important;
        }

        /* css dưới section 2  */
        /* Glass-to-Steel Effect */
        .vip-input:focus {
            background: linear-gradient(145deg, #111, #222);
            border-bottom-color: #D4AF37;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.1);
        }

        /* Thanh trượt Slider Gold */
        input[type=range] {
            height: 4px;
            -webkit-appearance: none;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #D4AF37;
            cursor: pointer;
            box-shadow: 0 0 10px #D4AF37;
        }

        /* --- HIỆU ỨNG RIÊNG CHO DIAMOND --- */
        .member-card-wrapper[data-rank="diamond"] .member-card::before {
            background: linear-gradient(45deg, transparent, rgba(8, 145, 178, 0.3), transparent);
            animation: shine-diamond 4s infinite;
        }

        /* --- ĐỊNH NGHĨA 2 CHUYỂN ĐỘNG KHÁC NHAU --- */
        @keyframes shine-diamond {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            20%,
            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        /* Hiệu ứng viền vàng chạy khi hover dành riêng cho Gold */
        .member-card-wrapper[data-rank="gold"]:hover .member-card {
            border-color: #D4AF37 !important;
            /* box-shadow: 0 0 30px rgba(212, 175, 55, 0.2) !important; */
            background: rgba(255, 255, 255, 0.05);

        }

        .member-card-wrapper[data-rank="gold"]:hover .member-card::before {
            animation-duration: 1.5s;
            /* Khi hover thì ánh sáng quét nhanh hơn như một phản hồi */
        }

        /* Hiệu ứng hover cho thẻ thành viên nói chung (dùng cho ALL) */
        .member-card-wrapper:hover .member-card {
            border-color: rgba(255, 255, 255, 0.4) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.05) !important;
            transform: translateY(-5px);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }



        .member-card-wrapper {
            width: 100%;
            /* Đảm bảo thẻ luôn nằm trong grid */
            max-width: 100%;
        }

        .member-card {
            position: relative;
            overflow: hidden;
            /* Để hiệu ứng shine-diamond không tràn ra ngoài */
        }

        .member-card-wrapper[data-rank="diamond"]:hover .member-card {
            border-color: #22d3ee !important;
            /* border-color: #f06915 !important; */

            /* box-shadow: 0 0 30px rgba(6, 182, 212, 0.2) !important; */
            background: rgba(255, 255, 255, 0.05);
        }

        /* Hiệu ứng chữ vàng phát sáng nhẹ */
        .member-card-wrapper[data-rank="gold"] h3 {
            transition: color 0.3s;
        }

        .member-card-wrapper[data-rank="gold"]:hover h3 {
            color: #F1C40F;
            text-shadow: 0 0 10px rgba(241, 196, 15, 0.3);
        }

        /* Hiệu ứng quét sáng riêng cho hạng Gold */
        /* Hiệu ứng quét sáng của Gold (Vàng Champagne) */
        @keyframes shine-gold {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            25%,
            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        /* Hiệu ứng viền bạch kim chạy khi hover dành riêng cho Platinum */
        .member-card-wrapper[data-rank="platinum"]:hover .member-card {
            border-color: #E5E4E2 !important;
            /* Màu bạch kim */
            box-shadow: 0 0 30px rgba(229, 228, 226, 0.25) !important;
            /* Đổ bóng ánh bạc sáng */
            /* Tăng độ sáng nền một chút khi hover */
        }

        .member-card-wrapper[data-rank="platinum"]:hover .member-card::before {
            animation-duration: 1.2s;
            /* Platinum thường tạo cảm giác nhanh và nhạy hơn Gold nên để 1.2s */

        }

        /* Hiệu ứng ánh sáng kim loại (Shimmer) riêng cho Platinum */
        .member-card-wrapper[data-rank="platinum"] .member-card {

            position: relative;
            overflow: hidden;
        }

        /* Thêm lớp phản chiếu ánh sáng trắng khi hover để tăng tính kim loại */
        .member-card-wrapper[data-rank="platinum"]:hover .member-card::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent 45%,
                    rgba(255, 255, 255, 0.1) 50%,
                    transparent 55%);
            transform: rotate(30deg);
            transition: all 0.5s;
            animation: shine-platinum 3s infinite;
        }

        @keyframes shine-platinum {
            0% {
                transform: translate(-100%, -100%) rotate(30deg);
            }

            100% {
                transform: translate(100%, 100%) rotate(30deg);
            }
        }

        /* --- Cấu hình chung cho lớp giả tạo ánh sáng --- */
        .member-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            transform: rotate(45deg);
            pointer-events: none;
            z-index: 1;
            /* Nằm dưới z-10 của nội dung */
        }

        /* --- HIỆU ỨNG CHO HẠNG GOLD (VÀNG CHAMPAGNE) --- */
        .member-card-wrapper[data-rank="gold"] .member-card::before {
            background: linear-gradient(45deg, transparent, rgba(212, 175, 55, 0.4), rgba(241, 196, 15, 0.6), transparent);

            animation: shine-gold 5s infinite;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #editor-container {
                max-height: 100vh;
                border-radius: 0;
            }

            .input-field-group {
                margin-bottom: 1.5rem;
            }

            /* 1. Cho phép cuộn ngang thanh bộ lọc trên Mobile */
            #member-filters {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 8px;
                -webkit-overflow-scrolling: touch;
                gap: 0.5rem;
                scrollbar-width: none;
                /* Ẩn scrollbar cho Firefox */
            }

            #member-filters::-webkit-scrollbar {
                display: none;
                /* Ẩn scrollbar cho Chrome/Safari */
            }

            /* 2. Cấu trúc lại lưới (Grid) hiển thị thẻ */
            .members-grid {
                display: grid;
                grid-template-columns: 1fr !important;
                /* Mobile hiện 1 cột duy nhất */
                gap: 1.5rem !important;
            }

            /* 3. Tối ưu lại padding cho container */
            .section-2-container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            /* 4. Điều chỉnh kích thước văn bản tiêu đề Section 2 */
            .section-2-header h2 {
                font-size: 1.5rem !important;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {

            /* Tablet: Hiện 2 cột */
            .members-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        @media (min-width: 1025px) {

            /* Desktop: Hiện 3 cột (hoặc 4 tùy bạn chỉnh) */
            .members-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }




        /* ----------------------------- section 3 -----------------------------  */
        /* Paper Mode */
        .paper-active #evidence-pane {
            background: #f4f1ea !important;
            transition: all 0.5s ease;
        }

        .paper-active #evidence-pane * {
            color: #2d2d2d !important;
            border-color: rgba(0, 0, 0, 0.1) !important;
        }

        .paper-active .evidence-card {
            filter: sepia(0.3) contrast(1.1);
        }

        /* Stamp Effect */
        .stamp-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(5);
            opacity: 0;
            z-index: 100;
            pointer-events: none;
        }

        /* Laser Line Animation */
        @keyframes laserMove {
            0% {
                top: 0;
                opacity: 1;
            }

            100% {
                top: 100%;
                opacity: 0;
            }
        }

        /* Ghost Comparison */
        #selfie-card {
            z-index: 30;
            transition: opacity 0.3s;
        }

        #selfie-card:active {
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 1280px) {
            #kyc-vault {
                height: auto;
            }

            #evidence-pane {
                min-height: 500px;
            }
        }

        /* Responsive cho Mobile */
        @media (max-width: 768px) {
            #kyc-vault {
                margin-left: 0% !important;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */
        /* Keyword Pills */
        .keyword-pill {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 8px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .keyword-pill:hover {
            background: rgba(8, 145, 178, 0.2);
            border-color: #0891B2;
            transform: translateY(-2px);
        }

        /* Heartbeat Animation */
        .heart-beat {
            animation: heartBeat 1.2s infinite;
        }

        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            15% {
                transform: scale(1.3);
            }

            30% {
                transform: scale(1);
            }

            45% {
                transform: scale(1.15);
            }

            60% {
                transform: scale(1);
            }
        }

        /* Custom Scrollbar for Queue */
        .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Neural Lines Effect (Simulation) */
        .neural-glow {
            box-shadow: 0 0 30px rgba(8, 145, 178, 0.6) !important;
            border-color: #0891B2 !important;
            transition: all 0.5s;
        }

        /* Ghost Notification Style */
        .ghost-notif {
            background: rgba(10, 17, 36, 0.9);
            backdrop-blur: 10px;
            border: 1px solid rgba(8, 145, 178, 0.3);
            padding: 12px 20px;
            border-radius: 12px;
            color: white;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .time-pill.active {
            background-color: rgba(6, 182, 212, 0.2);
            /* bg-cyan-500/20 */
            color: #22d3ee;
            /* text-cyan-400 */
        }

        .time-pill:not(.active) {
            background-color: transparent;
            color: rgba(255, 255, 255, 0.3);
            /* text-white/30 */
        }

        /* Responsive cho Mobile */
        @media (max-width: 768px) {
            #vip-pulse {
                margin-left: 0% !important;
            }
        }

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>
    <main class="transition-all duration-300 ml-0 lg:ml-[230px] min-h-screen overflow-x-hidden" id="main-content">
        <!-- ----------------------------- section 1 -----------------------------  -->
        <header id="vip-header" class="fixed top-0 md:top-4 right-0 md:right-4 left-0 md:left-20 lg:left-24 z-[100] transition-all duration-500 mt-2 ms-1 md:mt-0 md:ms-0" style="margin-left: 13%;">
            <div class="header-container relative bg-black/80 md:bg-black/60 backdrop-blur-2xl border-b md:border border-white/10 rounded-none md:rounded-[2rem] p-3 md:px-8 md:py-4 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">

                <div id="liquid-track" class="absolute bottom-0 left-0 h-[2px] w-0 transition-all duration-500 z-20"></div>

                <div class="flex items-center justify-between gap-2 md:gap-6 relative z-10">

                    <div class="flex items-center gap-3 md:gap-6">
                        <div class="identity-group">
                            <h1 class="text-lg md:text-2xl font-serif tracking-[1px] text-[#F1C40F] leading-none">
                                VIP <span class="hidden sm:inline font-light italic text-white/90">RELATIONS</span>
                            </h1>
                            <p class="text-[7px] md:text-[9px] font-mono tracking-[2px] text-white/30 uppercase mt-1">Concierge</p>
                        </div>

                        <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-full border border-white/5">
                            <div class="w-2 h-2 bg-[#0891B2] rounded-full shadow-[0_0_10px_#0891B2] animate-pulse"></div>
                            <span class="text-[10px] font-bold text-[#0891B2] font-mono">12 <span class="hidden xs:inline">VVIP</span></span>
                        </div>
                    </div>

                    <div class="wealth-ticker hidden lg:flex items-center gap-6 bg-white/5 px-6 py-2 rounded-xl border border-white/5 max-w-xs xl:max-w-md overflow-hidden relative group">
                        <div class="ticker-content flex items-center gap-6 whitespace-nowrap animate-ticker">
                            <div class="flex flex-col">
                                <span class="text-[7px] uppercase text-white/30 tracking-widest">Available</span>
                                <span class="text-xs font-bold text-white font-mono privacy-blur">$842M</span>
                            </div>
                            <div class="flex flex-col border-l border-white/10 pl-6">
                                <span class="text-[7px] uppercase text-white/30 tracking-widest">Avg. Auction</span>
                                <span class="text-xs font-bold text-[#F1C40F] font-mono privacy-blur">$1.5M</span>
                            </div>
                        </div>
                        <button onclick="togglePrivacy()" class="ml-2 text-white/20 hover:text-white"><i class="ri-eye-line text-xs"></i></button>
                    </div>

                    <div class="flex items-center gap-6 md:gap-12 flex-1 justify-end md:flex-none">
                        <div class="relative group flex-5 md:flex-none">
                            <i class="ri-search-2-line absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
                            <input type="text" id="deep-search" autocomplete="off" placeholder="Search..."
                                class="bg-white/5 border border-white/10 rounded-lg md:rounded-xl py-2 pl-9 pr-3 text-[11px] text-white focus:outline-none focus:ring-1 focus:ring-[#0891B2] w-full md:w-[180px] lg:w-[240px] transition-all">

                            <div id="search-suggestions" class="absolute top-[120%] left-[-50px] md:left-0 right-0 w-[250px] md:w-full rounded-xl overflow-hidden shadow-2xl hidden z-50">
                                <div class="p-2 text-[9px] text-white/40 border-b border-white/5 uppercase font-bold bg-black">Intelligence Results</div>

                                <div id="suggestions-list" class="max-h-[300px] overflow-y-auto custom-scrollbar bg-black">
                                </div>
                            </div>
                        </div>

                        <div class="relative ml-4">
                            <button onclick="openVipPortal()" id="add-vip-btn" class="group relative overflow-hidden bg-gradient-to-br from-[#D4AF37] via-[#F1C40F] to-[#C5A028] p-[1px] rounded-xl shadow-[0_0_20px_rgba(241,196,15,0.2)] hover:shadow-[0_0_30px_rgba(241,196,15,0.4)] transition-all duration-500">
                                <div class="bg-black/20 backdrop-blur-sm px-4 py-2 md:px-6 md:py-2.5 rounded-[11px] flex items-center gap-3 border border-white/10 group-active:scale-95 transition-transform">
                                    <div class="relative w-5 h-5 flex items-center justify-center">
                                        <i class="ri-add-line text-black font-bold text-lg transition-all duration-500 group-hover:opacity-0 group-hover:rotate-180"></i>
                                        <i class="ri-vip-crown-fill text-black absolute opacity-0 scale-50 transition-all duration-500 group-hover:opacity-100 group-hover:scale-100"></i>
                                    </div>
                                    <span class="hidden sm:inline text-black font-bold text-[10px] tracking-[2px] uppercase">Add New VIP</span>
                                    <span class="sm:hidden text-black font-bold text-[10px]">VIP</span>
                                </div>
                                <div class="absolute inset-0 rounded-xl border border-[#F1C40F] animate-pulse-gold opacity-50"></div>
                            </button>
                        </div>

                        <div id="vip-portal" class="fixed inset-0 z-[1000] hidden" style="margin-top: 25%;">
                            <div id="portal-bg" class="absolute inset-0 bg-black/90 backdrop-blur-xl translate-y-[-100%] transition-transform duration-700 ease-in-out"></div>

                            <div class="relative h-full flex items-center justify-center p-4">
                                <div id="portal-content" class="w-full max-w-4xl bg-[#0a0a0a] border border-[#D4AF37]/30 rounded-[2.5rem] overflow-hidden shadow-[0_0_100px_rgba(212,175,55,0.1)] opacity-0 translate-y-10">

                                    <div class="p-8 border-b border-white/5 flex justify-between items-center bg-gradient-to-r from-[#D4AF37]/5 to-transparent">
                                        <div>
                                            <h2 class="text-[#D4AF37] font-mono text-[10px] tracking-[5px] uppercase">Portal Access</h2>
                                            <h1 class="text-2xl text-white font-light mt-1">THE VIP <span class="font-bold">ONBOARDING</span></h1>
                                        </div>
                                        <button onclick="closeVipPortal()" class="text-white/20 hover:text-white transition-colors"><i class="ri-close-line text-3xl"></i></button>
                                    </div>

                                    <div class="p-8 md:p-12 overflow-y-auto max-h-[70vh] custom-scrollbar">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                                            <div class="space-y-6 portal-field">
                                                <div class="group mb-6">
                                                    <label class="text-[9px] text-white/30 uppercase block mb-2">Customer Full Name</label>
                                                    <input type="text" id="portal-fullname" placeholder="Nhập họ và tên..." class="w-full bg-white/5 border-b border-white/10 py-3 text-white focus:outline-none focus:border-[#D4AF37] transition-all font-light">
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="group">
                                                        <label class="text-[9px] text-[#D4AF37] uppercase tracking-widest block mb-2">Email Address</label>
                                                        <input type="email" id="portal-email" placeholder="example@gmail.com" class="w-full bg-white/5 border-b border-white/10 py-3 text-white focus:outline-none focus:border-[#D4AF37] transition-all font-light">
                                                    </div>
                                                    <div class="group">
                                                        <label class="text-[9px] text-[#D4AF37] uppercase tracking-widest block mb-2">Phone Number</label>
                                                        <input type="text" id="portal-phone" placeholder="09xxxxxxx" class="w-full bg-white/5 border-b border-white/10 py-3 text-white focus:outline-none focus:border-[#D4AF37] transition-all font-light">
                                                    </div>
                                                </div>

                                                <div class="group">
                                                    <label class="text-[9px] text-white/30 uppercase block mb-2">Initial Deposit (VND)</label>
                                                    <input type="number" id="deposit-input" oninput="predictRank(this.value)" placeholder="Amount..." class="w-full bg-white/5 border-b border-white/10 py-3 text-2xl text-[#F1C40F] font-mono focus:outline-none transition-all">
                                                    <p id="money-text" class="text-[10px] text-white/40 italic mt-2">Đang chờ nhập liệu...</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6 portal-field">
                                                <div class="p-6 bg-white/5 rounded-2xl border border-white/5 relative overflow-hidden group">
                                                    <label class="text-[9px] text-white/30 uppercase block mb-4">Identity Visualization (Avatar)</label>
                                                    <div class="flex items-center gap-6">
                                                        <div class="relative">
                                                            <img id="avatar-preview" src="https://i.pravatar.cc/150?u=new" class="w-20 h-20 rounded-full border-2 border-[#D4AF37] object-cover shadow-lg shadow-[#D4AF37]/20">
                                                            <label for="avatar-upload" class="absolute bottom-0 right-0 w-7 h-7 bg-[#D4AF37] rounded-full flex items-center justify-center cursor-pointer hover:bg-white transition-all shadow-md">
                                                                <i class="ri-camera-line text-black text-xs"></i>
                                                                <input type="file" id="avatar-upload" class="hidden" accept="image/*" onchange="previewUpload(this)">
                                                            </label>
                                                        </div>
                                                        <div class="flex-1">
                                                            <p class="text-[10px] text-white/40 mb-3 italic">Chọn nhận diện nhanh:</p>
                                                            <div class="flex gap-2">
                                                                <img onclick="selectPresetAvatar(this.src)" src="https://i.pravatar.cc/150?u=1" class="w-8 h-8 rounded-full cursor-pointer border border-transparent hover:border-[#D4AF37] transition-all">
                                                                <img onclick="selectPresetAvatar(this.src)" src="https://i.pravatar.cc/150?u=2" class="w-8 h-8 rounded-full cursor-pointer border border-transparent hover:border-[#D4AF37] transition-all">
                                                                <img onclick="selectPresetAvatar(this.src)" src="https://i.pravatar.cc/150?u=3" class="w-8 h-8 rounded-full cursor-pointer border border-transparent hover:border-[#D4AF37] transition-all">
                                                                <div onclick="document.getElementById('avatar-upload').click()" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center cursor-pointer hover:bg-white/10">
                                                                    <i class="ri-add-line text-white/50"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                                                    <label class="text-[9px] text-white/30 uppercase block mb-4">Predicted Rank</label>
                                                    <div id="rank-display" class="flex items-center gap-4">
                                                        <div class="w-12 h-12 rounded-full border-2 border-white/10 flex items-center justify-center grayscale opacity-30 transition-all duration-500" id="rank-icon">
                                                            <i class="ri-vip-diamond-line text-2xl"></i>
                                                        </div>
                                                        <span id="rank-name" class="text-white/20 font-bold tracking-widest uppercase">Awaiting Data</span>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="text-[9px] text-white/30 uppercase block mb-3">Special Interests</label>
                                                    <div class="flex flex-wrap gap-2">
                                                        <span class="px-3 py-1 rounded-full border border-white/10 text-[9px] text-white/50 cursor-pointer hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all">PHONG THUỶ</span>
                                                        <span class="px-3 py-1 rounded-full border border-white/10 text-[9px] text-white/50 cursor-pointer hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all">BIỂN SẢNH</span>
                                                        <span class="px-3 py-1 rounded-full border border-white/10 text-[9px] text-white/50 cursor-pointer hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all">ĐUÔI 99</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-12 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 portal-field">
                                            <div class="flex items-center gap-3">
                                                <input type="checkbox" id="welcome-invite" class="accent-[#D4AF37]">
                                                <label for="welcome-invite" class="text-[10px] text-white/60 uppercase tracking-widest cursor-pointer">Send Welcome Invitation</label>
                                            </div>
                                            <button onclick="finalizePortalRegistration()" class="w-full md:w-auto px-10 py-4 bg-[#D4AF37] text-black font-black text-xs uppercase tracking-[4px] rounded-xl hover:bg-[#F1C40F] transition-all shadow-lg shadow-[#D4AF37]/20">
                                                Finalize Registration
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="focus-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] opacity-0 pointer-events-none transition-opacity duration-500"></div>

        <!-- ----------------------------- section 2 -----------------------------  -->
        <section id="elite-grid" class="pt-32 pb-20 px-4 md:px-8 transition-all duration-500 ml-0 md:left-20 lg:ml-24 ml-0 md:ml-[17%]">

            <div class="flex flex-wrap items-center justify-between mb-10 gap-4 relative z-20">
                <div class="flex gap-2" id="member-filters">
                    <button onclick="filterMembers('all', this)"
                        class="filter-btn active px-4 py-2 bg-white/10 border border-white/40 rounded-full text-[10px] font-bold text-white transition-all shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                        ALL MEMBERS
                    </button>
                    <button onclick="filterMembers('gold', this)" class="filter-btn px-4 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold text-white/60 hover:text-[#D4AF37] hover:border-[#D4AF37]/50 transition-all">
                        GOLD MEMBERS
                    </button>
                    <button onclick="filterMembers('diamond', this)" class="filter-btn px-4 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold text-white/60 hover:text-cyan-400 hover:border-cyan-400/50 transition-all">
                        DIAMOND CLUB
                    </button>
                    <button onclick="filterMembers('platinum', this)"
                        class="filter-btn px-4 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold text-white/60 hover:text-[#E5E4E2] hover:border-[#E5E4E2]/50 hover:bg-[#E5E4E2]/5 transition-all">
                        PLATINUM CLUB
                    </button>
                </div>
                <div id="compare-mode-indicator" class="hidden items-center gap-3 bg-[#0891B2]/20 border border-[#0891B2]/50 px-4 py-2 rounded-full">
                    <span class="text-[10px] text-cyan-400 font-bold animate-pulse">COMPARE MODE ACTIVE</span>
                    <button onclick="exitCompareMode()" class="text-white hover:text-rose-500"><i class="ri-close-circle-fill"></i></button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="member-masonry">
                <?php

                // 1. Cấu hình phân trang
                $limit = 8; // Số lượng khách hàng mỗi trang
                $page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
                $keyword = isset($_GET['search']) ? $_GET['search'] : null;

                // 2. Lấy dữ liệu theo trang và từ khóa
                $customers = $customerModel->get($keyword, $page, $limit);
                $totalRecords = $customerModel->countTotal($keyword);
                $totalPages = ceil($totalRecords / $limit);

                // 3. Xử lý Search AJAX (Nếu có)
                if (isset($_GET['search']) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                    $results = $customerModel->get($_GET['search'], 1, 20);
                    echo json_encode($results);
                    exit;
                }

                ?>
                <?php if (count($customers) > 0): ?>
                    <?php foreach ($customers as $customer): ?>
                        <?= $customerModel->renderVipCard($customer); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white/30 col-span-full text-center py-10">No members found.</p>
                <?php endif; ?>


                <style>
                    @keyframes shimmer {
                        100% {
                            transform: translateX(100%);
                        }
                    }
                </style>
            </div>
            <div class="mt-12 flex justify-center items-center gap-2 ">
                <?php if ($page > 1): ?>
                    <a href="?p=<?= $page - 1 ?><?= $keyword ? "&search=$keyword" : "" ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-white hover:bg-cyan-500/20 hover:border-cyan-500/50 transition-all">
                        <i class="ri-arrow-left-s-line"></i>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?p=<?= $i ?><?= $keyword ? "&search=$keyword" : "" ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-xl border transition-all <?= $i == $page ? 'bg-cyan-500 border-cyan-500 text-white shadow-[0_0_15px_rgba(6,182,212,0.4)]' : 'bg-white/5 border-white/10 text-white/60 hover:border-white/30' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?p=<?= $page + 1 ?><?= $keyword ? "&search=$keyword" : "" ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-white hover:bg-cyan-500/20 hover:border-cyan-500/50 transition-all">
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                <?php endif; ?>
            </div>

            <p class="text-center text-white/20 text-[10px] mt-4 uppercase tracking-[2px]">
                Showing <?= count($customers) ?> of <?= $totalRecords ?> Elite Members
            </p>
        </section>
        <div id="vip-editor-overlay" class="fixed inset-0 z-[2000] hidden items-center justify-center p-0 md:p-10">
            <div id="editor-bg" class="absolute inset-0 bg-black/95 backdrop-blur-md opacity-0"></div>

            <div id="editor-container" class="relative w-full max-w-7xl h-full md:h-auto md:max-h-[90vh] bg-[#0a0a0a] rounded-none md:rounded-[2.5rem] border-x-0 md:border border-white/10 overflow-hidden opacity-0 scale-50 flex flex-col">

                <input type="hidden" id="editor-customer-id" value="">
                <input type="hidden" id="editor-rank-value" value="">
                <input type="hidden" id="editor-avatar-url" value="">
                <div class="p-4 md:p-6 border-b border-white/5 flex justify-between items-center bg-gradient-to-r from-white/5 to-transparent">
                    <div class="flex items-center gap-2 md:gap-4">
                        <div id="editor-rank-badge" class="px-2 py-1 rounded-full text-[3px] md:text-[9px] font-bold tracking-widest border">GOLD MEMBER</div>
                        <h2 class="text-white/40 font-mono text-[8px] md:text-[10px] tracking-widest uppercase truncate max-w-[120px] md:max-w-none">
                            Intelligence / <span id="editor-client-id" class="text-white">NEW</span>
                        </h2>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3">
                        <button onclick="toggleEditMode()" id="edit-mode-btn" class="flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-white/5 border border-white/10 text-white/60 text-[8px] md:text-[10px] uppercase font-bold transition-all">
                            <i class="ri-pencil-line"></i> <span class="hidden sm:inline">Enter Edit Mode</span>
                        </button>
                        <button onclick="closeVipEditor()" class="p-1 text-white/20 hover:text-white transition-colors"><i class="ri-close-circle-line text-xl md:text-2xl"></i></button>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row flex-1 overflow-y-auto custom-scrollbar">
                    <div class="w-full md:w-1/4 p-6 md:p-8 border-b md:border-b-0 md:border-r border-white/5 flex flex-row md:flex-col items-center gap-4 md:gap-6">
                        <div class="relative group cursor-pointer">
                            <div class="w-24 h-24 md:w-48 md:h-48 rounded-full border-2 md:border-4 border-[#D4AF37]/30 overflow-hidden relative">
                                <img id="editor-avatar" src="https://i.pravatar.cc/150" class="w-full h-full object-cover grayscale transition-all">
                            </div>
                        </div>
                        <div class="text-left md:text-center">
                            <h3 id="editor-name-display" class="text-lg md:text-2xl text-white font-light tracking-tight">VIP CLIENT</h3>
                            <p class="text-[8px] md:text-[10px] text-white/30 uppercase mt-1">Status: Active</p>
                        </div>
                    </div>

                    <div class="flex-1 p-6 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-10 pb-48 md:pb-40">
                        <div class="space-y-6 md:space-y-8">
                            <h4 class="text-[9px] md:text-[10px] text-[#D4AF37] font-bold uppercase tracking-[4px]">Basic Intelligence</h4>
                            <div class="space-y-4">
                                <div class="input-field-group">
                                    <label class="text-[9px] text-white/30 uppercase">Full Identity</label>
                                    <input type="text" id="editor-full-name" placeholder="Enter name..." readonly class="vip-input w-full bg-transparent border-b border-white/10 py-2 text-white outline-none focus:border-[#D4AF37] transition-colors">
                                </div>
                                <div class="input-field-group">
                                    <label class="text-[9px] text-white/30 uppercase">Email Secure</label>
                                    <input type="email" id="editor-email" placeholder="email@example.com" readonly class="vip-input w-full bg-transparent border-b border-white/10 py-2 text-white outline-none focus:border-[#D4AF37] transition-colors">
                                </div>
                                <div class="input-field-group">
                                    <label class="text-[9px] text-white/30 uppercase">Secure Contact</label>
                                    <input type="text" id="editor-phone" placeholder="+84..." readonly class="vip-input w-full bg-transparent border-b border-white/10 py-2 text-white outline-none focus:border-[#D4AF37] transition-colors">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 md:space-y-8">
                            <h4 class="text-[9px] md:text-[10px] text-cyan-400 font-bold uppercase tracking-[4px]">Financial Matrix</h4>
                            <div class="p-4 md:p-6 bg-white/5 rounded-2xl border border-white/5">
                                <label class="text-[9px] text-white/30 uppercase block mb-4">Bidding Limit</label>
                                <input type="range" id="editor-limit-range" class="w-full accent-[#D4AF37]" min="0" max="100000000000" step="1000000000" oninput="updateLimitText(this.value)">
                                <div class="flex justify-between mt-2 font-mono text-[10px] md:text-xs text-cyan-400">
                                    <span>0</span>
                                    <span id="editor-limit-text">0B VND</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 bg-[#0a0a0a]/90 backdrop-blur-md border-t border-white/10 flex justify-between items-center z-10">
                    <button class="text-rose-900/60 hover:text-rose-500 text-[8px] md:text-[10px] font-bold uppercase tracking-widest transition-all">Suspend Account</button>
                    <div class="flex gap-2 md:gap-4">
                        <button onclick="closeVipEditor()" class="px-4 py-2 md:px-6 md:py-3 text-white/40 text-[8px] md:text-[10px] font-bold uppercase">Discard</button>
                        <button onclick="saveAndEncrypt()" class="px-5 py-2 md:px-8 md:py-3 bg-[#D4AF37] text-black rounded-lg text-[8px] md:text-[10px] font-black uppercase tracking-[1px] md:tracking-[2px] hover:bg-white transition-all">Save Matrix</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ----------------------------- section 3 -----------------------------  -->
        <section id="kyc-vault" class="min-h-screen pt-20 pb-10 px-4 md:px-8 transition-all duration-500 ml-0 md:ml-20 lg:ml-24">

            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end border-b border-cyan-500/20 pb-6 md:pb-4 gap-6 md:gap-0">
                <div class="w-full md:w-auto">
                    <h2 class="text-[#0891B2] font-mono text-[9px] md:text-xs tracking-[2px] md:tracking-[4px] uppercase mb-2">
                        // Forensic Audit Mode
                    </h2>

                    <div class="flex flex-wrap items-center gap-3 md:gap-4">
                        <h1 class="text-xl md:text-2xl text-white font-bold tracking-tight">
                            Verification Vault
                        </h1>

                        <span class="bg-rose-500/20 text-rose-500 text-[8px] md:text-[10px] px-2 md:px-3 py-1 rounded-full border border-rose-500/30 animate-pulse flex items-center gap-1 shrink-0">
                            <i class="ri-error-warning-line"></i> 3 URGENT QUEUE
                        </span>
                    </div>
                </div>

                <div class="flex w-full md:w-auto justify-end">
                    <div id="paper-mode-toggle" onclick="togglePaperMode()"
                        class="cursor-pointer group flex items-center gap-2 bg-white/5 border border-white/10 px-3 py-2 md:px-4 md:py-2 rounded-lg hover:bg-white/10 transition-all w-full md:w-auto justify-center md:justify-start">
                        <i class="ri-eye-line text-cyan-400"></i>
                        <span class="text-[9px] md:text-[10px] text-white/60 font-bold uppercase tracking-widest">Paper Mode</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-6 h-auto xl:h-[750px]">

                <div class="flex-1 bg-black/40 border border-white/5 rounded-2xl relative overflow-hidden flex flex-col" id="evidence-pane">
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#0891B2 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>

                    <div class="flex bg-white/5 border-b border-white/10 relative z-10" id="kyc-tabs">
                        <button class="tab-btn active px-6 py-4 text-[10px] font-bold text-cyan-400 border-b-2 border-cyan-400 uppercase tracking-widest transition-all" data-tab="id">Identity (ID)</button>
                        <button class="tab-btn px-6 py-4 text-[10px] font-bold text-white/40 hover:text-white uppercase tracking-widest transition-all" data-tab="finance">Financials</button>
                        <button class="tab-btn px-6 py-4 text-[10px] font-bold text-white/40 hover:text-white uppercase tracking-widest transition-all" data-tab="bio">Biometrics</button>
                    </div>

                    <div class="flex-1 p-8 relative overflow-hidden flex items-center justify-center gap-8" id="document-viewer">
                        <div id="content-id" class="tab-content flex items-center justify-center gap-8 w-full">
                            <div class="evidence-card w-1/2 aspect-[1.6/1] bg-[#111] rounded-lg border border-white/20 relative overflow-hidden shadow-2xl">
                                <img src="https://img.freepik.com/premium-vector/id-card-template-with-flat-design_23-2147953335.jpg" class="w-full h-full object-cover grayscale opacity-70">
                            </div>
                            <div id="selfie-card" class="evidence-card w-1/3 aspect-square bg-[#111] rounded-full border-4 border-[#0891B2]/30 relative shadow-2xl overflow-hidden cursor-move">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400" class="w-full h-full object-cover grayscale">
                            </div>
                        </div>

                        <div id="content-finance" class="tab-content hidden flex-col items-center gap-4 w-full">
                            <div class="w-full max-w-lg p-6 bg-white/5 border border-cyan-500/20 rounded-xl font-mono text-[10px]">
                                <p class="text-cyan-400 mb-4">// ANNUAL TAX STATEMENT - 2025</p>
                                <div class="space-y-2 text-white/60">
                                    <div class="flex justify-between border-b border-white/5 pb-1"><span>Net Worth:</span><span class="text-white">$145,000,000</span></div>
                                    <div class="flex justify-between border-b border-white/5 pb-1"><span>Liquidity:</span><span class="text-white">High</span></div>
                                    <div class="flex justify-between"><span>Audit Status:</span><span class="text-emerald-400">PASSED</span></div>
                                </div>
                            </div>
                            <img src="https://placehold.co/600x200/0a0a0a/0891B2?text=BANK_STATEMENT_SCAN" class="rounded border border-white/10 opacity-50">
                        </div>

                        <div id="content-bio" class="tab-content hidden w-full text-center">
                            <div class="inline-block p-10 border-2 border-dashed border-cyan-500/30 rounded-full animate-pulse">
                                <i class="ri-fingerprint-line text-6xl text-cyan-400"></i>
                            </div>
                            <p class="text-cyan-400 font-mono text-[10px] mt-4 uppercase">Scanning Biometric Data...</p>
                        </div>
                    </div>

                    <div class="p-4 bg-black/80 border-t border-white/10 grid grid-cols-4 gap-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-[8px] text-white/30 uppercase">Captured on</span>
                            <span class="text-[10px] text-white font-mono">iPhone 15 Pro - GPS: 10.7626, 106.6602</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[8px] text-white/30 uppercase">Edit History</span>
                            <span class="text-[10px] text-emerald-400 font-mono">No tampering detected</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[8px] text-white/30 uppercase">AI Score</span>
                            <span class="text-[10px] text-white font-mono">98.4% Match</span>
                        </div>
                    </div>
                </div>

                <div class="w-full xl:w-[400px] flex flex-col gap-6" id="decision-pane">
                    <div class="bg-black/40 border border-white/10 rounded-2xl p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-2 text-[8px] font-mono text-white/10">OCR_V2.0</div>

                        <h3 class="text-white font-bold text-sm mb-6 flex items-center gap-2">
                            <i class="ri-cpu-line text-cyan-400"></i> AI Extraction (OCR)
                        </h3>

                        <div class="space-y-4">
                            <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                <label class="text-[8px] text-white/30 uppercase block mb-1">Full Name</label>
                                <div class="flex justify-between">
                                    <span class="text-xs text-white font-bold">NGUYEN HOANG PHI LONG</span>
                                    <i class="ri-checkbox-circle-fill text-emerald-500"></i>
                                </div>
                            </div>
                            <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                <label class="text-[8px] text-white/30 uppercase block mb-1">Document Number</label>
                                <span class="text-xs text-white font-bold tracking-[2px]">07909200****</span>
                            </div>
                            <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                <label class="text-[8px] text-white/30 uppercase block mb-1">Proposed Limit</label>
                                <span class="text-xs text-[#F1C40F] font-bold font-mono">$2,500,000.00</span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <p class="text-[9px] text-white/30 uppercase mb-3">Risk Assessment</p>
                            <div class="flex items-center gap-2 p-2 bg-emerald-500/10 border border-emerald-500/20 rounded-md mb-2">
                                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                                <span class="text-[10px] text-emerald-500">Global Blacklist Clear</span>
                            </div>
                            <div class="flex items-center gap-2 p-2 bg-white/5 border border-white/10 rounded-md">
                                <div class="w-1.5 h-1.5 bg-[#F1C40F] rounded-full"></div>
                                <span class="text-[10px] text-white/60">Large Cash Deposit Detected</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 mt-auto">
                        <button onclick="stampApprove()" id="btn-approve" class="group relative overflow-hidden bg-emerald-600 hover:bg-emerald-500 text-white py-4 rounded-xl font-bold text-xs uppercase tracking-[3px] transition-all flex items-center justify-center gap-2">
                            <i class="ri-shield-check-line"></i> Approve Identity
                            <div id="particle-container" class="absolute inset-0 pointer-events-none"></div>
                        </button>
                        <button onclick="openRejectModal()" class="bg-white/5 border border-white/10 hover:bg-rose-900/20 hover:border-rose-500 text-white/40 hover:text-rose-500 py-4 rounded-xl font-bold text-[10px] uppercase tracking-[3px] transition-all flex items-center justify-center gap-2">
                            <i class="ri-close-circle-line"></i> Reject Profile
                        </button>

                        <div id="reject-modal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
                            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeRejectModal()"></div>
                            <div class="relative bg-[#1a1a1a] border border-rose-500/30 p-6 rounded-2xl w-full max-w-sm shadow-[0_0_50px_rgba(244,63,94,0.2)]">
                                <h3 class="text-white font-bold text-sm mb-4 uppercase tracking-widest text-rose-500">Reason for Rejection</h3>
                                <div class="space-y-2">
                                    <button onclick="confirmReject('Low Quality Image')" class="w-full text-left p-3 rounded-lg bg-white/5 border border-white/10 text-[10px] text-white/60 hover:bg-rose-500/20 hover:text-white transition-all">IMAGE RESOLUTION TOO LOW</button>
                                    <button onclick="confirmReject('Document Expired')" class="w-full text-left p-3 rounded-lg bg-white/5 border border-white/10 text-[10px] text-white/60 hover:bg-rose-500/20 hover:text-white transition-all">DOCUMENT EXPIRED</button>
                                    <button onclick="confirmReject('Fraudulent Activity')" class="w-full text-left p-3 rounded-lg bg-white/5 border border-white/10 text-[10px] text-white/60 hover:bg-rose-500/20 hover:text-white transition-all">FRAUDULENT DATA DETECTED</button>
                                </div>
                                <button onclick="closeRejectModal()" class="mt-6 w-full py-2 text-[9px] text-white/20 uppercase tracking-widest hover:text-white">Cancel Action</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ----------------------------- section 4 -----------------------------  -->
        <section id="vip-pulse" class="pt-10 pb-20 px-4 md:px-8 transition-all duration-500 ml-0 md:ml-20 lg:ml-24 bg-[#050B18]">

            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-[#0891B2] font-mono text-[10px] tracking-[5px] uppercase mb-1">Intelligence System</h2>
                    <h1 class="text-xl text-white font-light tracking-widest uppercase">Relationship <span class="font-bold text-cyan-500">Matrix</span></h1>
                </div>
                <div class="flex items-center gap-4 bg-white/5 p-2 rounded-full border border-white/10" id="timeframe-switch">
                    <div onclick="updateTimeframe(this, '7')"
                        class="time-pill active px-4 py-1 rounded-full bg-cyan-500/20 text-cyan-400 text-[9px] font-bold cursor-pointer transition-all duration-300">
                        7 DAYS DWELL
                    </div>
                    <div onclick="updateTimeframe(this, '30')"
                        class="time-pill px-4 py-1 rounded-full text-white/30 text-[9px] font-bold cursor-pointer hover:text-white transition-all duration-300">
                        30 DAYS SCAN
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="bg-[#0A1124] border border-white/5 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#0891B2 0.5px, transparent 0.5px); background-size: 15px 15px;"></div>
                    <h3 class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-6 flex items-center gap-2">
                        <i class="ri-fire-line text-orange-500"></i> Interest Heatmap
                    </h3>

                    <div class="flex flex-wrap gap-3 relative z-10">
                        <div class="keyword-pill" onclick="triggerNeural('Sảnh Tiến')">
                            <span class="text-[11px] text-white">Sảnh Tiến</span>
                            <span class="text-[9px] text-cyan-500 font-bold">92%</span>
                        </div>
                        <div class="keyword-pill" onclick="triggerNeural('Lộc Phát 68')">
                            <span class="text-[11px] text-white">Lộc Phát 68</span>
                            <span class="text-[9px] text-cyan-500 font-bold">85%</span>
                        </div>
                        <div class="keyword-pill" onclick="triggerNeural('Ngũ Quý 9')">
                            <span class="text-[11px] text-white">Ngũ Quý 9</span>
                            <span class="text-[9px] text-rose-500 font-bold">HOT</span>
                        </div>
                        <div class="keyword-pill" onclick="triggerNeural('Tam Hoa 8')">
                            <span class="text-[11px] text-white">Tam Hoa 8</span>
                            <span class="text-[9px] text-cyan-500 font-bold">42%</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/5 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] text-white/30 uppercase">Avg. Gaze Time</span>
                            <span class="text-xs text-cyan-400 font-mono">18.4s / Plate</span>
                        </div>
                        <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full w-[75%] shadow-[0_0_10px_#0891B2]"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0A1124] border border-white/5 rounded-2xl p-6 flex flex-col">
                    <h3 class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-6 flex items-center gap-2">
                        <i class="ri-pulse-line text-cyan-400"></i> Engagement Flow
                    </h3>
                    <div class="flex-1 min-h-[150px] relative">
                        <canvas id="engagementChart"></canvas>
                    </div>
                    <div class="flex justify-around mt-4">
                        <div class="text-center">
                            <p class="text-[8px] text-white/30 uppercase">Peak Time</p>
                            <p class="text-xs text-white font-bold">21:00 - 23:00</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[8px] text-white/30 uppercase">Retention</p>
                            <p class="text-xs text-emerald-400 font-bold">88.4%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0A1124] border border-white/5 rounded-2xl p-6 flex flex-col">
                    <h3 class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-6 flex items-center justify-between">
                        <span class="flex items-center gap-2"><i class="ri-customer-service-2-line text-emerald-400"></i> Concierge Queue</span>
                        <span class="text-cyan-500 text-[8px] animate-pulse">LIVE</span>
                    </h3>

                    <div class="space-y-3 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                        <div class="bg-white/5 border-l-2 border-[#F1C40F] p-3 rounded-r-lg group hover:bg-white/10 transition-all cursor-pointer">
                            <div class="flex justify-between mb-1">
                                <span class="text-[10px] font-bold text-[#F1C40F]">DIAMOND • Mr. T**</span>
                                <span class="text-[8px] text-white/20">2m ago</span>
                            </div>
                            <p class="text-[11px] text-white/80 italic">"Tìm giúp biển số ngày sinh vợ 20/10..."</p>
                        </div>

                        <div class="bg-white/5 border-l-2 border-slate-400 p-3 rounded-r-lg group hover:bg-white/10 transition-all cursor-pointer">
                            <div class="flex justify-between mb-1">
                                <span class="text-[10px] font-bold text-slate-300">PLATINUM • Ms. K**</span>
                                <span class="text-[8px] text-white/20">15m ago</span>
                            </div>
                            <p class="text-[11px] text-white/80 italic">"Tư vấn thủ tục chuyển nhượng nhanh"</p>
                        </div>

                        <div class="flex items-center gap-3 p-2 bg-cyan-500/5 rounded-lg border border-cyan-500/10">
                            <div class="heart-beat">
                                <i class="ri-heart-pulse-fill text-cyan-500"></i>
                            </div>
                            <span class="text-[9px] text-cyan-400 font-mono tracking-tighter uppercase">High Engagement Mode Detected</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="ghost-notif-container" class="fixed bottom-6 right-6 z-[300] space-y-3 pointer-events-none"></div>
        </section>


        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->
    </main>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Hiệu ứng "The Royal Entrance" (GSAP)
        gsap.from("#vip-header", {
            y: -100,
            opacity: 0,
            filter: "blur(20px)",
            duration: 1.5,
            ease: "power4.out"
        });

        // 2. Hiệu ứng Nhảy số (Counting effect)
        const countNumbers = document.querySelectorAll('.counting-number');
        countNumbers.forEach(num => {
            const target = parseInt(num.getAttribute('data-target'));
            gsap.to(num, {
                innerText: target,
                duration: 2,
                snap: {
                    innerText: 1
                },
                ease: "power2.out",
                onUpdate: function() {
                    if (target > 1000) {
                        num.innerText = num.innerText.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            });
        });

        // 3. Hiệu ứng "The Focus Halo" khi search
        const searchInput = document.getElementById('deep-search');
        const overlay = document.getElementById('focus-overlay');
        const suggestionsBox = document.getElementById('search-suggestions');

        searchInput.addEventListener('focus', () => {
            overlay.classList.remove('pointer-events-none');
            overlay.classList.add('opacity-100');
        });
        // Khi gõ phím vào ô search
        // Cập nhật lại sự kiện input trong DOMContentLoaded
        searchInput.addEventListener('input', function(e) {
            const value = e.target.value.trim().toLowerCase();

            if (value.length >= 1) {
                // Sử dụng block thay vì gsap nếu muốn test nhanh hiển thị
                suggestionsBox.style.display = 'block';
                gsap.to(suggestionsBox, {
                    opacity: 1,
                    y: 5, // Trượt xuống một chút cho đẹp
                    duration: 0.2,
                });
            } else {
                suggestionsBox.style.display = 'none';
            }
        });

        searchInput.addEventListener('blur', () => {
            overlay.classList.add('pointer-events-none');
            overlay.classList.remove('opacity-100');
        });
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
        document.addEventListener('click', function(e) {
            const searchContainer = document.querySelector('.relative.group'); // Thẻ cha của ô search
            if (!searchContainer.contains(e.target)) {
                document.getElementById('search-suggestions').classList.add('hidden');
            }
        });

        function selectVIP(id) {
            const searchInput = document.getElementById('deep-search');
            const suggestionsBox = document.getElementById('search-suggestions');

            // 1. Tìm thẻ Card (Wrapper) của khách hàng này trên giao diện
            const targetWrapper = document.querySelector(`.member-card-wrapper[data-id="${id}"]`);

            if (targetWrapper) {
                // 2. Cuộn màn hình tới vị trí thẻ đó mượt mà
                targetWrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // 3. Tìm thẻ card bên trong và kích hoạt sự kiện click để mở Modal Editor
                const card = targetWrapper.querySelector('.member-card');
                if (card) {
                    card.click(); // Gọi hàm openVipEditor(card) mà bạn đã viết trước đó
                }

                // 4. Xóa nội dung search và ẩn gợi ý
                searchInput.value = '';
                suggestionsBox.classList.add('hidden');
            } else {
                // Trường hợp khách hàng không có trong danh sách hiện tại (đang bị lọc bởi Rank)
                console.log("Không tìm thấy thẻ trên view hiện tại. Đang mở trực tiếp...");
                // Nếu bạn muốn mở luôn dù không thấy thẻ, hãy gọi hàm open trực tiếp nếu có dữ liệu
            }
        }
        document.getElementById('deep-search').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Chặn reload trang ngay lập tức

                const searchTerm = e.target.value.toLowerCase().trim();
                const suggestionsContainer = document.getElementById('search-suggestions');
                const allCards = document.querySelectorAll('.member-card-wrapper');
                const allFilterBtns = document.querySelectorAll('.filter-btn');

                // 1. Ẩn bảng gợi ý
                if (suggestionsContainer) {
                    suggestionsContainer.classList.add('hidden');
                }

                // 2. Nếu ô search trống -> Quay về chế độ xem tất cả
                if (searchTerm === "") {
                    filterMembers('all', document.querySelector('.filter-btn[onclick*="all"]'));
                    return;
                }

                // 3. Reset các nút filter rank về trạng thái "All" để người dùng không bị rối
                allFilterBtns.forEach(btn => btn.classList.remove('active', 'bg-[#F1C40F]/20', 'text-[#F1C40F]'));
                const allBtn = document.querySelector('.filter-btn[onclick*="all"]');
                if (allBtn) allBtn.classList.add('active');

                // 4. Thực hiện lọc thẻ
                let matchCount = 0;
                allCards.forEach(wrapper => {
                    // Kiểm tra an toàn dữ liệu data-customer
                    const rawData = wrapper.getAttribute('data-customer');
                    if (!rawData) return;

                    const customerData = JSON.parse(rawData);
                    const fullName = (customerData.full_name || '').toLowerCase();
                    const phone = (customerData.phone_number || '').toLowerCase();
                    const id = (customerData.id || '').toString();

                    // Tìm kiếm theo Tên, Số điện thoại hoặc ID
                    if (fullName.includes(searchTerm) || phone.includes(searchTerm) || id.includes(searchTerm)) {
                        wrapper.style.display = 'block';
                        matchCount++;

                        // Hiệu ứng GSAP: Thẻ hiện ra mượt mà
                        gsap.fromTo(wrapper, {
                            opacity: 0,
                            y: 20,
                            scale: 0.95
                        }, {
                            opacity: 1,
                            y: 0,
                            scale: 1,
                            duration: 0.4,
                            ease: "back.out(1.7)"
                        });
                    } else {
                        wrapper.style.display = 'none';
                    }
                });

                // 5. Xử lý khi không tìm thấy kết quả
                if (matchCount === 0) {
                    // Có thể hiện một thông báo nhỏ (Toast) thay vì chỉ log console
                    console.log("No Matrix match found for: " + searchTerm);

                    // Tùy chọn: Hiển thị thông báo "Không tìm thấy" vào container chính
                    const container = document.querySelector('.grid-cols-1'); // ID container của bạn
                    if (container && !document.getElementById('no-result-msg')) {
                        const msg = document.createElement('div');
                        msg.id = 'no-result-msg';
                        msg.className = 'col-span-full text-center py-10 text-white/20 uppercase tracking-widest';
                        msg.innerText = 'No Intelligence Found';
                        container.appendChild(msg);
                    }
                } else {
                    // Xóa thông báo "Không tìm thấy" nếu có kết quả
                    const msg = document.getElementById('no-result-msg');
                    if (msg) msg.remove();
                }
            }
        });
        // 4. Liquid Metal Hover Effect chân trang
        const headerContainer = document.querySelector('.header-container');
        const track = document.getElementById('liquid-track');

        headerContainer.addEventListener('mousemove', (e) => {
            const x = e.clientX - headerContainer.getBoundingClientRect().left;
            gsap.to(track, {
                left: x - 50,
                width: '100px',
                background: 'linear-gradient(90deg, transparent, #F1C40F, transparent)',
                duration: 0.5
            });
        });
    });

    // 5. Privacy Toggle (Giải pháp phản biện)
    let isPrivate = false;

    function togglePrivacy() {
        isPrivate = !isPrivate;
        const elements = document.querySelectorAll('.privacy-blur');
        const icon = document.getElementById('privacy-icon');

        elements.forEach(el => {
            isPrivate ? el.classList.add('active') : el.classList.remove('active');
        });

        icon.className = isPrivate ? 'ri-eye-off-line text-sm text-[#F1C40F]' : 'ri-eye-line text-sm';

        // Haptic feedback giả lập
        if (window.navigator.vibrate) window.navigator.vibrate(10);
    }
    // 1. Mở Portal với hiệu ứng Cascade
    function openVipPortal() {
        const portal = document.getElementById('vip-portal');
        const bg = document.getElementById('portal-bg');
        const content = document.getElementById('portal-content');
        const fields = document.querySelectorAll('.portal-field');

        portal.classList.remove('hidden');
        portal.classList.add('flex');

        // Hiệu ứng trượt màn hình xuống
        gsap.to(bg, {
            translateY: 0,
            duration: 0.7,
            ease: "power4.inOut"
        });

        // Hiệu ứng hiện Modal
        gsap.to(content, {
            opacity: 1,
            translateY: 0,
            duration: 0.5,
            delay: 0.4
        });

        // Hiệu ứng Cascade (Thác đổ) cho các ô nhập liệu
        gsap.fromTo(fields, {
            opacity: 0,
            y: 30
        }, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            stagger: 0.15,
            delay: 0.6,
            ease: "power2.out"
        });
    }

    function closeVipPortal() {
        gsap.to("#portal-bg", {
            translateY: "-100%",
            duration: 0.7,
            ease: "power4.inOut",
            onComplete: () => {
                document.getElementById('vip-portal').classList.add('hidden');
            }
        });
    }

    // 2. Dự đoán hạng thẻ dựa trên tiền ký gửi
    function predictRank(val) {
        const amount = parseFloat(val);
        const rankIcon = document.getElementById('rank-icon');
        const rankName = document.getElementById('rank-name');
        const moneyText = document.getElementById('money-text');

        // Chuyển số thành chữ (Phản biện 1)
        if (val) {
            moneyText.innerText = formatMoneyToWords(amount) + " đồng";
        } else {
            moneyText.innerText = "Đang chờ nhập liệu...";
        }

        // Đề xuất hạng
        if (amount >= 10000000000) { // 10 tỷ
            rankIcon.className = "w-12 h-12 rounded-full border-2 border-cyan-500 flex items-center justify-center text-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.5)] bg-cyan-500/10";
            rankName.innerText = "DIAMOND MEMBER";
            rankName.classList.replace('text-white/20', 'text-cyan-500');
        } else if (amount >= 1000000000) { // 1 tỷ
            rankIcon.className = "w-12 h-12 rounded-full border-2 border-[#E5E4E2] flex items-center justify-center text-[#E5E4E2] shadow-[0_0_10px_rgba(229,228,226,0.3)] bg-white/5";
            rankName.innerText = "PLATINUM MEMBER";
            rankName.classList.replace('text-white/20', 'text-[#E5E4E2]');
        } else if (amount >= 500000000) { // 500 triệu (Mức GOLD)
            rankIcon.className = "w-12 h-12 rounded-full border-2 border-[#D4AF37] flex items-center justify-center text-[#D4AF37] shadow-[0_0_10px_rgba(212,175,55,0.3)] bg-[#D4AF37]/10";
            rankName.innerText = "GOLD MEMBER";
            rankName.classList.replace('text-white/20', 'text-[#D4AF37]');
        } else {
            // Mặc định cho thành viên phổ thông
            rankIcon.className = "w-12 h-12 rounded-full border-2 border-white/10 flex items-center justify-center text-white/20";
            rankName.innerText = "STANDARD MEMBER";
        }
    }

    // 3. Background Check trùng lặp (Phản biện 2)
    function checkDuplicate(val) {
        const warning = document.getElementById('duplicate-warning');
        // Giả lập check: Nếu nhập "090" thì báo trùng
        if (val.startsWith("090")) {
            warning.classList.replace('hidden', 'flex');
            if (window.navigator.vibrate) window.navigator.vibrate([50, 50, 50]);
        } else {
            warning.classList.add('hidden');
        }
    }

    // Hàm hỗ trợ đọc số tiền tiếng Việt
    function formatMoneyToWords(number) {
        // Đây là hàm rút gọn, bạn có thể tích hợp thư viện đọc số tiền chuyên sâu
        if (number >= 1000000000) return (number / 1000000000).toFixed(1) + " Tỷ";
        if (number >= 1000000) return (number / 1000000).toFixed(0) + " Triệu";
        return number.toLocaleString('vi-VN');
    }
    async function finalizePortalRegistration() {
        // 1. Lấy phần tử
        const nameInput = document.getElementById('portal-fullname');
        const emailInput = document.getElementById('portal-email');
        const phoneInput = document.getElementById('portal-phone');
        const depositInput = document.getElementById('deposit-input');
        const rankDisplay = document.getElementById('rank-name');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarUploadInput = document.getElementById('avatar-upload');

        if (!nameInput || !emailInput || !phoneInput || !depositInput) {
            alert("Lỗi hệ thống: Không tìm thấy các ô nhập liệu!");
            return;
        }

        // 2. Lấy giá trị thực tế
        const fullName = nameInput.value.trim();
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const deposit = depositInput.value;
        const rankName = rankDisplay ? rankDisplay.innerText : "Gold";

        // 3. Kiểm tra nhập liệu
        if (!fullName || !deposit || (!email && !phone)) {
            alert("Vui lòng điền Họ tên, Số tiền và ít nhất Email hoặc Số điện thoại!");
            return;
        }

        // 4. Hiệu ứng nút bấm (Sử dụng event.target an toàn hơn)
        const btn = event.currentTarget;
        const originalText = btn.innerText;
        btn.innerText = "INITIALIZING...";
        btn.disabled = true;

        // 5. Chuẩn bị FormData (PHẢI KHỞI TẠO TRƯỚC KHI APPEND)
        const formData = new FormData();
        formData.append('action_type', 'portal_onboard');
        formData.append('full_name', fullName);
        formData.append('email', email);
        formData.append('phone_number', phone);
        formData.append('deposit', deposit);
        formData.append('rank', rankName.replace(' MEMBER', '').trim());

        // XỬ LÝ AVATAR (Gửi đúng tên cột 'avatar' cho DB)
        if (avatarUploadInput && avatarUploadInput.files[0]) {
            // Nếu có file thực tế được chọn từ máy tính
            formData.append('avatar_file', avatarUploadInput.files[0]);
        } else if (avatarPreview) {
            // Nếu dùng ảnh mẫu (preset), gửi URL của ảnh đó
            formData.append('avatar', avatarPreview.src);
        }

        // 6. Gửi dữ liệu
        try {
            const response = await fetch('VipVelations.php', {
                method: 'POST',
                body: formData
            });

            // Kiểm tra xem server có trả về JSON hợp lệ không
            const text = await response.text();
            let res;
            try {
                res = JSON.parse(text);
            } catch (e) {
                console.error("Server response was not JSON:", text);
                throw new Error("Dữ liệu phản hồi từ server không hợp lệ!");
            }

            if (res.success) {
                alert("Matrix Integrated: Thêm VIP mới thành công!");
                location.reload();
            } else {
                alert("Lỗi: " + (res.message || "Không thể thêm khách hàng"));
                btn.innerText = originalText;
                btn.disabled = false;
            }
        } catch (err) {
            console.error("Fetch error:", err);
            alert("Lỗi kết nối máy chủ: " + err.message);
            btn.innerText = originalText;
            btn.disabled = false;
        }
    }
    // Hàm chọn ảnh từ danh sách gợi ý
    function selectPresetAvatar(src) {
        const preview = document.getElementById('avatar-preview');
        preview.src = src;

        // Hiệu ứng GSAP nhẹ khi đổi ảnh
        gsap.fromTo(preview, {
            scale: 0.8,
            opacity: 0.5
        }, {
            scale: 1,
            opacity: 1,
            duration: 0.4
        });
    }

    // Hàm preview ảnh khi người dùng upload từ máy tính
    function previewUpload(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
                gsap.from("#avatar-preview", {
                    filter: "brightness(2)",
                    duration: 0.5
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Khởi tạo Tilt (3D Card)
        if (typeof VanillaTilt !== 'undefined') {
            VanillaTilt.init(document.querySelectorAll(".member-card"), {
                speed: 1000,
                perspective: 1500,
            });
        }

        // 2. Ghost Overlay Logic (Phản biện 3)
        let idleTimer;
        const ghostInfo = document.querySelectorAll('.ghost-info');

        function resetIdleTimer() {
            ghostInfo.forEach(el => el.classList.remove('blurred'));
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                ghostInfo.forEach(el => el.classList.add('blurred'));
            }, 30000); // 30 giây không tương tác
        }

        document.addEventListener('mousemove', resetIdleTimer);
        document.addEventListener('keypress', resetIdleTimer);

        // 3. Compare Mode Logic (Phản biện 2)
        const cards = document.querySelectorAll('.member-card');
        let compareList = [];

        cards.forEach(card => {
            card.addEventListener('contextmenu', (e) => {
                e.preventDefault(); // Chuột phải để chọn so sánh
                card.classList.toggle('comparing');

                const indicator = document.getElementById('compare-mode-indicator');
                const count = document.querySelectorAll('.comparing').length;

                if (count > 0) {
                    indicator.classList.remove('hidden');
                    indicator.classList.add('flex');
                } else {
                    indicator.classList.add('hidden');
                }
            });

            // 4. Elite Expansion (GSAP)
            card.addEventListener('click', () => {
                // Haptic feedback cho Diamond
                if (card.closest('.member-card-wrapper').dataset.rank === 'diamond') {
                    if (window.navigator.vibrate) window.navigator.vibrate(20);
                }

                // Logic mở rộng hồ sơ có thể thêm ở đây bằng GSAP Flip
                console.log("Expanding VIP Profile...");
            });
        });
    });

    function exitCompareMode() {
        document.querySelectorAll('.comparing').forEach(el => el.classList.remove('comparing'));
        document.getElementById('compare-mode-indicator').classList.add('hidden');
    }

    function filterMembers(rank, btn) {
        // 1. Reset tất cả các nút về trạng thái bình thường
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active', 'bg-[#F1C40F]/20', 'border-[#F1C40F]/50', 'text-[#F1C40F]', 'bg-cyan-400/20', 'border-cyan-400/50', 'text-cyan-400', 'bg-[#D4AF37]/20', 'border-[#D4AF37]/50', 'text-[#D4AF37]');
            b.classList.add('bg-white/5', 'border-white/10', 'text-white/60');
        });

        // 2. Kích hoạt màu Active tương ứng cho từng hạng
        btn.classList.remove('bg-white/5', 'border-white/10', 'text-white/60');
        if (rank === 'all') {
            btn.classList.add('bg-[#F1C40F]/20', 'border-[#F1C40F]/50', 'text-[#F1C40F]');
        } else if (rank === 'gold') {
            btn.classList.add('bg-[#D4AF37]/20', 'border-[#D4AF37]/50', 'text-[#D4AF37]');
        } else if (rank === 'diamond') {
            btn.classList.add('bg-cyan-400/20', 'border-cyan-400/50', 'text-cyan-400');
        } else if (rank === 'platinum') {
            btn.classList.add('bg-slate-400/10', 'border-slate-400/50', 'text-slate-100', 'shadow-[0_0_10px_rgba(226,232,240,0.2)]');
        }

        // 3. Hiệu ứng lọc thẻ bằng GSAP
        const cards = document.querySelectorAll('.member-card-wrapper');
        cards.forEach(card => {
            const cardRank = card.getAttribute('data-rank');
            if (rank === 'all' || cardRank === rank) {
                card.style.display = 'block';
                gsap.to(card, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.4,
                    ease: "power2.out"
                });
            } else {
                gsap.to(card, {
                    opacity: 0,
                    scale: 0.9,
                    duration: 0.3,
                    onComplete: () => card.style.display = 'none'
                });
            }
        });
    }
    let isEditMode = false;

    function openVipEditor(cardElement) {
        const customerData = JSON.parse(cardElement.getAttribute('data-customer'));
        const rank = cardElement.getAttribute('data-rank').toLowerCase();

        // ID và Name
        const idInput = document.getElementById('editor-customer-id');
        // Lưu Rank vào input hidden để dùng cho toggleEditMode
        const rankInput = document.getElementById('editor-rank-value');
        if (rankInput) rankInput.value = rank;
        if (idInput) idInput.value = customerData.id;

        const nameDisplay = document.getElementById('editor-name-display'); // Đảm bảo ID này khớp với HTML của bạn
        if (nameDisplay) nameDisplay.innerText = customerData.full_name;

        document.getElementById('editor-client-id').innerText = customerData.id.toString().padStart(6, '0');

        // --- SỬA TẠI ĐÂY: Dùng phone_number thay vì phone ---
        document.getElementById('editor-full-name').value = customerData.full_name;
        document.getElementById('editor-phone').value = customerData.phone_number || '';
        document.getElementById('editor-email').value = customerData.email || '';

        // --- SỬA TẠI ĐÂY: Dùng avatar thay vì avatar_url ---
        const editorAvatar = document.getElementById('editor-avatar');
        editorAvatar.src = customerData.avatar ? customerData.avatar : `https://i.pravatar.cc/150?u=${customerData.id}`;

        // Financial Matrix
        const limit = parseFloat(customerData.bidding_limit) || 0;
        const limitRange = document.getElementById('editor-limit-range');
        const limitText = document.getElementById('editor-limit-text');
        if (limitRange) limitRange.value = limit;
        if (limitText) limitText.innerText = (limit / 1000000000).toFixed(1) + 'B VND';

        // Cập nhật Rank Badge
        updateBadgeStyle(rank);

        // Mở Modal (GSAP)
        const overlay = document.getElementById('vip-editor-overlay');
        const container = document.getElementById('editor-container');
        const bg = document.getElementById('editor-bg');
        const rect = cardElement.getBoundingClientRect();

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        gsap.timeline()
            .to(bg, {
                opacity: 1,
                duration: 0.4
            })
            .fromTo(container, {
                x: rect.left - (window.innerWidth / 2 - rect.width / 2),
                y: rect.top - (window.innerHeight / 2 - rect.height / 2),
                scale: 0.2,
                opacity: 0
            }, {
                x: 0,
                y: 0,
                scale: 1,
                opacity: 1,
                duration: 0.6,
                ease: "expo.out"
            });
    }

    function toggleEditMode() {
        isEditMode ? disableEditMode() : enableEditMode();
        const btn = document.getElementById('edit-mode-btn');
        const inputs = document.querySelectorAll('.vip-input');
        const container = document.getElementById('editor-container');

        // 1. Lấy Rank hiện tại (chuyển về chữ thường để so sánh)
        const currentRank = document.getElementById('editor-rank-value').value.toLowerCase();

        // 2. Định nghĩa màu theo Rank
        const rankColors = {
            gold: {
                hex: '#D4AF37',
                rgba: 'rgba(212, 175, 55, 0.3)'
            },
            platinum: {
                hex: '#E5E4E2',
                rgba: 'rgba(229, 228, 226, 0.3)'
            },
            diamond: {
                hex: '#b9f2ff',
                rgba: 'rgba(185, 242, 255, 0.3)'
            }
        };

        // Lấy màu tương ứng, nếu không khớp thì mặc định lấy màu Gold
        const activeColor = rankColors[currentRank] || rankColors.gold;

        if (isEditMode) {
            btn.innerHTML = `<i class="ri-save-line text-emerald-400"></i> <span class="text-emerald-400">Viewing (Edit Active)</span>`;

            // 3. Đổi màu viền theo Rank
            container.style.borderColor = activeColor.hex;

            inputs.forEach(input => {
                input.readOnly = false;
                input.classList.add('bg-white/5', 'px-2');
                // Đổi màu gạch chân input khi focus (tùy chọn)
                input.style.borderBottomColor = activeColor.hex;
            });

            // 4. Hiệu ứng Neon theo màu của Rank đó
            gsap.to(container, {
                boxShadow: `0 0 50px ${activeColor.rgba}`,
                duration: 0.5
            });

        } else {
            // Khi tắt Edit Mode, trả lại trạng thái cũ
            container.style.borderColor = "rgba(255,255,255,0.1)";
            gsap.to(container, {
                boxShadow: "none",
                duration: 0.3
            });
            // Xử lý đóng hoặc lưu...
        }
    }

    function disableEditMode() {
        isEditMode = false;
        const btn = document.getElementById('edit-mode-btn');
        btn.innerHTML = `<i class="ri-pencil-line"></i> Enter Edit Mode`;
        btn.classList.remove('bg-white', 'text-black');
        document.querySelectorAll('.vip-input').forEach(i => i.readOnly = true);
    }

    function enableEditMode() {
        isEditMode = true;
        const btn = document.getElementById('edit-mode-btn');
        btn.innerHTML = `<i class="ri-check-line"></i> Editing Mode`;
        btn.classList.add('bg-white', 'text-black');
        document.querySelectorAll('.vip-input').forEach(i => i.readOnly = false);
    }
    // --- HÀM 2: MỞ ĐỂ ADD (Dùng cho nút "Add New Member") ---
    function openAddModal() {
        // Xóa ID để biết là ADD
        document.getElementById('editor-customer-id').value = "";

        // Reset form trắng
        document.getElementById('editor-client-id').innerText = "NEW";
        document.getElementById('editor-name-display').innerText = "NEW CLIENT";
        document.getElementById('editor-full-name').value = "";
        document.getElementById('editor-email').value = "";
        document.getElementById('editor-phone').value = "";
        document.getElementById('editor-limit-range').value = 0;
        updateLimitText(0);
        document.getElementById('editor-avatar').src = "https://i.pravatar.cc/150?u=new";

        // Mở là cho phép nhập luôn
        enableEditMode();

        // Mở từ giữa màn hình
        showEditorAnimation();
    }

    function showEditorAnimation(rect = null) {
        const overlay = document.getElementById('vip-editor-overlay');
        const container = document.getElementById('editor-container');
        const bg = document.getElementById('editor-bg');

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        const tl = gsap.timeline();
        tl.to(bg, {
            opacity: 1,
            duration: 0.4
        });

        if (rect) {
            tl.fromTo(container, {
                x: rect.left - (window.innerWidth / 2 - rect.width / 2),
                y: rect.top - (window.innerHeight / 2 - rect.height / 2),
                scale: 0.2,
                opacity: 0
            }, {
                x: 0,
                y: 0,
                scale: 1,
                opacity: 1,
                duration: 0.6,
                ease: "expo.out"
            });
        } else {
            tl.fromTo(container, {
                scale: 0.5,
                opacity: 0
            }, {
                scale: 1,
                opacity: 1,
                duration: 0.5
            });
        }
    }

    function updateLimitText(val) {
        document.getElementById('editor-limit-text').innerText = (val / 1000000000).toFixed(1) + 'B VND';
    }

    function updateBadgeStyle(rank) {
        const badge = document.getElementById('editor-rank-badge');
        if (!badge) return;

        if (rank === 'gold') {
            badge.className = "px-3 py-1 rounded-full text-[6px] font-bold tracking-widest border border-[#D4AF37] text-[#D4AF37] bg-[#D4AF37]/10";
            badge.innerText = "GOLD MEMBER";
        } else if (rank === 'platinum') {
            // Màu BẠC (Slate/Zinc)
            badge.className = "px-3 py-1 rounded-full text-[6px] font-bold tracking-widest border border-slate-300 text-slate-300 bg-slate-300/10 shadow-[0_0_5px_rgba(203,213,225,0.3)]";
            badge.innerText = "PLATINUM MEMBER";
        } else {
            badge.className = "px-3 py-1 rounded-full text-[6px] font-bold tracking-widest border border-cyan-500 text-cyan-500 bg-cyan-500/10";
            badge.innerText = "DIAMOND CLUB";
        }
    }

    function closeVipEditor() {
        const container = document.getElementById('editor-container');
        const bg = document.getElementById('editor-bg');
        const overlay = document.getElementById('vip-editor-overlay');
        const btn = document.getElementById('edit-mode-btn');
        const inputs = document.querySelectorAll('.vip-input');

        // 1. ĐƯA MỌI THỨ VỀ TRẠNG THÁI XEM (Viewing Mode)
        isEditMode = false;

        // Reset nút bấm về trạng thái ban đầu
        if (btn) {
            btn.innerHTML = `<i class="ri-pencil-line"></i> <span>Enter Edit Mode</span>`;
            btn.classList.remove('bg-emerald-500/20'); // Nếu bạn có thêm class màu
        }

        // Reset các ô input về ReadOnly
        inputs.forEach(input => {
            input.readOnly = true;
            input.classList.remove('bg-white/5', 'px-2');
            input.style.borderBottomColor = "rgba(255,255,255,0.1)";
        });

        // 2. HIỆU ỨNG GSAP ĐỂ ĐÓNG
        // Thu nhỏ container và xóa bỏ Shadow (Neon)
        gsap.to(container, {
            scale: 0.8,
            opacity: 0,
            boxShadow: "none", // Xóa hiệu ứng Neon ngay khi đóng
            borderColor: "rgba(255,255,255,0.1)", // Trả về màu viền mặc định
            duration: 0.4,
            ease: "power2.in"
        });

        gsap.to(bg, {
            opacity: 0,
            duration: 0.4,
            onComplete: () => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');

                // Xóa style inline để không bị lỗi màu cho lần mở sau
                container.style.transform = "";
            }
        });
    }

    // HÀM LƯU DỮ LIỆU (AJAX)
    function saveAndEncrypt() {
        const id = document.getElementById('editor-customer-id').value;
        const formData = new FormData();

        formData.append('action_type', 'save_customer');
        formData.append('id', id);
        formData.append('full_name', document.getElementById('editor-full-name').value);
        formData.append('email', document.getElementById('editor-email').value);
        formData.append('phone', document.getElementById('editor-phone').value);
        formData.append('rank', document.getElementById('editor-rank-value').value);
        formData.append('bidding_limit', document.getElementById('editor-limit-range').value);
        formData.append('avatar', document.getElementById('editor-avatar').src);

        fetch('VipVelations.php', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) throw new Error("Mã lỗi HTTP: " + res.status);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Matrix Intelligence Synchronized!");
                    location.reload();
                } else {
                    alert("Lỗi database: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Lỗi: Không thể đọc JSON. Có thể PHP bị lỗi cú pháp hoặc in dư thẻ HTML.");
            });
    }
    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Hiệu ứng Biometric Scan khi vào section
        const laserLine = document.getElementById('laser-line');

        ScrollTrigger.create({
            trigger: "#kyc-vault",
            start: "top center",
            onEnter: () => {
                gsap.fromTo(laserLine, {
                    top: 0,
                    opacity: 1
                }, {
                    top: "100%",
                    opacity: 0,
                    duration: 2,
                    ease: "power1.inOut",
                    repeat: 2
                });
            }
        });

        // 2. Kéo thả so sánh (Simple Draggable)
        const selfie = document.getElementById('selfie-card');
        let isDragging = false;
        let offset = [0, 0];

        selfie.addEventListener('mousedown', (e) => {
            isDragging = true;
            offset = [selfie.offsetLeft - e.clientX, selfie.offsetTop - e.clientY];
        });

        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                selfie.style.left = (e.clientX + offset[0]) + 'px';
                selfie.style.top = (e.clientY + offset[1]) + 'px';
                selfie.style.position = 'absolute';
            }
        });

        document.addEventListener('mouseup', () => isDragging = false);
    });

    // 3. Paper Mode (Bảo vệ mắt Admin)
    function togglePaperMode() {
        document.body.classList.toggle('paper-active');
    }

    // 4. Stamp of Authority (Duyệt hồ sơ)
    function stampApprove() {
        const btn = document.getElementById('btn-approve');
        const idPane = document.getElementById('evidence-pane');

        // Tạo con dấu ảo
        const stamp = document.createElement('div');
        stamp.className = 'stamp-overlay';
        stamp.innerHTML = `
        <div class="border-8 border-emerald-500 text-emerald-500 p-8 rounded-full font-black text-6xl uppercase transform -rotate-12">
            APPROVED
            <div class="text-[10px] text-center font-mono">HASH: 0x8891...B2</div>
        </div>
    `;
        idPane.appendChild(stamp);

        // Hiệu ứng GSAP đóng dấu
        gsap.to(stamp, {
            opacity: 1,
            scale: 1,
            duration: 0.3,
            ease: "back.out(1.7)",
            onComplete: () => {
                // Rung nhẹ màn hình (Haptic)
                if (window.navigator.vibrate) window.navigator.vibrate([50, 30, 50]);

                // Âm thanh trầm đục (Giả lập bằng log)
                console.log("Authority Stamp Sound: THUD!");

                // Xóa sau 2 giây
                setTimeout(() => {
                    gsap.to(stamp, {
                        opacity: 0,
                        duration: 1,
                        onComplete: () => stamp.remove()
                    });
                }, 2000);
            }
        });

        // Chuyển nút sang trạng thái thành công
        btn.innerHTML = '<i class="ri-check-line"></i> PROFILE VERIFIED';
        btn.classList.add('bg-emerald-900');
    }
    // Tự động sửa lỗi ảnh cho toàn bộ trang
    document.querySelectorAll('img').forEach(img => {
        img.onerror = function() {
            this.src = "https://placehold.co/600x400/0a0a0a/0891B2?text=ENCRYPTED+DATA";
        };
    });
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');

                // 1. Cập nhật UI Nút (Active state)
                tabs.forEach(t => {
                    t.classList.remove('text-cyan-400', 'border-b-2', 'border-cyan-400');
                    t.classList.add('text-white/40');
                });
                tab.classList.add('text-cyan-400', 'border-b-2', 'border-cyan-400');
                tab.classList.remove('text-white/40');

                // 2. Hiệu ứng chuyển nội dung bằng GSAP
                gsap.to(contents, {
                    opacity: 0,
                    y: 10,
                    duration: 0.2,
                    display: 'none',
                    onComplete: () => {
                        const activeContent = document.getElementById(`content-${target}`);
                        activeContent.style.display = 'flex';
                        if (target === 'bio') activeContent.style.display = 'block';

                        gsap.fromTo(activeContent, {
                            opacity: 0,
                            y: -10
                        }, {
                            opacity: 1,
                            y: 0,
                            duration: 0.4,
                            ease: "power2.out"
                        });
                    }
                });

                // Haptic feedback khi bấm tab
                if (window.navigator.vibrate) window.navigator.vibrate(5);
            });
        });
    });
    const rejectModal = document.getElementById('reject-modal');
    const kycVault = document.getElementById('kyc-vault');

    function openRejectModal() {
        rejectModal.classList.add('show');
        // Hiệu ứng GSAP mở modal
        gsap.fromTo("#reject-modal div.relative", {
            scale: 0.8,
            opacity: 0
        }, {
            scale: 1,
            opacity: 1,
            duration: 0.3,
            ease: "back.out(1.7)"
        });
    }

    function closeRejectModal() {
        gsap.to("#reject-modal div.relative", {
            scale: 0.8,
            opacity: 0,
            duration: 0.2,
            onComplete: () => rejectModal.classList.remove('show')
        });
    }

    function confirmReject(reason) {
        console.log(`Hồ sơ bị từ chối vì: ${reason}`);

        // 1. Đóng modal
        closeRejectModal();

        // 2. Rung mạnh thiết bị (Haptic cho hồ sơ nghi vấn)
        if (window.navigator.vibrate) window.navigator.vibrate([100, 50, 100]);

        // 3. Hiệu ứng rung khung KYC
        kycVault.classList.add('shake-error');
        setTimeout(() => kycVault.classList.remove('shake-error'), 500);

        // 4. Hiệu ứng "Ghost Out" - Làm mờ hồ sơ đã bị loại
        gsap.to("#evidence-pane", {
            filter: "sepia(1) saturate(2) hue-rotate(-50deg) blur(2px)",
            opacity: 0.5,
            duration: 1
        });

        // Thông báo cho Admin
        alert(`REJECTED: ${reason}. Notification sent to VIP.`);
    }

    // ----------------------------- section 4 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Khởi tạo biểu đồ Engagement Flow (Chart.js)
        const ctx = document.getElementById('engagementChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['12pm', '3pm', '6pm', '9pm', '12am', '3am'],
                datasets: [{
                    label: 'VIP Online',
                    data: [12, 19, 15, 45, 30, 8],
                    borderColor: '#0891B2',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 0,
                    fill: true,
                    backgroundColor: (context) => {
                        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
                        gradient.addColorStop(0, 'rgba(8, 145, 178, 0.4)');
                        gradient.addColorStop(1, 'rgba(8, 145, 178, 0)');
                        return gradient;
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.2)',
                            font: {
                                size: 8
                            }
                        }
                    }
                }
            }
        });

        // 2. Hiệu ứng Neural Connection (Phản biện 2)
        window.triggerNeural = function(keyword) {
            // Giả lập tìm các thẻ ở Section 2 có cùng sở thích
            const cards = document.querySelectorAll('.member-card');

            // Haptic Feedback
            if (window.navigator.vibrate) window.navigator.vibrate(10);

            // Phát sáng thẻ ngẫu nhiên để mô phỏng sự kết nối
            cards.forEach((card, index) => {
                if (index % 2 === 0) {
                    card.classList.add('neural-glow');
                    setTimeout(() => card.classList.remove('neural-glow'), 2000);
                }
            });

            showGhostNotif(`AI: Matching VIPs interested in "${keyword}"...`);
        };

        // 3. Hiệu ứng Ghost Notification
        function showGhostNotif(message) {
            const container = document.getElementById('ghost-notif-container');
            const notif = document.createElement('div');
            notif.className = 'ghost-notif';
            notif.innerHTML = `
            <div class="w-2 h-2 bg-cyan-500 rounded-full animate-ping"></div>
            <span>${message}</span>
        `;

            container.appendChild(notif);

            // GSAP hiệu ứng trượt vào
            gsap.fromTo(notif, {
                x: 100,
                opacity: 0
            }, {
                x: 0,
                opacity: 1,
                duration: 0.5,
                ease: "back.out(1.7)"
            });

            // Tự động xóa sau 3 giây
            setTimeout(() => {
                gsap.to(notif, {
                    x: 50,
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => notif.remove()
                });
            }, 3000);
        }

        // Giả lập tin nhắn Concierge mới sau 5 giây
        setTimeout(() => {
            showGhostNotif("New Concierge Request from Diamond Member");
        }, 5000);
    });
    // Biến lưu trữ instance của biểu đồ để cập nhật
    let engagementChart;

    // Dữ liệu mẫu cho các khoảng thời gian
    const timeframeData = {
        '7': {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            values: [12, 45, 28, 60, 42, 85, 50],
            peak: "21:00 - 23:00",
            retention: "88.4%"
        },
        '30': {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            values: [150, 230, 180, 310],
            peak: "Weekend Nights",
            retention: "92.1%"
        }
    };

    function updateTimeframe(element, days) {
        // 1. Chuyển đổi trạng thái Active trên UI
        document.querySelectorAll('.time-pill').forEach(pill => pill.classList.remove('active'));
        element.classList.add('active');

        // 2. Lấy dữ liệu mới
        const data = timeframeData[days];

        // 3. Cập nhật Biểu đồ (Engagement Flow) với hiệu ứng GSAP
        if (engagementChart) {
            engagementChart.data.labels = data.labels;
            engagementChart.data.datasets[0].data = data.values;

            // Hiệu ứng update mượt mà của Chart.js
            engagementChart.update('active');
        }

        // 4. Cập nhật các con số thống kê bên dưới biểu đồ
        const statsContainer = element.closest('#vip-pulse').querySelectorAll('.text-xs.text-white.font-bold, .text-xs.text-emerald-400.font-bold');

        // Giả lập hiệu ứng nhảy số
        gsap.from(statsContainer, {
            innerText: 0,
            duration: 0.5,
            snap: {
                innerText: 0.1
            },
            stagger: 0.1
        });

        statsContainer[0].innerText = data.peak;
        statsContainer[1].innerText = data.retention;

        // 5. Haptic feedback
        if (window.navigator.vibrate) window.navigator.vibrate(5);

        console.log(`Switching Matrix Intelligence to ${days} days...`);
    }

    // Lưu ý: Trong phần khởi tạo Chart.js cũ của bạn, hãy gán nó vào biến engagementChart
    // Ví dụ: engagementChart = new Chart(ctx, { ... });

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>