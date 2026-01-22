<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap');

        .jetbrains {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Matrix Pulse Grid */
        .matrix-grid {
            background-image: linear-gradient(rgba(0, 194, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 194, 255, 0.05) 1px, transparent 1px);
            background-size: 15px 15px;
        }

        .glow-text {
            text-shadow: 0 0 15px rgba(0, 194, 255, 0.5);
        }

        /* Hiệu ứng tia sáng quét */
        .metric-card:hover .scanline {
            animation: scanMove 1.5s linear infinite;
            opacity: 1;
        }

        @keyframes scanMove {
            0% {
                top: 0;
            }

            100% {
                top: 100%;
            }
        }

        /* SVG Wave Animation */
        #wave-path {
            stroke-dasharray: 400;
            animation: waveAnim 4s linear infinite;
        }

        @keyframes waveAnim {
            0% {
                stroke-dashoffset: 400;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Mobile Expandable Logic */
        @media (max-width: 640px) {
            .detail-info {
                display: none;
            }

            .metric-card.active .detail-info {
                display: block;
                opacity: 1;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="admin-core" class="relative min-h-[400px] py-10 bg-[#000814] px-4 md:px-8">
        <div class="container mx-auto max-w-[1600px]">

            <div class="flex items-center gap-3 mb-8 border-l-4 border-cyan-500 pl-4">
                <div>
                    <h2 class="jetbrains text-[10px] tracking-[5px] text-cyan-500 uppercase">System Status</h2>
                    <h3 class="jetbrains text-2xl text-white font-bold">NHỊP ĐẬP HỆ THỐNG</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                <div class="metric-card group relative bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl p-6 overflow-hidden transition-all duration-500 hover:border-cyan-500/50">
                    <div class="scanline absolute top-0 left-0 w-full h-[2px] bg-cyan-500/50 opacity-0 pointer-events-none"></div>
                    <div class="matrix-grid absolute inset-0 opacity-10 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <span class="jetbrains text-[10px] text-white/40 tracking-tighter">REAL-TIME REVENUE</span>
                            <i class="ri-money-dollar-circle-line text-cyan-500"></i>
                        </div>
                        <div class="counter-wrapper mb-2">
                            <span class="jetbrains text-3xl font-bold text-[#00C2FF] glow-text" id="revenue-val">1.250.000.000</span>
                            <span class="text-[10px] text-white/30 ml-1">VND</span>
                        </div>
                        <div class="detail-info opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-emerald-400 text-[10px] jetbrains">↑ 12.5% vs last hour</span>
                        </div>
                    </div>
                </div>

                <div class="metric-card group relative bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl p-6 overflow-hidden transition-all duration-500">
                    <div class="scanline absolute top-0 left-0 w-full h-[2px] bg-cyan-500/50 opacity-0 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <span class="jetbrains text-[10px] text-white/40 tracking-tighter">LIVE BIDDERS</span>
                            <div class="flex items-center gap-1">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                <span class="text-[9px] text-emerald-500 jetbrains">ONLINE</span>
                            </div>
                        </div>
                        <div class="counter-wrapper">
                            <span class="jetbrains text-4xl font-bold text-white tracking-tighter" id="bidders-val">8,429</span>
                        </div>
                        <div class="detail-info opacity-0 group-hover:opacity-100 mt-2 transition-opacity duration-300">
                            <span class="text-white/40 text-[10px] jetbrains">Active in 42 rooms</span>
                        </div>
                    </div>
                </div>

                <div class="metric-card group relative bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl p-6 overflow-hidden transition-all duration-500">
                    <div class="scanline absolute top-0 left-0 w-full h-[2px] bg-cyan-500/50 opacity-0 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <span class="jetbrains text-[10px] text-white/40 tracking-tighter">SERVER HEALTH</span>
                            <span class="text-[10px] text-[#39FF14] jetbrains">STABLE</span>
                        </div>
                        <div class="h-16 w-full flex items-end overflow-hidden">
                            <svg viewBox="0 0 200 60" class="w-full h-full">
                                <path id="wave-path" d="M0,30 Q25,10 50,30 T100,30 T150,30 T200,30" fill="none" stroke="#00C2FF" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="flex justify-between mt-2 jetbrains text-[9px] text-white/40">
                            <span>Latency: 24ms</span>
                            <span>Load: 12%</span>
                        </div>
                    </div>
                </div>

                <div class="metric-card group relative bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl p-6 overflow-hidden transition-all duration-500">
                    <div class="scanline absolute top-0 left-0 w-full h-[2px] bg-cyan-500/50 opacity-0 pointer-events-none"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <span class="jetbrains text-[10px] text-white/40 tracking-tighter">SECURITY ALERTS</span>
                            <i class="ri-shield-check-line text-[#39FF14]"></i>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-2xl jetbrains text-white font-bold">PROTECTED</div>
                        </div>
                        <div class="mt-4 bg-white/5 rounded-lg p-2 flex items-center gap-3">
                            <div class="w-full bg-white/10 h-1 rounded-full overflow-hidden">
                                <div class="bg-[#39FF14] h-full w-[95%]"></div>
                            </div>
                            <span class="text-[9px] text-[#39FF14] jetbrains">95%</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Staggered Counter cho Doanh Thu
        function animateCounter(id, targetValue) {
            const obj = {
                value: 0
            };
            gsap.to(obj, {
                value: targetValue,
                duration: 2,
                ease: "power3.out",
                onUpdate: () => {
                    document.getElementById(id).innerText = Math.floor(obj.value).toLocaleString('vi-VN');
                },
                onComplete: () => {
                    // Hiệu ứng Glow khi đạt con số cuối
                    gsap.to(`#${id}`, {
                        color: "#00FFC2",
                        scale: 1.05,
                        duration: 0.2,
                        yoyo: true,
                        repeat: 1
                    });
                }
            });
        }

        // Chạy counter khi load
        animateCounter('revenue-val', 1250000000);

        // 2. Server Health SVG Wave Animation (Bằng GSAP để mượt hơn)
        const wavePath = document.getElementById('wave-path');
        let points = [];
        for (let i = 0; i <= 200; i += 25) points.push(i);

        function updateWave() {
            let d = `M0,30 `;
            points.forEach((x, i) => {
                if (i === 0) return;
                let y = 30 + Math.sin(Date.now() * 0.005 + i) * 15;
                d += `Q${x - 12},${y - 10} ${x},30 `;
            });
            wavePath.setAttribute('d', d);
            requestAnimationFrame(updateWave);
        }
        updateWave();

        // 3. Mobile Expandable Card
        if (window.innerWidth <= 640) {
            document.querySelectorAll('.metric-card').forEach(card => {
                card.addEventListener('click', () => {
                    card.classList.toggle('active');
                    if (window.navigator.vibrate) window.navigator.vibrate(10);
                });
            });
        }

        // 4. Matrix Pulse Background
        gsap.to(".matrix-grid", {
            opacity: 0.15,
            duration: 1.5,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });
    });

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>