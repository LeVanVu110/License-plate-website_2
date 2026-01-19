<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biển Số Đẹp | The Grand Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <style>
        :root {
            --electric-blue: #007FFF;
            --navy-deep: #000D1A;
        }

        body {
            background-color: var(--navy-deep);
            overflow-x: hidden;
            cursor: auto;
            /* Sử dụng custom cursor */
        }

        /* ----------------------------- section 1 -----------------------------  */
        .serif-title {
            font-family: 'Cormorant Garamond', serif;
        }

        .sans-text {
            font-family: 'Inter', sans-serif;
        }

        #custom-cursor {
            width: 100px;
            height: 100px;
            border: 1px solid var(--electric-blue);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            /* Không chặn click */
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--electric-blue);
            mix-blend-mode: difference;
            transition: opacity 0.3s ease;
        }

        /* Hero Video Overlay */
        .video-overlay {
            background: linear-gradient(to bottom, rgba(0, 13, 26, 0.7) 0%, rgba(0, 13, 26, 0.4) 50%, rgba(0, 13, 26, 0.9) 100%);
            z-index: 1;
        }

        #search-wrapper {
            position: relative;
            z-index: 50 !important;
        }

        /* The Crystal Search Bar */
        .crystal-search {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            pointer-events: auto !important;
            /* Cho phép tương tác */
            cursor: default;
        }

        /* Khi di chuột vào ô input, hiện trỏ chuột nhập liệu */
        .crystal-search input {
            cursor: text !important;
        }

        .crystal-search button {
            cursor: pointer !important;
        }

        /* Optical Glint Effect */
        .glint {
            position: absolute;
            top: -100%;
            left: -100%;
            width: 50%;
            height: 300%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: rotate(45deg);
            pointer-events: none;
        }

        #headline,
        #sub-headline,
        #search-wrapper {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }

        /* Loại bỏ viền mặc định khi click vào input */
        input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Hiệu ứng khi hover vào nút bấm */
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 127, 255, 0.4);
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            #custom-cursor {
                display: none;
            }

            .crystal-search {
                backdrop-filter: blur(10px);
            }

            body {
                cursor: auto;
            }

            /* #search-input{
                width: 131px !important;
            } */
        }

        /* ----------------------------- section 2 -----------------------------  */
        .filter-btn.active {
            background: #001F3F;
            color: white;
            border-color: #001F3F;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .plate-3d {
            transform-style: preserve-3d;
            transition: transform 0.1s;
        }

        .glass-card {
            transform-style: preserve-3d;
        }

        @media (max-width: 768px) {

            /* Tắt tilt trên mobile để tránh rối mắt */
            .glass-card {
                transform: none !important;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* Nền lưới Matrix */
        #matrix-grid {
            mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
        }

        /* Hiệu ứng Portal Input */
        #plate-input {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            font-size: 1.25rem;
        }

        #plate-input::placeholder {
            color: rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
            letter-spacing: 0.2em;
        }

        /* Khối cầu AI Sphere */
        #ai-sphere {
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                0 0 40px rgba(0, 127, 255, 0.1),
                inset 0 0 30px rgba(255, 255, 255, 0.05);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        /* Hiệu ứng hào quang khi có kết quả */
        .glow-text {
            color: #fff;
            text-shadow:
                0 0 10px #007FFF,
                0 0 20px #007FFF,
                0 0 40px #007FFF;
            animation: textPulse 2s infinite alternate;
        }

        @keyframes textPulse {
            from {
                opacity: 0.8;
                filter: brightness(1);
            }

            to {
                opacity: 1;
                filter: brightness(1.5);
            }
        }

        /* Vòng tròn Shockwave khi nổ giá trị */
        #shockwave {
            border: 2px solid #007FFF;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Nút bấm Analyze */
        #btn-analyze {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #btn-analyze:hover span {
            background-color: #fff;
            color: #007FFF;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
        }

        #plate-input:focus+#input-line {
            width: 100%;
        }

        #ai-sphere {
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }

        #ai-sphere:hover {
            box-shadow: 0 0 50px rgba(0, 127, 255, 0.3);
        }

        .glow-text {
            text-shadow: 0 0 20px rgba(0, 127, 255, 0.8), 0 0 40px rgba(0, 127, 255, 0.4);
        }

        .max-w-md {
            max-width: 33rem !important;
        }

        /* Khi input được focus, tìm thẻ anh em là #input-line */
        #plate-input:focus+#input-line {
            width: 100% !important;
        }

        /* Hiệu ứng mờ dần placeholder khi gõ */
        #plate-input:focus::placeholder {
            opacity: 0.3;
            transition: opacity 0.3s;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 4s linear infinite;
        }

        /* ----------------------------- section 4 -----------------------------  */
        /* CSS cho Infinite Marquee */
        /* --- Section 4: Styles --- */
        #social-pulse {
            position: relative;
            z-index: 10;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
        }

        .grainy-overlay {
            position: absolute;
            inset: 0;
            opacity: 0.03;
            pointer-events: none;
            background-image: url('https://grainy-gradients.vercel.app/noise.svg');
        }

        /* Marquee Styles */
        .marquee-wrapper {
            overflow: hidden;
            padding: 1rem 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }

        .marquee-content {
            animation: marquee-scroll 30s linear infinite;
            width: max-content;
        }

        @keyframes marquee-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .transaction-card {
            background: white;
            padding: 1rem 2rem;
            border-radius: 9999px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid white;
            position: relative;
            overflow: hidden;
        }

        .glint-pulse {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.8), transparent);
            transform: skewX(-20deg) translateX(-150%);
            animation: glint-move 4s infinite;
        }

        @keyframes glint-move {
            0% {
                transform: skewX(-20deg) translateX(-150%);
            }

            20%,
            100% {
                transform: skewX(-20deg) translateX(250%);
            }
        }

        .customer-name {
            font-weight: 600;
            color: #001f3f;
            font-size: 0.875rem;
        }

        .plate-number {
            font-weight: 800;
            color: #007fff;
            letter-spacing: 0.05em;
        }

        .status-tag {
            color: #9ca3af;
            font-size: 0.75rem;
            font-style: italic;
        }

        /* Auction Box */
        .auction-box {
            background: #001F3F;
            border-radius: 2.5rem;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .plate-highlight {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .plate-text {
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Cormorant Garamond', serif;
        }

        .countdown-timer {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .time-num {
            display: block;
            font-size: 2.25rem;
            font-weight: 700;
        }

        .time-label {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        .time-colon {
            font-size: 2.25rem;
            color: #007fff;
        }

        .btn-auction-join {
            margin-top: 2.5rem;
            padding: 1rem 2.5rem;
            background: white;
            color: #001f3f;
            font-weight: 700;
            border-radius: 9999px;
            transition: all 0.5s;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-auction-join:hover {
            background: #007fff;
            color: white;
        }

        .auction-icon-bg {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 200px;
            color: rgba(255, 255, 255, 0.05);
            transform: rotate(12deg);
            pointer-events: none;
        }

        /* Hub Box */
        .hub-box {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(20px);
            border-radius: 2.5rem;
            padding: 2.5rem;
            border: 1px solid white;
        }

        .hub-title {
            font-weight: 700;
            letter-spacing: 0.2em;
            color: #001f3f;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .hub-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 1rem;
        }

        .hub-plate {
            font-size: 0.875rem;
            font-weight: 700;
            color: #001f3f;
        }

        .hub-meta {
            font-size: 10px;
            color: #9ca3af;
        }

        .hub-price {
            color: #007fff;
            font-weight: 700;
        }

        .endorsement-logos {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            filter: grayscale(100%);
            opacity: 0.3;
        }

        .endorsement-logos i {
            font-size: 1.5rem;
        }

        /* Đảm bảo sticky title luôn nằm dưới header nhưng trên nội dung section */
        #sticky-title {
            z-index: 5;
        }

        /* Thêm vào CSS chung để đảm bảo footer không bị đè ngược */
        footer {
            position: relative;
            z-index: 20;
            background-color: #000D1A;
            /* Màu navy deep của bạn */
        }

        /* Responsive */
        @media (max-width: 768px) {
            .plate-text {
                font-size: 2rem;
            }

            .countdown-timer {
                gap: 0.75rem;
            }

            .time-num {
                font-size: 1.5rem;
            }

            #social-pulse {
                padding-left: 0 !important;
            }

            .plate-text {
                letter-spacing: -0.02em;
            }
        }

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="hero-stage" class="relative w-full h-screen flex flex-col items-center justify-center overflow-hidden">
        <div id="video-wrap" class="absolute inset-0 z-0">
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-luxury-car-parked-in-a-dark-place-34460-large.mp4" type="video/mp4">
            </video>
            <div class="video-overlay absolute inset-0"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 id="headline" class="serif-title text-5xl md:text-8xl text-white mb-6 opacity-0 tracking-tight leading-tight">
                ĐỊNH DANH VỊ THẾ<br>
                <span class="italic text-[#C0C0C0]">KHẮC GHI DI SẢN</span>
            </h1>

            <p id="sub-headline" class="sans-text text-sm md:text-xl text-gray-300 mb-12 opacity-0 tracking-[0.2em] uppercase">
                Hệ thống quản trị và giao dịch biển số định danh thượng lưu số 1 Việt Nam
            </p>

            <div id="search-wrapper" class="flex justify-center opacity-0 translate-y-10">
                <div class="crystal-search group w-full max-w-4xl rounded-full p-2 flex flex-col md:flex-row items-center gap-2">
                    <div class="glint" id="glint"></div>
                    <div class="flex-1 flex items-center px-6 border-r border-white/10 w-full relative z-20">
                        <i class="ri-search-2-line text-white/50 mr-3"></i>
                        <input type="text" placeholder="TÌM KIẾM DÃY SỐ PHONG THỦY..."
                            class="bg-transparent border-none focus:ring-0 text-white placeholder-white/30 w-full py-4 text-sm tracking-widest uppercase cursor-text">
                    </div>
                    <button class="relative z-20 bg-[#007FFF] text-white px-10 py-4 rounded-full font-bold sans-text text-sm hover:bg-white hover:text-[#007FFF] transition-all duration-500 shadow-lg shadow-blue-500/20">
                        KHÁM PHÁ NGAY
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="infinite-vault" class="relative py-24 bg-[#F8FAFC] min-h-screen overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-[0.03]"
            style="background-image: linear-gradient(#000 1px, transparent 1px), linear-gradient(90deg, #000 1px, transparent 1px); background-size: 100px 100px;">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="mb-16 max-w-2xl" id="vault-header">
                <h2 class="serif-title text-4xl md:text-5xl text-[#001F3F] mb-4 tracking-tight">
                    BỘ SƯU TẬP TINH HOA
                </h2>
                <div class="w-20 h-1 bg-[#007FFF] mb-6"></div>
                <p class="sans-text text-gray-500 uppercase tracking-[0.2em] text-sm md:text-base">
                    Những con số mang tính biểu tượng, được tuyển chọn cho những chủ nhân xứng tầm.
                </p>
            </div>

            <div class="flex flex-wrap gap-4 mb-12" id="quick-filter">
                <button class="filter-btn active px-8 py-3 rounded-full border border-gray-200 text-sm font-semibold tracking-widest transition-all">TẤT CẢ</button>
                <button class="filter-btn px-8 py-3 rounded-full border border-gray-200 text-sm font-semibold tracking-widest hover:border-[#007FFF] transition-all">NGŨ QUÝ</button>
                <button class="filter-btn px-8 py-3 rounded-full border border-gray-200 text-sm font-semibold tracking-widest hover:border-[#007FFF] transition-all">SẢN TIẾN</button>
                <button class="filter-btn px-8 py-3 rounded-full border border-gray-200 text-sm font-semibold tracking-widest hover:border-[#007FFF] transition-all">PHÁT LỘC</button>
            </div>

            <div id="cards-container" class="flex md:grid md:grid-cols-3 lg:grid-cols-3 gap-10 overflow-x-auto pb-10 md:pb-0 scrollbar-hide snap-x snap-mandatory">

                <div class="glass-card snap-center min-w-[300px] bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-white relative group" data-tilt data-tilt-max="10" data-tilt-speed="400" data-tilt-glare data-tilt-max-glare="0.3">
                    <div class="flex justify-between items-start mb-8">
                        <span class="text-[10px] tracking-[0.3em] text-[#007FFF] font-bold uppercase">Limited Edition</span>
                        <i class="ri-vip-crown-fill text-[#007FFF]"></i>
                    </div>
                    <div class="plate-3d mb-10 transform translate-z-20">
                        <div class="bg-gray-100 rounded-lg p-6 border-2 border-gray-300 shadow-inner flex flex-col items-center justify-center relative overflow-hidden">
                            <div class="w-full h-1 bg-gray-300 absolute top-4 opacity-50"></div>
                            <span class="text-[#001F3F] text-4xl md:text-5xl font-bold tracking-tighter serif-title">30K - 999.99</span>
                            <div class="text-[10px] tracking-[0.5em] text-gray-400 mt-2">THE GRAND GALLERY</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <div class="sans-text">
                                <p class="text-gray-400 text-[10px] uppercase tracking-widest">Giá sở hữu</p>
                                <h3 class="text-2xl font-bold text-[#007FFF] price-tag" data-target="2500000000">0</h3>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-md">ĐẠI CÁT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card snap-center min-w-[300px] bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-white relative group" data-tilt data-tilt-max="10">
                    <div class="flex justify-between items-start mb-8">
                        <span class="text-[10px] tracking-[0.3em] text-[#007FFF] font-bold uppercase">Legacy Series</span>
                        <i class="ri-shield-flash-fill text-[#007FFF]"></i>
                    </div>
                    <div class="plate-3d mb-10 transform translate-z-20">
                        <div class="bg-gray-100 rounded-lg p-6 border-2 border-gray-300 shadow-inner flex flex-col items-center justify-center relative overflow-hidden">
                            <span class="text-[#001F3F] text-4xl md:text-5xl font-bold tracking-tighter serif-title">51L - 888.88</span>
                            <div class="text-[10px] tracking-[0.5em] text-gray-400 mt-2">THE GRAND GALLERY</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div class="sans-text">
                            <p class="text-gray-400 text-[10px] uppercase tracking-widest">Giá sở hữu</p>
                            <h3 class="text-2xl font-bold text-[#007FFF] price-tag" data-target="1800000000">0</h3>
                        </div>
                        <span class="px-3 py-1 bg-blue-50 text-[#007FFF] text-[10px] font-bold rounded-md">PHÁT LỘC</span>
                    </div>
                </div>

                <div class="glass-card snap-center min-w-[300px] bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-white relative group" data-tilt data-tilt-max="10">
                    <div class="flex justify-between items-start mb-8">
                        <span class="text-[10px] tracking-[0.3em] text-[#007FFF] font-bold uppercase">Celestial</span>
                        <i class="ri-star-smile-fill text-[#007FFF]"></i>
                    </div>
                    <div class="plate-3d mb-10 transform translate-z-20">
                        <div class="bg-gray-100 rounded-lg p-6 border-2 border-gray-300 shadow-inner flex flex-col items-center justify-center relative overflow-hidden">
                            <span class="text-[#001F3F] text-4xl md:text-5xl font-bold tracking-tighter serif-title">60A - 666.66</span>
                            <div class="text-[10px] tracking-[0.5em] text-gray-400 mt-2">THE GRAND GALLERY</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div class="sans-text">
                            <p class="text-gray-400 text-[10px] uppercase tracking-widest">Giá sở hữu</p>
                            <h3 class="text-2xl font-bold text-[#007FFF] price-tag" data-target="950000000">0</h3>
                        </div>
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold rounded-md">TRƯỜNG CỬU</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="oracle-engine" class="relative py-32 bg-[#000D1A] min-h-screen flex items-center overflow-hidden">
        <div id="matrix-grid" class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute inset-0" style="background-image: linear-gradient(#007FFF 1px, transparent 1px), linear-gradient(90deg, #007FFF 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>

        <div id="data-nodes" class="absolute inset-0 pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">

                <div class="w-full lg:w-1/2 text-left" id="oracle-content">
                    <h2 class="serif-title text-4xl md:text-6xl text-white mb-6 leading-tight">
                        GIẢI MÃ <br> <span class="text-[#007FFF] italic">GIÁ TRỊ DI SẢN</span>
                    </h2>
                    <p class="sans-text text-gray-400 mb-12 max-w-md tracking-wide">
                        Sử dụng thuật toán AI độc quyền để phân tích tầng số học, phong thủy và giá trị giao dịch thực tế của biển số định danh.
                    </p>

                    <div class="relative max-w-md" id="input-portal">
                        <div class="relative overflow-hidden">
                            <input type="text" id="plate-input" placeholder="NHẬP BIỂN SỐ CỦA BẠN (VD: 30K-999.99)"
                                class="w-full bg-transparent border-b-2 border-gray-700 py-4 text-white sans-text tracking-[0.3em] uppercase focus:outline-none transition-all duration-500">

                            <div id="input-line" class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#007FFF] shadow-[0_0_15px_#007FFF] transition-all duration-500 ease-in-out"></div>
                        </div>

                        <button id="btn-analyze" class="mt-8 group flex items-center gap-4 text-white tracking-[0.2em] font-bold text-sm">
                            <span class="bg-[#007FFF] p-4 rounded-full group-hover:scale-110 transition-transform shadow-[0_0_20px_rgba(0,127,255,0.4)]">
                                <i class="ri-radar-line animate-spin-slow"></i>
                            </span>
                            BẮT ĐẦU ĐỊNH GIÁ AI
                        </button>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex justify-center items-center relative">
                    <div id="sphere-aura" class="absolute w-[400px] h-[400px] bg-[#007FFF] rounded-full blur-[120px] opacity-10"></div>

                    <div id="ai-sphere" class="relative w-64 h-64 md:w-80 md:h-80 rounded-full flex items-center justify-center border border-white/10 backdrop-blur-md shadow-2xl overflow-hidden cursor-pointer"
                        style="background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, rgba(0,0,0,0.4) 100%);">

                        <div id="sphere-core" class="text-center z-10 p-6">
                            <div id="status-text" class="text-[#007FFF] text-[10px] tracking-[0.4em] uppercase mb-2 opacity-50">Hệ thống sẵn sàng</div>
                            <div id="result-price" class="text-white text-3xl md:text-4xl font-bold sans-serif hidden">0</div>
                            <div id="loading-spinner" class="hidden">
                                <div class="w-12 h-12 border-2 border-[#007FFF] border-t-transparent rounded-full animate-spin mx-auto"></div>
                            </div>
                        </div>

                        <canvas id="sphere-particles" class="absolute inset-0 opacity-40"></canvas>
                    </div>

                    <div id="shockwave" class="absolute w-20 h-20 border-2 border-[#007FFF] rounded-full opacity-0 pointer-events-none"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="social-pulse" class="relative py-24 bg-[#F2F4F7] z-10 border-t border-white" style="padding-left: 45px;">
        <div class="grainy-overlay"></div>

        <div class="absolute inset-0 pointer-events-none">
            <div id="sticky-title-container" class="sticky top-1/2 -translate-y-1/2 h-fit">
                <div id="sticky-title" class="hidden lg:block ml-10">
                    <h2 class="serif-title text-sm tracking-[0.5em] text-[#001F3F] origin-left rotate-90 whitespace-nowrap opacity-50">
                        NHỊP ĐẬP THỊ TRƯỜNG
                    </h2>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-6">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="sans-text text-[10px] font-bold tracking-[0.3em] text-[#001F3F] uppercase">Giao dịch trực tiếp</span>
                </div>

                <div class="marquee-wrapper">
                    <div class="marquee-content flex gap-8 whitespace-nowrap">
                        <div class="transaction-card">
                            <div class="glint-pulse"></div>
                            <span class="customer-name">Anh Trần V.</span>
                            <span class="plate-number">30K - 999.XX</span>
                            <span class="status-tag">Vừa chốt đơn</span>
                        </div>
                        <div class="transaction-card">
                            <span class="customer-name">Chị Lê M.</span>
                            <span class="plate-number">51L - 888.XX</span>
                            <span class="status-tag">10 phút trước</span>
                        </div>
                        <div class="transaction-card">
                            <span class="customer-name">Khách hàng 09xx</span>
                            <span class="plate-number">60A - 666.XX</span>
                            <span class="status-tag">Vừa thanh toán</span>
                        </div>
                        <div class="transaction-card">
                            <span class="customer-name">Anh Trần V.</span>
                            <span class="plate-number">30K - 999.XX</span>
                            <span class="status-tag">Vừa chốt đơn</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="w-full lg:w-[60%] bg-[#001F3F] rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <h3 class="serif-title text-3xl mb-8 uppercase tracking-widest text-[#007FFF]">Phiên đấu giá tiêu điểm</h3>
                        <div class="flex items-center gap-12">
                            <div class="plate-highlight bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20">
                                <span class="text-4xl md:text-5xl font-bold tracking-tighter serif-title">30K - 555.55</span>
                            </div>
                            <div class="countdown-timer flex gap-6" id="auction-timer">
                                <div class="time-block">
                                    <span class="block text-4xl font-bold" id="hours">02</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">Giờ</span>
                                </div>
                                <span class="text-4xl text-[#007FFF]">:</span>
                                <div class="time-block">
                                    <span class="block text-4xl font-bold" id="mins">45</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">Phút</span>
                                </div>
                                <span class="text-4xl text-[#007FFF]">:</span>
                                <div class="time-block">
                                    <span class="block text-4xl font-bold" id="secs">12</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">Giây</span>
                                </div>
                            </div>
                        </div>
                        <button class="mt-10 px-10 py-4 bg-white text-[#001F3F] font-bold rounded-full hover:bg-[#007FFF] hover:text-white transition-all duration-500 shadow-xl">
                            THAM GIA ĐẤU GIÁ NGAY
                        </button>
                    </div>
                    <i class="ri-hammer-line absolute right-[-20px] bottom-[-20px] text-[200px] text-white/5 rotate-12"></i>
                </div>

                <div class="w-full lg:w-[40%] bg-white/50 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white">
                    <h3 class="sans-text font-bold tracking-[0.2em] text-[#001F3F] mb-8 text-sm uppercase">Ký gửi mới nhất</h3>
                    <div class="space-y-6" id="consignment-list">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div>
                                <p class="text-sm font-bold text-[#001F3F]">30K-123.45</p>
                                <p class="text-[10px] text-gray-400">Vừa ký gửi - Hà Nội</p>
                            </div>
                            <span class="text-[#007FFF] font-bold">1.2 Tỷ</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div>
                                <p class="text-sm font-bold text-[#001F3F]">51L-999.99</p>
                                <p class="text-[10px] text-gray-400">Vừa ký gửi - TP.HCM</p>
                            </div>
                            <span class="text-[#007FFF] font-bold">3.5 Tỷ</span>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between grayscale opacity-30">
                        <i class="ri-bank-line text-2xl"></i>
                        <i class="ri-newspaper-line text-2xl"></i>
                        <i class="ri-government-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->


    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    gsap.registerPlugin(ScrollTrigger);
    // 2. Initial Animation & Scroll
    window.addEventListener('load', () => {
        const mainTl = gsap.timeline();
        mainTl.to("#headline", {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: "power4.out"
            })
            .to("#sub-headline", {
                opacity: 1,
                y: 0,
                duration: 0.8
            }, "-=0.8")
            .to("#search-wrapper", {
                opacity: 1,
                y: 0,
                duration: 0.8
            }, "-=0.5");

        // Fixed Scroll disappearance
        gsap.to("#headline, #sub-headline", {
            scrollTrigger: {
                trigger: "#hero-stage",
                start: "top top",
                end: "30% top",
                scrub: 1,
                toggleActions: "play reverse play reverse"
            },
            y: -50,
            opacity: 0,
            immediateRender: false
        });

        gsap.to("#video-wrap video", {
            scrollTrigger: {
                trigger: "#hero-stage",
                start: "top top",
                end: "bottom top",
                scrub: 1
            },
            filter: "blur(15px) brightness(0.4)",
            scale: 1.1,
            force3D: true
        });
    });

    // 3. Magnetic Search FIXED
    const searchWrapper = document.getElementById('search-wrapper');
    const searchBox = document.querySelector('.crystal-search');

    // Chỉ chạy hiệu ứng hút khi chuột KHÔNG đè trực tiếp lên ô input
    document.addEventListener('mousemove', (e) => {
        const rect = searchWrapper.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const dist = Math.hypot(e.clientX - centerX, e.clientY - centerY);

        // Kiểm tra nếu chuột nằm trong vùng ô search
        const isInside = e.clientX >= rect.left && e.clientX <= rect.right &&
            e.clientY >= rect.top && e.clientY <= rect.bottom;

        if (dist < 400 && !isInside) {
            gsap.to(searchBox, {
                x: (e.clientX - centerX) * 0.12,
                y: (e.clientY - centerY) * 0.12,
                duration: 0.5,
                ease: "power2.out"
            });
        } else {
            gsap.to(searchBox, {
                x: 0,
                y: 0,
                duration: 0.4,
                ease: "power3.out"
            });
        }
    });

    // 4. Glint Effect
    gsap.to("#glint", {
        left: "150%",
        duration: 2.5,
        repeat: -1,
        repeatDelay: 5,
        ease: "power2.inOut"
    });

    // ----------------------------- section 2 ----------------------------- //
    window.addEventListener('load', () => {
        // 1. Reveal Header & Filter
        gsap.from("#vault-header > *", {
            scrollTrigger: {
                trigger: "#infinite-vault",
                start: "top 80%",
            },
            y: 30,
            opacity: 0,
            stagger: 0.2,
            duration: 1,
            ease: "power3.out"
        });

        // 2. The Floating Emergence (Staggered Cards)
        gsap.from(".glass-card", {
            scrollTrigger: {
                trigger: "#cards-container",
                start: "top 85%",
            },
            y: 60,
            opacity: 0,
            scale: 0.9,
            stagger: 0.15,
            duration: 1.2,
            ease: "expo.out"
        });

        // 3. The Price Counter & Focus Scale
        document.querySelectorAll('.glass-card').forEach((card) => {
            const priceTag = card.querySelector('.price-tag');
            const finalPrice = parseInt(priceTag.getAttribute('data-target'));

            ScrollTrigger.create({
                trigger: card,
                start: "top 70%",
                onEnter: () => {
                    // Nhảy số giá tiền
                    let obj = {
                        val: 0
                    };
                    gsap.to(obj, {
                        val: finalPrice,
                        duration: 2,
                        ease: "power3.out",
                        onUpdate: () => {
                            priceTag.innerHTML = Math.floor(obj.val).toLocaleString('vi-VN') + ' VNĐ';
                        }
                    });
                }
            });

            // Phóng đại tâm điểm khi cuộn qua (giữa màn hình)
            gsap.to(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top 50%",
                    end: "bottom 50%",
                    toggleActions: "play reverse play reverse",
                },
                scale: 1.05,
                borderColor: "#007FFF",
                boxShadow: "0 20px 40px rgba(0, 127, 255, 0.15)",
                duration: 0.4
            });
        });
    });

    // ----------------------------- section 3 ----------------------------- //
    window.addEventListener('load', () => {
        // 1. Matrix Pulse Effect
        gsap.to("#matrix-grid", {
            scale: 1.1,
            opacity: 0.3,
            duration: 4,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 2. Tạo các điểm sáng Nodes lơ lửng
        const nodesContainer = document.getElementById('data-nodes');
        for (let i = 0; i < 20; i++) {
            const node = document.createElement('div');
            node.className = 'absolute w-1 h-1 bg-[#007FFF] rounded-full opacity-40';
            node.style.left = Math.random() * 100 + '%';
            node.style.top = Math.random() * 100 + '%';
            nodesContainer.appendChild(node);

            gsap.to(node, {
                y: "random(-100, 100)",
                x: "random(-100, 100)",
                opacity: "random(0.1, 0.6)",
                duration: "random(3, 6)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }

        // 3. Logic Định giá AI
        const btnAnalyze = document.getElementById('btn-analyze');
        const plateInput = document.getElementById('plate-input');
        const resultPrice = document.getElementById('result-price');
        const statusText = document.getElementById('status-text');
        const loadingSpinner = document.getElementById('loading-spinner');
        const aiSphere = document.getElementById('ai-sphere');

        btnAnalyze.addEventListener('click', () => {
            if (plateInput.value === "") return alert("Vui lòng nhập biển số!");

            // Bắt đầu quét
            statusText.innerText = "Đang mã hóa dữ liệu...";
            loadingSpinner.classList.remove('hidden');
            resultPrice.classList.add('hidden');

            // Hiệu ứng hạt chảy vào tâm (Data Stream)
            gsap.to(aiSphere, {
                scale: 1.1,
                duration: 0.5,
                repeat: 3,
                yoyo: true
            });

            setTimeout(() => {
                loadingSpinner.classList.add('hidden');
                resultPrice.classList.remove('hidden');
                statusText.innerText = "ĐỊNH GIÁ HOÀN TẤT";

                // Giá giả lập ngẫu nhiên cho demo
                const finalVal = Math.floor(Math.random() * 5000000000) + 500000000;
                let obj = {
                    val: 0
                };

                // Counting Momentum
                gsap.to(obj, {
                    val: finalVal,
                    duration: 2.5,
                    ease: "expo.out",
                    onUpdate: () => {
                        resultPrice.innerHTML = Math.floor(obj.val).toLocaleString('vi-VN') + ' VNĐ';
                    },
                    onComplete: () => {
                        // Shockwave & Shake khi dừng lại
                        resultPrice.classList.add('glow-text');
                        gsap.fromTo(aiSphere, {
                            x: -5
                        }, {
                            x: 5,
                            duration: 0.05,
                            repeat: 10,
                            yoyo: true
                        });

                        // Shockwave animation
                        gsap.fromTo("#shockwave", {
                            width: 100,
                            height: 100,
                            opacity: 1
                        }, {
                            width: 800,
                            height: 800,
                            opacity: 0,
                            duration: 1.5,
                            ease: "power2.out"
                        });
                    }
                });
            }, 2000);
        });
    });

    // ----------------------------- section 4 ----------------------------- //
    window.addEventListener('load', () => {
        // 1. Tối ưu Marquee
        const marquee = document.querySelector('.marquee-content');
        // Chỉ nhân bản nếu chưa có đủ nội dung để lặp
        if (marquee.children.length < 8) {
            marquee.innerHTML += marquee.innerHTML;
        }

        // Velocity Mapping: Tốc độ marquee chạy theo nhịp cuộn
        let scrollVelocity = 1;
        ScrollTrigger.create({
            onUpdate: (self) => {
                scrollVelocity = 1 + Math.abs(self.getVelocity() / 1000);
                gsap.to(marquee, {
                    timeScale: scrollVelocity,
                    duration: 0.5
                });
            }
        });


        // Tìm đoạn này trong phần script Section 4
        gsap.to("#sticky-title", {
            scrollTrigger: {
                trigger: "#social-pulse",
                start: "top -80%",
                end: "bottom 80%", // Đảm bảo kết thúc trước khi chạm tới Footer
                pin: true,
                pinSpacing: false, // QUAN TRỌNG: Đặt là false để không tạo khoảng trống dư
                anticipatePin: 1
            }
        });

        // 3. Countdown Tension (Giữ nguyên logic nhảy số)
        const secsLabel = document.getElementById('secs');
        if (secsLabel) {
            setInterval(() => {
                let currentSec = parseInt(secsLabel.innerText);
                if (currentSec > 0) {
                    currentSec--;
                    secsLabel.innerText = currentSec < 10 ? '0' + currentSec : currentSec;
                    gsap.fromTo(secsLabel, {
                        scale: 1.2,
                        color: "#007FFF"
                    }, {
                        scale: 1,
                        color: "#FFFFFF",
                        duration: 0.4
                    });
                } else {
                    secsLabel.innerText = "59"; // Reset để demo
                }
            }, 1000);
        }

        // 4. Reveal Animation (Đảm bảo container hiện hết)
        gsap.from("#social-pulse .container", {
            scrollTrigger: {
                trigger: "#social-pulse",
                start: "top 80%",
            },
            y: 100,
            opacity: 0,
            duration: 1.5,
            ease: "power4.out"
        });
    });

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>