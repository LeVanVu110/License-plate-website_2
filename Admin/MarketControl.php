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
require_once dirname(__DIR__) . "/models/Auction.php";
require_once dirname(__DIR__) . "/models/Plate.php";

// Thêm vào đoạn đầu file PHP
$auctionModel = new Auction();
$availablePlates = $auctionModel->getAvailablePlates();
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* ----------------------------- section 1 -----------------------------  */
        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Hiệu ứng Sapphire Pulse */
        .pulse-ring {
            animation: pulse-ripple 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ripple {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* Sticky Header shrink when scroll */
        .header-shrink {
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            padding-top: 0 !important;
        }

        .header-shrink>div {
            border-radius: 0 0 20px 20px !important;
            border-top: none !important;
        }

        /* Mobile Swipe Simulation */
        @media (max-width: 768px) {
            #market-header {
                top: 0;
                left: 0;
                right: 0;
            }

            #market-header>div {
                border-radius: 0;
            }
        }

        /* Đảm bảo nội dung không bị Header fixed che mất */
        #market-grid {
            /* padding-top: 140px; */
            /* Khoảng cách này đủ để Header lơ lửng không đè lên content */
            z-index: 10;
            /* Khoảng cách an toàn để hiện 3 sản phẩm đầu */
            margin-top: 20px;
        }

        /* Trên mobile, Header có thể cao hơn, ta điều chỉnh thêm */
        @media (max-width: 1024px) {
            #market-grid {
                padding-top: 100px;
                margin-left: 0 !important;
            }

            .frontsize {
                font-size: 12px !important;
                margin-left: 10px;
            }

            #server-time {
                margin-left: 10px;
            }

        }

        /* Hiệu ứng Sticky Header khi cuộn trang */
        .header-shrink {
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            padding: 0 !important;
        }

        .header-shrink>div {
            border-radius: 0 0 20px 20px !important;
            border-top: none !important;
        }


        /* ----------------------------- section 2 -----------------------------  */
        /* Custom Scrollbar cho bảng */
        .custom-scrollbar::-webkit-scrollbar {
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(6, 182, 212, 0.2);
            border-radius: 10px;
        }

        /* Hiệu ứng mờ khi Pause */
        .row-paused {
            filter: grayscale(1);
            opacity: 0.5;
            pointer-events: none;
        }

        .row-paused::after {
            content: "PAUSED";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-family: 'JetBrains Mono';
            font-size: 10px;
            letter-spacing: 5px;
            animation: blink 2s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Bid Flash Animation */
        @keyframes flash-sweep {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .flash-active .bid-flash-overlay {
            animation: flash-sweep 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Z-Depth Hover effect */
        .grid-row {
            transform: translateZ(0);
            will-change: transform, box-shadow;
        }

        .grid-row:hover {
            transform: translateY(-4px) scale(1.01);
            z-index: 10;
        }

        .custom-grid-scrollbar::-webkit-scrollbar {
            width: 4px;
            /* Độ rộng thanh cuộn rất mỏng */
            /* padding-right: 8px; */
        }

        .custom-grid-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }

        .custom-grid-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #06b6d4, #3b82f6);
            /* Gradient từ Cyan sang Blue */
            border-radius: 10px;
        }

        .custom-grid-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #22d3ee;
        }

        /* Hiệu ứng mượt mà khi cuộn trên Mobile */
        .custom-grid-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #06b6d4 rgba(255, 255, 255, 0.02);
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        #grid-container {
            min-height: 450px;
            /* Đảm bảo khung hình ổn định khi trang chỉ có 1-2 sản phẩm */
            display: flex;
            flex-direction: column;
            gap: 12px;
        }


        /* Mobile Hybrid Cards */
        @media (max-width: 1023px) {
            #grid-container {
                min-width: 100% !important;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .grid-row {
                display: flex;
                flex-direction: column;
                padding: 1.5rem;
                height: auto;
                align-items: flex-start;
            }

            .grid-row>div {
                width: 100%;
                margin-bottom: 1rem;
            }

            .grid-row .col-span-12,
            .grid-row .col-span-3,
            .grid-row .col-span-2 {
                grid-column: span 6 / span 2;
            }

            .grid-row .justify-end {
                justify-content: flex-start;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* ----------------------------- SECTION 3: INTERVENTION PANEL ----------------------------- */

        /* Trạng thái mặc định: Panel nằm ngoài màn hình bên phải */
        #intervention-panel {
            transform: translateX(100%);
            will-change: transform;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.5s ease;
        }

        /* Khi có class .active: Panel trượt vào */
        #intervention-panel.active {
            transform: translateX(0);
        }

        /* Hiệu ứng Emergency: Chuyển tông màu sang Hổ phách mờ khi Pause phiên */
        #intervention-panel.emergency-mode {
            background-color: rgba(45, 20, 0, 0.95) !important;
            border-left: 1px solid rgba(245, 158, 11, 0.5);
            box-shadow: -20px 0 60px rgba(245, 158, 11, 0.15);
        }

        /* Hiệu ứng 3D cho Biển số */
        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }

        /* Thanh trượt bước giá (Custom Range Input) */
        #intervention-panel input[type=range] {
            -webkit-appearance: none;
            background: rgba(255, 255, 255, 0.1);
            height: 4px;
            border-radius: 10px;
        }

        #intervention-panel input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #06b6d4;
            /* Cyan 500 */
            cursor: pointer;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.6);
            border: 2px solid #fff;
            transition: transform 0.2s ease;
        }

        #intervention-panel input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        /* Hiệu ứng vòng xoay đồng bộ (Sync Spinner) */
        @keyframes spin-sync {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .sync-spinner {
            animation: spin-sync 1s linear infinite;
        }

        /* Tùy chỉnh thanh cuộn nội bộ của Panel */
        #intervention-panel .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
        }

        #intervention-panel .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        #intervention-panel .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Hiệu ứng loang sáng xung quanh biển số (Pulse Aura) */
        @keyframes plate-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0.4);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(6, 182, 212, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0);
            }
        }

        #intervention-panel .animate-pulse-aura {
            animation: plate-pulse 2s infinite;
        }

        /* Responsive cho Mobile */
        @media (max-width: 1023px) {
            #intervention-panel {
                width: 100% !important;
                height: 90vh !important;
                top: auto !important;
                bottom: 0 !important;
                transform: translateY(100%);
                /* Trượt từ dưới lên trên mobile */
                border-left: none;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 30px 30px 0 0;
            }

            #intervention-panel.active {
                transform: translateY(0);
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        .animate-pulse-fast {
            animation: pulse-glow 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 1;
                transform: scaleY(1);
            }

            50% {
                opacity: 0.7;
                transform: scaleY(1.1);
            }
        }

        #strategy-marquee {
            animation: marquee-scroll 25s linear infinite;
            padding-left: 100%;
        }

        @keyframes marquee-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .temp-bar {
            transform-origin: bottom;
        }

        /* Mobile Drawer Logic */
        @media (max-width: 1023px) {
            #sentiment-hub {
                left: 0 !important;
                margin-left: 0 !important;
            }

            #sentiment-content.drawer-open {
                height: 220px !important;
            }
        }

        /* ----------------------------- section 5 -----------------------------  */
        @media (max-width: 1023px) {
            #forge-container {
                height: 100vh;
                width: 100vw;
                border-radius: 0;
            }

            #stage-1 {
                grid-template-cols: 1fr !important;
            }

            /* Picker style for mobile input */
            input[type="number"] {
                font-size: 20px;
                text-align: center;
            }
        }

        .rotate-y-12 {
            transform: rotateY(12deg) rotateX(5deg);
        }

        #forge-overlay {
            position: fixed;
            width: 200px;
            /* Kích thước khởi tạo nhỏ */
            height: 200px;
            /* background: radial-gradient(square,rgba(6, 182, 212, 0.15) 0%, rgba(0, 8, 20, 0.95) 70%); */
            pointer-events: none;
            z-index: -1;
        }

        /* Hiệu ứng rung nhẹ khi nhập giá sai (Data Validation Glow) */
        .input-error-shake {
            border-color: #f43f5e !important;
            /* Rose-500 */
            box-shadow: 0 0 15px rgba(244, 63, 94, 0.3);
        }

        /* Thẻ biển số 3D xoay trong Forge */
        #plate-preview-3d {
            transition: transform 0.1s ease-out;
            transform-style: preserve-3d;
        }

        /* Khai báo will-change để GPU chuẩn bị trước */
        #traffic-surveillance,
        .will-change-transform {
            will-change: transform, opacity;
            transform: translateZ(0);
            /* Kích hoạt 3D acceleration */
        }

        /* Radar Scan effect cực nhẹ */
        @keyframes scan-line {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(1000%);
            }
        }

        /* Blur mượt mà hơn trên webkit */
        /* .backdrop-blur-2xl {
            -webkit-backdrop-filter: blur(40px);
            backdrop-filter: blur(40px);
        } */

        #forge-overlay,
        #forge-container {
            will-change: transform, opacity;
            backface-visibility: hidden;
            /* Giúp render mượt hơn trên Chrome/Safari */
        }

        @media (max-width: 640px) {
            .step-item span {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }
        }

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <header id="market-header" class="fixed top-6 left-6 right-6 lg:left-[284px] z-[50] transition-all duration-500">
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl px-6 py-3 flex items-center justify-between shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">

            <div class="absolute inset-0 sapphire-dust opacity-10 pointer-events-none"></div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="relative">
                    <div class="pulse-ring absolute -inset-1 bg-cyan-500/30 rounded-full blur-sm"></div>
                    <div class="w-3 h-3 bg-cyan-400 rounded-full relative"></div>
                </div>
                <div>
                    <h1 class="playfair text-white text-lg tracking-wider font-bold frontsize">MARKET CONTROL</h1>
                    <p id="server-time" class="space-mono text-[9px] text-cyan-400/70 uppercase tracking-[2px]">00:00:00 GMT+7</p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-10 relative z-10">
                <div class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="113" stroke-dashoffset="30" class="text-cyan-400 ring-progress transition-all duration-1000"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center space-mono text-[8px] text-white">72%</span>
                    </div>
                    <span class="text-[9px] text-white/40 space-mono leading-tight">ACTIVE<br>DISPUTE</span>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="113" stroke-dashoffset="80" class="text-amber-400 ring-progress transition-all duration-1000"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center space-mono text-[8px] text-white">28%</span>
                    </div>
                    <span class="text-[9px] text-white/40 space-mono leading-tight">ENDING<br>SOON</span>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="113" stroke-dashoffset="15" class="text-emerald-400 ring-progress transition-all duration-1000"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center space-mono text-[8px] text-white">85%</span>
                    </div>
                    <span class="text-[9px] text-white/40 space-mono leading-tight">PRICE<br>SURGE</span>
                </div>
            </div>

            <div class="flex items-center gap-4 relative z-10">
                <div id="search-container" class="relative group">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                    <input type="text" placeholder="AI Intelligence Search..." class="bg-white/5 border border-white/10 rounded-xl py-2 pl-10 pr-4 text-[11px] text-white w-40 focus:w-64 focus:bg-black/60 focus:border-cyan-500/50 transition-all duration-500 outline-none jetbrains">
                </div>
                <button id="new-auction-btn" onclick="openForge(event)" class="hidden lg:flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-700 hover:from-cyan-500 hover:to-blue-600 text-white text-[10px] font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-cyan-900/20 active:scale-95 jetbrains">
                    <i class="ri-add-circle-line text-sm"></i> NEW AUCTION
                </button>
            </div>
        </div>
    </header>

    <button onclick="openForge(event)" class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-cyan-500 rounded-full shadow-2xl z-[100] flex items-center justify-center text-white text-2xl active:scale-90 transition-transform">
        <i class="ri-add-line"></i>
    </button>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="market-grid" class="relative pt-[120px] pb-20 px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500">
        <div class="container mx-auto max-w-[1600px]">

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            </div>
            <h3 class="playfair text-white text-xl font-bold tracking-wider">THE INTELLIGENCE MATRIX</h3>
            <p class="space-mono text-[10px] text-white/30 uppercase tracking-[3px]">Real-time Asset Monitoring</p>
        </div>

        <div class="flex items-center gap-3 bg-black/40 p-1 rounded-xl border border-white/10">
            <button onclick="sortGrid('price')" class="px-4 py-2 rounded-lg jetbrains text-[10px] text-white/60 hover:text-cyan-400 hover:bg-white/5 transition-all">SORT BY PRICE</button>
            <button onclick="sortGrid('time')" class="px-4 py-2 rounded-lg jetbrains text-[10px] text-white/60 hover:text-cyan-400 hover:bg-white/5 transition-all">SORT BY TIME</button>
        </div>
        </div>

        <div class="w-full bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-md">

            <div class="hidden lg:grid grid-cols-12 px-8 py-4 bg-white/10 border-b border-white/10 space-mono text-[10px] text-white/40 uppercase tracking-widest">
                <div class="col-span-3">Asset Identifier</div>
                <div class="col-span-2">Valuation Pulse</div>
                <div class="col-span-2">Density</div>
                <div class="col-span-2">Time Horizon</div>
                <div class="col-span-3 text-right">Authority Tools</div>
            </div>

            <div id="grid-container" class="max-h-[700px] overflow-y-auto custom-grid-scrollbar p-4 space-y-3 scroll-mt-10">
                <?php
                $auctionModel = new Auction();
                $allAuctions = $auctionModel->getAllAuctionsDetail();

                foreach ($allAuctions as $auc):
                    // 1. Tính toán phần trăm tăng trưởng (Current vs Starting)
                    $startingPrice = $auc['starting_price'];
                    $currentPrice = $auc['current_max_bid'];
                    $increasePercent = ($currentPrice > $startingPrice)
                        ? round((($currentPrice - $startingPrice) / $startingPrice) * 100)
                        : 0;

                    // 2. Xác định màu sắc theo trạng thái
                    $statusColor = 'text-amber-500'; // Mặc định là đang đấu
                    if ($auc['plate_status'] == 'Sold') $statusColor = 'text-red-500';
                    if ($auc['plate_status'] == 'Available') $statusColor = 'text-blue-500';
                ?>

                    <div class="grid-row group grid grid-cols-12 items-center px-8 py-6 bg-[#0A0A0A]/60 backdrop-blur-md border border-white/5 rounded-2xl hover:border-cyan-500/30 transition-all duration-500 relative overflow-hidden mb-4">
                        <div class="bid-flash-overlay absolute inset-0 bg-gradient-to-r from-transparent via-cyan-500/10 to-transparent -translate-x-full pointer-events-none"></div>

                        <div class="col-span-3 flex items-center gap-1">
                            <div class="bg-gradient-to-br from-gray-300 to-gray-500 p-[1px] rounded-lg shadow-lg shadow-black">
                                <div class="bg-white px-2 py-1.5 rounded-[7px] border border-black/20">
                                    <span class="text-black font-bold jetbrains text-sm tracking-tighter">
                                        <?php echo $auc['plate_number']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <p class="text-cyan-400 font-bold jetbrains text-base rolling-number"
                                data-value="<?php echo number_format($currentPrice, 0, '.', '.'); ?>">
                                <?php echo number_format($currentPrice, 0, '.', '.'); ?>
                            </p>
                            <p class="text-[9px] text-emerald-400 space-mono">↑ +<?php echo $increasePercent; ?>% START</p>
                        </div>

                        <div class="col-span-2 flex items-center gap-4">
                            <div class="flex items-center gap-1.5">
                                <i class="ri-eye-line text-white/20 text-xs"></i>
                                <span class="text-white/60 jetbrains text-[10px]">1.2k</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ri-auction-line text-white/20 text-xs"></i>
                                <span class="text-white/60 jetbrains text-[10px]">
                                    <?php echo $auc['total_bids']; ?>
                                </span>
                            </div>
                        </div>

                        <!-- <div class="col-span-2 flex items-center gap-3">
                            <div class="relative w-10 h-10">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" fill="transparent"
                                        stroke-dasharray="100" stroke-dashoffset="30"
                                        class="<?php echo $statusColor; ?> transition-all duration-1000"></circle>
                                </svg>
                                <i class="ri-time-line absolute inset-0 flex items-center justify-center text-[10px] <?php echo $statusColor; ?>"></i>
                            </div>
                            <span class="countdown-timer <?php echo $statusColor; ?> jetbrains text-[11px] font-bold"
                                data-end="<?php echo $auc['display_end_time']; ?>">
                                --:--:--
                            </span>
                        </div> -->
                        <div class="col-span-2 flex items-center gap-3">
                            <div class="relative w-10 h-10">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" fill="transparent"
                                        stroke-dasharray="100"
                                        stroke-dashoffset="<?php echo ($auc['is_paused'] == 1) ? '0' : '30'; ?>"
                                        class="<?php echo ($auc['is_paused'] == 1) ? 'text-amber-500' : $statusColor; ?> transition-all duration-1000"></circle>
                                </svg>
                                <i class="ri-time-line absolute inset-0 flex items-center justify-center text-[10px] <?php echo ($auc['is_paused'] == 1) ? 'text-amber-500' : $statusColor; ?>"></i>
                            </div>

                            <?php if ($auc['is_paused'] == 1): ?>
                                <div class="flex flex-col">
                                    <span class="text-amber-500 jetbrains text-[11px] font-bold uppercase tracking-tighter">
                                        Paused
                                    </span>
                                    <span class="text-amber-500/70 jetbrains text-[10px] font-medium">
                                        <?php
                                        $r = $auc['remaining_seconds'];
                                        $h = floor($r / 3600);
                                        $m = floor(($r % 3600) / 60);
                                        $s = $r % 60;
                                        echo sprintf("%02d:%02d:%02d", $h, $m, $s);
                                        ?>
                                    </span>
                                </div>
                            <?php else: ?>
                                <span class="countdown-timer <?php echo $statusColor; ?> jetbrains text-[11px] font-bold"
                                    data-end="<?php echo $auc['display_end_time']; ?>">
                                    --:--:--
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="col-span-3 flex justify-end gap-2">
                            <button onclick="handlePause(this, <?php echo $auc['id']; ?>)"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-all <?php echo ($auc['is_paused'] == 1) ? 'bg-amber-500/20 text-amber-500' : 'bg-white/5 text-white/40 hover:bg-white/10 hover:text-white'; ?>">

                                <i class="<?php echo ($auc['is_paused'] == 1) ? 'ri-play-fill' : 'ri-pause-line'; ?>"></i>
                            </button>
                            <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 hover:text-white transition-all">
                                <i class="ri-time-fill"></i>
                            </button>

                            <?php if ($auc['plate_status'] == 'Auctioning'): ?>
                                <!-- <button
                                    class="px-4 h-8 rounded-lg bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[9px] jetbrains font-bold hover:bg-cyan-500 hover:text-black transition-all"
                                    onclick="openIntervention('<?php echo $auc['plate_number']; ?>')">
                                    BOOST
                                </button> -->
                                <button
                                    class="px-4 h-8 rounded-lg bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[9px] jetbrains font-bold hover:bg-cyan-500 hover:text-black transition-all"
                                    onclick="openIntervention(<?php echo $auc['id']; ?>, '<?php echo $auc['plate_number']; ?>')">
                                    BOOST
                                </button>
                            <?php else: ?>
                                <button class="px-4 h-8 rounded-lg bg-white/5 border border-white/10 text-white/40 text-[9px] jetbrains font-bold cursor-not-allowed">
                                    CLOSED
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endforeach; ?>

                <div class="flex justify-center items-center gap-4 mt-8 pb-10">
                    <button onclick="prevPage()" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-white/40 hover:bg-cyan-500 hover:text-black transition-all duration-300">
                        <i class="ri-arrow-left-s-line"></i>
                    </button>

                    <div id="pagination-numbers" class="flex gap-2">
                    </div>

                    <button onclick="nextPage()" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-white/40 hover:bg-cyan-500 hover:text-black transition-all duration-300">
                        <i class="ri-arrow-right-s-line"></i>
                    </button>
                </div>
            </div>

        </div>
        </div>
    </section>


    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="intervention-panel" class="fixed top-0 right-0 h-full w-[420px] bg-[#050505]/90 backdrop-blur-3xl border-l border-white/10 z-[100] translate-x-full shadow-[-30px_0_60px_rgba(0,0,0,0.9)] transition-all duration-500">

        <div id="panel-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[-1] opacity-0"></div>

        <div class="flex flex-col h-full p-8 overflow-y-auto custom-scrollbar relative">
            <button onclick="closePanel()" class="absolute top-6 left-6 text-white/30 hover:text-cyan-400 transition-all active:scale-90">
                <i class="ri-arrow-right-double-line text-2xl"></i>
            </button>

            <div class="mt-12 text-center">
                <div class="relative inline-block perspective-1000">
                    <div class="absolute -inset-4 bg-cyan-500/15 rounded-2xl blur-2xl animate-pulse"></div>
                    <div class="relative bg-gradient-to-br from-gray-100 to-gray-400 p-[2px] rounded-xl shadow-[0_20px_40px_rgba(0,0,0,0.7)] transform-style-3d hover:rotate-y-12 transition-transform duration-700">
                        <div class="bg-white px-10 py-5 rounded-[10px] border-2 border-black/5">
                            <span id="target-plate-display" class="text-black font-black text-4xl jetbrains tracking-tighter">30L-999.99</span>
                        </div>
                    </div>
                </div>
                <p class="space-mono text-[10px] text-cyan-400 mt-8 tracking-[5px] uppercase">Authority Control Mode</p>
            </div>

            <div id="control-core" class="mt-12 space-y-12">
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <label class="jetbrains text-[10px] text-white/30 uppercase tracking-widest">Gia hạn thời gian</label>
                        <span class="text-amber-500 jetbrains text-[11px] font-bold">+00:15:00</span>
                    </div>
                    <!-- <div class="grid grid-cols-3 gap-2">
                        <button class="py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] text-white jetbrains hover:bg-cyan-500/20 hover:border-cyan-500/40 transition-all">+2 PHÚT</button>
                        <button class="py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] text-white jetbrains hover:bg-cyan-500/20 hover:border-cyan-500/40 transition-all">+5 PHÚT</button>
                        <button class="py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] text-white jetbrains hover:bg-cyan-500/20 hover:border-cyan-500/40 transition-all">+10 PHÚT</button>
                    </div> -->
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="selectMinutes(this, 120)" class="minute-btn py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] text-white jetbrains hover:bg-cyan-500/20 transition-all">+2 PHÚT</button>
                        <button onclick="selectMinutes(this, 300)" class="minute-btn py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] text-white jetbrains hover:bg-cyan-500/20 transition-all">+5 PHÚT</button>
                        <button onclick="selectMinutes(this, 600)" class="minute-btn py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] text-white jetbrains hover:bg-cyan-500/20 transition-all">+10 PHÚT</button>
                    </div>
                </div>

                <div class="space-y-5">
                    <label class="jetbrains text-[10px] text-white/30 uppercase tracking-widest">Bước giá (Override)</label>
                    <input type="range" min="1" max="100" value="10" class="w-full h-1.5 bg-white/10 rounded-lg appearance-none cursor-pointer accent-cyan-500">
                    <div class="flex justify-between space-mono text-[9px] text-white/40">
                        <span>MIN: 1M</span>
                        <span class="text-cyan-400 font-bold">SET: 10M</span>
                    </div>
                </div>

                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-white/5 to-transparent rounded-2xl border border-white/10">
                    <div>
                        <p class="jetbrains text-sm text-white font-bold">Tạm dừng phiên</p>
                        <p class="text-[10px] text-white/20 jetbrains uppercase mt-1">Immediate Halt</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                            onchange="toggleEmergencyHalt(this, <?php echo $auc['id']; ?>)"
                            class="sr-only peer"
                            <?php echo ($auc['is_paused'] == 1) ? 'checked' : ''; ?>>
                        <div class="w-12 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white/60 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                    </label>
                </div>
                <!-- <div class="flex items-center justify-between p-5 bg-gradient-to-r from-white/5 to-transparent rounded-2xl border border-white/10">
                    <div>
                        <p class="jetbrains text-sm text-white font-bold">Tạm dừng phiên</p>
                        <p class="text-[10px] text-white/20 jetbrains uppercase mt-1">Immediate Halt</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                            onchange="toggleEmergencyHalt(this, <?php echo $auc['id']; ?>)"
                            class="sr-only peer"
                            <?php echo ($auc['status'] === 'Paused') ? 'checked' : ''; ?>>
                        <div class="w-12 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white/60 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                    </label>
                </div> -->
            </div>

            <div class="mt-auto pt-12">
                <label class="jetbrains text-[10px] text-white/30 uppercase tracking-widest block mb-4">Thông báo Live</label>
                <div class="relative group">
                    <textarea placeholder="Nhập nội dung cảnh báo..." class="w-full bg-black/60 border border-white/10 rounded-2xl p-5 text-xs text-white outline-none focus:border-cyan-500/50 transition-all h-28 resize-none jetbrains"></textarea>
                    <button class="absolute bottom-4 right-4 w-10 h-10 bg-cyan-600 text-white rounded-xl flex items-center justify-center hover:bg-cyan-400 hover:text-black transition-all shadow-lg shadow-cyan-900/40">
                        <i class="ri-broadcast-line text-lg"></i>
                    </button>
                </div>

                <!-- <button onclick="pushToSystem()" class="mt-8 w-full py-4 bg-gradient-to-r from-cyan-600 to-blue-700 rounded-xl text-white jetbrains text-[11px] font-bold tracking-[3px] flex items-center justify-center gap-3">
                    <div class="sync-spinner w-4 h-4 border-2 border-white/20 border-t-white rounded-full hidden"></div>
                    PUSH TO SYSTEM
                </button> -->
                <button onclick="pushToSystem()" class="mt-8 w-full py-4 bg-gradient-to-r from-cyan-600 to-blue-700 rounded-xl text-white jetbrains text-[11px] font-bold tracking-[3px] flex items-center justify-center gap-3">
                    <div class="sync-spinner w-4 h-4 border-2 border-white/20 border-t-white rounded-full hidden"></div>
                    PUSH TO SYSTEM
                </button>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="sentiment-hub" class="fixed bottom-0 left-0 right-0 lg:left-[260px] group-[.collapsed]:lg:left-[80px] z-[40] transition-all duration-500">
        <div onclick="toggleSentimentDrawer()" class="lg:hidden bg-gradient-to-r from-[#001D3D] to-[#003566] p-3 flex justify-between items-center border-t border-white/10 cursor-pointer shadow-2xl">
            <div class="flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-orange-500 animate-ping"></span>
                <span class="space-mono text-[10px] text-white">MARKET SENTIMENT: HIGH 🔥</span>
            </div>
            <i id="drawer-icon" class="ri-arrow-up-s-line text-white"></i>
        </div>

        <div id="sentiment-content" class="bg-[#000814]/95 backdrop-blur-2xl border-t border-white/10 px-6 py-4 lg:py-6 h-[0px] lg:h-auto overflow-hidden lg:overflow-visible transition-all duration-500">
            <div class="max-w-[1600px] mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 items-center">

                <div class="lg:col-span-3 flex items-center gap-6">
                    <div class="space-y-2">
                        <p class="space-mono text-[9px] text-white/40 uppercase tracking-widest">Market Temp</p>
                        <div class="flex items-end gap-1.5 h-12">
                            <div class="temp-bar w-2 bg-blue-500/30 rounded-full h-[40%] transition-all duration-700"></div>
                            <div class="temp-bar w-2 bg-blue-400/50 rounded-full h-[60%] transition-all duration-700"></div>
                            <div class="temp-bar w-2 bg-cyan-400 rounded-full h-[85%] animate-pulse-fast shadow-[0_0_10px_#22d3ee]"></div>
                            <div class="temp-bar w-2 bg-orange-500 rounded-full h-[70%] transition-all duration-700"></div>
                            <div class="temp-bar w-2 bg-red-500 rounded-full h-[95%] shadow-[0_0_15px_#ef4444]"></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-white text-xl font-bold space-mono">48 <span class="text-xs text-white/40">BPM</span></h4>
                        <p class="text-[9px] text-orange-400 font-bold uppercase tracking-tighter">Extreme Tension</p>
                    </div>
                </div>

                <div class="lg:col-span-4 border-l border-white/5 pl-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="space-mono text-[9px] text-white/40 uppercase tracking-widest">Spending Readiness (AI)</span>
                        <span class="text-emerald-400 text-[10px] space-mono">92%</span>
                    </div>
                    <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-600 to-emerald-400 w-[92%] shadow-[0_0_10px_rgba(52,211,153,0.5)]"></div>
                    </div>
                    <p class="text-[10px] text-white/30 mt-2 inter italic font-light">"High-net-worth behavior detected in 3 active sessions."</p>
                </div>

                <div class="lg:col-span-5 relative overflow-hidden bg-black/20 rounded-xl py-3 px-4 border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                            <i class="ri-lightbulb-flash-line text-emerald-400"></i>
                        </div>
                        <div class="marquee-container w-full overflow-hidden whitespace-nowrap">
                            <p id="strategy-marquee" class="inline-block text-[11px] text-emerald-400 inter font-medium tracking-wide">
                                AI INSIGHT: Thị trường đang nóng, gợi ý mở thêm 2 phiên Ngũ Quý vào 20:00 tối nay • Khối lượng truy cập từ khu vực Hà Nội tăng 140% • Đề xuất gia hạn biển 30L-888.88 thêm 5 phút...
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->
    <section id="auction-forge" class="fixed inset-0 z-[200] hidden flex items-center justify-center overflow-hidden">
        <div id="forge-container" class="relative w-[95%] max-w-5xl h-[85vh] bg-white/5 border border-white/10 rounded-[32px] shadow-[0_0_100px_rgba(0,0,0,0.8)] flex flex-col opacity-0 translate-y-20 transition-all duration-500 overflow-hidden" style="background-color: #000814;">

            <div class="px-4 md:px-10 py-6 md:py-8 border-b border-white/5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-cyan-500/20 flex items-center justify-center border border-cyan-500/30 shrink-0">
                        <i class="ri-hammer-fill text-cyan-400 text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-lg md:text-xl jetbrains tracking-tight">AUCTION FORGE</h2>
                        <p class="text-[9px] md:text-[10px] text-white/30 space-mono uppercase">V.2.0 STRATEGIC</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 md:gap-8 w-full sm:w-auto justify-between sm:justify-end border-t border-white/5 pt-4 sm:pt-0 sm:border-none">
                    <div class="step-item active flex items-center gap-2" data-step="1">
                        <span class="w-7 h-7 md:w-8 md:h-8 rounded-full border-2 border-cyan-500 flex items-center justify-center text-cyan-400 text-[10px] md:text-xs font-bold shrink-0">1</span>
                        <span class="text-[9px] md:text-[10px] text-white hidden lg:block jetbrains uppercase tracking-tighter">Asset</span>
                    </div>

                    <div class="w-6 md:w-10 h-[1px] bg-white/10"></div>

                    <div class="step-item flex items-center gap-2 opacity-30" data-step="2">
                        <span class="w-7 h-7 md:w-8 md:h-8 rounded-full border-2 border-white/20 flex items-center justify-center text-white text-[10px] md:text-xs font-bold shrink-0">2</span>
                        <span class="text-[9px] md:text-[10px] text-white hidden lg:block jetbrains uppercase tracking-tighter">Economy</span>
                    </div>

                    <div class="w-6 md:w-10 h-[1px] bg-white/10"></div>

                    <div class="step-item flex items-center gap-2 opacity-30" data-step="3">
                        <span class="w-7 h-7 md:w-8 md:h-8 rounded-full border-2 border-white/20 flex items-center justify-center text-white text-[10px] md:text-xs font-bold shrink-0">3</span>
                        <span class="text-[9px] md:text-[10px] text-white hidden lg:block jetbrains uppercase tracking-tighter">Strategy</span>
                    </div>

                    <button onclick="closeForge()" class="ml-4 w-8 h-8 md:w-10 md:h-10 rounded-full hover:bg-white/5 flex items-center justify-center text-white/40 transition-all">
                        <i class="ri-close-line text-xl md:text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="forge-stages" class="flex-1 overflow-hidden relative">

                <div id="stage-1" class="stage-content absolute inset-0 p-10 grid grid-cols-1 lg:grid-cols-2 gap-12 transition-all duration-500">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <label class="text-[10px] text-white/40 jetbrains uppercase tracking-widest">Identify Asset</label>
                            <div class="relative">
                                <select id="plate-selector" onchange="updateForgePreview(this)"
                                    class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white jetbrains focus:border-cyan-500/50 outline-none transition-all appearance-none">
                                    <option value="" class="bg-[#000814]">-- CHỌN BIỂN SỐ TỪ KHO --</option>

                                    <?php foreach ($availablePlates as $plate): ?>
                                        <option value="<?php echo $plate['id']; ?>"
                                            data-number="<?php echo $plate['plate_number']; ?>"
                                            data-price="<?php echo $plate['starting_price']; ?>"
                                            class="bg-[#000814]">
                                            <?php echo $plate['plate_number']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="ri-arrow-down-s-line absolute right-6 top-4 text-white/20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-black/40 rounded-[24px] border border-white/5 flex items-center justify-center flex-col p-8 group">
                        <div id="plate-preview-3d" class="bg-white px-12 py-6 rounded-xl shadow-2xl transition-all duration-700 transform group-hover:rotate-y-12">
                            <span class="text-black font-black text-4xl jetbrains tracking-tighter">30L-XXX.XX</span>
                        </div>
                        <p class="mt-8 text-[10px] text-white/20 jetbrains uppercase">3D Visual Confirmation</p>
                    </div>
                </div>

                <div id="stage-2" class="stage-content absolute inset-0 p-10 translate-x-full opacity-0 transition-all duration-500">
                    <div class="max-w-2xl mx-auto space-y-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <label class="text-[10px] text-white/40 jetbrains tracking-widest uppercase">Giá khởi điểm</label>
                                <input type="number" oninput="checkAIPrice(this)" class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white jetbrains outline-none">
                                <p class="text-[9px] text-cyan-400/60 inter italic">AI Suggestion: 500.000.000đ</p>
                            </div>
                            <div class="space-y-4">
                                <label class="text-[10px] text-white/40 jetbrains tracking-widest uppercase">Bước giá tối thiểu</label>
                                <input type="number" value="10000000" class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white jetbrains outline-none">
                            </div>
                        </div>
                        <div class="p-6 bg-white/5 rounded-2xl border border-white/5">
                            <label class="text-[10px] text-white/40 jetbrains tracking-widest uppercase block mb-4">Tiền đặt cọc (Deposit)</label>
                            <input type="range" class="w-full accent-cyan-500">
                            <div class="flex justify-between mt-2 text-[11px] text-white jetbrains">
                                <span>40.000.000đ</span>
                                <span class="text-cyan-400">Fixed: 20% Asset Value</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="stage-3" class="stage-content absolute inset-0 p-10 translate-x-full opacity-0 transition-all duration-500">
                    <div class="max-w-3xl mx-auto space-y-10">
                        <div class="space-y-4">
                            <label class="text-[10px] text-white/40 jetbrains uppercase tracking-widest">Thanh lịch trình (Conflict Detector)</label>
                            <div class="h-12 w-full bg-white/5 rounded-full relative flex items-center px-4 overflow-hidden border border-white/5">
                                <div class="h-full w-20 bg-amber-500/20 border-x border-amber-500/40 absolute left-20"></div>
                                <div class="h-full w-32 bg-cyan-500/40 border-x border-cyan-500 absolute left-60"></div>
                                <span class="absolute inset-0 flex items-center justify-center text-[9px] text-white/20 jetbrains uppercase">Timeline Visualization</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-6 bg-cyan-500/10 border border-cyan-500/20 rounded-2xl">
                            <div>
                                <p class="text-white text-sm font-bold">Auto-Extension Strategy</p>
                                <p class="text-[10px] text-cyan-400/60">Extend 5 mins if bid occurs in last 30s</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:bg-cyan-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-white/5 flex justify-between bg-black/20">
                <button id="prevBtn" onclick="moveStep(-1)" class="px-8 py-3 rounded-xl border border-white/10 text-white/40 text-xs jetbrains invisible transition-all">BACK</button>
                <button id="nextBtn" onclick="moveStep(1)" class="px-10 py-3 rounded-xl bg-cyan-500 text-black font-bold text-xs jetbrains hover:shadow-[0_0_20px_rgba(6,182,212,0.5)] transition-all uppercase tracking-widest">Continue</button>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Cập nhật Server Time thời gian thực
        function updateServerTime() {
            const now = new Date();
            const timeStr = now.toTimeString().split(' ')[0] + " GMT+7";
            document.getElementById('server-time').innerText = timeStr;
        }
        setInterval(updateServerTime, 1000);

        // 2. Parallax/Sticky Effect khi cuộn
        window.addEventListener('scroll', () => {
            const header = document.getElementById('market-header');
            if (window.scrollY > 50) {
                header.classList.add('header-shrink');
            } else {
                header.classList.remove('header-shrink');
            }
        });

        // 3. Animation cho các con số Rings (Data Inflow)
        gsap.from(".ring-progress", {
            strokeDashoffset: 113,
            duration: 2,
            stagger: 0.3,
            ease: "expo.out",
            scrollTrigger: {
                trigger: "#market-header",
                start: "top top"
            }
        });

        // 4. Magnetic Search Blur Effect
        const searchInput = document.querySelector('#search-container input');
        searchInput.addEventListener('focus', () => {
            gsap.to("section:not(#market-header)", {
                filter: "blur(4px)",
                opacity: 0.5,
                duration: 0.4
            });
        });
        searchInput.addEventListener('blur', () => {
            gsap.to("section:not(#market-header)", {
                filter: "blur(0px)",
                opacity: 1,
                duration: 0.4
            });
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Hiệu ứng Bid Flash giả lập (Mỗi 5 giây chọn ngẫu nhiên 1 dòng)
        setInterval(() => {
            const rows = document.querySelectorAll('.grid-row');
            const randomRow = rows[Math.floor(Math.random() * rows.length)];

            // Kích hoạt flash
            randomRow.classList.add('flash-active');
            setTimeout(() => randomRow.classList.remove('flash-active'), 1000);

            // Hiệu ứng lăn số (Rolling number)
            const priceTag = randomRow.querySelector('.rolling-number');
            const currentVal = parseInt(priceTag.getAttribute('data-value').replace(/\./g, ''));
            const newVal = currentVal + 5000000;

            gsap.to(priceTag, {
                innerText: newVal,
                duration: 1,
                snap: {
                    innerText: 1
                },
                onUpdate: function() {
                    priceTag.innerHTML = parseInt(this.targets()[0].innerText).toLocaleString('vi-VN');
                },
                onComplete: () => priceTag.setAttribute('data-value', newVal.toString())
            });
        }, 5000);

        // 2. Logic sắp xếp (Sorting)
        window.sortGrid = (type) => {
            const container = document.getElementById('grid-container');
            const rows = Array.from(container.querySelectorAll('.grid-row'));

            rows.sort((a, b) => {
                if (type === 'price') {
                    return b.dataset.price - a.dataset.price;
                } else {
                    return a.dataset.time - b.dataset.time;
                }
            });

            // Sử dụng GSAP để trượt các hàng
            const state = Flip.getState(rows);
            rows.forEach(row => container.appendChild(row));
            Flip.from(state, {
                duration: 0.8,
                ease: "power3.inOut",
                stagger: 0.05
            });
        };
    });
    let currentPage = 1;
    const recordsPerPage = 3; // Chỉ hiện 3 sản phẩm mỗi trang

    function renderPagination() {
        const container = document.getElementById('grid-container');
        const rows = Array.from(container.getElementsByClassName('grid-row'));
        const totalPages = Math.ceil(rows.length / recordsPerPage);

        // 1. Ẩn/Hiện các hàng dựa trên trang hiện tại
        rows.forEach((row, index) => {
            row.style.display = 'none';
            if (index >= (currentPage - 1) * recordsPerPage && index < currentPage * recordsPerPage) {
                row.style.display = 'grid'; // Hoặc 'flex' tùy cấu trúc row của bạn

                // Thêm hiệu ứng xuất hiện mượt mà của GSAP
                gsap.fromTo(row, {
                    opacity: 0,
                    y: 10
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.4,
                    delay: (index % 3) * 0.1
                });
            }
        });

        // 2. Sinh số trang
        const paginationNumbers = document.getElementById('pagination-numbers');
        paginationNumbers.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.innerText = i;
            btn.className = `w-10 h-10 rounded-xl border transition-all duration-300 jetbrains text-xs ${
            i === currentPage 
            ? 'bg-cyan-500 border-cyan-500 text-black shadow-[0_0_15px_rgba(6,182,212,0.5)]' 
            : 'bg-white/5 border-white/10 text-white/40 hover:bg-white/10'
        }`;
            btn.onclick = () => {
                currentPage = i;
                renderPagination();
            };
            paginationNumbers.appendChild(btn);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderPagination();
        }
    }

    function nextPage() {
        const rows = document.getElementsByClassName('grid-row');
        if (currentPage < Math.ceil(rows.length / recordsPerPage)) {
            currentPage++;
            renderPagination();
        }
    }

    // Khởi chạy khi trang load xong
    document.addEventListener('DOMContentLoaded', () => {
        renderPagination();
    });

    function startGlobalCountdowns() {
        setInterval(() => {
            const now = Math.floor(Date.now() / 1000); // Thời gian hiện tại (timestamp giây)

            document.querySelectorAll('.countdown-timer').forEach(timer => {
                const endTime = parseInt(timer.getAttribute('data-end'));
                const timeLeft = endTime - now;

                if (timeLeft <= 0) {
                    timer.innerText = "ĐÃ KẾT THÚC";
                    timer.classList.remove('text-amber-500');
                    timer.classList.add('text-red-500');
                    return;
                }

                // Tính toán giờ, phút, giây
                const hours = Math.floor(timeLeft / 3600);
                const minutes = Math.floor((timeLeft % 3600) / 60);
                const seconds = timeLeft % 60;

                // Định dạng hiển thị 00:00:00
                const displayTime = [
                    hours.toString().padStart(2, '0'),
                    minutes.toString().padStart(2, '0'),
                    seconds.toString().padStart(2, '0')
                ].join(':');

                timer.innerText = displayTime;
            });
        }, 1000); // Chạy lại mỗi 1 giây
    }

    // Kích hoạt khi trang web tải xong
    document.addEventListener('DOMContentLoaded', startGlobalCountdowns);

    function handlePause(btn, auctionId) {
        // Hiệu ứng bấm nút
        btn.style.transform = "scale(0.9)";
        setTimeout(() => btn.style.transform = "scale(1)", 100);

        const formData = new FormData();
        formData.append('auction_id', auctionId);

        fetch('toggle_pause_api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Đổi icon và màu sắc trực tiếp trên nút
                    const icon = btn.querySelector('i');
                    if (icon.classList.contains('ri-pause-line')) {
                        // Chuyển sang trạng thái PAUSED
                        icon.className = 'ri-play-fill';
                        btn.className = 'w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-amber-500/20 text-amber-500';
                    } else {
                        // Chuyển sang trạng thái ACTIVE
                        icon.className = 'ri-pause-line';
                        btn.className = 'w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-white/5 text-white/40 hover:bg-white/10 hover:text-white';
                    }
                } else {
                    alert("Lỗi hệ thống, không thể thực hiện!");
                }
                        location.reload();

            })
            .catch(err => console.error("Error:", err));
    }

    function handlePause(btn, auctionId) {
        // Hiệu ứng bấm nút
        btn.style.transform = "scale(0.9)";
        setTimeout(() => btn.style.transform = "scale(1)", 100);

        const formData = new FormData();
        formData.append('auction_id', auctionId);

        fetch('toggle_pause_api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Đổi icon và màu sắc trực tiếp trên nút
                    const icon = btn.querySelector('i');
                    if (icon.classList.contains('ri-pause-line')) {
                        // Chuyển sang trạng thái PAUSED
                        icon.className = 'ri-play-fill';
                        btn.className = 'w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-amber-500/20 text-amber-500';
                    } else {
                        // Chuyển sang trạng thái ACTIVE
                        icon.className = 'ri-pause-line';
                        btn.className = 'w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-white/5 text-white/40 hover:bg-white/10 hover:text-white';
                    }
                } else {
                    alert("Lỗi hệ thống, không thể thực hiện!");
                }
            })
            .catch(err => console.error("Error:", err));
    }

    // ----------------------------- section 3 ----------------------------- //
    // ----------------------------- section 3 ----------------------------- //
    // function openIntervention(plateNumber) {
    //     const panel = document.getElementById('intervention-panel'); // Giờ đây là thẻ section
    //     const overlay = document.getElementById('panel-overlay');
    //     const plateText = document.getElementById('target-plate-display');
    //     const mainGrid = document.getElementById('market-grid');

    //     plateText.innerText = plateNumber;
    //     panel.classList.add('active');
    //     overlay.classList.remove('hidden');

    //     gsap.to(overlay, {
    //         opacity: 1,
    //         duration: 0.5
    //     });
    //     gsap.to(mainGrid, {
    //         x: -40,
    //         filter: "blur(10px)",
    //         opacity: 0.3,
    //         duration: 0.7,
    //         ease: "power3.out"
    //     });
    // }

    // function closePanel() {
    //     const panel = document.getElementById('intervention-panel');
    //     const overlay = document.getElementById('panel-overlay');
    //     const mainGrid = document.getElementById('market-grid');

    //     panel.classList.remove('active');

    //     gsap.to(overlay, {
    //         opacity: 0,
    //         duration: 0.4,
    //         onComplete: () => overlay.classList.add('hidden')
    //     });

    //     gsap.to(mainGrid, {
    //         x: 0,
    //         filter: "blur(0px)",
    //         opacity: 1,
    //         duration: 0.6,
    //         ease: "power3.inOut"
    //     });
    // }
    let currentAuctionId = null; // Biến lưu trữ ID phiên đang chọn

    function openIntervention(id, plateNumber) {
        currentAuctionId = id; // Lưu ID lại để dùng khi bấm "PUSH TO SYSTEM"

        const panel = document.getElementById('intervention-panel');
        const overlay = document.getElementById('panel-overlay');
        const plateText = document.getElementById('target-plate-display');
        const mainGrid = document.getElementById('market-grid');

        plateText.innerText = plateNumber;
        panel.classList.add('active');
        overlay.classList.remove('hidden');

        // Giữ nguyên hiệu ứng của bạn
        gsap.to(overlay, {
            opacity: 1,
            duration: 0.5
        });
        gsap.to(mainGrid, {
            x: -40,
            filter: "blur(10px)",
            opacity: 0.3,
            duration: 0.7,
            ease: "power3.out"
        });
    }

    function closePanel() {
        currentAuctionId = null; // Reset ID khi đóng
        const panel = document.getElementById('intervention-panel');
        const overlay = document.getElementById('panel-overlay');
        const mainGrid = document.getElementById('market-grid');

        panel.classList.remove('active');

        // Giữ nguyên hiệu ứng của bạn
        gsap.to(overlay, {
            opacity: 0,
            duration: 0.4,
            onComplete: () => overlay.classList.add('hidden')
        });

        gsap.to(mainGrid, {
            x: 0,
            filter: "blur(0px)",
            opacity: 1,
            duration: 0.6,
            ease: "power3.inOut"
        });
    }
    let pendingSeconds = 0; // Lưu số giây chờ để gửi

    function selectMinutes(element, seconds) {
        pendingSeconds = seconds;

        // Reset màu tất cả các nút phút khác
        document.querySelectorAll('.minute-btn').forEach(btn => {
            btn.classList.remove('border-cyan-500', 'bg-cyan-500/20');
            btn.classList.add('border-white/10', 'bg-white/5');
        });

        // Highlight nút đang chọn
        element.classList.remove('border-white/10', 'bg-white/5');
        element.classList.add('border-cyan-500', 'bg-cyan-500/20');
    }

    function pushToSystem() {
        if (!currentAuctionId || pendingSeconds === 0) {
            alert("Vui lòng chọn số phút!");
            return;
        }

        const formData = new FormData();
        formData.append('action', 'add_time');
        formData.append('id', currentAuctionId);
        formData.append('seconds', pendingSeconds);

        fetch('update_auction.php', {
                method: 'POST',
                body: formData // Gửi trực tiếp formData
            })
            .then(response => response.text()) // Nhận text trước để kiểm tra
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert("Gia hạn thành công!");
                        location.reload();
                    } else {
                        alert("Lỗi: " + data.message);
                    }
                } catch (e) {
                    console.error("Phản hồi từ server bị lỗi (không phải JSON):", text);
                    alert("Lỗi cấu trúc dữ liệu từ máy chủ!");
                }
            });
    }

    function addSniperTime(seconds) {
        if (!currentAuctionId) {
            alert("Không tìm thấy ID phiên đấu giá!");
            return;
        }

        // Hiệu ứng loading nhẹ trên nút bấm hoặc console
        console.log(`Đang cộng thêm ${seconds} giây cho phiên ${currentAuctionId}`);

        // Gửi yêu cầu bằng Fetch API (AJAX)
        fetch('update_auction.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=add_time&id=${currentAuctionId}&seconds=${seconds}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Đã gia hạn thời gian thành công!");
                    // Cập nhật lại thời gian hiển thị trên Panel nếu cần
                    location.reload(); // Hoặc viết hàm cập nhật UI realtime
                } else {
                    alert("Lỗi: " + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function toggleEmergencyHalt(checkbox, auctionId) {
        const isPaused = checkbox.checked;

        // Hiệu ứng Visual nhẹ
        const container = checkbox.closest('div.flex');
        if (isPaused) {
            container.classList.add('opacity-80');
        } else {
            container.classList.remove('opacity-80');
        }

        // Gửi dữ liệu bằng FormData
        const formData = new FormData();
        formData.append('auction_id', auctionId);
        formData.append('paused', isPaused);

        fetch('toggle_auction_status.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert("Lỗi: " + data.message);
                    checkbox.checked = !isPaused; // Trả lại trạng thái cũ nếu lỗi
                }
            })
            .catch(err => {
                console.error(err);
                checkbox.checked = !isPaused;
            });
    }

    // ----------------------------- section 4 ----------------------------- //
    // ----------------------------- section 4 ----------------------------- //
    function toggleSentimentDrawer() {
        const content = document.getElementById('sentiment-content');
        const icon = document.getElementById('drawer-icon');

        if (content.classList.contains('drawer-open')) {
            content.classList.remove('drawer-open');
            icon.classList.replace('ri-arrow-down-s-line', 'ri-arrow-up-s-line');
        } else {
            content.classList.add('drawer-open');
            icon.classList.replace('ri-arrow-up-s-line', 'ri-arrow-down-s-line');
            // Haptic feedback khi mở
            if (window.navigator.vibrate) window.navigator.vibrate([30, 10, 30]);
        }
    }

    // Giả lập Dynamic Temperature (Thay đổi mỗi 3 giây)
    setInterval(() => {
        const bars = document.querySelectorAll('.temp-bar');
        bars.forEach(bar => {
            const randomHeight = Math.floor(Math.random() * (100 - 30 + 1)) + 30;
            gsap.to(bar, {
                height: randomHeight + '%',
                duration: 0.8,
                ease: "elastic.out(1, 0.3)"
            });
        });
    }, 3000);

    // Hiệu ứng Sparkle cho biển số được AI dự báo (Áp dụng cho Section 2)
    function applyAIPrediction(plateId) {
        const targetRow = document.querySelector(`[data-plate="${plateId}"]`);
        if (targetRow) {
            const plateContainer = targetRow.querySelector('.asset-plate-container');
            const star = document.createElement('i');
            star.className = 'ri-star-fill absolute -top-2 -right-2 text-yellow-400 text-xs animate-spin-slow';
            plateContainer.style.position = 'relative';
            plateContainer.appendChild(star);
        }
    }

    // ----------------------------- section 5 ----------------------------- //
    let currentForgeStep = 1;

    function openForge(event) {
        const forge = document.getElementById('auction-forge');
        const overlay = document.getElementById('forge-overlay');
        const container = document.getElementById('forge-container');

        const rect = event.currentTarget.getBoundingClientRect();
        const startX = rect.left + rect.width / 2;
        const startY = rect.top + rect.height / 2;

        forge.classList.remove('hidden');

        // Reset và chuẩn bị
        gsap.set(overlay, {
            xPercent: -50,
            yPercent: -50,
            left: startX,
            top: startY,
            scale: 0,
            opacity: 0,
            borderRadius: "50%" // Bắt đầu từ hình tròn
        });

        // Sử dụng timeline để kiểm soát thứ tự
        const tl = gsap.timeline();

        tl.to(overlay, {
                scale: 12, // Giảm bớt tỷ lệ nếu cần
                opacity: 1,
                duration: 0.6, // Giảm thời gian xuống cho cảm giác nhanh nhẹn
                ease: "power2.out"
            })
            .to(container, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.5,
                ease: "back.out(1.2)" // Hiệu ứng nảy nhẹ sang trọng
            }, "-=0.3"); // Chạy sớm hơn một chút khi overlay chưa xong hẳn
    }

    function moveStep(direction) {
        // KIỂM TRA: Nếu đang ở bước 3 mà bấm CONTINUE (PUBLISH)
        if (currentForgeStep === 3 && direction === 1) {
            publishAuction(); // Gọi hàm gửi dữ liệu
            return; // Dừng lại không chạy logic chuyển step nữa
        }

        const prevStep = currentForgeStep;
        currentForgeStep += direction;

        // Đảm bảo không đi quá giới hạn step (1-3)
        if (currentForgeStep < 1) currentForgeStep = 1;
        if (currentForgeStep > 3) currentForgeStep = 3;

        // Update Indicators (Giữ nguyên logic của bạn)
        document.querySelectorAll('.step-item').forEach(item => {
            const step = parseInt(item.dataset.step);
            item.classList.toggle('active', step === currentForgeStep);
            item.style.opacity = step <= currentForgeStep ? "1" : "0.3";
        });

        // Animate Stages (Giữ nguyên hiệu ứng GSAP của bạn)
        gsap.to(`#stage-${prevStep}`, {
            x: direction > 0 ? -100 : 100,
            opacity: 0,
            duration: 0.4
        });
        gsap.fromTo(`#stage-${currentForgeStep}`, {
            x: direction > 0 ? 100 : -100,
            opacity: 0
        }, {
            x: 0,
            opacity: 1,
            duration: 0.4,
            delay: 0.2
        });

        // Update Buttons
        document.getElementById('prevBtn').style.visibility = currentForgeStep === 1 ? 'hidden' : 'visible';

        // Đổi chữ nút ở bước cuối
        const nextBtn = document.getElementById('nextBtn');
        if (currentForgeStep === 3) {
            nextBtn.innerText = 'PUBLISH AUCTION';
            nextBtn.classList.replace('bg-cyan-500', 'bg-emerald-500'); // Thêm hiệu ứng đổi màu cho nút chốt
        } else {
            nextBtn.innerText = 'CONTINUE';
            nextBtn.classList.replace('bg-emerald-500', 'bg-cyan-500');
        }
    }

    function checkAIPrice(input) {
        const val = parseInt(input.value);
        // Giả lập AI: Biển XXX.XX phải > 500tr
        if (val < 500000000) {
            input.classList.add('border-rose-500/50', 'bg-rose-500/5');
            gsap.to(input, {
                x: 5,
                repeat: 3,
                yoyo: true,
                duration: 0.1
            });
        } else {
            input.classList.remove('border-rose-500/50', 'bg-rose-500/5');
            input.classList.add('border-cyan-500/50', 'bg-cyan-500/5');
        }
    }

    function closeForge() {
        gsap.to('#forge-container', {
            opacity: 0,
            y: 50,
            duration: 0.4
        });
        gsap.to('#forge-overlay', {
            scale: 0,
            opacity: 0,
            duration: 0.6,
            delay: 0.2,
            onComplete: () => {
                document.getElementById('auction-forge').classList.add('hidden');
            }
        });
    }

    function updateForgePreview(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const plateNumber = selectedOption.getAttribute('data-number');
        const startingPrice = selectedOption.getAttribute('data-price');

        // Cập nhật số trên biển 3D
        const previewText = document.querySelector('#plate-preview-3d span');
        if (plateNumber) {
            previewText.innerText = plateNumber;
            // Tự động điền giá khởi điểm vào Stage 2 nếu muốn
            const priceInput = document.querySelector('#stage-2 input[type="number"]');
            if (priceInput) priceInput.value = startingPrice;
        } else {
            previewText.innerText = "30L-XXX.XX";
        }
    }

    function publishAuction() {
        // 1. Lấy dữ liệu từ các input đã tạo ở các Stage
        const plateId = document.getElementById('plate-selector').value; // ID từ select ở Stage 1
        const startingPrice = document.querySelector('#stage-2 input[type="number"]').value;
        const durationHours = 24; // Bạn có thể thêm 1 input chọn giờ ở Stage 3

        if (!plateId) {
            alert("Vui lòng quay lại Bước 1 để chọn biển số!");
            moveStep(-2); // Quay lại bước 1
            return;
        }

        // Hiệu ứng loading trên nút
        const nextBtn = document.getElementById('nextBtn');
        nextBtn.disabled = true;
        nextBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> FORGING...';

        const formData = new FormData();
        formData.append('action', 'create_auction');
        formData.append('plate_id', plateId);
        formData.append('starting_price', startingPrice);
        formData.append('duration_hours', durationHours);

        // Gửi đến file xử lý PHP
        fetch('create_auction_api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Chúc mừng! Phiên đấu giá đã được đưa lên hệ thống.");
                    location.reload();
                } else {
                    alert("Lỗi: " + data.message);
                    nextBtn.disabled = false;
                    nextBtn.innerText = 'PUBLISH AUCTION';
                }
            })
            .catch(err => {
                console.error(err);
                alert("Lỗi kết nối server!");
                nextBtn.disabled = false;
            });
    }
    // ----------------------------- section 5: OPTIMIZED RADAR ----------------------------- //


    // ----------------------------- section 6 ----------------------------- //
</script>

</html>