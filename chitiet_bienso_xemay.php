<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Relic Showcase | Biển Số Di Sản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
    <style>
        :root {
            --midnight: #000F1A;
            --electric-blue: #007FFF;
            --cyan-neon: #00f2ff;
            --ice-blue: #E0F7FA;
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--midnight);
            margin: 0;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            color: white;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Hiệu ứng bệ kính Sapphire */
        .sapphire-stage {
            background: radial-gradient(circle at center, rgba(0, 127, 255, 0.2) 0%, transparent 70%);
            perspective: 1000px;
        }

        .glass-platform {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -20px 50px rgba(0, 242, 255, 0.15);
            transform: rotateX(60deg);
        }

        /* Thiết kế biển số 3D */
        .relic-card {
            width: 280px;
            /* Tỷ lệ 190x140mm rút gọn */
            height: 206px;
            background: #f0f0f0;
            border-radius: 12px;
            position: relative;
            transform-style: preserve-3d;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            border: 4px solid #333;
        }

        /* Độ dày vật lý của biển số */
        .relic-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #999;
            transform: translateZ(-5px);
            border-radius: 12px;
        }

        .plate-content {
            padding: 20px;
            text-align: center;
            color: #1a1a1a;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #fff 0%, #e0e0e0 100%);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        /* Hiệu ứng tia sáng quét ngang (Sapphire Glimmer) */
        .scanline {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(0, 242, 255, 0.4), transparent);
            transform: skewX(-25deg);
        }

        /* Floating HUD Lines */
        .hud-line {
            position: absolute;
            background: var(--cyan-neon);
            opacity: 0.4;
            pointer-events: none;
        }

        .custom-cursor {
            width: 100px;
            height: 100px;
            border: 1px solid var(--cyan-neon);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            transform: translate(-50%, -50%);
            display: none;
        }

        @media (min-width: 1024px) {
            .custom-cursor {
                display: flex;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        .text-ice-blue {
            color: #E0F7FA;
        }

        /* Hiệu ứng Focus Spotlight */
        .attribute-card:hover .spotlight {
            opacity: 1;
        }

        .attribute-card:hover {
            border-color: rgba(0, 242, 255, 0.4);
            transform: translateY(-5px);
            transition: all 0.4s cubic-bezier(0.2, 1, 0.3, 1);
        }

        /* Đè CSS cho Chart.js để mượt hơn */
        #radarChart {
            filter: drop-shadow(0 0 20px rgba(0, 242, 255, 0.2));
        }

        /* ----------------------------- section 3 -----------------------------  */
        #virtual-fitting {
            --s-cyan: #00f2ff;
            --s-navy: #00050A;
            background-color: var(--s-navy);
            perspective: 2000px;
            overflow: hidden;
        }

        /* Khung chứa xe máy */
        #bike-display {
            position: relative;
            z-index: 10;
            transform-style: preserve-3d;
            will-change: transform;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Ảnh xe máy - Chống kéo nhầm ảnh khi xoay */
        #current-bike-img {
            max-height: 500px;
            width: auto;
            user-select: none;
            -webkit-user-drag: none;
            filter: drop-shadow(0 20px 50px rgba(0, 0, 0, 0.6));
            z-index: 5;
        }

        /* Container biển số gắn trên xe */
        #attached-plate {
            position: absolute;
            pointer-events: none;
            z-index: 999999999;
            /* Phải cao hơn ảnh xe */
            transform-origin: center;
            transition: transform 0.1s ease-out;
        }

        /* Thiết kế thẻ biển số mini - Fix lỗi font và border */
        .mini-plate-skin {
            width: 75px;
            height: 55px;
            background: #fdfdfd;
            border: 1.5px solid #222;
            border-radius: 3px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5), inset 0 0 2px rgba(0, 0, 0, 0.1);
            padding: 2px;
            background-image: linear-gradient(135deg, #fff 0%, #ebebeb 100%);
        }

        /* Font số trên biển gắn xe */
        .mini-plate-skin span {
            font-family: 'Space Mono', monospace !important;
            color: #000 !important;
            line-height: 1.1 !important;
            text-align: center;
        }

        .mini-plate-skin .plate-top {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-bottom: 0.5px solid #ccc;
            width: 90%;
            margin-bottom: 1px;
        }

        .mini-plate-skin .plate-bottom {
            font-size: 13px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }

        /* Hiệu ứng sàn phản chiếu */
        .reflective-floor {
            position: absolute;
            bottom: 15%;
            width: 100%;
            height: 150px;
            background: radial-gradient(ellipse at center, rgba(0, 127, 255, 0.2) 0%, transparent 75%);
            filter: blur(50px);
            transform: rotateX(80deg);
            pointer-events: none;
            z-index: 1;
        }

        /* Selector chọn xe mượt mà hơn */
        .bike-icon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(255, 255, 255, 0.05);
            background: rgba(255, 255, 255, 0.02);
            cursor: pointer;
            padding: 8px;
        }

        .bike-icon:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 242, 255, 0.3);
        }

        .bike-icon.active {
            border-color: var(--s-cyan);
            background: rgba(0, 242, 255, 0.1);
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.3);
        }

        /* Nút Snap-On lơ lửng */
        #snap-trigger {
            z-index: 100;
            transition: all 0.5s ease;
        }

        #snap-trigger.hidden-plate {
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, -50%) scale(0.5);
        }

        /* Tablet & Mobile responsive */
        @media (max-width: 1024px) {
            #current-bike-img {
                max-height: 350px;
            }

            .mini-plate-skin {
                width: 55px;
                height: 40px;
            }

            .mini-plate-skin .plate-top {
                font-size: 7px;
            }

            .mini-plate-skin .plate-bottom {
                font-size: 10px;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */
        .neon-text {
            text-shadow: 0 0 10px rgba(0, 242, 255, 0.5), 0 0 20px rgba(0, 242, 255, 0.3);
        }

        .seal-ring {
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .action-box {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .action-box:hover {
            transform: scale(1.02);
        }

        /* --- CSS CHO TRUST SEAL - SECTION 4 --- */

        #trust-seal {
            z-index: 50;
            pointer-events: none;
            /* Hiệu ứng drop shadow để tạo độ nổi khối 3D */
            filter: drop-shadow(0 0 15px rgba(0, 242, 255, 0.4));
        }

        /* Vòng tròn lan tỏa xung quanh con dấu */
        .seal-ring {
            position: absolute;
            inset: 0;
            border: 2px solid var(--cyan-neon);
            border-radius: 50%;
            animation: seal-pulse 2s cubic-bezier(0.24, 0, 0.38, 1) infinite;
            opacity: 0;
        }

        /* Hiệu ứng sóng lan tỏa */
        @keyframes seal-pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        /* Hiệu ứng khi con dấu "đóng" xuống (Impact effect) */
        .seal-impact {
            animation: impact-shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes impact-shake {

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

        /* Đảm bảo icon bên trong sáng rực rỡ */
        #trust-seal i {
            text-shadow: 0 0 10px rgba(0, 242, 255, 0.8);
        }

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <div class="custom-cursor" id="cursor">
        <span class="text-[8px] text-cyan-400 font-bold tracking-widest uppercase">Drag to Rotate</span>
    </div>

    <section class="relative min-h-screen flex flex-col lg:flex-row items-center justify-center p-6 sapphire-stage overflow-hidden">

        <div class="absolute top-0 left-1/4 w-[1px] h-screen bg-gradient-to-b from-cyan-500/20 to-transparent"></div>
        <div class="absolute top-0 right-1/4 w-[1px] h-screen bg-gradient-to-b from-cyan-500/20 to-transparent"></div>

        <div class="relative flex-1 flex flex-col items-center justify-center z-10 w-full">

            <div id="hud-top" class="absolute top-[-40px] left-[-20px] text-cyan-400 font-mono text-[10px] opacity-0">
                <p>[ REGION_CODE: 29-G1 ]</p>
                <div class="hud-line h-[1px] w-20 origin-left mt-1"></div>
            </div>

            <div id="hud-bottom" class="absolute bottom-[-40px] right-[-20px] text-cyan-400 font-mono text-[10px] opacity-0 text-right">
                <div class="hud-line h-[1px] w-20 origin-right mb-1 ml-auto"></div>
                <p>[ STATUS: LEGENDARY_RELIC ]</p>
            </div>

            <div id="relic-wrapper" class="relative cursor-grab active:cursor-grabbing">
                <div class="relic-card" id="plate">
                    <div class="plate-content">
                        <div class="scanline" id="scan-effect"></div>
                        <p class="text-3xl font-bold tracking-widest font-mono">29-G1</p>
                        <p class="text-5xl font-extrabold tracking-tighter font-mono mt-2">888.88</p>
                    </div>
                </div>
            </div>

            <div class="glass-platform w-[300px] h-[300px] rounded-full mt-[-60px] z-[-1]"></div>
        </div>

        <div class="w-full lg:w-1/3 flex flex-col gap-8 z-20 mt-12 lg:mt-0">
            <div class="space-y-2">
                <h4 class="text-cyan-500 font-mono text-xs tracking-[0.3em] uppercase italic">Current Valuation</h4>
                <h2 class="text-5xl lg:text-6xl font-bold text-white tracking-tighter">850.000.000<span class="text-cyan-400 text-2xl">₫</span></h2>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white/5 border border-white/10 p-4 rounded-xl backdrop-blur-md">
                    <p class="text-gray-500 text-[10px] uppercase font-bold">Mã vùng</p>
                    <p class="text-white font-mono">Hà Nội (G1)</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-4 rounded-xl backdrop-blur-md">
                    <p class="text-gray-500 text-[10px] uppercase font-bold">Độ hiếm</p>
                    <p class="text-cyan-400 font-mono font-bold">9.9/10</p>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <button class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-4 rounded-full transition-all shadow-[0_0_30px_rgba(0,242,255,0.3)] uppercase tracking-widest text-sm">
                    Sở hữu báu vật ngay
                </button>
                <div class="flex gap-3">
                    <button class="flex-1 bg-white/5 hover:bg-white/10 text-white py-3 rounded-full border border-white/10 transition-all text-xs uppercase font-bold">
                        <i class="ri-heart-line mr-2"></i> Lưu báu vật
                    </button>
                    <button class="flex-1 bg-white/5 hover:bg-white/10 text-white py-3 rounded-full border border-white/10 transition-all text-xs uppercase font-bold">
                        <i class="ri-share-forward-line mr-2"></i> Chia sẻ
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="numerology-matrix" class="relative py-20 bg-[#000810] overflow-hidden border-t border-white/5">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[2px] h-20 bg-gradient-to-b from-cyan-500 to-transparent"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-16 items-center">

                <div class="w-full lg:w-1/2 space-y-6">
                    <h3 class="text-cyan-500 font-mono text-sm tracking-[0.4em] uppercase mb-12 flex items-center gap-4">
                        <span class="w-2 h-2 bg-cyan-500 rounded-full animate-pulse"></span>
                        The Core Attributes
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="attribute-grid">
                        <div class="attribute-card group p-6 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl relative overflow-hidden cursor-none">
                            <div class="spotlight absolute inset-0 bg-cyan-500/10 opacity-0 transition-opacity duration-300 pointer-events-none"></div>
                            <p class="text-gray-500 font-mono text-[10px] uppercase tracking-widest mb-2">Mã Vùng</p>
                            <h4 class="text-xl text-ice-blue font-semibold scramble-text" data-value="Hà Nội - 29G1">00000000000</h4>
                        </div>

                        <div class="attribute-card group p-6 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl relative overflow-hidden cursor-none">
                            <div class="spotlight absolute inset-0 bg-cyan-500/10 opacity-0 transition-opacity duration-300 pointer-events-none"></div>
                            <p class="text-gray-500 font-mono text-[10px] uppercase tracking-widest mb-2">Tình trạng</p>
                            <h4 class="text-xl text-ice-blue font-semibold scramble-text" data-value="Chưa đăng ký">00000000000</h4>
                        </div>

                        <div class="attribute-card group p-6 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl relative overflow-hidden cursor-none">
                            <div class="spotlight absolute inset-0 bg-cyan-500/10 opacity-0 transition-opacity duration-300 pointer-events-none"></div>
                            <p class="text-gray-500 font-mono text-[10px] uppercase tracking-widest mb-2">Đời biển</p>
                            <h4 class="text-xl text-ice-blue font-semibold scramble-text" data-value="Series 2025">00000000000</h4>
                        </div>

                        <div class="attribute-card group p-6 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl relative overflow-hidden cursor-none">
                            <div class="spotlight absolute inset-0 bg-cyan-500/10 opacity-0 transition-opacity duration-300 pointer-events-none"></div>
                            <p class="text-gray-500 font-mono text-[10px] uppercase tracking-widest mb-2">Pháp lý</p>
                            <h4 class="text-xl text-ice-blue font-semibold scramble-text" data-value="Chính chủ">00000000000</h4>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex flex-col items-center">
                    <div class="relative w-full max-w-[450px] aspect-square">
                        <div class="hidden md:block">
                            <canvas id="radarChart"></canvas>
                        </div>

                        <div class="block md:hidden space-y-6 w-full">
                            <h4 class="text-white font-mono text-center mb-8 uppercase tracking-widest">Destiny Scores</h4>
                            <div class="space-y-4">
                                <div class="mobile-progress" data-label="Tài Lộc" data-value="95"></div>
                                <div class="mobile-progress" data-label="Quyền Lực" data-value="88"></div>
                                <div class="mobile-progress" data-label="Bình An" data-value="75"></div>
                                <div class="mobile-progress" data-label="Độc Bản" data-value="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="virtual-fitting" class="relative min-h-screen bg-[#00050A] overflow-hidden py-20">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#001525] z-0"></div>
        <div class="absolute bottom-0 w-full h-1/2 bg-[radial-gradient(ellipse_at_center,_rgba(0,127,255,0.1)_0%,_transparent_70%)] opacity-50"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-10">
                <h3 class="text-cyan-500 font-mono text-xs tracking-[0.5em] uppercase mb-2">The Virtual Fitting</h3>
                <h2 id="bike-name" class="text-3xl md:text-5xl font-extralight text-ice-blue tracking-tighter italic">Vespa 946 Christian Dior</h2>
            </div>

            <div class="relative w-full h-[400px] md:h-[600px] flex items-center justify-center">
                <div class="absolute bottom-10 w-full h-40 bg-white/5 blur-3xl rounded-[100%] scale-y-50 opacity-20"></div>

                <div id="bike-display" class="relative z-10 transition-transform duration-700 ease-out cursor-grab active:cursor-grabbing">
                    <img id="current-bike-img" src="vespa946christiandior155zing1-09213937-removebg-preview.png"
                        class="max-h-[350px] md:max-h-[500px] object-contain drop-shadow-[0_20px_50px_rgba(0,0,0,0.8)]" alt="Bike">

                    <div id="attached-plate" class="absolute opacity-0 scale-50 z-[100] pointer-events-none">
                        <div class="mini-plate-skin flex flex-col items-center justify-center bg-white border border-gray-400 shadow-2xl">
                            <span class="plate-text-top text-black font-bold uppercase">29-G1</span>
                            <span class="plate-text-bottom text-black font-black">888.88</span>
                        </div>
                    </div>
                </div>

                <button id="snap-trigger" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 w-20 h-20 rounded-full border border-cyan-500/30 flex items-center justify-center group">
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-full flex items-center justify-center group-hover:bg-cyan-500 transition-all">
                        <i class="ri-attachment-line text-white text-xl"></i>
                    </div>
                    <span class="absolute -bottom-8 w-32 text-center text-[10px] text-cyan-400 font-mono opacity-0 group-hover:opacity-100 transition-opacity uppercase tracking-widest">Gắn biển ngay</span>
                </button>
            </div>

            <div class="mt-12 flex flex-col items-center gap-8">
                <div class="flex gap-4 md:gap-8 overflow-x-auto pb-4 max-w-full no-scrollbar" id="bike-selector">
                    <button onclick="changeBike('vespa', 'Vespa 946 Christian Dior', 'vespa946christiandior155zing1-09213937-removebg-preview.png', {top: '72%', left: '33%'})"
                        class="bike-icon active shrink-0 w-20 h-20 rounded-full border-2 border-cyan-500 p-2 bg-white/5">
                        <img src="vespa946christiandior155zing1-09213937-removebg-preview.png" class="w-full h-full object-contain" alt="Vespa">
                    </button>

                    <button onclick="changeBike('sh', 'Honda SH350i Heritage', '350-xanh-tt.webp', {top: '68%', left: '38%'})"
                        class="bike-icon shrink-0 w-20 h-20 rounded-full border-2 border-white/10 p-2 bg-white/5">
                        <img src="350-xanh-tt.webp" class="w-full h-full object-contain" alt="Honda SH">
                    </button>
                </div>

                <div class="flex gap-4">
                    <div onclick="changeColor('#0a0a0a')" class="w-8 h-8 rounded-full bg-[#0a0a0a] border border-white/20 cursor-pointer hover:scale-125 transition-all shadow-lg"></div>
                    <div onclick="changeColor('#f0f0f0')" class="w-8 h-8 rounded-full bg-[#f0f0f0] border border-white/20 cursor-pointer hover:scale-125 transition-all shadow-lg"></div>
                    <div onclick="changeColor('#007FFF')" class="w-8 h-8 rounded-full bg-[#007FFF] border border-white/20 cursor-pointer hover:scale-125 transition-all shadow-lg"></div>
                    <div onclick="changeColor('#C41E3A')" class="w-8 h-8 rounded-full bg-[#C41E3A] border border-white/20 cursor-pointer hover:scale-125 transition-all shadow-lg"></div>
                </div>
            </div>
        </div>

        <button class="fixed bottom-6 right-6 lg:hidden w-14 h-14 bg-cyan-600 rounded-full flex items-center justify-center shadow-2xl z-50">
            <i class="ri-camera-3-line text-white text-2xl"></i>
        </button>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="sovereign-gateway" class="relative min-h-screen bg-[#000814] flex items-center justify-center overflow-hidden py-20" style="height: 160vh!important">
        <canvas id="liquid-data-canvas" class="absolute inset-0 z-0 opacity-30"></canvas>

        <div class="container mx-auto px-6 relative z-10">
            <div id="trust-seal" class="absolute top-[150px] left-1/2 -translate-x-1/2 w-32 h-32 opacity-0 pointer-events-none">
                <div class="w-full h-full rounded-full border-2 border-cyan-500/50 flex items-center justify-center bg-cyan-500/10 backdrop-blur-md">
                    <i class="ri-shield-check-fill text-cyan-400 text-5xl"></i>
                </div>
                <div class="seal-ring absolute inset-0 border border-cyan-400 rounded-full"></div>
            </div>

            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl font-serif text-white mb-4 tracking-tight">CHỦ NHÂN TIẾP THEO LÀ BẠN</h2>
                <p class="text-cyan-500 font-mono text-sm tracking-[0.3em] uppercase">The Sovereign Ledger Entry</p>
            </div>

            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="action-box group relative p-10 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-2xl transition-all duration-500 hover:border-cyan-500/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl"></div>

                    <h3 class="text-xl font-semibold text-white mb-8 flex items-center gap-3">
                        <i class="ri-flashlight-fill text-yellow-400"></i> Sở hữu tức thời
                    </h3>

                    <div class="mb-10">
                        <span class="text-gray-400 text-sm font-mono block mb-2 uppercase tracking-widest">Giá niêm yết</span>
                        <div class="text-5xl md:text-6xl font-bold text-white tracking-tighter neon-text">
                            850.000.000<span class="text-xl text-cyan-400">₫</span>
                        </div>
                    </div>

                    <button id="buy-now-btn" class="magnetic-wrap relative w-full py-5 bg-gradient-to-r from-blue-700 to-cyan-500 rounded-xl text-white font-bold uppercase tracking-[0.2em] shadow-[0_0_20px_rgba(0,127,255,0.4)] overflow-hidden">
                        <span class="relative z-10">Sở hữu ngay</span>
                        <div class="inverse-glow absolute inset-0 bg-white opacity-0 transition-opacity duration-300"></div>
                    </button>
                </div>

                <div class="action-box group relative p-10 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-2xl transition-all duration-500 hover:border-blue-500/50">
                    <h3 class="text-xl font-semibold text-white mb-8 flex items-center gap-3">
                        <i class="ri-customer-service-2-fill text-blue-400"></i> Tư vấn đặc quyền
                    </h3>

                    <p class="text-gray-400 mb-10 leading-relaxed font-light">
                        Kết nối trực tiếp với chuyên gia định danh di sản để nhận lộ trình pháp lý và giải pháp tài chính tối ưu nhất cho riêng bạn.
                    </p>

                    <button class="w-full py-5 border border-white/20 rounded-xl text-white font-bold uppercase tracking-[0.2em] hover:bg-white hover:text-black transition-all">
                        Liên hệ chuyên gia
                    </button>
                </div>
            </div>

            <div class="mt-20 flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-700">
                <div class="flex items-center gap-2 text-green-400 font-mono text-[10px] tracking-widest uppercase">
                    <i class="ri-lock-2-line text-lg"></i> SSL Secured
                </div>
                <div class="flex items-center gap-2 text-green-400 font-mono text-[10px] tracking-widest uppercase">
                    <i class="ri-bank-card-line text-lg"></i> PCI DSS
                </div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4 invert">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-8">
            </div>
        </div>

        <div class="fixed bottom-0 left-0 w-full p-4 grid grid-cols-2 gap-3 bg-black/60 backdrop-blur-xl border-t border-white/10 z-[100] lg:hidden">
            <button class="bg-white/10 text-white py-4 rounded-xl text-xs font-bold uppercase tracking-widest border border-white/10">Tư vấn</button>
            <button onclick="triggerHaptic()" class="bg-cyan-600 text-white py-4 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-cyan-900/40">Mua ngay</button>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // 1. Khởi tạo hiệu ứng Entrance Reveal
    window.addEventListener('load', () => {
        const tl = gsap.timeline();

        tl.from("#plate", {
                scale: 0,
                rotateY: 180,
                duration: 1.5,
                ease: "back.out(1.7)"
            })
            .to("#hud-top, #hud-bottom", {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.2
            }, "-=0.5");

        // 2. Hiệu ứng "The 360° Float" (Chuyển động tự do)
        gsap.to("#plate", {
            y: -15,
            rotateX: 5,
            rotateZ: 2,
            duration: 3,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 3. Hiệu ứng Sapphire Glimmer (Tia sáng quét)
        setInterval(() => {
            gsap.fromTo("#scan-effect", {
                left: "-100%"
            }, {
                left: "200%",
                duration: 1,
                ease: "power2.inOut"
            });
        }, 5000);
    });

    // 4. Tương tác Magnetic Tilt & Cursor
    const plate = document.getElementById('plate');
    const cursor = document.getElementById('cursor');

    if (window.innerWidth >= 1024) {
        document.addEventListener('mousemove', (e) => {
            // Custom Cursor logic
            gsap.to(cursor, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.1
            });

            // Tilt logic
            const xPos = (e.clientX / window.innerWidth) - 0.5;
            const yPos = (e.clientY / window.innerHeight) - 0.5;

            gsap.to(plate, {
                rotateY: xPos * 40,
                rotateX: -yPos * 40,
                duration: 0.6,
                ease: "power2.out"
            });
        });
    }

    // 5. Mobile Touch Rotate (Inertia)
    Draggable.create("#plate", {
        type: "rotation,x,y",
        inertia: true,
        onDrag: function() {
            // Rung nhẹ khi xoay đến góc chính diện (0 độ)
            if (Math.abs(this.rotation % 360) < 5) {
                if (window.navigator.vibrate) window.navigator.vibrate(10);
            }
        }
    });

    // ----------------------------- section 2 ----------------------------- //
    gsap.registerPlugin(TextPlugin, ScrollTrigger);

    document.addEventListener('DOMContentLoaded', () => {

        // 1. Hiệu ứng Scramble Text khi cuộn tới
        const scrambleTexts = document.querySelectorAll('.scramble-text');

        ScrollTrigger.create({
            trigger: "#numerology-matrix",
            start: "top 70%",
            onEnter: () => {
                scrambleTexts.forEach(el => {
                    const finalValue = el.getAttribute('data-value');
                    gsap.to(el, {
                        duration: 1,
                        text: {
                            value: finalValue,
                            scrambleText: {
                                chars: "0123456789ABCDEF",
                                speed: 0.5
                            }
                        },
                        ease: "none"
                    });
                });

                // Kích hoạt Progress Bar Mobile
                initMobileProgress();
            }
        });

        // 2. Khởi tạo Biểu đồ Radar (Desktop)
        const ctx = document.getElementById('radarChart').getContext('2d');
        const radarData = {
            labels: ['TÀI LỘC', 'QUYỀN LỰC', 'BÌNH AN', 'ĐỘC BẢN', 'TRƯỜNG CỬU'],
            datasets: [{
                label: 'Chỉ số phong thủy',
                data: [95, 88, 75, 100, 92],
                backgroundColor: 'rgba(0, 242, 255, 0.1)',
                borderColor: '#00f2ff',
                borderWidth: 2,
                pointBackgroundColor: '#00f2ff',
                pointRadius: 4
            }]
        };

        const myRadarChart = new Chart(ctx, {
            type: 'radar',
            data: radarData,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            color: 'rgba(255,255,255,0.1)'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        },
                        pointLabels: {
                            color: '#00f2ff',
                            font: {
                                family: 'Monospace',
                                size: 10
                            }
                        },
                        ticks: {
                            display: false
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutElastic'
                }
            }
        });

        // 3. Hiệu ứng Progress Bar Mobile
        function initMobileProgress() {
            const containers = document.querySelectorAll('.mobile-progress');
            containers.forEach(container => {
                if (container.innerHTML !== "") return;
                const label = container.getAttribute('data-label');
                const val = container.getAttribute('data-value');

                container.innerHTML = `
                <div class="flex justify-between text-[10px] text-cyan-400 font-mono mb-1">
                    <span>${label}</span>
                    <span>${val}%</span>
                </div>
                <div class="h-[2px] w-full bg-white/10 overflow-hidden">
                    <div class="progress-bar h-full bg-cyan-500 w-0"></div>
                </div>
            `;

                gsap.to(container.querySelector('.progress-bar'), {
                    width: val + "%",
                    duration: 1.5,
                    ease: "power4.out"
                });
            });
        }

        // 4. Focus Spotlight Tracking
        const cards = document.querySelectorAll('.attribute-card');
        cards.forEach(card => {
            const spotlight = card.querySelector('.spotlight');
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                gsap.to(spotlight, {
                    background: `radial-gradient(circle at ${x}px ${y}px, rgba(0,242,255,0.15) 0%, transparent 80%)`,
                    duration: 0.3
                });
            });
        });
    });

    // ----------------------------- section 3 ----------------------------- //
    // Cấu hình vị trí gắn biển mặc định cho Vespa
    let platePosition = {
        top: '68%',
        left: '32%'
    };
    let isPlateAttached = false; // Biến kiểm soát trạng thái đã gắn biển chưa
    function changeBike(id, name, img, pos) {
        const plate = document.getElementById('attached-plate');
        const trigger = document.getElementById('snap-trigger');
        // 1. Hiệu ứng đổi tên
        gsap.to("#bike-name", {
            opacity: 0,
            y: 10,
            duration: 0.3,
            onComplete: () => {
                document.getElementById('bike-name').innerText = name;
                gsap.to("#bike-name", {
                    opacity: 1,
                    y: 0,
                    duration: 0.5
                });
            }
        });
        // Đảm bảo khi đổi xe, biển số tạm ẩn đi để bấm Snap lại
        gsap.set("#attached-plate", {
            opacity: 0,
            scale: 0.5,
            display: 'block' // Đảm bảo không bị display: none
        });
        gsap.to("#snap-trigger", {
            scale: 1,
            opacity: 1,
            duration: 0.3
        });

        // 2. Hiệu ứng đổi ảnh xe
        gsap.to("#current-bike-img", {
            scale: 0.8,
            opacity: 0,
            duration: 0.4,
            onComplete: () => {
                document.getElementById('current-bike-img').src = img;
                platePosition = pos; // Cập nhật tọa độ mới của xe mới

                gsap.to("#current-bike-img", {
                    scale: 1,
                    opacity: 1,
                    duration: 0.6
                });

                // NẾU BIỂN ĐANG GẮN: Cho biển bay ngay sang vị trí mới trên xe mới
                if (isPlateAttached) {
                    gsap.to(plate, {
                        top: pos.top,
                        left: pos.left,
                        duration: 0.6,
                        ease: "back.out(1.2)",
                        opacity: 1,
                        scale: 1
                    });
                }
            }
        });

        // Cập nhật giao diện nút chọn xe
        document.querySelectorAll('.bike-icon').forEach(btn => btn.classList.remove('active', 'border-cyan-500'));
        event.currentTarget.classList.add('active', 'border-cyan-500');
    }

    // Hiệu ứng Snap-On
    document.getElementById('snap-trigger').addEventListener('click', function() {
        const plate = document.getElementById('attached-plate');

        // Ẩn nút trigger
        gsap.to(this, {
            scale: 0,
            opacity: 0,
            duration: 0.3
        });

        // Hiệu ứng bay biển
        gsap.set(plate, {
            top: '50%',
            left: '50%',
            xPercent: -50,
            yPercent: -50,
            opacity: 1,
            scale: 2,
            rotateY: 45
        });

        gsap.to(plate, {
            top: platePosition.top,
            left: platePosition.left,
            scale: 1,
            rotateY: 0,
            duration: 1.2,
            ease: "back.inOut(1.7)",
            onComplete: () => {
                // Flash effect khi khớp
                gsap.to(plate, {
                    boxShadow: "0 0 20px #00f2ff",
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1
                });
            }
        });
    });

    // Hiệu ứng xoay 360 độ (Drag Interaction)
    Draggable.create("#bike-display", {
        type: "x",
        onDrag: function() {
            let rotation = this.x / 5;
            gsap.set("#bike-display", {
                rotationY: rotation
            });
        },
        onDragEnd: function() {
            gsap.to("#bike-display", {
                rotationY: 0,
                duration: 1.5,
                ease: "power2.out"
            });
        }
    });

    // Hiệu ứng đổi màu xe (Color Wave)
    function changeColor(hex) {
        const bikeImg = document.getElementById('current-bike-img');
        // Giả lập hiệu ứng quét màu
        const tl = gsap.timeline();
        tl.to(bikeImg, {
                filter: `drop-shadow(0 0 30px ${hex})`,
                duration: 0.5
            })
            .to(bikeImg, {
                opacity: 0.7,
                duration: 0.2
            })
            .to(bikeImg, {
                opacity: 1,
                duration: 0.5
            });
    }

    // Cảm biến nghiêng điện thoại (Gyroscope)
    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', (event) => {
            if (window.innerWidth < 1024) {
                let tiltX = event.gamma / 2; // Nghiêng trái phải
                gsap.to("#bike-display", {
                    x: tiltX,
                    duration: 0.5
                });
            }
        });
    }

    // ----------------------------- section 4 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Hiệu ứng "The Trust Seal" khi cuộn tới
        ScrollTrigger.create({
            trigger: "#sovereign-gateway",
            start: "top 60%",
            onEnter: () => {
                const tl = gsap.timeline();
                tl.to("#trust-seal", {
                        opacity: 1,
                        top: "-30%",
                        duration: 0.8,
                        ease: "bounce.out"
                    })
                    .to("#sovereign-gateway", {
                        backgroundColor: "#001220",
                        duration: 0.2,
                        yoyo: true,
                        repeat: 1
                    }); // Hiệu ứng rung màn hình nhẹ
            }
        });

        // 2. Hiệu ứng Lực hút năng lượng cho nút Mua ngay (Inverse Glow)
        const buyBtn = document.getElementById('buy-now-btn');
        const glow = buyBtn.querySelector('.inverse-glow');

        buyBtn.addEventListener('mouseenter', () => {
            gsap.to(glow, {
                opacity: 0.2,
                scale: 2,
                duration: 0.4
            });
            gsap.to(buyBtn, {
                boxShadow: "0 0 40px rgba(0, 242, 255, 0.8)",
                duration: 0.4
            });
        });

        buyBtn.addEventListener('mouseleave', () => {
            gsap.to(glow, {
                opacity: 0,
                scale: 1,
                duration: 0.4
            });
            gsap.to(buyBtn, {
                boxShadow: "0 0 20px rgba(0, 127, 255, 0.4)",
                duration: 0.4
            });
        });

        // 3. Hiệu ứng Liquid Data Flow Background (Canvas)
        const canvas = document.getElementById('liquid-data-canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.speed = Math.random() * 0.5 + 0.1;
                this.size = Math.random() * 2;
            }
            draw() {
                ctx.fillStyle = "#007FFF";
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
            update() {
                this.y += this.speed;
                if (this.y > canvas.height) this.y = 0;
            }
        }

        for (let i = 0; i < 100; i++) particles.push(new Particle());

        function animateLiquid() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animateLiquid);
        }
        animateLiquid();
    });

    // 4. Mobile Haptic Feedback
    function triggerHaptic() {
        if (window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate([50, 30, 50]); // Rung Double click
        }
        alert("Hệ thống đang khởi tạo cổng thanh toán an toàn...");
    }

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>