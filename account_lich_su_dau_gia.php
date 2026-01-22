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

        /* ----------------------------- section 3 -----------------------------  */

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

    <!-- ----------------------------- section 3 -----------------------------  -->

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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>