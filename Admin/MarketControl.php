<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
        }

        /* ----------------------------- section 1 -----------------------------  */
        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Hiệu ứng Sapphire Pulse */
        .pulse-ring {
            animation: pulse-ripple 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ripple {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* Sticky Header shrink when scroll */
        .header-shrink {
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            padding-top: 0 !important;
        }

        .header-shrink>div {
            border-radius: 0 0 20px 20px !important;
            border-top: none !important;
        }

        /* Mobile Swipe Simulation */
        @media (max-width: 768px) {
            #market-header {
                top: 0;
                left: 0;
                right: 0;
            }

            #market-header>div {
                border-radius: 0;
            }
        }

        /* Đảm bảo nội dung không bị Header fixed che mất */
        #market-grid {
            padding-top: 140px;
            /* Khoảng cách này đủ để Header lơ lửng không đè lên content */
        }

        /* Trên mobile, Header có thể cao hơn, ta điều chỉnh thêm */
        @media (max-width: 1024px) {
            #market-grid {
                padding-top: 100px;
            }
            .frontsize{
                font-size: 12px !important;
                margin-left: 10px;
            }
            #server-time{
                margin-left: 10px;
            }
            
        }

        /* Hiệu ứng Sticky Header khi cuộn trang */
        .header-shrink {
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            padding: 0 !important;
        }

        .header-shrink>div {
            border-radius: 0 0 20px 20px !important;
            border-top: none !important;
        }
        

        /* ----------------------------- section 2 -----------------------------  */
        /* Custom Scrollbar cho bảng */
        .custom-scrollbar::-webkit-scrollbar {
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(6, 182, 212, 0.2);
            border-radius: 10px;
        }

        /* Hiệu ứng mờ khi Pause */
        .row-paused {
            filter: grayscale(1);
            opacity: 0.5;
            pointer-events: none;
        }

        .row-paused::after {
            content: "PAUSED";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-family: 'JetBrains Mono';
            font-size: 10px;
            letter-spacing: 5px;
            animation: blink 2s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Bid Flash Animation */
        @keyframes flash-sweep {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .flash-active .bid-flash-overlay {
            animation: flash-sweep 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Z-Depth Hover effect */
        .grid-row {
            transform: translateZ(0);
            will-change: transform, box-shadow;
        }

        .grid-row:hover {
            transform: translateY(-4px) scale(1.01);
            z-index: 10;
        }

        /* Mobile Hybrid Cards */
        @media (max-width: 1023px) {
            #grid-container {
                min-width: 100% !important;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .grid-row {
                display: flex;
                flex-direction: column;
                padding: 1.5rem;
                height: auto;
                align-items: flex-start;
            }

            .grid-row>div {
                width: 100%;
                margin-bottom: 1rem;
            }

            .grid-row .col-span-12,
            .grid-row .col-span-3,
            .grid-row .col-span-2 {
                grid-column: span 12 / span 12;
            }

            .grid-row .justify-end {
                justify-content: flex-start;
            }
        }

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
    <header id="market-header" class="fixed top-6 left-6 right-6 lg:left-[284px] z-[50] transition-all duration-500">
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl px-6 py-3 flex items-center justify-between shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">

            <div class="absolute inset-0 sapphire-dust opacity-10 pointer-events-none"></div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="relative">
                    <div class="pulse-ring absolute -inset-1 bg-cyan-500/30 rounded-full blur-sm"></div>
                    <div class="w-3 h-3 bg-cyan-400 rounded-full relative"></div>
                </div>
                <div>
                    <h1 class="playfair text-white text-lg tracking-wider font-bold frontsize">MARKET CONTROL</h1>
                    <p id="server-time" class="space-mono text-[9px] text-cyan-400/70 uppercase tracking-[2px]">00:00:00 GMT+7</p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-10 relative z-10">
                <div class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="113" stroke-dashoffset="30" class="text-cyan-400 ring-progress transition-all duration-1000"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center space-mono text-[8px] text-white">72%</span>
                    </div>
                    <span class="text-[9px] text-white/40 space-mono leading-tight">ACTIVE<br>DISPUTE</span>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="113" stroke-dashoffset="80" class="text-amber-400 ring-progress transition-all duration-1000"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center space-mono text-[8px] text-white">28%</span>
                    </div>
                    <span class="text-[9px] text-white/40 space-mono leading-tight">ENDING<br>SOON</span>
                </div>
                <div class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                            <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="113" stroke-dashoffset="15" class="text-emerald-400 ring-progress transition-all duration-1000"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center space-mono text-[8px] text-white">85%</span>
                    </div>
                    <span class="text-[9px] text-white/40 space-mono leading-tight">PRICE<br>SURGE</span>
                </div>
            </div>

            <div class="flex items-center gap-4 relative z-10">
                <div id="search-container" class="relative group">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                    <input type="text" placeholder="AI Intelligence Search..." class="bg-white/5 border border-white/10 rounded-xl py-2 pl-10 pr-4 text-[11px] text-white w-40 focus:w-64 focus:bg-black/60 focus:border-cyan-500/50 transition-all duration-500 outline-none jetbrains">
                </div>
                <button class="hidden lg:flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-700 hover:from-cyan-500 hover:to-blue-600 text-white text-[10px] font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-cyan-900/20 active:scale-95 jetbrains">
                    <i class="ri-add-circle-line text-sm"></i> NEW AUCTION
                </button>
            </div>
        </div>
    </header>

    <button class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-cyan-500 rounded-full shadow-2xl z-[100] flex items-center justify-center text-white text-2xl active:scale-90 transition-transform">
        <i class="ri-add-line"></i>
    </button>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="market-grid" class="relative pb-20 px-6 lg:ml-[260px] group-[.collapsed]:lg:ml-[80px] transition-all duration-500">
        <div class="container mx-auto max-w-[1600px]">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h3 class="playfair text-white text-xl font-bold tracking-wider">THE INTELLIGENCE MATRIX</h3>
                    <p class="space-mono text-[10px] text-white/30 uppercase tracking-[3px]">Real-time Asset Monitoring</p>
                </div>

                <div class="flex items-center gap-3 bg-black/40 p-1 rounded-xl border border-white/10">
                    <button onclick="sortGrid('price')" class="px-4 py-2 rounded-lg jetbrains text-[10px] text-white/60 hover:text-cyan-400 hover:bg-white/5 transition-all">SORT BY PRICE</button>
                    <button onclick="sortGrid('time')" class="px-4 py-2 rounded-lg jetbrains text-[10px] text-white/60 hover:text-cyan-400 hover:bg-white/5 transition-all">SORT BY TIME</button>
                </div>
            </div>

            <div class="w-full overflow-x-auto custom-scrollbar">
                <div id="grid-container" class="min-w-[1000px] lg:min-w-full space-y-4">

                    <div class="grid grid-cols-12 px-8 py-4 bg-white/5 border-b border-white/10 rounded-t-2xl space-mono text-[10px] text-white/40 uppercase tracking-widest">
                        <div class="col-span-3">Asset Identifier</div>
                        <div class="col-span-2">Valuation Pulse</div>
                        <div class="col-span-2">Density</div>
                        <div class="col-span-2">Time Horizon</div>
                        <div class="col-span-3 text-right">Authority Tools</div>
                    </div>

                    <div class="grid-row group grid grid-cols-12 items-center px-8 py-6 bg-[#0A0A0A]/60 backdrop-blur-md border border-white/5 rounded-2xl hover:border-cyan-500/30 hover:shadow-[0_10px_30px_rgba(0,0,0,0.5)] transition-all duration-500 relative overflow-hidden" data-price="850000000" data-time="3600">
                        <div class="bid-flash-overlay absolute inset-0 bg-gradient-to-r from-transparent via-cyan-500/10 to-transparent -translate-x-full pointer-events-none"></div>

                        <div class="col-span-3 flex items-center gap-4">
                            <div class="bg-gradient-to-br from-gray-300 to-gray-500 p-[1px] rounded-lg shadow-lg shadow-black">
                                <div class="bg-white px-3 py-1.5 rounded-[7px] border border-black/20">
                                    <span class="text-black font-bold jetbrains text-sm tracking-tighter">30L-888.88</span>
                                </div>
                            </div>
                            <i class="ri-vip-diamond-line text-cyan-400 text-lg"></i>
                        </div>

                        <div class="col-span-2">
                            <p class="text-cyan-400 font-bold jetbrains text-base rolling-number" data-value="850.000.000">850.000.000</p>
                            <p class="text-[9px] text-emerald-400 space-mono">↑ +120% START</p>
                        </div>

                        <div class="col-span-2 flex items-center gap-4">
                            <div class="flex items-center gap-1.5">
                                <i class="ri-eye-line text-white/20 text-xs"></i>
                                <span class="text-white/60 jetbrains text-[10px]">1.2k</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="ri-auction-line text-white/20 text-xs"></i>
                                <span class="text-white/60 jetbrains text-[10px]">42</span>
                            </div>
                        </div>

                        <div class="col-span-2 flex items-center gap-3">
                            <div class="relative w-10 h-10">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5"></circle>
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" fill="transparent" stroke-dasharray="100" stroke-dashoffset="30" class="text-amber-500 transition-all duration-1000"></circle>
                                </svg>
                                <i class="ri-time-line absolute inset-0 flex items-center justify-center text-[10px] text-amber-500"></i>
                            </div>
                            <span class="text-amber-500 jetbrains text-[11px] font-bold">12:45:02</span>
                        </div>

                        <div class="col-span-3 flex justify-end gap-2">
                            <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 hover:text-white transition-all"><i class="ri-pause-line"></i></button>
                            <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-white/40 hover:bg-white/10 hover:text-white transition-all"><i class="ri-time-fill"></i></button>
                            <button class="px-4 h-8 rounded-lg bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-[9px] jetbrains font-bold hover:bg-cyan-500 hover:text-black transition-all">BOOST</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Cập nhật Server Time thời gian thực
        function updateServerTime() {
            const now = new Date();
            const timeStr = now.toTimeString().split(' ')[0] + " GMT+7";
            document.getElementById('server-time').innerText = timeStr;
        }
        setInterval(updateServerTime, 1000);

        // 2. Parallax/Sticky Effect khi cuộn
        window.addEventListener('scroll', () => {
            const header = document.getElementById('market-header');
            if (window.scrollY > 50) {
                header.classList.add('header-shrink');
            } else {
                header.classList.remove('header-shrink');
            }
        });

        // 3. Animation cho các con số Rings (Data Inflow)
        gsap.from(".ring-progress", {
            strokeDashoffset: 113,
            duration: 2,
            stagger: 0.3,
            ease: "expo.out",
            scrollTrigger: {
                trigger: "#market-header",
                start: "top top"
            }
        });

        // 4. Magnetic Search Blur Effect
        const searchInput = document.querySelector('#search-container input');
        searchInput.addEventListener('focus', () => {
            gsap.to("section:not(#market-header)", {
                filter: "blur(4px)",
                opacity: 0.5,
                duration: 0.4
            });
        });
        searchInput.addEventListener('blur', () => {
            gsap.to("section:not(#market-header)", {
                filter: "blur(0px)",
                opacity: 1,
                duration: 0.4
            });
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Hiệu ứng Bid Flash giả lập (Mỗi 5 giây chọn ngẫu nhiên 1 dòng)
        setInterval(() => {
            const rows = document.querySelectorAll('.grid-row');
            const randomRow = rows[Math.floor(Math.random() * rows.length)];

            // Kích hoạt flash
            randomRow.classList.add('flash-active');
            setTimeout(() => randomRow.classList.remove('flash-active'), 1000);

            // Hiệu ứng lăn số (Rolling number)
            const priceTag = randomRow.querySelector('.rolling-number');
            const currentVal = parseInt(priceTag.getAttribute('data-value').replace(/\./g, ''));
            const newVal = currentVal + 5000000;

            gsap.to(priceTag, {
                innerText: newVal,
                duration: 1,
                snap: {
                    innerText: 1
                },
                onUpdate: function() {
                    priceTag.innerHTML = parseInt(this.targets()[0].innerText).toLocaleString('vi-VN');
                },
                onComplete: () => priceTag.setAttribute('data-value', newVal.toString())
            });
        }, 5000);

        // 2. Logic sắp xếp (Sorting)
        window.sortGrid = (type) => {
            const container = document.getElementById('grid-container');
            const rows = Array.from(container.querySelectorAll('.grid-row'));

            rows.sort((a, b) => {
                if (type === 'price') {
                    return b.dataset.price - a.dataset.price;
                } else {
                    return a.dataset.time - b.dataset.time;
                }
            });

            // Sử dụng GSAP để trượt các hàng
            const state = Flip.getState(rows);
            rows.forEach(row => container.appendChild(row));
            Flip.from(state, {
                duration: 0.8,
                ease: "power3.inOut",
                stagger: 0.05
            });
        };
    });

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>