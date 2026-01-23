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

        /* ----------------------------- section 2 -----------------------------  */

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
        <section id="fiscal-pulse" class="py-8 px-4 md:px-10 bg-[#050505] min-h-screen font-['Inter']">

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

        <style>
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
        </style>

        <!-- ----------------------------- section 2 -----------------------------  -->

        <!-- ----------------------------- section 3 -----------------------------  -->

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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>