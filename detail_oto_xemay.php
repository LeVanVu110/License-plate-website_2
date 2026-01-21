<?php include "header.php"; ?>
<?php
$query = isset($_GET['plate']) ? htmlspecialchars($_GET['plate']) : "888.88";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discovery Matrix | <?php echo $query; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sapphire: #007FFF;
            --midnight: #000814;
            --ice-silver: #E2E8F0;
        }

        body {
            background-color: var(--midnight);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        .serif-italic {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Glassmorphism Card */
        .treasure-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            opacity: 0;
            transform: translateY(30px);
        }

        /* Hover rực viền (Neon Border Draw) */
        .treasure-card:hover {
            border-color: var(--sapphire);
            box-shadow: 0 0 30px rgba(0, 127, 255, 0.2), inset 0 0 15px rgba(0, 127, 255, 0.1);
            transform: scale(1.02) translateY(-5px);
            z-index: 10;
        }

        /* Hiệu ứng mờ các thẻ xung quanh */
        .discovery-grid:hover .treasure-card:not(:hover) {
            opacity: 0.3;
            filter: blur(2px);
        }

        /* Radar Pulse Beam */
        #radar-beam {
            position: fixed;
            top: 0;
            left: 50%;
            width: 2px;
            height: 100vh;
            background: linear-gradient(to bottom, transparent, var(--sapphire), transparent);
            box-shadow: 0 0 50px 10px var(--sapphire);
            z-index: 100;
            pointer-events: none;
            visibility: hidden;
        }

        /* Plate Embossed Text */
        .plate-num {
            text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.2), -1px -1px 0px rgba(0, 0, 0, 0.5);
            letter-spacing: -1px;
        }

        /* Custom Tabs for Mobile */
        @media (max-width: 768px) {
            .vault-container {
                display: none;
            }

            .vault-container.active-tab {
                display: block;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Glassmorphism Configuration */
        .glass-filter {
            background: rgba(0, 13, 26, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }

        /* Filter Tags */
        .filter-tag {
            white-space: nowrap;
            padding: 6px 16px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.5);
            border-radius: 50px;
            transition: all 0.4s ease;
        }

        .filter-tag.active {
            color: white;
            background: rgba(0, 127, 255, 0.2);
            box-shadow: 0 0 15px rgba(0, 127, 255, 0.3);
            border: 1px solid rgba(0, 127, 255, 0.5);
        }

        /* Element Buttons */
        .element-btn {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            position: relative;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .element-btn:hover {
            transform: scale(1.5);
        }

        .element-btn .dot {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: currentColor;
        }

        .kim {
            color: #E2E8F0;
        }

        /* Trắng bạc */
        .moc {
            color: #4ADE80;
        }

        /* Xanh lá */
        .thuy {
            color: #60A5FA;
        }

        /* Xanh biển */
        .hoa {
            color: #F87171;
        }

        /* Đỏ */
        .tho {
            color: #FBBF24;
        }

        /* Vàng đất */

        /* Custom Price Slider */
        .price-slider {
            -webkit-appearance: none;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 12px;
            height: 12px;
            background: #A3ABB8;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 127, 255, 0.5);
            transition: 0.3s;
        }

        .price-slider::-webkit-slider-thumb:hover {
            background: #007FFF;
            transform: scale(1.2);
        }

        /* No Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <div id="radar-beam"></div>

    <header class="pt-20 pb-10 text-center px-6" style="background-color: #000814;">
        <p class="serif-italic text-blue-300/60 text-xl mb-2">Tìm thấy 39 kết quả cho di sản "<?php echo $query; ?>"</p>
        <div class="h-[1px] w-24 bg-blue-500/30 mx-auto"></div>
    </header>

    <div class="flex md:hidden justify-center gap-4 p-3 px-6" style="background-color: #000814;">
        <button onclick="switchTab('auto')" id="btn-auto" class="flex-1 py-4 bg-blue-600/20 border border-blue-500/50 rounded-xl text-[10px] tracking-[3px] font-bold uppercase active-tab-btn">Ô tô (24)</button>
        <button onclick="switchTab('moto')" id="btn-moto" class="flex-1 py-4 bg-white/5 border border-white/10 rounded-xl text-[10px] tracking-[3px] font-bold uppercase">Xe máy (15)</button>
    </div>

    <main class="max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-20 relative " style="background-color: #000814;">

        <div class="absolute left-1/2 top-0 w-[1px] h-full bg-gradient-to-b from-transparent via-blue-500/20 to-transparent -translate-x-1/2 hidden md:block"></div>

        <section id="auto-vault" class="vault-container active-tab pb-20">
            <h3 class="text-[10px] tracking-[5px] text-white/30 uppercase mb-10 flex items-center gap-4 p-5">
                <i class="ri-steering-2-line "></i> Auto-Vault Allocation
            </h3>
            <div class="discovery-grid grid grid-cols-1 xl:grid-cols-2 gap-6">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="treasure-card p-8 rounded-2xl relative group overflow-hidden">
                        <div class="absolute -right-4 -top-0 text-blue-500/5 text-6xl font-black space-mono opacity-0 group-hover:opacity-100 transition-opacity">VƯỢNG TÀI</div>
                        <div class="flex justify-between items-start mb-8">
                            <span class="bg-blue-500/10 text-blue-400 text-[9px] px-3 py-1 rounded-full tracking-widest uppercase font-bold">Tứ Quý</span>
                            <i class="ri-bookmark-line text-white/20"></i>
                        </div>
                        <h2 class="plate-num space-mono text-4xl font-bold text-white mb-8">30K-<?php echo $query; ?></h2>
                        <div class="flex justify-end">
                            <span class="text-white/80 space-mono text-lg italic">2.450.000.000 <small class="text-[10px] text-white/40">VND</small></span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </section>

        <section id="moto-vault" class="vault-container pb-20">
            <h3 class="text-[10px] tracking-[5px] text-white/30 uppercase mb-10 flex items-center gap-4 p-5">
                <i class="ri-motorbike-line"></i> Moto-Vault Allocation
            </h3>
            <div class="discovery-grid grid grid-cols-1 xl:grid-cols-2 gap-6">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="treasure-card p-8 rounded-2xl relative group overflow-hidden">
                        <div class="absolute -right-0 -top-0 text-cyan-500/5 text-6xl font-black space-mono opacity-0 group-hover:opacity-100 transition-opacity"
                            style="top: 15px; right: 25px;">ĐẠI CÁT</div>
                        <div class="flex justify-between items-start mb-8">
                            <span class="bg-cyan-500/10 text-cyan-400 text-[9px] px-3 py-1 rounded-full tracking-widest uppercase font-bold">Lộc Phát</span>
                            <i class="ri-bookmark-line text-white/20"></i>
                        </div>
                        <h2 class="plate-num space-mono text-3xl font-bold text-white mb-8 text-center">29-G1<br><?php echo $query; ?></h2>
                        <div class="flex justify-end">
                            <span class="text-white/80 space-mono text-lg italic">450.000.000 <small class="text-[10px] text-white/40">VND</small></span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </section>
    </main>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <nav id="strategic-filter" class="sticky top-0 z-[80] w-full px-6 py-4 transition-all duration-500" style="background-color: #000814;">
        <div class="max-w-[1400px] mx-auto">
            <div class="glass-filter rounded-2xl md:rounded-full px-8 py-3 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-4 border border-white/10 shadow-2xl">

                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar w-full md:w-auto">
                    <span class="text-[10px] tracking-widest text-white/40 uppercase mr-2 hidden lg:block">Phân loại:</span>
                    <button class="filter-tag active" data-filter="all">Tất cả</button>
                    <button class="filter-tag" data-filter="tiet-tien">Sảnh tiến</button>
                    <button class="filter-tag" data-filter="tu-quy">Tứ quý</button>
                    <button class="filter-tag" data-filter="loc-phat">Lộc phát</button>
                </div>

                <div class="flex items-center gap-5 border-x border-white/10 px-8 hidden xl:flex">
                    <button class="element-btn kim" title="Hành Kim">
                        <div class="dot"></div>
                    </button>
                    <button class="element-btn moc" title="Hành Mộc">
                        <div class="dot"></div>
                    </button>
                    <button class="element-btn thuy" title="Hành Thủy">
                        <div class="dot"></div>
                    </button>
                    <button class="element-btn hoa" title="Hành Hỏa">
                        <div class="dot"></div>
                    </button>
                    <button class="element-btn tho" title="Hành Thổ">
                        <div class="dot"></div>
                    </button>
                </div>

                <div class="flex-1 max-w-xs px-4 hidden md:block">
                    <div class="flex justify-between mb-1">
                        <span class="text-[9px] text-white/40 uppercase tracking-tighter">Budget Range</span>
                        <span id="price-label" class="text-[10px] text-blue-400 space-mono">0 - 5B</span>
                    </div>
                    <input type="range" min="0" max="5000" value="5000" class="price-slider w-full cursor-pointer" id="price-range">
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <span id="result-count" class="block text-blue-400 space-mono text-lg leading-none">39</span>
                        <span class="text-[8px] text-white/30 uppercase tracking-widest">Kết quả</span>
                    </div>
                    <button class="bg-blue-600 hover:bg-white hover:text-blue-600 text-white px-6 py-2.5 rounded-full text-[10px] font-bold tracking-[2px] transition-all duration-500 flex items-center gap-2">
                        <i class="ri-equalizer-line"></i>
                        <span class="hidden sm:inline">LỌC CHUYÊN SÂU</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <button id="mobile-filter-fab" class="md:hidden fixed bottom-8 right-6 w-14 h-14 bg-blue-600 rounded-full shadow-2xl z-[90] flex items-center justify-center text-white text-2xl border border-white/20">
        <i class="ri-filter-3-line"></i>
    </button>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // 1. Hiệu ứng Radar Pulse & Staggered Entrance
    window.addEventListener('load', () => {
        const beam = document.getElementById('radar-beam');

        const tl = gsap.timeline();

        // Hiệu ứng tia sáng quét
        tl.set(beam, {
                visibility: 'visible'
            })
            .to(beam, {
                x: "-50vw",
                duration: 1,
                ease: "power2.inOut"
            })
            .to(beam, {
                x: "50vw",
                duration: 1.5,
                ease: "power2.inOut"
            }, "-=0.5")
            .to(beam, {
                opacity: 0,
                duration: 0.5
            });

        // Hiệu ứng hiện thẻ tuần tự
        gsap.to(".treasure-card", {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.1,
            ease: "expo.out",
            delay: 0.5
        });
    });

    // 2. Mobile Tab Switching
    function switchTab(type) {
        const autoVault = document.getElementById('auto-vault');
        const motoVault = document.getElementById('moto-vault');
        const btnAuto = document.getElementById('btn-auto');
        const btnMoto = document.getElementById('btn-moto');

        if (type === 'auto') {
            autoVault.classList.add('active-tab');
            motoVault.classList.remove('active-tab');
            btnAuto.classList.add('bg-blue-600/20', 'border-blue-500/50');
            btnMoto.classList.remove('bg-blue-600/20', 'border-blue-500/50');
        } else {
            motoVault.classList.add('active-tab');
            autoVault.classList.remove('active-tab');
            btnMoto.classList.add('bg-blue-600/20', 'border-blue-500/50');
            btnAuto.classList.remove('bg-blue-600/20', 'border-blue-500/50');
        }

        // Re-run animation cho tab mới
        gsap.from(".active-tab .treasure-card", {
            opacity: 0,
            x: type === 'auto' ? -20 : 20,
            stagger: 0.05,
            duration: 0.5
        });
    }

    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Smart Sticky: Hiện thanh lọc khi cuộn ngược lên
        let lastScrollTop = 0;
        const filterNav = document.getElementById('strategic-filter');

        window.addEventListener('scroll', () => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                filterNav.style.transform = "translateY(-100%)";
            } else {
                filterNav.style.transform = "translateY(0)";
                filterNav.classList.add('glass-filter'); // Thêm nền khi cuộn
            }
            lastScrollTop = scrollTop;
        });

        // 2. Layout Shuffle (Dùng cho các thẻ biển số ở Section 1)
        const tags = document.querySelectorAll('.filter-tag');
        const cards = document.querySelectorAll('.treasure-card');

        tags.forEach(tag => {
            tag.addEventListener('click', () => {
                tags.forEach(t => t.classList.remove('active'));
                tag.classList.add('active');

                const filterValue = tag.getAttribute('data-filter');

                // Hiệu ứng "Shuffle"
                gsap.to(cards, {
                    scale: 0.8,
                    opacity: 0,
                    duration: 0.3,
                    stagger: 0.05,
                    onComplete: () => {
                        // Logic lọc thực tế (Ở đây chỉ demo hiệu ứng hiện lại)
                        gsap.to(cards, {
                            scale: 1,
                            opacity: 1,
                            duration: 0.5,
                            stagger: 0.05,
                            ease: "back.out(1.7)"
                        });

                        // Cập nhật bộ đếm ảo
                        animateCounter('result-count', Math.floor(Math.random() * 30) + 1);
                    }
                });
            });
        });

        // 3. Floating Counter Animation
        function animateCounter(id, targetValue) {
            const obj = document.getElementById(id);
            let current = parseInt(obj.innerText);
            gsap.to({
                val: current
            }, {
                val: targetValue,
                duration: 1,
                onUpdate: function() {
                    obj.innerText = Math.floor(this.targets()[0].val);
                }
            });
        }

        // 4. Haptic Feedback Simulation (Price Slider)
        const slider = document.getElementById('price-range');
        slider.addEventListener('input', (e) => {
            const val = e.target.value;
            document.getElementById('price-label').innerText = `0 - ${val}M`;

            // Giả lập Haptic nếu mobile hỗ trợ
            if (val % 1000 === 0 && window.navigator.vibrate) {
                window.navigator.vibrate(10);
            }
        });
    });

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>