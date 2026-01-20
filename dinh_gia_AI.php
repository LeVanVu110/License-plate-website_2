<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Space+Mono&display=swap');

        #quantum-portal {
            perspective: 1000px;
        }

        #headline {
            font-family: 'Playfair Display', serif;
        }

        #plate-input {
            font-family: 'Space Mono', monospace;
            text-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        }

        /* Radar Animation */
        .radar-ring {
            transition: transform 0.1s ease-out;
        }

        /* Biometric Laser */
        #laser-line {
            top: 0;
        }

        /* Glow Effect for Rings */
        .ring-1 {
            box-shadow: inset 0 0 50px rgba(0, 255, 255, 0.05);
        }

        /* Utility Classes */
        .shake-screen {
            animation: quantum-shake 0.1s infinite;
        }

        @keyframes quantum-shake {
            0% {
                transform: translate(1px, 1px);
            }

            50% {
                transform: translate(-1px, -2px);
            }

            100% {
                transform: translate(1px, 1px);
            }
        }

        @media (max-width: 768px) {
            #headline {
                tracking: 0.5rem;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        .glass-module {
            background: linear-gradient(135deg, rgba(0, 26, 51, 0.4), rgba(0, 15, 26, 0.8));
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .glass-module:hover {
            border-color: rgba(34, 211, 238, 0.6);
            transform: scale(1.05) translateY(-5px);
            z-index: 30;
        }

        /* Scanline Effect */
        .scanline {
            width: 100%;
            height: 100px;
            z-index: 10;
            background: linear-gradient(0deg, transparent, rgba(34, 211, 238, 0.05), transparent);
            position: absolute;
            top: -100px;
            left: 0;
            animation: scanline-move 4s linear infinite;
            pointer-events: none;
        }

        @keyframes scanline-move {
            0% {
                top: -100px;
            }

            100% {
                top: 100%;
            }
        }

        /* Data Stream Path Animation */
        .data-path {
            stroke-dasharray: 20;
            animation: dash-flow 2s linear infinite;
        }

        @keyframes dash-flow {
            to {
                stroke-dashoffset: -40;
            }
        }

        /* Neural Grid Pattern */
        .neural-grid-pattern {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(34, 211, 238, 0.1) 1px, transparent 0);
            background-size: 40px 40px;
        }

        /* Mobile Adjustments */
        @media (max-width: 1024px) {
            .valuation-core {
                margin-bottom: 3rem;
            }

            .module-card {
                padding: 1.25rem !important;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        /* Waterfall background with Canvas or CSS */
        #data-waterfall {
            background: linear-gradient(to bottom, rgba(0, 150, 255, 0.1) 0%, transparent 100%);
            position: relative;
        }

        /* Mercury Liquid Effect */
        .action-card:hover .liquid-bg {
            background: radial-gradient(circle at center, rgba(34, 211, 238, 0.4) 0%, transparent 70%);
            opacity: 1;
        }

        .btn-mercury {
            position: relative;
            overflow: hidden;
            transition: all 0.4s;
        }

        .btn-mercury:hover {
            background: #22d3ee;
            color: #000;
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.8);
        }

        /* Heartbeat Pulsing */
        @keyframes master-pulse {
            0% {
                box-shadow: 0 0 20px rgba(34, 211, 238, 0.4);
            }

            50% {
                box-shadow: 0 0 60px rgba(34, 211, 238, 0.8);
            }

            100% {
                box-shadow: 0 0 20px rgba(34, 211, 238, 0.4);
            }
        }

        #master-cta {
            animation: master-pulse 2s infinite ease-in-out;
        }

        /* Mobile Swiper Layout */
        @media (max-width: 768px) {
            #power-cards-container {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding-bottom: 2rem;
                gap: 20px;
            }

            .action-card {
                min-width: 85%;
                scroll-snap-align: center;
            }

            #power-cards-container::-webkit-scrollbar {
                display: none;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="quantum-portal" class="relative min-h-screen bg-[#000814] overflow-hidden flex items-center justify-center">

        <canvas id="starfield-canvas" class="absolute inset-0 z-0"></canvas>

        <div class="absolute left-6 top-1/2 -translate-y-1/2 hidden lg:flex flex-col gap-2 font-mono text-[10px] text-cyan-500/30 select-none" id="left-data-stream"></div>
        <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:flex flex-col gap-2 font-mono text-[10px] text-cyan-500/30 select-none" id="right-data-stream"></div>

        <div class="container mx-auto px-6 relative z-10 flex flex-col items-center">
            <div class="text-center mb-16 overflow-hidden">
                <h1 id="headline" class="text-4xl md:text-6xl font-serif uppercase text-[#E0F7FA] tracking-[1rem] opacity-0 translate-y-full">
                    AI Oracle: Giải mã di sản
                </h1>
            </div>

            <div id="scanner-hub" class="relative w-[320px] h-[320px] md:w-[500px] md:h-[500px] flex items-center justify-center">

                <div class="radar-ring ring-1 absolute inset-0 border border-cyan-500/20 rounded-full"></div>
                <div class="radar-ring ring-2 absolute inset-[15%] border border-cyan-500/40 rounded-full border-dashed"></div>
                <div class="radar-ring ring-3 absolute inset-[30%] border-2 border-cyan-400/10 rounded-full"></div>

                <div class="relative z-20 w-full px-8 text-center">
                    <div class="input-wrapper relative">
                        <input type="text" id="plate-input" maxlength="10" placeholder="NHẬP BIỂN SỐ..."
                            class="w-full bg-transparent border-b-2 border-cyan-500/30 py-4 text-center text-3xl md:text-5xl font-mono text-cyan-400 focus:outline-none placeholder:text-cyan-900 tracking-widest uppercase">

                        <div id="laser-line" class="absolute left-0 right-0 h-[2px] bg-cyan-400 shadow-[0_0_15px_#22d3ee] opacity-0 pointer-events-none"></div>
                    </div>

                    <button id="btn-valuation" class="mt-12 group relative px-12 py-4 overflow-hidden border border-cyan-500 rounded-full transition-all duration-500">
                        <span class="relative z-10 text-cyan-400 font-bold tracking-[0.3rem] group-hover:text-black transition-colors">ĐỊNH GIÁ</span>
                        <div class="absolute inset-0 bg-cyan-400 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </button>
                </div>

                <div id="neural-center" class="absolute w-2 h-2 bg-cyan-400 rounded-full blur-sm opacity-0"></div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="neural-analysis" class="relative min-h-screen py-24 bg-[#000814] overflow-hidden flex items-center justify-center">

        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
            <div class="neural-grid-pattern absolute inset-0"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-center gap-16 lg:gap-32">

                <div class="valuation-core relative z-20 order-1 lg:order-2">
                    <div id="core-pulse" class="absolute inset-0 bg-cyan-500/20 rounded-full blur-[80px] scale-0"></div>

                    <div class="main-plate-3d bg-[#F0F0F0] p-6 rounded-2xl border-4 border-[#CCCCCC] shadow-2xl mb-8 relative">
                        <span class="absolute top-2 left-4 text-black/20 font-bold">VN</span>
                        <h2 id="analyzing-plate" class="text-black text-4xl md:text-6xl font-black tracking-tighter text-center py-4 font-mono">
                            30K-999.99
                        </h2>
                    </div>

                    <div class="total-valuation text-center">
                        <p class="text-cyan-500/50 uppercase tracking-[5px] text-[10px] mb-2 font-mono">Định giá sơ bộ</p>
                        <div class="flex items-baseline justify-center gap-2">
                            <span id="value-counter" class="text-cyan-400 text-6xl md:text-8xl font-black font-mono">0</span>
                            <span class="text-cyan-400 text-2xl font-bold uppercase">Triệu</span>
                        </div>
                    </div>
                </div>

                <div class="analysis-modules left-modules flex flex-col gap-8 order-2 lg:order-1 w-full lg:w-1/3">
                    <div class="module-card glass-module group p-6 rounded-2xl border border-cyan-500/20 relative overflow-hidden" data-module="fengshui">
                        <div class="scanline"></div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-cyan-500/10 flex items-center justify-center text-cyan-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-bold tracking-wider">PHONG THỦY HỌC</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-xs"><span class="text-white/40">Quẻ dịch:</span> <span class="text-mint-400 text-cyan-300">Cát Tường</span></div>
                            <div class="flex justify-between text-xs"><span class="text-white/40">Ngũ hành:</span> <span class="text-cyan-300">Kim Sinh Thủy</span></div>
                            <div class="h-[4px] w-full bg-white/5 rounded-full overflow-hidden mt-2">
                                <div class="h-full bg-cyan-500 w-[85%]"></div>
                            </div>
                        </div>
                    </div>

                    <div class="module-card glass-module group p-6 rounded-2xl border border-cyan-500/20 relative overflow-hidden" data-module="market">
                        <div class="scanline"></div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-cyan-500/10 flex items-center justify-center text-cyan-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-bold tracking-wider">GIÁ TRỊ THỊ TRƯỜNG</h3>
                        </div>
                        <p class="text-[10px] text-white/40 mb-2">SO SÁNH 2.4M DỮ LIỆU</p>
                        <div class="text-2xl font-mono text-cyan-400 font-bold">TOP 0.1% HIẾM</div>
                    </div>
                </div>

                <div class="analysis-modules right-modules order-3 w-full lg:w-1/3">
                    <div class="module-card glass-module group p-8 rounded-2xl border border-cyan-500/20 relative overflow-hidden" data-module="growth">
                        <div class="scanline"></div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-cyan-500/10 flex items-center justify-center text-cyan-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-bold tracking-wider">CHỈ SỐ TƯƠNG LAI</h3>
                        </div>
                        <div class="text-center">
                            <p class="text-white/40 text-[10px] mb-2 uppercase">Dự báo tăng trưởng (24 tháng)</p>
                            <div class="text-4xl font-mono text-emerald-400 font-bold">+25.8%</div>
                            <div class="mt-4 flex gap-1 h-8 items-end justify-center">
                                <div class="w-2 bg-emerald-500/20 h-2"></div>
                                <div class="w-2 bg-emerald-500/40 h-4"></div>
                                <div class="w-2 bg-emerald-500/60 h-6"></div>
                                <div class="w-2 bg-emerald-500 h-8 animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0 opacity-40">
                <path id="path-left" d="" stroke="url(#grad-cyan)" stroke-width="1.5" fill="none" class="data-path" />
                <path id="path-right" d="" stroke="url(#grad-cyan)" stroke-width="1.5" fill="none" class="data-path" />
                <defs>
                    <linearGradient id="grad-cyan" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#22d3ee" stop-opacity="0" />
                        <stop offset="50%" stop-color="#22d3ee" stop-opacity="1" />
                        <stop offset="100%" stop-color="#22d3ee" stop-opacity="0" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="action-hub" class="relative min-h-screen py-24 bg-[#000814] overflow-hidden flex items-center justify-center">

        <div class="absolute inset-0 z-0 opacity-30 pointer-events-none">
            <div id="data-waterfall" class="w-full h-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold text-[#E0F7FA] tracking-[0.5rem] uppercase mb-4">Trung Tâm Chuyển Hóa</h2>
                <p class="text-cyan-400/60 text-xs tracking-widest uppercase">Biến dữ liệu thành giá trị di sản</p>
            </div>

            <div id="power-cards-container" class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">

                <div class="action-card group relative bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-[2rem] overflow-hidden transition-all duration-500 cursor-pointer">
                    <div class="liquid-bg absolute inset-0 bg-cyan-500/0 transition-all duration-700"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="icon-3d mb-6 w-20 h-20 bg-cyan-500/10 rounded-full flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 uppercase tracking-widest">Thanh Khoản</h3>
                        <p class="text-sm text-white/60 mb-8">Ký gửi biển số ngay với mức giá AI định danh tối ưu nhất.</p>
                        <button class="btn-mercury px-6 py-2 border border-cyan-500/50 rounded-full text-[10px] font-bold text-cyan-400 uppercase tracking-widest">Ký gửi ngay</button>
                    </div>
                </div>

                <div id="cert-card" class="action-card group relative bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-[2rem] overflow-hidden transition-all duration-500 cursor-pointer">
                    <div class="liquid-bg absolute inset-0 bg-cyan-500/0 transition-all duration-700"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="icon-3d mb-6 w-20 h-20 bg-cyan-500/10 rounded-full flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 uppercase tracking-widest">Xác Thực</h3>
                        <p class="text-sm text-white/60 mb-8">Tải bản báo cáo định giá (PDF) có dấu mộc bảo chứng AI.</p>
                        <button class="btn-mercury px-6 py-2 border border-cyan-500/50 rounded-full text-[10px] font-bold text-cyan-400 uppercase tracking-widest">Tải báo cáo</button>
                    </div>
                    <div id="virtual-pdf" class="absolute inset-0 bg-white opacity-0 scale-0 pointer-events-none rounded-lg flex items-center justify-center">
                        <span class="text-black font-bold">PDF REPORT</span>
                    </div>
                </div>

                <div class="action-card group relative bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-[2rem] overflow-hidden transition-all duration-500 cursor-pointer">
                    <div class="liquid-bg absolute inset-0 bg-cyan-500/0 transition-all duration-700"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="icon-3d mb-6 w-20 h-20 bg-cyan-500/10 rounded-full flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 uppercase tracking-widest">Săn Tìm</h3>
                        <p class="text-sm text-white/60 mb-8">Tìm kiếm những biển số có giá trị tương đương trong kho báu.</p>
                        <button class="btn-mercury px-6 py-2 border border-cyan-500/50 rounded-full text-[10px] font-bold text-cyan-400 uppercase tracking-widest">Khám phá kho</button>
                    </div>
                </div>
            </div>

            <div class="text-center relative">
                <div class="convergence-glow absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-cyan-500/20 blur-[100px] rounded-full animate-pulse"></div>
                <button id="master-cta" class="relative z-10 px-16 py-6 bg-cyan-500 text-[#000814] font-black text-lg tracking-[0.4rem] uppercase rounded-full shadow-[0_0_50px_rgba(34,211,238,0.5)] hover:scale-105 transition-transform duration-300">
                    Thực thi chuyển đổi
                </button>
            </div>
        </div>

        <div id="sticky-contact" class="fixed bottom-0 left-0 w-full p-4 z-[100] translate-y-full transition-transform duration-500 lg:hidden">
            <button class="w-full bg-teal-500/80 backdrop-blur-lg py-4 rounded-2xl text-white font-bold uppercase tracking-widest text-xs border border-white/20">
                Liên hệ chuyên gia tư vấn
            </button>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. STARFIELD PARTICLES
        const canvas = document.getElementById('starfield-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        const particleCount = window.innerWidth < 768 ? 400 : 1000;
        let speedMult = 1;

        const resize = () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };
        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor() {
                this.reset();
            }
            reset() {
                this.x = (Math.random() - 0.5) * canvas.width * 2;
                this.y = (Math.random() - 0.5) * canvas.height * 2;
                this.z = Math.random() * canvas.width;
                this.prevZ = this.z;
            }
            update() {
                this.prevZ = this.z;
                this.z -= 4 * speedMult;
                if (this.z <= 0) this.reset();
            }
            draw() {
                const x = (this.x / this.z) * 100 + canvas.width / 2;
                const y = (this.y / this.z) * 100 + canvas.height / 2;
                const px = (this.x / this.prevZ) * 100 + canvas.width / 2;
                const py = (this.y / this.prevZ) * 100 + canvas.height / 2;

                ctx.strokeStyle = `rgba(34, 211, 238, ${1 - this.z / canvas.width})`;
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(px, py);
                ctx.lineTo(x, y);
                ctx.stroke();
            }
        }

        for (let i = 0; i < particleCount; i++) particles.push(new Particle());

        function loop() {
            ctx.fillStyle = 'rgba(0, 8, 20, 0.2)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(loop);
        }
        loop();

        // 2. ENTRANCE ANIMATION
        const tl = gsap.timeline();
        tl.to("#headline", {
                opacity: 1,
                y: 0,
                duration: 1.5,
                ease: "expo.out"
            })
            .from(".radar-ring", {
                scale: 0,
                opacity: 0,
                stagger: 0.2,
                duration: 2,
                ease: "elastic.out(1, 0.5)"
            }, "-=1");

        gsap.to(".ring-1", {
            rotation: 360,
            duration: 20,
            repeat: -1,
            ease: "none"
        });
        gsap.to(".ring-2", {
            rotation: -360,
            duration: 15,
            repeat: -1,
            ease: "none"
        });

        // 3. MOUSE FOLLOW (TILT) & GYRO
        window.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 20;
            const y = (e.clientY / window.innerHeight - 0.5) * 20;
            gsap.to("#scanner-hub", {
                rotationY: x,
                rotationX: -y,
                duration: 1
            });
        });

        // 4. INPUT INTERACTION
        const input = document.getElementById('plate-input');
        const laser = document.getElementById('laser-line');

        input.addEventListener('focus', () => {
            gsap.to(laser, {
                opacity: 1,
                duration: 0.3
            });
            gsap.to(laser, {
                top: "100%",
                duration: 1.5,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });

        input.addEventListener('input', () => {
            // Digital Ripple
            speedMult = 5;
            setTimeout(() => speedMult = 1, 200);
            if ("vibrate" in navigator) navigator.vibrate(10);
        });

        // 5. THE NEURAL CRUNCH (CLICK BUTTON)
        document.getElementById('btn-valuation').addEventListener('click', () => {
            const crunchTl = gsap.timeline();

            // Co hội tụ hạt và rung màn hình
            speedMult = 20;
            document.body.classList.add('shake-screen');

            crunchTl.to("#scanner-hub", {
                    scale: 0.8,
                    filter: "blur(10px)",
                    duration: 0.5
                })
                .to(".radar-ring", {
                    rotation: "+=1080",
                    duration: 1,
                    ease: "power4.in"
                }, 0)
                .to("#quantum-portal", {
                    backgroundColor: "#22d3ee",
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1
                })
                .add(() => {
                    // Transition effect sang Section tiếp theo
                    console.log("Valuation complete. Jumping to results...");
                    document.body.classList.remove('shake-screen');
                    // Window.scrollTo(...)
                });
        });

        // DATA STREAM DECRYPTION (Rìa màn hình)
        const streams = [document.getElementById('left-data-stream'), document.getElementById('right-data-stream')];
        streams.forEach(s => {
            for (let i = 0; i < 20; i++) {
                const d = document.createElement('div');
                d.innerText = Math.random().toString(16).substr(2, 8).toUpperCase();
                s.appendChild(d);
            }
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        // 1. Floating Animation for Modules
        gsap.utils.toArray(".module-card").forEach((card, i) => {
            gsap.to(card, {
                y: "-=15",
                duration: 2 + i * 0.5,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });

        // 2. Value Counting Animation
        const valueTarget = 850; // Giá trị giả lập
        const counterObj = {
            val: 0
        };

        ScrollTrigger.create({
            trigger: "#neural-analysis",
            start: "top 60%",
            onEnter: () => {
                // Count up animation
                gsap.to(counterObj, {
                    val: valueTarget,
                    duration: 2.5,
                    ease: "power4.out",
                    onUpdate: () => {
                        document.getElementById('value-counter').innerText = Math.floor(counterObj.val).toLocaleString();
                    }
                });

                // Pulse Wave Effect
                gsap.to("#core-pulse", {
                    scale: 2,
                    opacity: 0,
                    duration: 1.5,
                    repeat: 3,
                    ease: "power2.out"
                });

                // Draw Data Connections (Giả lập đường vẽ SVG)
                updateNeuralPaths();
            }
        });

        // 3. Logic vẽ đường nối Neural (Dynamic Path)
        function updateNeuralPaths() {
            const core = document.querySelector('.main-plate-3d').getBoundingClientRect();
            const modules = document.querySelectorAll('.module-card');
            const svg = document.querySelector('svg');
            const svgRect = svg.getBoundingClientRect();

            // Vẽ đường nối từ tâm tới các khối (chạy demo 1 đường)
            modules.forEach((mod, i) => {
                const modRect = mod.getBoundingClientRect();
                // Code xử lý vẽ path SVG nối các điểm sẽ nằm ở đây
            });
        }

        // 4. Mobile Hover Fix
        if (window.innerWidth < 1024) {
            gsap.utils.toArray(".module-card").forEach(card => {
                ScrollTrigger.create({
                    trigger: card,
                    start: "top 80%",
                    onEnter: () => {
                        gsap.to(card, {
                            borderColor: "rgba(34, 211, 238, 0.6)",
                            scale: 1.02
                        });
                    }
                });
            });
        }
    });

    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        // 1. PERSPECTIVE SHIFT (Desktop)
        if (window.innerWidth > 1024) {
            document.addEventListener('mousemove', (e) => {
                const x = (e.clientX / window.innerWidth - 0.5) * 10;
                const y = (e.clientY / window.innerHeight - 0.5) * 10;

                gsap.to("#action-hub .container", {
                    rotationY: x,
                    rotationX: -y,
                    transformPerspective: 1500,
                    duration: 1,
                    ease: "power2.out"
                });
            });
        }

        // 2. THE CERTIFICATE SPROUT (FLY TO POCKET)
        const certCard = document.getElementById('cert-card');
        const virtualPdf = document.getElementById('virtual-pdf');

        certCard.addEventListener('click', () => {
            const tl = gsap.timeline();

            tl.to(virtualPdf, {
                    scale: 1,
                    opacity: 1,
                    duration: 0.4,
                    ease: "back.out(1.7)"
                })
                .to(virtualPdf, {
                    x: 500,
                    y: 800,
                    rotation: 360,
                    scale: 0.1,
                    opacity: 0,
                    duration: 0.8,
                    ease: "power2.in"
                });

            // Haptic feedback
            if (navigator.vibrate) navigator.vibrate(50);
        });

        // 3. THE CONVERGENCE (Particle rotation)
        // Giả lập các hạt hội tụ từ Section 2
        gsap.from(".convergence-glow", {
            scale: 0.5,
            opacity: 0,
            duration: 2,
            scrollTrigger: {
                trigger: "#action-hub",
                start: "top center"
            }
        });

        // 4. STICKY FOOTER LOGIC
        ScrollTrigger.create({
            trigger: "#action-hub",
            start: "top 20%",
            onEnter: () => gsap.to("#sticky-contact", {
                y: 0,
                duration: 0.5
            }),
            onLeaveBack: () => gsap.to("#sticky-contact", {
                y: "100%",
                duration: 0.5
            })
        });

        // 5. MOBILE SWIPE HAPTIC
        const container = document.getElementById('power-cards-container');
        if (window.innerWidth < 768) {
            let lastScrollLeft = 0;
            container.addEventListener('scroll', () => {
                const currentScroll = container.scrollLeft;
                const cardWidth = container.offsetWidth * 0.85;

                if (Math.abs(currentScroll - lastScrollLeft) > cardWidth) {
                    if (navigator.vibrate) navigator.vibrate(20);
                    lastScrollLeft = currentScroll;
                }
            });
        }
    });

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>