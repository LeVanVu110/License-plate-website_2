<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.cdnfonts.com/css/digital-7-mono');

        /* Arena Setup */
        .perspective-2000 {
            perspective: 2000px;
        }

        /* 3D Pedestal Construction */
        .cube-3d {
            width: 450px;
            /* Chiều rộng bệ */
            height: 180px;
            /* Chiều cao bệ */
            position: relative;
            transform-style: preserve-3d;
            transform: rotateX(-10deg) rotateY(-15deg);
            /* Góc nhìn 3D mặc định */
        }

        .cube-face {
            position: absolute;
            width: 450px;
            height: 180px;
            border: 1px solid rgba(0, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            backface-visibility: visible;
        }

        /* Định vị 6 mặt để tạo độ dày 40px */
        .cube-face.front {
            transform: rotateY(0deg) translateZ(20px);
            background: rgba(0, 26, 51, 0.4);
        }

        .cube-face.back {
            transform: rotateY(180deg) translateZ(20px);
            background: rgba(0, 10, 20, 0.8);
        }

        .cube-face.top {
            height: 40px;
            transform: rotateX(90deg) translateZ(20px);
            top: 0px;
            background: rgba(0, 255, 255, 0.1);
        }

        .cube-face.bottom {
            height: 40px;
            transform: rotateX(-90deg) translateZ(160px);
            top: 0px;
            background: rgba(0, 255, 255, 0.3);
            box-shadow: 0 0 100px rgba(0, 255, 255, 0.5);
        }

        .cube-face.left {
            width: 40px;
            transform: rotateY(-90deg) translateZ(20px);
            left: 0px;
            background: rgba(0, 255, 255, 0.1);
        }

        .cube-face.right {
            width: 40px;
            transform: rotateY(90deg) translateZ(430px);
            left: 0px;
            background: rgba(0, 255, 255, 0.1);
        }

        /* Plate Typography */
        .digital-font {
            font-family: 'Digital-7 Mono', sans-serif;
        }

        .plate-body {
            width: 420px;
            height: 150px;
        }

        /* Animations */
        @keyframes shake {

            0%,
            100% {
                transform: translate(0, 0);
            }

            25% {
                transform: translate(2px, 2px);
            }

            75% {
                transform: translate(-2px, -2px);
            }
        }

        .timer-shake {
            animation: shake 0.2s infinite;
            color: #FF0055 !important;
        }

        @media (min-width: 768px) {
            .md\:text-8xl {
                font-size: 4rem !important;
            }
        }

        @media (max-width: 1024px) {
            .cube-3d {
                width: 300px;
                /* Thu nhỏ bệ thờ trên tablet/mobile */
                height: 120px;
            }

            .cube-face {
                width: 300px;
                height: 120px;
            }

            /* Điều chỉnh lại vị trí các mặt cho khớp kích thước mới */
            .cube-face.top,
            .cube-face.bottom {
                height: 40px;
               
            }
            .cube-face.bottom{
                 top: -60px !important;
            }

            .cube-face.left,
            .cube-face.right {
                width: 40px;
            }

            .cube-face.right {
                transform: rotateY(90deg) translateZ(280px);
            }

            /* 300 - 20 */

            .plate-body {
                width: 280px;
                height: 100px;
            }

            #plate-number {
                font-size: 2.0rem !important;
                /* Thu nhỏ số biển số */
            }
        }

        /* --- Tối ưu giao diện Mobile --- */
        @media (max-width: 768px) {
            .pedestal-center {
                height: 300px;
                /* Giảm chiều cao khu vực trung tâm */
                order: 1;
                /* Đưa biển số lên đầu */
            }

            .left-side {
                order: 2;
            }

            .right-side {
                order: 3;
            }

            /* Ẩn bớt các hiệu ứng nặng nếu cần (Chế độ Lite) */
            #energy-particles {
                opacity: 0.3;
            }

            /* Đưa bảng giá và đồng hồ lên vị trí dễ nhìn */
            .glass-console {
                padding: 1rem !important;
            }

            #countdown-timer {
                font-size: 2.5rem !important;
            }

            /* Thanh trả giá nhanh dính dưới màn hình */


            #bid-now-btn {
                padding: 12px !important;
                flex: 2;
            }

            .bid-control .flex {
                flex: 1;
                flex-direction: column;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&display=swap');

        #multiverse-stakes {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Glass Refraction (Glint) */
        .glint-layer {
            background: linear-gradient(135deg, transparent 0%, transparent 40%, rgba(153, 255, 255, 0.2) 50%, transparent 60%, transparent 100%);
            background-size: 250% 250%;
            background-position: 200% 200%;
            transition: background-position 0.8s ease;
        }

        .arena-mini-card:hover .glint-layer {
            background-position: -150% -150%;
        }

        /* Live Flash Animation */
        @keyframes flash-cyan {
            0% {
                box-shadow: 0 0 0px rgba(0, 255, 255, 0);
                border-color: rgba(0, 255, 255, 0.2);
            }

            50% {
                box-shadow: 0 0 30px rgba(0, 255, 255, 0.5);
                border-color: rgba(0, 255, 255, 0.8);
            }

            100% {
                box-shadow: 0 0 0px rgba(0, 255, 255, 0);
                border-color: rgba(0, 255, 255, 0.2);
            }
        }

        .card-flash {
            animation: flash-cyan 1s ease-out;
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 768px) {
            .arena-mini-card {
                padding: 0;
                border-radius: 16px;
            }

            .inner-content {
                flex-direction: row;
                align-items: center;
                padding: 12px;
                gap: 15px;
                border-radius: 16px;
            }

            .plate-preview {
                width: 100px;
                /* Cố định chiều rộng */
                height: 70px;
                margin-bottom: 0 !important;
                flex-shrink: 0;
            }

            .plate-mockup {
                font-size: 10px !important;
                padding: 4px 8px !important;
            }

            .progress-fill {
                height: 1px;
            }

            /* Biến phần Progress Bar thành đường chỉ mỏng dưới biển số */
            .mb-6 {
                margin-bottom: 0 !important;
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .mt-auto {
                margin-top: 0 !important;
                flex-direction: column;
                align-items: flex-end;
                gap: 4px;
            }

            .arena-mini-card button {
                padding: 6px 12px !important;
                font-size: 8px !important;
                border-radius: 8px;
            }

            /* Ẩn các hiệu ứng nặng để tiết kiệm tài nguyên mobile */
            .glint-layer {
                display: none;
            }

            .price-val {
                font-size: 14px;
            }

            #auction-grid {
                grid-template-columns: 1fr;
                /* 1 cột duy nhất */
                gap: 12px;
            }

            /* Biến thẻ thành dạng Row (Dòng ngang) */
            .arena-mini-card .inner-content {
                display: flex;
                flex-direction: row;
                /* Xếp ngang các thành phần */
                align-items: center;
                padding: 12px;
                gap: 12px;
                min-height: 100px;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* Perspective Path */
        .perspective-path {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 200%;
            height: 100%;
            background: radial-gradient(ellipse at bottom, rgba(0, 255, 255, 0.1) 0%, transparent 70%);
            transform: translateX(-50%) perspective(500px) rotateX(60deg);
        }

        /* Honor Card Styles */
        .honor-card {
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
            width: 350px;
        }

        .sapphire-filter {
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, rgba(0, 127, 255, 0.4), transparent);
            z-index: 10;
            pointer-events: none;
            border-radius: 8px;
        }

        /* SOLD Seal */
        .sold-seal {
            position: absolute;
            top: -10px;
            right: -10px;
            z-index: 30;
            background: linear-gradient(45deg, #C0C0C0, #FFFFFF, #C0C0C0);
            color: black;
            padding: 5px 15px;
            font-weight: 900;
            font-size: 14px;
            border-radius: 4px;
            transform: rotate(15deg);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Price Sparkle Animation */
        .price-sparkle {
            position: relative;
            background: linear-gradient(to right, #C0C0C0 20%, #fff 40%, #fff 60%, #C0C0C0 80%);
            background-size: 200% auto;
            color: #000;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 3s linear infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        /* Celebration Beam */
        .beam-effect {
            position: absolute;
            bottom: -100px;
            left: 50%;
            width: 2px;
            height: 0;
            background: linear-gradient(to top, transparent, #00FFFF, transparent);
            transform: translateX(-50%);
            filter: blur(2px);
            opacity: 0;
        }

        @media (max-width: 1024px) {
            .honor-card {
                width: 280px;
            }
        }

        /* Perspective Path */
        .perspective-path {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 200%;
            height: 100%;
            background: radial-gradient(ellipse at bottom, rgba(0, 255, 255, 0.1) 0%, transparent 70%);
            transform: translateX(-50%) perspective(500px) rotateX(60deg);
        }

        /* Honor Card Styles */
        .honor-card {
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
            width: 350px;
        }

        .sapphire-filter {
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, rgba(0, 127, 255, 0.4), transparent);
            z-index: 10;
            pointer-events: none;
            border-radius: 8px;
        }

        /* SOLD Seal */
        .sold-seal {
            position: absolute;
            top: -10px;
            right: -10px;
            z-index: 30;
            background: linear-gradient(45deg, #C0C0C0, #FFFFFF, #C0C0C0);
            color: black;
            padding: 5px 15px;
            font-weight: 900;
            font-size: 14px;
            border-radius: 4px;
            transform: rotate(15deg);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Price Sparkle Animation */
        .price-sparkle {
            position: relative;
            background: linear-gradient(to right, #C0C0C0 20%, #fff 40%, #fff 60%, #C0C0C0 80%);
            background-size: 200% auto;
            color: #000;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 3s linear infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        /* Celebration Beam */
        .beam-effect {
            position: absolute;
            bottom: -100px;
            left: 50%;
            width: 2px;
            height: 0;
            background: linear-gradient(to top, transparent, #00FFFF, transparent);
            transform: translateX(-50%);
            filter: blur(2px);
            opacity: 0;
        }

        @media (max-width: 1024px) {
            .honor-card {
                width: 280px;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */
        /* Heartbeat for Icons */
        @keyframes trust-heartbeat {
            0% {
                transform: scale(1);
                filter: drop-shadow(0 0 0px rgba(45, 212, 191, 0));
            }

            50% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 10px rgba(45, 212, 191, 0.5));
            }

            100% {
                transform: scale(1);
                filter: drop-shadow(0 0 0px rgba(45, 212, 191, 0));
            }
        }

        .trust-icon {
            animation: trust-heartbeat 3s infinite ease-in-out;
        }

        /* Scanning Effect Line */
        .scan-line {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(45, 212, 191, 0.1),
                    transparent);
            pointer-events: none;
            transition: left 0.8s ease;
        }

        .trust-card:hover .scan-line {
            left: 100%;
        }

        /* Responsive Steps (Mobile) */
        @media (max-width: 1024px) {
            .trust-block {
                margin-bottom: 1.5rem;
            }
        }

        /* Accordion Expand on Hover/Active */
        .trust-block:hover .details {
            opacity: 1;
            max-height: 100px;
            margin-top: 1rem;
        }

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>

    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="grand-arena" class="relative min-h-screen bg-[#00050A] overflow-hidden flex items-center justify-center">

        <canvas id="energy-particles" class="absolute inset-0 z-0 opacity-60"></canvas>

        <div class="absolute inset-0 z-0">
            <div class="light-sweep absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-cyan-500/10 to-transparent skew-x-12"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">

            <div class="portal-side left-side w-full lg:w-1/4 flex flex-col gap-6">
                <div class="glass-console p-6 rounded-2xl border-l-2 border-cyan-500 bg-[#001A33]/40 backdrop-blur-xl">
                    <p class="text-white/40 text-[10px] tracking-[4px] uppercase mb-1">Giá khởi điểm</p>
                    <p class="text-white text-xl font-mono">500.000.000đ</p>

                    <div class="my-6 h-[1px] bg-cyan-500/20 w-full"></div>

                    <p class="text-cyan-400 text-[10px] tracking-[4px] uppercase mb-1 font-bold">Giá hiện tại</p>
                    <h3 id="current-price" class="text-[#99FFFF] text-4xl font-bold font-sans drop-shadow-[0_0_15px_rgba(0,255,255,0.5)]" style="text-align: center;">
                        850.000.000
                    </h3>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1 glass-console p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-white/30 text-[8px] uppercase">Lượt trả</p>
                        <p class="text-white font-bold">128</p>
                    </div>
                    <div class="flex-1 glass-console p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-white/30 text-[8px] uppercase">Đang xem</p>
                        <p class="text-cyan-400 font-bold">1.2k</p>
                    </div>
                </div>
            </div>

            <div class="pedestal-center relative perspective-2000 w-full lg:w-2/4 h-[400px] flex items-center justify-center">
                <div id="crystal-cube" class="cube-3d">
                    <div class="cube-face front flex items-center justify-center">
                        <div class="legacy-plate-3d group">
                            <div class="plate-aura absolute inset-0 blur-2xl bg-cyan-500/20 group-hover:bg-cyan-500/40 transition-all"></div>
                            <div class="plate-body relative bg-[#F0F0F0] p-4 rounded-xl border-4 border-[#CCCCCC] shadow-2xl flex flex-col items-center">
                                <span class="text-black/30 font-bold self-start text-xl">VN</span>
                                <h2 id="plate-number" class="text-black text-6xl md:text-8xl font-black tracking-tighter py-4">
                                    30K-999.99
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="cube-face back bg-cyan-500/5 backdrop-blur-sm border border-cyan-500/20"></div>
                    <div class="cube-face top bg-cyan-500/10 backdrop-blur-sm border border-cyan-500/20"></div>
                    <div class="cube-face bottom bg-cyan-500/20 shadow-[0_0_100px_rgba(0,255,255,0.3)]"></div>
                </div>
            </div>

            <div class="portal-side right-side w-full lg:w-1/4 flex flex-col gap-6">
                <div class="glass-console p-6 rounded-2xl border-r-2 border-cyan-500 bg-[#001A33]/40 backdrop-blur-xl text-right">
                    <p class="text-cyan-400 text-[10px] tracking-[4px] uppercase mb-2 font-bold">Thời gian còn lại</p>
                    <div id="countdown-timer" class="digital-font text-5xl md:text-6xl text-cyan-400">
                        00:58
                    </div>
                </div>

                <div class="bid-control flex flex-col gap-4">
                    <button id="bid-now-btn" class="relative group overflow-hidden py-6 rounded-2xl bg-[#007FFF] shadow-[0_0_30px_rgba(0,127,255,0.4)] transition-all">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform"></div>
                        <span class="relative z-10 text-white font-bold uppercase tracking-[4px]">Trả giá ngay</span>
                    </button>

                    <div class="flex gap-2">
                        <button class="flex-1 py-3 rounded-lg bg-white/5 border border-white/10 text-white text-xs hover:bg-cyan-500/20 transition-all">+5M</button>
                        <button class="flex-1 py-3 rounded-lg bg-white/5 border border-white/10 text-white text-xs hover:bg-cyan-500/20 transition-all">+10M</button>
                        <button class="flex-1 py-3 rounded-lg bg-white/5 border border-white/10 text-white text-xs hover:bg-cyan-500/20 transition-all">Tùy chỉnh</button>
                    </div>
                </div>

                <div class="recent-bidders bg-white/5 rounded-xl p-4 overflow-hidden h-32">
                    <div class="marquee-vertical space-y-2">
                        <p class="text-[10px] text-white/40"><span class="text-cyan-400">Ẩn danh 432</span> vừa trả 860M</p>
                        <p class="text-[10px] text-white/40"><span class="text-cyan-400">Anh Hoàng - HN</span> vừa trả 850M</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="multiverse-stakes" class="relative min-h-screen py-24 bg-[#000F1A] overflow-hidden">

        <div class="absolute inset-0 z-0 opacity-10 pointer-events-none" id="matrix-bg">
            <div class="matrix-column absolute top-0 text-[10px] text-cyan-500 font-mono leading-none whitespace-nowrap"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <h2 class="text-[#99FFFF] text-4xl md:text-5xl font-bold tracking-tight mb-2 uppercase">Toàn cảnh chiến trường</h2>
                    <p class="text-cyan-500/50 uppercase tracking-[4px] text-xs font-mono">Real-time Global Auction Grid</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-cyan-500/10 border border-cyan-500/30 px-4 py-2 rounded-full flex items-center gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="text-cyan-400 text-[10px] font-bold uppercase tracking-widest">42 Phiên trực tiếp</span>
                    </div>
                </div>
            </div>

            <div id="auction-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="arena-mini-card group relative rounded-3xl p-[1px] bg-gradient-to-br from-cyan-500/20 to-transparent overflow-hidden" data-id="1" data-time="55">
                    <div class="inner-content bg-[#001A33]/60 backdrop-blur-2xl rounded-[23px] p-6 h-full flex flex-col">
                        <div class="glint-layer absolute inset-0 pointer-events-none"></div>

                        <div class="plate-preview relative h-40 bg-white/5 rounded-2xl mb-6 flex items-center justify-center overflow-hidden border border-white/5">
                            <div class="absolute inset-0 bg-gradient-to-t from-cyan-500/10 to-transparent"></div>
                            <div class="plate-mockup bg-white text-black px-6 py-3 rounded-lg font-bold text-2xl font-mono shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                                51L - 888.88
                            </div>
                            <div class="quick-view absolute inset-0 bg-[#000F1A]/90 backdrop-blur-md flex flex-col justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-cyan-400 text-[10px] uppercase mb-2">Thông số chi tiết</p>
                                <div class="flex gap-4 text-white/70 text-xs">
                                    <span>Bước giá: 5M</span>
                                    <span>Lượt trả: 86</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between text-[10px] text-white/40 uppercase mb-2 font-mono">
                                <span>Thời gian còn lại</span>
                                <span class="text-red-400 countdown-text">55s</span>
                            </div>
                            <div class="h-[2px] w-full bg-white/10 rounded-full overflow-hidden">
                                <div class="progress-fill h-full bg-cyan-500 w-[80%]"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <p class="text-white/40 text-[9px] uppercase tracking-widest">Giá hiện tại</p>
                                <p class="text-[#99FFFF] font-bold text-xl font-mono price-val">1.250M</p>
                            </div>
                            <button class="bg-cyan-500 hover:bg-[#99FFFF] text-[#000F1A] px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-colors">
                                Tham chiến
                            </button>
                        </div>
                    </div>
                </div>

                <div class="arena-mini-card group relative rounded-3xl p-[1px] bg-gradient-to-br from-cyan-500/20 to-transparent overflow-hidden" data-id="2" data-time="3600">
                    <div class="inner-content bg-[#001A33]/60 backdrop-blur-2xl rounded-[23px] p-6 h-full flex flex-col">
                        <div class="plate-preview relative h-40 bg-white/5 rounded-2xl mb-6 flex items-center justify-center border border-white/5">
                            <div class="plate-mockup bg-white text-black w-24 h-24 rounded-lg font-bold text-xl font-mono flex flex-col items-center justify-center leading-tight">
                                <span>29-AA</span>
                                <span>999.99</span>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="flex justify-between text-[10px] text-white/40 uppercase mb-2 font-mono">
                                <span>Thời gian còn lại</span>
                                <span class="text-cyan-400 countdown-text">01:00:00</span>
                            </div>
                            <div class="h-[2px] w-full bg-white/10 rounded-full overflow-hidden">
                                <div class="progress-fill h-full bg-cyan-500 w-[40%]"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <div>
                                <p class="text-white/40 text-[9px] uppercase tracking-widest">Giá hiện tại</p>
                                <p class="text-[#99FFFF] font-bold text-xl font-mono">450M</p>
                            </div>
                            <button class="bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-cyan-500 hover:text-[#000F1A] transition-all">
                                Tham chiến
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="hall-of-sovereigns" class="relative min-h-screen py-24 bg-[#00050A] overflow-hidden">

        <canvas id="star-dust" class="absolute inset-0 z-0 opacity-40"></canvas>

        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="perspective-path"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <h2 class="hall-title text-6xl md:text-8xl font-serif uppercase text-[#E0F7FA] tracking-tighter opacity-0">
                    The Hall of <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-silver">Sovereigns</span>
                </h2>
                <p class="text-cyan-500/60 tracking-[5px] text-xs mt-4 uppercase font-mono">Nơi những huyền thoại được vinh danh</p>
            </div>

            <div id="honor-carousel" class="flex flex-col lg:flex-row justify-center items-center gap-12 lg:gap-8 h-full">

                <div class="honor-card group relative" data-sold="true">
                    <div class="video-overlay absolute inset-0 opacity-0 group-hover:opacity-30 transition-opacity duration-700 rounded-2xl overflow-hidden">
                        <video autoplay muted loop playsinline class="w-full h-full object-cover">
                            <source src="https://assets.mixkit.co/videos/preview/mixkit-night-city-street-traffic-with-cars-and-lights-34538-wide.mp4" type="video/mp4">
                        </video>
                    </div>

                    <div class="card-inner relative bg-[#001A33]/40 backdrop-blur-3xl p-8 rounded-2xl border border-white/10 flex flex-col items-center">
                        <div class="sold-seal">SOLD</div>

                        <div class="honor-plate relative mb-8">
                            <div class="sapphire-filter"></div>
                            <div class="bg-white text-black px-8 py-4 rounded-lg font-bold text-4xl font-mono shadow-2xl">
                                30K - 888.88
                            </div>
                        </div>

                        <div class="text-center space-y-2">
                            <p class="text-cyan-400/60 text-[10px] uppercase tracking-widest font-mono">Chủ sở hữu</p>
                            <h4 class="text-white text-xl font-light tracking-wide">Mr. Hoang****</h4>
                            <div class="price-sparkle-wrap mt-4">
                                <span class="text-silver text-2xl font-bold font-mono price-sparkle">2.450.000.000đ</span>
                            </div>
                        </div>
                    </div>

                    <div class="beam-effect"></div>
                </div>

                <div class="honor-card group relative">
                    <div class="card-inner relative bg-[#001A33]/40 backdrop-blur-3xl p-8 rounded-2xl border border-white/10 flex flex-col items-center">
                        <div class="sold-seal">SOLD</div>
                        <div class="honor-plate relative mb-8">
                            <div class="sapphire-filter"></div>
                            <div class="bg-white text-black px-8 py-4 rounded-lg font-bold text-4xl font-mono shadow-2xl">
                                51L - 999.99
                            </div>
                        </div>
                        <div class="text-center space-y-2">
                            <p class="text-cyan-400/60 text-[10px] uppercase tracking-widest font-mono">Chủ sở hữu</p>
                            <h4 class="text-white text-xl font-light tracking-wide">Mrs. Tuyet**</h4>
                            <div class="price-sparkle-wrap mt-4">
                                <span class="text-silver text-2xl font-bold font-mono price-sparkle">1.890.000.000đ</span>
                            </div>
                        </div>
                    </div>
                    <div class="beam-effect"></div>
                </div>

            </div>

            <div class="mt-32 max-w-2xl mx-auto glass-panel p-8 rounded-3xl border border-white/5 bg-white/5">
                <h3 class="text-silver text-center text-sm uppercase tracking-[10px] mb-8">Bảng Vàng Kỷ Lục</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-white/5 pb-4">
                        <span class="text-white/40 font-mono">01. Mr. T**</span>
                        <span class="text-cyan-400 font-bold">12.500.000.000đ</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/5 pb-4">
                        <span class="text-white/40 font-mono">02. Mr. V**</span>
                        <span class="text-cyan-400 font-bold">9.200.000.000đ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- <button class="lg:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-cyan-500 text-black font-bold px-8 py-4 rounded-full shadow-[0_0_30px_rgba(0,255,255,0.5)] uppercase text-xs tracking-widest">
            Đăng ký phiên tới
        </button> -->
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="protocol-trust" class="relative min-h-screen py-24 bg-[#000B14] overflow-hidden">

        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-1/2 w-[1px] h-full bg-cyan-500/50"></div>
            <div class="absolute top-1/4 left-0 w-full h-[1px] bg-cyan-500/50"></div>
            <div class="absolute top-3/4 left-0 w-full h-[1px] bg-cyan-500/50"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-24">
                <div id="security-shield-container" class="relative w-32 h-32 mx-auto mb-8 flex items-center justify-center">
                    <svg id="security-shield" class="w-24 h-24 text-cyan-400 drop-shadow-[0_0_20px_rgba(34,211,238,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <div class="shield-lock-glow absolute inset-0 bg-cyan-500/20 blur-3xl rounded-full opacity-0"></div>
                </div>
                <h2 class="text-4xl md:text-5xl font-serif text-[#E0F7FA] tracking-widest uppercase mb-4">Nghị Định & Niềm Tin</h2>
                <div class="h-[2px] w-24 bg-teal-500 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative">
                <svg class="hidden lg:block absolute inset-0 w-full h-full pointer-events-none" style="z-index: -1;">
                    <path d="M 33% 50% L 66% 50%" stroke="rgba(20, 184, 166, 0.2)" stroke-width="1" fill="none" />
                </svg>

                <div class="trust-block group" data-step="1">
                    <div class="trust-card relative bg-[#001F3F]/30 backdrop-blur-xl border border-teal-500/20 p-8 rounded-3xl h-full transition-all duration-500 hover:border-teal-500/60">
                        <div class="scan-line"></div>
                        <div class="trust-icon text-teal-400 mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Quy trình đặt cọc</h3>
                        <p class="text-white/70 leading-relaxed text-sm mb-6">Tiền cọc được ký quỹ an toàn tại ngân hàng đối tác liên kết, bảo mật tuyệt đối 100% đến khi kết thúc phiên.</p>
                        <div class="details opacity-0 max-h-0 overflow-hidden transition-all duration-500">
                            <ul class="text-xs text-teal-400/80 space-y-2 border-t border-white/10 pt-4">
                                <li>• Xác thực OTP đa tầng</li>
                                <li>• Hoàn tiền trong 24h làm việc</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="trust-block group" data-step="2">
                    <div class="trust-card relative bg-[#001F3F]/30 backdrop-blur-xl border border-teal-500/20 p-8 rounded-3xl h-full transition-all duration-500 hover:border-teal-500/60">
                        <div class="scan-line"></div>
                        <div class="trust-icon text-teal-400 mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Thủ tục định danh</h3>
                        <p class="text-white/70 leading-relaxed text-sm mb-6">Tuân thủ nghiêm ngặt Luật đấu giá biển số 2026. Hỗ trợ thu hồi và lắp biển mới trực tiếp tại cư trú.</p>
                        <div class="details opacity-0 max-h-0 overflow-hidden transition-all duration-500">
                            <ul class="text-xs text-teal-400/80 space-y-2 border-t border-white/10 pt-4">
                                <li>• Liên kết dữ liệu VNeID</li>
                                <li>• Bàn giao hồ sơ gốc tận tay</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="trust-block group" data-step="3">
                    <div class="trust-card relative bg-[#001F3F]/30 backdrop-blur-xl border border-teal-500/20 p-8 rounded-3xl h-full transition-all duration-500 hover:border-teal-500/60">
                        <div class="scan-line"></div>
                        <div class="trust-icon text-teal-400 mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Cam kết hoàn tiền</h3>
                        <p class="text-white/70 leading-relaxed text-sm mb-6">Sự minh bạch là tôn chỉ. Hoàn trả phí đăng ký nếu có bất kỳ sai lệch nào từ phía hệ thống đấu giá.</p>
                        <div class="details opacity-0 max-h-0 overflow-hidden transition-all duration-500">
                            <ul class="text-xs text-teal-400/80 space-y-2 border-t border-white/10 pt-4">
                                <li>• Bảo hiểm giao dịch 100%</li>
                                <li>• Pháp lý được luật sư phê duyệt</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="lg:hidden fixed bottom-6 right-6 z-50">
            <button class="bg-teal-600/90 backdrop-blur-md text-white px-6 py-4 rounded-full shadow-2xl flex items-center gap-3 border border-teal-400/30">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zm-4 0H9v2h2V9z"></path>
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest">Luật sư tư vấn</span>
            </button>
        </div> -->
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Flip.min.js"></script>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Reveal Animation
        const revealTl = gsap.timeline();
        revealTl.from("#crystal-cube", {
                y: 300,
                opacity: 0,
                rotationX: 90,
                duration: 2,
                ease: "expo.out"
            })
            .from("#plate-number", {
                clipPath: "inset(0 100% 0 0)",
                duration: 1.5
            }, "-=1");

        // 2. Continuous Rotation
        gsap.to("#crystal-cube", {
            rotationY: "+=360",
            duration: 20,
            repeat: -1,
            ease: "none"
        });

        // 3. Energy Particles
        const canvas = document.getElementById('energy-particles');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2;
                this.speedY = (Math.random() - 0.5) * 0.8;
            }
            update() {
                this.y += this.speedY;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }
            draw() {
                ctx.fillStyle = '#00FFFF';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        for (let i = 0; i < 80; i++) particles.push(new Particle());

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animate);
        }
        animate();

        // 4. Price Surge Logic
        document.getElementById('bid-now-btn').addEventListener('click', () => {
            const price = document.getElementById('current-price');

            // Hiệu ứng bùng nổ giá
            gsap.timeline()
                .to(price, {
                    scale: 1.4,
                    filter: "brightness(2)",
                    duration: 0.1
                })
                .set(price, {
                    textContent: (parseInt(price.textContent.replace(/\./g, '')) + 5000000).toLocaleString('vi-VN')
                })
                .to(price, {
                    scale: 1,
                    filter: "brightness(1)",
                    duration: 0.4,
                    ease: "back.out"
                });

            if (navigator.vibrate) navigator.vibrate(50);
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(Flip);

        // --- 1. KHỞI TẠO NỀN MATRIX PARALLAX ---
        const initMatrixBackground = () => {
            const matrixBg = document.getElementById('matrix-bg');
            if (!matrixBg) return;

            const numbers = "0123456789";
            const columnCount = 30;

            for (let i = 0; i < columnCount; i++) {
                const col = document.createElement('div');
                col.className = 'matrix-column absolute top-0 opacity-20 font-mono text-cyan-500';
                col.style.left = (i * (100 / columnCount)) + '%';
                col.style.fontSize = '10px';

                // Tạo chuỗi số ngẫu nhiên cho mỗi cột
                let content = "";
                for (let j = 0; j < 50; j++) {
                    content += numbers[Math.floor(Math.random() * numbers.length)] + "<br>";
                }
                col.innerHTML = content;
                matrixBg.appendChild(col);

                // Hiệu ứng chạy dọc vô tận với tốc độ ngẫu nhiên
                gsap.to(col, {
                    y: -150,
                    duration: 15 + Math.random() * 25,
                    repeat: -1,
                    ease: "none"
                });
            }
        };

        // --- 2. HIỆU ỨNG NGHIÊNG THẺ 3D (DESKTOP TILT) ---
        const initTiltEffect = () => {
            if (window.innerWidth > 1024) {
                const cards = document.querySelectorAll('.arena-mini-card');

                cards.forEach(card => {
                    const inner = card.querySelector('.inner-content');

                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;

                        // Tính toán góc quay (tối đa 10 độ)
                        const rotateX = (y - centerY) / 10;
                        const rotateY = (centerX - x) / 10;

                        gsap.to(inner, {
                            rotationX: rotateX,
                            rotationY: rotateY,
                            transformPerspective: 1000,
                            ease: "power2.out",
                            duration: 0.4
                        });
                    });

                    card.addEventListener('mouseleave', () => {
                        gsap.to(inner, {
                            rotationX: 0,
                            rotationY: 0,
                            duration: 0.6,
                            ease: "elastic.out(1, 0.5)"
                        });
                    });
                });
            }
        };

        // --- 3. HỆ THỐNG SẮP XẾP THÔNG MINH (FLIP ANIMATION) ---
        const reorderGrid = () => {
            const grid = document.getElementById('auction-grid');
            const cards = gsap.utils.toArray(".arena-mini-card");

            // Ghi lại trạng thái hiện tại của các phần tử
            const state = Flip.getState(cards);

            // Sắp xếp lại mảng thẻ dựa trên data-time (thời gian còn lại)
            cards.sort((a, b) => {
                return parseInt(a.dataset.time) - parseInt(b.dataset.time);
            });

            // Đưa các phần tử vào DOM theo thứ tự mới
            cards.forEach(card => grid.appendChild(card));

            // Thực hiện hiệu ứng bay mượt mà đến vị trí mới
            Flip.from(state, {
                duration: 0.8,
                ease: "power3.inOut",
                stagger: 0.05,
                scale: true,
                onStart: () => {
                    // Có thể thêm hiệu ứng lóe sáng khi thẻ đổi chỗ
                }
            });
        };

        // --- 4. HIỆU ỨNG LIVE WAVE (LÓE SÁNG KHI CÓ NGƯỜI TRẢ GIÁ) ---
        const simulateLiveBids = () => {
            setInterval(() => {
                const cards = document.querySelectorAll('.arena-mini-card');
                const randomCard = cards[Math.floor(Math.random() * cards.length)];

                if (randomCard) {
                    // Hiệu ứng nháy sáng viền
                    randomCard.classList.add('card-flash');

                    // Hiệu ứng rung nhẹ thu hút chú ý
                    gsap.to(randomCard, {
                        scale: 1.03,
                        duration: 0.1,
                        yoyo: true,
                        repeat: 1,
                        ease: "power1.inOut"
                    });

                    // Cập nhật giá giả lập
                    const priceLabel = randomCard.querySelector('.price-val');
                    if (priceLabel) {
                        let currentPrice = parseInt(priceLabel.innerText.replace('M', ''));
                        priceLabel.innerText = (currentPrice + 5) + "M";
                        gsap.from(priceLabel, {
                            scale: 1.5,
                            color: "#00FFFF",
                            duration: 0.4
                        });
                    }

                    setTimeout(() => {
                        randomCard.classList.remove('card-flash');
                    }, 1000);
                }
            }, 4000); // Mỗi 4 giây giả lập có 1 người trả giá ngẫu nhiên
        };

        // --- 5. ĐIỀU KHIỂN RESPONSIVE TRÊN MOBILE ---
        const initMobileInteractions = () => {
            if (window.innerWidth < 768) {
                // Tối ưu cuộn vô tận hoặc các tương tác vuốt
                console.log("Mobile optimization active");
            }
        };

        // KÍCH HOẠT TẤT CẢ CÁC HỆ THỐNG
        initMatrixBackground();
        initTiltEffect();
        simulateLiveBids();
        initMobileInteractions();

        // Giả lập sau 5 giây sẽ thực hiện sắp xếp lại (khi có thẻ sắp kết thúc)
        setTimeout(() => {
            console.log("Reordering grid based on priority...");
            reorderGrid();
        }, 5000);

    });

    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Foggy Reveal Animation
        gsap.registerPlugin(ScrollTrigger);

        gsap.to(".hall-title", {
            scrollTrigger: "#hall-of-sovereigns",
            opacity: 1,
            y: -20,
            duration: 2,
            ease: "power4.out"
        });

        gsap.utils.toArray(".honor-card").forEach((card, i) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top 80%",
                },
                opacity: 0,
                filter: "blur(20px)",
                y: 100,
                scale: 0.8,
                duration: 1.5,
                delay: i * 0.3,
                onComplete: () => {
                    // Kích hoạt hiệu ứng Beam sau khi thẻ hiện ra
                    const beam = card.querySelector('.beam-effect');
                    gsap.to(beam, {
                        height: "400px",
                        opacity: 1,
                        duration: 0.5,
                        onComplete: () => {
                            gsap.to(beam, {
                                opacity: 0,
                                duration: 1
                            });
                        }
                    });
                }
            });
        });

        // 2. Star Dust Particle System
        const canvas = document.getElementById('star-dust');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let stars = [];
        for (let i = 0; i < 150; i++) {
            stars.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                size: Math.random() * 1.5,
                vX: (Math.random() - 0.5) * 0.2,
                vY: (Math.random() - 0.5) * 0.2
            });
        }

        function animateStars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#00FFFF";
            stars.forEach(s => {
                s.x += s.vX;
                s.y += s.vY;
                if (s.x < 0 || s.x > canvas.width) s.vX *= -1;
                if (s.y < 0 || s.y > canvas.height) s.vY *= -1;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
                ctx.fill();
            });
            requestAnimationFrame(animateStars);
        }
        animateStars();

        // 3. Mobile 3D Carousel (Simple version)
        if (window.innerWidth < 1024) {
            // Sử dụng cử chỉ vuốt để thay đổi focus cho thẻ
            // Ở đây có thể tích hợp thư viện Swiper.js hoặc tự viết logic xoay 3D
        }
    });

    // ----------------------------- section 4 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        // 1. SHIELD REVEAL & LOCK
        const shieldTl = gsap.timeline({
            scrollTrigger: {
                trigger: "#security-shield-container",
                start: "top 70%",
            }
        });

        shieldTl.from("#security-shield", {
                rotationY: 360,
                scale: 0,
                opacity: 0,
                duration: 1.5,
                ease: "back.out(1.7)"
            })
            .to(".shield-lock-glow", {
                opacity: 1,
                duration: 0.5,
                onStart: () => {
                    // Hiệu ứng "Khóa" bằng một tia sáng mạnh
                    gsap.fromTo("#security-shield", {
                        filter: "brightness(1)"
                    }, {
                        filter: "brightness(3)",
                        duration: 0.2,
                        yoyo: true,
                        repeat: 1
                    });
                }
            });

        // 2. BLOCKS UNFOLDING (Theo thứ tự)
        gsap.utils.toArray(".trust-block").forEach((block, i) => {
            gsap.from(block, {
                scrollTrigger: {
                    trigger: block,
                    start: "top 85%",
                },
                rotationX: -90, // Hiệu ứng lật trang (Unfolding)
                opacity: 0,
                y: 50,
                duration: 1.2,
                delay: i * 0.3,
                ease: "expo.out"
            });
        });

        // 3. SCANNING EFFECT ON HOVER
        document.querySelectorAll('.trust-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                // Có thể thêm âm thanh "beep" nhẹ ở đây nếu muốn
                gsap.fromTo(card.querySelector('.trust-icon'), {
                    scale: 1
                }, {
                    scale: 1.2,
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1
                });
            });
        });
    });

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>