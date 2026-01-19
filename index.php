<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biển Số Đẹp | The Grand Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <style>
        :root {
            --electric-blue: #007FFF;
            --navy-deep: #000D1A;
        }

        body {
            background-color: var(--navy-deep);
            overflow-x: hidden;
            cursor: auto;
            /* Sử dụng custom cursor */
        }

        /* ----------------------------- section 1 -----------------------------  */
        .serif-title {
            font-family: 'Cormorant Garamond', serif;
        }

        .sans-text {
            font-family: 'Inter', sans-serif;
        }

        #custom-cursor {
            width: 100px;
            height: 100px;
            border: 1px solid var(--electric-blue);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            /* Không chặn click */
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--electric-blue);
            mix-blend-mode: difference;
            transition: opacity 0.3s ease;
        }

        /* Hero Video Overlay */
        .video-overlay {
            background: linear-gradient(to bottom, rgba(0, 13, 26, 0.7) 0%, rgba(0, 13, 26, 0.4) 50%, rgba(0, 13, 26, 0.9) 100%);
            z-index: 1;
        }

        #search-wrapper {
            position: relative;
            z-index: 50 !important;
        }

        /* The Crystal Search Bar */
        .crystal-search {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            pointer-events: auto !important;
            /* Cho phép tương tác */
            cursor: default;
        }

        /* Khi di chuột vào ô input, hiện trỏ chuột nhập liệu */
        .crystal-search input {
            cursor: text !important;
        }

        .crystal-search button {
            cursor: pointer !important;
        }

        /* Optical Glint Effect */
        .glint {
            position: absolute;
            top: -100%;
            left: -100%;
            width: 50%;
            height: 300%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: rotate(45deg);
            pointer-events: none;
        }

        #headline,
        #sub-headline,
        #search-wrapper {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }

        /* Loại bỏ viền mặc định khi click vào input */
        input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Hiệu ứng khi hover vào nút bấm */
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 127, 255, 0.4);
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            #custom-cursor {
                display: none;
            }

            .crystal-search {
                backdrop-filter: blur(10px);
            }

            body {
                cursor: auto;
            }

            /* #search-input{
                width: 131px !important;
            } */
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
    <section id="hero-stage" class="relative w-full h-screen flex flex-col items-center justify-center overflow-hidden">
        <div id="video-wrap" class="absolute inset-0 z-0">
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-luxury-car-parked-in-a-dark-place-34460-large.mp4" type="video/mp4">
            </video>
            <div class="video-overlay absolute inset-0"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 id="headline" class="serif-title text-5xl md:text-8xl text-white mb-6 opacity-0 tracking-tight leading-tight">
                ĐỊNH DANH VỊ THẾ<br>
                <span class="italic text-[#C0C0C0]">KHẮC GHI DI SẢN</span>
            </h1>

            <p id="sub-headline" class="sans-text text-sm md:text-xl text-gray-300 mb-12 opacity-0 tracking-[0.2em] uppercase">
                Hệ thống quản trị và giao dịch biển số định danh thượng lưu số 1 Việt Nam
            </p>

            <div id="search-wrapper" class="flex justify-center opacity-0 translate-y-10">
                <div class="crystal-search group w-full max-w-4xl rounded-full p-2 flex flex-col md:flex-row items-center gap-2">
                    <div class="glint" id="glint"></div>
                    <div class="flex-1 flex items-center px-6 border-r border-white/10 w-full relative z-20">
                        <i class="ri-search-2-line text-white/50 mr-3"></i>
                        <input type="text" placeholder="TÌM KIẾM DÃY SỐ PHONG THỦY..."
                            class="bg-transparent border-none focus:ring-0 text-white placeholder-white/30 w-full py-4 text-sm tracking-widest uppercase cursor-text">
                    </div>
                    <button class="relative z-20 bg-[#007FFF] text-white px-10 py-4 rounded-full font-bold sans-text text-sm hover:bg-white hover:text-[#007FFF] transition-all duration-500 shadow-lg shadow-blue-500/20">
                        KHÁM PHÁ NGAY
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
    gsap.registerPlugin(ScrollTrigger);
    // 2. Initial Animation & Scroll
    window.addEventListener('load', () => {
        const mainTl = gsap.timeline();
        mainTl.to("#headline", {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: "power4.out"
            })
            .to("#sub-headline", {
                opacity: 1,
                y: 0,
                duration: 0.8
            }, "-=0.8")
            .to("#search-wrapper", {
                opacity: 1,
                y: 0,
                duration: 0.8
            }, "-=0.5");

        // Fixed Scroll disappearance
        gsap.to("#headline, #sub-headline", {
            scrollTrigger: {
                trigger: "#hero-stage",
                start: "top top",
                end: "30% top",
                scrub: 1,
                toggleActions: "play reverse play reverse"
            },
            y: -50,
            opacity: 0,
            immediateRender: false
        });

        gsap.to("#video-wrap video", {
            scrollTrigger: {
                trigger: "#hero-stage",
                start: "top top",
                end: "bottom top",
                scrub: 1
            },
            filter: "blur(15px) brightness(0.4)",
            scale: 1.1,
            force3D: true
        });
    });

    // 3. Magnetic Search FIXED
    const searchWrapper = document.getElementById('search-wrapper');
    const searchBox = document.querySelector('.crystal-search');

    // Chỉ chạy hiệu ứng hút khi chuột KHÔNG đè trực tiếp lên ô input
    document.addEventListener('mousemove', (e) => {
        const rect = searchWrapper.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const dist = Math.hypot(e.clientX - centerX, e.clientY - centerY);

        // Kiểm tra nếu chuột nằm trong vùng ô search
        const isInside = e.clientX >= rect.left && e.clientX <= rect.right &&
            e.clientY >= rect.top && e.clientY <= rect.bottom;

        if (dist < 400 && !isInside) {
            gsap.to(searchBox, {
                x: (e.clientX - centerX) * 0.12,
                y: (e.clientY - centerY) * 0.12,
                duration: 0.5,
                ease: "power2.out"
            });
        } else {
            gsap.to(searchBox, {
                x: 0,
                y: 0,
                duration: 0.4,
                ease: "power3.out"
            });
        }
    });

    // 4. Glint Effect
    gsap.to("#glint", {
        left: "150%",
        duration: 2.5,
        repeat: -1,
        repeatDelay: 5,
        ease: "power2.inOut"
    });

    // ----------------------------- section 2 ----------------------------- //


    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>