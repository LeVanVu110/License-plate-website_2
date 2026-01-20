<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Relic Showcase | Biển Số Di Sản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --midnight: #000F1A;
            --electric-blue: #007FFF;
            --cyan-neon: #00f2ff;
        }

        body {
            background-color: var(--midnight);
            margin: 0;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Hiệu ứng bệ kính Sapphire */
        .sapphire-stage {
            background: radial-gradient(circle at center, rgba(0, 127, 255, 0.2) 0%, transparent 70%);
            perspective: 1000px;
        }

        .glass-platform {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -20px 50px rgba(0, 242, 255, 0.15);
            transform: rotateX(60deg);
        }

        /* Thiết kế biển số 3D */
        .relic-card {
            width: 280px;
            /* Tỷ lệ 190x140mm rút gọn */
            height: 206px;
            background: #f0f0f0;
            border-radius: 12px;
            position: relative;
            transform-style: preserve-3d;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            border: 4px solid #333;
        }

        /* Độ dày vật lý của biển số */
        .relic-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #999;
            transform: translateZ(-5px);
            border-radius: 12px;
        }

        .plate-content {
            padding: 20px;
            text-align: center;
            color: #1a1a1a;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #fff 0%, #e0e0e0 100%);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        /* Hiệu ứng tia sáng quét ngang (Sapphire Glimmer) */
        .scanline {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(0, 242, 255, 0.4), transparent);
            transform: skewX(-25deg);
        }

        /* Floating HUD Lines */
        .hud-line {
            position: absolute;
            background: var(--cyan-neon);
            opacity: 0.4;
            pointer-events: none;
        }

        .custom-cursor {
            width: 100px;
            height: 100px;
            border: 1px solid var(--cyan-neon);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            transform: translate(-50%, -50%);
            display: none;
        }

        @media (min-width: 1024px) {
            .custom-cursor {
                display: flex;
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
    <div class="custom-cursor" id="cursor">
        <span class="text-[8px] text-cyan-400 font-bold tracking-widest uppercase">Drag to Rotate</span>
    </div>

    <section class="relative min-h-screen flex flex-col lg:flex-row items-center justify-center p-6 sapphire-stage overflow-hidden">

        <div class="absolute top-0 left-1/4 w-[1px] h-screen bg-gradient-to-b from-cyan-500/20 to-transparent"></div>
        <div class="absolute top-0 right-1/4 w-[1px] h-screen bg-gradient-to-b from-cyan-500/20 to-transparent"></div>

        <div class="relative flex-1 flex flex-col items-center justify-center z-10 w-full">

            <div id="hud-top" class="absolute top-[-40px] left-[-20px] text-cyan-400 font-mono text-[10px] opacity-0">
                <p>[ REGION_CODE: 29-G1 ]</p>
                <div class="hud-line h-[1px] w-20 origin-left mt-1"></div>
            </div>

            <div id="hud-bottom" class="absolute bottom-[-40px] right-[-20px] text-cyan-400 font-mono text-[10px] opacity-0 text-right">
                <div class="hud-line h-[1px] w-20 origin-right mb-1 ml-auto"></div>
                <p>[ STATUS: LEGENDARY_RELIC ]</p>
            </div>

            <div id="relic-wrapper" class="relative cursor-grab active:cursor-grabbing">
                <div class="relic-card" id="plate">
                    <div class="plate-content">
                        <div class="scanline" id="scan-effect"></div>
                        <p class="text-3xl font-bold tracking-widest font-mono">29-G1</p>
                        <p class="text-5xl font-extrabold tracking-tighter font-mono mt-2">888.88</p>
                    </div>
                </div>
            </div>

            <div class="glass-platform w-[300px] h-[300px] rounded-full mt-[-60px] z-[-1]"></div>
        </div>

        <div class="w-full lg:w-1/3 flex flex-col gap-8 z-20 mt-12 lg:mt-0">
            <div class="space-y-2">
                <h4 class="text-cyan-500 font-mono text-xs tracking-[0.3em] uppercase italic">Current Valuation</h4>
                <h2 class="text-5xl lg:text-6xl font-bold text-white tracking-tighter">850.000.000<span class="text-cyan-400 text-2xl">₫</span></h2>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white/5 border border-white/10 p-4 rounded-xl backdrop-blur-md">
                    <p class="text-gray-500 text-[10px] uppercase font-bold">Mã vùng</p>
                    <p class="text-white font-mono">Hà Nội (G1)</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-4 rounded-xl backdrop-blur-md">
                    <p class="text-gray-500 text-[10px] uppercase font-bold">Độ hiếm</p>
                    <p class="text-cyan-400 font-mono font-bold">9.9/10</p>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <button class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-4 rounded-full transition-all shadow-[0_0_30px_rgba(0,242,255,0.3)] uppercase tracking-widest text-sm">
                    Sở hữu báu vật ngay
                </button>
                <div class="flex gap-3">
                    <button class="flex-1 bg-white/5 hover:bg-white/10 text-white py-3 rounded-full border border-white/10 transition-all text-xs uppercase font-bold">
                        <i class="ri-heart-line mr-2"></i> Lưu báu vật
                    </button>
                    <button class="flex-1 bg-white/5 hover:bg-white/10 text-white py-3 rounded-full border border-white/10 transition-all text-xs uppercase font-bold">
                        <i class="ri-share-forward-line mr-2"></i> Chia sẻ
                    </button>
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
    // 1. Khởi tạo hiệu ứng Entrance Reveal
    window.addEventListener('load', () => {
        const tl = gsap.timeline();

        tl.from("#plate", {
                scale: 0,
                rotateY: 180,
                duration: 1.5,
                ease: "back.out(1.7)"
            })
            .to("#hud-top, #hud-bottom", {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.2
            }, "-=0.5");

        // 2. Hiệu ứng "The 360° Float" (Chuyển động tự do)
        gsap.to("#plate", {
            y: -15,
            rotateX: 5,
            rotateZ: 2,
            duration: 3,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 3. Hiệu ứng Sapphire Glimmer (Tia sáng quét)
        setInterval(() => {
            gsap.fromTo("#scan-effect", {
                left: "-100%"
            }, {
                left: "200%",
                duration: 1,
                ease: "power2.inOut"
            });
        }, 5000);
    });

    // 4. Tương tác Magnetic Tilt & Cursor
    const plate = document.getElementById('plate');
    const cursor = document.getElementById('cursor');

    if (window.innerWidth >= 1024) {
        document.addEventListener('mousemove', (e) => {
            // Custom Cursor logic
            gsap.to(cursor, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.1
            });

            // Tilt logic
            const xPos = (e.clientX / window.innerWidth) - 0.5;
            const yPos = (e.clientY / window.innerHeight) - 0.5;

            gsap.to(plate, {
                rotateY: xPos * 40,
                rotateX: -yPos * 40,
                duration: 0.6,
                ease: "power2.out"
            });
        });
    }

    // 5. Mobile Touch Rotate (Inertia)
    Draggable.create("#plate", {
        type: "rotation,x,y",
        inertia: true,
        onDrag: function() {
            // Rung nhẹ khi xoay đến góc chính diện (0 độ)
            if (Math.abs(this.rotation % 360) < 5) {
                if (window.navigator.vibrate) window.navigator.vibrate(10);
            }
        }
    });

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>