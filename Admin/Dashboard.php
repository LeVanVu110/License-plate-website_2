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
    <section id="global-wealth-chart" class="relative pb-20 px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500">
        <div class="container mx-auto max-w-[1600px]">
            <div class="flex flex-col xl:flex-row gap-6">

                <div class="xl:w-2/3 bg-[#050505]/60 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 relative overflow-hidden group">
                    <div class="absolute inset-0 sapphire-grid opacity-10 pointer-events-none"></div>

                    <div class="flex justify-between items-center mb-8 relative z-10">
                        <div>
                            <h3 class="jetbrains text-white text-lg font-bold">FINANCIAL HORIZON</h3>
                            <p class="text-[10px] text-white/30 jetbrains tracking-[3px] uppercase">Real-time Market Flow</p>
                        </div>
                        <div class="flex bg-black/40 p-1 rounded-xl border border-white/5 shadow-inner">
                            <button class="time-filter active px-4 py-1.5 rounded-lg text-[10px] jetbrains text-white transition-all" data-range="day">DAY</button>
                            <button class="time-filter px-4 py-1.5 rounded-lg text-[10px] jetbrains text-white/40 transition-all" data-range="week">WEEK</button>
                            <button class="time-filter px-4 py-1.5 rounded-lg text-[10px] jetbrains text-white/40 transition-all" data-range="month">MONTH</button>
                        </div>
                    </div>

                    <div class="relative h-[400px] w-full">
                        <canvas id="wealthChart"></canvas>
                    </div>
                </div>

                <div class="xl:w-1/3 flex flex-col gap-6">
                    <div class="bg-gradient-to-br from-cyan-950/40 to-black/60 backdrop-blur-2xl border border-cyan-500/20 rounded-3xl p-8 flex-1 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-cyan-500/5 rounded-full blur-3xl"></div>

                        <h4 class="jetbrains text-cyan-400 text-xs mb-6 flex items-center gap-2">
                            <i class="ri-robot-line animate-pulse"></i> AI PREDICTION ENGINE
                        </h4>

                        <div class="space-y-8">
                            <div class="forecast-item">
                                <p class="text-[10px] text-white/40 jetbrains mb-2">EXPECTED REVENUE (EOD)</p>
                                <div class="flex justify-between items-end">
                                    <span class="text-2xl text-white jetbrains font-bold">120%</span>
                                    <span class="text-[#00FFC2] text-[10px] jetbrains">↑ EXCEEDING TARGET</span>
                                </div>
                                <div class="w-full bg-white/5 h-1 mt-3 rounded-full overflow-hidden">
                                    <div class="bg-cyan-500 h-full w-[85%] shadow-[0_0_10px_#06b6d4]"></div>
                                </div>
                            </div>

                            <div class="forecast-item">
                                <p class="text-[10px] text-white/40 jetbrains mb-2">BID INTENSITY FORECAST</p>
                                <div class="flex justify-between items-end">
                                    <span class="text-2xl text-white jetbrains font-bold">High</span>
                                    <span class="text-cyan-400 text-[10px] jetbrains italic">PHASE: PEAK REACH</span>
                                </div>
                            </div>

                            <div class="p-4 bg-cyan-500/5 border border-cyan-500/10 rounded-2xl mt-4">
                                <p class="text-[11px] leading-relaxed text-white/60 italic font-light">
                                    "Dựa trên lưu lượng hiện tại, hệ thống dự báo một đợt bùng nổ giá vào lúc 21:00 đêm nay tại sảnh đấu giá Tứ Quý."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

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

        const wealthChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
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
                                size: 10
                            }
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
                                size: 10
                            }
                        }
                    }
                }
            }
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

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>