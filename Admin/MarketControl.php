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
    <header id="market-header" class="fixed top-6 left-6 right-6 lg:left-[284px] z-[50] transition-all duration-500">
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl px-6 py-3 flex items-center justify-between shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">

            <div class="absolute inset-0 sapphire-dust opacity-10 pointer-events-none"></div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="relative">
                    <div class="pulse-ring absolute -inset-1 bg-cyan-500/30 rounded-full blur-sm"></div>
                    <div class="w-3 h-3 bg-cyan-400 rounded-full relative"></div>
                </div>
                <div>
                    <h1 class="playfair text-white text-lg tracking-wider font-bold">MARKET CONTROL</h1>
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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>