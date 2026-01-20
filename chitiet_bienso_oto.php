<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Grand Reveal | Biển Số Ô Tô Di Sản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/InertiaPlugin.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --midnight-abyss: #00040A;
            --sapphire-blue: #0066FF;
            --cyan-neon: #00f2ff;
        }

        body {
            background-color: var(--midnight-abyss);
            margin: 0;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            color: white;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Sân khấu chính */
        .stage-container {
            perspective: 2000px;
            background: radial-gradient(circle at 50% 50%, #001529 0%, var(--midnight-abyss) 80%);
        }

        /* Bệ đỡ Obsidian 3D */
        .pedestal-3d {
            width: 400px;
            height: 40px;
            background: linear-gradient(145deg, #1a1a1a, #000);
            border-top: 1px solid rgba(0, 102, 255, 0.3);
            box-shadow: 0 0 50px rgba(0, 102, 255, 0.2), inset 0 0 20px rgba(0, 0, 0, 1);
            transform: rotateX(60deg);
            position: relative;
        }

        .pedestal-halo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            background: radial-gradient(ellipse, rgba(0, 102, 255, 0.4) 0%, transparent 70%);
            filter: blur(20px);
        }

        /* Biển số Ô tô dài (530x110mm) */
        .car-plate-3d {
            width: 530px;
            height: 110px;
            background: #f0f0f0;
            border-radius: 4px;
            position: relative;
            transform-style: preserve-3d;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
            border: 3px solid #333;
            overflow: hidden;
            cursor: grab;
        }

        /* Giả lập lớp Chrome Chrome phản chiếu */
        .plate-chrome-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, transparent 50%, rgba(0, 102, 255, 0.1) 100%);
            z-index: 5;
            pointer-events: none;
        }

        .plate-content {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 0 20px;
        }

        /* Chữ mạ Chrome Xanh */
        .plate-number {
            font-family: 'Space Mono', monospace;
            font-weight: 900;
            font-size: 60px;
            color: #1a1a1a;
            letter-spacing: 5px;
            background: linear-gradient(to bottom, #111 0%, var(--sapphire-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(2px 2px 2px rgba(0, 0, 0, 0.2));
        }

        /* Aurora Borealis Scan Effect */
        .aurora-scan {
            position: absolute;
            top: 0;
            left: -100%;
            width: 40%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(0, 242, 255, 0.2), rgba(0, 255, 127, 0.1), transparent);
            transform: skewX(-30deg);
            z-index: 6;
        }

        /* Holographic HUD Lines */
        .hud-line {
            position: absolute;
            background: var(--cyan-neon);
            opacity: 0.5;
            height: 1px;
            transform-origin: left;
        }

        /* Custom Cursor */
        .cursor-glow {
            width: 40px;
            height: 40px;
            background: var(--cyan-neon);
            border-radius: 50%;
            filter: blur(15px);
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .car-plate-3d {
                width: 320px;
                height: 70px;
            }

            .plate-number {
                font-size: 32px;
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
    <div class="cursor-glow" id="mouseGlow"></div>

    <section class="stage-container relative min-h-screen flex flex-col lg:flex-row items-center justify-center p-6 overflow-hidden">

        <div class="relative flex-[2] flex flex-col items-center justify-center h-full">

            <div id="hud-price" class="absolute top-[15%] left-[10%] opacity-0">
                <p class="font-mono text-[10px] text-cyan-400 tracking-widest uppercase">Current Value</p>
                <div class="text-4xl font-bold text-white neon-value" id="price-stream">5.800.000.000₫</div>
                <div class="hud-line w-32 mt-2"></div>
            </div>

            <div id="hud-region" class="absolute bottom-[20%] right-[10%] opacity-0 text-right">
                <p class="font-mono text-[10px] text-cyan-400 tracking-widest uppercase">Region Code</p>
                <div class="text-2xl font-bold text-white uppercase">TP. Hồ Chí Minh</div>
                <div class="hud-line w-32 mt-2 ml-auto origin-right"></div>
            </div>

            <div id="plate-wrapper" class="relative z-20 mb-[-20px]">
                <div class="car-plate-3d" id="carPlate">
                    <div class="plate-chrome-overlay" id="chromeLight"></div>
                    <div class="aurora-scan" id="auroraEffect"></div>
                    <div class="plate-content">
                        <span class="plate-number">30K - 888.88</span>
                    </div>
                </div>
            </div>

            <div id="pedestal" class="pedestal-3d flex items-center justify-center">
                <div class="pedestal-halo"></div>
            </div>
        </div>

        <div class="flex-1 w-full lg:max-w-md z-30 space-y-8 bg-black/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5">
            <div>
                <h1 class="text-cyan-500 font-mono text-xs tracking-[0.5em] uppercase mb-2">Grand Reveal</h1>
                <h2 class="text-4xl font-extralight tracking-tighter">THE SOVEREIGN <br><strong class="font-bold">EIGHTS</strong></h2>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button class="bg-white/5 hover:bg-cyan-500/20 border border-white/10 p-4 rounded-xl transition-all group">
                    <i class="ri-ruler-2-line text-cyan-400 mb-2 block"></i>
                    <span class="text-[10px] uppercase font-bold text-gray-400 group-hover:text-white">Biển dài</span>
                </button>
                <button class="bg-white/5 hover:bg-cyan-500/20 border border-white/10 p-4 rounded-xl transition-all group">
                    <i class="ri-drag-move-fill text-cyan-400 mb-2 block"></i>
                    <span class="text-[10px] uppercase font-bold text-gray-400 group-hover:text-white">Xoay 360°</span>
                </button>
            </div>

            <div class="space-y-4">
                <button class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-5 rounded-full shadow-[0_0_30px_rgba(0,242,255,0.3)] transition-all uppercase tracking-widest text-sm">
                    Đặt cọc ngay
                </button>
                <p class="text-center text-[10px] text-gray-500 font-mono">Bảo mật giao dịch bởi Blockchain Ledger</p>
            </div>
        </div>
    </section>

    <div class="fixed bottom-0 left-0 w-full p-4 lg:hidden z-[999] bg-black/60 backdrop-blur-md border-t border-white/10">
        <button class="w-full bg-cyan-600 text-white py-4 rounded-xl font-bold uppercase tracking-widest text-xs">
            Đặt cọc sở hữu
        </button>
    </div>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // Khởi tạo hiệu ứng GSAP
    window.addEventListener('load', () => {
        const tl = gsap.timeline();

        // 1. "The Genesis Spin" - Khởi tạo bệ và biển số
        tl.from("#pedestal", {
                rotateY: 360,
                scale: 0,
                duration: 2,
                ease: "expo.out"
            })
            .from("#carPlate", {
                y: -500,
                opacity: 0,
                scale: 0.5,
                duration: 1.5,
                ease: "bounce.out"
            }, "-=1")
            .to("#hud-price, #hud-region", {
                opacity: 1,
                duration: 1,
                stagger: 0.3
            });

        // 2. Chuyển động lơ lửng (Floating)
        gsap.to("#carPlate", {
            y: -15,
            duration: 2.5,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 3. Aurora Borealis Scan - Mỗi 8 giây
        setInterval(() => {
            gsap.fromTo("#auroraEffect", {
                left: "-100%"
            }, {
                left: "200%",
                duration: 2,
                ease: "power2.inOut"
            });
        }, 8000);

        // 4. Particle Swarm (Giả lập bằng chữ số nhảy)
        function animatePrice() {
            const priceEl = document.getElementById('price-stream');
            let target = 5800000000;
            let current = {
                val: 0
            };
            gsap.to(current, {
                val: target,
                duration: 3,
                onUpdate: () => {
                    priceEl.innerText = Math.floor(current.val).toLocaleString() + "₫";
                }
            });
        }
        animatePrice();
    });

    // 5. Tương tác Dynamic Chrome Reflection & Tilt
    const plate = document.getElementById('carPlate');
    const chrome = document.getElementById('chromeLight');
    const glow = document.getElementById('mouseGlow');

    document.addEventListener('mousemove', (e) => {
        // Mouse Glow
        gsap.to(glow, {
            x: e.clientX,
            y: e.clientY,
            duration: 0.2
        });

        const xPos = (e.clientX / window.innerWidth) - 0.5;
        const yPos = (e.clientY / window.innerHeight) - 0.5;

        // Xoay biển số theo chuột (Tilt)
        gsap.to(plate, {
            rotateY: xPos * 30,
            rotateX: -yPos * 20,
            duration: 0.5
        });

        // Di chuyển luồng sáng phản chiếu (Chrome reflection)
        gsap.to(chrome, {
            x: xPos * 100,
            y: yPos * 50,
            duration: 0.5
        });
    });

    // 6. Gyroscope (Mobile)
    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', (e) => {
            if (window.innerWidth < 1024) {
                const tiltX = e.gamma; // Trái-phải
                const tiltY = e.beta; // Trước-sau
                gsap.to(plate, {
                    rotateY: tiltX / 2,
                    rotateX: (tiltY - 45) / 2,
                    duration: 0.5
                });
            }
        });
    }

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>