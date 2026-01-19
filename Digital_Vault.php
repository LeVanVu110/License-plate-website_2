<?php include "header.php"; ?>
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
            animation: grid-zoom 20s linear infinite;
        }

        @keyframes grid-zoom {
            from {
                transform: perspective(500px) rotateX(20deg) translateY(0);
            }

            to {
                transform: perspective(500px) rotateX(20deg) translateY(50px);
            }
        }

        /* 2. Data Streams Animation */
        .stream-line {
            animation: stream-flow 3s linear infinite;
        }

        @keyframes stream-flow {
            to {
                transform: translateY(100vh);
                opacity: 0;
            }
        }

        /* 3. Sticky Morphing Class (Kích hoạt bởi GSAP) */
        #crystal-console.sticky-mode {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%) scale(0.85);
            width: 90%;
            padding: 1rem 2rem;
            border-radius: 100px;
            z-index: 1000;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        #crystal-console.sticky-mode label,
        #crystal-console.sticky-mode .md\:flex,
        #crystal-console.sticky-mode .lg\:col-span-3 {
            display: none !important;
            /* Thu gọn khi dính */
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
        /* Hiệu ứng Masonry Offset */
        @media (min-width: 768px) {
            #destiny-container>div:nth-child(even) {
                margin-top: 40px;
                /* Tạo độ lệch so le */
            }
        }

        /* Digital Case - Thẻ Ô tô (Chrome) */
        .auto-case {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.01) 100%);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .auto-case::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1rem;
            padding: 1px;
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), transparent, rgba(0, 127, 255, 0.2));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }

        /* Thẻ Xe máy (Matte Silver) */
        .moto-case {
            border: 1px solid rgba(192, 192, 192, 0.1);
        }

        /* Plate Font mô phỏng */
        .plate-number,
        .plate-number-moto {
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.05em;
        }

        /* Glow Line animation */
        .glow-line {
            box-shadow: inset 0 0 20px rgba(0, 127, 255, 0);
        }

        .group:hover .glow-line {
            box-shadow: inset 0 0 20px rgba(0, 127, 255, 0.2);
        }

        /* Mobile Swipe Animations */
        @media (max-width: 768px) {
            .legacy-card {
                transition: transform 0.3s ease-out !important;
            }
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="command-center" class="relative min-h-screen bg-[#000D1A] flex items-center pt-20 overflow-hidden">
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
    // ----------------------------- SECTION 1: THE COMMAND CENTER SCRIPT ----------------------------- //

    document.addEventListener('DOMContentLoaded', () => {
        // Đăng ký ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        const consoleElem = document.getElementById('crystal-console');
        const wrapper = document.getElementById('crystal-console-wrapper');

        // 1. HIỆU ỨNG KHỞI ĐỘNG (SYSTEM BOOT)
        // Chạy ngay khi trang web sẵn sàng
        bootTl.from(consoleElem, {
                clipPath: "inset(0 50% 0 50%)",
                opacity: 0,
                duration: 1.5,
                ease: "expo.inOut"
            })
            .from("#crystal-console > div", {
                opacity: 0,
                y: 20,
                stagger: 0.1,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.5");


        // 2. HIỆU ỨNG STICKY MORPHING (THU NHỎ KHI CUỘN)
        // Timeline này điều khiển việc thu nhỏ thanh Console thành thanh Search gọn nhẹ
        const morphTl = gsap.timeline({
        scrollTrigger: {
            trigger: "#command-center",
            start: "bottom 60%", // Bắt đầu thu nhỏ sớm hơn một chút
            end: "bottom 20%",
            scrub: 1,            // Mượt mà theo tay cuộn
            onEnter: () => consoleElem.classList.add('sticky-mode'),
            onLeaveBack: () => consoleElem.classList.remove('sticky-mode'),
        }
    });

        morphTl.to(consoleElem, {
        width: (window.innerWidth > 1024) ? "75%" : "92%",
        padding: "10px 20px",
        borderRadius: "100px",
        backgroundColor: "rgba(0, 13, 26, 0.85)",
        ease: "none"
    })
    // Ẩn các label và các thành phần không cần thiết để biến thành thanh search mini
    .to(".hide-on-sticky", {
        opacity: 0,
        height: 0,
        margin: 0,
        padding: 0,
        duration: 0.2
    }, 0);


        // 3. LOGIC GHIM THANH SEARCH (PINNING)
        // Đảm bảo thanh Search dính ở trên đầu khi xem các Section tiếp theo
        ScrollTrigger.create({
        trigger: wrapper,
        start: "top 20px",    // Vị trí ghim cách đỉnh màn hình 20px
        endTrigger: "html",   // Ghim cho đến hết trang
        end: "bottom bottom",
        pin: true,            // GSAP tự xử lý position: fixed cực chuẩn
        pinSpacing: false,    // Không đẩy Section 2 xuống dưới
        anticipatePin: 1,
        onUpdate: (self) => {
            // Nếu cuộn ngược lên trên cùng, trả lại trạng thái ban đầu
            if (self.progress === 0) {
                gsap.to(consoleElem, { width: "100%", borderRadius: "2.5rem" });
            }
        }
    });
    ScrollTrigger.refresh();

        // 4. HIỆU ỨNG MAGNETIC INPUT (CẢM ỨNG DỮ LIỆU)
        const searchInput = consoleElem.querySelector('input');
        searchInput.addEventListener('focus', () => {
            gsap.to(".grid-lines", {
                scale: 1.1,
                opacity: 0.4,
                duration: 0.8,
                ease: "power2.out"
            });
            gsap.to(consoleElem, {
                borderColor: "rgba(0, 127, 255, 0.6)",
                boxShadow: "0 0 30px rgba(0, 127, 255, 0.2)",
                duration: 0.4
            });
        });

        searchInput.addEventListener('blur', () => {
            gsap.to(".grid-lines", {
                scale: 1,
                opacity: 0.2,
                duration: 0.8
            });
            gsap.to(consoleElem, {
                borderColor: "rgba(255, 255, 255, 0.1)",
                boxShadow: "0 0 50px rgba(0,127,255,0.1)",
                duration: 0.4
            });
        });


        // 5. MOBILE FLOATING HUB REVEAL
        // Nút tròn điều khiển trên Mobile sẽ hiện ra khi thanh search chính đã thu nhỏ
        const mobileHub = document.getElementById('mobile-hub');
        if (mobileHub) {
            gsap.from(mobileHub, {
                scrollTrigger: {
                    trigger: "#command-center",
                    start: "bottom center",
                    toggleActions: "play reverse play reverse"
                },
                scale: 0,
                opacity: 0,
                duration: 0.5,
                ease: "back.out(1.7)"
            });
        }

        // Refresh lại toàn bộ để cập nhật tọa độ chính xác nhất
        ScrollTrigger.refresh();
    });

    // Hàm chuyển đổi Ô tô / Xe máy (Phần cơ học)
    function toggleDevice(type) {
        const slider = document.getElementById('toggle-active');
        const buttons = document.querySelectorAll('#crystal-console button');

        if (type === 'auto') {
            gsap.to(slider, {
                x: "0%",
                duration: 0.4,
                ease: "power2.out"
            });
            buttons[0].classList.replace('text-white/40', 'text-white');
            buttons[1].classList.replace('text-white', 'text-white/40');
        } else {
            gsap.to(slider, {
                x: "100%",
                duration: 0.4,
                ease: "power2.out"
            });
            buttons[1].classList.replace('text-white/40', 'text-white');
            buttons[0].classList.replace('text-white', 'text-white/40');
        }

        // Đồng bộ với việc lọc dữ liệu ở Section 2 (nếu có)
        if (typeof switchGallery === "function") {
            switchGallery(type);
        }
    }
    // ----------------------------- section 2 ----------------------------- //


    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>