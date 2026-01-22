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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>