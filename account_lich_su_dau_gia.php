<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        .nebula-bg {
            background: radial-gradient(circle at 50% 50%, #1a0b2e 0%, #000814 70%);
            background-image:
                url('https://www.transparenttextures.com/patterns/stardust.png'),
                radial-gradient(circle at 20% 30%, rgba(0, 255, 255, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(138, 43, 226, 0.08) 0%, transparent 40%);
        }

        .sphere-glass {
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.02);
            box-shadow: inset 0 0 30px rgba(0, 255, 255, 0.05);
        }

        /* Viền tím Deep Violet */
        .totem-item::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            background: linear-gradient(45deg, transparent 40%, rgba(138, 43, 226, 0.3));
            z-index: -1;
        }

        .text-silver {
            color: #C0C0C0;
        }

        /* Hiệu ứng sóng Pulse Glow */
        .pulse-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(0, 255, 255, 0.3);
            z-index: 0;
        }

        /* Responsive Mobile */
        @media (max-width: 1024px) {
            .totems-wrapper {
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                display: flex;
                flex-direction: row;
                justify-content: flex-start;
                padding: 40px 20px;
                width: 100vw;
                scrollbar-width: none;
            }

            .totem-item {
                flex: 0 0 80vw;
                scroll-snap-align: center;
                display: flex;
                justify-content: center;
            }

            .totems-wrapper::-webkit-scrollbar {
                display: none;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@700&family=Space+Grotesk:wght@700&display=swap');

        .space-grotesk {
            font-family: 'Space Grotesk', sans-serif;
        }

        .countdown-timer {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Hiệu ứng nhịp tim cho thẻ Outbid */
        .outbid-pulse {
            animation: heartbeat-card 1.5s infinite ease-in-out;
        }

        @keyframes heartbeat-card {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 0, 85, 0.2);
            }

            50% {
                transform: scale(1.01);
                box-shadow: 0 0 20px 0 rgba(255, 0, 85, 0.4);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 0, 85, 0.2);
            }
        }

        /* Glitch Effect */
        .glitch-flash {
            animation: glitch 0.2s infinite;
        }

        @keyframes glitch {
            0% {
                opacity: 1;
                transform: translate(0);
            }

            20% {
                opacity: 0.8;
                transform: translate(-2px, 2px);
            }

            80% {
                opacity: 0.9;
                transform: translate(2px, -2px);
            }

            100% {
                opacity: 1;
                transform: translate(0);
            }
        }

        @media (max-width: 1024px) {

            /* Section 1: Chuyển Totems thành Carousel ngang */
            .totems-wrapper {
                display: flex !important;
                flex-direction: row !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory;
                gap: 2rem !important;
                padding: 40px 20px !important;
                scrollbar-width: none;
                -webkit-overflow-scrolling: touch;
            }

            .totems-wrapper::-webkit-scrollbar {
                display: none;
            }

            .totem-item {
                flex: 0 0 80vw;
                /* Chiếm 80% màn hình để lộ thẻ tiếp theo */
                scroll-snap-align: center;
                display: flex;
                justify-content: center;
            }

            /* Section 2: Tối ưu thẻ đấu giá trên Tablet */
            .auction-card .flex-col.lg\:flex-row {
                gap: 1.5rem;
            }

            #live-war-room .auction-card .flex-col {
                gap: 1.5rem;
            }
        }

        /* Mobile Stacking Layout */
        @media (max-width: 768px) {
            .auction-card {
                padding: 1.5rem !important;
            }

            .countdown-timer {
                font-size: 2.25rem !important;
            }

            .bid-btn {
                font-size: 11px !important;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */
        .inter-light {
            font-family: 'Inter', sans-serif;
            font-weight: 300;
        }

        /* Hiệu ứng Shine vệt sáng chạy xéo */
        .shine-effect {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0) 45%,
                    rgba(255, 255, 255, 0.4) 50%,
                    rgba(255, 255, 255, 0) 55%,
                    rgba(255, 255, 255, 0) 100%);
            background-size: 250% 250%;
            animation: shine-swipe 4s infinite linear;
        }

        @keyframes shine-swipe {
            0% {
                background-position: 200% 200%;
            }

            100% {
                background-position: -200% -200%;
            }
        }

        /* Tối ưu Mobile */
        @media (max-width: 768px) {
            .timeline-axis {
                left: 20px !important;
            }

            .timeline-row {
                padding-left: 50px;
                margin-bottom: 2rem;
            }

            .timeline-node {
                left: 20px !important;
                display: block !important;
            }

            /* Mobile ribbon indicator */
            .auction-card-chrono::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
            }

            .auction-card-chrono.triumph::before {
                background: #C5A059;
            }

            .auction-card-chrono.memory::before {
                background: #333;
            }
        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="battle-summary" class="relative min-h-screen flex items-center justify-center py-20 px-6 bg-[#000814] overflow-hidden">
        <div class="nebula-bg absolute inset-0 opacity-40 pointer-events-none"></div>

        <div class="container mx-auto max-w-7xl relative z-10">
            <div class="text-center mb-16 md:mb-24">
                <h2 class="text-[10px] tracking-[8px] text-cyan-400 uppercase mb-4 opacity-70">Auction Intelligence</h2>
                <h1 class="serif text-4xl md:text-6xl text-white font-light">Tổng Kết <span class="text-white/50 italic">Chiến Tích</span></h1>
            </div>

            <div class="totems-wrapper flex flex-col lg:flex-row items-center justify-around gap-16 lg:gap-8">

                <div class="totem-item group relative" data-speed="0.05">
                    <div class="sphere-glass relative w-64 h-64 md:w-72 md:h-72 rounded-full border border-white/10 backdrop-blur-sm flex flex-col items-center justify-center overflow-hidden shadow-[0_0_50px_rgba(0,255,255,0.1)]">
                        <div class="liquid-fill absolute bottom-0 left-0 w-full bg-gradient-to-t from-cyan-500/40 to-cyan-300/10" data-percent="75"></div>
                        <div class="relative z-10 text-center">
                            <p class="text-[10px] text-silver tracking-[3px] uppercase mb-2">The Victor</p>
                            <span class="space-mono text-5xl md:text-6xl text-white font-bold counter" data-target="24">0</span>
                            <p class="text-[9px] text-cyan-400/60 mt-2 uppercase">Cuộc đấu thành công</p>
                        </div>
                    </div>
                    <div class="extra-stats absolute -top-10 -right-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
                        <p class="text-[10px] text-white/40 space-mono">Hụt: 12 lượt</p>
                    </div>
                </div>

                <div class="totem-item group relative" data-speed="-0.03">
                    <div class="sphere-glass relative w-64 h-64 md:w-72 md:h-72 rounded-full border border-white/10 backdrop-blur-sm flex flex-col items-center justify-center overflow-hidden shadow-[0_0_50px_rgba(138,43,226,0.15)]">
                        <div class="liquid-fill absolute bottom-0 left-0 w-full bg-gradient-to-t from-violet-600/40 to-cyan-400/10" data-percent="68"></div>
                        <div class="relative z-10 text-center p-4">
                            <p class="text-[10px] text-silver tracking-[3px] uppercase mb-2">The Strategy</p>
                            <span class="space-mono text-5xl md:text-6xl text-white font-bold counter" data-target="68">0</span><span class="text-2xl text-white">%</span>
                            <p class="text-[9px] text-cyan-400/60 mt-2 uppercase">Win Rate</p>
                        </div>
                        <svg class="absolute inset-0 w-full h-full -rotate-90">
                            <circle cx="50%" cy="50%" r="48%" stroke="rgba(0, 255, 255, 0.1)" stroke-width="2" fill="none" />
                            <circle class="progress-ring" cx="50%" cy="50%" r="48%" stroke="#00ffff" stroke-width="2" fill="none" stroke-dasharray="1000" stroke-dashoffset="1000" />
                        </svg>
                    </div>
                </div>

                <div class="totem-item group relative" data-speed="0.04">
                    <div class="sphere-glass relative w-64 h-64 md:w-72 md:h-72 rounded-full border border-white/10 backdrop-blur-sm flex flex-col items-center justify-center overflow-hidden shadow-[0_0_50px_rgba(0,127,255,0.1)]">
                        <div class="liquid-fill absolute bottom-0 left-0 w-full bg-gradient-to-t from-blue-600/40 to-cyan-400/10" data-percent="45"></div>
                        <div class="relative z-10 text-center">
                            <p class="text-[10px] text-silver tracking-[3px] uppercase mb-2">The Capital</p>
                            <div class="flex flex-col items-center">
                                <span class="space-mono text-3xl md:text-4xl text-white font-bold">1.2B</span>
                                <p class="text-[9px] text-cyan-400/60 mt-2 uppercase italic text-center">Tiền cọc hệ thống</p>
                            </div>
                        </div>
                    </div>
                    <div class="extra-stats absolute -bottom-10 -left-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none text-right">
                        <p class="text-[10px] text-white/40 space-mono">Hoàn: 850M</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="live-war-room" class="relative min-h-screen py-16 md:py-24 px-4 md:px-6 bg-[#000814] overflow-hidden">
        <div class="container mx-auto max-w-6xl relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 border-b border-white/10 pb-6 gap-4">
                <div class="text-center md:text-left">
                    <h2 class="text-[10px] tracking-[5px] text-red-500 uppercase mb-2">Live Situation</h2>
                    <h3 class="serif text-3xl md:text-4xl text-white">Phòng <span class="text-red-500">Lệnh Chiến</span></h3>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-[10px] text-white/40 space-mono">STRIKE TIME: 22:45:01</p>
                    <p class="text-xs text-emerald-400">Hệ thống bảo mật Quantum</p>
                </div>
            </div>

            <div class="war-room-container flex flex-col gap-6">

                <div id="card-1" class="auction-card leading group relative bg-[#050505] rounded-2xl p-5 md:p-6 border border-[#00FFC2]/20 transition-all duration-500">
                    <div class="relative z-10 flex flex-col lg:flex-row items-center gap-6 lg:gap-8">
                        <div class="w-full lg:w-1/4">
                            <div class="plate-render bg-gradient-to-br from-white/10 to-transparent p-4 rounded-xl border border-white/5 shadow-2xl">
                                <div class="text-center">
                                    <p class="text-white/20 text-[8px] uppercase tracking-tighter mb-1">TP. Hồ Chí Minh</p>
                                    <p class="space-mono text-2xl md:text-3xl text-white font-bold tracking-tighter">30K-999.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/3 text-center">
                            <p class="text-[9px] text-white/30 uppercase tracking-[3px] mb-2">Thời gian còn lại</p>
                            <div class="countdown-timer font-mono text-3xl md:text-5xl text-white tracking-widest" data-time="3600">00:59:42</div>
                        </div>
                        <div class="w-full lg:w-2/5 flex flex-col sm:flex-row items-center justify-between lg:justify-end gap-6">
                            <div class="text-center lg:text-right">
                                <p class="text-[9px] text-[#00FFC2] uppercase mb-1">Giá hiện tại (Leading)</p>
                                <div class="price-wrapper relative overflow-hidden h-8 md:h-10">
                                    <span class="current-price block text-2xl md:text-3xl text-white font-bold space-grotesk">1,250,000,000</span>
                                </div>
                            </div>
                            <button class="bid-btn w-full sm:w-auto px-8 py-4 bg-white/5 backdrop-blur-md border border-[#00FFC2]/50 rounded-xl text-[#00FFC2] text-xs font-bold hover:bg-[#00FFC2] hover:text-black transition-all">NÂNG GIÁ NHANH</button>
                        </div>
                    </div>
                </div>

                <div id="card-2" class="auction-card outbid outbid-pulse group relative bg-[#050505] rounded-2xl p-5 md:p-6 border border-[#FF0055]/30 transition-all duration-500">
                    <div class="relative z-10 flex flex-col lg:flex-row items-center gap-6 lg:gap-8">
                        <div class="w-full lg:w-1/4">
                            <div class="plate-render bg-gradient-to-br from-red-500/10 to-transparent p-4 rounded-xl border border-red-500/20">
                                <div class="text-center">
                                    <p class="text-white/20 text-[8px] uppercase mb-1">Hà Nội</p>
                                    <p class="space-mono text-2xl md:text-3xl text-white/90 font-bold tracking-tighter">29A-888.88</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/3 text-center">
                            <p class="text-[9px] text-red-500 uppercase tracking-[3px] mb-2 animate-pulse">Critical Time</p>
                            <div class="countdown-timer font-mono text-3xl md:text-5xl text-red-500" data-time="45">00:00:45</div>
                        </div>
                        <div class="w-full lg:w-2/5 flex flex-col sm:flex-row items-center justify-between lg:justify-end gap-6">
                            <div class="text-center lg:text-right">
                                <p class="text-[9px] text-red-500 uppercase mb-1">Bị vượt mặt!</p>
                                <span class="text-2xl md:text-3xl text-white font-bold">2,100,000,000</span>
                            </div>
                            <button class="bid-btn w-full sm:w-auto px-8 py-4 bg-red-500/20 backdrop-blur-md border border-red-500 rounded-xl text-red-500 text-xs font-bold hover:bg-red-500 hover:text-white transition-all">LẤY LẠI VỊ THẾ</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="auction-chronology" class="relative min-h-screen py-24 bg-[#000814] overflow-hidden">
        <div class="container mx-auto max-w-6xl relative px-6">

            <div class="text-center mb-20">
                <h2 class="text-[10px] tracking-[5px] text-cyan-400 uppercase mb-4">The Timeless Axis</h2>
                <h3 class="serif text-5xl text-white font-light">Hành Trình <span class="italic text-white/60">Di Sản</span></h3>
            </div>

            <div class="relative">
                <div class="timeline-axis absolute left-4 md:left-1/2 top-0 bottom-0 w-[1px] bg-gradient-to-b from-transparent via-cyan-500/50 to-transparent transform md:-translate-x-1/2"></div>

                <div class="space-y-24">

                    <div class="timeline-row flex flex-col md:flex-row items-center justify-between w-full">
                        <div class="timeline-card-wrapper w-full md:w-[45%] order-2 md:order-1">
                            <div class="auction-card-chrono triumph group relative p-6 bg-gradient-to-br from-white/10 to-transparent border border-white/20 rounded-2xl overflow-hidden shadow-2xl">
                                <div class="shine-effect absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100"></div>
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="inter-light text-[10px] text-white/50 tracking-widest uppercase">12 OCT 2025</span>
                                        <i class="ri-medal-fill text-[#C5A059] text-xl"></i>
                                    </div>
                                    <h4 class="space-mono text-3xl text-white font-bold mb-2">51K-888.88</h4>
                                    <div class="flex justify-between items-center mt-6">
                                        <span class="text-[10px] text-cyan-400 tracking-tighter">FINAL BID:</span>
                                        <span class="space-mono text-white text-lg font-bold">4,250,000,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-node absolute left-4 md:left-1/2 w-3 h-3 bg-cyan-400 rounded-full shadow-[0_0_15px_rgba(34,211,238,0.8)] transform -translate-x-1/2 z-10 hidden md:block"></div>
                        <div class="w-full md:w-[45%] order-1 md:order-2"></div>
                    </div>

                    <div class="timeline-row flex flex-col md:flex-row items-center justify-between w-full">
                        <div class="w-full md:w-[45%] order-1"></div>
                        <div class="timeline-node absolute left-4 md:left-1/2 w-3 h-3 bg-white/20 rounded-full transform -translate-x-1/2 z-10 hidden md:block"></div>
                        <div class="timeline-card-wrapper w-full md:w-[45%] order-2">
                            <div class="auction-card-chrono memory group relative p-6 bg-white/5 border border-white/5 rounded-2xl opacity-60 hover:opacity-100 transition-all duration-500">
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="inter-light text-[10px] text-white/30 tracking-widest uppercase">28 SEP 2025</span>
                                        <span class="text-[10px] text-white/20 italic opacity-0 group-hover:opacity-100 transition-opacity">Gần chạm tới di sản</span>
                                    </div>
                                    <h4 class="space-mono text-3xl text-white/60 group-hover:text-white font-bold mb-2">30L-123.45</h4>
                                    <div class="flex justify-between items-center mt-6">
                                        <span class="text-[10px] text-white/20 tracking-tighter">MISSED AT:</span>
                                        <span class="space-mono text-white/40 group-hover:text-white text-lg">950,000,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-row flex flex-col md:flex-row items-center justify-between w-full">
                        <div class="timeline-card-wrapper w-full md:w-[45%] order-2 md:order-1">
                            <div class="auction-card-chrono triumph group relative p-6 bg-gradient-to-br from-[#C5A059]/10 to-transparent border border-[#C5A059]/30 rounded-2xl overflow-hidden">
                                <div class="shine-effect absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100"></div>
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="inter-light text-[10px] text-[#C5A059] tracking-widest uppercase">15 AUG 2025</span>
                                        <i class="ri-vip-diamond-fill text-[#C5A059] text-xl"></i>
                                    </div>
                                    <h4 class="space-mono text-3xl text-white font-bold mb-2">99A-999.99</h4>
                                    <div class="flex justify-between items-center mt-6">
                                        <span class="text-[10px] text-[#C5A059] tracking-tighter uppercase">Exquisite Asset:</span>
                                        <span class="space-mono text-white text-lg">12,000,000,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-node absolute left-4 md:left-1/2 w-3 h-3 bg-cyan-400 rounded-full transform -translate-x-1/2 z-10 hidden md:block"></div>
                        <div class="w-full md:w-[45%] order-1 md:order-2"></div>
                    </div>

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
        // 1. Hiệu ứng Liquid Fill dâng trào
        gsap.utils.toArray('.liquid-fill').forEach(liquid => {
            const targetPercent = liquid.getAttribute('data-percent');
            gsap.fromTo(liquid, {
                height: "0%"
            }, {
                height: targetPercent + "%",
                duration: 3,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: "#battle-summary",
                    start: "top 60%"
                }
            });
        });

        // 2. Nhảy số (Counter)
        gsap.utils.toArray('.counter').forEach(el => {
            const target = el.getAttribute('data-target');
            ScrollTrigger.create({
                trigger: el,
                onEnter: () => {
                    gsap.to(el, {
                        innerText: target,
                        duration: 2.5,
                        snap: {
                            innerText: 1
                        },
                        ease: "power1.out"
                    });
                }
            });
        });

        // 3. Parallax Mouse Move (Desktop)
        if (window.innerWidth > 1024) {
            document.addEventListener('mousemove', (e) => {
                const {
                    clientX,
                    clientY
                } = e;
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;

                gsap.utils.toArray('.totem-item').forEach(item => {
                    const speed = item.getAttribute('data-speed');
                    const x = (clientX - centerX) * speed;
                    const y = (clientY - centerY) * speed;
                    gsap.to(item, {
                        x: x,
                        y: y,
                        duration: 1,
                        ease: "power2.out"
                    });
                });
            });
        }

        // 4. Pulse Glow Loop (3 giây/lần)
        setInterval(() => {
            const spheres = document.querySelectorAll('.sphere-glass');
            spheres.forEach(sphere => {
                const ring = document.createElement('div');
                ring.className = 'pulse-ring absolute inset-0';
                sphere.appendChild(ring);

                gsap.to(ring, {
                    scale: 1.5,
                    opacity: 0,
                    duration: 2,
                    ease: "power1.out",
                    onComplete: () => ring.remove()
                });
            });
        }, 3000);

        // 5. Mobile Haptic & Scale
        if (window.innerWidth <= 1024) {
            const wrapper = document.querySelector('.totems-wrapper');
            wrapper.addEventListener('scroll', () => {
                // Logic để tìm khối cầu trung tâm và zoom lớn + rung nhẹ
                // (Sử dụng Intersection Observer hoặc đơn giản là kiểm tra scrollLeft)
                if (window.navigator.vibrate) window.navigator.vibrate(5);
            });
        }
    });

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const isMobile = window.innerWidth <= 768;

        // 1. Hàm cập nhật giá (Gọi thủ công khi cần)
        window.updatePrice = function(cardId, newPrice) {
            const card = document.querySelector(cardId);
            if (!card) return;
            const priceWrapper = card.querySelector('.price-wrapper');
            const oldPrice = priceWrapper.querySelector('.current-price');

            const nextPrice = document.createElement('span');
            nextPrice.className = 'current-price block text-2xl md:text-3xl text-white font-bold space-grotesk absolute top-full left-0 w-full';
            nextPrice.innerText = newPrice;
            priceWrapper.appendChild(nextPrice);

            gsap.to(oldPrice, {
                y: -40,
                opacity: 0,
                duration: 0.4,
                onComplete: () => oldPrice.remove()
            });
            gsap.to(nextPrice, {
                y: -40,
                opacity: 1,
                duration: 0.4
            });
        };

        // 2. Logic Countdown & Rung Mobile
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(timer => {
            let time = parseInt(timer.getAttribute('data-time'));
            if (time < 60) {
                // Hiệu ứng cảnh báo khẩn cấp
                gsap.to(timer, {
                    opacity: 0.5,
                    repeat: -1,
                    yoyo: true,
                    duration: 0.5
                });

                if (isMobile && window.navigator.vibrate) {
                    // Rung nhẹ khi load nếu có kèo khẩn cấp
                    window.navigator.vibrate([100, 50, 100]);
                }
            }
        });

        // 3. Phản hồi Touch cho nút bấm
        if (isMobile) {
            document.querySelectorAll('.bid-btn').forEach(btn => {
                btn.addEventListener('touchstart', () => gsap.to(btn, {
                    scale: 0.95,
                    duration: 0.1
                }));
                btn.addEventListener('touchend', () => {
                    gsap.to(btn, {
                        scale: 1,
                        duration: 0.1
                    });
                    if (window.navigator.vibrate) window.navigator.vibrate(20);
                });
            });
        }
    });

    // ----------------------------- section 3 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const rows = gsap.utils.toArray('.timeline-row');

        rows.forEach((row) => {
            const card = row.querySelector('.timeline-card-wrapper');
            const node = row.querySelector('.timeline-node');
            const isLeft = card.parentElement.querySelector(':nth-child(3)') === card; // Logic hướng

            // Animation cho từng thẻ khi cuộn đến
            gsap.from(card, {
                x: isLeft ? 100 : -100, // Bay từ ngoài vào trung tâm
                opacity: 0,
                duration: 1.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: row,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse"
                }
            });

            // Animation cho điểm nút rực sáng
            if (node) {
                gsap.from(node, {
                    scale: 0,
                    backgroundColor: "#fff",
                    boxShadow: "0 0 0px #fff",
                    scrollTrigger: {
                        trigger: row,
                        start: "top 80%",
                        onEnter: () => gsap.to(node, {
                            scale: 1.5,
                            backgroundColor: "#22d3ee",
                            boxShadow: "0 0 20px #22d3ee",
                            duration: 0.5
                        })
                    }
                });
            }
        });

        // Desktop Hover Effect: Zoom trục thời gian
        if (window.innerWidth > 1024) {
            document.querySelectorAll('.auction-card-chrono').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    gsap.to(card, {
                        scale: 1.05,
                        duration: 0.4,
                        ease: "back.out(1.7)"
                    });
                });
                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        scale: 1,
                        duration: 0.4
                    });
                });
            });
        }
    });

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>