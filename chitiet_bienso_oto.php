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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        /* Tối ưu hóa hiển thị cho hiệu ứng 3D */
        .perspective-2000 {
            perspective: 2000px;
        }

        /* Sân khấu và bệ đỡ */
        .pedestal-3d {
            width: 450px;
            height: 50px;
            background: linear-gradient(180deg, #111 0%, #000 100%);
            border-top: 1px solid rgba(0, 102, 255, 0.4);
            transform: rotateX(70deg);
            position: relative;
            box-shadow: 0 0 60px rgba(0, 102, 255, 0.2);
            top: 45px;
        }

        .pedestal-halo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140%;
            height: 140%;
            background: radial-gradient(ellipse, rgba(0, 102, 255, 0.3) 0%, transparent 75%);
            filter: blur(40px);
        }

        /* Biển số 3D */
        .car-plate-3d {
            width: 530px;
            height: 110px;
            background: #fff;
            border-radius: 6px;
            position: relative;
            transform-style: preserve-3d;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.9);
            border: 3px solid #222;
            overflow: hidden;
        }

        /* Hiệu ứng Chrome phản chiếu */
        .plate-chrome-overlay {
            position: absolute;
            inset: 0%;
            top: 30% !important;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.7) 0%, transparent 45%, rgba(0, 102, 255, 0.15) 100%);
            z-index: 5;
            pointer-events: none;
            mix-blend-mode: overlay;
        }

        /* Hiệu ứng quét cực quang */
        .aurora-scan {
            position: absolute;
            top: 0;
            left: -150%;
            /* Đẩy xa hơn một chút để khởi động */
            width: 100%;
            /* Tăng độ rộng dải sáng */
            height: 100%;
            /* Làm dải sáng rực rỡ hơn với dải màu cyan/emerald */
            background: linear-gradient(to right,
                    transparent 0%,
                    rgba(0, 242, 255, 0.5) 50%,
                    rgba(0, 255, 127, 0.3) 70%,
                    transparent 100%);
            transform: skewX(-25deg);
            z-index: 10;
            /* Quan trọng: Phải cao hơn .plate-content (mặc định z-index: auto hoặc thấp hơn) */
            pointer-events: none;
        }

        /* Chữ mạ Chrome Xanh */
        .plate-number {
            font-family: 'Space Mono', monospace;
            font-weight: 900;
            font-size: 60px;
            background: linear-gradient(to bottom, #111 0%, #0066FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .plate-content {
            position: relative;
            z-index: 1;
            /* Thấp hơn aurora-scan */
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 0 20px;
        }

        .cursor-glow {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 102, 255, 0.1) 0%, transparent 70%);
            position: fixed;
            pointer-events: none;
            z-index: 1;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        @media (max-width: 1024px) {
            .car-plate-3d {
                width: 320px;
                height: 70px;
            }

            .plate-number {
                font-size: 34px;
            }

            .pedestal-3d {
                width: 300px;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        #radarChart,
        #lineChart {
            filter: drop-shadow(0 0 10px rgba(0, 242, 255, 0.2));
        }

        /* Hiệu ứng xung điện chạy qua Grid System */
        @keyframes gridPulse {
            0% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.3;
            }

            100% {
                opacity: 0.1;
            }
        }

        #sovereignty-metrics .absolute.inset-0 {
            animation: gridPulse 4s infinite ease-in-out;
        }

        /* Parallax hiệu ứng lơ lửng */
        @media (min-width: 1024px) {
            .metric-module:nth-child(1) {
                transform: translateY(20px);
            }

            .metric-module:nth-child(2) {
                transform: translateY(0px);
            }

            .metric-module:nth-child(3) {
                transform: translateY(-20px);
            }
        }

        /* Font kỹ thuật */
        .font-mono {
            font-family: 'Space Mono', monospace;
        }

        /* ----------------------------- section 3 -----------------------------  */
        #prestige-fitting {
            perspective: 1000px;
        }

        .car-btn.active {
            background: rgba(0, 242, 255, 0.1);
            border-color: #00f2ff;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.1);
        }

        .pulse-wave {
            position: absolute;
            inset: -10px;
            /* Tỏa ra ngoài biển số */
            border: 2px solid #00f2ff;
            border-radius: 4px;
            opacity: 0;
            pointer-events: none;
            animation: wavePulse 2s infinite;
        }

        /* Ghi đè lại class car-plate-3d khi nằm trong Section 3 */
        #plate-snap .car-plate-3d {
            width: 100%;
            height: 100%;
            background: #fff;
            border-radius: 2px;
            border: 1px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        @keyframes wavePulse {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        #car-container {
            transform-style: preserve-3d;
            will-change: transform;
        }

        /* Kiểu chữ tiêu đề mẫu xe */
        .font-serif {
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.2em;
        }

        /* Vị trí biển số trên xe (Tùy chỉnh cho từng ảnh xe) */
        #plate-snap {
            top: 50%;
            left: 0%;
            width: 1300px;
            /* Độ rộng ước tính của biển số khi gắn lên xe */
            height: 85%;
            transform-origin: center center;
        }

        /* Wrapper để quản lý tỷ lệ scale */
        .plate-mini-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .plate-number-mini {
            font-family: 'Space Mono', monospace;
            font-weight: 900;
            font-size: 5rem;
            /* Tăng size chữ lên để nhìn rõ */
            background: linear-gradient(to bottom, #111 0%, #0066FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            white-space: nowrap;
        }

        @media (max-width: 1024px) {
            #prestige-fitting {
                padding-top: 40px;
                padding-bottom: 40px;
            }

            /* Biển số nhỏ lại một chút trên Mobile để cân đối với xe */
            #plate-snap {
                top: 100%;
                left: -145%;
            }

            .plate-number-prestige {
                font-size: 15px;
                /* Giảm size chữ để không bị vỡ khung */
            }



            /* Console điều khiển dạng danh sách gọn hơn */
            .car-btn {
                padding: 0.5rem !important;
            }
        }

        /* Hiệu ứng Zoom khi Double Tap (cho Mobile) */
        .zoomed-in {
            transform: scale(1.5) translateY(-20px);
            transition: transform 0.5s ease;

        }

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <div class="cursor-glow" id="mouseGlow"></div>

    <section class="stage-container relative min-h-screen flex flex-col lg:flex-row items-center justify-center p-6 overflow-hidden">
        <div class="relative flex-[2] flex flex-col items-center justify-center h-full min-h-[500px]">

            <div id="hud-price" class="absolute top-[15%] left-[10%] opacity-0 z-30">
                <p class="font-mono text-[10px] text-cyan-400 tracking-widest uppercase">Current Value</p>
                <div class="text-4xl font-bold text-white neon-value" id="price-stream">0₫</div>
                <div class="hud-line w-32 mt-2"></div>
            </div>

            <div id="hud-status" class="absolute top-[15%] right-[10%] opacity-0 z-30 text-right">
                <p class="font-mono text-[10px] text-cyan-400 tracking-widest uppercase">Auction Status</p>
                <div class="text-2xl font-bold text-green-400 uppercase">Live Now</div>
                <div class="hud-line w-32 mt-2 ml-auto origin-right"></div>
            </div>

            <div id="plate-wrapper" class="relative z-20 mb-[-20px] perspective-2000">
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

        <div class="flex-1 w-full lg:max-w-sm z-30 space-y-8 bg-black/40 backdrop-blur-xl p-8 rounded-3xl border border-white/5">
            <div>
                <h1 class="text-cyan-500 font-mono text-xs tracking-[0.5em] uppercase mb-2">Grand Reveal</h1>
                <h2 class="text-4xl font-extralight tracking-tighter text-white">THE SOVEREIGN <br><strong class="font-bold">EIGHTS</strong></h2>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button class="bg-white/5 hover:bg-cyan-500/20 border border-white/10 p-4 rounded-xl transition-all group">
                    <i class="ri-ruler-2-line text-cyan-400 mb-2 block text-xl"></i>
                    <span class="text-[10px] uppercase font-bold text-gray-400 group-hover:text-white">Biển dài (Default)</span>
                </button>
                <button class="bg-white/5 hover:bg-cyan-500/20 border border-white/10 p-4 rounded-xl transition-all group">
                    <i class="ri-drag-move-fill text-cyan-400 mb-2 block text-xl"></i>
                    <span class="text-[10px] uppercase font-bold text-gray-400 group-hover:text-white">Drag to Rotate</span>
                </button>
            </div>

            <div class="space-y-4">
                <button class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-5 rounded-full shadow-[0_0_30px_rgba(0,242,255,0.3)] transition-all uppercase tracking-widest text-sm">
                    ĐẶT CỌC NGAY
                </button>
                <p class="text-center text-[10px] text-gray-500 font-mono">Blockchain Secured Transaction</p>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="sovereignty-metrics" class="relative min-h-screen bg-[#00040A] py-20 overflow-hidden border-t border-white/5">
        <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(#007FFF 1px, transparent 1px), linear-gradient(90deg, #007FFF 1px, transparent 1px); background-size: 50px 50px;"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="mb-16 text-center lg:text-left">
                <h2 class="text-cyan-500 font-mono text-xs tracking-[0.5em] uppercase mb-4">The Sovereignty Metrics</h2>
                <div class="text-3xl md:text-5xl font-light tracking-tighter">PHÂN TÍCH <span class="font-bold italic text-white">DI SẢN SỐ</span></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="metric-module opacity-0 transform translate-y-10 bg-white/5 backdrop-blur-xl p-8 rounded-3xl border border-white/10 hover:border-cyan-500/50 transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl"></div>
                    <h3 class="font-mono text-[10px] text-cyan-400 tracking-[0.3em] uppercase mb-6 flex items-center gap-2">
                        <i class="ri-radar-line"></i> Fortune Matrix
                    </h3>

                    <div class="relative w-full aspect-square flex items-center justify-center">
                        <canvas id="radarChart"></canvas>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-2 text-center">
                        <div class="p-2 border border-white/5 rounded-lg bg-white/5">
                            <div class="text-[8px] text-gray-500 uppercase font-mono">Thiên</div>
                            <div class="text-cyan-400 font-bold text-sm">Hòa</div>
                        </div>
                        <div class="p-2 border border-white/5 rounded-lg bg-white/5">
                            <div class="text-[8px] text-gray-500 uppercase font-mono">Địa</div>
                            <div class="text-cyan-400 font-bold text-sm">Lợi</div>
                        </div>
                        <div class="p-2 border border-white/5 rounded-lg bg-white/5">
                            <div class="text-[8px] text-gray-500 uppercase font-mono">Nhân</div>
                            <div class="text-cyan-400 font-bold text-sm">Thời</div>
                        </div>
                    </div>
                </div>

                <div class="metric-module opacity-0 transform translate-y-10 bg-white/5 backdrop-blur-xl p-8 rounded-3xl border border-white/10 hover:border-cyan-500/50 transition-all duration-500 group">
                    <h3 class="font-mono text-[10px] text-cyan-400 tracking-[0.3em] uppercase mb-6 flex items-center gap-2">
                        <i class="ri-rfid-line"></i> Scarcity Index
                    </h3>

                    <div class="py-10 text-center">
                        <div class="text-7xl font-bold text-white mb-2 leading-none">
                            <span class="random-string" data-value="0.01">00.00</span><span class="text-2xl text-cyan-500">%</span>
                        </div>
                        <p class="text-gray-400 text-xs font-light px-6">Top biển số cực hiếm trong hệ thống định danh quốc gia 2026</p>
                    </div>

                    <div class="space-y-4">
                        <div class="level-bar-group">
                            <div class="flex justify-between text-[10px] mb-1 uppercase tracking-tighter">
                                <span>Độ hiếm ký tự</span>
                                <span class="text-cyan-400">98%</span>
                            </div>
                            <div class="h-[2px] w-full bg-white/10 overflow-hidden">
                                <div class="h-full bg-cyan-500 level-progress" style="width: 0%" data-width="98%"></div>
                            </div>
                        </div>
                        <div class="level-bar-group">
                            <div class="flex justify-between text-[10px] mb-1 uppercase tracking-tighter">
                                <span>Thanh khoản kỳ vọng</span>
                                <span class="text-cyan-400">85%</span>
                            </div>
                            <div class="h-[2px] w-full bg-white/10 overflow-hidden">
                                <div class="h-full bg-cyan-500 level-progress" style="width: 0%" data-width="85%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="metric-module opacity-0 transform translate-y-10 bg-white/5 backdrop-blur-xl p-8 rounded-3xl border border-white/10 hover:border-cyan-500/50 transition-all duration-500 group">
                    <h3 class="font-mono text-[10px] text-cyan-400 tracking-[0.3em] uppercase mb-6 flex items-center gap-2">
                        <i class="ri-line-chart-line"></i> Value Projection
                    </h3>

                    <div class="h-48 w-full mt-4">
                        <canvas id="lineChart"></canvas>
                    </div>

                    <div class="mt-10 p-4 rounded-2xl bg-cyan-500/10 border border-cyan-500/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-[10px] text-cyan-400 uppercase font-mono">Dự báo 2028</div>
                                <div class="text-xl font-bold text-white tracking-tighter">+125% <i class="ri-arrow-right-up-line"></i></div>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-cyan-500 flex items-center justify-center text-black">
                                <i class="ri-hand-coin-line text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="prestige-fitting" class="relative min-h-screen bg-[#000810] overflow-hidden border-t border-white/5">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/80"></div>
            <div class="absolute right-0 top-0 w-1/3 h-full bg-cyan-950/10 blur-[120px]"></div>
        </div>

        <div class="container mx-auto px-6 py-20 relative z-10 h-full flex flex-col">
            <div class="mb-10">
                <h2 class="text-cyan-500 font-mono text-xs tracking-[0.5em] uppercase mb-2">The Prestige Fitting</h2>
                <div class="text-3xl md:text-5xl font-serif tracking-widest text-blue-100 italic" id="car-name">MAYBACH S680</div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12 items-center flex-grow">
                <div class="relative flex-[2] w-full flex items-center justify-center min-h-[400px]" id="studio-scene">
                    <div class="absolute bottom-10 w-[120%] h-32 bg-gradient-to-t from-cyan-900/20 to-transparent rounded-[100%] blur-2xl transform -rotate-x-12"></div>

                    <div id="car-container" class="relative transition-all duration-700">
                        <canvas id="photon-canvas" class="absolute inset-0 pointer-events-none opacity-0"></canvas>

                        <img id="current-car" src="mercedes-benz-s-class-car-maybach-mercedes-benz-e-class-mercedes-benz-s-class-car-removebg-preview.png"
                            class="w-full h-auto object-contain drop-shadow-[0_20px_50px_rgba(0,0,0,0.8)]" alt="Luxury Car">

                        <div id="plate-snap" class="absolute opacity-0 z-20 pointer-events-none flex items-center justify-center">
                            <div class="plate-mini-wrapper">
                                <div class="car-plate-3d shadow-none border-[1px]">
                                    <div class="plate-content">
                                        <span class="plate-number-mini">30K - 888.88</span>
                                    </div>
                                </div>
                                <div class="pulse-wave"></div>
                            </div>
                        </div>
                    </div>

                    <button class="absolute bottom-4 right-4 lg:hidden bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-full">
                        <i class="ri-anticlockwise-2-fill text-cyan-400 text-2xl"></i>
                        <span class="text-[10px] block text-white uppercase mt-1">Xem AR</span>
                    </button>
                </div>

                <div class="flex-1 w-full lg:max-w-md space-y-8">
                    <div class="console-group">
                        <label class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mb-4 block">Select Specimen</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button onclick="changeCar('sedan', 'MAYBACH S680')" class="car-btn active bg-white/5 border border-cyan-500/50 p-3 rounded-xl hover:bg-white/10 transition-all text-center">
                                <i class="ri-car-fill text-xl block mb-1"></i>
                                <span class="text-[9px] uppercase tracking-tighter">Sedan</span>
                            </button>
                            <button onclick="changeCar('suv', 'CULLINAN')" class="car-btn bg-white/5 border border-white/10 p-3 rounded-xl hover:bg-white/10 transition-all text-center">
                                <i class="ri-truck-fill text-xl block mb-1"></i>
                                <span class="text-[9px] uppercase tracking-tighter">SUV</span>
                            </button>
                            <button onclick="changeCar('hyper', 'VENENO')" class="car-btn bg-white/5 border border-white/10 p-3 rounded-xl hover:bg-white/10 transition-all text-center">
                                <i class="ri-flashlight-fill text-xl block mb-1"></i>
                                <span class="text-[9px] uppercase tracking-tighter">Hypercar</span>
                            </button>
                        </div>
                    </div>

                    <div class="console-group">
                        <label class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mb-4 block">Exterior Finish</label>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-black border-2 border-cyan-500 cursor-pointer shadow-[0_0_10px_rgba(0,242,255,0.3)]"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-400 border border-white/20 cursor-pointer"></div>
                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-white/20 cursor-pointer"></div>
                        </div>
                    </div>

                    <div class="flex border-t border-white/5 pt-8 gap-4">
                        <button class="flex-1 bg-white/5 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-cyan-600 transition-all">
                            Front View
                        </button>
                        <button class="flex-1 border border-white/10 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest hover:border-cyan-500">
                            Rear View
                        </button>
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
    window.addEventListener('load', () => {
        // 1. Khởi tạo hiệu ứng Genesis Spin
        const tl = gsap.timeline();
        tl.from("#pedestal", {
                rotateY: 360,
                scale: 0,
                duration: 2,
                ease: "expo.out"
            })
            .from("#carPlate", {
                y: -30,
                rotationX: 90,
                opacity: 0,
                scale: 0.5,
                duration: 2,
                ease: "back.out(1.5)"
            }, "-=1.5")
            .to("#hud-price, #hud-status", {
                opacity: 1,
                duration: 1,
                stagger: 0.3
            });

        // 2. Hiệu ứng Particle Swarm (Nhảy số tiền)
        const priceEl = document.getElementById('price-stream');
        let priceVal = {
            val: 0
        };
        gsap.to(priceVal, {
            val: 5800000000,
            duration: 3,
            onUpdate: () => {
                priceEl.innerText = Math.floor(priceVal.val).toLocaleString('vi-VN') + "₫";
            }
        });

        // 3. Hiệu ứng Floating (Lơ lửng)
        gsap.to("#carPlate", {
            y: "-=15",
            duration: 2.5,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 4. Tương tác chuột: Xoay 3D & Phản chiếu (Chrome Reflection)
        const plate = document.getElementById('carPlate');
        const plateReflect = document.getElementById('chromeLight');
        const glow = document.getElementById('mouseGlow');

        document.addEventListener('mousemove', (e) => {
            const xPos = (e.clientX / window.innerWidth) - 0.5;
            const yPos = (e.clientY / window.innerHeight) - 0.5;

            // Xoay biển số theo chuột
            gsap.to(plate, {
                rotateY: xPos * 40,
                rotateX: -yPos * 30,
                duration: 0.7,
                ease: "power2.out"
            });

            // Di chuyển vùng sáng phản chiếu
            gsap.to(plateReflect, {
                x: xPos * 250,
                y: yPos * 150,
                duration: 0.7
            });

            // Ánh sáng theo chuột
            gsap.to(glow, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.5
            });
        });

        // 5. Aurora Borealis Scan (Ánh sáng Bắc cực quét ngang)
        function runAurora() {
            gsap.fromTo("#auroraEffect", {
                left: "-150%",
                opacity: 0
            }, {
                left: "150%",
                opacity: 1,
                duration: 2.5,
                ease: "power2.inOut"
            });
        }
        setInterval(runAurora, 8000); // Chạy mỗi 8 giây

        // 6. Cảm biến nghiêng (Gyroscope) cho Mobile
        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (e) => {
                if (window.innerWidth < 1024) {
                    const tiltX = e.gamma; // Độ nghiêng trái-phải
                    const tiltY = e.beta; // Độ nghiêng trước-sau
                    gsap.to(plate, {
                        rotateY: tiltX * 0.7,
                        rotateX: (tiltY - 45) * 0.5,
                        duration: 0.5
                    });
                }
            });
        }
        // 3. Aurora Borealis Scan - Cải tiến hiệu ứng quét mượt hơn
        function triggerAurora() {
            const aurora = document.getElementById('auroraEffect');
            if (aurora) {
                gsap.fromTo(aurora, {
                    left: "-150%",
                    opacity: 0
                }, {
                    left: "150%",
                    opacity: 1,
                    duration: 2.5,
                    ease: "power2.inOut",
                    onComplete: () => {
                        gsap.set(aurora, {
                            opacity: 0
                        }); // Ẩn đi sau khi quét xong
                    }
                });
            }
        }

        // Chạy lần đầu sau khi load
        setTimeout(triggerAurora, 2000);

        // Lặp lại mỗi 6 giây (nhanh hơn 8s để người dùng dễ thấy)
        setInterval(triggerAurora, 6000);
    });
    // ----------------------------- section 2 ----------------------------- //
    window.addEventListener('load', () => {
        // ĐĂNG KÝ PLUGIN TRƯỚC KHI SỬ DỤNG
        gsap.registerPlugin(ScrollTrigger);

        // 1. Khởi tạo Biểu đồ Radar
        const ctxRadar = document.getElementById('radarChart').getContext('2d');
        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: ['Tài lộc', 'Quyền lực', 'Sức khỏe', 'Danh tiếng', 'May mắn'],
                datasets: [{
                    data: [95, 90, 85, 92, 88],
                    backgroundColor: 'rgba(0, 242, 255, 0.2)',
                    borderColor: '#00f2ff',
                    borderWidth: 1,
                    pointBackgroundColor: '#00f2ff',
                }]
            },
            options: {
                scales: {
                    r: {
                        angleLines: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        pointLabels: {
                            color: '#888',
                            font: {
                                size: 9
                            }
                        },
                        ticks: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 2. Khởi tạo Biểu đồ Đường
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['2024', '2025', '2026', '2027', '2028'],
                datasets: [{
                    data: [100, 140, 190, 210, 280],
                    borderColor: '#007FFF',
                    backgroundColor: 'rgba(0, 127, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#555',
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 3. Hiệu ứng "The System Boot"
        // Tạo một timeline riêng cho việc hiện các module
        const tlMetrics = gsap.timeline({
            scrollTrigger: {
                trigger: "#sovereignty-metrics",
                start: "top 80%", // Kích hoạt khi đầu section cách top màn hình 80%
                toggleActions: "play none none none" // Chỉ chạy 1 lần khi cuộn xuống
            }
        });

        tlMetrics.to(".metric-module", {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.3,
                ease: "power3.out"
            })
            .to(".level-progress", {
                width: (i, el) => el.dataset.width,
                duration: 1.5,
                ease: "expo.out"
            }, "-=0.5");

        // Hiệu ứng nhảy số
        const randomNums = document.querySelectorAll('.random-string');
        randomNums.forEach(num => {
            const finalVal = parseFloat(num.dataset.value);
            gsap.to(num, {
                innerText: finalVal,
                duration: 2,
                scrollTrigger: {
                    trigger: num,
                    start: "top 90%"
                },
                onUpdate: function() {
                    // Tạo hiệu ứng nhảy số thập phân mượt mà
                    num.innerText = this.targets()[0].innerText.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            });
        });
    });
    // ----------------------------- section 3 ----------------------------- //
    // Cấu hình vị trí biển số cho từng loại xe
    const carConfigs = {
        'sedan': {
            platePos: {
                top: '40%',
                left: '0%'
            },
            name: 'MAYBACH S680',
            img: 'mercedes-benz-s-class-car-maybach-mercedes-benz-e-class-mercedes-benz-s-class-car-removebg-preview.png'
        },
        'suv': {
            platePos: {
               top: '50%',
                left: '25%'
            },
            name: 'RR CULLINAN',
            img: 'Armored_Vehicle_Make_e3a8620860.png'
        },
        'hyper': {
            platePos: {
                top: '40%',
                left: '0%'
            },
            name: 'LAMBO VENENO',
            img: '499540-removebg-preview.png'
        }
    };

    function changeCar(type) {
        const config = carConfigs[type];
        const carImg = document.getElementById('current-car');
        const carName = document.getElementById('car-name');
        const plate = document.getElementById('plate-snap');

        // 1. Hiệu ứng biến mất (mờ dần và lóe sáng)
        gsap.to(carImg, {
            filter: "brightness(3) blur(15px)",
            opacity: 0,
            scale: 1.05,
            duration: 0.4,
            onComplete: () => {
                // 2. Thay đổi nguồn ảnh và tên xe sau khi ảnh cũ đã mờ hẳn
                carImg.src = config.img;
                carName.innerText = config.name;

                // Cập nhật vị trí biển số cho khớp với xe mới
                plate.style.top = config.platePos.top;
                plate.style.left = config.platePos.left;

                // 3. Hiệu ứng hiện hình xe mới
                gsap.fromTo(carImg, {
                    filter: "brightness(3) blur(15px)",
                    opacity: 0,
                    scale: 0.95
                }, {
                    filter: "brightness(1) blur(0px)",
                    opacity: 1,
                    scale: 1,
                    duration: 0.6,
                    ease: "power2.out"
                });

                // Gọi lại hiệu ứng lắp biển số
                snapPlate();
            }
        });

        // Cập nhật trạng thái Active của nút
        document.querySelectorAll('.car-btn').forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }

    function snapPlate() {
        const plate = document.getElementById('plate-snap');

        // Reset biển
        gsap.set(plate, {
            opacity: 0,
            scale: 3,
            y: -100
        });

        // Hiệu ứng "Hít" biển vào xe
        gsap.to(plate, {
            opacity: 1,
            scale: 0.15, // Scale về kích thước thực tế trên xe
            y: 0,
            duration: 1,
            delay: 0.5,
            ease: "power4.out",
            onComplete: () => {
                // Flash sáng khi chạm
                gsap.to(".pulse-wave", {
                    opacity: 1,
                    scale: 2,
                    duration: 0.5,
                    repeat: 1,
                    yoyo: true
                });
            }
        });
    }

    // Khởi chạy lần đầu
    window.addEventListener('load', () => {
        setTimeout(snapPlate, 2500); // Đợi Section 1 hoàn tất

        // 4. Studio Camera Path (Hover effect)
        const studio = document.getElementById('studio-scene');
        studio.addEventListener('mousemove', (e) => {
            const xPos = (e.clientX / window.innerWidth) - 0.5;
            gsap.to("#car-container", {
                rotateY: xPos * 15,
                duration: 1,
                ease: "power2.out"
            });
        });
    });

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>