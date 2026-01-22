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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
        }

        .sapphire-dust-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.05;
            pointer-events: none;
            z-index: 1;
        }

        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap');

        .jetbrains {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Hiệu ứng hạt bụi Sapphire (Stardust) */
        .sapphire-dust {
            background-image: url('https://www.transparenttextures.com/patterns/stardust.png');
            background-repeat: repeat;
            filter: invert(0.5) sepia(1) saturate(5) hue-rotate(180deg);
        }

        /* Hiệu ứng pháo hoa hạt mịn (Celebration) */
        .celebrate-glow {
            animation: gold-pulse 2s infinite ease-in-out;
            border-color: rgba(255, 215, 0, 0.5) !important;
            box-shadow: 0 0 40px rgba(255, 215, 0, 0.2);
        }

        @keyframes gold-pulse {
            0% {
                filter: drop-shadow(0 0 5px gold);
            }

            50% {
                filter: drop-shadow(0 0 15px gold);
            }

            100% {
                filter: drop-shadow(0 0 5px gold);
            }
        }

        #command-metrics {
            background-color: #000814;
            /* Màu đen xanh sâu */
            background-image:
                radial-gradient(circle at 50% -20%, rgba(6, 182, 212, 0.1), transparent 50%);
            position: relative;
        }

        /* Mobile Swipe Optimization */
        @media (max-width: 768px) {
            #command-metrics {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #metrics-grid {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding: 20px;
                gap: 1rem;
                scrollbar-width: none;
            }

            .metric-tile {
                flex: 0 0 85vw;
                scroll-snap-align: center;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Sapphire Grid Texture */
        .sapphire-grid {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(6, 182, 212, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(6, 182, 212, 0.1) 1px, transparent 1px);
        }

        .time-filter.active {
            background: rgba(34, 211, 238, 0.1);
            color: #22d3ee;
            box-shadow: inset 0 0 10px rgba(34, 211, 238, 0.2);
        }

        /* Hiệu ứng thở (Breathe) cho vùng Area */
        @keyframes breathe {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 0.8;
            }
        }

        #wealthChart {
            filter: drop-shadow(0 0 15px rgba(6, 182, 212, 0.1));
        }

        #global-wealth-chart {
            background-color: #000814;
            background-image:
                radial-gradient(circle at 80% 50%, rgba(139, 92, 246, 0.03), transparent 40%),
                /* Ánh tím nhẹ */
                radial-gradient(circle at 20% 80%, rgba(6, 182, 212, 0.03), transparent 40%);
            /* Ánh xanh nhẹ */
        }

        /* Đảm bảo khung chứa biểu đồ co giãn đúng */
        .chart-container {
            position: relative;
            width: 100%;
        }

        /* Mobile Landscape Hint */
        @media (max-width: 640px) and (orientation: portrait) {
            #global-wealth-chart::after {
                content: "Xoay ngang để xem chi tiết biểu đồ";
                position: absolute;
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(34, 211, 238, 0.2);
                padding: 5px 15px;
                border-radius: 20px;
                color: #22d3ee;
                font-size: 10px;
                z-index: 20;
                pointer-events: none;
            }

            #wealthChart {
                margin-left: -10px;
                /* Tận dụng không gian lề */
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* Hoạt động cũ mờ dần */
        #activity-waterfall .activity-card {
            transition: opacity 0.5s ease;
        }

        #activity-waterfall .activity-card:nth-last-child(n+6) {
            opacity: 0.4;
        }

        #activity-waterfall .activity-card:nth-last-child(n+8) {
            opacity: 0.1;
        }

        /* Hiệu ứng Glitch cho thẻ cực lớn */
        .glitch-gold {
            border: 1px solid rgba(255, 215, 0, 0.5) !important;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.1);
            animation: glitch-border 0.2s infinite;
        }

        @keyframes glitch-border {
            0% {
                border-color: rgba(255, 215, 0, 0.5);
            }

            50% {
                border-color: rgba(255, 215, 0, 1);
                transform: translateX(1px);
            }

            100% {
                border-color: rgba(255, 215, 0, 0.5);
            }
        }

        /* Motion Blur khi trượt xuống */
        .motion-blur-in {
            filter: blur(5px);
            transform: translateY(-20px);
        }

        @media (max-width: 1024px) {

            /* Trên Mobile/Tablet: Thu nhỏ thẻ hoạt động */
            .activity-card {
                padding: 0.75rem !important;
            }

            .activity-card p {
                font-size: 8px !important;
            }
        }

        /* Hiệu ứng Ticker cho Mobile: Chỉ thẻ đầu tiên rực rỡ */
        @media (max-width: 640px) {
            #activity-waterfall .activity-card:not(:first-child) {
                opacity: 0.2;
                transform: scale(0.95);
            }

            #activity-waterfall .activity-card:first-child {
                border-color: rgba(6, 182, 212, 0.5);
                background: rgba(6, 182, 212, 0.05);
            }
        }

        /* ----------------------------- section 4 -----------------------------  */
        /* Data Flow Animation dọc viền thẻ */
        .tech-card::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border: 1px solid transparent;
            border-image: linear-gradient(90deg, transparent, #06b6d4, transparent) 1;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tech-card:hover::before {
            opacity: 0.5;
        }

        /* Radar Scanning */
        .radar-scanner {
            animation: radar-spin 4s linear infinite;
            transform-origin: center;
        }

        @keyframes radar-spin {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Overload Warning State */
        .overload-active {
            border-color: #f59e0b !important;
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.1);
        }

        .overload-active::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(245, 158, 11, 0.05);
            backdrop-filter: blur(2px);
            pointer-events: none;
            z-index: 5;
        }

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>

    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="command-metrics" class="relative pt-24 pb-12 px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500">
        <div class="container mx-auto max-w-[1600px]">

            <div id="quick-info-bar" class="fixed top-0 left-0 right-0 z-40 bg-black/80 backdrop-blur-xl border-b border-white/10 p-2 flex justify-around items-center opacity-0 -translate-y-full transition-all duration-500 pointer-events-none">
                <div class="text-[10px] jetbrains"><span class="text-white/40">REV:</span> <span class="text-cyan-400">1.2B</span></div>
                <div class="text-[10px] jetbrains"><span class="text-white/40">AUC:</span> <span class="text-cyan-400">42</span></div>
                <div class="text-[10px] jetbrains"><span class="text-white/40">VIP:</span> <span class="text-cyan-400">156</span></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6" id="metrics-grid">

                <div class="metric-tile group relative bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.5)] cursor-default">
                    <div class="sapphire-dust absolute inset-0 opacity-20 pointer-events-none"></div>
                    <div class="hover-glow absolute w-48 h-48 bg-cyan-500/10 rounded-full blur-[60px] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-[10px] tracking-[3px] text-white/40 uppercase jetbrains">Total Revenue</p>
                            <i class="ri-money-dollar-circle-line text-cyan-400"></i>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-3xl font-bold text-[#E2E2E2] jetbrains counter" data-target="1250000000">0</span>
                            <span class="text-[10px] text-white/30 jetbrains">VND</span>
                        </div>
                        <div class="text-[10px] jetbrains text-[#00FFC2]">↑ 15.4% <span class="text-white/20 ml-1">vs yesterday</span></div>
                    </div>
                    <canvas class="sparkline-canvas absolute bottom-0 left-0 w-full h-12 opacity-30"></canvas>
                </div>

                <div class="metric-tile group relative bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                    <div class="sapphire-dust absolute inset-0 opacity-20 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-[10px] tracking-[3px] text-white/40 uppercase jetbrains">Live Auctions</p>
                            <div class="relative flex items-center justify-center">
                                <span class="absolute w-4 h-4 bg-cyan-400/20 rounded-full animate-ping"></span>
                                <i class="ri-radar-line text-cyan-400"></i>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-3xl font-bold text-[#E2E2E2] jetbrains counter" data-target="42">0</span>
                            <span class="text-[10px] text-white/30 jetbrains">ROOMS</span>
                        </div>
                        <div class="text-[10px] jetbrains text-[#FF4D6D]">↓ 2.1% <span class="text-white/20 ml-1">system cooling</span></div>
                    </div>
                    <canvas class="sparkline-canvas absolute bottom-0 left-0 w-full h-12 opacity-30"></canvas>
                </div>

                <div class="metric-tile group relative bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                    <div class="sapphire-dust absolute inset-0 opacity-20 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-[10px] tracking-[3px] text-white/40 uppercase jetbrains">Verified VIPs</p>
                            <i class="ri-user-star-line text-cyan-400"></i>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-3xl font-bold text-[#E2E2E2] jetbrains counter" data-target="156">0</span>
                            <span class="text-[10px] text-white/30 jetbrains">ONLINE</span>
                        </div>
                        <div class="text-[10px] jetbrains text-[#00FFC2]">↑ 8 new <span class="text-white/20 ml-1">last 10m</span></div>
                    </div>
                    <canvas class="sparkline-canvas absolute bottom-0 left-0 w-full h-12 opacity-30"></canvas>
                </div>

                <div class="metric-tile group relative bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.5)]" id="load-card">
                    <div class="sapphire-dust absolute inset-0 opacity-20 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-[10px] tracking-[3px] text-white/40 uppercase jetbrains">System Load</p>
                            <i class="ri-cpu-line text-cyan-400"></i>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-3xl font-bold text-[#E2E2E2] jetbrains counter" data-target="12">0</span>
                            <span class="text-[10px] text-white/30 jetbrains">MS LATENCY</span>
                        </div>
                        <div class="text-[10px] jetbrains text-cyan-400">OPTIMIZED <span class="text-white/20 ml-1">Quantum Match</span></div>
                    </div>
                    <canvas class="sparkline-canvas absolute bottom-0 left-0 w-full h-12 opacity-30"></canvas>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="global-wealth-chart" class="relative pb-20 px-4 md:px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500">
        <div class="container mx-auto max-w-[1600px]">
            <div class="flex flex-col xl:flex-row gap-6">

                <div class="w-full xl:w-2/3 bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-3xl p-4 md:p-8 relative overflow-hidden group">
                    <div class="absolute inset-0 sapphire-grid opacity-10 pointer-events-none"></div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 relative z-10 gap-4">
                        <div>
                            <h3 class="jetbrains text-white text-base md:text-lg font-bold">FINANCIAL HORIZON</h3>
                            <p class="text-[9px] md:text-[10px] text-white/30 jetbrains tracking-[2px] md:tracking-[3px] uppercase">Real-time Market Flow</p>
                        </div>
                        <div class="flex bg-black/40 p-1 rounded-xl border border-white/5 shadow-inner w-full sm:w-auto overflow-x-auto">
                            <button class="time-filter active flex-1 sm:flex-none px-4 py-1.5 rounded-lg text-[10px] jetbrains text-white transition-all whitespace-nowrap" data-range="day">DAY</button>
                            <button class="time-filter flex-1 sm:flex-none px-4 py-1.5 rounded-lg text-[10px] jetbrains text-white/40 transition-all whitespace-nowrap" data-range="week">WEEK</button>
                            <button class="time-filter flex-1 sm:flex-none px-4 py-1.5 rounded-lg text-[10px] jetbrains text-white/40 transition-all whitespace-nowrap" data-range="month">MONTH</button>
                        </div>
                    </div>

                    <div class="relative h-[300px] md:h-[400px] w-full">
                        <canvas id="wealthChart"></canvas>
                    </div>
                </div>

                <div class="w-full xl:w-1/3 flex flex-col sm:flex-row xl:flex-col gap-6">
                    <div class="bg-gradient-to-br from-cyan-950/40 to-black/60 backdrop-blur-2xl border border-cyan-500/20 rounded-3xl p-6 md:p-8 flex-1 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-cyan-500/5 rounded-full blur-3xl"></div>

                        <h4 class="jetbrains text-cyan-400 text-[10px] md:text-xs mb-6 flex items-center gap-2">
                            <i class="ri-robot-line animate-pulse"></i> AI PREDICTION ENGINE
                        </h4>

                        <div class="space-y-6 md:space-y-8">
                            <div class="forecast-item">
                                <p class="text-[9px] md:text-[10px] text-white/40 jetbrains mb-2">EXPECTED REVENUE (EOD)</p>
                                <div class="flex justify-between items-end">
                                    <span class="text-xl md:text-2xl text-white jetbrains font-bold">120%</span>
                                    <span class="text-[#00FFC2] text-[9px] md:text-[10px] jetbrains">↑ EXCEEDING</span>
                                </div>
                                <div class="w-full bg-white/5 h-1 mt-3 rounded-full overflow-hidden">
                                    <div class="bg-cyan-500 h-full w-[85%] shadow-[0_0_10px_#06b6d4]"></div>
                                </div>
                            </div>

                            <div class="p-4 bg-cyan-500/5 border border-cyan-500/10 rounded-2xl">
                                <p class="text-[10px] md:text-[11px] leading-relaxed text-white/60 italic font-light">
                                    "Hệ thống dự báo một đợt bùng nổ giá vào lúc 21:00 đêm nay."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="live-pulse-feed" class="relative pb-20 px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500">
        <div class="container mx-auto max-w-[1600px]">

            <div class="flex lg:hidden bg-black/40 p-1 rounded-xl border border-white/5 mb-6">
                <button onclick="switchTab('stream')" id="btn-stream" class="flex-1 py-2 rounded-lg jetbrains text-[10px] text-cyan-400 bg-cyan-500/10 border border-cyan-500/20">DÒNG CHẢY</button>
                <button onclick="switchTab('rank')" id="btn-rank" class="flex-1 py-2 rounded-lg jetbrains text-[10px] text-white/40">XẾP HẠNG</button>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-[600px]">

                <div id="col-stream" class="w-full lg:w-3/5 bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-3xl p-6 relative overflow-hidden flex flex-col h-[500px] lg:h-full transition-all duration-500">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                            <h3 class="jetbrains text-white text-[10px] lg:text-sm font-bold tracking-widest uppercase">Live Activity Stream</h3>
                        </div>
                        <span class="hidden sm:block text-[10px] jetbrains text-white/20">AUTO-UPDATE: ENABLED</span>
                    </div>

                    <div id="activity-waterfall" class="flex-1 overflow-y-hidden relative space-y-3 pr-2">
                    </div>
                </div>

                <div id="col-rank" class="hidden lg:flex w-full lg:w-2/5 bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-3xl p-6 flex-col h-full transition-all duration-500">
                    <h3 class="jetbrains text-white text-sm font-bold tracking-widest uppercase mb-6 flex items-center gap-2">
                        <i class="ri-trophy-line text-amber-500"></i> Top Performers (1h)
                    </h3>

                    <div class="space-y-4 flex-1 overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between p-4 bg-white/[0.03] rounded-2xl border border-white/5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full border border-cyan-500/30 flex items-center justify-center jetbrains text-cyan-400 text-xs bg-cyan-500/5">#1</div>
                                <div>
                                    <p class="text-white text-[11px] font-bold jetbrains uppercase">Shark Nguyễn</p>
                                    <p class="text-[9px] text-white/40 jetbrains">Total Bid: 12.5B</p>
                                </div>
                            </div>
                            <i class="ri-fire-line text-orange-500"></i>
                        </div>
                    </div>
                    <button class="mt-4 w-full py-3 border border-white/5 rounded-xl jetbrains text-[10px] text-white/30 hover:bg-white/5 transition-all">FULL RANKING</button>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="system-integrity" class="relative pb-20 px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500 border-2 border-transparent transition-colors duration-500">
        <div class="container mx-auto max-w-[1600px]">

            <div class="flex items-center gap-4 mb-8">
                <h3 class="jetbrains text-[10px] tracking-[5px] text-white/40 uppercase">System Integrity & Sentinel</h3>
                <div class="h-[1px] flex-1 bg-white/10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <div class="tech-card p-6 bg-black/40 border border-white/10 rounded-2xl relative overflow-hidden group">
                    <div class="data-flow-line absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-cyan-500 to-transparent"></div>
                    <h4 class="jetbrains text-[10px] text-cyan-400 mb-6 uppercase tracking-widest">Server Vitality</h4>

                    <div class="relative flex justify-center items-center h-48">
                        <div class="absolute w-40 h-40 rounded-full border-[6px] border-cyan-500/20 border-t-cyan-500 animate-[spin_3s_linear_infinite]"></div>
                        <div class="absolute w-28 h-28 rounded-full border-[6px] border-emerald-500/20 border-t-emerald-500 animate-[spin_2s_linear_reverse_infinite]"></div>
                        <div class="absolute w-16 h-16 rounded-full border-[6px] border-blue-500/20 border-t-blue-500 animate-[spin_1s_linear_infinite]"></div>

                        <div class="text-center z-10">
                            <span class="text-white jetbrains text-xl font-bold">98.2%</span>
                            <p class="text-[8px] text-white/30 jetbrains">UPTIME</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 mt-6 gap-2 text-center">
                        <div>
                            <p class="text-[8px] text-white/30 jetbrains">CPU</p>
                            <p class="text-[10px] text-cyan-400 jetbrains">42%</p>
                        </div>
                        <div>
                            <p class="text-[8px] text-white/30 jetbrains">RAM</p>
                            <p class="text-[10px] text-emerald-400 jetbrains">5.8GB</p>
                        </div>
                        <div>
                            <p class="text-[8px] text-white/30 jetbrains">PING</p>
                            <p class="text-[10px] text-blue-400 jetbrains">12ms</p>
                        </div>
                    </div>
                </div>

                <div class="tech-card p-6 bg-black/40 border border-white/10 rounded-2xl relative overflow-hidden xl:col-span-1 md:col-span-2">
                    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                    <h4 class="jetbrains text-[10px] text-red-400 mb-6 uppercase tracking-widest">Security Threat Map</h4>

                    <div class="relative h-48 bg-cyan-950/10 rounded-xl overflow-hidden border border-white/5">
                        <div class="radar-scanner absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200%] h-[200%] bg-[conic-gradient(from_0deg,transparent_0deg,rgba(6,182,212,0.2)_90deg,transparent_91deg)] z-10"></div>

                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="ri-global-line text-8xl text-white/5"></i>
                        </div>

                        <div class="absolute top-1/4 left-1/3 w-2 h-2 bg-red-500 rounded-full animate-ping"></div>
                        <div class="absolute bottom-1/3 right-1/4 w-2 h-2 bg-red-500 rounded-full animate-ping"></div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <span class="jetbrains text-[9px] text-white/40 italic">BLOCKED: 192.168.1.104</span>
                        <button class="text-[9px] text-red-400 underline jetbrains">VIEW LOGS</button>
                    </div>
                </div>

                <div class="tech-card p-6 bg-black/40 border border-white/10 rounded-2xl relative overflow-hidden">
                    <h4 class="jetbrains text-[10px] text-amber-400 mb-6 uppercase tracking-widest">Encrypted Storage</h4>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-[9px] text-white/40 jetbrains uppercase">Database Cluster</span>
                                <span class="text-[9px] text-white/60 jetbrains">78%</span>
                            </div>
                            <div class="h-1 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-500 w-[78%] shadow-[0_0_10px_#f59e0b]"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-[9px] text-white/40 jetbrains uppercase">VIP Archives (AES-256)</span>
                                <span class="text-[9px] text-white/60 jetbrains">32%</span>
                            </div>
                            <div class="h-1 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-cyan-500 w-[32%] shadow-[0_0_10px_#06b6d4]"></div>
                            </div>
                        </div>
                    </div>

                    <button id="system-purge" class="mt-8 w-full py-3 bg-red-500/10 border border-red-500/20 text-red-500 text-[10px] jetbrains font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all">
                        SYSTEM PURGE <i class="ri-fingerprint-line ml-2"></i>
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. The Number Surge (Counter)
        gsap.utils.toArray('.counter').forEach(el => {
            const target = parseFloat(el.getAttribute('data-target'));
            gsap.to(el, {
                innerText: target,
                duration: 2.5,
                ease: "expo.out",
                snap: {
                    innerText: 1
                },
                onUpdate: function() {
                    if (target > 1000) {
                        el.innerText = Math.floor(this.targets()[0].innerText).toLocaleString('vi-VN');
                    }
                }
            });
        });

        // 2. Hover Illumination Logic
        const tiles = document.querySelectorAll('.metric-tile');
        tiles.forEach(tile => {
            const glow = tile.querySelector('.hover-glow');
            tile.addEventListener('mousemove', (e) => {
                const rect = tile.getBoundingClientRect();
                const x = e.clientX - rect.left - 96; // 96 là bán kính glow (w-48 / 2)
                const y = e.clientY - rect.top - 96;
                gsap.to(glow, {
                    x: x,
                    y: y,
                    duration: 0.5
                });
            });
        });

        // 3. Live Heartbeat (Mini Sparklines)
        const canvases = document.querySelectorAll('.sparkline-canvas');
        canvases.forEach(canvas => {
            const ctx = canvas.getContext('2d');
            let points = Array.from({
                length: 20
            }, () => Math.random() * 40 + 10);

            function drawSparkline() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.beginPath();
                ctx.strokeStyle = '#00C2FF';
                ctx.lineWidth = 2;
                ctx.lineJoin = 'round';

                const step = canvas.width / (points.length - 1);
                points.forEach((p, i) => {
                    i === 0 ? ctx.moveTo(0, p) : ctx.lineTo(i * step, p);
                });
                ctx.stroke();

                // Shift points
                points.shift();
                points.push(Math.random() * 40 + 10);
            }
            setInterval(drawSparkline, 200);
        });

        // 4. Threshold Alert Simulation (Vd: Doanh thu đạt mốc)
        setTimeout(() => {
            document.querySelector('.metric-tile').classList.add('celebrate-glow');
            if (window.navigator.vibrate) window.navigator.vibrate([100, 50, 100]);
        }, 3000);

        // 5. Quick Info Bar Logic (Sticky on scroll)
        window.addEventListener('scroll', () => {
            const bar = document.querySelector('#quick-info-bar');
            if (window.scrollY > 300) {
                gsap.to(bar, {
                    opacity: 1,
                    y: 0,
                    duration: 0.4,
                    pointerEvents: 'auto'
                });
            } else {
                gsap.to(bar, {
                    opacity: 0,
                    y: -50,
                    duration: 0.4,
                    pointerEvents: 'none'
                });
            }
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const ctx = document.getElementById('wealthChart').getContext('2d');

        // Gradient tạo màu Sapphire rực rỡ
        const gradientRevenue = ctx.createLinearGradient(0, 0, 0, 400);
        gradientRevenue.addColorStop(0, 'rgba(6, 182, 212, 0.4)');
        gradientRevenue.addColorStop(1, 'rgba(6, 182, 212, 0)');

        const chartData = {
            labels: ['09:00', '11:00', '13:00', '15:00', '17:00', '19:00', '21:00'],
            datasets: [{
                label: 'Doanh thu',
                data: [450, 620, 580, 890, 720, 1100, 950],
                borderColor: '#22d3ee',
                borderWidth: 3,
                backgroundColor: gradientRevenue,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#22d3ee',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }, {
                label: 'Lượt trả giá',
                data: [300, 400, 350, 500, 480, 700, 650],
                borderColor: '#8b5cf6',
                borderWidth: 2,
                borderDash: [5, 5],
                fill: false,
                tension: 0.4,
                pointRadius: 0
            }]
        };

        // Cập nhật cấu hình trong hàm khởi tạo wealthChart ở thẻ <script>
        const wealthChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false, // Quan trọng để chiếm hết chiều cao container
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: window.innerWidth > 768, // Chỉ hiện legend trên màn hình lớn
                        labels: {
                            color: 'rgba(255,255,255,0.5)',
                            font: {
                                family: 'JetBrains Mono',
                                size: 10
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.03)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.3)',
                            font: {
                                family: 'JetBrains Mono',
                                size: window.innerWidth < 640 ? 8 : 10
                            },
                            maxTicksLimit: 5 // Giới hạn số lượng nhãn trục Y trên mobile
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.3)',
                            font: {
                                family: 'JetBrains Mono',
                                size: window.innerWidth < 640 ? 8 : 10
                            },
                            maxRotation: 0 // Giữ nhãn nằm ngang dễ đọc
                        }
                    }
                }
            }
        });

        // Thêm sự kiện Window Resize để cập nhật biểu đồ khi Admin xoay màn hình
        window.addEventListener('resize', () => {
            const isMobile = window.innerWidth < 640;
            wealthChart.options.scales.x.ticks.font.size = isMobile ? 8 : 10;
            wealthChart.options.scales.y.ticks.font.size = isMobile ? 8 : 10;
            wealthChart.options.plugins.legend.display = window.innerWidth > 768;
            wealthChart.update();
        });

        // 1. Fluid Draw Animation với GSAP ScrollTrigger
        gsap.from(wealthChart.data.datasets[0].data, {
            duration: 2,
            value: 0,
            ease: "power4.out",
            scrollTrigger: {
                trigger: "#wealthChart",
                start: "top 80%",
            },
            onUpdate: () => wealthChart.update()
        });

        // 2. Time Range Switching (Morphing effect simulation)
        document.querySelectorAll('.time-filter').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.time-filter').forEach(b => b.classList.remove('active', 'text-white'));
                this.classList.add('active', 'text-white');

                // Randomize data to simulate switching
                wealthChart.data.datasets[0].data = wealthChart.data.datasets[0].data.map(v => v + (Math.random() - 0.5) * 200);
                wealthChart.update('active'); // Chart.js mượt mà chuyển đổi

                if (window.navigator.vibrate) window.navigator.vibrate(5);
            });
        });

        // 3. Magnetic Tooltip Vertical Line (Simulated via Chart.js options)
        // Hiệu ứng Haptic khi đạt đỉnh (Peak)
        wealthChart.options.onHover = (event, elements) => {
            if (elements.length > 0) {
                const index = elements[0].index;
                const val = wealthChart.data.datasets[0].data[index];
                const maxVal = Math.max(...wealthChart.data.datasets[0].data);

                if (val === maxVal && window.navigator.vibrate) {
                    window.navigator.vibrate(10); // Rung nhẹ khi chạm đỉnh
                }
            }
        };
    });

    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const waterfall = document.getElementById('activity-waterfall');

        const activityTypes = [{
                type: 'DEPOSIT',
                label: 'Nạp tiền thành công',
                color: '#00FFC2',
                icon: 'ri-add-circle-line'
            },
            {
                type: 'BID',
                label: 'Lệnh trả giá mới',
                color: '#00C2FF',
                icon: 'ri-auction-line'
            },
            {
                type: 'KYC',
                label: 'Yêu cầu phê duyệt KYC',
                color: '#FBBF24',
                icon: 'ri-shield-user-line'
            },
            {
                type: 'VIP',
                label: 'Thành viên VIP mới',
                color: '#8B5CF6',
                icon: 'ri-vip-crown-line'
            }
        ];

        function switchTab(tab) {
            const colStream = document.getElementById('col-stream');
            const colRank = document.getElementById('col-rank');
            const btnStream = document.getElementById('btn-stream');
            const btnRank = document.getElementById('btn-rank');

            if (tab === 'stream') {
                colStream.classList.remove('hidden');
                colRank.classList.add('hidden');

                btnStream.className = "flex-1 py-2 rounded-lg jetbrains text-[10px] text-cyan-400 bg-cyan-500/10 border border-cyan-500/20";
                btnRank.className = "flex-1 py-2 rounded-lg jetbrains text-[10px] text-white/40";
            } else {
                colStream.classList.add('hidden');
                colRank.classList.remove('hidden', 'lg:flex'); // Hiện cột rank
                colRank.classList.add('flex');

                btnRank.className = "flex-1 py-2 rounded-lg jetbrains text-[10px] text-cyan-400 bg-cyan-500/10 border border-cyan-500/20";
                btnStream.className = "flex-1 py-2 rounded-lg jetbrains text-[10px] text-white/40";
            }

            // Rung phản hồi khi đổi tab
            if (window.navigator.vibrate) window.navigator.vibrate(10);
        }

        // Logic Double Tap trên Mobile để mở chi tiết (Thêm vào trong loop render card)
        // card.addEventListener('dblclick', () => { alert('Mở chi tiết đối tượng...'); });

        function createActivity(data) {
            const card = document.createElement('div');
            const isBigBoss = data.amount > 5000000000; // Trên 5 tỷ

            card.className = `activity-card relative flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-xl ${isBigBoss ? 'glitch-gold' : ''}`;
            card.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: ${data.color}20; color: ${data.color}">
                    <i class="${data.icon}"></i>
                </div>
                <div>
                    <p class="text-white text-[10px] jetbrains font-bold uppercase">${data.label}</p>
                    <p class="text-[9px] text-white/40 jetbrains">${data.user} • ${data.time}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="jetbrains text-[10px] font-bold" style="color: ${data.color}">${data.value}</p>
            </div>
        `;

            // Thêm vào đầu danh sách
            waterfall.prepend(card);

            // Hiệu ứng Fluid Influx
            gsap.from(card, {
                y: -50,
                opacity: 0,
                filter: "blur(10px)",
                duration: 0.6,
                ease: "power3.out"
            });

            // Giới hạn số lượng thẻ để tránh lag
            if (waterfall.children.length > 10) {
                waterfall.lastElementChild.remove();
            }

            // Rung Haptic nếu là giao dịch lớn
            if (isBigBoss && window.navigator.vibrate) {
                window.navigator.vibrate([200, 100, 200]);
            }
        }

        // Mô phỏng dòng chảy dữ liệu thực tế
        setInterval(() => {
            const randomType = activityTypes[Math.floor(Math.random() * activityTypes.length)];
            const mockData = {
                ...randomType,
                user: "User_" + Math.floor(Math.random() * 9999),
                time: "Vừa xong",
                value: (Math.random() * 1000).toFixed(1) + "M VND",
                amount: Math.random() * 6000000000 // Random số tiền để test Glitch
            };
            createActivity(mockData);
        }, 4000); // Mỗi 4 giây có 1 hoạt động mới
    });

    // ----------------------------- section 4 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Mô phỏng hiệu ứng Overload (Cảnh báo khi tải cao)
        function simulateOverload(isActive) {
            const section = document.getElementById('system-integrity');
            if (isActive) {
                section.classList.add('overload-active');
                gsap.to(section, {
                    borderColor: "#f59e0b",
                    duration: 0.5
                });
            } else {
                section.classList.remove('overload-active');
                gsap.to(section, {
                    borderColor: "transparent",
                    duration: 0.5
                });
            }
        }

        // 2. System Purge Logic (FaceID/Fingerprint Confirmation)
        const purgeBtn = document.getElementById('system-purge');
        purgeBtn.addEventListener('click', function() {
            if (confirm("Confirm System Purge via Biometrics?")) {
                gsap.to(this, {
                    scale: 0.95,
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1
                });
                this.innerText = "PURGING CACHE...";
                this.style.color = "#fff";
                this.style.backgroundColor = "#ef4444";

                setTimeout(() => {
                    this.innerText = "SYSTEM PURGE SUCCESS";
                    this.style.backgroundColor = "#10b981";
                    if (window.navigator.vibrate) window.navigator.vibrate([100, 50, 100]);
                }, 2000);
            }
        });

        // 3. GSAP Data Flow Lines Animation
        gsap.from(".data-flow-line", {
            x: "-100%",
            duration: 3,
            repeat: -1,
            ease: "none"
        });

        // 4. Random Threat Pulse
        setInterval(() => {
            const pulses = document.querySelectorAll('.animate-ping');
            pulses.forEach(p => {
                p.style.top = Math.random() * 80 + "%";
                p.style.left = Math.random() * 80 + "%";
            });
        }, 5000);
    });

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>