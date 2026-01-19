<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            overflow-x: hidden;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* 1. Dynamic Grid Animation */
        .grid-lines {
            /* Sử dụng translate3d để đẩy việc render lên card đồ họa */
            will-change: transform;
            transform: translate3d(0, 0, 0);
            animation: grid-zoom 15s linear infinite;
        }

        @keyframes grid-zoom {
            from {
                transform: perspective(1000px) rotateX(20deg) translate3d(0, 0, 0);
            }

            to {
                transform: perspective(1000px) rotateX(20deg) translate3d(0, 50px, 0);
            }
        }

        /* 2. Optimized Data Streams */
        .stream-line {
            will-change: transform;
            animation: stream-flow 3s linear infinite;
        }

        @keyframes stream-flow {
            to {
                transform: translate3d(0, 100vh, 0);
                opacity: 0;
            }
        }

        /* 3. Sticky Morphing Class (Kích hoạt bởi GSAP) */
        #crystal-console.sticky-mode {
            position: fixed;
            top: 20px;
            /* Cách header một khoảng để không bị đè */
            z-index: 1000;
        }

        #crystal-console.sticky-mode label,
        #crystal-console.sticky-mode .md\:flex,
        #crystal-console.sticky-mode .lg\:col-span-3 {
            display: none !important;
            /* Thu gọn khi dính */
        }

        #crystal-console {
            /* Hạn chế backdrop-filter quá cao trên mobile */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            /* Giảm shadow phức tạp khi cuộn */
            transition: width 0.4s cubic-bezier(0.25, 1, 0.5, 1),
                padding 0.4s ease,
                border-radius 0.4s ease;
        }

        #crystal-console.is-morphing {
            background: rgba(0, 13, 26, 0.8);
            backdrop-blur: 20px;
            border-color: rgba(0, 127, 255, 0.3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        /* Ẩn các thành phần thừa khi thu nhỏ trên Desktop */
        .is-morphing .hide-on-sticky {
            display: none !important;
        }

        /* Đảm bảo container không bị hẫng chiều cao khi pin */
        #command-center {
            overflow: visible !important;
        }

        /* 4. Mobile Bottom Sheet */
        #bottom-sheet {
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.32, 0.72, 0, 1);
        }

        #bottom-sheet.open {
            transform: translateY(0);
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Masonry Logic cho Desktop */
        @media (min-width: 1024px) {


            .legacy-card:nth-child(3) {
                margin-top: 40px;
            }
        }

        /* Digital Case Style */
        .digital-case {
            position: relative;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .chrome-border {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .silver-border {
            border-color: rgba(192, 192, 192, 0.2);
        }

        .legacy-card:hover .digital-case {
            background: rgba(255, 255, 255, 0.05);
            border-color: #007FFF;
            box-shadow: 0 20px 40px rgba(0, 127, 255, 0.15);
        }

        /* Hiệu ứng Zoom Silhouette */
        .car-silhouette {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.05;
            filter: grayscale(1) invert(1);
            transition: all 1s ease;
            pointer-events: none;
        }

        .legacy-card:hover .car-silhouette {
            opacity: 0.15;
            transform: scale(1.2) rotate(-3deg);
        }

        /* Typography */
        .plate-num {
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }

        .tag-ribbon {
            position: absolute;
            top: 20px;
            left: -10px;
            background: #007FFF;
            color: white;
            padding: 4px 15px;
            font-size: 10px;
            font-weight: 900;
            border-radius: 0 4px 4px 0;
            transform: rotate(-5deg);
            z-index: 20;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Tối ưu Mobile */
        @media (max-width: 640px) {
            #destiny-grid {
                gap: 12px;
            }

            .digital-case {
                border-radius: 20px;
                padding: 1.5rem !important;
            }

            .plate-num {
                font-size: 2rem !important;
            }
        }

        #destiny-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            align-items: start;
            will-change: transform;
            /* Bật tăng tốc phần cứng */
        }

        @media (min-width: 1024px) {
            #destiny-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 30px;
            }

            /* Tạo Masonry bằng CSS thay vì JS để giảm lag */
            .legacy-card:nth-child(even) {
                transform: translateY(40px) !important;
            }
        }

        .digital-case {
            position: relative;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            /* Giảm độ nhòe để mượt hơn */
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        /* Chỉ hover trên thiết bị có chuột mới chạy hiệu ứng nặng */
        @media (hover: hover) {
            .legacy-card:hover .digital-case {
                border-color: #007FFF;
                box-shadow: 0 15px 30px rgba(0, 127, 255, 0.1);
            }

            .legacy-card:hover .car-silhouette {
                transform: scale(1.1) translateZ(0);
                opacity: 0.15;
            }
        }

        .car-silhouette {
            position: absolute;
            inset: 0;
            opacity: 0.05;
            filter: grayscale(1) invert(1);
            transition: transform 0.6s ease, opacity 0.6s ease;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .plate-num {
            font-size: clamp(1.2rem, 3vw, 2.5rem);
            font-weight: 800;
            color: #fff;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <!-- <section id="command-center" class="relative min-h-screen bg-[#000D1A] flex items-center pt-20 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="grid-lines absolute inset-0 opacity-20"
                style="background-image: linear-gradient(var(--electric-blue) 1px, transparent 1px), linear-gradient(90deg, var(--electric-blue) 1px, transparent 1px); background-size: 50px 50px;"></div>
            <div class="data-streams absolute inset-0 overflow-hidden opacity-30">
                <div class="stream-line absolute w-[1px] h-40 bg-gradient-to-b from-transparent via-[#007FFF] to-transparent left-1/4 -top-40"></div>
                <div class="stream-line absolute w-[1px] h-40 bg-gradient-to-b from-transparent via-[#007FFF] to-transparent left-3/4 -top-40"></div>
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div id="headline-block" class="mb-12 text-left">
                <h1 class="serif-title text-6xl md:text-8xl text-white font-bold leading-tight mb-4 uppercase tracking-tighter">
                    Truy Tìm <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-400 to-[#007FFF]">Di Sản</span>
                </h1>
                <p class="sans-text text-blue-200/60 text-lg md:text-xl max-w-lg tracking-wide">
                    Lọc theo phong thủy, tỉnh thành hoặc dòng số độc bản.
                </p>
            </div>

            <div id="crystal-console-wrapper" class="w-full">
                <div id="crystal-console" class="relative bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-[0_0_50px_rgba(0,127,255,0.1)]">

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                        <div class="lg:col-span-3 hide-on-sticky">
                            <label class="block text-[10px] tracking-[3px] text-blue-400 uppercase mb-4 font-bold">Phân vùng thiết bị</label>
                            <div class="flex bg-black/40 p-1 rounded-full border border-white/5 relative h-14">
                                <div id="toggle-active" class="absolute w-[calc(50%-4px)] h-[calc(100%-8px)] bg-[#007FFF] rounded-full shadow-[0_0_15px_rgba(0,127,255,0.5)] transition-all duration-300"></div>
                                <button onclick="toggleDevice('auto')" class="relative z-10 flex-1 text-xs font-bold text-white uppercase tracking-widest">Ô Tô</button>
                                <button onclick="toggleDevice('moto')" class="relative z-10 flex-1 text-xs font-bold text-white/40 uppercase tracking-widest">Xe Máy</button>
                            </div>
                        </div>

                        <div class="lg:col-span-5 relative group">
                            <label class="block text-[10px] tracking-[3px] text-blue-400 uppercase mb-4 font-bold">Mã số định danh</label>
                            <div class="relative overflow-hidden rounded-2xl">
                                <input type="text" placeholder="Nhập dãy số may mắn..."
                                    class="w-full bg-white/5 border border-white/10 p-4 pl-12 text-white placeholder-white/20 focus:outline-none focus:border-[#007FFF] transition-all">
                                <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-xl group-hover:text-[#007FFF]"></i>
                                <div class="absolute bottom-0 left-0 h-[2px] bg-[#007FFF] w-0 group-focus-within:w-full transition-all duration-500"></div>
                            </div>
                        </div>

                        <div class="lg:col-span-4 grid grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-[10px] tracking-[3px] text-blue-400 uppercase mb-4 font-bold">Khu vực</label>
                                <select class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white text-sm focus:outline-none appearance-none cursor-pointer hover:bg-white/10">
                                    <option>Toàn quốc</option>
                                    <option>Hà Nội (29-30)</option>
                                    <option>TP. HCM (50-59)</option>
                                </select>
                            </div>
                            <div class="relative">
                                <label class="block text-[10px] tracking-[3px] text-blue-400 uppercase mb-4 font-bold">Dòng biển</label>
                                <select class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white text-sm focus:outline-none appearance-none cursor-pointer hover:bg-white/10">
                                    <option>Tất cả loại</option>
                                    <option>Ngũ Quý</option>
                                    <option>Sảnh Tiến</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:flex flex-wrap gap-3 mt-8 pt-8 border-t border-white/5 hide-on-sticky">
                        <span class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-[10px] text-white/60 hover:text-[#007FFF] hover:border-[#007FFF] cursor-pointer transition-all uppercase tracking-widest">Dưới 50 Tr</span>
                        <span class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-[10px] text-white/60 hover:text-[#007FFF] hover:border-[#007FFF] cursor-pointer transition-all uppercase tracking-widest">Tam Hoa</span>
                        <span class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-[10px] text-white/60 hover:text-[#007FFF] hover:border-[#007FFF] cursor-pointer transition-all uppercase tracking-widest">Phát Lộc (86)</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobile-hub" class="fixed bottom-6 right-6 z-[100] md:hidden">
            <button onclick="toggleMobileSheet()" class="w-16 h-16 bg-[#007FFF] rounded-full shadow-[0_0_20px_rgba(0,127,255,0.5)] flex items-center justify-center text-white text-2xl">
                <i class="ri-equalizer-fill"></i>
            </button>
        </div>
    </section> -->

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="grid-destiny" class="relative py-20 bg-[#000D1A] overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="mb-16 text-left max-w-2xl">
                <h2 class="text-blue-400 text-xs tracking-[0.5em] uppercase mb-4 font-bold">The Digital Inventory</h2>
                <h3 class="serif-title text-4xl md:text-5xl text-white">Lưới Phân Định <span class="text-blue-500 italic">Vận Mệnh</span></h3>
            </div>

            <div id="destiny-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 items-start">

                <div class="legacy-card auto group col-span-2" data-tilt>
                    <div class="digital-case chrome-border p-6 md:p-10 min-h-[220px] flex flex-col justify-between" style="margin: 30px;">
                        <div class="tag-ribbon">VIP HERITAGE</div>
                        <div class="car-silhouette">
                            <img src="https://fumo.com.vn/wp-content/uploads/2025/06/ly-do-hinh-nen-lamborghini-duoc-tim-kiem-nhieu.jpg" class="w-2/3">
                        </div>
                        <div class="card-inner relative z-10 text-center py-4">
                            <h4 class="plate-num text-4xl md:text-6xl font-black text-white tracking-tighter">30K - 888.88</h4>
                        </div>
                        <div class="relative z-10 flex justify-between items-end">
                            <div class="actions flex gap-3 opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0">
                                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center"><i class="ri-search-eye-line text-white"></i></button>
                                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-red-500 flex items-center justify-center"><i class="ri-heart-fill text-white"></i></button>
                            </div>
                            <div class="price-box text-right">
                                <p class="text-[10px] text-white/40 uppercase tracking-widest">Giá sở hữu</p>
                                <p class="price text-xl md:text-2xl font-bold text-[#007FFF]">2.450.000.000đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="digital-case chrome-border p-6 md:p-10 min-h-[220px] flex flex-col justify-between" style="margin: 30px;">
                        <div class="tag-ribbon">VIP HERITAGE</div>
                        <div class="car-silhouette">
                            <img src="https://fumo.com.vn/wp-content/uploads/2025/06/ly-do-hinh-nen-lamborghini-duoc-tim-kiem-nhieu.jpg" class="w-2/3">
                        </div>
                        <div class="card-inner relative z-10 text-center py-4">
                            <h4 class="plate-num text-4xl md:text-6xl font-black text-white tracking-tighter">30K - 888.88</h4>
                        </div>
                        <div class="relative z-10 flex justify-between items-end">
                            <div class="actions flex gap-3 opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0">
                                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center"><i class="ri-search-eye-line text-white"></i></button>
                                <button class="w-10 h-10 rounded-full bg-white/10 hover:bg-red-500 flex items-center justify-center"><i class="ri-heart-fill text-white"></i></button>
                            </div>
                            <div class="price-box text-right">
                                <p class="text-[10px] text-white/40 uppercase tracking-widest">Giá sở hữu</p>
                                <p class="price text-xl md:text-2xl font-bold text-[#007FFF]">2.450.000.000đ</p>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="legacy-card moto group" data-tilt>
                    <div class="digital-case silver-border p-6 aspect-[4/5] flex flex-col justify-between">
                        <div class="tag-ribbon !bg-gray-600">SẢNH TIẾN</div>
                        <div class="car-silhouette">
                            <img src="https://hoangvietauto.vn/wp-content/uploads/E1BAA2nh-siC3AAu-xe-C491E1BAB9p-chE1BAA5t-lC6B0E1BBA3ng-cao.jpg" class="w-3/4">
                        </div>
                        <div class="card-inner relative z-10 text-center moto-style">
                            <p class="plate-top text-lg text-white/60 font-mono">29-G1</p>
                            <p class="plate-bottom text-3xl text-white font-black tracking-widest">567.89</p>
                        </div>
                        <div class="price-box text-center relative z-10">
                            <p class="price text-lg font-bold text-[#007FFF]">385.000.000đ</p>
                        </div>
                    </div>
                </div>

                <div class="legacy-card moto group" data-tilt>
                    <div class="digital-case silver-border p-6 aspect-[4/5] flex flex-col justify-between">
                        <div class="tag-ribbon">PHÁT LỘC</div>
                        <div class="car-silhouette">
                            <img src="https://hoangvietauto.vn/wp-content/uploads/E1BAA2nh-siC3AAu-xe-C491E1BAB9p-chE1BAA5t-lC6B0E1BBA3ng-cao.jpg" class="w-3/4">
                        </div>
                        <div class="card-inner relative z-10 text-center moto-style pt-10">
                            <p class="plate-top text-lg text-white/60 font-mono">59-S3</p>
                            <p class="plate-bottom text-3xl text-white font-black tracking-widest">868.68</p>
                        </div>
                        <div class="price-box text-center relative z-10">
                            <p class="price text-lg font-bold text-[#007FFF]">125.000.000đ</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-20 text-center">
                <button id="btn-load-more" class="group relative px-10 py-4 overflow-hidden rounded-full border border-blue-500/50">
                    <span class="relative z-10 text-blue-400 font-bold tracking-widest text-xs uppercase group-hover:text-white transition-colors duration-300">Mở rộng kho di sản</span>
                    <div class="absolute inset-0 bg-blue-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </button>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php
    include "footer.php";
    ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //

    document.addEventListener('DOMContentLoaded', () => {
        const consoleElem = document.getElementById('crystal-console');
        const wrapper = document.getElementById('crystal-console-wrapper');

        // 1. BOOT ANIMATION: Sử dụng force3D để mượt hơn
        const bootTl = gsap.timeline({
            defaults: {
                force3D: true
            }
        });
        bootTl.from(consoleElem, {
                scaleX: 0,
                opacity: 0,
                duration: 1,
                ease: "expo.out"
            })
            .from("#crystal-console > div > div", {
                opacity: 0,
                y: 15,
                stagger: 0.05,
                duration: 0.5
            }, "-=0.5");

        

        // 3. TỐI ƯU INPUT (Chỉ chạy khi thực sự cần)
        const searchInput = consoleElem.querySelector('input');
        searchInput.addEventListener('focus', () => {
            gsap.to(consoleElem, {
                borderColor: "rgba(0, 127, 255, 0.6)",
                boxShadow: "0 0 20px rgba(0, 127, 255, 0.2)",
                duration: 0.3
            });
        });
        searchInput.addEventListener('blur', () => {
            gsap.to(consoleElem, {
                borderColor: "rgba(255, 255, 255, 0.1)",
                boxShadow: "none",
                duration: 0.3
            });
        });

        // 4. PREVENT LAYOUT SHIFT
        ScrollTrigger.addEventListener("refreshInit", () => {
            // Giữ vị trí console ổn định khi trình duyệt tính toán lại
            gsap.set(consoleElem, {
                clearProps: "all"
            });
        });
    });
    // ----------------------------- section 2 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Reveal & Glide (Các con số trượt vào khi cuộn)
        gsap.utils.toArray('.legacy-card').forEach((card, i) => {
            const plateContent = card.querySelector('.card-inner');

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: card,
                    start: "top 90%",
                    toggleActions: "play none none reverse"
                }
            });

            tl.from(card, {
                y: 60,
                opacity: 0,
                duration: 0.8,
                ease: "power3.out"
            }).from(plateContent, {
                x: -40,
                opacity: 0,
                duration: 0.8,
                ease: "power2.out"
            }, "-=0.4");
        });

        // 2. 3D Tilt Effect
        if (window.innerWidth > 1024) {
            VanillaTilt.init(document.querySelectorAll(".legacy-card"), {
                max: 10,
                speed: 400,
                glare: true,
                "max-glare": 0.2,
            });
        }

        // 3. Spiral Loading Effect cho nút Xem thêm
        const btnLoad = document.getElementById('btn-load-more');
        btnLoad.addEventListener('click', () => {
            gsap.to(".legacy-card", {
                duration: 0.8,
                scale: 0.95,
                stagger: {
                    each: 0.05,
                    from: "center",
                    grid: "auto"
                },
                yoyo: true,
                repeat: 1,
                ease: "power2.inOut"
            });
            // Logic thực tế để gọi thêm dữ liệu sẽ ở đây
        });
    });

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>