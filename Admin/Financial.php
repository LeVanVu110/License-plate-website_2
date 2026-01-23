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

        /* ----------------------------- section 1 -----------------------------  */
        /* Typography & Core Styles */
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono&display=swap');

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .widget-glass {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .widget-glass:hover {
            transform: translateY(-8px) scale(1.02);
        }

        /* Pulse Glow Animation */
        @keyframes pulse-emerald {
            0% {
                transform: scale(0.9);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .active-pulse .pulse-glow {
            animation: pulse-emerald 0.8s ease-out;
            opacity: 1 !important;
        }

        /* Mặc định cho Main Content dựa trên Sidebar */
        #main-content {
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }

        /* Khi Sidebar thu gọn (Sử dụng class của Sidebar.php nếu có) */
        #obsidian-sidebar.collapsed+#main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        /* Tablet & Desktop nhỏ */
        @media (max-width: 1280px) {
            #widgets-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                /* Bố cục 2x2 */
                overflow: visible;
            }

            /* Ẩn sparkline trên tablet để gọn gàng, dùng trend arrows (giả lập bằng css) */
            .tablet-hide {
                display: none;
            }
        }

        /* Mobile (The Pocket CFO) */
        @media (max-width: 768px) {
            #main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0;
            }

            #fiscal-pulse {
                padding: 1.5rem 1rem;
            }

            /* Hiệu ứng Trượt ngang cho Widget trên Mobile */
            #widgets-container {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                gap: 1rem;
                padding-bottom: 2rem;
                -webkit-overflow-scrolling: touch;
            }

            .widget-glass {
                min-width: 85vw;
                /* Thẻ chiếm gần hết chiều ngang */
                scroll-snap-align: center;
            }

            /* Thu nhỏ font chữ tiêu đề trên mobile */
            .count-up {
                font-size: 1.5rem !important;
            }
        }

        /* Smart Abbreviation Tooltip (CSS thuần) */
        .widget-glass:active::after {
            content: attr(data-full-value);
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 8px;
            color: white;
            backdrop-filter: blur(10px);
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Zebra Striping mờ */
        .transaction-row:nth-child(even) .grid {
            background-color: rgba(255, 255, 255, 0.01);
        }

        /* Custom Scrollbar cho Grid */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Crimson Blink cho Flagged */
        .status-flagged {
            color: #F43F5E;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Hiệu ứng báo động cho giao dịch nghi vấn */
        .transaction-row[data-type="flagged"] {
            background: linear-gradient(90deg, rgba(244, 63, 94, 0.05) 0%, transparent 100%);
        }

        .status-flagged {
            animation: blink-red 1s infinite;
        }

        @keyframes blink-red {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 0px rgba(244, 63, 94, 0);
            }

            50% {
                opacity: 0.7;
                box-shadow: 0 0 10px rgba(244, 63, 94, 0.2);
            }
        }

        /* Mobile Responsive Hybrid List */
        @media (max-width: 767px) {
            .transaction-row .grid {
                grid-template-columns: 1fr auto !important;
                padding: 1.5rem !important;
            }

            .transaction-row .grid>div:not(:first-child):not(:nth-child(4)) {
                display: none;
            }

            .transaction-row .grid .text-right {
                text-align: right;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>
    <main class="transition-all duration-300 ml-[250px]" id="main-content">
        <!-- ----------------------------- section 1 -----------------------------  -->
        <section id="fiscal-pulse" class="py-8 px-4 md:px-10 bg-[#050505] font-['Inter']">

            <div class="flex justify-between items-center mb-6 px-2">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <p class="text-[10px] text-white/40 uppercase tracking-[2px] font-mono">System Time: UTC+7 (Live Syncing...)</p>
                </div>
                <div class="hidden md:block">
                    <p class="text-[10px] text-white/20 uppercase font-mono">Pre-calculated Cache: 5s Interval</p>
                </div>
            </div>

            <div id="widgets-container" class="flex overflow-x-auto md:grid md:grid-cols-2 lg:grid-cols-4 gap-4 pb-6 scrollbar-hide">

                <div class="widget-glass group min-w-[280px] p-6 rounded-[2rem] border border-white/10 bg-white/[0.03] backdrop-blur-xl relative overflow-hidden transition-all duration-500 hover:bg-white/[0.06]">
                    <div class="relative z-10">
                        <p class="text-[10px] text-white/40 uppercase tracking-widest mb-4 font-bold">Total Liquidity</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-light text-emerald-500">₫</span>
                            <h2 class="text-3xl font-['Space_Mono'] text-white count-up" data-value="1250800000">0</h2>
                        </div>
                        <div class="mt-4 h-[40px] opacity-50 group-hover:opacity-100 transition-opacity">
                            <canvas id="sparkline-liquidity"></canvas>
                        </div>
                    </div>
                    <div class="pulse-glow absolute inset-0 bg-emerald-500/5 opacity-0"></div>
                </div>

                <div class="widget-glass group min-w-[280px] p-6 rounded-[2rem] border border-white/10 bg-white/[0.03] backdrop-blur-xl relative overflow-hidden transition-all duration-500 hover:bg-white/[0.06]">
                    <div class="relative z-10">
                        <p class="text-[10px] text-white/40 uppercase tracking-widest mb-4 font-bold">Escrow Trust</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-light text-amber-500">₫</span>
                            <h2 class="text-3xl font-['Space_Mono'] text-white count-up" data-value="450200000">0</h2>
                        </div>
                        <p class="text-[10px] text-amber-500 mt-2 font-mono">+12.5% vs yesterday</p>
                    </div>
                    <div class="pulse-glow absolute inset-0 bg-amber-500/5 opacity-0"></div>
                </div>

                <div class="widget-glass group min-w-[280px] p-6 rounded-[2rem] border border-white/10 bg-white/[0.03] backdrop-blur-xl relative overflow-hidden transition-all duration-500 hover:bg-white/[0.06]">
                    <div class="relative z-10">
                        <p class="text-[10px] text-white/40 uppercase tracking-widest mb-4 font-bold">Platform Revenue</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-light text-emerald-400">₫</span>
                            <h2 class="text-3xl font-['Space_Mono'] text-white count-up" data-value="85400000">0</h2>
                        </div>
                        <div class="mt-4 h-[40px] opacity-50 group-hover:opacity-100 transition-opacity">
                            <canvas id="sparkline-revenue"></canvas>
                        </div>
                    </div>
                    <div class="pulse-glow absolute inset-0 bg-emerald-400/10 opacity-0"></div>
                </div>

                <div class="widget-glass group min-w-[280px] p-6 rounded-[2rem] border border-white/10 bg-white/[0.03] backdrop-blur-xl relative overflow-hidden transition-all duration-500 hover:bg-white/[0.06]">
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <p class="text-[10px] text-white/40 uppercase tracking-widest mb-4 font-bold">Pending Payouts</p>
                                <span class="px-2 py-0.5 bg-rose-500/20 text-rose-500 text-[8px] font-bold rounded uppercase">Priority</span>
                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-light text-rose-500">₫</span>
                                <h2 class="text-3xl font-['Space_Mono'] text-white count-up" data-value="120500000">0</h2>
                            </div>
                        </div>
                        <p class="text-[9px] text-white/20 mt-4 italic italic">14 payouts awaiting approval</p>
                    </div>
                    <div class="pulse-glow absolute inset-0 bg-rose-500/5 opacity-0"></div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-4 pt-6 border-t border-white/5 gap-4">
                <div class="flex bg-white/5 p-1 rounded-xl border border-white/10">
                    <button class="px-4 py-1.5 rounded-lg text-[10px] font-bold text-white bg-white/10 transition-all">TODAY</button>
                    <button class="px-4 py-1.5 rounded-lg text-[10px] font-bold text-white/40 hover:text-white transition-all">WEEK</button>
                    <button class="px-4 py-1.5 rounded-lg text-[10px] font-bold text-white/40 hover:text-white transition-all">MONTH</button>
                    <button class="px-4 py-1.5 rounded-lg text-[10px] font-bold text-white/40 hover:text-white transition-all">QUARTER</button>
                </div>

                <button class="flex items-center gap-2 px-6 py-2 bg-gradient-to-b from-[#E2E8F0] to-[#94A3B8] text-[#0f172a] rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-transform shadow-lg shadow-white/5">
                    <i class="ri-file-download-line text-sm"></i>
                    Export Report
                </button>
            </div>
        </section>

        <!-- ----------------------------- section 2 -----------------------------  -->
        <section id="transaction-ledger" class="py-6 px-4 md:px-10 mb-20">
            <div class="flex flex-col lg:flex-row justify-between items-center lg:items-center mb-8 gap-6">
                <div>
                    <h3 class="text-xl font-light text-white tracking-tight flex items-center gap-3">
                        <i class="ri-exchange-funds-line text-emerald-500"></i>
                        Financial Nerve System
                    </h3>
                    <p class="text-[10px] text-white/30 uppercase tracking-[3px] mt-2">Real-time Transaction Stream</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button onclick="filterGrid('whale')" class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-bold text-emerald-500 hover:bg-emerald-500/20 transition-all">WHALE (>1B)</button>
                    <button onclick="filterGrid('refund')" class="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[10px] font-bold text-white/40 hover:text-white transition-all">REFUNDS</button>
                    <button onclick="filterGrid('flagged')" class="px-4 py-1.5 rounded-full bg-rose-500/10 border border-rose-500/20 text-[10px] font-bold text-rose-500 hover:bg-rose-500/20 transition-all">FLAGGED</button>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-[2rem] border border-white/5 bg-white/[0.02] backdrop-blur-3xl">
                <div class="hidden md:grid grid-cols-7 gap-4 p-6 border-b border-white/10 bg-white/[0.05] text-[10px] font-black text-white/40 uppercase tracking-widest">
                    <div class="col-span-2">Entity & Hash</div>
                    <div>Asset</div>
                    <div class="text-center">Flow Type</div>
                    <div class="text-right">Quantum & Method</div>
                    <div class="text-center">Status</div>
                    <div class="text-right">Audit</div>
                </div>

                <div id="transaction-rows" class="max-h-[600px] overflow-y-auto custom-scrollbar">

                    <div class="transaction-row group" data-type="whale">
                        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 p-4 md:p-6 border-b border-white/5 items-center hover:bg-white/[0.04] transition-all cursor-pointer" onclick="revealReceipt(this)">

                            <div class="md:col-span-2 flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-500 to-cyan-500 p-0.5">
                                        <img src="https://i.pravatar.cc/100?u=vip1" class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-black rounded-full flex items-center justify-center border border-white/20">
                                        <span class="text-[8px] text-emerald-400">D</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white group-hover:text-emerald-400 transition-colors">Hoàng Nguyễn</h4>
                                    <p class="text-[9px] font-mono text-white/30 mt-1">0x71C...8e42 <i class="ri-file-copy-line ml-1 opacity-0 group-hover:opacity-100"></i></p>
                                </div>
                            </div>

                            <div class="hidden md:block">
                                <div class="px-2 py-1 bg-white/5 border border-white/10 rounded-md inline-block">
                                    <span class="text-[9px] font-black text-white tracking-tighter">30G-888.88</span>
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <div class="flex flex-col items-center gap-1">
                                    <i class="ri-download-cloud-2-line text-emerald-400 text-lg"></i>
                                    <span class="text-[8px] text-emerald-400/50 uppercase font-bold">Deposit</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-['Space_Mono'] font-bold text-white">2,500,000,000 ₫</p>
                                <p class="text-[9px] text-white/20 mt-1">Bank Transfer</p>
                            </div>

                            <div class="flex justify-center relative group/status">
                                <div class="status-badge px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[9px] font-black uppercase flex items-center gap-1.5">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Finalized
                                </div>
                                <button class="absolute inset-0 bg-emerald-500 text-black font-black text-[9px] rounded-full opacity-0 group-hover/status:opacity-100 transition-all scale-75 group-hover/status:scale-100">VERIFY</button>
                            </div>

                            <div class="text-right flex flex-col items-end">
                                <i class="ri-shield-check-line text-white/20 text-lg"></i>
                                <span class="text-[8px] text-white/10 font-mono">ID: #SYS-992</span>
                            </div>
                        </div>

                        <div class="receipt-detail hidden overflow-hidden bg-black/40 border-b border-white/5">
                            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="border-l border-white/10 pl-6">
                                    <p class="text-[10px] text-white/30 uppercase mb-4">Breakdown</p>
                                    <ul class="space-y-3">
                                        <li class="flex justify-between text-xs">
                                            <span class="text-white/40">Base Amount</span>
                                            <span class="text-white font-mono">2.350B</span>
                                        </li>
                                        <li class="flex justify-between text-xs">
                                            <span class="text-white/40">Platform Fee (5%)</span>
                                            <span class="text-emerald-500 font-mono">+125M</span>
                                        </li>
                                        <li class="flex justify-between text-xs border-t border-white/5 pt-2">
                                            <span class="text-white/60">Total Recieved</span>
                                            <span class="text-white font-bold font-mono">2.500B</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="md:col-span-2 bg-white/[0.02] rounded-xl p-4 relative border border-white/5">
                                    <p class="text-[10px] text-white/30 uppercase mb-4">Blockchain Verification</p>
                                    <div class="text-[10px] font-mono text-emerald-400/70 break-all leading-relaxed">
                                        sig:0x8921312389123891238912381239123123123...<br>
                                        block: #19,203,112 | timestamp: 2024-05-20 14:22:01
                                    </div>
                                    <div class="mt-4 flex gap-4">
                                        <button class="text-[9px] px-3 py-1 bg-white/10 rounded hover:bg-white/20 transition-all text-white">VIEW BLOCK EXPLORER</button>
                                        <button class="text-[9px] px-3 py-1 bg-rose-500/10 text-rose-500 rounded">REPORT DISCREPANCY</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="transaction-row group" data-type="refund">
                        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 p-4 md:p-6 border-b border-white/5 items-center hover:bg-white/[0.04] transition-all cursor-pointer" onclick="revealReceipt(this)">
                            <div class="md:col-span-2 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">
                                    <i class="ri-user-shared-line text-white/40"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white/80 group-hover:text-amber-400 transition-colors">Trần Minh Tâm</h4>
                                    <p class="text-[9px] font-mono text-white/20 mt-1">0x3A2...f910</p>
                                </div>
                            </div>

                            <div class="hidden md:block">
                                <div class="px-2 py-1 bg-white/5 border border-white/10 rounded-md inline-block">
                                    <span class="text-[9px] font-black text-white/60 tracking-tighter">51K-999.99</span>
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <div class="flex flex-col items-center gap-1">
                                    <i class="ri-upload-cloud-2-line text-amber-400 text-lg"></i>
                                    <span class="text-[8px] text-amber-400/50 uppercase font-bold">Refund</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-['Space_Mono'] font-bold text-white/90">50,000,000 ₫</p>
                                <p class="text-[9px] text-white/20 mt-1">Sapphire Credit</p>
                            </div>

                            <div class="flex justify-center">
                                <div class="px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-[9px] font-black uppercase">
                                    Pending
                                </div>
                            </div>

                            <div class="text-right">
                                <i class="ri-time-line text-white/20 text-lg"></i>
                            </div>
                        </div>
                        <div class="receipt-detail hidden overflow-hidden bg-black/40 border-b border-white/5">
                            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                                <div class="absolute right-10 bottom-0 text-[100px] font-black text-white/[0.02] pointer-events-none select-none">REFUND</div>

                                <div class="border-l border-amber-500/20 pl-6">
                                    <p class="text-[10px] text-amber-500/50 uppercase mb-4 tracking-widest font-bold">Reversal Breakdown</p>
                                    <ul class="space-y-3">
                                        <li class="flex justify-between text-xs">
                                            <span class="text-white/40">Original Deposit</span>
                                            <span class="text-white font-mono">50,000,000 ₫</span>
                                        </li>
                                        <li class="flex justify-between text-xs">
                                            <span class="text-white/40">Processing Fee</span>
                                            <span class="text-rose-500 font-mono">- 0 ₫</span>
                                        </li>
                                        <li class="flex justify-between text-xs border-t border-white/5 pt-2">
                                            <span class="text-white/60 font-bold">Amount to Return</span>
                                            <span class="text-amber-400 font-bold font-mono">50,000,000 ₫</span>
                                        </li>
                                    </ul>
                                    <div class="mt-6 p-3 bg-amber-500/5 border border-amber-500/10 rounded-lg">
                                        <p class="text-[9px] text-amber-500/80 leading-relaxed italic">
                                            * Khoản tiền cọc này được hoàn trả do người dùng không thắng trong phiên đấu giá biển số 51K-999.99.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-4">
                                    <p class="text-[10px] text-white/30 uppercase tracking-widest font-bold">Internal Audit Log</p>
                                    <div class="space-y-4">
                                        <div class="flex gap-3 items-start">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-1"></div>
                                            <div>
                                                <p class="text-[10px] text-white/70">Auction Ended</p>
                                                <p class="text-[8px] text-white/30 font-mono">2024-05-20 15:00:00</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 items-start">
                                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-1"></div>
                                            <div>
                                                <p class="text-[10px] text-white/70">Refund Initiated</p>
                                                <p class="text-[8px] text-white/30 font-mono">2024-05-20 15:05:12</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 items-start opacity-30">
                                            <div class="w-1.5 h-1.5 rounded-full bg-white/20 mt-1"></div>
                                            <div>
                                                <p class="text-[10px] text-white/70">Bank Confirmation</p>
                                                <p class="text-[8px] text-white/30 font-mono">Awaiting...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white/[0.02] rounded-2xl p-6 border border-white/5 flex flex-col justify-between">
                                    <div>
                                        <p class="text-[10px] text-white/30 uppercase mb-4 tracking-widest">Execution Path</p>
                                        <div class="flex items-center gap-2 mb-6">
                                            <i class="ri-bank-card-line text-xl text-white/60"></i>
                                            <div>
                                                <p class="text-[11px] text-white font-bold uppercase">Sapphire Credit</p>
                                                <p class="text-[9px] text-white/20 font-mono">Internal Wallet Reversal</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <button class="py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-500 text-[9px] font-black rounded-lg transition-all uppercase tracking-tighter">
                                            Approve Refund
                                        </button>
                                        <button class="py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white/60 text-[9px] font-black rounded-lg transition-all uppercase tracking-tighter">
                                            Hold Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="transaction-row group" data-type="flagged">
                        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 p-4 md:p-6 border-b border-white/5 items-center hover:bg-white/[0.04] transition-all cursor-pointer" onclick="revealReceipt(this)">
                            <div class="md:col-span-2 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-rose-500/20 border border-rose-500/30 flex items-center justify-center">
                                    <i class="ri-error-warning-line text-rose-500"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-rose-500">Unknown Entity</h4>
                                    <p class="text-[9px] font-mono text-rose-500/40 mt-1">0xUnknown...Hash</p>
                                </div>
                            </div>

                            <div class="hidden md:block opacity-20">
                                <span class="text-[9px] font-black text-white">—</span>
                            </div>

                            <div class="flex justify-center">
                                <div class="flex flex-col items-center gap-1">
                                    <i class="ri-spam-3-line text-rose-500 text-lg animate-pulse"></i>
                                    <span class="text-[8px] text-rose-500/50 uppercase font-bold">Inquiry</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-['Space_Mono'] font-bold text-rose-500">10,000,000 ₫</p>
                                <p class="text-[9px] text-rose-500/20 mt-1">Direct Link</p>
                            </div>

                            <div class="flex justify-center">
                                <div class="status-flagged px-3 py-1 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-500 text-[9px] font-black uppercase">
                                    Suspicious
                                </div>
                            </div>

                            <div class="text-right">
                                <button class="px-3 py-1 bg-rose-500 text-white text-[8px] font-bold rounded">BLOCK</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ----------------------------- section 3 -----------------------------  -->
        <section id="revenue-intelligence" class="py-10 px-4 md:px-10 mb-20">
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h3 class="text-2xl font-light text-white tracking-tight flex items-center gap-3">
                        <i class="ri-line-chart-line text-blue-500"></i>
                        Intelligence Matrix
                    </h3>
                    <p class="text-[10px] text-white/30 uppercase tracking-[4px] mt-2">Strategic Profit & Velocity Analytics</p>
                </div>

                <div class="flex bg-white/5 p-1 rounded-xl border border-white/10 backdrop-blur-md">
                    <button onclick="updateMainChart('24h')" class="px-4 py-1.5 rounded-lg text-[9px] font-black text-white/40 hover:text-white transition-all uppercase">24h</button>
                    <button onclick="updateMainChart('7d')" class="px-4 py-1.5 rounded-lg text-[9px] font-black text-white bg-white/10 shadow-xl uppercase">7 Days</button>
                    <button onclick="updateMainChart('30d')" class="px-4 py-1.5 rounded-lg text-[9px] font-black text-white/40 hover:text-white transition-all uppercase">30 Days</button>
                    <button onclick="updateMainChart('year')" class="px-4 py-1.5 rounded-lg text-[9px] font-black text-white/40 hover:text-white transition-all uppercase">Year</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                <div class="lg:col-span-2 xl:col-span-3 bg-white/[0.02] border border-white/5 rounded-[2.5rem] p-8 relative overflow-hidden group">
                    <div class="flex justify-between items-start mb-10 relative z-10">
                        <div>
                            <p class="text-[10px] text-white/40 uppercase font-bold tracking-widest">Net Revenue Growth</p>
                            <h4 class="text-3xl font-['Space_Mono'] text-white mt-1">128.450B <span class="text-xs text-emerald-400 font-sans">+12.5%</span></h4>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" checked class="hidden" onchange="toggleVerifiedOnly(this)">
                                <span class="w-8 h-4 bg-emerald-500/20 border border-emerald-500/50 rounded-full relative transition-all">
                                    <span class="absolute left-1 top-1 w-2 h-2 bg-emerald-500 rounded-full dot-toggle"></span>
                                </span>
                                <span class="text-[9px] text-white/60 font-bold uppercase">Verified Only</span>
                            </label>
                        </div>
                    </div>

                    <div class="h-[350px] w-full relative">
                        <canvas id="mainRevenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/5 rounded-[2.5rem] p-8 flex flex-col items-center">
                    <p class="text-[10px] text-white/40 uppercase font-bold tracking-widest mb-8 self-start">Revenue Source Split</p>
                    <div class="relative w-full aspect-square max-w-[220px]">
                        <canvas id="revenueSplitChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-[10px] text-white/20 uppercase">Total</span>
                            <span class="text-xl font-['Space_Mono'] text-white">100%</span>
                        </div>
                    </div>
                    <div class="mt-8 w-full space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-white/40 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Auction Fee</span>
                            <span class="text-xs text-white font-mono">60%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-white/40 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Escrow</span>
                            <span class="text-xs text-white font-mono">30%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-white/40 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-purple-500"></span> VIP Services</span>
                            <span class="text-xs text-white font-mono">10%</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/5 rounded-[2.5rem] p-8">
                    <p class="text-[10px] text-white/40 uppercase font-bold tracking-widest mb-6">Top Profit Sectors</p>
                    <div class="space-y-6">
                        <div class="group cursor-pointer">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs text-white/80 font-bold">Biển Ngũ Quý</span>
                                <span class="text-xs text-emerald-400 font-mono">45.2B</span>
                            </div>
                            <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-emerald-500 w-[85%] group-hover:w-[90%] transition-all duration-1000"></div>
                            </div>
                        </div>
                        <div class="group cursor-pointer">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs text-white/80 font-bold">Biển Sảnh Tiến</span>
                                <span class="text-xs text-emerald-400 font-mono">22.8B</span>
                            </div>
                            <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-emerald-500 w-[60%] group-hover:w-[65%] transition-all duration-1000"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-white/5 space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[9px] text-white/30 uppercase tracking-tighter">Burn Rate Index</span>
                                <span class="text-[10px] text-rose-400 font-mono">0.12x</span>
                            </div>
                            <p class="text-[8px] text-white/10 uppercase">Efficiency: High</p>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[9px] text-white/30 uppercase tracking-tighter">EBITDA Margin</span>
                                <span class="text-[10px] text-emerald-400 font-mono">24.5%</span>
                            </div>
                            <p class="text-[8px] text-white/10 uppercase">Benchmark: Outperform</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* CSS for Toggle Switch */
            input:checked+span .dot-toggle {
                transform: translateX(16px);
                background-color: #10B981;
            }

            input:checked+span {
                background-color: rgba(16, 185, 129, 0.3);
            }
        </style>

        <!-- ----------------------------- section 4 -----------------------------  -->

        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->
    </main>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. GSAP: The Currency Roll Effect
        gsap.utils.toArray('.count-up').forEach(el => {
            const targetValue = parseFloat(el.getAttribute('data-value'));

            gsap.to(el, {
                innerText: targetValue,
                duration: 2.5,
                ease: "power4.out",
                snap: {
                    innerText: 1
                },
                onUpdate: function() {
                    // Định dạng tiền tệ trong khi chạy: 1.000.000
                    el.innerText = Math.floor(this.targets()[0].innerText).toLocaleString('vi-VN');
                }
            });
        });

        // 2. Sparklines (Biểu đồ mini)
        const createSparkline = (id, color) => {
            const ctx = document.getElementById(id).getContext('2d');
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array(10).fill(''),
                    datasets: [{
                        data: Array.from({
                            length: 10
                        }, () => Math.floor(Math.random() * 50)),
                        borderColor: color,
                        borderWidth: 1.5,
                        pointRadius: 0,
                        fill: true,
                        backgroundColor: color.replace('1)', '0.1)'),
                        tension: 0.4
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
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });
        };

        createSparkline('sparkline-liquidity', 'rgba(16, 185, 129, 1)');
        createSparkline('sparkline-revenue', 'rgba(52, 211, 153, 1)');

        // 3. Live Pulse Glow Effect (Giả lập giao dịch mới mỗi 8 giây)
        setInterval(() => {
            const widgets = document.querySelectorAll('.widget-glass');
            const randomWidget = widgets[Math.floor(Math.random() * widgets.length)];

            randomWidget.classList.add('active-pulse');
            if (window.navigator.vibrate) window.navigator.vibrate(10); // Haptic light

            setTimeout(() => {
                randomWidget.classList.remove('active-pulse');
            }, 800);
        }, 8000);
    });
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('obsidian-toggle'); // ID từ Sidebar.php
        const sidebar = document.getElementById('obsidian-sidebar');
        const mainContent = document.getElementById('main-content');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                // Chờ sidebar thực hiện animation xong
                setTimeout(() => {
                    if (sidebar.classList.contains('collapsed')) {
                        mainContent.style.marginLeft = "80px";
                        mainContent.style.width = "calc(100% - 80px)";
                    } else {
                        mainContent.style.marginLeft = "250px";
                        mainContent.style.width = "calc(100% - 250px)";
                    }
                    // Update lại Chart.js nếu cần để không bị méo biểu đồ
                    window.dispatchEvent(new Event('resize'));
                }, 300);
            });
        }

        // Xử lý Haptic Heartbeat trên Mobile khi đạt Milestone (Ví dụ: Doanh thu > 80tr)
        const revenueValue = 85400000;
        if (revenueValue > 80000000 && window.navigator.vibrate) {
            // Rung nhẹ kiểu nhịp tim: rung 50ms, nghỉ 100ms, rung 50ms
            window.navigator.vibrate([50, 100, 50]);
        }
    });

    // ----------------------------- section 2 ----------------------------- //
    // 1. GSAP: The Ledger Pulse - Hiệu ứng nảy khi có dòng mới
    function addNewTransaction(data) {
        const container = document.getElementById('transaction-rows');
        const newRow = document.createElement('div');
        newRow.className = 'transaction-row group';
        // (Build HTML string cho row dựa trên data...)

        container.prepend(newRow);

        // Hiệu ứng Overshoot nảy nhẹ
        gsap.from(newRow, {
            y: -50,
            opacity: 0,
            duration: 0.8,
            ease: "back.out(1.7)",
            backgroundColor: "rgba(16, 185, 129, 0.2)", // Phát sáng xanh bạc
            onComplete: () => {
                gsap.to(newRow, {
                    backgroundColor: "transparent",
                    duration: 2
                });
            }
        });

        // Haptic cho Whale
        if (data.isWhale && window.navigator.vibrate) {
            window.navigator.vibrate([100, 50, 100]);
        }
    }

    // 2. The Detail Reveal: Row Expansion
    function revealReceipt(element) {
        const detail = element.parentElement.querySelector('.receipt-detail');
        const isHidden = detail.classList.contains('hidden');

        // Đóng các receipt khác đang mở
        document.querySelectorAll('.receipt-detail').forEach(el => {
            if (el !== detail) gsap.to(el, {
                height: 0,
                duration: 0.3,
                onComplete: () => el.classList.add('hidden')
            });
        });

        if (isHidden) {
            detail.classList.remove('hidden');
            gsap.fromTo(detail, {
                height: 0
            }, {
                height: "auto",
                duration: 0.5,
                ease: "power2.out"
            });
        } else {
            gsap.to(detail, {
                height: 0,
                duration: 0.3,
                onComplete: () => detail.classList.add('hidden')
            });
        }
    }

    // 3. Live Filter Logic
    function filterGrid(type) {
        const rows = document.querySelectorAll('.transaction-row');
        rows.forEach(row => {
            gsap.to(row, {
                scale: 0.95,
                opacity: 0,
                duration: 0.2,
                onComplete: () => {
                    if (type === 'all' || row.getAttribute('data-type') === type) {
                        row.style.display = 'block';
                        gsap.to(row, {
                            scale: 1,
                            opacity: 1,
                            duration: 0.3
                        });
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    }

    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Khởi tạo Main Revenue Chart
        const mainCtx = document.getElementById('mainRevenueChart').getContext('2d');
        const revenueGradient = mainCtx.createLinearGradient(0, 0, 0, 400);
        revenueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        revenueGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        const mainRevenueChart = new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Verified Revenue',
                    data: [65, 59, 80, 81, 56, 95, 128],
                    borderColor: '#3b82f6',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: revenueGradient,
                    pointBackgroundColor: '#3b82f6',
                    pointHoverRadius: 8,
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 10,
                            family: 'Inter'
                        },
                        bodyFont: {
                            size: 12,
                            family: 'Space Mono'
                        },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Revenue: ${context.raw}B VNĐ`;
                            }
                        }
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
                                size: 10
                            }
                        }
                    }
                }
            }
        });

        // 2. Khởi tạo Revenue Split Chart (Donut)
        const splitCtx = document.getElementById('revenueSplitChart').getContext('2d');
        const revenueSplitChart = new Chart(splitCtx, {
            type: 'doughnut',
            data: {
                labels: ['Auction', 'Escrow', 'VIP'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#3b82f6', '#10b981', '#a855f7'],
                    borderWidth: 0,
                    hoverOffset: 20 // Hiệu ứng Segment Isolation
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 3. GSAP Animation: Data Draw
        gsap.from("#revenue-intelligence .bg-white\/\\[0\.02\\]", {
            scrollTrigger: {
                trigger: "#revenue-intelligence",
                start: "top 80%"
            },
            y: 50,
            opacity: 0,
            duration: 1,
            stagger: 0.2,
            ease: "power4.out"
        });

        // Anomaly Detection: Giả lập tô đỏ vùng sụt giảm (Tháng 5 sụt giảm > 20%)
        // Bạn có thể xử lý logic này dựa trên dữ liệu thật
    });

    // Hàm Toggle Verified Revenue
    function toggleVerifiedOnly(cb) {
        // Logic ẩn/hiện đường dữ liệu ảo
        console.log("Verified Only Mode:", cb.checked);
        // Reload hoặc update chart tại đây
    }
    // Giả lập kho dữ liệu cho các mốc thời gian
    const chartDataStore = {
        '24h': {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'],
            values: [12, 18, 45, 30, 85, 92, 110],
            total: "8.250B"
        },
        '7d': {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            values: [65, 59, 80, 81, 56, 95, 128],
            total: "128.450B"
        },
        '30d': {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            values: [450, 620, 580, 890],
            total: "2.540T"
        },
        'year': {
            labels: ['Jan', 'Mar', 'May', 'Jul', 'Sep', 'Nov'],
            values: [2100, 3500, 4200, 3800, 5600, 7200],
            total: "26.800T"
        }
    };

    function updateMainChart(timeframe) {
        // 1. Lấy tham chiếu đến Chart instance (đã khởi tạo ở DOMContentLoaded)
        // Lưu ý: Bạn cần khai báo biến mainRevenueChart ở phạm vi ngoài để hàm này truy cập được
        const chart = Chart.getChart("mainRevenueChart");
        const data = chartDataStore[timeframe];

        if (!chart || !data) return;

        // 2. Hiệu ứng UI cho các nút bấm
        const buttons = event.target.parentElement.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.classList.remove('bg-white/10', 'text-white', 'shadow-xl');
            btn.classList.add('text-white/40');
        });
        event.target.classList.add('bg-white/10', 'text-white', 'shadow-xl');
        event.target.classList.remove('text-white/40');

        // 3. Cập nhật con số tổng (Revenue Display)
        const revenueHeader = document.querySelector('#revenue-intelligence h4');
        gsap.to(revenueHeader, {
            opacity: 0,
            y: -10,
            duration: 0.2,
            onComplete: () => {
                revenueHeader.firstChild.textContent = data.total + " ";
                gsap.to(revenueHeader, {
                    opacity: 1,
                    y: 0,
                    duration: 0.3
                });
            }
        });

        // 4. Cập nhật dữ liệu biểu đồ với hiệu ứng mượt
        chart.data.labels = data.labels;
        chart.data.datasets[0].data = data.values;

        // Cấu hình animation riêng cho lúc update
        chart.update({
            duration: 800,
            easing: 'easeOutQuart'
        });

        // 5. Haptic Feedback (Rung nhẹ)
        if (window.navigator.vibrate) window.navigator.vibrate(5);
    }

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>