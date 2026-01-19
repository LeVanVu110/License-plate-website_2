<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* 1. Dynamic Grid Animation */
.grid-lines {
    animation: grid-zoom 20s linear infinite;
}

@keyframes grid-zoom {
    from { transform: perspective(500px) rotateX(20deg) translateY(0); }
    to { transform: perspective(500px) rotateX(20deg) translateY(50px); }
}

/* 2. Data Streams Animation */
.stream-line {
    animation: stream-flow 3s linear infinite;
}

@keyframes stream-flow {
    to { transform: translateY(100vh); opacity: 0; }
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
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}

#crystal-console.sticky-mode label,
#crystal-console.sticky-mode .md\:flex,
#crystal-console.sticky-mode .lg\:col-span-3 {
    display: none !important; /* Thu gọn khi dính */
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
                    <div class="lg:col-span-3">
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

                <div class="hidden md:flex flex-wrap gap-3 mt-8 pt-8 border-t border-white/5">
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
        document.addEventListener('DOMContentLoaded', () => {
    // 1. System Boot Animation
    const tl = gsap.timeline();
    
    tl.from("#crystal-console", {
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

    // 2. Sticky Morphing Logic
    ScrollTrigger.create({
        trigger: "#command-center",
        start: "bottom 20%",
        onEnter: () => {
            document.getElementById('crystal-console').classList.add('sticky-mode');
            gsap.from(".sticky-mode", { y: -50, opacity: 0, duration: 0.5 });
        },
        onLeaveBack: () => {
            document.getElementById('crystal-console').classList.remove('sticky-mode');
        }
    });

    // 3. Magnetic Input Background Effect
    const inputField = document.querySelector('input');
    inputField.addEventListener('input', () => {
        gsap.to(".grid-lines", {
            scale: 1.05,
            duration: 0.3,
            borderColor: "#007FFF",
            ease: "power2.out"
        });
    });

    // 4. Shake to Randomize (Mobile)
    if (typeof DeviceMotionEvent !== 'undefined') {
        window.addEventListener('devicemotion', (event) => {
            const acc = event.accelerationIncludingGravity;
            if (Math.abs(acc.x) > 15 || Math.abs(acc.y) > 15) {
                // Kích hoạt gợi ý ngẫu nhiên
                console.log("Shaking - Recommending VIP plates...");
            }
        });
    }
});

function toggleDevice(type) {
    const slider = document.getElementById('toggle-active');
    if (type === 'auto') {
        slider.style.transform = 'translateX(0)';
    } else {
        slider.style.transform = 'translateX(100%)';
    }
}

        // ----------------------------- section 2 ----------------------------- //

        // ----------------------------- section 3 ----------------------------- //

        // ----------------------------- section 4 ----------------------------- //

        // ----------------------------- section 5 ----------------------------- //
        
        // ----------------------------- section 6 ----------------------------- //
</script>
</html>

