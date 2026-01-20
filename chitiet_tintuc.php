<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Space+Mono&display=swap');

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Hiệu ứng hào quang cho chữ */
        .text-glow {
            text-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        /* Flickering Effect */
        .flicker {
            animation: textFlicker 3s infinite;
        }

        @keyframes textFlicker {

            0%,
            18%,
            22%,
            25%,
            53%,
            57%,
            100% {
                opacity: 1;
                text-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            }

            20%,
            24%,
            55% {
                opacity: 0.7;
                text-shadow: none;
            }
        }

        /* Responsive Sticky Meta */
        .meta-sticky {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            max-width: none !important;
            background: rgba(0, 15, 26, 0.95) !important;
            border-radius: 0 !important;
            border-bottom: 1px solid rgba(0, 255, 255, 0.3);
            z-index: 90;
            padding: 10px 24px !important;
            transform: translateY(-100%);
            transition: transform 0.5s ease;
        }

        .meta-sticky.active {
            transform: translateY(0);
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Tối ưu typography cho trải nghiệm đọc */
        #fluid-narrative p {
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.01em;
            line-height: 1.8;
        }

        /* Hiệu ứng Glow cho từ khóa quan trọng */
        .keyword-glow {
            font-weight: 600;
            transition: all 0.5s ease;
            color: #fff;
        }

        .keyword-glow.active {
            color: #00FFFF;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.8);
        }

        /* Glassmorphism cho Pull Quote */
        blockquote {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        /* Magnifier Thấu kính */
        .magnifier-lens {
            background-repeat: no-repeat;
            display: none;
            /* Hiện qua JS */
        }

        @media (max-width: 1024px) {
            #fluid-narrative {
                padding-top: 50px;
            }

            #fluid-narrative article {
                max-width: 100%;
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
    <section id="insight-horizon" class="relative min-h-[90vh] bg-[#000F1A] overflow-hidden">

        <div class="hero-image-container absolute inset-0 z-0">
            <div class="hero-overlay absolute inset-0 bg-gradient-to-t from-[#000F1A] via-transparent to-black/30 z-10"></div>
            <img src="https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&q=80&w=2000"
                id="hero-img"
                class="w-full h-full object-cover opacity-0"
                alt="Featured News Image">
        </div>

        <div class="relative z-20 container mx-auto px-6 h-screen flex flex-col justify-end pb-24 lg:pb-32">

            <div class="max-w-5xl">
                <h1 id="news-headline" class="text-4xl md:text-6xl lg:text-8xl font-serif text-[#E0F2F7] leading-tight tracking-tighter opacity-0">
                    TƯƠNG LAI CỦA <br>
                    <span class="text-glow">DI SẢN SỐ</span> TRÊN BLOCKCHAIN
                </h1>
            </div>

            <div id="meta-info-bar" class="mt-8 flex items-center gap-6 p-4 rounded-r-full bg-blue-900/20 backdrop-blur-md border-l-4 border-[#00FFFF] max-w-fit opacity-0 translate-x-[-50px]">
                <div class="flex items-center gap-2">
                    <i class="ri-user-3-line text-[#00FFFF]"></i>
                    <span class="font-mono text-[10px] md:text-xs text-[#E0F2F7] uppercase tracking-widest">By Sapphire Admin</span>
                </div>
                <div class="w-[1px] h-4 bg-white/20"></div>
                <div class="flex items-center gap-2">
                    <i class="ri-calendar-event-line text-[#00FFFF]"></i>
                    <span class="font-mono text-[10px] md:text-xs text-[#E0F2F7] uppercase tracking-widest">24 Oct 2024</span>
                </div>
                <div class="w-[1px] h-4 bg-white/20"></div>
                <div class="flex items-center gap-2">
                    <i class="ri-time-line text-[#00FFFF]"></i>
                    <span class="font-mono text-[10px] md:text-xs text-[#00FFFF] uppercase tracking-widest">5 Phút đọc</span>
                </div>
            </div>
        </div>

        <div id="reading-progress" class="fixed top-0 left-0 w-0 h-1 bg-[#00FFFF] z-[100] shadow-[0_0_10px_#00FFFF]"></div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="fluid-narrative" class="relative bg-gradient-to-b from-[#000F1A] to-[#00040A] py-20 lg:py-32 overflow-visible">

        <aside class="hidden lg:flex fixed left-10 top-1/2 -translate-y-1/2 flex-col gap-8 z-30 opacity-0" id="floating-sidebar">
            <div class="flex flex-col items-center gap-2 group cursor-pointer">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center bg-white/5 backdrop-blur-md group-hover:border-[#00FFFF] transition-all">
                    <i class="ri-share-forward-line text-[#E0F2F7]"></i>
                </div>
                <span class="text-[8px] font-mono text-gray-500 uppercase tracking-widest">Share</span>
            </div>
            <div class="flex flex-col items-center gap-2 group cursor-pointer">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center bg-white/5 backdrop-blur-md group-hover:border-[#00FFFF] transition-all">
                    <i class="ri-fire-line text-orange-500"></i>
                </div>
                <span class="text-[8px] font-mono text-gray-500 uppercase tracking-widest">1.2k Views</span>
            </div>
            <a href="journal.php" class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center bg-white/5 backdrop-blur-md group-hover:bg-[#00FFFF]/10 transition-all">
                    <i class="ri-arrow-left-line text-[#E0F2F7]"></i>
                </div>
                <span class="text-[8px] font-mono text-gray-500 uppercase tracking-widest">Back</span>
            </a>
        </aside>

        <div class="container mx-auto px-6 relative">
            <div class="hidden lg:block absolute left-[-20px] top-0 w-[1px] h-full bg-white/5">
                <div id="vertical-progress" class="w-full bg-[#00FFFF] shadow-[0_0_10px_#00FFFF] origin-top"></div>
            </div>

            <article class="max-w-[750px] mx-auto space-y-12">

                <div class="reveal-text">
                    <p class="text-[#D1E8F2] text-lg lg:text-xl leading-relaxed font-light">
                        Trong kỷ nguyên số, một chiếc biển số không đơn thuần là những con số vô hồn. Nó là sự giao thoa giữa <span class="keyword-glow">di sản vật lý</span> và giá trị mã hóa. Sapphire tự hào mang đến quy trình định danh độc bản, nơi mỗi tấm biển được xử lý như một tác phẩm nghệ thuật kỹ thuật số.
                    </p>
                </div>

                <h2 class="reveal-text text-2xl lg:text-3xl font-serif text-[#00FFFF] uppercase tracking-widest pt-8">
                    Quy trình tinh xảo & Bảo mật Sapphire
                </h2>

                <div class="reveal-text relative group overflow-hidden rounded-2xl border border-white/10">
                    <div class="magnifier-lens absolute w-32 h-32 border-2 border-[#00FFFF] rounded-full pointer-events-none opacity-0 z-20 shadow-[0_0_20px_rgba(0,255,255,0.5)] bg-white/10 backdrop-blur-sm"></div>
                    <img src="https://images.unsplash.com/photo-1512446816042-444d641267d4?auto=format&fit=crop&q=80&w=1200"
                        class="w-full h-auto transition-transform duration-700 zoom-target" alt="Detail Plate">
                    <div class="absolute bottom-4 right-4 text-[10px] font-mono text-white/50 bg-black/40 px-3 py-1 rounded-full">
                        Zoom: Surface Detail v1.0
                    </div>
                </div>

                <blockquote class="reveal-text relative p-8 lg:p-12 bg-white/5 backdrop-blur-xl border-l-4 border-[#00FFFF] rounded-r-2xl my-16">
                    <p class="text-2xl lg:text-4xl font-serif italic text-white leading-tight">
                        "Chúng tôi không đấu giá con số, chúng tôi đấu giá sự trường tồn của một vị thế xã hội."
                    </p>
                    <cite class="block mt-6 font-mono text-[#00FFFF] text-sm tracking-widest">— Sapphire CEO</cite>
                </blockquote>


                <div class="reveal-text">
                    <p class="text-[#D1E8F2] text-lg lg:text-xl leading-relaxed font-light">
                        Mỗi bước đi trong "Dòng chảy tri thức" này đều được minh chứng bằng các con số. Tính đến quý 3 năm 2024, tổng giá trị các biển số <span class="keyword-glow">Ngũ Quý</span> đã tăng trưởng 240% so với cùng kỳ năm trước. Điều này khẳng định sức hút không thể chối từ của thị trường sưu tầm hạng sang.
                    </p>
                </div>
        </div>

        </article>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    window.addEventListener('load', () => {
        gsap.registerPlugin(ScrollTrigger);

        // 1. Hiệu ứng "The Galactic Unfold" (Lúc trang vừa tải)
        const tl = gsap.timeline();

        tl.to("#hero-img", {
                opacity: 1,
                scale: 1,
                filter: "blur(0px)",
                duration: 2,
                ease: "power2.out",
                startAt: {
                    scale: 1.1,
                    filter: "blur(20px)"
                }
            })
            .to("#news-headline", {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: "expo.out",
                startAt: {
                    y: 100
                }
            }, "-=1")
            .to("#meta-info-bar", {
                opacity: 1,
                x: 0,
                duration: 0.8,
                ease: "back.out(1.7)"
            }, "-=0.5");

        // Hiệu ứng Focus Flicker ngẫu nhiên cho tiêu đề
        const headline = document.getElementById('news-headline');
        setInterval(() => {
            headline.classList.add('flicker');
            setTimeout(() => headline.classList.remove('flicker'), 2000);
        }, 5000);

        // 2. Hiệu ứng "Deep Scroll Parallax"
        gsap.to("#hero-img", {
            yPercent: 30,
            ease: "none",
            scrollTrigger: {
                trigger: "#insight-horizon",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });

        gsap.to("#news-headline", {
            scale: 0.8,
            opacity: 0,
            y: -50,
            scrollTrigger: {
                trigger: "#insight-horizon",
                start: "top top",
                end: "bottom 30%",
                scrub: true
            }
        });

        // 3. Thanh tiến trình đọc và Sticky Meta
        ScrollTrigger.create({
            trigger: "body",
            start: "top top",
            end: "bottom bottom",
            onUpdate: (self) => {
                // Cập nhật Reading Progress
                gsap.to("#reading-progress", {
                    width: (self.progress * 100) + "%",
                    duration: 0.1
                });

                // Sticky Meta Bar khi cuộn qua Section 1
                const metaBar = document.getElementById('meta-info-bar');
                if (self.scroll() > window.innerHeight * 0.7) {
                    metaBar.classList.add('meta-sticky', 'active');
                } else {
                    metaBar.classList.remove('active');
                    setTimeout(() => {
                        if (!metaBar.classList.contains('active')) metaBar.classList.remove('meta-sticky');
                    }, 500);
                }
            }
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    window.addEventListener('load', () => {
        gsap.registerPlugin(ScrollTrigger);

        // 1. Hiệu ứng "Smart Scroll Reveal" cho các đoạn văn
        const reveals = document.querySelectorAll('.reveal-text');
        reveals.forEach((el) => {
            gsap.from(el, {
                y: 50,
                opacity: 0,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });
        });

        // 2. Hiệu ứng "The Reading Pulse" (Thanh tiến trình dọc)
        gsap.to("#vertical-progress", {
            height: "100%",
            ease: "none",
            scrollTrigger: {
                trigger: "#fluid-narrative",
                start: "top center",
                end: "bottom center",
                scrub: true
            }
        });

        // 3. Hiệu ứng "Text Highlight" (Glow on Scroll)
        const keywords = document.querySelectorAll('.keyword-glow');
        keywords.forEach((word) => {
            ScrollTrigger.create({
                trigger: word,
                start: "top center",
                end: "bottom center",
                onEnter: () => word.classList.add('active'),
                onLeaveBack: () => word.classList.remove('active')
            });
        });

        // 4. Hiệu ứng "The Magnifier" (Soi chi tiết)
        const container = document.querySelector('.zoom-target').parentElement;
        const lens = document.querySelector('.magnifier-lens');
        const img = document.querySelector('.zoom-target');

        container.addEventListener('mousemove', (e) => {
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            lens.style.display = "block";
            lens.style.opacity = "1";
            lens.style.left = `${x - 64}px`;
            lens.style.top = `${y - 64}px`;

            // Tính toán vị trí zoom
            const zoomScale = 2;
            img.style.transformOrigin = `${(x / rect.width) * 100}% ${(y / rect.height) * 100}%`;
            img.style.transform = `scale(${zoomScale})`;
        });

        container.addEventListener('mouseleave', () => {
            lens.style.opacity = "0";
            img.style.transform = `scale(1)`;
            setTimeout(() => lens.style.display = "none", 300);
        });

        // Hiện Sidebar khi cuộn xuống
        gsap.to("#floating-sidebar", {
            opacity: 1,
            duration: 1,
            scrollTrigger: {
                trigger: "#fluid-narrative",
                start: "top center",
                toggleActions: "play none none reverse"
            }
        });
    });

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>