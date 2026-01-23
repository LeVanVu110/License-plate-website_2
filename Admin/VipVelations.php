<!DOCTYPE html>
<html lang="en">

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
            inset: -2px;
            /* Đẩy ra ngoài một chút để làm viền */
            border-radius: 1.5rem;
            padding: 2px;
            /* Độ dày viền */
            /* Tạo dải màu gradient xoay */
            background: conic-gradient(from 0deg, transparent 70%, #0891B2);
            /* Dùng mask để chỉ hiện phần viền, đục rỗng phần giữa */
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;

            /* Animation xoay toàn bộ mask */
            /* animation: rotate-border 4s linear infinite; */
            pointer-events: none;
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

                <div class="flex items-center gap-2 md:gap-4 flex-1 justify-end md:flex-none">
                    <div class="relative group flex-1 md:flex-none">
                        <i class="ri-search-2-line absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
                        <input type="text" id="deep-search" autocomplete="off" placeholder="Search..."
                            class="bg-white/5 border border-white/10 rounded-lg md:rounded-xl py-2 pl-9 pr-3 text-[11px] text-white focus:outline-none focus:ring-1 focus:ring-[#0891B2] w-full md:w-[180px] lg:w-[240px] transition-all">

                        <div id="search-suggestions" class="absolute top-[120%] left-[-50px] md:left-0 right-0 w-[250px] md:w-full rounded-xl overflow-hidden shadow-2xl">
                            <div class="p-2 text-[9px] text-white/40 border-b border-white/5 uppercase font-bold bg-black">Suggested</div>
                            <div class="suggestion-item p-3 cursor-pointer flex items-center gap-3 bg-black hover:bg-white/5" onclick="selectVIP('David Le')">
                                <div class="w-7 h-7 rounded-full bg-cyan-500/20 flex items-center justify-center text-[10px] text-cyan-400">DL</div>
                                <span class="text-[11px] text-white">David Le (Diamond)</span>
                            </div>
                        </div>
                    </div>

                    <button class="bg-[#F1C40F] text-black w-9 h-9 md:w-auto md:h-auto md:px-5 md:py-2.5 rounded-lg md:rounded-xl flex items-center justify-center shadow-lg">
                        <i class="ri-add-line font-bold"></i>
                        <span class="hidden md:inline ml-2 text-[10px] font-bold uppercase tracking-widest">Add VIP</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div id="focus-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] opacity-0 pointer-events-none transition-opacity duration-500"></div>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="elite-grid" class="pt-32 pb-20 px-4 md:px-8 transition-all duration-500 ml-0 md:left-20 lg:ml-24" style="margin-left: 17%;">

        <div class="flex flex-wrap items-center justify-between mb-10 gap-4 relative z-20">
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold text-white/60 hover:text-[#F1C40F] hover:border-[#F1C40F]/50 transition-all">ALL MEMBERS</button>
                <button class="px-4 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold text-white/60 hover:text-cyan-400">DIAMOND CLUB</button>
            </div>
            <div id="compare-mode-indicator" class="hidden items-center gap-3 bg-[#0891B2]/20 border border-[#0891B2]/50 px-4 py-2 rounded-full">
                <span class="text-[10px] text-cyan-400 font-bold animate-pulse">COMPARE MODE ACTIVE</span>
                <button onclick="exitCompareMode()" class="text-white hover:text-rose-500"><i class="ri-close-circle-fill"></i></button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="member-masonry">

            <div class="member-card-wrapper" data-rank="diamond">
                <div class="member-card diamond-card relative overflow-hidden group p-6 rounded-[1.5rem] border border-white/10 bg-[#0a0a0a] transition-all duration-500 cursor-pointer" data-tilt data-tilt-max="10" data-tilt-glare data-tilt-max-glare="0.3">

                    <div class="online-flow"></div>

                    <div class="flex justify-between items-start mb-8 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="https://i.pravatar.cc/150?u=david" class="w-12 h-12 rounded-full border-2 border-[#0891B2] grayscale group-hover:grayscale-0 transition-all">
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-[#0891B2] rounded-full border-2 border-black"></div>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm tracking-wide ghost-info">Mr. D****</h3>
                                <span class="text-[9px] text-white/40 font-mono tracking-widest uppercase">ID: 8888-99</span>
                            </div>
                        </div>
                        <div class="rank-badge diamond-badge">DIAMOND</div>
                    </div>

                    <div class="mb-8 relative z-10">
                        <p class="text-[9px] text-white/30 uppercase tracking-[2px] mb-3">Wealth Pulse (30D)</p>
                        <div class="h-12 w-full flex items-end gap-1">
                            <div class="flex-1 bg-cyan-500/20 h-[40%] rounded-t-sm"></div>
                            <div class="flex-1 bg-cyan-500/40 h-[60%] rounded-t-sm"></div>
                            <div class="flex-1 bg-cyan-500/20 h-[30%] rounded-t-sm"></div>
                            <div class="flex-1 bg-cyan-500/80 h-[90%] rounded-t-sm animate-pulse"></div>
                            <div class="flex-1 bg-[#0891B2] h-[100%] rounded-t-sm"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/5 relative z-10">
                        <div>
                            <span class="text-[8px] text-white/30 block uppercase">Super Plates</span>
                            <span class="text-sm font-bold text-white ghost-info">12</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[8px] text-white/30 block uppercase">Bidding Limit</span>
                            <span class="text-sm font-bold text-[#F1C40F] ghost-info">$5.0M</span>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 h-1 bg-emerald-500 transition-all duration-500" style="width: 95%;"></div>

                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/diamond-upholstery.png')]"></div>
                </div>
            </div>

            <div class="member-card-wrapper" data-rank="gold">
                <div class="member-card gold-card relative overflow-hidden group p-6 rounded-[1.5rem] border border-white/10 bg-[#1a120b] transition-all duration-500 cursor-pointer" data-tilt data-tilt-max="10">
                    <div class="flex justify-between items-start mb-8 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full border-2 border-[#F1C40F]/30 bg-white/5 flex items-center justify-center text-white/60">Ms. H</div>
                            <div>
                                <h3 class="text-white font-bold text-sm tracking-wide ghost-info">Ms. H****</h3>
                                <span class="text-[9px] text-white/40 font-mono tracking-widest uppercase">ID: 7721-04</span>
                            </div>
                        </div>
                        <div class="rank-badge gold-badge">GOLD</div>
                    </div>
                    <div class="mb-8 relative z-10">
                        <p class="text-[9px] text-white/30 uppercase tracking-[2px] mb-3">Wealth Pulse</p>
                        <div class="h-12 w-full flex items-end gap-1 opacity-50">
                            <div class="flex-1 bg-yellow-500/50 h-[20%]"></div>
                            <div class="flex-1 bg-yellow-500/50 h-[40%]"></div>
                            <div class="flex-1 bg-yellow-500/50 h-[35%]"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/5 relative z-10">
                        <div><span class="text-[8px] text-white/30 block uppercase">Super Plates</span><span class="text-sm font-bold text-white ghost-info">04</span></div>
                        <div class="text-right"><span class="text-[8px] text-white/30 block uppercase">Bidding Limit</span><span class="text-sm font-bold text-[#F1C40F] ghost-info">$1.2M</span></div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 bg-rose-500 w-[40%]"></div>
                </div>
            </div>

        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="kyc-vault" class="min-h-screen pt-20 pb-10 px-4 md:px-8 transition-all duration-500 ml-0 md:ml-20 lg:ml-24" style="margin-left: 17%;">

        <div class="mb-8 flex justify-between items-end border-b border-cyan-500/20 pb-4">
            <div>
                <h2 class="text-[#0891B2] font-mono text-xs tracking-[4px] uppercase mb-2">// Forensic Audit Mode</h2>
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl text-white font-bold tracking-tight">Verification Vault</h1>
                    <span class="bg-rose-500/20 text-rose-500 text-[10px] px-3 py-1 rounded-full border border-rose-500/30 animate-pulse">
                        <i class="ri-error-warning-line"></i> 3 URGENT QUEUE
                    </span>
                </div>
            </div>
            <div class="flex gap-4">
                <div id="paper-mode-toggle" onclick="togglePaperMode()" class="cursor-pointer group flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-lg hover:bg-white/10 transition-all">
                    <i class="ri-eye-line text-cyan-400"></i>
                    <span class="text-[10px] text-white/60 font-bold uppercase tracking-widest">Paper Mode</span>
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
    <section id="vip-pulse" class="pt-10 pb-20 px-4 md:px-8 transition-all duration-500 ml-0 md:ml-20 lg:ml-24 bg-[#050B18]" style="margin-left: 17%;">

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

        function selectVIP(name) {
            const searchInput = document.getElementById('deep-search');
            const suggestionsBox = document.getElementById('search-suggestions');

            searchInput.value = name;
            suggestionsBox.style.display = 'none';
            console.log("Đã chọn thượng khách:", name);
        }

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