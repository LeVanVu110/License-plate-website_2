<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,wght@0,700;1,700&family=Inter:wght@300;400&display=swap');

        #oracle-chronicle {
            font-family: 'Inter', sans-serif;
        }

        #hero-headline {
            font-family: 'Bodoni Moda', serif;
            letter-spacing: -0.02em;
        }

        /* Pulse Glow for Button */
        @keyframes pulse-cyan {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 211, 238, 0.4);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(34, 211, 238, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(34, 211, 238, 0);
            }
        }

        #btn-read-now {
            animation: pulse-cyan 2s infinite;
        }

        /* Mobile Sticky Button */
        @media (max-width: 1024px) {
            #btn-read-now.sticky-mobile {
                position: fixed;
                bottom: 20px;
                left: 5%;
                width: 90%;
                z-index: 100;
                background: rgba(0, 11, 24, 0.8);
                backdrop-filter: blur(10px);
            }
        }

        /* Glow Tracer Effect */
        .tracer-active::after {
            content: "";
            position: absolute;
            height: 100%;
            width: 2px;
            background: #00ffff;
            box-shadow: 0 0 15px #00ffff;
            left: 0;
            top: 0;
            animation: trace 2s ease-in-out forwards;
        }

        @keyframes trace {
            100% {
                left: 100%;
                opacity: 0;
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
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="oracle-chronicle" class="relative min-h-screen bg-[#000B18] overflow-hidden flex items-center">

        <canvas id="star-map-canvas" class="absolute inset-0 z-0 opacity-60"></canvas>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

                <div class="lg:w-1/2 order-2 lg:order-1">
                    <div class="relative pl-8 border-l border-cyan-500/30 overflow-hidden" id="headline-container">
                        <h1 id="hero-headline" class="text-4xl md:text-7xl font-serif text-[#E0F7FA] leading-[1.1] mb-8 opacity-0 -translate-x-full">
                            GIẢI MÃ: BIỂN SỐ TỈ ĐÔ <br>
                            <span class="text-cyan-400">888.88</span> <br>
                            ĐỊNH DANH VẬN MỆNH THẾ NÀO?
                        </h1>

                        <p id="hero-lead" class="text-lg md:text-xl text-cyan-200/70 font-sans leading-relaxed mb-10 opacity-0">
                            Từ một dãy số vô hồn trở thành di sản tài chính triệu đô. Khám phá bí ẩn phong thủy và lực đẩy thị trường phía sau những con số quyền lực nhất Việt Nam.
                        </p>

                        <button id="btn-read-now" class="px-12 py-4 bg-white/5 backdrop-blur-md border border-cyan-500/50 rounded-lg text-cyan-400 font-bold tracking-[0.3rem] uppercase hover:bg-cyan-500 hover:text-black transition-all duration-500 shadow-[0_0_20px_rgba(34,211,238,0.2)]">
                            Đọc Ngay
                        </button>
                    </div>
                </div>

                <div class="lg:w-1/2 order-1 lg:order-2 relative" id="hero-image-wrapper">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                        <div id="sapphire-filter" class="absolute inset-0 bg-blue-900/40 backdrop-blur-sm z-10 transition-all duration-1000"></div>

                        <img id="hero-img" src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=2070&auto=format&fit=crop"
                            alt="Luxury Car & Plate"
                            class="w-full h-[300px] md:h-[600px] object-cover scale-110 opacity-0">

                        <div class="absolute -inset-2 bg-cyan-500/20 blur-2xl z-0 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-cyan-500/50 animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7m14-8l-7 7-7-7"></path>
            </svg>
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
        gsap.registerPlugin(ScrollTrigger);

        // 1. DYNAMIC STAR MAP CANVAS
        const canvas = document.getElementById('star-map-canvas');
        const ctx = canvas.getContext('2d');
        let stars = [];

        function initStars() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            stars = [];
            for (let i = 0; i < 200; i++) {
                stars.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    size: Math.random() * 2,
                    vx: (Math.random() - 0.5) * 0.3,
                    vy: (Math.random() - 0.5) * 0.3
                });
            }
        }

        function animateStars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = '#22d3ee';
            stars.forEach(s => {
                s.x += s.vx;
                s.y += s.vy;
                if (s.x < 0 || s.x > canvas.width) s.vx *= -1;
                if (s.y < 0 || s.y > canvas.height) s.vy *= -1;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
                ctx.fill();
            });
            requestAnimationFrame(animateStars);
        }
        initStars();
        animateStars();

        // 2. THE GRAND ENTRANCE TIMELINE
        const tl = gsap.timeline();

        tl.to("#hero-headline", {
                opacity: 1,
                x: 0,
                duration: 1.5,
                ease: "expo.out"
            })
            .to("#hero-img", {
                opacity: 1,
                scale: 1,
                duration: 2,
                ease: "power2.out"
            }, "-=1")
            .to("#sapphire-filter", {
                backdropFilter: "blur(0px)",
                backgroundColor: "rgba(30, 58, 138, 0.2)",
                duration: 1.5
            }, "-=1.5")
            .to("#hero-lead", {
                opacity: 1,
                y: 0,
                duration: 1
            }, "-=1");

        // 3. PARALLAX NARRATIVE
        gsap.to("#hero-img", {
            scrollTrigger: {
                trigger: "#oracle-chronicle",
                start: "top top",
                end: "bottom top",
                scrub: true
            },
            y: 100,
            scale: 1.1
        });

        gsap.to("#hero-headline", {
            scrollTrigger: {
                trigger: "#oracle-chronicle",
                start: "top top",
                end: "bottom top",
                scrub: true
            },
            y: -50
        });

        // 4. MOBILE STICKY CTA
        if (window.innerWidth < 1024) {
            ScrollTrigger.create({
                trigger: "#btn-read-now",
                start: "top center",
                onLeave: () => document.getElementById('btn-read-now').classList.add('sticky-mobile'),
                onEnterBack: () => document.getElementById('btn-read-now').classList.remove('sticky-mobile')
            });
        }

        // 5. INTERACTIVE HOVER
        const wrapper = document.getElementById('hero-image-wrapper');
        wrapper.addEventListener('mouseenter', () => {
            gsap.to("#sapphire-filter", {
                opacity: 0,
                duration: 0.5
            });
            gsap.to("#hero-img", {
                scale: 1.05,
                duration: 0.5
            });
        });
        wrapper.addEventListener('mouseleave', () => {
            gsap.to("#sapphire-filter", {
                opacity: 1,
                duration: 0.5
            });
            gsap.to("#hero-img", {
                scale: 1,
                duration: 0.5
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