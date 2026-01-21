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
            /* color: white; */
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            min-height: 0;
            background: linear-gradient(135deg, #000000 0%, #000000 100%);
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
        /* Bệ đỡ cẩm thạch 3D */
        .pedestal-container {
            perspective: 1200px;
            width: 100%;
            max-width: 600px;
        }

        .marble-pedestal {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%) rotateX(70deg);
            width: 80%;
            height: 200px;
            background: radial-gradient(ellipse at center, #1a1a1a 0%, #000 70%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.8), 0 0 40px rgba(0, 127, 255, 0.1);
            border-radius: 50%;
        }

        /* Hiệu ứng kính spec */
        .glass-spec {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.01) 100%);
        }

        /* Nút kích hoạt */
        .active-v-btn {
            background: #007FFF !important;
            border-color: #007FFF !important;
            box-shadow: 0 0 20px rgba(0, 127, 255, 0.4);
        }

        /* Animation cho biển số khi bay */
        .ghost-plate {
            position: fixed;
            z-index: 9999;
            pointer-events: none;
            background: white;
            color: black;
            font-family: 'Space Mono';
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0, 127, 255, 0.5);
        }

        /* ----------------------------- section 4 -----------------------------  */
        /* Flip Card CSS */
        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }

        .backface-hidden {
            backface-visibility: hidden;
        }

        .rotate-y-180 {
            transform: rotateY(180deg);
        }

        .flip-card-container:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        /* Magnetic Area */
        #magnetic-area {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile floating icons */
        .floating-contact {
            animation: pulse-blue 2s infinite;
        }

        @keyframes pulse-blue {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 127, 255, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(0, 127, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 127, 255, 0);
            }
        }

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

    <div class="flex md:hidden justify-center gap-4 p-3 px-6" style="background-color: #000814; color: #fff;">
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
    <div id="mobile-filter-overlay" class="fixed inset-0 z-[100] hidden">
        <div id="filter-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0"></div>

        <div id="filter-sheet" class="absolute bottom-0 left-0 w-full bg-[#000d1a] rounded-t-[30px] p-8 border-t border-white/10 transform translate-y-full">
            <div class="w-12 h-1.5 bg-white/20 rounded-full mx-auto mb-8"></div>

            <h3 class="serif text-white text-2xl mb-6">Bộ Lọc Chuyên Sâu</h3>

            <div class="space-y-8">
                <div>
                    <p class="text-[10px] tracking-[3px] text-white/40 uppercase mb-4">Loại hình di sản</p>
                    <div class="flex flex-wrap gap-3">
                        <button class="filter-tag active">Tất cả</button>
                        <button class="filter-tag">Sảnh tiến</button>
                        <button class="filter-tag">Tứ quý</button>
                        <button class="filter-tag">Lộc phát</button>
                    </div>
                </div>

                <div>
                    <p class="text-[10px] tracking-[3px] text-white/40 uppercase mb-4">Tương hợp Ngũ hành</p>
                    <div class="flex justify-between bg-white/5 p-4 rounded-2xl">
                        <button class="element-btn kim scale-125">
                            <div class="dot"></div>
                        </button>
                        <button class="element-btn moc scale-125">
                            <div class="dot"></div>
                        </button>
                        <button class="element-btn thuy scale-125">
                            <div class="dot"></div>
                        </button>
                        <button class="element-btn hoa scale-125">
                            <div class="dot"></div>
                        </button>
                        <button class="element-btn tho scale-125">
                            <div class="dot"></div>
                        </button>
                    </div>
                </div>

                <button id="close-filter-mobile" class="w-full py-4 bg-blue-600 text-white font-bold rounded-2xl tracking-[2px] text-xs">ÁP DỤNG BỘ LỌC</button>
            </div>
        </div>
    </div>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="reality-preview" class="relative min-h-screen bg-[#00050a] py-24 px-6 overflow-hidden border-t border-white/5">

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-4 order-2 lg:order-1">
                <div class="glass-spec p-8 rounded-3xl border border-white/10 backdrop-blur-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>

                    <span class="text-[10px] tracking-[5px] text-blue-500 uppercase">Quick Analysis</span>
                    <h3 id="preview-plate-display" class="space-mono text-3xl text-white mt-4 mb-8">000.00</h3>

                    <div class="space-y-6">
                        <div class="flex justify-between border-b border-white/5 pb-4">
                            <span class="text-white/40 text-xs">Phong thủy</span>
                            <span id="spec-fengshui" class="text-white text-xs font-bold uppercase tracking-widest">Đại cát - Kim</span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-4">
                            <span class="text-white/40 text-xs">Giá chốt nhanh</span>
                            <span id="spec-price" class="text-blue-400 space-mono font-bold">---</span>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-10">
                        <button onclick="switchVehicle('auto')" id="btn-view-auto" class="flex-1 py-4 bg-white/5 border border-white/10 rounded-xl text-[9px] tracking-[2px] font-bold text-white hover:bg-blue-600 transition-all active-v-btn">XEM TRÊN Ô TÔ</button>
                        <button onclick="switchVehicle('moto')" id="btn-view-moto" class="flex-1 py-4 bg-white/5 border border-white/10 rounded-xl text-[9px] tracking-[2px] font-bold text-white hover:bg-blue-600 transition-all">XEM TRÊN XE MÁY</button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 order-1 lg:order-2 relative min-h-[500px] flex items-center justify-center">
                <div class="pedestal-container relative">
                    <div class="marble-pedestal"></div>

                    <div id="vehicle-model" class="relative z-10 transition-all duration-700 transform-gpu">
                        <img id="model-img" src="350-xanh-tt.webp" class="w-full max-w-lg mx-auto grayscale opacity-50 brightness-150" alt="Vehicle Model">

                        <div id="snap-point" class="absolute top-1/2 left-1/2 -translate-x-1/2 translate-y-8 w-32 h-10 border border-blue-500/30 bg-blue-500/5 backdrop-blur-sm flex items-center justify-center overflow-hidden">
                            <div id="target-plate" class="text-black font-black text-[10px] space-mono bg-white px-2 py-1 rounded shadow-lg opacity-0"></div>
                            <div class="snap-flash absolute inset-0 bg-blue-400 opacity-0"></div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 text-center w-full">
                    <p class="serif-italic text-white/20 text-sm italic">Xoay để cảm nhận ánh sáng phản chiếu trên lớp dập nổi kim loại</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="acquisition-hub" class="relative min-h-screen bg-gradient-to-b from-[#00050a] to-[#000000] py-32 px-6 overflow-hidden">

        <div id="beacon-line" class="absolute left-1/2 top-0 w-[1px] h-full bg-gradient-to-b from-blue-500 via-cyan-400 to-transparent -translate-x-1/2 opacity-30"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-24 h-20">
                <h2 id="morphing-text" class="serif text-white text-4xl md:text-5xl tracking-tight">Tìm thấy báu vật?</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">

                <div class="hub-lane p-10 rounded-[40px] bg-white/[0.02] border border-white/5 backdrop-blur-2xl hover:border-blue-500/30 transition-all duration-700">
                    <span class="text-[10px] tracking-[5px] text-blue-500 uppercase block mb-6">Lối 01 // Gợi ý tối ưu</span>
                    <h3 class="text-white text-2xl mb-10 serif">Sở hữu ngay di sản tương đồng</h3>

                    <div class="space-y-4 mb-12">
                        <div class="flex justify-between items-center p-4 border-b border-white/5 hover:bg-white/5 transition-colors group">
                            <span class="space-mono text-white group-hover:text-blue-400">30K-889.88</span>
                            <span class="text-xs text-white/40 italic">Đại cát - 1.2 tỷ</span>
                        </div>
                        <div class="flex justify-between items-center p-4 border-b border-white/5 hover:bg-white/5 transition-colors group">
                            <span class="space-mono text-white group-hover:text-blue-400">30K-888.89</span>
                            <span class="text-xs text-white/40 italic">Tiến bước - 950tr</span>
                        </div>
                    </div>

                    <button class="w-full py-4 border border-blue-500/50 text-blue-400 text-[10px] tracking-[4px] font-bold uppercase hover:bg-blue-500 hover:text-white transition-all">Xem danh sách mở rộng</button>
                </div>

                <div class="flip-card-container h-[450px] perspective-1000">
                    <div class="flip-card-inner relative w-full h-full transition-transform duration-1000 transform-style-3d cursor-pointer">

                        <div class="flip-front absolute inset-0 backface-hidden p-10 rounded-[40px] bg-blue-600/10 border border-blue-500/20 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] tracking-[5px] text-cyan-400 uppercase block mb-6">Lối 02 // Đặc quyền VIP</span>
                                <h3 class="text-white text-3xl serif leading-tight">Chưa tìm thấy<br>dãy số định mệnh?</h3>
                            </div>
                            <p class="text-white/60 text-sm leading-relaxed">Kích hoạt đội ngũ "Heritage Hunter" để săn tìm đúng dãy số bạn mong muốn trong kho số quốc gia.</p>
                            <div class="text-cyan-400 text-[10px] font-bold tracking-[2px]">HOVER ĐỂ XEM QUY TRÌNH ➔</div>
                        </div>

                        <div class="flip-back absolute inset-0 backface-hidden p-10 rounded-[40px] bg-[#001a33] border border-blue-500/50 rotate-y-180 flex flex-col justify-center space-y-8">
                            <div class="step flex gap-6">
                                <span class="space-mono text-2xl text-blue-500">01</span>
                                <p class="text-white text-sm">Gửi yêu cầu dãy số & ngân sách dự kiến.</p>
                            </div>
                            <div class="step flex gap-6">
                                <span class="space-mono text-2xl text-blue-500">02</span>
                                <p class="text-white text-sm">Quản gia check kho & đấu giá ủy quyền.</p>
                            </div>
                            <div class="step flex gap-6">
                                <span class="space-mono text-2xl text-blue-500">03</span>
                                <p class="text-white text-sm">Bàn giao biển số tận nơi trong 7 ngày.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-20 md:mt-32 flex justify-center w-full">
                <div id="magnetic-area" class="p-8 md:p-20 flex justify-center items-center w-full">
                    <button id="magnetic-btn" class="w-full max-w-[300px] md:w-auto bg-cyan-500 text-black px-8 md:px-16 py-5 md:py-6 rounded-full font-bold tracking-[3px] md:tracking-[5px] text-[10px] md:text-[11px] uppercase shadow-[0_0_30px_rgba(34,211,238,0.3)] active:scale-95 transition-transform">
                        ĐẶT HÀNG SỐ RIÊNG
                    </button>
                </div>
            </div>
        </div>

        <footer class="mt-32 pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 opacity-40">
            <div class="flex gap-10 items-center">
                <img src="images__1_-removebg-preview.png" class="h-10 grayscale hover:grayscale-0 transition-all duration-500"
                    alt="Secure Certification">
                <span class="text-[9px] tracking-[3px] text-white uppercase">Mã hóa giao dịch quân đội 256-bit</span>
            </div>
            <p class="text-[9px] text-white tracking-[2px]">© 2024 THE GRAND GALLERY. ALL RIGHTS RESERVED.</p>
        </footer>

    </section>

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
        // --- Code bổ sung cho Mobile Filter ---
        const fab = document.getElementById('mobile-filter-fab');
        const overlay = document.getElementById('mobile-filter-overlay');
        const backdrop = document.getElementById('filter-backdrop');
        const sheet = document.getElementById('filter-sheet');
        const closeBtn = document.getElementById('close-filter-mobile');

        // Hàm mở bộ lọc
        fab.addEventListener('click', () => {
            overlay.classList.remove('hidden');

            // Rung nhẹ điện thoại (Haptic)
            if (window.navigator.vibrate) window.navigator.vibrate(15);

            gsap.to(backdrop, {
                opacity: 1,
                duration: 0.4
            });
            gsap.to(sheet, {
                y: 0,
                duration: 0.6,
                ease: "expo.out"
            });
        });

        // Hàm đóng bộ lọc
        function closeMobileFilter() {
            gsap.to(backdrop, {
                opacity: 0,
                duration: 0.3
            });
            gsap.to(sheet, {
                y: "100%",
                duration: 0.5,
                ease: "expo.in",
                onComplete: () => {
                    overlay.classList.add('hidden');
                }
            });
        }

        closeBtn.addEventListener('click', closeMobileFilter);
        backdrop.addEventListener('click', closeMobileFilter);
    });

    // ----------------------------- section 3 ----------------------------- //
    // 1. Hàm Teleport Biển số từ Section 1 xuống Section 3
    function previewPlate(element, plateNumber, price, fengshui) {
        // Lấy vị trí bắt đầu (thẻ được click)
        const rect = element.getBoundingClientRect();
        const target = document.getElementById('snap-point').getBoundingClientRect();

        // Tạo Ghost Element
        const ghost = document.createElement('div');
        ghost.className = 'ghost-plate';
        ghost.innerText = plateNumber;
        document.body.appendChild(ghost);

        // Đặt vị trí ban đầu
        gsap.set(ghost, {
            x: rect.left,
            y: rect.top
        });

        // Hiệu ứng bay theo đường cong Bezier
        gsap.to(ghost, {
            duration: 1.2,
            motionPath: {
                path: [{
                        x: rect.left - 100,
                        y: rect.top + (target.top - rect.top) / 2
                    },
                    {
                        x: target.left,
                        y: target.top
                    }
                ],
                curviness: 1.5
            },
            scale: 0.5,
            opacity: 0.8,
            ease: "power2.inOut",
            onComplete: () => {
                ghost.remove();
                triggerMagneticSnap(plateNumber, price, fengshui);
            }
        });
    }

    // 2. Hiệu ứng Magnetic Snap & Flash
    function triggerMagneticSnap(plate, price, fengshui) {
        const targetPlate = document.getElementById('target-plate');
        const flash = document.querySelector('.snap-flash');

        targetPlate.innerText = plate;

        const tl = gsap.timeline();
        tl.to(targetPlate, {
                opacity: 1,
                scale: 1.2,
                duration: 0.1
            })
            .to(targetPlate, {
                scale: 1,
                duration: 0.3,
                ease: "back.out"
            })
            .to(flash, {
                opacity: 0.8,
                duration: 0.1,
                yoyo: true,
                repeat: 1
            })
            .to(flash, {
                opacity: 0,
                duration: 0.5
            });

        // Cập nhật bảng thông số
        document.getElementById('preview-plate-display').innerText = plate;
        document.getElementById('spec-price').innerText = price;
        document.getElementById('spec-fengshui').innerText = fengshui;
    }

    // 3. Xoay mô hình theo chuột
    const stage = document.getElementById('reality-preview');
    const model = document.getElementById('vehicle-model');

    stage.addEventListener('mousemove', (e) => {
        const x = (window.innerWidth / 2 - e.pageX) / 30;
        const y = (window.innerHeight / 2 - e.pageY) / 30;
        gsap.to(model, {
            rotateY: -x,
            rotateX: y,
            duration: 0.5,
            ease: "power1.out"
        });
    });

    // 4. Chuyển đổi loại xe
    function switchVehicle(type) {
        const img = document.getElementById('model-img');
        const btns = [document.getElementById('btn-view-auto'), document.getElementById('btn-view-moto')];

        // Hiệu ứng chuyển cảnh mờ
        gsap.to(img, {
            opacity: 0,
            scale: 0.9,
            duration: 0.3,
            onComplete: () => {
                img.src = type === 'auto' ? 'Armored_Vehicle_Make_e3a8620860.png' : 'anh-mo-ta-removebg-preview.png';
                gsap.to(img, {
                    opacity: 0.5,
                    scale: 1,
                    duration: 0.5
                });
            }
        });

        btns.forEach(b => b.classList.remove('active-v-btn'));
        document.getElementById(`btn-view-${type}`).classList.add('active-v-btn');
    }

    // ----------------------------- section 4 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Text Morphing
        const phrases = ["Tìm thấy báu vật?", "Sở hữu di sản?", "Tạo ra huyền thoại?"];
        let currentIndex = 0;
        const textElement = document.getElementById('morphing-text');

        function morphText() {
            gsap.to(textElement, {
                opacity: 0,
                y: -10,
                duration: 0.8,
                onComplete: () => {
                    currentIndex = (currentIndex + 1) % phrases.length;
                    textElement.innerText = phrases[currentIndex];
                    gsap.to(textElement, {
                        opacity: 1,
                        y: 0,
                        duration: 0.8
                    });
                }
            });
        }
        setInterval(morphText, 3500);

        // 2. Magnetic Button Effect
        const magneticArea = document.getElementById('magnetic-area');
        const magneticBtn = document.getElementById('magnetic-btn');
        // Kiểm tra nếu không phải thiết bị di động
        if (window.innerWidth > 768) {
            magneticArea.addEventListener('mousemove', (e) => {
                const rect = magneticArea.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;

                gsap.to(magneticBtn, {
                    x: x * 0.4,
                    y: y * 0.4,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            magneticArea.addEventListener('mouseleave', () => {
                gsap.to(magneticBtn, {
                    x: 0,
                    y: 0,
                    duration: 0.5,
                    ease: "elastic.out(1, 0.3)"
                });
            });
        } else {
            // Hiệu ứng riêng cho Mobile: Rung khi chạm
            magneticBtn.addEventListener('touchstart', () => {
                if (window.navigator.vibrate) {
                    window.navigator.vibrate(10); // Rung nhẹ 10ms
                }
            });
        }

        magneticArea.addEventListener('mousemove', (e) => {
            const rect = magneticArea.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            gsap.to(magneticBtn, {
                x: x * 0.4,
                y: y * 0.4,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        magneticArea.addEventListener('mouseleave', () => {
            gsap.to(magneticBtn, {
                x: 0,
                y: 0,
                duration: 0.5,
                ease: "elastic.out(1, 0.3)"
            });
        });

        // 3. Beacon Line Animation
        gsap.fromTo("#beacon-line", {
            scaleY: 0,
            transformOrigin: "top"
        }, {
            scaleY: 1,
            duration: 3,
            ease: "none",
            scrollTrigger: {
                trigger: "#acquisition-hub",
                start: "top center",
                scrub: true
            }
        });
    });

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>