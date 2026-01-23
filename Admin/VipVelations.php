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

    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
        }

        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@400;700&display=swap');

        .font-serif {
            font-family: 'Cormorant+Garamond', serif;
        }

        .font-mono {
            font-family: 'Montserrat', sans-serif;
        }

        .animate-ticker {
            animation: ticker 30s linear infinite;
        }

        @keyframes ticker {
            0% {
                transform: translateX(10%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .pause-animate {
            animation-play-state: paused;
        }

        .privacy-blur {
            transition: filter 0.3s ease;
        }

        .privacy-blur.active {
            filter: blur(8px);
        }

        /* Hiệu ứng focus thanh search */
        #deep-search:focus~#search-suggestions {
            display: block;
        }

        /* Hiệu ứng khi di chuột vào từng mục gợi ý */
        .suggestion-item:hover {
            background-color: rgba(8, 145, 178, 0.1);
            border-left: 2px solid #0891B2;
        }

        /* Thêm hiệu ứng hover cho item để dễ nhìn */
        .suggestion-item {
            background: transparent;
            transition: all 0.2s;
        }

        #search-suggestions {
            z-index: 999999 !important;
            /* Đảm bảo cực cao */
            position: absolute;
            top: 100%;
            /* Luôn nằm dưới ô input */
            left: 0;
            right: 0;
            background: #0a0a0a;
            /* Nền tối đặc để không bị xuyên thấu */
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            display: none;
            /* Mặc định ẩn, JS sẽ điều khiển */
            margin-top: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive cho Mobile */
        @media (max-width: 768px) {
            #vip-header {
                top: 0;
                left: 7px;
                right: 0;
            }

            .header-container {
                border-radius: 0 0 1.5rem 1.5rem;
                border-top: none;
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
    <!-- <header id="vip-header" class="fixed top-4 right-4 left-4 md:left-24 z-[100] transition-all duration-500" style="margin-left: 13%;">
        <div class="header-container relative bg-black/60 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-4 md:px-8 md:py-5 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">

            <div id="liquid-track" class="absolute bottom-0 left-0 h-[2px] w-0 transition-all duration-500 z-20"></div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">

                <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-start">
                    <div class="identity-group">
                        <h1 class="text-1xl md:text-2xl font-serif tracking-[2px] text-[#F1C40F] leading-none mb-1" style="font-size: 1rem;">
                            VIP <span class="font-light italic text-white/90">RELATIONS</span>
                        </h1>
                        <p class="text-[9px] font-mono tracking-[3px] text-white/30 uppercase">The Elite Concierge</p>
                    </div>

                    <div class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-full border border-white/5">
                        <div class="relative">
                            <div class="w-3 h-3 bg-[#0891B2] rounded-full shadow-[0_0_15px_#0891B2] animate-pulse"></div>
                            <div class="absolute inset-0 w-3 h-3 bg-[#0891B2] rounded-full animate-ping opacity-50"></div>
                        </div>
                        <span class="text-xs font-bold text-[#0891B2] font-mono"><span class="counting-number" data-target="12">0</span> VVIP ONLINE</span>
                    </div>
                </div>

                <div class="wealth-ticker hidden lg:flex items-center gap-10 bg-white/5 px-8 py-3 rounded-2xl border border-white/5 max-w-md overflow-hidden relative group">
                    <div class="ticker-content flex items-center gap-8 whitespace-nowrap animate-ticker hover:pause-animate cursor-help">
                        <div class="flex flex-col">
                            <span class="text-[8px] uppercase text-white/30 tracking-widest mb-1">Available Funds</span>
                            <span class="text-xs font-bold text-white font-mono privacy-blur">$ <span class="counting-number" data-target="842000000">0</span></span>
                        </div>
                        <div class="w-[1px] h-6 bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-[8px] uppercase text-white/30 tracking-widest mb-1">Avg. VIP Auction</span>
                            <span class="text-xs font-bold text-[#F1C40F] font-mono privacy-blur">$ <span class="counting-number" data-target="1520000">0</span></span>
                        </div>
                    </div>
                    <button onclick="togglePrivacy()" class="ml-4 text-white/20 hover:text-white transition-colors">
                        <i id="privacy-icon" class="ri-eye-line text-sm"></i>
                    </button>
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative flex-1 md:flex-none group">
                        <i class="ri-search-2-line absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                        <input type="text" id="deep-search" autocomplete="off" placeholder="Deep Search VIP..."
                            class="bg-white/5 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-xs text-white focus:outline-none focus:ring-2 focus:ring-[#0891B2]/50 w-full md:w-[250px] transition-all duration-300">

                        <div id="search-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-xl overflow-hidden border border-white/10">
                            <div class="p-3 text-[10px] text-white/40 border-b border-white/5 uppercase font-bold tracking-widest">Suggested VIPs</div>

                            <div class="suggestion-item p-3 cursor-pointer flex items-center gap-3 transition-colors" onclick="selectVIP('David Le (Diamond)')">
                                <div class="w-8 h-8 rounded-full bg-cyan-500/20 flex items-center justify-center text-[10px] text-cyan-400 border border-cyan-500/30">DL</div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-white font-bold">David Le</span>
                                    <span class="text-[9px] text-cyan-400 uppercase tracking-tighter">Diamond Member</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="bg-gradient-to-r from-[#F1C40F] to-[#D4AC0D] text-black px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest shadow-[0_0_20px_rgba(241,196,15,0.3)] hover:shadow-[0_0_30px_rgba(241,196,15,0.5)] hover:-translate-y-1 transition-all duration-300">
                        Add VIP Profile
                    </button>
                </div>
            </div>
        </div>
    </header> -->
    <header id="vip-header" class="fixed top-0 md:top-4 right-0 md:right-4 left-0 md:left-20 lg:left-24 z-[100] transition-all duration-500 mt-2 ms-1 md:mt-0 md:ms-0" style="margin-left: 13%;">
        <div class="header-container relative bg-black/80 md:bg-black/60 backdrop-blur-2xl border-b md:border border-white/10 rounded-none md:rounded-[2rem] p-3 md:px-8 md:py-4 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">

            <div id="liquid-track" class="absolute bottom-0 left-0 h-[2px] w-0 transition-all duration-500 z-20"></div>

            <div class="flex items-center justify-between gap-2 md:gap-6 relative z-10">

                <div class="flex items-center gap-3 md:gap-6">
                    <div class="identity-group">
                        <h1 class="text-lg md:text-2xl font-serif tracking-[1px] text-[#F1C40F] leading-none">
                            VIP <span class="hidden sm:inline font-light italic text-white/90">RELATIONS</span>
                        </h1>
                        <p class="text-[7px] md:text-[9px] font-mono tracking-[2px] text-white/30 uppercase mt-1">Concierge</p>
                    </div>

                    <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-full border border-white/5">
                        <div class="w-2 h-2 bg-[#0891B2] rounded-full shadow-[0_0_10px_#0891B2] animate-pulse"></div>
                        <span class="text-[10px] font-bold text-[#0891B2] font-mono">12 <span class="hidden xs:inline">VVIP</span></span>
                    </div>
                </div>

                <div class="wealth-ticker hidden lg:flex items-center gap-6 bg-white/5 px-6 py-2 rounded-xl border border-white/5 max-w-xs xl:max-w-md overflow-hidden relative group">
                    <div class="ticker-content flex items-center gap-6 whitespace-nowrap animate-ticker">
                        <div class="flex flex-col">
                            <span class="text-[7px] uppercase text-white/30 tracking-widest">Available</span>
                            <span class="text-xs font-bold text-white font-mono privacy-blur">$842M</span>
                        </div>
                        <div class="flex flex-col border-l border-white/10 pl-6">
                            <span class="text-[7px] uppercase text-white/30 tracking-widest">Avg. Auction</span>
                            <span class="text-xs font-bold text-[#F1C40F] font-mono privacy-blur">$1.5M</span>
                        </div>
                    </div>
                    <button onclick="togglePrivacy()" class="ml-2 text-white/20 hover:text-white"><i class="ri-eye-line text-xs"></i></button>
                </div>

                <div class="flex items-center gap-2 md:gap-4 flex-1 justify-end md:flex-none">
                    <div class="relative group flex-1 md:flex-none">
                        <i class="ri-search-2-line absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
                        <input type="text" id="deep-search" autocomplete="off" placeholder="Search..."
                            class="bg-white/5 border border-white/10 rounded-lg md:rounded-xl py-2 pl-9 pr-3 text-[11px] text-white focus:outline-none focus:ring-1 focus:ring-[#0891B2] w-full md:w-[180px] lg:w-[240px] transition-all">

                        <div id="search-suggestions" class="absolute top-[120%] left-[-50px] md:left-0 right-0 w-[250px] md:w-full rounded-xl overflow-hidden shadow-2xl">
                            <div class="p-2 text-[9px] text-white/40 border-b border-white/5 uppercase font-bold bg-black">Suggested</div>
                            <div class="suggestion-item p-3 cursor-pointer flex items-center gap-3 bg-black hover:bg-white/5" onclick="selectVIP('David Le')">
                                <div class="w-7 h-7 rounded-full bg-cyan-500/20 flex items-center justify-center text-[10px] text-cyan-400">DL</div>
                                <span class="text-[11px] text-white">David Le (Diamond)</span>
                            </div>
                        </div>
                    </div>

                    <button class="bg-[#F1C40F] text-black w-9 h-9 md:w-auto md:h-auto md:px-5 md:py-2.5 rounded-lg md:rounded-xl flex items-center justify-center shadow-lg">
                        <i class="ri-add-line font-bold"></i>
                        <span class="hidden md:inline ml-2 text-[10px] font-bold uppercase tracking-widest">Add VIP</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div id="focus-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] opacity-0 pointer-events-none transition-opacity duration-500"></div>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Hiệu ứng "The Royal Entrance" (GSAP)
        gsap.from("#vip-header", {
            y: -100,
            opacity: 0,
            filter: "blur(20px)",
            duration: 1.5,
            ease: "power4.out"
        });

        // 2. Hiệu ứng Nhảy số (Counting effect)
        const countNumbers = document.querySelectorAll('.counting-number');
        countNumbers.forEach(num => {
            const target = parseInt(num.getAttribute('data-target'));
            gsap.to(num, {
                innerText: target,
                duration: 2,
                snap: {
                    innerText: 1
                },
                ease: "power2.out",
                onUpdate: function() {
                    if (target > 1000) {
                        num.innerText = num.innerText.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            });
        });

        // 3. Hiệu ứng "The Focus Halo" khi search
        const searchInput = document.getElementById('deep-search');
        const overlay = document.getElementById('focus-overlay');
        const suggestionsBox = document.getElementById('search-suggestions');

        searchInput.addEventListener('focus', () => {
            overlay.classList.remove('pointer-events-none');
            overlay.classList.add('opacity-100');
        });
        // Khi gõ phím vào ô search
        // Cập nhật lại sự kiện input trong DOMContentLoaded
        searchInput.addEventListener('input', function(e) {
            const value = e.target.value.trim().toLowerCase();

            if (value.length >= 1) {
                // Sử dụng block thay vì gsap nếu muốn test nhanh hiển thị
                suggestionsBox.style.display = 'block';
                gsap.to(suggestionsBox, {
                    opacity: 1,
                    y: 5, // Trượt xuống một chút cho đẹp
                    duration: 0.2,
                });
            } else {
                suggestionsBox.style.display = 'none';
            }
        });

        searchInput.addEventListener('blur', () => {
            overlay.classList.add('pointer-events-none');
            overlay.classList.remove('opacity-100');
        });
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });

        function selectVIP(name) {
            const searchInput = document.getElementById('deep-search');
            const suggestionsBox = document.getElementById('search-suggestions');

            searchInput.value = name;
            suggestionsBox.style.display = 'none';
            console.log("Đã chọn thượng khách:", name);
        }

        // 4. Liquid Metal Hover Effect chân trang
        const headerContainer = document.querySelector('.header-container');
        const track = document.getElementById('liquid-track');

        headerContainer.addEventListener('mousemove', (e) => {
            const x = e.clientX - headerContainer.getBoundingClientRect().left;
            gsap.to(track, {
                left: x - 50,
                width: '100px',
                background: 'linear-gradient(90deg, transparent, #F1C40F, transparent)',
                duration: 0.5
            });
        });
    });

    // 5. Privacy Toggle (Giải pháp phản biện)
    let isPrivate = false;

    function togglePrivacy() {
        isPrivate = !isPrivate;
        const elements = document.querySelectorAll('.privacy-blur');
        const icon = document.getElementById('privacy-icon');

        elements.forEach(el => {
            isPrivate ? el.classList.add('active') : el.classList.remove('active');
        });

        icon.className = isPrivate ? 'ri-eye-off-line text-sm text-[#F1C40F]' : 'ri-eye-line text-sm';

        // Haptic feedback giả lập
        if (window.navigator.vibrate) window.navigator.vibrate(10);
    }

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>