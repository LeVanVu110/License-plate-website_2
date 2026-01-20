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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>