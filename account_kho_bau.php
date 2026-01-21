<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Hiệu ứng viền chạy Sapphire dọc thẻ */
        .card-border-glow {
            animation: border-energy 5s infinite linear;
            box-shadow: inset 0 0 20px rgba(0, 127, 255, 0.1);
        }

        @keyframes border-energy {
            0% {
                border-color: rgba(0, 127, 255, 0);
                box-shadow: inset 0 0 10px rgba(0, 127, 255, 0);
            }

            50% {
                border-color: rgba(0, 127, 255, 0.4);
                box-shadow: inset 0 0 30px rgba(0, 127, 255, 0.2);
            }

            100% {
                border-color: rgba(0, 127, 255, 0);
                box-shadow: inset 0 0 10px rgba(0, 127, 255, 0);
            }
        }

        /* Hiệu ứng Floating Ambient */
        #vip-card,
        .stats-box {
            will-change: transform;
        }

        /* Tối ưu Mobile */
        @media (max-width: 768px) {
            .perspective-container {
                perspective: 1000px;
            }

            #vip-card {
                width: 100%;
                height: 220px;
            }

            .stats-box {
                border-left: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                padding-left: 0;
                padding-bottom: 15px;
                text-align: center;
            }

            .stats-box div {
                justify-content: center;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Pulse of Provenance: Vòng tròn xác thực Blockchain */
        .verify-circle {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verify-circle::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 1px solid rgba(34, 211, 238, 0.5);
            animation: pulse-ring 4s infinite linear;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .sapphire-pod {
            background: radial-gradient(circle at center, #001A33 0%, #000814 100%);
            transition: transform 0.5s cubic-bezier(0.2, 0, 0.2, 1);
        }

        .plate-image {

            background: radial-gradient(circle at center, #001A33 0%, #000814 100%);
            transition: transform 0.5s cubic-bezier(0.2, 0, 0.2, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        #collection-gallery {
            background-color: #000814;
        }

        /* Carousel cho Mobile */
        @media (max-width: 768px) {
            #collection-gallery .container {
                padding: 0;
                overflow-x: auto;
                /* display: flex; */
                scroll-snap-type: x mandatory;
            }

            pod-wrapper {
                flex: 0 0 85vw;
                /* Mỗi báu vật chiếm 85% chiều rộng màn hình */
                scroll-snap-align: center;
                perspective: 1000px;
            }

            .sapphire-pod {
                aspect-ratio: 3/4;
                /* Tỷ lệ thẻ đứng hơn trên mobile */
            }

            #collection-gallery h3 {
                font-size: 2rem;
                margin-bottom: 2rem;
            }

            #collection-gallery .museum-grid {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                gap: 1.5rem;
                padding-bottom: 2rem;
                scrollbar-width: none;
                /* Firefox */
            }

            #collection-gallery .museum-grid::-webkit-scrollbar {
                display: none;
            }

            .museum-grid {
                display: flex !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory;
                gap: 1.5rem !important;
                padding: 0 10px 30px 10px !important;
                scrollbar-width: none;
                /* Ẩn scrollbar Firefox */
                -webkit-overflow-scrolling: touch;
            }

            .museum-grid::-webkit-scrollbar {
                display: none;
                /* Ẩn scrollbar Chrome/Safari */
            }
        }

        /* Mask mờ sương khi chưa Reveal */
        .reveal-mask {
            background: rgba(0, 26, 51, 0.8);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            z-index: 20;
        }

        @media (max-width: 1024px) {
            .pod-wrapper {
                margin-top: 0 !important;
            }


        }

        /* ----------------------------- section 3 -----------------------------  */
        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Hiệu ứng Pulse cho các điểm nút */
        .chart-node,
        #peak-point {
            filter: drop-shadow(0 0 8px #00f2ff);
            animation: pulse-node 2s infinite;
        }

        @keyframes pulse-node {
            0% {
                r: 5;
                opacity: 1;
            }

            50% {
                r: 8;
                opacity: 0.5;
            }

            100% {
                r: 5;
                opacity: 1;
            }
        }

        /* Mobile: Ẩn biểu đồ phức tạp thay bằng cột nếu cần, 
       nhưng ở đây chúng ta tối ưu SVG để nó co giãn tốt */
        @media (max-width: 768px) {
            #growth-chart {
                transform: scale(1.1);
                margin-left: 20px;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section class="relative min-h-[70vh] flex items-center justify-center py-20 px-6 overflow-hidden bg-[#000814]">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-900/10 blur-[120px] rounded-full"></div>

        <div class="container max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-16 relative z-10">

            <div class="perspective-container flex-1 flex justify-center items-center">
                <div id="vip-card" class="relative w-[340px] h-[500px] md:w-[450px] md:h-[280px] rounded-[24px] overflow-hidden border border-white/10 shadow-2xl cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#001A33] via-[#000814] to-[#011627]"></div>
                    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>

                    <div class="card-border-glow absolute inset-0 rounded-[24px] border-2 border-blue-500/0"></div>

                    <div class="relative h-full p-8 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div class="logo-gold text-2xl font-bold tracking-tighter text-[#D4AF37]">
                                KHO BÁU SỐ
                            </div>
                            <div class="text-white/20 italic space-mono text-[10px]">PREMIUM ACCESS</div>
                        </div>

                        <div class="mt-auto">
                            <p class="text-[10px] text-blue-100/40 tracking-[3px] uppercase mb-1">MEMBER IDENTITY</p>
                            <h2 class="text-3xl md:text-4xl font-light text-[#D4AF37] tracking-wider mb-4 serif italic">Mr. Alexander</h2>

                            <div class="flex justify-between items-end border-t border-white/10 pt-4">
                                <div>
                                    <p class="text-[9px] text-white/30 tracking-[2px]">VIP CODE</p>
                                    <p class="space-mono text-sm text-white/80">KBS-8888-9999</p>
                                </div>
                                <div class="w-12 h-9 bg-gradient-to-tr from-[#D4AF37] to-[#F9E29C] rounded-md opacity-80 flex items-center justify-center">
                                    <div class="w-8 h-6 border border-black/10 rounded flex flex-col gap-1 p-1">
                                        <div class="h-[1px] bg-black/20 w-full"></div>
                                        <div class="h-[1px] bg-black/20 w-full"></div>
                                        <div class="h-[1px] bg-black/20 w-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="card-shine" class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-transparent pointer-events-none"></div>
                </div>
            </div>

            <div class="flex-1 w-full lg:max-w-md">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3 lg:grid-cols-1">
                    <div class="stats-box group border-l-2 border-blue-500/20 pl-6 py-2">
                        <p class="text-[10px] text-white/40 tracking-[4px] uppercase mb-2">Total Assets</p>
                        <div class="flex items-baseline gap-2">
                            <span class="counter text-3xl font-light text-white" data-target="85000000000">0</span>
                            <span class="text-xs text-blue-400 font-bold uppercase tracking-widest">VNĐ</span>
                        </div>
                    </div>

                    <div class="stats-box group border-l-2 border-blue-500/20 pl-6 py-2">
                        <p class="text-[10px] text-white/40 tracking-[4px] uppercase mb-2">Inventory</p>
                        <div class="flex items-baseline gap-2">
                            <span class="counter text-3xl font-light text-white" data-target="12">0</span>
                            <span class="text-xs text-blue-400 font-bold uppercase tracking-widest">Báu vật</span>
                        </div>
                    </div>

                    <div class="stats-box group border-l-2 border-blue-500/20 pl-6 py-2">
                        <p class="text-[10px] text-white/40 tracking-[4px] uppercase mb-2">Rank Status</p>
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-light text-[#D4AF37] tracking-widest uppercase">Diamond</span>
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-[0_0_10px_#007FFF]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="collection-gallery" class="relative min-h-screen py-24 px-6 bg-[#000814] overflow-hidden">
        <div class="container mx-auto max-w-7xl">
            <div class="mb-20 text-center lg:text-left">
                <h2 class="text-[10px] tracking-[5px] text-blue-400 uppercase mb-4 opacity-70">Digital Heritage</h2>
                <h3 class="serif text-5xl text-white font-light">Phòng Trưng Bày <span class="text-[#D4AF37]">Báu Vật</span></h3>
            </div>

            <div class="museum-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16 items-start">

                <div class="pod-wrapper lg:mt-20 group">
                    <div class="sapphire-pod relative aspect-[4/5] bg-black rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
                        <div class="reveal-mask absolute inset-0 bg-blue-900/40 backdrop-blur-3xl z-20 pointer-events-none"></div>

                        <div class="pod-content relative h-full p-8 flex flex-col justify-between z-10">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] space-mono text-white/40 tracking-widest uppercase">Rare Score: 98/100</span>
                                <div class="verify-circle w-4 h-4 rounded-full border border-cyan-400/50 flex items-center justify-center">
                                    <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full"></div>
                                </div>
                            </div>

                            <div class="plate-3d-container flex justify-center items-center py-10 transition-transform duration-500">
                                <div class="plate-image bg-gradient-to-b from-gray-200 to-white px-8 py-4 rounded-lg shadow-[0_20px_50px_rgba(0,127,255,0.3)] border-2 border-black/10">
                                    <span class="text-4xl md:text-5xl font-bold tracking-tighter text-[#001A33] space-mono">30A-888.88</span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-end border-b border-white/10 pb-4">
                                    <div>
                                        <p class="text-xs text-white/60 font-semibold italic">Siêu phẩm Ngũ Quý</p>
                                        <p class="text-[10px] text-white/30 font-light mt-1 uppercase tracking-tighter">Sở hữu: 20/01/2024 • Ô tô</p>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <button class="p-3 rounded-full border border-white/10 hover:bg-blue-500/20 hover:border-blue-500/50 transition-all group/btn">
                                        <i class="ri-file-shield-2-line text-white/60 group-hover/btn:text-cyan-400"></i>
                                    </button>
                                    <button class="p-3 rounded-full border border-white/10 hover:bg-blue-500/20 hover:border-blue-500/50 transition-all group/btn">
                                        <i class="ri-history-line text-white/60 group-hover/btn:text-cyan-400"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pod-wrapper group">
                    <div class="sapphire-pod relative aspect-[4/5] bg-black rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
                        <div class="reveal-mask absolute inset-0 bg-blue-900/40 backdrop-blur-3xl z-20 pointer-events-none"></div>
                        <div class="pod-content relative h-full p-8 flex flex-col justify-between z-10">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] space-mono text-white/40 tracking-widest uppercase">Rare Score: 92/100</span>
                                <div class="verify-circle w-4 h-4 rounded-full border border-cyan-400/50"></div>
                            </div>
                            <div class="plate-3d-container flex justify-center items-center py-10">
                                <div class="plate-image bg-white px-8 py-4 rounded-lg shadow-[0_20px_50px_rgba(0,127,255,0.2)] border-2 border-black/10">
                                    <span class="text-4xl md:text-5xl font-bold tracking-tighter text-[#001A33] space-mono">51G-999.99</span>
                                </div>
                            </div>
                            <div class="space-y-4 text-white">
                                <p class="text-[10px] text-white/30 font-light mt-1 uppercase tracking-tighter">Sở hữu: 15/12/2023 • Ô tô</p>
                                <div class="flex gap-4">
                                    <button class="p-3 rounded-full border border-white/10"><i class="ri-file-shield-2-line"></i></button>
                                    <button class="p-3 rounded-full border border-white/10"><i class="ri-history-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pod-wrapper lg:mt-40 group">
                    <div class="sapphire-pod relative aspect-[4/5] bg-black rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
                        <div class="reveal-mask absolute inset-0 bg-blue-900/40 backdrop-blur-3xl z-20 pointer-events-none"></div>
                        <div class="pod-content relative h-full p-8 flex flex-col justify-between z-10">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] space-mono text-white/40 tracking-widest uppercase">Rare Score: 85/100</span>
                                <div class="verify-circle w-4 h-4 rounded-full border border-cyan-400/50"></div>
                            </div>
                            <div class="plate-3d-container flex justify-center items-center py-10">
                                <div class="plate-image bg-[#FFD700] px-8 py-4 rounded-lg shadow-[0_20px_50px_rgba(212,175,55,0.3)] border-2 border-white/20">
                                    <span class="text-4xl md:text-5xl font-bold tracking-tighter text-[#001A33] space-mono">29A-666.66</span>
                                </div>
                            </div>
                            <div class="space-y-4 text-white">
                                <p class="text-[10px] text-white/30 font-light mt-1 uppercase tracking-tighter">Sở hữu: 05/01/2024 • Xe máy</p>
                                <div class="flex gap-4">
                                    <button class="p-3 rounded-full border border-white/10"><i class="ri-file-shield-2-line"></i></button>
                                    <button class="p-3 rounded-full border border-white/10"><i class="ri-history-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="market-pulse" class="relative min-h-screen py-24 px-6 bg-[#000814] overflow-hidden border-t border-white/5">
        <div class="absolute inset-0 opacity-10 pointer-events-none"
            style="background-image: linear-gradient(#007FFF 1px, transparent 1px), linear-gradient(90deg, #007FFF 1px, transparent 1px); background-size: 50px 50px;">
        </div>

        <div class="container mx-auto max-w-7xl relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-center">

                <div class="w-full lg:w-1/3 space-y-8">
                    <div class="header-content">
                        <h2 class="text-[10px] tracking-[5px] text-blue-400 uppercase mb-4">Market Performance</h2>
                        <h3 class="serif text-4xl text-white font-light leading-tight">Chỉ Số <br> <span class="text-cyan-400">Tăng Trưởng</span></h3>
                    </div>

                    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 p-8 rounded-[32px]">
                        <p class="text-[10px] text-white/40 tracking-[2px] uppercase mb-2">Lợi nhuận ước tính</p>
                        <div class="flex items-center gap-4">
                            <span id="profit-counter" class="text-5xl font-bold text-[#50C878] space-mono" data-value="15.8">+0.0%</span>
                            <div class="p-2 bg-[#50C878]/10 rounded-full">
                                <i class="ri-arrow-right-up-line text-[#50C878] text-2xl"></i>
                            </div>
                        </div>
                        <p class="text-xs text-white/30 mt-4 leading-relaxed font-light">
                            Giá trị kho báu đã tăng trưởng ổn định nhờ vào sự khan hiếm của các dãy số Ngũ Quý trên thị trường.
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-2/3 relative min-h-[400px] flex items-center">
                    <svg id="growth-chart" viewBox="0 0 800 400" class="w-full h-auto drop-shadow-[0_0_20px_rgba(0,242,255,0.2)] overflow-visible">
                        <defs>
                            <linearGradient id="chart-gradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#00f2ff" stop-opacity="0.3" />
                                <stop offset="100%" stop-color="#00f2ff" stop-opacity="0" />
                            </linearGradient>
                        </defs>

                        <path id="chart-area" d="M 0 350 Q 200 300 400 250 T 800 100 L 800 400 L 0 400 Z" fill="url(#chart-gradient)" opacity="0"></path>

                        <path id="chart-line" d="M 0 350 Q 200 300 400 250 T 800 100"
                            fill="none" stroke="#00f2ff" stroke-width="3" stroke-linecap="round"></path>

                        <circle class="chart-node" cx="200" cy="300" r="5" fill="#00f2ff"></circle>
                        <circle class="chart-node" cx="400" cy="250" r="5" fill="#00f2ff"></circle>
                        <circle class="chart-node" cx="600" cy="180" r="5" fill="#00f2ff"></circle>
                        <circle id="peak-point" cx="800" cy="100" r="6" fill="#00f2ff" class="cursor-pointer"></circle>
                    </svg>

                    <div id="chart-tooltip" class="absolute hidden bg-white/10 backdrop-blur-md border border-white/20 p-3 rounded-xl pointer-events-none">
                        <p class="text-[9px] text-white/60 space-mono">GIA TRỊ ƯỚC TÍNH</p>
                        <p class="text-xs text-white font-bold">92.400.000.000 VNĐ</p>
                    </div>
                </div>
            </div>

            <div class="mt-20 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="p-6 bg-white/[0.02] border border-white/5 rounded-2xl hover:border-blue-500/30 transition-all">
                    <p class="text-[9px] text-white/30 uppercase mb-2">Đang hót nhất</p>
                    <p class="text-white space-mono text-sm">30K-999.99</p>
                    <p class="text-[10px] text-blue-400 mt-2">Đang đấu giá: 4.2 tỷ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const card = document.getElementById('vip-card');
        const shine = document.getElementById('card-shine');

        // 1. Hiệu ứng Number Roll (Chạy số staggered)
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const duration = 2; // giây

            gsap.to(counter, {
                innerText: target,
                duration: duration,
                snap: {
                    innerText: 1
                },
                scrollTrigger: {
                    trigger: counter,
                    start: "top 90%"
                },
                onUpdate: function() {
                    if (target > 1000) {
                        counter.innerText = Number(counter.innerText).toLocaleString('vi-VN');
                    }
                }
            });
        });

        // 2. Hiệu ứng Ambient Floating (Trôi lơ lửng)
        gsap.to("#vip-card", {
            y: -10,
            rotation: 1,
            duration: 3,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 3. Hiệu ứng The Tilt Interaction (Desktop)
        if (window.innerWidth > 1024) {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;

                gsap.to(card, {
                    rotateX: rotateX,
                    rotateY: rotateY,
                    duration: 0.5,
                    ease: "power2.out"
                });

                // Di chuyển lớp bắt sáng
                gsap.to(shine, {
                    x: (x - centerX) * 0.5,
                    y: (y - centerY) * 0.5,
                    opacity: 1,
                    duration: 0.5
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    rotateX: 0,
                    rotateY: 0,
                    duration: 1,
                    ease: "elastic.out(1, 0.3)"
                });
                gsap.to(shine, {
                    opacity: 0.2,
                    duration: 1
                });
            });
        }

        // 4. Hiệu ứng Gyroscope (Nghiêng điện thoại - Mobile)
        if (window.DeviceOrientationEvent && window.innerWidth <= 1024) {
            window.addEventListener('deviceorientation', (event) => {
                const tiltX = Math.clip(event.beta, -30, 30) / 2; // Độ nghiêng trước sau
                const tiltY = Math.clip(event.gamma, -30, 30) / 2; // Độ nghiêng trái phải

                gsap.to(card, {
                    rotateX: tiltX,
                    rotateY: tiltY,
                    duration: 0.3
                });
            });
        }
    });

    // Hàm giới hạn giá trị
    Math.clip = (number, min, max) => Math.min(Math.max(number, min), max);

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const isMobile = window.innerWidth <= 768;
        // 1. Hiệu ứng The Glass Reveal (Mở màn sương mù Sapphire)
        gsap.utils.toArray('.sapphire-pod').forEach(pod => {
            const mask = pod.querySelector('.reveal-mask');
            const content = pod.querySelector('.pod-content');

            gsap.to(mask, {
                clipPath: 'circle(0% at 50% 50%)',
                opacity: 0,
                duration: 1.5,
                ease: "expo.inOut",
                scrollTrigger: {
                    trigger: pod,
                    start: "top 80%",
                }
            });

            // 2. Chỉ chạy 3D Parallax trên Desktop (Tránh giật lag mobile)
            if (!isMobile) {
                pod.addEventListener('mousemove', (e) => {
                    const rect = pod.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width - 0.5;
                    const y = (e.clientY - rect.top) / rect.height - 0.5;

                    gsap.to(pod.querySelector('.plate-3d-container'), {
                        x: x * 30,
                        y: y * 30,
                        rotateX: -y * 15,
                        rotateY: x * 15,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                });

                pod.addEventListener('mouseleave', () => {
                    gsap.to(pod.querySelector('.plate-3d-container'), {
                        x: 0,
                        y: 0,
                        rotateX: 0,
                        rotateY: 0,
                        duration: 1,
                        ease: "elastic.out(1, 0.5)"
                    });
                });
            } else {
                // 3. Hiệu ứng chạm nhẹ trên Mobile
                pod.addEventListener('touchstart', () => {
                    gsap.to(pod, {
                        scale: 0.95,
                        duration: 0.3
                    });
                });
                pod.addEventListener('touchend', () => {
                    gsap.to(pod, {
                        scale: 1,
                        duration: 0.3
                    });
                });
            }

            // 3. Mobile Double Tap (Xem nhanh chứng nhận)
            let lastTap = 0;
            pod.addEventListener('touchend', (e) => {
                const currentTime = new Date().getTime();
                const tapLength = currentTime - lastTap;
                if (tapLength < 300 && tapLength > 0) {
                    // Hiệu ứng Haptic giả lập
                    if (window.navigator.vibrate) window.navigator.vibrate(20);
                    alert("Đang truy xuất Giấy chứng nhận Blockchain cho biển số...");
                    e.preventDefault();
                }
                lastTap = currentTime;
            });
        });
    });

    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Hiệu ứng Vẽ Biểu Đồ (DrawSVG-like)
        const path = document.querySelector('#chart-line');
        const length = path.getTotalLength();

        // Thiết lập trạng thái ẩn ban đầu cho line
        gsap.set(path, {
            strokeDasharray: length,
            strokeDashoffset: length
        });

        ScrollTrigger.create({
            trigger: "#market-pulse",
            start: "top 70%",
            onEnter: () => {
                // Vẽ đường Line
                gsap.to(path, {
                    strokeDashoffset: 0,
                    duration: 2.5,
                    ease: "power2.inOut"
                });

                // Hiện vùng Area Gradient
                gsap.to("#chart-area", {
                    opacity: 1,
                    duration: 1.5,
                    delay: 1,
                    ease: "power1.out"
                });

                // Nhảy số phần trăm
                const profit = document.getElementById('profit-counter');
                const targetVal = parseFloat(profit.getAttribute('data-value'));
                gsap.to(profit, {
                    innerText: targetVal,
                    duration: 2,
                    snap: {
                        innerText: 0.1
                    },
                    onUpdate: function() {
                        profit.innerText = "+" + parseFloat(profit.innerText).toFixed(1) + "%";
                    }
                });
            }
        });

        // 2. Tooltip Interaction (Desktop Mouse Tracking)
        const peakPoint = document.getElementById('peak-point');
        const tooltip = document.getElementById('chart-tooltip');

        if (window.innerWidth > 1024) {
            document.getElementById('growth-chart').addEventListener('mousemove', (e) => {
                const rect = e.currentTarget.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                tooltip.classList.remove('hidden');
                gsap.to(tooltip, {
                    left: x + 20,
                    top: y - 40,
                    duration: 0.3
                });
            });

            document.getElementById('growth-chart').addEventListener('mouseleave', () => {
                tooltip.classList.add('hidden');
            });
        }

        // 3. Mobile Haptic Feedback (Chạm vào điểm cao nhất)
        peakPoint.addEventListener('touchstart', () => {
            if (window.navigator.vibrate) {
                window.navigator.vibrate([50, 30, 50]); // Rung nhịp kép khi đạt đỉnh
            }
            tooltip.classList.remove('hidden');
            tooltip.style.left = "50%";
            tooltip.style.top = "10%";
            tooltip.style.transform = "translateX(-50%)";
        });
    });

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>