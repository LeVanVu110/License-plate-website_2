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

        /* ----------------------------- section 3 -----------------------------  */

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

    <!-- ----------------------------- section 3 -----------------------------  -->

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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>